<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class ApiController extends Controller
{
    use ApiResponser;

    public function __construct() {
        //$this->middleware('auth:api');
    }

    protected function allowedAdminAction() {
        if(Gate::denies('admin-action')) {
            throw new AuthorizationException('Esta acción no te es permitida');
        }
    }
}
