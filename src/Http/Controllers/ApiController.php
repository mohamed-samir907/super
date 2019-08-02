<?php

namespace Samirz\Super\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * The service class
     *
     * @var \Samirz\Super\Services\SamirzService
     */
    protected $service;

    /**
     * The Model Resource
     *
     * @var \Illuminate\Http\Resources\Json\JsonResource
     */
    protected $resource;

    /**
     * The Request that used to validate the inputs on "Store" method
     *
     * @var \Request
     */
    protected $store_request = Request::class;

    /**
     * The Request that used to validate the inputs on "Update" method
     *
     * @var \Request
     */
    protected $update_request = Request::class;

    /**
     * The Controller Constructor
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function __construct(SamirzService $service)
    {
        $this->service  = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->resource->collection(
            $this->service->repository()->getRecordsPaginated(20)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $request = app($this->store_request);

        return new $this->resource( $this->service->create($request->all()) );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return if_true_return_resource(
            $this->service->repository()->getRecord($id), $this->resource
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $request = app($this->update_request);

        return if_true_return_resource(
            $this->service->update($id, $request->all()), $this->resource
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return if_true_return_message(
            $this->service->delete($id), delete_success()
        );
    }

    /**
     * Get all trashed recordsGET
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        return $this->resource->collection(
            $this->service->repository()->getTrashedRecordsPaginated(20)
        );
    }

    /**
     * Restore the trashed record to un trashed records
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        return if_true_return_message(
            $this->service->restore($id), restore_success()
        );
    }

    /**
     * Force Delete the record from model table
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function force($id)
    {
        return if_true_return_message(
            $this->service->force($id), force_success()
        );
    }
}
