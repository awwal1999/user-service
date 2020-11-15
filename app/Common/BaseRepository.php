<?php


namespace App\Common;


use App\Common\Contracts\BaseRepositoryContract;
use App\Model\Enums\GenericStatusConstant;
use Closure;
use Dlabs\PaginateApi\PaginateApiAwarePaginator;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryContract
{


    protected $model;

    /**
     * The query builder.
     *
     * @var Builder
     */
    protected $query;

    /**
     * Alias for the query limit.
     *
     * @var int
     */
    protected $take;


    /** Array of all the joins
     * @var array
     */
    protected $join = [];

    /**
     * Array of related models to eager load.
     *
     * @var array
     */
    protected $with = [];

    /**
     * Array of one or more where clause parameters.
     *
     * @var array
     */
    protected $wheres = [];


    /**
     * Array of one or more orWhere clause parameters.
     * @var array
     */
    protected $orWhere = [];


    /**
     * Array of one or more where in clause parameters.
     *
     * @var array
     */
    protected $whereIns = [];

    /**
     * Array of one or more ORDER BY column/value pairs.
     *
     * @var array
     */
    protected $orderBys = [];

    /**
     * Array of scope methods to call on the model.
     *
     * @var array
     */
    protected $scopes = [];

    /**
     * Alias for the query pffset.
     *
     * @var int
     */
    private $offset;

    /**
     * Get all the model records in the database.
     *
     * @return Collection
     */
    public function all()
    {
        $this->newQuery()->eagerLoad();

        $models = $this->query->get();

        $this->unsetClauses();

        return $models;
    }

    /**
     * Count the number of specified model records in the database.
     *
     * @return int
     */
    public function count(): int
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $count = $this->query->count();

        $this->unsetClauses();

        return $count;
    }


    /**
     * @param array $columns
     * @return Builder|Model|object|null
     */

    public function first(array $columns = ['*'])
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $model = $this->query->first($columns);

        $this->unsetClauses();

        return $model;
    }

    public function firstOrFail(array $columns = ['*'])
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $model = $this->query->firstOrFail($columns);

        $this->unsetClauses();

        return $model;
    }


    /**
     * @param array $columns
     * @return Builder[]|Collection
     */
    public function get($columns = ['*'])
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $models = $this->query->get($columns);

        $this->unsetClauses();

        return $models;
    }


    public function getById($id, $status)
    {

        $this->newQuery()->eagerLoad();

        $model = $this->query->findOrFail($id);

        $this->unsetClauses();

        return $model;
    }


    public function getByIds($ids, $status, $columns = ['*']): Collection
    {

        $this->newQuery()->eagerLoad();
        $models = $this->query->whereIn('id', $ids)->get($columns);
        $this->unsetClauses();
        return $models;


    }

    /**
     * @param array $keyValue
     * @param array $columns
     * @return int
     */
    public function countByColumns(array $keyValue, $columns = ['*'])
    {


        $this->newQuery()->eagerLoad();

        foreach ($keyValue as $column => $item) {
            $this->query->where($column, "=", $item);
        }
        $count = $this->query->count($columns);
        $this->unsetClauses();
        return $count;


    }


    /**
     * @param array $keyValue
     * @param array $columns
     * @return Builder|Model|object|null
     */
    public function getByColumns(array $keyValue, $columns = ['*'])
    {

        $this->newQuery()->eagerLoad();
        foreach ($keyValue as $column => $item) {
            $this->query->where($column, "=", $item);
        }

        $models = $this->query->get($columns);

        $this->unsetClauses();

        return $models;
    }

    public function getFirstByColumns(array $keyValue, $columns = ['*'])
    {
        $this->newQuery()->eagerLoad();
        foreach ($keyValue as $column => $item) {
            $this->query->where($column, "=", $item);
        }
        $model = $this->query->firstOrFail($columns);
        $this->unsetClauses();
        return $model;
    }

    public function getFirstOrElse(array $keyValue, Closure $callBack, $columns = ['*'])
    {

        $this->newQuery()->eagerLoad();

        foreach ($keyValue as $column => $item) {
            $this->query->where($column, "=", $item);
        }
        $model = $this->query->firstOr($columns, $callBack);

        $this->unsetClauses();

        return $model;
    }

    /**
     * @param $column
     * @param $item
     * @param array $columns
     * @return Builder|Model|object|null
     */


    public function getByColumn($column, $item, array $columns = ['*'])
    {


        $this->newQuery()->eagerLoad();

        $model = $this->query->where($column, $item)->first($columns);

        $this->unsetClauses();

        return $model;
    }

    /**
     * Delete the specified model record from the database.
     *
     * @param $id
     *
     * @return bool|null
     * @throws Exception
     */
    public function deleteById($id, $status)
    {
        $delete = $this->getById($id, $status)->delete();
        $this->unsetClauses();
        return $delete;
    }

    /**
     * Use with causion!!!
     */
    public function deleteAll($status)
    {

        $this->get()->map(function ($model) use ($status) {
            $this->deleteById($model->id, $status);
        });

        $this->unsetClauses();
    }

    /**
     * Set the query limit.
     *
     * @param int $limit
     *
     * @return $this
     */
    public function limit($limit)
    {
        $this->take = $limit;

        return $this;
    }

    /**
     * Set an ORDER BY clause.
     *
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->orderBys[] = compact('column', 'direction');

        return $this;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param array $columns
     * @return PaginateApiAwarePaginator
     */
    public function paginate($limit = 25, $offset = 0, array $columns = ['*'])
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $perPage = $this->take ?? $limit;

        $offSet = $this->offset ?? $offset;


        $models = $this->query->paginateApi($perPage, $offSet, $columns);

        $this->unsetClauses();

        return $models;
    }


    public function orWhere($column, $value, $operator = '=')
    {
        $this->orWhere[] = compact('column', 'value', 'operator');

        return $this;
    }

    /**
     * Add a simple where clause to the query.
     *
     * @param string $column
     * @param string $value
     * @param string $operator
     *
     * @return $this
     */
    public function where($column, $value = null, $operator = '=')
    {

        $this->wheres[] = compact('column', 'value', 'operator');

        return $this;
    }

    /**
     * Add a simple where in clause to the query.
     *
     * @param string $column
     * @param mixed $values
     *
     * @return $this
     */
    public function whereIn($column, $values)
    {
        $values = is_array($values) ? $values : [$values];

        $this->whereIns[] = compact('column', 'values');

        return $this;
    }

    /**
     * Set Eloquent relationships to eager load.
     *
     * @param $relations
     *
     * @return $this
     */
    public function with($relations)
    {
        if (is_string($relations)) {
            $relations = func_get_args();
        }

        $this->with = $relations;

        return $this;
    }

    /**
     * Create a new instance of the model's query builder.
     *
     * @return $this
     */
    protected function newQuery()
    {
        $this->query = $this->model->newQuery();

        return $this;
    }


    public function join($table, $firstConstraint, $secondConstraint, $operator = '=')
    {
        $this->join[] = compact('table', 'firstConstraint', 'secondConstraint', 'operator');

        return $this;
    }

    /**
     * Add relationships to the query builder to eager load.
     *
     * @return $this
     */
    protected function eagerLoad()
    {
        foreach ($this->with as $relation) {
            $this->query->with($relation);
        }

        return $this;
    }

    /**
     * Set clauses on the query builder.
     *
     * @return $this
     */
    protected function setClauses()
    {

        foreach ($this->join as $join) {
            $this->query->join($join['table'], $join['firstConstraint'], $join['operator'], $join['secondConstraint']);
        }

        foreach ($this->wheres as $where) {

            if ($where['column'] instanceof Closure) {
                $this->query->where($where['column']);
            } else {
                $this->query->where($where['column'], $where['operator'], $where['value']);
            }

        }

        foreach ($this->orWhere as $orWhere) {
            $this->query->orWhere($orWhere['column'], $orWhere['operator'], $orWhere['value']);
        }

        foreach ($this->whereIns as $whereIn) {
            $this->query->whereIn($whereIn['column'], $whereIn['values']);
        }

        foreach ($this->orderBys as $orders) {
            $this->query->orderBy($orders['column'], $orders['direction']);
        }

        if (isset($this->take) and !is_null($this->take)) {
            $this->query->take($this->take);
        }

        if (isset($this->limit) and !is_null($this->limit)) {
            $this->query->limit($this->limit);
        }

        return $this;
    }

    /**
     * Set query scopes.
     *
     * @return $this
     */
    protected function setScopes()
    {
        foreach ($this->scopes as $method => $args) {
            $this->query->$method(implode(', ', $args));
        }

        return $this;
    }

    /**
     * Reset the query clause parameter arrays.
     *
     * @return $this
     */
    protected function unsetClauses()
    {
        $this->wheres = [];
        $this->whereIns = [];
        $this->scopes = [];
        $this->join = [];
        $this->orWhere = [];
        $this->take = null;
        $this->offset = null;

        return $this;
    }

    public function exists()
    {
        $this->newQuery()->eagerLoad()->setClauses()->setScopes();

        $exists = $this->query->exists();

        $this->unsetClauses();

        return $exists;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }



}

