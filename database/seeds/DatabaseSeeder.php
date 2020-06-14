<?php

use Illuminate\Database\Seeder;
use App\ModuloAtencion;
use App\Tramite;
use App\Horario;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('password_resets')->delete();
        ModuloAtencion::create([
            'Nombre' => 'Oficina Central Insurgentes',
            'Direccion' => 'Insurgentes 860, Napoles. CDMX'
        ]);
        ModuloAtencion::create([
            'Nombre' => 'Módulo Móvil 30',
            'Direccion' => 'Av. Universidad 3000, Ciudad Universitaria. CDMX'
        ]);
        ModuloAtencion::create([
            'Nombre' => 'Módulo Móvil 18',
            'Direccion' => 'Av. Canal de Tezontle 118, Alfonso Ortiz Tirado. CDMX'
        ]);
        Tramite::create([
            'Nombre' => 'Reposición de Tarjeta de Circulación',
            'Prioridad' => 1
        ]);
        Tramite::create([
            'Nombre' => 'Renovación de Tarjeta de Circulación',
            'Prioridad' => 2
        ]);
        Horario::create([
            'tipo_dia' => 'habil',
            'hora_inicio' => 540,
            'hora_fin' => 900,
            'descripcion' => 'Horario de servicio en dias habiles'
        ]);
        // $this->call(UsersTableSeeder::class);
    }
}
