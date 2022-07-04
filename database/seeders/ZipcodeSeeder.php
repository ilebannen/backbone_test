<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpParser\Node\Scalar\MagicConst\Line;

class ZipcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $content = \File::get(storage_path('CPdescarga.txt'));
        $lines = explode("\n", $content);

        $municipalities = [];
        $federalEntities = [];
        $settlementTypes = [];
        $settlements = [];
        $zipCodes = [];
        $countZips = 1;
        foreach($lines as $i => $line) {
            if ($i<2) continue;
            $line = mb_convert_case($line, MB_CASE_UPPER, "UTF-8");
            //$line = strtr($line,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
            $line = iconv('utf-8', 'us-ascii//TRANSLIT', $line);

            $fields =  explode("|", $line);
            if(count($fields) < 15) continue;
            
            $d_codigo = $fields[0];
            $d_asenta = $fields[1];
            $d_tipo_asenta = $fields[2];
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
                \DB::table('municipalities')->insert([
                    'id' => intval($c_mnpio),
                    'name' => $D_mnpio,
                ]);
                $municipalities[$c_mnpio] = true;
            }

            if (!isset($federalEntities[$c_estado])) {
                \DB::table('federal_entities')->insert([
                    'id' => intval($c_estado),
                    'name' => $d_estado,
                    'code' => strlen($c_CP)==0 ? null:$c_CP,
                ]);
                $federalEntities[$c_estado] = true;
            }

            if (!isset($zipCodes[$d_codigo])) {
                \DB::table('zipcodes')->insert([
                    'id' => $countZips,
                    'zip_code' => $d_codigo,
                    'locality' => $d_ciudad,
                    'federal_entity_id' => intval($c_estado),
                    'municipality_id' => intval($c_mnpio),
                ]);
                $zipCodes[$d_codigo] = $countZips++;
            }

            if (!isset($settlementTypes[$c_tipo_asenta])) { 
                \DB::table('settlements_types')->insert([
                    'id' => intval($c_tipo_asenta),
                    'name' => $d_tipo_asenta,
                ]);
                $settlementTypes[$c_tipo_asenta] = true;
            }

            if (!isset($settlements[$id_asenta_cpcons])) { 
                \DB::table('settlements')->insert([
                    'id' => intval($id_asenta_cpcons),
                    'name' => $d_asenta,
                    'zone_type' => $d_zona,
                    'settlement_type_id' => intval($c_tipo_asenta)
                ]);
                $settlements[$id_asenta_cpcons] = true;
            }

            \DB::table('zipcode_settlement')->insert([
                'zipcode_id' => $zipCodes[$d_codigo],
                'settlement_id' => intval($id_asenta_cpcons)
            ]);
        }
    }
}
