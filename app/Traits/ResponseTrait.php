<?php


namespace App\Traits;

trait ResponseTrait{
    public function getCurrentLang()
    {
        return app()->getLocale();
    }

    public function returnErrorMessage($message)
    {
        $response = [
            'error'=> true,
            'message'=> $message,
            'data'=> null
        ];

        return response()->json($response);
    }

    public function returnSuccessMessage($message)
    {
        

        return response()->json([
            'error'=> false,
            'message'=> $message,
            'data'=> null
        ]);
    }

    public function returnData($payload, $message)
    {
        

        return response()->json([
            'error'=> false,
            'message'=> $message,
            'data'=> $payload
        ]);
    }


}