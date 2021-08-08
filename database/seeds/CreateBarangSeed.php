<?php

use Illuminate\Database\Seeder;
use App\Models\Goods;
use Illuminate\Support\Facades\DB;

class CreateBarangSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Goods::class, 20)->create();
    }
}
