<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    public function getDataObject(Request $request){
        // 1. determinar el modelo del recurso
        $resource = $request->resource;
        $model = QueryController::model($resource);
        $modelPath = QueryController::modelPath($model);

        // 2. determinar el objecto
        $object = $modelPath::find($request->id);

        // 3. determinar los campos del objeto a mostrar
        $fieldsUrl = $request->input('fields.' . $resource);
        $fields = $fieldsUrl? QueryController::modelFields($modelPath, $fieldsUrl) : null;

        // 4. determinar la clave 'data' del json
        $data = ObjectController::dataResourceObject($object, $fields);

        // 5. determinar los recursos incluídos a mostrar
        $includedUrl = $request->input('included');
        $relations = $includedUrl? QueryController::modelRelations($modelPath, $includedUrl) : null;

        // 6. determinar los recursos incluídos belongsTo
        $belongsTo = $relations? ObjectController::objectBelongsTo($object, $relations) : null;

        return CommonController::getJson($data);
    }

    public function getDataCollection(Request $request){
        // 1. determinar el modelo del recurso
        $resource = $request->resource;
        $model = QueryController::model($resource);
        $modelPath = QueryController::modelPath($model);

        // 2. determinar el objecto
        $collection = $modelPath::get();

        // 3. determinar los campos del objeto a mostrar
        $fieldsUrl = $request->input('fields.' . $resource);
        $fields = QueryController::modelFields($modelPath, $fieldsUrl);

        // 4. determinar la clave 'data' del json
        $data = CollectionController::dataCollection($collection, $fields);

        // 5. determinar los recursos incluídos a mostrar
        $includedUrl = $request->input('include');
        $relations = $includedUrl? QueryController::modelRelations($modelPath, $includedUrl) : null;

        // 6. determinar los recursos incluídos
        // $include = $relations? ObjectController::includedObject($collection, $relations) : null;

        // return CommonController::getJson($data, $included);
    }
}