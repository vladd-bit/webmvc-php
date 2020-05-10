# WebWay-PHP

WebWay php MVC framework, mainly mimicking the .NET asp & mvc framework .

## Getting Started

### Prerequisites (PHP only)
```
    PHP version >= 7.4 (This is mainly if you want support for all the new and neat, mainly required for using typed propertyes and/or type hinting for view objects).
    Composer 
        Deployment:
           -ducks-project/spl-types
           -ext-pdo
           -ext-json
        Development
           -phpunit
```

#### Other prerequisites

This project uses nodeJS for compiling scss files to css. 
As well as AngularJS and a few other libraries for the material design web theme.
Please see the dependencies in the package.json file.

To enable the nodeJS webpack file watcher run the following command: webpack --config webpack.config.development.js 

These packages are entirely optional, they are only included as the base project setup/start files.

### Configuration

Project configurations such as log locations, server time and zone are located in the /application/config/WebConfig.php file.
Database connection details can be found and configured in /application/config/DatabaseConfig.php.

### Project structure
```
  ├───application
  │   ├───config 
  │   ├───controllers <-- controller logic for your pages
  │   ├───core <-- code should not be touched unless submitting a bug report :)
  │   ├───models <-- all viewmodels/models and their business logic are stored here
  │   │   ├───dbobj <-- the exact representation of the db objects (optional to have them coded this way of course)
  │   │   └───viewmodels <-- used for view data representation only (h
  │   ├───utils <-- utility classes
  │   └───views <-- controllers should have their views stored in their respective folder
  │       ├───account 
  │       ├───home 
  │       └───shared <-- used as the base for any view (shared across views) 
  └───public 
      ├───dist 
      ├───js
      ├───media
      │   ├───fonts
      │   ├───images
      │   └───stylesheets
      └───ts
```

## What this project doesn't provide

This project has been made mostly for fun and for personal projects, and so it may have some issues:
- it cannot provide the assurance that this project is secure enough to be used in an enterprise environment. 
- an ORM framework, this means that you'll have to code your own models and logic, unless you want to use Doctrine or Eloquent.
- it may lack fancy view input/output handling, this means you are still using  htmlspecialchars functions etc. 


## Basic Example
This section describes some quick and basic examples of how to use the framework to its full effect.

#### Models

Multiple ways of creating models, db logic can be separated from the initial representation of object (optional).

For example, the UserAccount object is the identical representation of the table stored in the database:

Located in 
``` 
application/models/dbobj/UserAccount.php
```

```
class UserAccount
{
    private $id;
    private $username;
    private $passwordHash;
    private $sessionKey;
    private $email;
    ...

    public function __construct($properties = array())
    {
        foreach($properties as $key => $value)
        {
            if(property_exists($this, $key))
            {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    ...... other getter and setter methods...

}

```
The __constructor() is only coded in a way that lets us set the properties of the model automatically when passing
the rows from the database. Again, this is optional and you may want to ignore or reimplement this.

The actual Model containing the db logic can be coded as:

```
class UserAccountModel extends Model
{
    public static function getUserByName($username)
    {
        $db = static::getDB();

        $sql = 'select * from "getUserAccountByName"(:username)';
        $query = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $query->execute(array(':username' => $username));

        return $query->fetch(PDO::FETCH_ASSOC);
    }
    ...
}
```

Located in:
```
application/models/UserAccountModel.php
```

#### ViewModels

A quick example of a ViewModel:

```
class UserAccountViewModel extends ViewModel
{
    public $username;
    public $password;
    public $confirmPassword;
    public $email;

    public function __construct()
    {
        $this->setValidationFieldProperties(array(
            'username' => 'required|maxLength:20|minLength:4',
            'password' => 'required|maxLength:30|minLength:4|numerals:2|lowerCharacters:4|equalTo:confirmPassword',
            'confirmPassword' => 'required|maxLength:30|minLength:4|numerals:2|lowerCharacters:4|equalTo:password',
            'email' => 'required|dataType:email'));

        $this->setValidationFieldMessages(array('password' => ['error' => 'passwords do not match'],
                                                'confirmPassword' => ['error' => 'passwords do not match'],
                                                'email' => ['error' => 'invalid email format',
                                                'maxLength' => ['success' => 'maxLengthSuccess',  'error' => 'MAX length custom error message']]
                                          ));
    }
}
```

Every ViewModel must inherit the ViewModel class if you wish to have access to model validation methods and parameters.

The setValidationFieldProperties() method is used to set the validation conditions for each field, as shown above.

The framework provides automatically generated success and error messages for these conditions, however,
 you can also manually add your own custom message as displayed above by using the setValidationFieldMessages() method.
  
Each field has an 'error' and 'success' message state that can be configured.

The properties for which you can set conditions are as follows :
['maxLength','minLength','required', 'numerals',
'lowerCharacters','upperCharacters','dataType', 'dateFormat',
'dateAfter', 'dateBefore','equalTo', 'greaterThan', 'lowerThan', 'greaterThanEqual',
'lowerThanEqual']

 Values taken by each condition/property:
 - required : 1 or 0
 - maxLength : number of maximum characters
 - minLength : number of minimum characters 
 - numerals : number of numeric characters
 - dataType : email, dateTime, phoneNumber 
 - dateFormat : date format such as '!Y-m-d'
 - dateAfter/dateBefore : the exact date, it must respect the format configured by the server 
                         or the dateFormat property specified (if any), 
                         by default it will always validate the date format against the server time format from WebConfig.
 - lowerThanEqual/lowerThan/greaterThanEqual/greaterThan/equalTo: field must be equal to value, this value can be anything,
            and can even be another the value of another field, such as equalTo:password
                         
##### Validating a ViewModel

To generate the validation messages the isValid() method must be called after submitting data through an action.
For example the 'create()' action in the Account controller:

```
class AccountController extends Controller
{
  ........
  public function create()
    {
        $viewData = Request::getData($this->getRequestParameters());

        $userAccountViewModel = new UserAccountViewModel();
        $userAccountViewModel->setFieldData($viewData);

        if($userAccountViewModel->isValid())
        {
            ......

            $createAccount = UserAccountModel::create($userAccount);

            if($createAccount == ErrorDatabaseQueryType::SuccessfulExecution)
            {
                Router::redirect('/home/index');
            }
            else if($createAccount == ErrorDatabaseQueryType::DuplicateEntry)
            {
                $view = new View();
                $view->set('userAccountViewModel', $userAccountViewModel);
                $view->set('accountExistsError', ErrorDatabaseQueryType::DuplicateEntry);
                $view->render('account/register.php');
            }
        }
        else
        {
            $view = new View();
            $view->set('userAccountViewModel', $userAccountViewModel);
            $view->render('account/register.php');
        }
    }
  .......
}
```

We get the request parameters using the Request::getData() method, which automatically checks POST/GET requests for
data according to the parameters set in the RouteNavigation for the current route action. 

#### Controllers

Creating a controller is quite easy, a basic Home and Account controller is provided by default, and can be found in:
```
application/controllers/ControllerName.php
```

Some example controllers: 

The Account controller has a basic register method served as a GET request when we first enter the account/register page.

This page uses the ViewModel concept to store its data.
    
```
class AccountController extends Controller
{
    public function register()
    {
        $view = new View();

        $userAccountViewModel = new UserAccountViewModel();

        $view->set('userAccountViewModel', $userAccountViewModel);
        $view->render('/account/register.php');
    }
    ...
}

class HomeController extends Controller
{
    public function index()
    {
        if(Authentication::isAuthorized())
        {
            Router::redirect('/home/dashboard');
        }

        $view = new View();

        $userAccountLoginViewModel  = new UserAccountLoginViewModel();

        $view->set('userAccountLoginViewModel', $userAccountLoginViewModel);
        $view->render('/home/index.php');
    }

    public function login()
    {
        if (Authentication::isAuthorized())
        {
            Router::redirect('/home/dashboard');
        }

        $viewData = Request::getData($this->getRequestParameters());
        ...
     }
}
```


####Routing
Routes are declared as their respective /controller/action paths, found in:

```
application\utils\RouteNavigation.php
```

When creating a route the only thing we need to worry about is how the web path would look like and what parameters it should accept.
The Router instance is shared across the program so we only need to declare these once in the initializeRoutes() function:

```
public static function initializeRoutes(Router $router)
{
    self::$routerInstance = $router;
    self::$routerInstance->add('/home/index', ['controller' => 'Home', 'action' => 'index']);
    self::$routerInstance->add('/home/logout', ['controller' => 'Home', 'action' => 'logout']);
    self::$routerInstance->add('/home/login', ['controller' => 'Home', 'action' => 'login', 'parameters' => UserAccountLoginViewModel::getModelFields() ]);
    ...
```

Parameters can be added to the route manually:
```
self::$routerInstance->add('/home/login', ['controller' => 'Home', 'action' => 'login', 'parameters' => ['username', 'password', 'confirmPassword', ....]);
```
Or by using the getModelFields() method which is available for classes that inherit the ViewModel class
, note that the fields for these classes should be public, otherwise they won't be automatically generated by the method.
```
self::$routerInstance->add('/home/login', ['controller' => 'Home', 'action' => 'login', 'parameters' => UserAccountLoginViewModel::getModelFields()]);
```
