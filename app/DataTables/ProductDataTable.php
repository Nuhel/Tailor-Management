<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class ProductDataTable extends DataTable
{

    protected $tableId = 'product-table';

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
            })->filterColumn('category', function($query, $keyword) {
                $query->whereHas('category', function ($query) use($keyword){
                    $query->where('name', 'like', '%'.$keyword.'%');
                });
            })->filterColumn('price', function($query, $keyword) {
                $query->where('price', "like", "%".$keyword."%");
            })
            ->addColumn('category', function(Product $product) {
                return $product->category->name;
            })
            ->addColumn('actions', function(Product $product) {
                return view('components.actionbuttons.table_actions')->with('route','products')->with('param','product')->with('value',$product)->render();
            })
            ->addIndexColumn()
            ->rawColumns(['actions']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model)
    {
        return $model->newQuery()->with('category');
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
            Column::make('category'),
            Column::make('price'),
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
        return 'Product_' . date('YmdHis');
    }

    public function getFilters()
    {
        return [
            '1'=>'Name',
            '2'=>'Category',
            '3'=>'Price',
        ];
    }

    public function overrideButtons(){
        return [
            'create'=>Button::make('create')->raw('<i  class="fa fa-plus"></i>')->attr([
                'data-toggle' => 'modal',
                'data-target' => '#product-add-modal',
            ]),
            'export'=>null,
            'print'=>null,
            'reset'=>null,
            'reload'=>null,
        ];
    }
}
