<?php


namespace App\Repositories;


use App\Interface\FileRepositoryInterface;
use App\Models\File;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    /**
     * FileRepository constructor.
     *
     * @param File $model
     */
    public function __construct(File $model)
    {
        parent::__construct($model);
    }
}
