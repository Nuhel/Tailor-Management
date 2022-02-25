<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\OrderService;
use App\Http\Requests\SendToProductionRequest;
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
            'craftMans' => Employee::all(),
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

    public function sentToProduction(SendToProductionRequest $request, OrderService $orderService){
        $orderService->employee_id = $request->employee_id;
        if($request->employee_id == null)
            $orderService->status = 'pending';
        else
            $orderService->status = 'processing';

        $orderService->update();
        return response()->json(['success',"Sent To Production"], 200);
    }
}
