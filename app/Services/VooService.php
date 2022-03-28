<?php

namespace App\Services;

use App\Repositories\VooRepository;

class VooService {
    private $repository;

    public function __construct(VooRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getVoos()
    {
        try {
            return response()->json(
                [
                    'data' => $this->repository->getVoos(),
                    'status' => true,
                ],
                200
            );
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'error' => $e->getMessage(),
                    'status' => false,
                ],
                500
            );
        }
    }

    public function getVoosIda()
    {
        try {
            return response()->json(
                [
                    'data' => $this->repository->getVoosIda(),
                    'status' => true,
                ],
                200
            );
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'error' => $e->getMessage(),
                    'status' => false,
                ],
                500
            );
        }
    }

    public function getVoosVolta()
    {
        try {
            return response()->json(
                [
                    'data' => $this->repository->getVoosVolta(),
                    'status' => true,
                ],
                200
            );
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'error' => $e->getMessage(),
                    'status' => false,
                ],
                500
            );
        }
    }
    
    public function getVoosAgrupado(){
        try {
            $voos = $this->repository->getVoos();

            $idsGrupos = [];
            $grupos = [];
            
            foreach ($voos as $key => $value) {
                
                $id_grupo = isset($idsGrupos[$value['fare']]) ? $idsGrupos[$value['fare']] : $idsGrupos[$value['fare']] = count($idsGrupos) + 1;

                if(!isset($grupos[$id_grupo])){
                    $grupos[$id_grupo] = [
                        'uniqueId' => $id_grupo,
                        'totalPrice' => $value['price'],
                        'outbound' => $value['outbound'] == 1 ? [$value['id']] : [],
                        'inbound' => $value['inbound'] == 1 ? [$value['id']] : [],
                    ];
                }else{
                    $grupos[$id_grupo]['totalPrice'] += $value['price'];
                    if($value['outbound']){
                        $grupos[$id_grupo]['outbound'][] = $value['id'];
                    }else{
                        $grupos[$id_grupo]['inbound'][] = $value['id'];
                    }
                }
            }
            
            $grupos = collect($grupos)->sortBy('totalPrice');
            $cheapest = $grupos->first();
            $retorno = [
                'flights' => $voos,
                'groups' => $grupos,
                'totalGroups' => $grupos->count(),
                'totalFlights' => $voos->count(),
                'cheapestPrice' => $cheapest['totalPrice'],
                'cheapestGroup' => $cheapest['uniqueId'],
            ];

            return response()->json(
                [
                    'data' => $retorno,
                    'status' => true,
                ],
                200
            );
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'error' => $e->getMessage(),
                    'status' => false,
                ],
                500
            );
        }
    }
}
