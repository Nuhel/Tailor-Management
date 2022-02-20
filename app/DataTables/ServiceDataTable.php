<?php

namespace App\DataTables;

use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class ServiceDataTable extends DataTable
{

    protected $tableId = 'service-table';

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
            })->filterColumn('measurements', function($query, $keyword) {
                $query->whereHas('measurements', function ($query) use($keyword){
                    $query->where('name', 'like', '%'.$keyword.'%');
                });
            })
            ->addColumn('measurements', function(Service $service) {
                $data = '';
                foreach($service->measurements as $index => $measurement){
                    $data.= $measurement->name;

                    if(! ($index == $service->measurements->count()-1))
                        $data .=',';
                }
                return $data;
            })
            ->addColumn('actions', function(Service $service) {
                return view('components.actionbuttons.table_actions')->with('route','services')->with('param','service')->with('value',$service)->render();
            })
            ->addIndexColumn()
            ->rawColumns(['actions']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Service $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Service $model)
    {
        return $model->newQuery()->with('measurements');
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
            Column::computed('measurements'),
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
        return 'Service_' . date('YmdHis');
    }

    public function getFilters()
    {
        return [
            '1'=>'Name',
            '2'=>'Measurements',
        ];
    }

    public function overrideButtons(){
        return [
            'create'=>null,
            'export'=>null,
            'print'=>null,
            'reset'=>null,
            'reload'=>null,
        ];
    }
}
