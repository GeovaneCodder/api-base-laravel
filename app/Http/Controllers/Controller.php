<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $request;

    /**
     * @method __construct
     * @param Illuminate\Http\Request
     * @return void
     * 
     * Criamo um unico ciclo para as requisições de entrada,
     * assim podemos recuperar em todos os outros controladores.
     */
    public function __construct(Request $r)
    {
        $this->request = $r;
    }
}
