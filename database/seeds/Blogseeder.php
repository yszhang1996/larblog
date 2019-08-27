<?php

use Illuminate\Database\Seeder;

class Blogseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\Blog::class,200)->create();
    }
}
