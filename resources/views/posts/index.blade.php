@extends('layouts.app')

@section('title', 'Semua Post')

@section('content')
<h1>Semua Post</h1>

@forelse($posts as $post)
    <article class="post-card">
        <h2>
            <a href="{{ route('posts.show', $post) }}">
                {{ $post->title }}
            </a>
        </h2>
        <p class="meta">
            Oleh {{ $post->author }} | {{ $post->created_at->format('d M Y') }}
        </p>
        <p>{{ Str::limit($post->content, 150) }}</p>
        <div class="actions">
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary">Edit</a>
            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus post ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </article>
@empty
    <p class="empty">Belum ada post. <a href="{{ route('posts.create') }}">Buat post pertama!</a></p>
@endforelse

@if($posts instanceof \Illuminate\Contracts\Pagination\Paginator)
    <div class="pagination">
        {{ $posts->links() }}
    </div>
@endif
@endsection
