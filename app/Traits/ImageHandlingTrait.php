<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

trait ImageHandlingTrait
{
    private $modelDimensions = [
        'productos' => ['width' => 800, 'height' => 600],
        'categorias' => ['width' => 400, 'height' => 300],
        'promociones' => ['width' => 1200, 'height' => 800],
        'users' => ['width' => 300, 'height' => 300],
    ];
    /**
     * Resolve the model instance based on type and ID.
     */
    private function resolveModel(string $modelType, int $modelId)
    {
        $modelClasses = [
            'productos' => \App\Models\Producto::class,
            'categorias' => \App\Models\Categoria::class,
            'promociones' => \App\Models\Promocione::class,
            'users' => \App\Models\User::class,
        ];

        if (!array_key_exists($modelType, $modelClasses)) {
            throw new \InvalidArgumentException('Tipo de modelo no válido');
        }

        return $modelClasses[$modelType]::findOrFail($modelId);
    }

    /**
     * Resolve the model class based on type.
     */
    private function resolveModelClass(string $modelType)
    {
        $modelClasses = [
            'productos' => \App\Models\Producto::class,
            'categorias' => \App\Models\Categoria::class,
            'promociones' => \App\Models\Promocione::class,
            'users' => \App\Models\User::class,
        ];

        if (!array_key_exists($modelType, $modelClasses)) {
            throw new \InvalidArgumentException('Tipo de modelo no válido');
        }

        return $modelClasses[$modelType];
    }

    /**
     * Delete the image and handle storage.
     */
    private function deleteImageFile(Image $image): void
    {
        $path = $image->path;
    
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function deleteImage(Image $image): void
    {
        $this->deleteImageFile($image);
        $image->delete();
    }

    /**
     * Get the URL of the image.
     */
    public function getImageUrl(Image $image)
    {
        $url = Storage::url($image->path); // Obtén la URL completa para mostrar
        
        return response()->json([
            'url' => $url
        ], Response::HTTP_OK);
    }
    /**
     * Resize the image if needed based on the model type.
     */
    private function resizeImageIfNeeded($imageFile, string $modelType)
    {
        // Verifica si el modelo es válido
        if (!array_key_exists($modelType, $this->modelDimensions)) {
            throw new \InvalidArgumentException('Tipo de modelo no válido para redimensionamiento');
        }
    
        // Obtener las dimensiones específicas para el modelo
        $dimensions = $this->modelDimensions[$modelType];
        $maxWidth = $dimensions['width'];
        $maxHeight = $dimensions['height'];
    
        // Crear una instancia del ImageManager con el driver 'gd'
        $manager = ImageManager::gd();
    
        // Crear una instancia de la imagen usando el ImageManager
        $imageInstance = $manager->read($imageFile);
    
        // Obtener las dimensiones actuales de la imagen
        $width = $imageInstance->width();
        $height = $imageInstance->height();
    
        // Redimensionar la imagen solo si es más grande que las dimensiones máximas
        if ($width > $maxWidth || $height > $maxHeight) {
            $imageInstance->resize($maxWidth, $maxHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }
    
        return $imageInstance;
    }
}
