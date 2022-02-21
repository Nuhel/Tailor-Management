<?php
namespace App\DataTables;

use Illuminate\Support\Arr;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable as BaseDataTable;

class DataTable extends BaseDataTable{
    private $defaultButton;
    private $buttonClass = 'btn btn-sm btn-info';
    public function __construct()
    {
        $this->defaultButton = [
            'create'=>Button::make('create')->raw('<i class="fa fa-plus"></i>')->extend('create')->addClass($this->buttonClass.' rounded-left'),
            'export'=>Button::make('export')->raw('<i class="fa fa-download"></i>')->extend('export')->addClass($this->buttonClass),
            'print'=>Button::make('print')->raw('<i class="fa fa-print"></i>')->extend('print')->addClass($this->buttonClass),
            'reset'=>Button::make('reset')->raw('<i class="fa fa-redo"></i>')->extend('reload')->addClass($this->buttonClass),
            'reload'=>Button::make('reload')->raw('<i class="fa fa-undo"></i>')->extend('reset')->addClass($this->buttonClass)->attr(['id'=>"reset-button"]),
        ];
    }

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
                    ->searching(true)
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons($this->getButtons());
    }


    public function getButtons(){

        return [
            Button::make('pageLength')->addClass($this->buttonClass.' rounded'),
            Button::make('spacer')->raw('<p></p>')->className('btn-link bg-transparent spacer')->attr(['disabled'=>'disabled']),
            $this->getButton('create'),
            $this->getButton('export'),
            $this->getButton('print'),
            $this->getButton('reset'),
            $this->getButton('reload'),
        ];
    }
    /**
     * Get the value of filters
     */
    public function getFilters()
    {

    }



    private function getButton($buttonname){
        $button =  Arr::get($this->overrideButtons(),$buttonname,null);
        return $button instanceof Button?$button->addClass($this->buttonClass):Arr::get($this->defaultButton,$buttonname);
    }

    public function overrideButtons(){

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
        $data['datatableId'] = $this->tableId;
        return view($view, $data, $mergeData)->with($this->dataTableVariable, $this->getHtmlBuilder());
    }
}
