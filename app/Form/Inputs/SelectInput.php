<?php
namespace App\Form\Inputs;
use Illuminate\Support\Str;
class SelectInput extends BaseInput
{
    protected $viewName = 'form_facade.select';
    protected $options;
    protected $optionBuilder;
    protected $selected;

    public function getOptionBuilder(){
        return $this->optionBuilder;
    }


    public function setOptionBuilder($optionBuilder){
        $this->optionBuilder = $optionBuilder;
        return $this;
    }


    public function getOptions(){
        return $this->options;
    }


    public function setOptions($options){
        $this->options = $options;
        return $this;
    }

    public function addParamsToView(){
        parent::addParamsToView();
        $this->view = $this->view
        ->with('placeholder',$this->getPlaceHolder()??"Select ".Str::of($this->getName())->ucfirst())
        ->with('options',$this->getOptions())
        ->with('optionBuilder',$this->getOptionBuilder())
        ->with('selected', $this->getValue());
    }

    function validateRender(){
        parent::validateRender();

        if($this->getOptions() == null ){
            $this->setOptions(collect([]));
        }

        if(!is_iterable($this->getOptions()) ){
            throw new \ErrorException('Options Must Be An Associative Array');
        }

        if(!is_callable($this->getOptionBuilder()) ){
            throw new \ErrorException('Option Builder Should Be A Callable Function');
        }


    }


}
