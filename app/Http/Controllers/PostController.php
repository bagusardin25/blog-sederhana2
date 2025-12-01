<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Menampilkan semua post.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    // Menampilkan form create
    public function create()
    {
        return view('posts.create');
    }

    // Menyimpan post baru (contoh validasi)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'author' => 'required|max:100'
        ]);

        Post::create($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Post berhasil dibuat!');
    }

    // Menampilkan detail post
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // Menampilkan form edit
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    // Memperbarui post
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'author' => 'required|max:100'
        ]);

        $post->update($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post berhasil diperbarui!');
    }

    // Menghapus post
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post berhasil dihapus!');
    }

}
