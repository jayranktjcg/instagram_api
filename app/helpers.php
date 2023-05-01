<?php

if(!function_exists('ajaxResponse')){
    function ajaxResponse($status, $data, $message) {
        return [
            'status' => $status,
            'data' => $data,
            'message' => $message
        ];
    }
}