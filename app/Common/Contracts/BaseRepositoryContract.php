<?php


namespace App\Common\Contracts;


use App\Model\Enums\GenericStatusConstant;
use Closure;
use Illuminate\Database\Eloquent\Collection;


interface BaseRepositoryContract
{


    public function first(array $columns = ['*']);

    public function get($columns = ['*']);

    public function getByIds($ids, $status, $columns = ['*']): Collection;

    public function getFirstOrElse(array $keyValue, Closure $callBack, $columns = ['*']);

    public function deleteById($id, $status);

    public function getByColumn($column, $item, array $columns = ['*']);

    public function getFirstByColumns(array $keyValue, $columns = ['*']);

    public function getByColumns(array $keyValue, $columns = ['*']);

    public function countByColumns(array $keyValue, $columns = ['*']);

    public function all();

    public function count(): int;

    public function limit($limit);

    public function offset($offset);

    public function exists();

    public function orderBy($column, $value);

    public function paginate($limit = 25, $offset = 0, array $columns = ['*']);

    public function where($column, $value, $operator = '=');

    public function whereIn($column, $value);

    public function with($relations);

    /**
     * Use with brain ooooo ooooooooooo!!!
     */
    public function deleteAll($status);


}
