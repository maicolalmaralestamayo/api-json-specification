<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlController extends Controller
{
    // OKOKOK
    static function model($resource)
    {
        //eliminar guiones bajos y medios
        $modelArray = preg_split('/[_-]/', $resource);

        //poner mayúsculas y eliminar plurales
        foreach ($modelArray as $key => $value) {
            $modelArray[$key] = ucfirst($value);

            $lastChar = substr($value, -1);
            if ($lastChar == 's') {
                $modelArray[$key] = substr($value, 0, -1);
            }
        }

        //obtener nombre del modelo
        $model = implode('', $modelArray);

        return $model;
    }

    // OKOKOK
    static function modelPath($model)
    {
        return 'App\\Models\\' . $model;
    }

    // OKOKOK
    static function modelFields($modelPath, $fieldsUrl = null)
    {
        // obtener los campos disponibles en un modelo
        $fieldsModel = $modelPath::$attribs;

        // si hay fields[] en la query
        if ($fieldsUrl) {
            if ($fieldsUrl[0] == '-') {// eliminar el signo de resta y setear el tipo de campos a mostrar
                $listType = false;
                $fieldsString = substr($fieldsUrl, 1);
            } else {// mantener los campos originales sin cambios
                $listType = true;
                $fieldsString = $fieldsUrl;
            }

            $fieldsList = explode(',', $fieldsString);// convertir los campos solicitados en un arreglo

            if ($listType == true) {
                $fields = array_intersect_key($fieldsModel, array_flip($fieldsList));
            } elseif ($listType == false) {
                $fields = array_diff_key($fieldsModel, array_flip($fieldsList));
            }
        } else {// si no hay fields[] en la query, se devuelven todos los atributos del modelo
            $fields = $fieldsModel;
        }

        return $fields;
    }

    // OKOKOK
    static function modelRelations($modelPath, $includedUrl = null)
    {
        // obtener los campos disponibles en un modelo
        try { $belongsToModel = $modelPath::$belongsTo; } catch (\Throwable $th) { $belongsToModel = []; }
        try { $hasManyModel = $modelPath::$hasMany; } catch (\Throwable $th) { $hasManyModel = []; }
        $relationsModel = array_merge($belongsToModel, $hasManyModel);

        // si hay fields[] en la query
        if ($includedUrl) {
            if ($includedUrl[0] == '-') {// eliminar el signo de resta y setear el tipo de relación a mostrar
                $listType = false;
                $includeString = substr($includedUrl, 1);
            } else {// mantener las relaciones originales sin cambios
                $listType = true;
                $includeString = $includedUrl;
            }

            $fieldsList = explode(',', $includeString);// convertir las relaciones solicitadas en un arreglo

            if ($listType == true) {
                $included = array_values(array_intersect($relationsModel, $fieldsList));
            } elseif ($listType == false) {
                $included = array_values(array_diff($relationsModel, $fieldsList));
            }
        } elseif (!$includedUrl || empty($relationsModel)) {// si no hay include[] en la query
            $included = null;
        }

        return $included;
    }

    public function url(Request $request)
    {
        // determinar el recurso y su modelo asociado
        $resource = $request->resource? : null;

        if ($resource) {
            $modelResource = self::model($resource);
            $modelPath = self::modelPath($modelResource);

            // determinar los campos del recurso
            $fieldsUrl = $request->input('fields.' . $resource)? : null;
            $fields = self::modelFields($modelPath, $fieldsUrl); // no se comprueba $fieldsUrl porque siempre se devuelven datos

            // determinar los recursos incluídos
            // $includedUrl = $request->input('included');
            // $included = $includedUrl? self::modelRelations($modelPath, $includedUrl) : null;

            // determinar el identidicador del recurso
            $idResource = $request->id? : null;
            if ($idResource) {
                $data = $modelPath::find($idResource);   
            } else {
                $data = $modelPath::get();
            }

            // determinar la clave 'data' del json
            return CommonController::getJson($data, null);
        }
        
        // return $fields;
    }
}
