<?php


namespace App\Traits;

trait HttpResponse{
    protected function sucess($data,$message=null,$code = 200){
        return response()->json([
            "status"=>"Request was Sucessfull",
            "message"=>$message,
            "data"=>$data,
        ],$code);
    }
    protected function error($data,$message=null,$code){
        return response()->json([
            "status"=>"Error has occured",
            "message"=>$message,
            "data"=>$data,
        ],$code);
    }
}