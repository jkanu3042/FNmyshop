<?php

use App\Member;
use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
    public function run()
    {
        Member::truncate();

        Member::forceCreate([
            'name'=>'MEMBER',
            'email'=>'member@example.com',
            'password'=>bcrypt('secret'),
            'role'=>\App\Role::BASE,
        ]);

        factory(Member::class, 5)->create();
    }
}
