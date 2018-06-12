<?php

namespace Application\Models;

class StorageRepository
{
    private $id;
    private $accountId;
    private $storageTypeId;
    private $storageName;
    private $storageSize;
    private $storagePath;
    private $bucket;
    private $dateCreated;
    private $dateUpdated;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @param mixed $accountId
     */
    public function setAccountId($accountId): void
    {
        $this->accountId = $accountId;
    }

    /**
     * @return mixed
     */
    public function getStorageTypeId()
    {
        return $this->storageTypeId;
    }

    /**
     * @param mixed $storageTypeId
     */
    public function setStorageTypeId($storageTypeId): void
    {
        $this->storageTypeId = $storageTypeId;
    }

    /**
     * @return mixed
     */
    public function getStorageName()
    {
        return $this->storageName;
    }

    /**
     * @param mixed $storageName
     */
    public function setStorageName($storageName): void
    {
        $this->storageName = $storageName;
    }

    /**
     * @return mixed
     */
    public function getStorageSize()
    {
        return $this->storageSize;
    }

    /**
     * @param mixed $storageSize
     */
    public function setStorageSize($storageSize): void
    {
        $this->storageSize = $storageSize;
    }

    /**
     * @return mixed
     */
    public function getStoragePath()
    {
        return $this->storagePath;
    }

    /**
     * @param mixed $storagePath
     */
    public function setStoragePath($storagePath): void
    {
        $this->storagePath = $storagePath;
    }

    /**
     * @return mixed
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * @param mixed $bucket
     */
    public function setBucket($bucket): void
    {
        $this->bucket = $bucket;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param mixed $dateCreated
     */
    public function setDateCreated($dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return mixed
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @param mixed $dateUpdated
     */
    public function setDateUpdated($dateUpdated): void
    {
        $this->dateUpdated = $dateUpdated;
    }
}