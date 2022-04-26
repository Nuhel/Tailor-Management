<?php

namespace App\DataTables;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class ExpenseCategoryDataTable extends DataTable
{

    protected $tableId = 'expensecategory-table';


    public function dataTable(Request $request,$query)
    {

        return datatables()
            ->eloquent($query)
            ->filterColumn('name', function($query, $keyword) {
                $query->where('name', "like", "%".$keyword."%");
            })
            ->addColumn('actions', function(ExpenseCategory $category) {
                return view('components.actionbuttons.table_actions')->with('route','expense-categories')->with('param','expense_category')->with('value',$category)->render();
            })
            ->addIndexColumn()
            ->rawColumns(['actions']);
    }

    public function query(ExpenseCategory $model)
    {
        return $model->newQuery();
    }

    public function getColumns()
    {
        return [
            Column::computed('index','SL')->width(20),
            Column::make('name'),
            Column::computed('actions')
            ->width(90)
                  ->exportable(false)
                  ->printable(false)

                  ->addClass('text-center')

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Expense Category_' . date('YmdHis');
    }

    public function getFilters()
    {
        return [
            '1'=>'Name',
        ];
    }
}
