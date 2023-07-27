<?php

namespace App\Repository\Base;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    // index
    public function all();
    // list
    public function getList();
    // show
    public function find($id): ?Model;
    // store
    public function create(array $data): Model;
    // update
    public function update(array $data, $id);
    // destroy or archive
    public function delete(string $id);

}
