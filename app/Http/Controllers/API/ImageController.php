<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api')->except(['index', 'show']);
       // $this->middleware(['scope:admin', 'permission:create general'])->only('store');
        //$this->middleware(['scope:admin,cliente', 'permission:edit general|edicion parcial'])->only('update');
       // $this->middleware(['scope:admin,cliente', 'permission:delete general|Eliminacion parcial'])->only('destroy');
    }

    /**
     * Display a listing of the images for a specific model (one-to-many).
     */
    public function index(string $modelType)
    {
        $modelClass = $this->resolveModelClass($modelType);

        if (method_exists($modelClass, 'images')) {
            $models = $modelClass::with('images')->get(); 
            $images = $models->flatMap(fn($model) => $model->images);
        } elseif (method_exists($modelClass, 'image')) {
            $models = $modelClass::with('image')->get();
            $images = $models->map(fn($model) => $model->image)->filter();
        } else {
            return response()->json([
                'message' => 'El modelo no tiene métodos de imágenes',
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'data' => ImageResource::collection($images)
        ], Response::HTTP_OK);
    }
    /**
     * Display the specified image.
     */
    public function show(string $modelType, int $modelId, $imageId = null)
    {
        $model = $this->resolveModel($modelType, $modelId);
    
        if (method_exists($model, 'images')) {
            if ($imageId) {
                $existingImage = $model->images()->findOrFail($imageId);
                $imageResource = new ImageResource($existingImage);
            } else {
                $existingImages = $model->images;
                $imageResource = ImageResource::collection($existingImages);
            }
        } elseif (method_exists($model, 'image')) {
            $existingImage = $model->image;
            $imageResource = new ImageResource($existingImage);
        } else {
            return response()->json([
                'message' => 'El modelo no tiene métodos de imágenes',
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'message' => 'Imagenes obtenidas exitosamente',
            'data' => $imageResource
        ], Response::HTTP_OK);
    }
    
    /**
     * Store a newly created image in storage.
     */
    public function store(ImageRequest $request)
    {
        //$this->authorize('create', Image::class);
        $data = $request->validated();

        $model = $this->resolveModel($data['imageable_type'], $data['imageable_id']);
        
        if (method_exists($model, 'image')) {
            $existingImage = $model->image;
            if ($existingImage) {
                return response()->json([
                    'message' => 'Ya hay una imagen asiganada, por favor actualicela o eliminela'
                ], Response::HTTP_BAD_REQUEST);
            }
        }

        $modelTypeFolder = strtolower(class_basename($data['imageable_type']));

        $path = $request->file('image')->store("images/{$modelTypeFolder}", 'public');

        if (method_exists($model, 'images')) {
            $image = $model->images()->create([
                'path' => $path,
            ]);
        } elseif (method_exists($model, 'image')) {
            $image = $model->image()->create([
                'path' => $path,
            ]);
        }
        return response()->json([
            'message' => 'Imagen creada exitosamente',
            'data' => new ImageResource($image)
        ], Response::HTTP_CREATED);
    }
    /**
     * Update the specified image (one-to-many).
     */
    public function updateImage(ImageRequest $request, Image $image)
    {
        $data = $request->validated();

        $modelTypeFolder = strtolower(class_basename($data['imageable_type']));
        $path = $request->file('image')->store("images/{$modelTypeFolder}", 'public');
        
        $model = $this->resolveModel($data['imageable_type'], $data['imageable_id']);

        if (method_exists($model, 'images')) {
            $existingImage =$model->images()->findOrFail($image->id);
        } elseif (method_exists($model, 'image')) {
            $existingImage = $model->image;
        } else {
            return response()->json([
                'message' => 'El modelo no tiene método de imágenes',
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($existingImage) {

            $this->deleteImageFile($existingImage);

            $existingImage->update(['path' => $path]);
            
            return response()->json([
                'message' => 'Imagen actualizada exitosamente',
                'data' => new ImageResource($existingImage)
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'Imagen no encontrada',
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified image (one-to-many).
     */
    public function destroyImage(string $modelType, int $modelId, int $imageId)
    {
        $model = $this->resolveModel($modelType, $modelId);
    
        if (method_exists($model, 'images')) {
            if ($imageId) {
                $image = $model->images()->find($imageId);
            } else {
                return response()->json([
                    'message' => 'ID de imagen no proporcionado'
                ], Response::HTTP_BAD_REQUEST);
            }
        } elseif (method_exists($model, 'image')) {
            $image = $model->image;
        } else {
            return response()->json([
                'message' => 'El modelo no tiene método de imágenes'
            ], Response::HTTP_BAD_REQUEST);
        }
    
        if (isset($image) && $image) {
            $this->deleteImage($image);
            return response()->json([
                'message' => 'Imagen eliminada con éxito'
            ], Response::HTTP_OK);
        }
    
        return response()->json([
            'message' => 'Imagen no encontrada'
        ], Response::HTTP_NOT_FOUND);
    }
    
    
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

    
    public function getImageUrl(Image $image)
    {
        $url = Storage::url($image->path); // Obtén la URL completa para mostrar
        
        return response()->json([
            'url' => $url
        ], Response::HTTP_OK);
    }

    
}
