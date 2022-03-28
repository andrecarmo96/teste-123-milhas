<?php

namespace App\Services;

use App\Repositories\VooRepository;

class VooService {
    private $repository;

    public function __construct(VooRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getVoosAgrupado(){
        try {
            $voos = $this->repository->getVoos();

            $idsGrupos = [];
            $grupos = [];
            $cheapestPrice = '';
            $cheapestGroup = '';
            
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
                    $grupos[$id_grupo]['totalPrice'] += floatval($value['price']);
                    if($value['outbound']){
                        $grupos[$id_grupo]['outbound'][] = $value['id'];
                    }else{
                        $grupos[$id_grupo]['inbound'][] = $value['id'];
                    }
                }
            }

            foreach ($grupos as $key => $value) {
                if(!$cheapestPrice){
                    $cheapestPrice = $value['totalPrice'];
                    $cheapestGroup = $value['uniqueId'];
                }    

                $cheapestPrice = $value['totalPrice'] < $cheapestPrice ? $value['totalPrice'] : $cheapestPrice;
                $cheapestGroup = $value['totalPrice'] < $cheapestPrice ? $value['uniqueId'] : $cheapestGroup;
            }
            
            $grupos = collect($grupos)->sortBy('totalPrice');
            $retorno = [
                // 'flights' => $voos,
                'groups' => $grupos->sortBy('totalPrice'),
                'totalGroups' => $grupos->count(),
                'totalFlights' => $voos->count(),
                'cheapestPrice' => $cheapestPrice,
                'cheapestGroup' => $cheapestGroup,
            ];
            
            return response()->json($retorno, 200);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
