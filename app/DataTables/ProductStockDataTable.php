<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;

class ProductStockDataTable extends DataTable
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
            })->filterColumn('stock', function($query, $keyword) {
                $query->where('stock', "like", "%".$keyword."%");
            })

            ->addColumn('stock-input', function(Product $product) {
                return "
                    <div class='form-group mb-0' id='products-".$product->id."'>
                        <input class='form-control form-control-sm' name='products[".$product->id."][stock]' value='".$product->stock."'/>
                        <input name='products[".$product->id."][id]' type='hidden' value='".$product->id."'/>
                    </div>
                ";
            })
            ->addIndexColumn()
            ->rawColumns(['stock-input','name']);
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
            Column::make('stock'),
            Column::computed('stock-input'),

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
