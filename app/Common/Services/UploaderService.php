<?php namespace App\Common\Services;

use File;

/**
 * Class for Uploading Files
 * Class UploaderService
 */
class UploaderService
{
    /**
     * Uploaded File
     * @var file
     */
    protected $file;

    /**
     * File Path
     * @var string
     */
    protected $path;

    /**
     * Constructor
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Uploads the file with a specific name and storage
     *
     * @param $storage, $filename
     * @return path
     */
    public function upload($storage, $filename)
    {
    	return $this->file->storeAs($storage, $filename);
    }

    /**
     * Deletes a specific file by its path
     *
     * @param $path
     * @return boolean
     */
    public function delete($path)
    {
    	$delete = File::delete($path);

    	$isDeleted = ($delete) ? true : false;
    	return $isDeleted;
    }
}