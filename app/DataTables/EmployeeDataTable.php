<?php

namespace App\DataTables;

use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;

class EmployeeDataTable extends DataTable
{

    protected $tableId = 'employee-table';

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable(Request $request,$query)
    {

        return datatables()
            ->eloquent($query)
            ->filterColumn('name', function($query, $keyword) {
                $query->where('name', "like", "%".$keyword."%");
            })->filterColumn('mobile', function($query, $keyword) {
                $query->where('mobile', "like", "%".$keyword."%");
            })->filterColumn('address', function($query, $keyword) {
                $query->where('address', "like", "%".$keyword."%");
            })
            ->addColumn('actions', function(Employee $employee) {
                return view('components.actionbuttons.table_actions')->with('route','employees')->with('param','employee')->with('value',$employee)->render();
            })
            ->addIndexColumn()
            ->rawColumns(['actions']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Employee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Employee $model)
    {
        return $model->newQuery();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    public function getColumns()
    {
        return [
            Column::make('name'),
            Column::make('mobile'),
            Column::make('address'),
            Column::computed('actions')
                  ->exportable(false)
                  ->printable(false)
                  ->width(240)
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
        return 'Employee_' . date('YmdHis');
    }

    public function getFilters()
    {
        return [
            '0'=>'Name',
            '1'=>'Mobile',
            '2'=>'Address',
        ];
    }
}
