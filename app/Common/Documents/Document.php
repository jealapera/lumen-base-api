<?php 

namespace App\Common\Documents;

interface Document 
{
    /**
     * Loads the document
     * @return
     */
    public function load($filePath);

    /**
     * Downloads the document
     *
     * @param $filename
     * @param $data
     * @param $mapping
     * @return Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($filename,
                             $data,
                             $mapping);
}