<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class VooRepository
{
    public function __construct(){}

    public function getVoos(){
        return Http::get('http://prova.123milhas.net/api/flights')->collect();
    }

    public function getVoosIda(){
        return Http::get('http://prova.123milhas.net/api/flights')->collect()->where('outbound', 1)->values();
    }

    public function getVoosVolta(){
        return Http::get('http://prova.123milhas.net/api/flights')->collect()->where('inbound', 1)->values();
    }
}
