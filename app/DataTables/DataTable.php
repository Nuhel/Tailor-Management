<?php
namespace App\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable as BaseDataTable;

class DataTable extends BaseDataTable{

    protected $tableId = "datatable";
    public function getColumns(){
        return [];
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId($this->tableId)
                    ->addTableClass('table-sm table-striped')
                    ->columns($this->getColumns())
                    ->lengthMenu([ 10, 25, 50, -1 ])
                    ->searching(false)
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons($this->getButtons());
    }


    public function getButtons(){
        $buttonClass = 'btn btn-sm btn-info';
        return [

            Button::make('create')->extend('pageLength')->addClass($buttonClass.' rounded'),
            Button::make('create')->raw('<p></p>')->addClass($buttonClass.' spacer'),
            Button::make('create')->raw('<i class="fa fa-plus"></i>')->extend('create')->addClass($buttonClass.' rounded-left'),
            Button::make('export')->raw('<i class="fa fa-download"></i>')->extend('export')->addClass($buttonClass),
            Button::make('print')->raw('<i class="fa fa-print"></i>')->extend('print')->addClass($buttonClass),
            Button::make('reset')->raw('<i class="fa fa-redo"></i>')->extend('reload')->addClass($buttonClass),
            Button::make('reload')->raw('<i class="fa fa-undo"></i>')->extend('reset')->addClass($buttonClass)->attr(['id'=>"reset-button"])
        ];
    }
    /**
     * Get the value of filters
     */
    public function getFilters()
    {

    }


    /**
     * Set the value of filters
     *
     * @return  self
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;

        return $this;
    }

    public function render($view, $data = [], $mergeData = [])
    {
        if ($this->request()->ajax() && $this->request()->wantsJson()) {
            return app()->call([$this, 'ajax']);
        }

        if ($action = $this->request()->get('action') and in_array($action, $this->actions)) {
            if ($action == 'print') {
                return app()->call([$this, 'printPreview']);
            }

            return app()->call([$this, $action]);
        }
        $data['datatableFilters'] = collect($this->getFilters())->toJson();
        return view($view, $data, $mergeData)->with($this->dataTableVariable, $this->getHtmlBuilder());
    }
}
