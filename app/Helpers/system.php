<?php
// xây dựng những hàm đóng vai trò là system
function uploadFile($nameFolder,$file){
    $fileName = time().'_'.$file->getClientOriginalName();
    return $file->StoreAs($nameFolder,$fileName,'public');
}