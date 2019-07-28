<?php

namespace Samirz\Super\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

class SamirzController extends Controller
{
    /**
     * The Model Class
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The Controller Constructor
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Display the resource index
     *
     * @return void
     */
    public function index()
    {
        //
    }
}
