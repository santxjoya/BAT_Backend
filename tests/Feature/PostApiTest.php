<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
    }

    /** @test */
    public function una_persona_no_autenticada_no_puede_crear_posts()
    {
        $response = $this->postJson('/api/posts', [
            'title' => 'Post test',
            'content' => 'Contenido de prueba',
            'category_id' => $this->category->id
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function un_usuario_autenticado_puede_crear_posts()
    {
        $response = $this->actingAs($this->user, 'api')->postJson('/api/posts', [
            'title' => 'Post test',
            'content' => 'Contenido de prueba',
            'category_id' => $this->category->id
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'Post test']);
    }

    /** @test */
    public function un_usuario_solo_puede_editar_o_eliminar_sus_posts()
    {
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $otherUser = User::factory()->create();

        $updateResponse = $this->actingAs($otherUser, 'api')->putJson("/api/posts/{$post->id}", [
            'title' => 'Nuevo titulo'
        ]);

        $deleteResponse = $this->actingAs($otherUser, 'api')->deleteJson("/api/posts/{$post->id}");

        $updateResponse->assertStatus(403);
        $deleteResponse->assertStatus(403);

        $updateResponseAuth = $this->actingAs($this->user, 'api')->putJson("/api/posts/{$post->id}", [
            'title' => 'Nuevo titulo'
        ]);

        $deleteResponseAuth = $this->actingAs($this->user, 'api')->deleteJson("/api/posts/{$post->id}");

        $updateResponseAuth->assertStatus(200)
                           ->assertJsonFragment(['title' => 'Nuevo titulo']);
        $deleteResponseAuth->assertStatus(200)
                           ->assertJsonFragment(['message' => 'Post eliminado']);
    }

    /** @test */
    public function get_api_posts_retornara_posts_con_paginacion()
    {
        Post::factory()->count(15)->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'links'
                 ]);

        $this->assertCount(10, $response->json('data'));
    }
}
