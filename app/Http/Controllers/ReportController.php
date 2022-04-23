<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\DataTables\Reports\ProfitDataTable;


class ReportController extends Controller
{
    public function profit(ProfitDataTable $dataTable)
    {
        return $dataTable->render('components.datatable.index',['heading'=>'Profit']);
    }

}
