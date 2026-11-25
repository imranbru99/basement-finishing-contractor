@extends('layouts.site')
@section('title', 'Field Journal')
@section('content')
<div class="page-hero"><div class="wrap"><h1>Field journal</h1><p>Basement finishing insights from CedarVault crews.</p></div></div>
<section><div class="wrap post-list">
    @foreach ($posts as $post)
        <article>
            <a href="{{ route('blog.show', $post) }}">
                <strong style="font-size:1.25rem;">{{ $post->title }}</strong>
                <p style="margin:.4rem 0;color:#405248;">{{ $post->excerpt }}</p>
                <small>{{ optional($post->published_at)->format('M j, Y') }} · {{ $post->author_name }}</small>
            </a>
        </article>
    @endforeach
    <div style="margin-top:2rem;">{{ $posts->links() }}</div>
</div></section>
@endsection
