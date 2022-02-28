<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function redirectWithAlert(bool $success = true,$moduleName = null){
        $trace = debug_backtrace()[1];
        $moduleName = $moduleName??$this->resolveModuleName($trace);
        $callerFunction = ($trace['function']);
        return $this->redirect($moduleName,$callerFunction, !$success);
    }

    public function resolveModuleName($trace){
        $baseClass = class_basename($trace['class']);
        return  Str::of($baseClass)->replace('Controller','')->lower();
    }

    public function getResponseArray($moduleName,$callerFunction, bool $hasError = false){

        $message = "dummymodule Successfully dummyfunction";

        if($hasError){
            $message = "Failed to dummyfunction dummymodule";
        }
        $readableAction = "";

        if($callerFunction == 'store'){
            $readableAction = $hasError?"Create":"Created";
        }elseif($callerFunction == 'update'){
            $readableAction = $hasError?"Update":"Updated";
        }else if($callerFunction == 'destroy'){
            $readableAction = $hasError?"Delete":"Deleted";
        }

        return [
            'status' => $hasError?'error':'success',
            'title' => $hasError?'Oops...':'Great',
            'text' => Str::of($message)->replace('dummyfunction',$readableAction)->replace('dummymodule', Str::of($moduleName)->singular()->headline()),
        ];
    }

    public function redirect($moduleName,$callerFunction, bool $hasError = false){
        $return = null;

        if($hasError)
            $return = redirect()->back();
        else
            $return = redirect(route(Str::of($moduleName)->plural().'.index'));
        return $return->with('alert', $this->getResponseArray($moduleName,$callerFunction, $hasError));
    }
}
