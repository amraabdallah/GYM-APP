<?php

namespace Database\Seeders;

use App\Models\TrainingPackage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'System Administrator',
            'password' => Hash::make('123456'),
            'email' => 'admin@admin.com',
        ]);
        for($i = 0;$i<10;$i++){
            TrainingPackage::factory()->create([
                'created_by' => $user->id
            ]);
        }
        $user->assignRole('admin');
    }
}
