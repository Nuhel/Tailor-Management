<?php
namespace App\Form;

use App\Form\Inputs\TextInput;
use App\Form\Inputs\TextAreaInput;
use App\Form\Inputs\SelectInput;

class Form
{
    public function input(){
        return new TextInput();
    }

    public function textarea(){
        return new TextAreaInput();
    }

    public function select(){
        return new SelectInput();

    }
}
