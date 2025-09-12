<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder {

    public function run(): void {
        Material::factory()->create([
            'name'          => 'Agulha hipodérmica 30x0,70 22g (Apiração)',
            'quantity'      => 100,
            'unit'          => 'un.',
            'purchasePrice' => 14.67,
            'unitCost'      => 0.15
        ]);

        Material::factory()->create([
            'name'          => 'Seringa Insulina 1mL',
            'quantity'      => 100,
            'unit'          => 'un.',
            'purchasePrice' => 33.42,
            'unitCost'      => 0.33
        ]);

        Material::factory()->create([
            'name'          => 'Cartucho Dermafusion',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 279.00,
            'unitCost'      => 27.90
        ]);

        Material::factory()->create([
            'name'          => 'Dysport 500',
            'quantity'      => 8,
            'unit'          => 'mL',
            'purchasePrice' => 1902.22,
            'unitCost'      => 237.78
        ]);

        Material::factory()->create([
            'name'          => 'Restylane Refine',
            'quantity'      => 1,
            'unit'          => 'un.',
            'purchasePrice' => 243.33,
            'unitCost'      => 243.33
        ]);

        Material::factory()->create([
            'name'          => 'Restylane Kiss',
            'quantity'      => 2,
            'unit'          => 'un.',
            'purchasePrice' => 864.44,
            'unitCost'      => 432.22
        ]);

        Material::factory()->create([
            'name'          => 'Restylane Lift',
            'quantity'      => 2,
            'unit'          => 'un.',
            'purchasePrice' => 886.66,
            'unitCost'      => 443.33
        ]);

        Material::factory()->create([
            'name'          => 'L-Cartinina 600mg',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 77.00,
            'unitCost'      => 7.70
        ]);

        Material::factory()->create([
            'name'          => 'EGF 1% + IGF 1%',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 57.10,
            'unitCost'      => 5.71
        ]);

        Material::factory()->create([
            'name'          => 'Cooper Peptídeo 10mg',
            'quantity'      => 20,
            'unit'          => 'un.',
            'purchasePrice' => 97.40,
            'unitCost'      => 4.87
        ]);

        Material::factory()->create([
            'name'          => 'Vitamina B3 (niacinamida)',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 39.00,
            'unitCost'      => 3.90
        ]);

        Material::factory()->create([
            'name'          => 'L-Prolina 500mg',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 84.10,
            'unitCost'      => 8.41
        ]);

        Material::factory()->create([
            'name'          => 'L-Metionina 100mg',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 45.00,
            'unitCost'      => 4.50
        ]);

        Material::factory()->create([
            'name'          => 'EGF 1% + IGF 1% + TGFB3 1%',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 57.10,
            'unitCost'      => 5.71
        ]);

        Material::factory()->create([
            'name'          => 'Minoxidil 5%',
            'quantity'      => 20,
            'unit'          => 'un.',
            'purchasePrice' => 114.00,
            'unitCost'      => 5.70
        ]);

        Material::factory()->create([
            'name'          => 'Biotina 10mg',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 44.40,
            'unitCost'      => 4.44
        ]);

        Material::factory()->create([
            'name'          => 'Ac. Alfalipólico 300mg',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 116.25,
            'unitCost'      => 11.63
        ]);

        Material::factory()->create([
            'name'          => 'CoQ10 100mg',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 193.76,
            'unitCost'      => 19.38
        ]);

        Material::factory()->create([
            'name'          => 'Luva de Vinil',
            'quantity'      => 1000,
            'unit'          => 'un.',
            'purchasePrice' => 170.82,
            'unitCost'      => 0.17
        ]);

        Material::factory()->create([
            'name'          => 'Agulha Lebel Mesodérmica 0,23x4mm',
            'quantity'      => 100,
            'unit'          => 'un.',
            'purchasePrice' => 126.78,
            'unitCost'      => 1.27
        ]);

        Material::factory()->create([
            'name'          => 'Lidocaina 2% + Epinefrina 1:100',
            'quantity'      => 50,
            'unit'          => 'un.',
            'purchasePrice' => 243.55,
            'unitCost'      => 4.87
        ]);

        Material::factory()->create([
            'name'          => 'Luva Cirúrgicas',
            'quantity'      => 2,
            'unit'          => 'un.',
            'purchasePrice' => 9.86,
            'unitCost'      => 4.93
        ]);

        Material::factory()->create([
            'name'          => 'Fita Cirúrgica Microporosa',
            'quantity'      => 6,
            'unit'          => 'un.',
            'purchasePrice' => 43.07,
            'unitCost'      => 7.18
        ]);

        Material::factory()->create([
            'name'          => 'Punch 4mm',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 154.00,
            'unitCost'      => 15.40
        ]);

        Material::factory()->create([
            'name'          => 'Bisturi Descartável',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 21.00,
            'unitCost'      => 2.10
        ]);

        Material::factory()->create([
            'name'          => 'Rioex Clorexina Aquosa',
            'quantity'      => 1000,
            'unit'          => 'mL',
            'purchasePrice' => 57.39,
            'unitCost'      => 0.06
        ]);

        Material::factory()->create([
            'name'          => 'Vitamina D3 600ui',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 202.40,
            'unitCost'      => 20.24
        ]);

        Material::factory()->create([
            'name'          => 'Metilcobalamina 2500mcg',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 251.90,
            'unitCost'      => 25.19
        ]);

        Material::factory()->create([
            'name'          => 'Vitamina B6 (Piridoxina)',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 42.90,
            'unitCost'      => 4.29
        ]);

        Material::factory()->create([
            'name'          => 'D-Pantenol 40mg',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 36.40,
            'unitCost'      => 3.64
        ]);

        Material::factory()->create([
            'name'          => 'L-Taurina 10%',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 38.10,
            'unitCost'      => 3.81
        ]);

        Material::factory()->create([
            'name'          => 'IGF 1% + BFGF 1% + VEGF 1% + Cooper Peptídeo 1%',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 62.70,
            'unitCost'      => 6.27
        ]);

        Material::factory()->create([
            'name'          => 'Dimetilsulfóxido 99,99%',
            'quantity'      => 10,
            'unit'          => 'un.',
            'purchasePrice' => 39.40,
            'unitCost'      => 3.94
        ]);

        Material::factory()->create([
            'name'          => 'Kit Sutura Descartável',
            'quantity'      => 2,
            'unit'          => 'un.',
            'purchasePrice' => 172.84,
            'unitCost'      => 86.42
        ]);

        Material::factory()->create([
            'name'          => 'Gase Estéril Fio 13',
            'quantity'      => 100,
            'unit'          => 'un.',
            'purchasePrice' => 133.74,
            'unitCost'      => 1.34
        ]);

        Material::factory()->create([
            'name'          => 'Gase Não Estéril',
            'quantity'      => 200,
            'unit'          => 'un.',
            'purchasePrice' => 78.52,
            'unitCost'      => 0.39
        ]);

        Material::factory()->create([
            'name'          => 'Sacola de Papel',
            'quantity'      => 100,
            'unit'          => 'un.',
            'purchasePrice' => 870.00,
            'unitCost'      => 8.70
        ]);

        Material::factory()->create([
            'name'          => 'Papel Timbrado',
            'quantity'      => 500,
            'unit'          => 'un.',
            'purchasePrice' => 250.00,
            'unitCost'      => 0.50
        ]);

        Material::factory()->create([
            'name'          => 'Envelope',
            'quantity'      => 100,
            'unit'          => 'un.',
            'purchasePrice' => 105.00,
            'unitCost'      => 1.05
        ]);

        Material::factory()->create([
            'name'          => 'Cartão Fidelidade',
            'quantity'      => 50,
            'unit'          => 'un.',
            'purchasePrice' => 385.00,
            'unitCost'      => 7.70
        ]);

        Material::factory()->create([
            'name'          => 'Anestésico Tópico (Dermomax)',
            'quantity'      => 80,
            'unit'          => 'g',
            'purchasePrice' => 62.46,
            'unitCost'      => 0.78
        ]);

        Material::factory()->create([
            'name'          => 'Flyers',
            'quantity'      => 700,
            'unit'          => 'un.',
            'purchasePrice' => 321.34,
            'unitCost'      => 0.46
        ]);

        Material::factory()->create([
            'name'          => 'Uréia 20%',
            'quantity'      => 30,
            'unit'          => 'mL',
            'purchasePrice' => 49.90,
            'unitCost'      => 1.66
        ]);

        Material::factory()->create([
            'name'          => 'Ácido Retinoico 8%',
            'quantity'      => 30,
            'unit'          => 'g',
            'purchasePrice' => 93.00,
            'unitCost'      => 3.10
        ]);

        Material::factory()->create([
            'name'          => 'Alcool 70%',
            'quantity'      => 5000,
            'unit'          => 'mL',
            'purchasePrice' => 65.69,
            'unitCost'      => 0.01
        ]);

        Material::factory()->create([
            'name'          => 'Cotonetes De Maquiagem',
            'quantity'      => 80,
            'unit'          => 'un.',
            'purchasePrice' => 11.04,
            'unitCost'      => 0.14
        ]);

        Material::factory()->create([
            'name'          => 'ATA 30%',
            'quantity'      => 30,
            'unit'          => 'mL',
            'purchasePrice' => 10.30,
            'unitCost'      => 0.34
        ]);

        Material::factory()->create([
            'name'          => 'Cromóforo Tópico',
            'quantity'      => 30,
            'unit'          => 'g',
            'purchasePrice' => 43.25,
            'unitCost'      => 1.44
        ]);

        Material::factory()->create([
            'name'          => 'Agulha Infiltração 40x12mm 18G',
            'quantity'      => 100,
            'unit'          => 'un.',
            'purchasePrice' => 10.49,
            'unitCost'      => 0.10
        ]);

        Material::factory()->create([
            'name'          => 'Triancinolona 20mg/mL',
            'quantity'      => 5,
            'unit'          => 'mL',
            'purchasePrice' => 132.49,
            'unitCost'      => 26.50
        ]);

        Material::factory()->create([
            'name'          => 'Aluguel Ultraformer',
            'quantity'      => 6,
            'unit'          => 'un.',
            'purchasePrice' => 1300.00,
            'unitCost'      => 216.67
        ]);

        Material::factory()->create([
            'name'          => 'Disparo Ultraformer',
            'quantity'      => 1,
            'unit'          => 'un.',
            'purchasePrice' => 189.00,
            'unitCost'      => 189.00
        ]);

        Material::factory()->create([
            'name'          => 'Lavieen',
            'quantity'      => 6,
            'unit'          => 'un.',
            'purchasePrice' => 1450.00,
            'unitCost'      => 241.67
        ]);

        Material::factory()->create([
            'name'          => 'Técnica de Máquinas',
            'quantity'      => 6,
            'unit'          => 'un.',
            'purchasePrice' => 300.00,
            'unitCost'      => 50.00
        ]);

        Material::factory()->create([
            'name'          => 'Etherean',
            'quantity'      => 6,
            'unit'          => 'un.',
            'purchasePrice' => 1400.00,
            'unitCost'      => 233.33
        ]);

        Material::factory()->create([
            'name'          => 'Melora C Monoderma',
            'quantity'      => 1,
            'unit'          => 'un.',
            'purchasePrice' => 230.00,
            'unitCost'      => 230.00
        ]);

        Material::factory()->create([
            'name'          => 'Firmalize AOX',
            'quantity'      => 1,
            'unit'          => 'un.',
            'purchasePrice' => 150.00,
            'unitCost'      => 150.00
        ]);

        Material::factory()->create([
            'name'          => 'Heliomax Claro',
            'quantity'      => 1,
            'unit'          => 'un.',
            'purchasePrice' => 60.00,
            'unitCost'      => 60.00
        ]);
    }
}
