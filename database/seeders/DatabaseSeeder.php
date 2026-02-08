<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar usuário admin padrão com role Pastor Geral
        $adminUser = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@igreja.com',
            'password' => Hash::make('password'),
        ]);

        // Criar usuário de teste
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Executar seeders de permissões primeiro
        $this->call([
            RolesSeeder::class,
            PermissionsSeeder::class,
            RolePermissionSeeder::class,
        ]);

        // Atribuir role Pastor Geral ao admin
        $adminUser->assignRole('Pastor Geral');
    }
}
