<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Session::start();
    }

    private function csrfToken(): array
    {
        return ['_token' => Session::token()];
    }

    public function test_user_can_create_post(): void
    {
        $response = $this->actingAs(User::factory()->create())
            ->post(route('posts.store'), array_merge($this->csrfToken(), [
            'title' => 'Judul Baru',
            'content' => 'Konten baru yang sangat menarik.',
            'author' => 'Penulis',
            ]));

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', [
            'title' => 'Judul Baru',
            'author' => 'Penulis',
        ]);
    }

    public function test_user_can_update_post(): void
    {
        $post = Post::factory()->create();

        $response = $this->actingAs(User::factory()->create())
            ->put(route('posts.update', $post), array_merge($this->csrfToken(), [
            'title' => 'Judul Update',
            'content' => 'Konten diperbarui.',
            'author' => 'Penulis Update',
            ]));

        $response->assertRedirect(route('posts.show', $post->fresh()))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Judul Update',
            'author' => 'Penulis Update',
        ]);
    }

    public function test_user_can_delete_post(): void
    {
        $post = Post::factory()->create();

        $response = $this->actingAs(User::factory()->create())
            ->delete(route('posts.destroy', $post), $this->csrfToken());

        $response->assertRedirect(route('posts.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
