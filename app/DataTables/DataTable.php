<?php
namespace App\DataTables;

use Illuminate\Support\Arr;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Html\Button;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Services\DataTablesExportHandler;
use Yajra\DataTables\Services\DataTable as BaseDataTable;

class DataTable extends BaseDataTable{
    private $defaultButton;
    public $buttonClass = 'btn btn-sm btn-info';
    public function __construct()
    {
        $this->defaultButton = [
            'create'=>Button::make('create')->raw('<i class="fa fa-plus"></i>')->extend('create')->addClass($this->buttonClass.' rounded-left'),
            'export'=>Button::make('export')->raw('<i class="fa fa-download"></i>')->extend('export')->addClass($this->buttonClass),
            'print'=>Button::make('print')->raw('<i class="fa fa-print"></i>')->extend('print')->addClass($this->buttonClass),
            'reset'=>Button::make('reset')->raw('<i class="fa fa-redo"></i>')->extend('reload')->addClass($this->buttonClass),
            'reload'=>Button::make('reload')->raw('<i class="fa fa-undo"></i>')->extend('reset')->addClass($this->buttonClass)->attr(['id'=>$this->getId()."-reset-button"]),
        ];
    }

    protected $tableId = "datatable";

    public function getId(){
        return $this->tableId;
    }
    public function getColumns(){
        return [];
    }

    public function addVerticalAlignmentToColumns($coulmns){
        return collect($coulmns)->map(function($value){
            if($value->name != "actions")
                $value->addClass('align-middle');
            return $value;
        })->toArray();
    }

    public function pdf(){
        $collection = $this->getAjaxResponseData();
        if(count($collection)){
            $exportObject = null;
            if (! new $this->exportClass(collect()) instanceof DataTablesExportHandler) {
                $exportObject = new $this->exportClass($this->convertToLazyCollection($collection));
                $keys =  $exportObject->headings();
            }else{
                $keys = array_keys($collection[0]);
            }
            $view = view('components.datatable.export.pdf')
            ->with('headings',$keys)
            ->with('data',$collection)
            ->with('exportObject',$exportObject)
            ->render();
            return App::make('dompdf.wrapper')->loadHTML($view)->setPaper('a4', 'landscape')->download($this->getFilename() .'.pdf');
        }else{
            echo "No Data To Download";
        }
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId($this->getId())
                    ->addTableClass('table-sm table-striped')
                    ->columns($this->getColumns())
                    ->lengthMenu([[ 10, 25, 50, -1 ], [10, 25, 50, "All"]])
                    ->searching(true)
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



    public function getButton($buttonname){
        $button =  Arr::get($this->overrideButtons(),$buttonname,null);
        return $button instanceof Button?$button->addClass($this->buttonClass):Arr::get($this->defaultButton,$buttonname);
    }

    public function overrideButtons(){

    }

    public function render($view, $data = [], $mergeData = [])
    {

        // if ($this->request()->ajax() && $this->request()->wantsJson()) {
        //     return app()->call([$this, 'ajax']);
        // }

        // if ($action = $this->request()->get('action') and in_array($action, $this->actions)) {
        //     if ($action == 'print') {
        //         return app()->call([$this, 'printPreview']);
        //     }

        //     return app()->call([$this, $action]);
        // }

        $data['datatableFilters'] = collect($this->getFilters())->toJson();
        $data['datatableId'] = $this->tableId;
        return parent::render($view,$data,$mergeData);
        //return view($view, $data, $mergeData)->with($this->dataTableVariable, $this->getHtmlBuilder());
    }
}
