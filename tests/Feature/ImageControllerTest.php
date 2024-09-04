<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


class ImageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index method with a valid model type.
     */
    public function testIndexWithUsers()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->getJson('/api/images/users');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'message',
            'data' => [
                '*' => [
                    'id',
                    'path',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    /**
     * Test index method with an invalid model type.
     */
    public function testIndexWithInvalidModel()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->getJson('/api/images/invalidmodel');

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJson([
            'message' => 'El modelo no tiene métodos de imágenes',
        ]);
    }

    /**
     * Test show method with a valid image ID.
     */
    public function testShowImage()
    {
        $user = User::factory()->create();
        $image = Image::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->getJson("/api/images/users/{$user->id}/{$image->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'path',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    /**
     * Test show method with a non-existing image ID.
     */
    public function testShowImageNotFound()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->getJson("/api/images/users/{$user->id}/999");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson([
            'message' => 'Imagen no encontrada',
        ]);
    }

    /**
     * Test store method to upload a new image.
     */
    public function testStoreImage()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        Storage::fake('public');
        $file = UploadedFile::fake()->image('photo.jpg');
        $data = [
            'imageable_type' => User::class,
            'imageable_id' => $user->id,
            'image' => $file,
        ];

        $response = $this->postJson('/api/images', $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'path',
                'created_at',
                'updated_at'
            ]
        ]);
        Storage::disk('public')->assertExists('images/users/' . $file->hashName());
    }

    /**
     * Test store method when an image already exists.
     */
    public function testStoreImageWithExistingImage()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        
        // Create an existing image for the user
        Image::create([
            'path' => 'images/users/existing.jpg',
            'imageable_type' => User::class,
            'imageable_id' => $user->id,
        ]);

        Storage::fake('public');
        $file = UploadedFile::fake()->image('photo.jpg');
        $data = [
            'imageable_type' => User::class,
            'imageable_id' => $user->id,
            'image' => $file,
        ];

        $response = $this->postJson('/api/images', $data);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJson([
            'message' => 'Ya hay una imagen asignada, por favor actualícela o elimínela'
        ]);
    }

    /**
     * Test update method for an existing image.
     */
    public function testUpdateImage()
    {
        $user = User::factory()->create();
        $image = Image::factory()->create([
            'path' => 'images/users/old-image.jpg',
            'imageable_type' => User::class,
            'imageable_id' => $user->id,
        ]);
        $this->actingAs($user, 'api');

        Storage::fake('public');
        $file = UploadedFile::fake()->image('updated-photo.jpg');
        $data = [
            'imageable_type' => User::class,
            'imageable_id' => $user->id,
            'image' => $file,
        ];

        $response = $this->putJson("/api/images/{$image->id}", $data);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'path',
                'created_at',
                'updated_at'
            ]
        ]);
        Storage::disk('public')->assertExist('images/users/' . $file->hashName());
    }

    /**
     * Test update method for a non-existing image.
     */
    public function testUpdateImageNotFound()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        Storage::fake('public');
        $file = UploadedFile::fake()->image('photo.jpg');
        $data = [
            'imageable_type' => User::class,
            'imageable_id' => $user->id,
            'image' => $file,
        ];

        $response = $this->putJson("/api/images/999", $data);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson([
            'message' => 'Imagen no encontrada',
        ]);
    }

    /**
     * Test destroy method to delete an image.
     */
    public function testDestroyImage()
    {
        $user = User::factory()->create();
        $image = Image::factory()->create([
            'path' => 'images/users/image-to-delete.jpg',
            'imageable_type' => User::class,
            'imageable_id' => $user->id,
        ]);
        $this->actingAs($user, 'api');

        $response = $this->deleteJson("/api/images/users/{$user->id}/{$image->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'message' => 'Imagen eliminada con éxito'
        ]);
        Storage::disk('public')->assertMissing('images/users/image-to-delete.jpg');
    }

    /**
     * Test destroy method for a non-existing image.
     */
    public function testDestroyImageNotFound()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->deleteJson("/api/images/users/{$user->id}/999");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson([
            'message' => 'Imagen no encontrada',
        ]);
    }
}
