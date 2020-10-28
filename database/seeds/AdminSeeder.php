<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Webkul\User\Models\Admin::updateOrCreate([
            'name' => 'David',
            'email' => 'david@dgitts.com',
            'password' => '$2y$10$6ARaKDBf8QhfHZwDwDM6TOX9BtQp8wsoYWwzQdeoPP7IiuvtAZx4G',
            'status' => 1,
            'role_id' => 1
        ]);
    }
}
