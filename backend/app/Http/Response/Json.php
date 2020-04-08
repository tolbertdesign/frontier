<?php

namespace App\Http\Response;

class Json
{
    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function asError(int $responseCode, array $data = array())
    {
        return response()->json(['errors' => $data], $responseCode);
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function asSuccess(array $data = array())
    {
        return response()->json(array_merge(['success' => true], $data));
    }
}
