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

    public function getVoos(){
        return $this->service->getVoos();
    }

    public function getVoosIda(){
        return $this->service->getVoosIda();
    }

    public function getVoosVolta(){
        return $this->service->getVoosVolta();
    }

    public function getVoosAgrupado(){
        return $this->service->getVoosAgrupado();
    }
}
