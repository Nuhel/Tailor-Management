<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Constant\ServiceStatus;
use App\Models\OrderService;
use Illuminate\Http\Request;
use App\DataTables\Productions\ReadyDataTable;
use App\Http\Requests\SendToProductionRequest;
use App\DataTables\Productions\PendingDataTable;
use App\DataTables\Productions\ProcessingDataTable;

class ProductionController extends Controller
{

    public function index(PendingDataTable $pendingDataTable, ProcessingDataTable $processingDataTable, ReadyDataTable $readyDataTable)
    {

        //dd($pendingDataTable->getFilters());
        return view('productions.index', [
            'pendingDataTable' => $pendingDataTable,
            'processingDataTable' => $processingDataTable,
            'readyDataTable' => $readyDataTable  ,
            'craftMans' => Employee::all(),
        ]);
    }

    public function pendingDataTable(PendingDataTable $pendingDataTable){
        return $pendingDataTable->render('productions.datatables.pending',['heading'=>'Pendign']);
    }

    public function processingDataTable(ProcessingDataTable $processingDataTable){
        return $processingDataTable->render('productions.datatables.processing',['heading'=>'Processing']);
    }

    public function readyDataTable(ReadyDataTable $readyDataTable){
        return $readyDataTable->render('components.datatable.index',['heading'=>'Ready']);;
    }

    public function sentToProduction(SendToProductionRequest $request, OrderService $orderService){
        $orderService->employee_id = $request->employee_id;
        if($request->employee_id == null)
            $orderService->status = ServiceStatus::PENDING;
        else
            $orderService->status = ServiceStatus::PROCESSING;

        $orderService->update();
        return response()->json(['success',"Sent To Production"], 200);
    }

    public function makeReady(Request $request,OrderService $orderService){

        $message = "";
        if($request->ready == 'true' && $orderService->employee_id != null){
            $orderService->status = ServiceStatus::READY;
            $message = "Service Is Ready To Delivar";
        }else if($orderService->employee_id != null){
            $orderService->status = ServiceStatus::PROCESSING;
            $message = "Service Sent To Production";
        }else{
            $orderService->status = ServiceStatus::PENDING;
            $message = "Service Is On Pending";
        }


        $orderService->update();
        return response()->json(['success',$message], 200);
    }
}
