<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\DataTables\Reports\OrderDataTable;


class ReportController extends Controller
{
    public function orderReport(OrderDataTable $dataTable)
    {
        return $dataTable->render('reports.order',['heading'=>'Order Report']);
    }

}
