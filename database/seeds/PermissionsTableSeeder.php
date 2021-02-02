<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Permission::create(['name' => 'tutorial_create']);
      Permission::create(['name' => 'tutorial_edit']);
      Permission::create(['name' => 'tutorial_delete']);
      Permission::create(['name' => 'comment_create']);
      Permission::create(['name' => 'comment_delete']);
      Permission::create(['name' => 'vote_create']);
      Permission::create(['name' => 'vote_delete']);
      Permission::create(['name' => 'subscription_create']);
      Permission::create(['name' => 'subscription_delete']);
    }
}
