<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $nominal_options = [100000, 200000, 300000]; 

        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'tanggal'    => date('Y-m-d', strtotime("+$i days")),
                'nominal'    => $nominal_options[array_rand($nominal_options)],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
        }

        $this->db->table('diskon')->insertBatch($data);
    }
}