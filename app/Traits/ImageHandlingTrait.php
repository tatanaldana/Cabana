<?php

namespace App\Traits;

use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

trait ImageHandlingTrait
{
    private $modelDimensions = [
        'productos' => ['width' => 400, 'height' => 200],
        'categorias' => ['width' => 400, 'height' => 200],
        'promociones' => ['width' => 400, 'height' => 200],
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
     * Maneja la visualización de imágenes para el modelo 'User'.
     */
    private function handleUserImages($model, $imageId)
    {
        // Obtener la imagen asociada al usuario
        $existingImage = $model->image; // Asumiendo que $model->image es una instancia de Image

        // Si se proporciona $imageId, verifica que coincida con la imagen del usuario
        if ($imageId) {
            if ($existingImage && $existingImage->id == $imageId) {
                $this->authorize('view', $existingImage);
                return response()->json([
                    'message' => 'Imagen obtenida exitosamente',
                    'data' => new ImageResource($existingImage)
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'Imagen no encontrada',
                ], Response::HTTP_NOT_FOUND);
            }
        }

        // Si no se proporciona $imageId, devuelve la imagen asociada al usuario
        if ($existingImage) {
            $this->authorize('view', $existingImage);
            return response()->json([
                'message' => 'Imagen obtenida exitosamente',
                'data' => new ImageResource($existingImage)
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'Imagen no encontrada',
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Maneja la visualización de imágenes para otros modelos.
     */
    private function handleGeneralImages($model, $imageId)
    {
        if (method_exists($model, 'images')) {
            // Relación uno a muchos
            if ($imageId) {
                $existingImage = $model->images()->findOrFail($imageId);
                return response()->json([
                    'message' => 'Imagen obtenida exitosamente',
                    'data' => new ImageResource($existingImage)
                ], Response::HTTP_OK);
            }
            $existingImages = $model->images;
            return response()->json([
                'message' => 'Imagenes obtenidas exitosamente',
                'data' => ImageResource::collection($existingImages)
            ], Response::HTTP_OK);
        }

        if (method_exists($model, 'image')) {
            // Relación uno a uno
            $existingImage = $model->image;
            return response()->json([
                'message' => 'Imagen obtenida exitosamente',
                'data' => new ImageResource($existingImage)
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'El modelo no tiene métodos de imágenes',
        ], Response::HTTP_BAD_REQUEST);
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
