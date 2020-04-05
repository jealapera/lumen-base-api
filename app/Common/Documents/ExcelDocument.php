<?php 

namespace App\Common\Documents;

use App\Common\Documents\Exports\ExcelDataExport;

class ExcelDocument implements Document 
{
    public function load($filePath)
    {
        //
    }

    /**
     * Downloads the excel document
     *
     * @param $filename
     * @param $data
     * @param $mapping
     * @return Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($filename,
                             $data,
                             $mapping)
    {
        return (new ExcelDataExport($data, $mapping))->download($filename);
    }
}