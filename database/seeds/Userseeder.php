<?php

use Illuminate\Database\Seeder;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class,100)->create();
        $user = \App\User::find(1);
        $user->name='夜笙';
        $user->email='yszhang1996@outlook.com';
        $user->password=bcrypt('121212');
        $user->is_admin=true;
        $user->save();
        $user = \App\User::find(2);
        $user->name='夜笙丶';
        $user->email='1111@qq.com';
        $user->password=bcrypt('121212');
        $user->save();
    }
}
