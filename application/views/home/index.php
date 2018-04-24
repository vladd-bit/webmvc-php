<?php
    $layout = 'layout.php';
    $title = 'someRandomTitle';

    for($i =0; $i< 400; $i++)
    {
        echo '<p>'. $i .'</p>';
    }


    echo '$test';
?>

<main>
  <div class="main-content">
    <div class="server-status"> </div>
    <div class="content">
      <button class="button-default button-indigo" id="some_test_button" onclick=""> Inject / test JS</button>
      <button class="button-default button-indigo" id="show_cookie" onclick=""> GET COOKIE </button>
        <form action="/home/submit" method="post">
            <p>Your name: <label>Name:</label><input type="text" name="name"/></p>
            <p>Your age: <label>Age:</label><input type="text" name="age" value="" /></p>
            <input type="submit" name="test_input" />
        </form>
    </div>
  </div>
</main>