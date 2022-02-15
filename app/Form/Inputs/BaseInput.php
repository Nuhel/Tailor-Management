<?php
namespace App\Form\Inputs;
use Illuminate\Support\Str;
abstract class BaseInput{



    protected $label;
    protected $name;
    protected $type;
    protected $value;
    protected $placeHolder;
    protected $id;
    protected $error;

    protected $wrapperClass;
    protected $inputClass;

    protected $enableLabel;
    protected $labelClass;


    protected $viewName = 'form_facade.input';
    protected $view;
    protected $append;

    public function __construct(){
        $this->enableLabel = true;
        $this->type = 'text';
        $this->wrapperClass = 'form-group mb-0';
        $this->inputClass = 'form-control form-control-sm';
        $this->labelClass = 'form-inline';
        $this->view = view($this->viewName);
    }


    public function getLabel()
    {
        return Str::of($this->label??$this->getName())->headline();
    }


    public function setLabel($label = null)
    {
        $this->label = $label;

        return $this;
    }


    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    public function getType()
    {
        return $this->type;
    }


    public function setType($type = "text")
    {
        $this->type = $type;

        return $this;
    }


    public function getValue()
    {
        return $this->value;
    }


    public function setValue($value= null)
    {
        $this->value = $value;

        return $this;
    }


    public function getPlaceHolder()
    {
        return Str::of($this->placeHolder??$this->getName())->headline();
    }


    public function setPlaceHolder($placeHolder = null)
    {
        $this->placeHolder = $placeHolder;

        return $this;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }






    public function getError()
    {
        return $this->error?? $this->getName();
    }

    /**
     * Set the value of error
     *
     * @return  self
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    public function render()
    {
        $this->validateRender();
        $this->addParamsToView();
        return $this->view->render();
    }

    public function addParamsToView(){
        $this->view = $this->view
        ->with('name',$this->getName())
        ->with('id',$this->getId())
        ->with('label',$this->getLabel())
        ->with('type',$this->getType())
        ->with('placeholder',$this->getPlaceHolder())
        ->with('value',$this->getValue())
        ->with('error',$this->getError())
        ->with('wrapperClass',$this->getWrapperClass())
        ->with('inputClass',$this->getInputClass())
        ->with('labelClass',$this->getLabelClass())
        ->with('append',$this->getAppend())
        ->with('enableLabel',$this->getEnableLabel())
        ;
    }

    function validateRender(){
        if($this->getName() == null || Str::length($this->getName())==0){
            throw new \ErrorException('Input Name is required');
        }
    }


    public function getWrapperClass()
    {
        return $this->wrapperClass;
    }


    public function setWrapperClass($wrapperClass)
    {
        $this->wrapperClass = $wrapperClass;

        return $this;
    }

    public function appendWrapperClass($wrapperClass)
    {
        $this->wrapperClass = $this->wrapperClass . ' '.$wrapperClass;

        return $this;
    }

    public function getInputClass()
    {
        return $this->inputClass;
    }


    public function setInputClass($inputClass)
    {
        $this->inputClass = $inputClass;

        return $this;
    }

    public function appendInputClass($inputClass)
    {
        $this->inputClass = $this->inputClass . ' '.$inputClass;

        return $this;
    }


    public function getLabelClass()
    {
        return $this->labelClass;
    }


    public function setLabelClass($labelClass)
    {
        $this->labelClass = $labelClass;

        return $this;
    }

    public function appendLabelClass($labelClass)
    {
        $this->labelClass = $this->labelClass . ' '.$labelClass;

        return $this;
    }

    /**
     * Get the value of append
     */
    public function getAppend()
    {
        return $this->append;
    }

    /**
     * Set the value of append
     *
     * @return  self
     */
    public function setAppend($append)
    {
        $this->append = $append;

        return $this;
    }

    /**
     * Get the value of enableLabel
     */
    public function getEnableLabel()
    {
        return $this->enableLabel;
    }

    /**
     * Set the value of enableLabel
     *
     * @return  self
     */
    public function setEnableLabel($enableLabel)
    {
        $this->enableLabel = $enableLabel;

        return $this;
    }

    public function __toString(){
        return $this->render();
    }
}
