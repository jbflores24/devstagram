<div>
    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <div>
                    <a href="{{ route('posts.show', ['post'=>$post,'user'=>$post->user]) }}">
                        <img src="{{ asset('uploads') . '/' . $post->imagen}}" alt="Imágen del post {{ $post->titulo }}">
                    </a>
                </div>
            @endforeach
        </div>
        <div class="my-6">
            {{ $posts->links('pagination::tailwind') }}
        </div>
    @else
        <p class="text-center">No hay post, sigue a alguien para poder ver sus posts</p>
    @endif
</div>
