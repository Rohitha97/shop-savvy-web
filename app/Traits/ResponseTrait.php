<?php

namespace App\Traits;


trait ResponseTrait
{
    public function errorResponse($data,$code=400)
    {
        return response()->json(
            [
                'message' => 'Bad Request Data',
                'data' => $data,
                'code'=>$code
            ],
        );
    }

    public function successResponse($data = [],$code=200)
    {
        return response()->json(
            [
                'message' => 'Successfull',
                'data' => $data,
                'code'=>$code
            ],
        );
    }
}
