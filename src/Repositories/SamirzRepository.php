<?php

namespace Samirz\Super\Repositories;

use Illuminate\Database\Eloquent\Model;

class SamirzRepository
{
    /**
     * The Model clas
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The Repository Constructor
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get the model class
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Create new record
     *
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function create(array $data)
    {
        $record = $this->model->create($data);

        return $record;
    }

    /**
     * Update an exists record
     *
     * @param  int $id
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Collection|bool
     */
    public function update($id, array $data)
    {
        $record = $this->getRecord($id);

        if (!$record)
            return false;

        $record->update($data);

        return $record;
    }

    /**
     * Delete an existing record
     *
     * @param  int $id
     * @return bool
     */
    public function delete($id)
    {
        $record = $this->getRecord($id);

        if (!$record)
            return false;

        return $record->delete();
    }

    /**
     * Restore deleted record by id
     *
     * @param  int $id
     * @return bool
     */
    public function restore($id)
    {
        $record = $this->model::onlyTrashed()->find($id);

        if (null === $record)
            return false;

        return $record->restore();
    }

    /**
     * Force delete record by id
     *
     * @param  int $id
     * @return bool
     */
    public function forceDelete($id)
    {
        $record = $this->model->withTrashed()->find($id);

        if (null === $record)
            return false;

        return $record->forceDelete();
    }

    /**
     * Get the record by id
     *
     * @param  int $id
     * @return \Illuminate\Database\Eloquent\Collection|bool
     */
    public function getRecord($id)
    {
        $record = $this->model->find($id);

        if (null === $record)
            return false;

        return $record;
    }

    /**
     * Get all records
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRecords()
    {
        return $this->model->all();
    }

    /**
     * Get the data ordered and paginated
     *
     * @param  int $count
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecordsPaginated($count = 20, $order = 'desc')
    {
        return $this->model->orderBy('created_at', $order)->paginate($count);
    }

    /**
     * Get the trashed data ordered and paginated
     *
     * @param  int $count
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTrashedRecordsPaginated($count = 20, $order = 'desc')
    {
        return $this->model->onlyTrashed()->orderBy('created_at', $order)->paginate($count);
    }
}
