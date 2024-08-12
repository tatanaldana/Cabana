<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api')->except(['index', 'show','indexAllImages']);
       // $this->middleware(['scope:admin', 'permission:create general'])->only('store');
        //$this->middleware(['scope:admin,cliente', 'permission:edit general|edicion parcial'])->only('update');
       // $this->middleware(['scope:admin,cliente', 'permission:delete general|Eliminacion parcial'])->only('destroy');
    }

    /**
     * Display a listing of the images for a specific model (one-to-many).
     */
    public function index(string $modelType, int $modelId)
    {
        $model = $this->resolveModel($modelType, $modelId);

        if (method_exists($model, 'images')) {
            $images = $model->images()->get();
        } else {
            $images = $model->image ? [$model->image] : [];
        }

        return response()->json([
            'data' => ImageResource::collection($images)
        ], Response::HTTP_OK);
    }

    /**
     * Display all images for a specific model (one-to-many) or all instances of a model.
     */
    public function indexAllImages(string $modelType)
{

    $modelClass = $this->resolveModelClass($modelType);

    if (method_exists($modelClass, 'images')) {
        // Relación uno a muchos
        $models = $modelClass::with('images')->get(); // Usa 'images' para relaciones uno a muchos
        $images = $models->flatMap(function ($model) {
            return $model->images; // Para relaciones uno a muchos, retorna la colección de imágenes
        });
    } else if (method_exists($modelClass, 'image')) {
        // Relación uno a uno
        $models = $modelClass::with('image')->get(); // Usa 'image' para relaciones uno a uno
        $images = $models->map(function ($model) {
            return $model->image; // Para relaciones uno a uno, retorna la única imagen asociada
        })->filter(); // Filtra los valores nulos
    } 

    return response()->json([
        'data' => ImageResource::collection($images)
    ], Response::HTTP_OK);
}


    /**
     * Display the specified image.
     */
    public function show(string $modelType, int $modelId, int $imageId)
    {
        $model = $this->resolveModel($modelType, $modelId);

        if (method_exists($model, 'images')) {
            $image = $model->images()->findOrFail($imageId);
        } else {
            $image = $model->image; // Asumiendo que la relación es 'image'
        }

        return response()->json([
            'data' => new ImageResource($image)
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created image in storage.
     */
    public function store(ImageRequest $request)
    {
        //$this->authorize('create', Image::class);

        $modelTypeFolder = strtolower(class_basename($request->input('imageable_type')));
        $path = $request->file('image')->store("images/{$modelTypeFolder}", 'public');

        $model = $this->resolveModel($request->input('imageable_type'), $request->input('imageable_id'));

        if (method_exists($model, 'images')) {
            $image = $model->images()->create([
                'path' => $path,
            ]);
        } else {
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
    public function updateForOneToMany(string $modelType, int $modelId, int $imageId, Request $request)
    {
        $model = $this->resolveModel($modelType, $modelId);
        $image = $model->images()->findOrFail($imageId);

        dd($model,$image);
    
        if ($request->hasFile('image')) {
            $oldPath = $image->path;
    
            // Elimina el archivo antiguo
            $this->deleteFile($oldPath);
    
            // Almacena el archivo nuevo
            $path = $request->file('image')->store("images/" . strtolower(class_basename($modelType)), 'public');
    
            // Actualiza el registro con la nueva ruta
            $image->path = $path;
            $image->save();
        }else{
            echo "Image file not found:";
        }
    
        return response()->json([
            'message' => 'Imagen actualizada exitosamente',
            'data' => new ImageResource($image)
        ], Response::HTTP_OK);
    }
    
    public function updateForOneToOne(string $modelType, int $modelId, ImageRequest $request)
    {
        $model = $this->resolveModel($modelType, $modelId);
        $image = $model->image;

        dd($model,$image);
    
        if (!$image) {
            return response()->json(['message' => 'Imagen no encontrada.'], Response::HTTP_NOT_FOUND);
        }
    
        if ($request->hasFile('image')) {
            $oldPath = $image->path;
    
            // Elimina el archivo antiguo
            $this->deleteFile($oldPath);
    
            // Almacena el archivo nuevo
            $path = $request->file('image')->store('images/' . strtolower(class_basename($modelType)), 'public');

            // Actualiza el registro con la nueva ruta
            $image->path = $path;
            $image->save();
        }else{
            echo "Image file not found:";
        }
    
        return response()->json([
            'message' => 'Imagen actualizada exitosamente',
            'data' => new ImageResource($image)
        ], Response::HTTP_OK);
    }
    
    


    /**
     * Remove the specified image (one-to-many).
     */
    public function destroyImageForOneToMany(string $modelType, int $modelId, int $imageId)
    {
       // $this->authorize('delete', Image::class);

        $model = $this->resolveModel($modelType, $modelId);
        $image = $model->images()->findOrFail($imageId);

        $this->deleteImage($image);

        return response()->json([
            'message' => 'Imagen eliminada con éxito'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified image (one-to-one).
     */
    public function destroyImageForOneToOne(string $modelType, int $modelId)
    {
       // $this->authorize('delete', Image::class);

        $model = $this->resolveModel($modelType, $modelId);
        $image = $model->image; // Asumiendo que la relación es 'image'

        if (!$image) {
            return response()->json(['message' => 'Imagen no encontrada.'], Response::HTTP_NOT_FOUND);
        }

        $this->deleteImage($image);

        return response()->json([
            'message' => 'Imagen eliminada con éxito'
        ], Response::HTTP_OK);
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

     private function deleteFile($path): void
     {
        
         if (Storage::disk('public')->exists($path)) {
             Storage::disk('public')->delete($path);
         }
     }

    private function deleteImage(Image $image): void
    {
        $path = $image->path;
    
        if (Storage::disk('public')->exists($path)) {

            Storage::disk('public')->delete($path);

        }
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
