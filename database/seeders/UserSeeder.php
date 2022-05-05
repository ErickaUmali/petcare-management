<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->create([
                'firstname' => 'Ericka',
                'lastname' => 'Umali',
                'username' => 'admin',
                'contact' => '09657669976',
                'password' => bcrypt('admin123'),
                'role' => 1,
            ]);

        User::factory()
            ->count(3)
            ->create([
                'role' => 2,
            ]);

        $profiles = Storage::files('public/profiles/user');

        foreach ($profiles as $profile) {
            User::factory()
                ->create([
                    'role' => 3,
                    'profile' => $profile,
                ]);
        }
    }
}
