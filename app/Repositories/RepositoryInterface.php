<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function orderBy($column, $direction = 'asc');

    public function where($column, $operator = null, $value = null);

    public function updateWhere($id, $column, array $data);

    public function paginate($perPage = 10);
}
