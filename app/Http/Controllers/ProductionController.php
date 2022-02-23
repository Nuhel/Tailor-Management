<?php

namespace App\Http\Controllers;

use App\DataTables\Productions\PendingDataTable;
use App\DataTables\Productions\ProcessingDataTable;

class ProductionController extends Controller
{

    public function index(PendingDataTable $pendingDataTable, ProcessingDataTable $processingDataTable)
    {

        //dd($pendingDataTable->getFilters());
        return view('productions.index', [
            'pendingDataTable' => $pendingDataTable,
            'processingDataTable' => $processingDataTable,
        ]);
    }

    public function pendingDataTable(PendingDataTable $pendingDataTable){
        return $pendingDataTable->render('components.datatable.index',['heading'=>'Masters']);
    }

    public function processingDataTable(ProcessingDataTable $processingDataTable){
        return $processingDataTable->render('components.datatable.index',['heading'=>'Masters']);
    }

    public function delivardDataTable(){

    }
}
