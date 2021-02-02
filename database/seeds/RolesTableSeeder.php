<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo('tutorial_create','tutorial_edit', 'tutorial_delete', 'comment_create', 'comment_delete', 'vote_create', 'vote_delete', 'subscription_create', 'subscription_delete' );
        $role = Role::create(['name' => 'moderator']);
        $role->givePermissionTo('tutorial_create','tutorial_edit', 'tutorial_delete', 'comment_create', 'comment_delete', 'vote_create', 'vote_delete', 'subscription_create', 'subscription_delete');
        $role = Role::create(['name' => 'użytkownik']);
        $role->givePermissionTo('tutorial_create','tutorial_edit', 'tutorial_delete', 'comment_create', 'comment_delete', 'vote_create', 'vote_delete', 'subscription_create', 'subscription_delete');
    }
}
