<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class ZipJsonGenerator 
{
    public static function generate() {
        $content = \File::get(storage_path('CPdescarga.txt'));
        $lines = explode("\n", $content);

        $municipalities = [];
        $federalEntities = [];
        $settlementTypes = [];
        $settlements = [];
        $zipCodes = [];
        $countZips = 1;
        $countSettlements = 1;
        foreach($lines as $i => $line) {
            if ($i<2) continue;
            $line = mb_convert_case($line, MB_CASE_UPPER, "UTF-8");
            $line = iconv('utf-8', 'us-ascii//TRANSLIT', $line);

            $fields =  explode("|", $line);
            if(count($fields) < 15) continue;
            
            $d_codigo = $fields[0];
            $d_asenta = $fields[1];
            $d_tipo_asenta = ucfirst(strtolower($fields[2]));
            $D_mnpio = $fields[3];
            $d_estado = $fields[4];
            $d_ciudad = $fields[5];
            $d_CP = $fields[6];
            $c_estado = $fields[7];
            $c_oficina = $fields[8];
            $c_CP = $fields[9];
            $c_tipo_asenta = $fields[10];
            $c_mnpio = $fields[11];
            $id_asenta_cpcons = $fields[12];
            $d_zona = $fields[13];
            $c_cve_ciudad = $fields[14];

            if (!isset($municipalities[$c_mnpio])) {
                $municipalities[$c_mnpio] = [
                    'key' => intval($c_mnpio),
                    'name' => $D_mnpio,
                ];
            }

            if (!isset($federalEntities[$c_estado])) {
                $federalEntities[$c_estado] = [
                    'key' => intval($c_estado),
                    'name' => $d_estado,
                    'code' => strlen($c_CP)==0 ? null:$c_CP,
                ];
            }

            if (!isset($zipCodes[$d_codigo])) {
                $zipCodes[$d_codigo] = [
                    //'id' => $countZips,
                    'zip_code' => $d_codigo,
                    'locality' => $d_ciudad,
                    'federal_entity' => $federalEntities[$c_estado],
                    'municipality' => $municipalities[$c_mnpio],
                    'settlements' => []
                ];
                $countZips++;
            }

            if (!isset($settlementTypes[$c_tipo_asenta])) { 
                $settlementTypes[$c_tipo_asenta] = [
                    //'id' => intval($c_tipo_asenta),
                    'name' => $d_tipo_asenta,
                ];
            }

            $zipCodes[$d_codigo]['settlements'][] = [
                'key' => intval($id_asenta_cpcons),
                'name' => $d_asenta,
                'zone_type' => $d_zona,
                'settlement_type' => $settlementTypes[$c_tipo_asenta]
            ];

            $countSettlements++;
        }

        foreach($zipCodes as $zc) {
            Redis::set('zips:'.$zc['zip_code'], json_encode($zc));
        }
    }
}