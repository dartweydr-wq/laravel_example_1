<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

interface CRUDRepositoryInterface
{
    public function getModelById(int $id) : ?Model;
    public function getModelsQB() : Builder;
}
