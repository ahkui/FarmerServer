<?php

use Illuminate\Database\Seeder;

// use AllDataVer1;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GoogleApiKeys::class);
        $this->call(AllDataVersionOne::class);
    }
}
