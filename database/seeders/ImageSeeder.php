<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Promocione;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Categorias
        $this->seedCategoryImages();

        // Productos
      //  $this->seedProductImages();

        // Promociones
      //  $this->seedPromotionImages();
    }

    /**
     * Seed images for categories.
     */
    private function seedCategoryImages(): void
{
    $categorias = [
        'Hamburguesas' => 'hamburguesas.jpg',
        'Pizzas' => 'pizzas.jpg',
        'Salchipapa' => 'salchipapas.jpg',
        'Bebidas' => 'bebidas.jpg',
        'Promociones' => 'promociones.jpg'
    ];

    foreach ($categorias as $nombre => $imagen) {
        $categoria = Categoria::where('nombre_cat', $nombre)->first();
        if ($categoria) {
            $imagePath = "images/categorias/{$imagen}";
            $this->createImage($categoria, $imagePath);
        }
    }
}

    /**
     * Seed images for products.
     */
    /*private function seedProductImages(): void
    {
        $productos = [
            'Producto 1' => 'producto1.jpg',
            'Producto 2' => 'producto2.jpg',
        ];

        foreach ($productos as $nombre => $imagen) {
            $producto = Producto::where('nombre_prod', $nombre)->first();
            if ($producto) {
                $this->createImage($producto, $imagen);
            }
        }
    }

    /**
     * Seed images for promotions.
     */
    /*private function seedPromotionImages(): void
    {
        $promociones = [
            'Promoción 1' => 'promocion1.jpg',
            'Promoción 2' => 'promocion2.jpg',
        ];

        foreach ($promociones as $nombre => $imagen) {
            $promocion = Promocione::where('nombre_promo', $nombre)->first();
            if ($promocion) {
                $this->createImage($promocion, $imagen);
            }
        }
    }

    /**
     * Create an image record.
     */
    private function createImage($model, string $imagen): void
    {
        $imagePath = $imagen;

        if (Storage::disk('public')->exists($imagePath)) {

            $image = Image::create([
                'imageable_type' => get_class($model),
                'imageable_id' => $model->id,
                'path' => $imagePath,
            ]);
    
            if ($image) {
                echo "Image record created for model ID: {$model->id}\n";
            } else {
                echo "Failed to create image record for model ID: {$model->id}\n";
            }
        } else {
            echo "Image file not found: {$imagePath}\n";
        }
    }

    
}
