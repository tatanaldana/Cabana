<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Detpromocione;
use App\Models\Detventa;
use App\Models\Matprima;
use App\Models\Pqr;
use App\Models\Producto;
use App\Models\Promocione;
use App\Models\Proveedore;
use App\Models\User;
use App\Models\Venta;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Storage::deleteDirectory('image');
        //Storage::makeDirectory('image');

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
         $this->call(CategoriaSeeder::class);
         $this->call(ProductoSeeder::class);
         $this->call(VentaSeeder::class);
         $this->call(DetventaSeeder::class);
         $this->call(PromocioneSeeder::class);
         $this->call(DetpromocioneSeeder::class);
         $this->call(PqrSeeder::class);
         $this->call(MatprimaSeeder::class);
         $this->call(ProveedoreSeeder::class); 
 
    /*     User::Factory(10)->create()->each(function (User $user){
            Image::factory(1)->create([
                'imageable_id'=>$user->id,
                'imageable_type'=>User::class
            ]);
         });
         Producto::Factory(20)->create()->each(function (Producto $producto){
            Image::factory(1)->create([
                'imageable_id'=>$producto->id,
                'imageable_type'=>Producto::class
            ]);
         });
         Promocione::Factory(10)->create()->each(function (Promocione $promocione){
            Image::factory(1)->create([
                'imageable_id'=>$promocione->id,
                'imageable_type'=>Promocione::class
            ]);
         });
         Detpromocione::Factory(40)->create();
         Venta::factory(10)->create();
         Detventa::factory(30)->create();
         Pqr::factory(10)->create();
         Matprima::factory(10)->create();
         Proveedore::factory(10)->create();
         */
         // User::factory(10)->create();;
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
