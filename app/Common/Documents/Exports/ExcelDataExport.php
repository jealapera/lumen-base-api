<?php namespace App\Common\Documents\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelDataExport implements WithMapping, WithHeadings, FromCollection
{
    use Exportable;

    /**
     * @var
     */
    public $data;

    /**
     * @var
     */
    public $mapping;

    /**
     * Constructor
     */
    public function __construct($data, $mapping)
    {
        $this->data = $data;

        $this->mapping = $mapping;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function map($data): array
    {
        $mapping = array();

        foreach($this->mapping as $header => $field)
        {
            $mapping[] = $data[$field];
        }

        return $mapping;
    }

    public function headings(): array
    {
        $mapping = array();

        foreach($this->mapping as $header => $field)
        {
            $mapping[] = $header;
        }

        return $mapping;
    }
}