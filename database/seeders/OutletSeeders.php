<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;
use App\Models\Outlet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OutletSeeders extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
 
        Outlet::insert([
            [
                'nama' => 'PT. Gedang Kepok ',
                'alamat' => 'Malang'
            ]
        ]);
        // DB::table('Outlet')->insert([
        //     'nama' => 'PT. Gedang Kepok',
        //     'alamat' => 'Malang'
        // ]);
    }
}