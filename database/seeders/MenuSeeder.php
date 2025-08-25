<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Nasi Kuning',
                'category' => 'Jawa',
                'price' => '15000',
                'image' => 'nasi-kuning-asli.png',
                'desc' => 'Nasi kuning adalah hidangan khas Indonesia berbahan dasar nasi yang dimasak dengan kunyit dan santan, menghasilkan rasa gurih dan aroma harum'
            ],
            [
                'name' => 'Soto Bening',
                'category' => 'Sunda',
                'price' => '20000',
                'image' => 'soto.png',
                'desc' => 'Soto bening adalah sup khas Indonesia dengan kuah jernih berbumbu ringan yang disajikan dengan daging ayam atau sapi dan pelengkap seperti tauge dan seledri'
            ],
            [
                'name' => 'Serabi',
                'category' => 'Jawa',
                'price' => '30000',
                'image' => 'serabi.png',
                'desc' => 'Serabi adalah kue tradisional Indonesia berbahan dasar tepung beras dan santan, yang dimasak di atas tungku dengan tekstur lembut dan pinggiran renyah'
            ],
        ];

        Item::insert($data);
    }
}
