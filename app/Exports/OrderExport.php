<?php

namespace App\Exports;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Yajra\DataTables\Exports\DataTablesCollectionExport;

class OrderExport extends DataTablesCollectionExport implements WithMapping
{

    public function headings(): array
    {
        return [
            'Invoice No',
        ];
    }

    public function map($row): array
    {
        return [
            $row['invoice_no'],
        ];

    }



}
