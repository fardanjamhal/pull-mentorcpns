<?php

namespace App\Repositories\Contracts;

Interface BaseRepositoryInterface
{
    /**
     * Retrive data array for populate field select
     *
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function lists($column, $key = null);

    /**
     * Retrive data array for populate field select
     *
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function pluck($column, $key = null);

    /**
     * Sync Relations
     *
     * @param $id
     * @param $relation
     * @param $attributes
     * @param boolean $detaching
     * @return mixed
     */
    public function sync($id, $relation, $attributes, $detaching = true);

    /**
     * SyncWithoutDetaching
     *
     * @param $id
     * @param $relation
     * @param $attributes
     * @return mixed
     */
    public function syncWithoutDetaching($id, $relation, $attributes);

    /**
     * Retrive all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * Retrieve all data of repository, paginated
     *
     * @param $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate($limit = null, $columns = ['*']);

    /**
     * Retrieve all data of repository, simple paginated
     *
     * @param $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function simplePaginate($limit = null, $columns = ['*']);

    /**
     * Find data by id
     *
     * @param $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id);

    /**
     * Find data by field and value
     *
     * @param $field
     * @param $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByField($field, $value, $columns = ['*']);

    /**
     * Find data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*']);

    /**
     * Find data by multiple values in one field
     *
     * @param $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = ['*']);

    /**
     * Find data by excluding multiple values in one field
     *
     * @param $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereNotIn($field, array $values, $columns = ['*']);

    /**
     * Find data by between values in one field
     *
     * @param $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereBetween($field, array $values, $columns = ['*']);

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id);

    /**
     * Update or Create an entity in repository
     *
     * @param array $attributes
     * @param array $values
     *
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = []);

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * Order collection by a given column
     *
     * @param $column
     * @param string $direction
     *
     * @return mixed
     */
    public function orderBy($column, $direction = 'asc');

    /**
     * Load relations
     *
     * @param $relations
     *
     * @return mixed
     */
    public function with($relations);

    /**
     * Load relation with closure
     *
     * @param $relation
     * @param $closure
     *
     * @return mixed
     */
    public function whereHas($relation, $closure);

    /**
     * Add subselect queries to count the relations.
     *
     * @param $relations
     *
     * @return mixed
     */
    public function withCount($relations);

    /**
     * Set hidden fields
     *
     * @param array $fields
     *
     * @return mixed
     */
    public function hidden(array $fields);

    /**
     * Set visible fields
     *
     * @param array $fields
     *
     * @return mixed
     */
    public function visible(array $fields);

    /**
     * Query Scope
     *
     * @param \Closure $scope
     *
     * @return mixed
     */
    public function scopeQuery(\Closure $scope);

    /**
     * Reset Query Scope
     *
     *
     * @return mixed
     */
    public function resetScope();

    /**
     * Get Searchable Fields
     *
     *
     * @return mixed
     */
    public function getFieldsSearchable();

    /**
     * Retrieve first data of repository, or return new Entity
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function firstOrNew(array $attributes = []);

    /**
     * Retrieve first data of repository, or create new Entity
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function firstOrCreate(array $attributes = []);
}
