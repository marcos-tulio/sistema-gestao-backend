<?php

namespace Database\Seeders;

use App\Models\Procedure;
use Illuminate\Database\Seeder;

class ProcedureSeeder extends Seeder {

    public function run(): void {
        // Consulta Médica
        Procedure::create(['name' => 'Consulta Médica'])
            ->setMaterials([
                ['id' => 39, 'quantityUsed' => 1],
                ['id' => 37, 'quantityUsed' => 1],
                ['id' => 38, 'quantityUsed' => 2],
                ['id' => 40, 'quantityUsed' => 1],
            ])
            ->save();

        // Consultoria
        Procedure::create(['name' => 'Consultoria'])
            ->setMaterials([
                ['id' => 39, 'quantityUsed' => 1],
                ['id' => 37, 'quantityUsed' => 1],
                ['id' => 38, 'quantityUsed' => 2],
                ['id' => 40, 'quantityUsed' => 1],
            ])
            ->save();


        // Toxina Botulínica Full Face/ Bruxismo (50ui)
        Procedure::create(['name' => 'Toxina Botulínica Full Face/ Bruxismo (50ui)'])
            ->setMaterials([
                ['id' => 19, 'quantityUsed' => 4],
                ['id' => 35, 'quantityUsed' => 1],
                ['id' =>  2, 'quantityUsed' => 2],
                ['id' =>  1, 'quantityUsed' => 2],
                ['id' => 20, 'quantityUsed' => 2],
                ['id' => 64, 'quantityUsed' => 1],
                ['id' => 26, 'quantityUsed' => 2],
                ['id' => 41, 'quantityUsed' => 2],
                ['id' => 42, 'quantityUsed' => 1],
                ['id' =>  4, 'quantityUsed' => 1],
            ])
            ->save();
    }
}
