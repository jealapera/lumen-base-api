<?php 

namespace App\Common\Documents;

use App\Common\Documents\Exports\ExcelDataExport;
use \PhpOffice\PhpSpreadsheet\Reader\Csv;

class CSVDocument implements Document 
{
    /**
     * Downloads the CSV document
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

    /**
     * Loads the CSV document and then parses it
     *
     * @param $filePath
     * @return array|null
     */
    public function load($filePath)
    {
        $reader = new Csv();
        $reader->setDelimiter(",");

        $spreadsheet = $reader->load($filePath);

        $csvData = $spreadsheet->getActiveSheet()->toArray();

        $result = null;

        if($csvData && is_array($csvData))
        {
            $result = array();
            
            // Get the header
            $header = $csvData[0];

            // Loop starting on the first index since record start in the index 1
            for($i = 1; $i < count($csvData); $i++)
            {
                $data = array();
                for($j = 0; $j < count($header); $j++)
                {
                    $key = strtolower(str_replace(" ", "_", $header[$j]));

                    $data[$key] = $csvData[$i][$j];
                }
                
                $result[] = $data;
            }
        }

        return $result;
    }
}