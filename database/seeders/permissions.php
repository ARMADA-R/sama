<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a = ['users','roles',  'courses','languages','reports','certificates','search'];
        $b = ['browse','edit','delete','add','view'];
        $c =['access dashboard'];

        foreach ($a as $Aval) {
            foreach ($b as $Bval) {
                Permission::create([
                    'title' => $Bval .' '. $Aval,
                    'code' => $Bval .'-'. $Aval,
                    'group' => $Aval
                ]);
            }
        }
        foreach ($c as $Cval) {
            Permission::create([
                'title' => $Cval,
                'code' => str_replace(' ','-' ,$Cval) ,
                'group' => 'general'
            ]);
        }
    }
}
