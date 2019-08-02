<?php

namespace Samirz\Super\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Samirz\Super\Exceptions\CanNotAccessException;
use Samirz\Super\Services\SamirzService;

class AjaxController extends Controller
{
    /**
     * The service class
     *
     * @var \Samirz\Super\Services\SamirzService
     */
    protected $service;

    /**
     * The views names
     *
     * @var string
     */
    protected $views = [
        'index'     => 'records.index',
        'trash'     => 'records.trash'
    ];

    /**
     * The model records name in plural case
     *
     * @var string
     */
    protected $plural = 'records';

    /**
     * The model record name in singular case
     *
     * @var string
     */
    protected $singular = 'record';

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
        $records    = $this->plural;
        $data       = $this->service->repository()->getRecordsPaginated(20);
        $$records   = $data;

        return view($this->views['index'], compact($records));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        throw new CanNotAccessException();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $request = app($this->store_request);

        check_ajax();

        $record = $this->service->create($request->all());
        return create_success($record);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        check_ajax();

        $record = $this->service->repository()->getRecord($id);
        return if_true_return_message( $record, found_success($record) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        check_ajax();

        $record = $this->service->repository()->getRecord($id);
        return if_true_return_message( $record, found_success($record) );
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

        check_ajax();

        $record = $this->service->update($id, $request->all());
        return if_true_return_message( $record, edit_success($record) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        check_ajax();

        return if_true_return_message( $this->service->delete($id), delete_success() );
    }

    /**
     * Get all trashed records
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $records    = $this->plural;
        $data       = $this->service->repository()->getTrashedRecordsPaginated(20);
        $$records   = $data;

        return view($this->views['trash'], compact($records));
    }

    /**
     * Restore the trashed record to un trashed records
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        check_ajax();

        return if_true_return_message( $this->service->restore($id), restore_success() );
    }

    /**
     * Force Delete the record from model table
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function force($id)
    {
        check_ajax();

        return if_true_return_message( $this->service->force($id), force_success() );
    }
}
