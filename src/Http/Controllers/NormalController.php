<?php

namespace Samirz\Super\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Samirz\Super\Services\SamirzService;

class NormalController extends Controller
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
        'create'    => 'records.create',
        'show'      => 'records.show',
        'edit'      => 'records.edit',
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
        return view($this->views['create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $request = app($this->store_request);
        $this->service->create($request->all());

        return back()->with('success', 'Record Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record     = $this->singular;
        $data       = $this->service->repository()->getRecord($id);
        $$record    = $data;

        return view($this->views['show'], compact($record));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record     = $this->singular;
        $data       = $this->service->repository()->getRecord($id);
        $$record    = $data;

        return view($this->views['edit'], compact($record));
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
        $this->service->update($id, $request->all());

        return back()->with('success', 'Record Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->service->delete($id);
        return back()->with('success', 'Record Deleted Successfully');
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
        $this->service->restore($id);
        return back();
    }

    /**
     * Force Delete the record from model table
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function force($id)
    {
        $this->service->force($id);
        return back();
    }
}
