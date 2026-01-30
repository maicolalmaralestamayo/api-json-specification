<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

class CommonController extends Controller
{
    // OKOKOK
    static function jsonapi(){
        return [
            'version' => '1.1',
            'ext' => null,
            'profile' => null,
            'meta' => [
                'application' => env('APP_NAME'),
                'description' => env('DESCRIPTION'),
                'api_version' => env('API_VERSION'),
                'language' => 'PHP ' . phpversion(),
                'engine' => 'Zend Engine ' . zend_version(),
                'framework' => app()->version(),
                'organization' => env('ORGANIZATION'),
                'team' => env('TEAM'),
                'author' => env('AUTHOR'),
                'email' => env('EMAIL'),
                'phone' => env('PHONE'),
                'environment' => App::environment(),
                'updated_at' => env('UPDATED_AT'),
            ]
        ];
    }

    // OKOKOK
    static function getJson($data, $included = null){
        $json = [];

        if ($data) { $json['data'] = $data; }
        if ($included) { $json['included'] = $included; }
        $json['jsonapi'] = self::jsonapi();

        return response()->json($json, 200);
    }
}