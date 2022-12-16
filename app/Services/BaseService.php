<?php


namespace App\Services;


use Illuminate\Database\Eloquent\Model;

class BaseService
{
    protected function normalize(Model $model, $resourceClassName)
    {
        //$model = $resourceClassName::loadRelations($model);

        return new $resourceClassName($model);
    }

    protected function normalizeList($data, $resourceClassName)
    {

//        $builder->dd();
        //$perPage = (int)request()->get('perPage', request()->query('perPage'));

//        return $builder->paginate($perPage);
        return $resourceClassName::collection($data);
    }
}
