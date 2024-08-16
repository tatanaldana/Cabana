<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Traits\ImageHandlingTrait;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    use ImageHandlingTrait;
    
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware(['auth:api'])->only(['store', 'update', 'destroy']);
        $this->middleware(['scope:admin,cliente', 'permission:create general|registro parcial'])->only('store');
        $this->middleware(['scope:admin,cliente', 'permission:edit general|edicion parcial'])->only('update');
        $this->middleware(['scope:admin,cliente', 'permission:delete general|Eliminacion parcial'])->only('destroy');
    }
    /**
     * Display a listing of the images for a specific model (one-to-many).
     */
    public function index(string $modelType)
    {
        $modelClass = $this->resolveModelClass($modelType);

        if ($modelType === 'users') {
            $this->authorize('viewAny', User::class);
        }

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
            'message' => 'Imagenes obtenidas exitosamente',
            'data' => ImageResource::collection($images)
        ], Response::HTTP_OK);
    }
    /**
     * Display the specified image.
     */
    public function show(string $modelType, int $modelId, $imageId = null)
    {
        // Resuelve el modelo basado en el tipo y el ID
        $model = $this->resolveModel($modelType, $modelId);

        // Verifica si el modelo es de tipo 'users'
        if ($modelType === 'users') {
            return $this->handleUserImages($model, $imageId);
        }

        // Maneja otros modelos (productos, categorías, promociones)
        return $this->handleGeneralImages($model, $imageId);
    }
    
    /**
     * Store a newly created image in storage.
     */
    public function store(ImageRequest $request)
    {
        $data = $request->validated();
        $model = $this->resolveModel($data['imageable_type'], $data['imageable_id']);
        $this->authorize('create', $model);
        
        if (method_exists($model, 'image')) {
            $existingImage = $model->image;
            if ($existingImage) {
                return response()->json([
                    'message' => 'Ya hay una imagen asignada, por favor actualícela o elimínela'
                ], Response::HTTP_BAD_REQUEST);
            }
        }

        $modelTypeFolder = strtolower(class_basename($data['imageable_type']));
        $imageFile = $request->file('image');
        $imageInstance = $this->resizeImageIfNeeded($imageFile, $data['imageable_type']);
        $uuid = (string) Str::uuid();
        $path = 'images/' . $modelTypeFolder . '/' . $uuid . '.' . $imageFile->getClientOriginalExtension();
        Storage::disk('public')->put($path, (string) $imageInstance->encode());

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
        $this->authorize('update', $image);
        $data = $request->validated();
        $model = $this->resolveModel($data['imageable_type'], $data['imageable_id']);

        if (method_exists($model, 'images')) {
            $existingImage = $model->images()->findOrFail($image->id);
        } elseif (method_exists($model, 'image')) {
            $existingImage = $model->image;
        } else {
            return response()->json([
                'message' => 'El modelo no tiene método de imágenes',
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($existingImage) {
            $this->deleteImageFile($existingImage);

            $imageFile = $request->file('image');
            $imageInstance = $this->resizeImageIfNeeded($imageFile, $data['imageable_type']);
            $modelTypeFolder = strtolower(class_basename($data['imageable_type']));
            $uuid = (string) Str::uuid();
            $path = 'images/' . $modelTypeFolder . '/' . $uuid . '.' . $imageFile->getClientOriginalExtension();
            Storage::disk('public')->put($path, (string) $imageInstance->encode());

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
            // Autorizamos la eliminación basada en la instancia de la imagen
            $this->authorize('delete', $image);
            
            // Procedemos a eliminar la imagen
            $this->deleteImage($image);
    
            return response()->json([
                'message' => 'Imagen eliminada con éxito'
            ], Response::HTTP_OK);
        }
    
        return response()->json([
            'message' => 'Imagen no encontrada'
        ], Response::HTTP_NOT_FOUND);
    }
}
