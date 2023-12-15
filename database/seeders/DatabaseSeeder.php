<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Config;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Config::create([
            'name' => 'site_name',
            'value' => 'BigOnePanel'
        ]);
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'User',
            'email' => 'demo@demo.com',
            'password' => Hash::make('password'),
            'balance' => 0,
            'phone' => '62812341234',
            'email_verify_status' => 1,
        ]);
        DB::table('roles')->insert([
            'name' => 'Member',
            'total_spend' => 0,
            'total_discount' => 0
        ]);
        \App\Models\Admin::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'super_admin' => 1,
        ]);
        DB::table('pages')->insert(
            [
                [
                    'pages' => "terms-of-services",
                    'content' => '-'
                ],
                [
                    'pages' => "privacy",
                    'content' => '-'
                ],
                [
                    'pages' => "about-us",
                    'content' => '-'
                ],
                [
                    'pages' => "contact-us",
                    'content' => '-'
                ]
            ]
        );
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
