<?php

namespace App\Core\Materials\Repositories;

use App\Core\Materials\Entities\MaterialEntity;

interface MaterialRepositoryInterface
{
    public function create(array $data): MaterialEntity;
    public function find($materialID);
}
