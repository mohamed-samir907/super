<?php

namespace Samirz\Super\Services;

use GuzzleHttp\Psr7\Request;
use Samirz\Super\Repositories\SamirzRepository;

class SamirzService
{
    /**
     * The Repository class
     *
     * @var \Samirz\Super\Repositories\SamirzRepository
     */
    protected $repository;

    /**
     * The class constructor
     *
     * @param \Samirz\Super\Repositories\SamirzRepository $repository
     */
    public function __construct(SamirzRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the Repository class
     *
     * @return \Samirz\Super\Repositories\SamirzRepository
     */
    public function repository()
    {
        return $this->repository;
    }

    /**
     * Create new record
     *
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * Update an exists record
     *
     * @param  int $id
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete an existing record
     *
     * @param  int $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Restore deleted record by id
     *
     * @param  int $id
     * @return bool
     */
    public function restore($id)
    {
        return $this->repository->restore($id);
    }

    /**
     * Force delete record by id
     *
     * @param  int $id
     * @return bool
     */
    public function force($id)
    {
        return $this->repository->forceDelete($id);
    }
}
