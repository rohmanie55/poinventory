<?php

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class CreateSupplierSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Supplier::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(Supplier::class, 10)->create();
    }
}
