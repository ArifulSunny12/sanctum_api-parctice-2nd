<?php

namespace App\Helper;

class ResponseHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * common function to show success message tp json response
     *  @param string $status
     *  @param string $message
     *  @param array $data
     *  @param integer $statusCode
     *  @return response
     **/

     public static function success($status='success', $message=null, $data=[], $statusCode=200){
        return response()->json([
            'status'=> $status,
            'message'=>$message,
            'data'=>$data,
        ],$statusCode );

    }


    /**
     * common function to show error message tp json response
     *  @param string $status
     *  @param string $message
     *  @param integer $statusCode
     *  @return response
     **/
    public static function error($status='error', $message=null, $statusCode=400){
        return response()->json([
            'status'=> $status,
            'message'=>$message,
        ],$statusCode );

    }
}
