@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <article class="post-detail">
        <h1>{{ $post->title }}</h1>
        <p class="meta">
            Oleh {{ $post->author }} | {{ $post->created_at->format('d M Y') }}
        </p>
        <div class="content">
            {!! nl2br(e($post->content)) !!}
        </div>
        <div class="actions">
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary">Edit</a>
            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus post ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
            <a href="{{ route('posts.index') }}" class="btn">Kembali</a>
        </div>
    </article>
@endsection
