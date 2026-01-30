<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

class CollectionController extends Controller
{
    // OKOKOK
    static function dataCollection(Collection $collection, ?array $fields = null){
        $dataCollection = [];    

        foreach ($collection as $key => $object) {
            $dataCollection[] = ObjectController::dataResourceObject($object, $fields);
        }

        return $dataCollection;
    }

    // OKOKOK
    static function includedCollection(?Collection $collection = null, ?array $relations = null){
        $includeObjects = [];

        foreach ($collection as $key => $object) {
            foreach ($relations as $key => $relation) {
                $includeObjects[] = ObjectController::dataResourceObject($object->$relation);
            }
        }

        return $includeObjects;
    }
}