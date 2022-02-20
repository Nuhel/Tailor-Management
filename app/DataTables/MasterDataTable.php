<?php

namespace App\DataTables;

use App\Models\Master;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class MasterDataTable extends DataTable
{

    protected $tableId = 'master-table';

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
            })->filterColumn('salary', function($query, $keyword) {
                $query->where('salary', "like", "%".$keyword."%");
            })
            ->addColumn('actions', function(Master $master) {
                return view('components.actionbuttons.table_actions')->with('route','masters')->with('param','master')->with('value',$master)->render();
            })
            ->addIndexColumn()
            ->rawColumns(['actions']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Master $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Master $model)
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
            Column::computed('index','SL')->width(20),
            Column::make('name'),
            Column::make('mobile'),
            Column::make('address'),
            Column::make('salary'),
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
        return 'Master_' . date('YmdHis');
    }

    public function getFilters()
    {
        return [
            '1'=>'Name',
            '2'=>'Mobile',
            '3'=>'Address',
            '4'=>'Salary',
        ];
    }
}
