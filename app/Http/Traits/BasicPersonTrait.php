<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait BasicPersonTrait{

    public function storePerson(Request $request, $object){
        $object->name = $request->name;
        $object->mobile = $request->mobile;
        $object->address = $request->address;
        return $object->save();
    }

    public function updatePerson(Request $request, $object){
        $object->name = $request->name;
        $object->mobile = $request->mobile;
        $object->address = $request->address;
        return $object->update();
    }
}
