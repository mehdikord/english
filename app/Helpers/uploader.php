<?php
//All functions for upload in storage

function upload_public_file($path,$file=null){
    if(is_file($file)){
        return \Illuminate\Support\Facades\Storage::put("public/".$path,$file,'public');
    }
}
