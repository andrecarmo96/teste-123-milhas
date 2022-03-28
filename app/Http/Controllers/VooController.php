<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\VooService;

class VooController extends Controller
{
    protected $service;

    public function __construct(VooService $service)
    {
        $this->service = $service;
    }

    public function getVoosAgrupado(){
        return $this->service->getVoosAgrupado();
    }
}
