<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class VooRepository
{
    public function __construct(){}

    public function getVoos(){
        return Http::get('http://prova.123milhas.net/api/flights')->collect();
    }
}
