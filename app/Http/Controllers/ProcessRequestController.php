<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProcessRequestController extends Controller
{
    public function processRequest(Request $request)
    {
        //obtener segmentos de la URl    
        $segmentsUrl = explode('/', $request->objetos);

        //obtener modelo principal
        $principalModel = $segmentsUrl[0];

        //eliminar plural del modelo principal (si está en plural)
        $lastChar = substr($principalModel, -1);
        if ($lastChar == 's') {
            $principalModel = substr($principalModel, 0, -1);
        }

        //obtener ruta del modelo principal
        $pathPrincipalModel = 'App\\Models\\' . ucfirst($principalModel);

        //obtener los datos
        if (count($segmentsUrl) == 1) {
            $collection = $pathPrincipalModel::get();
            return CollectionController::getJson($collection, $request);
        }

        if (count($segmentsUrl) == 2) {
            $object = $pathPrincipalModel::find($segmentsUrl[1]);
            return ObjectController::getJson($object, $request);
        }

        if (count($segmentsUrl) == 4) {
            if ($segmentsUrl[2] == 'relationships') {
                # code...
            }
        }

        // $data = Schema::getColumnListing((new $pathPrincipalModel)->gettable());
        // return response()->json(['data' => $data]);
    }

    public function columns($model)
    {
        return Schema::getColumnListing((new $model)->gettable());
    }
}
