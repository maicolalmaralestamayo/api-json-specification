<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class ObjectController extends Controller
{
    // OKOKOK
    static function dataIdentification(Model $object)
    {
        $type = get_class($object)::$type;
        if (!$type) {
            $type = lcfirst(class_basename($object) . 's');
        }

        $objectId['type'] = $type;
        $objectId['id'] = $object->id;

        return $objectId;
    }

    // OKOKOK
    static function dataAttributes(Model $object, ?array $fields = null)
    {
        if (!$fields) {
            $fields = get_class($object)::$attribs;
        }

        foreach ($fields as $key => $field) {
            $attributes[$key] = $object->$field;
        }

        return $attributes;
    }

    // OKOKOK
    static function dataRelationships(Model $object)
    {
        try { $belongsTo = get_class($object)::$belongsTo; } catch (\Throwable $th) { $belongsTo = null; }
        try { $hasMany = get_class($object)::$hasMany; } catch (\Throwable $th) { $hasMany = null; }

        if ($belongsTo) {
            foreach ($belongsTo as $relation) {
                $relations[$relation]['links'] = [
                    'self' => '/' . get_class($object)::$type . '/' . $object->id . '/relationships/' . $relation,
                    'related' => '/' . get_class($object)::$type . '/' . $object->id . '/' . $relation,
                ];

                $relations[$relation]['data'] = self::dataIdentification($object->{$relation});
            }
        }

        if ($hasMany) {
            foreach ($hasMany as $relation) {
                $relations[$relation]['links'] = [
                    'self' => '/' . get_class($object)::$type . '/' . $object->id . '/relationships/' . $relation,
                    'related' => '/' . get_class($object)::$type . '/' . $object->id . '/' . $relation,
                ];

                $relatedData = $object->$relation;
                foreach ($relatedData as $data) {
                    $relations[$relation]['data'][] = self::dataIdentification($data);
                }
            }
        }

        if (!$belongsTo && !$hasMany) { $relations = null; }

        return $relations;
    }

    // OKOKOK
    static function dataLinks(Model $object)
    {
        $links['self'] = '/' . lcfirst(class_basename(get_class($object))) . 's' . '/' . $object->id;
        return $links;
    }

    // OKOKOK
    static function dataMeta(Model $object)
    {
        $meta = null;

        try { $times = get_class($object)::$times; } catch (\Throwable $th) { $times = null; }
        try { $fk = get_class($object)::$fk; } catch (\Throwable $th) { $fk = null; }

        if ($times) {
            foreach ($times as $key => $time) {
                $meta['timestamps'][$key] = $object->$time;
            }
        }

        if ($fk) {
            foreach ($fk as $key => $llave) {
                $meta['foreign_keys'][$key] = $object->$llave;
            }
        }

        return $meta;
    }

    // OKOKOK
    static function dataResourceObject(?Model $object = null, ?array $fields = null)
    {
        if ($object) {
            $resourceObject = self::dataIdentification($object);
            $resourceObject['attributes'] = self::dataAttributes($object, $fields);
            $resourceObject['relationships'] = self::dataRelationships($object);
            $resourceObject['links'] = self::dataLinks($object);

            $meta = self::dataMeta($object);
            if ($meta) {
                $resourceObject['meta'] = $meta;
            }
        } else {
            $resourceObject = $object;
        }

        return $resourceObject;
    }

    // TRABAJANDO
    static function objectBelongsTo(?Model $object = null, ?array $relations = null)
    {
        // verificar que en el modelo existan relaciones belongsTo
        try {
            $belongsTo = get_class($object)::$belongsTo;
        } catch (\Throwable $th) {
            $belongsTo = null;
        }

        // si hay relaciones belongsTo
        if ($belongsTo) {
            if ($relations) {
                $includeObjects = [];

                foreach ($relations as $key => $relation) {
                    $includeObjects[] = self::dataResourceObject($object->$relation);
                }
            } else {
                $includeObjects = $belongsTo;
            }
        } else { //si no hay relaciones belongsTo
            $includeObjects = null;
        }

        return $includeObjects;
    }
}
