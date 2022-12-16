<?php


namespace App\Repositories;


use App\Interface\GroupRepositoryInterface;
use App\Models\Group;

class GroupRepository extends BaseRepository implements GroupRepositoryInterface
{
    /**
     * GroupRepository constructor.
     *
     * @param Group $model
     */
    public function __construct(Group $model)
    {
        parent::__construct($model);
    }

    public function setModel(Group $model)
    {
        $this->model = $model;
        return $this;
    }


}
