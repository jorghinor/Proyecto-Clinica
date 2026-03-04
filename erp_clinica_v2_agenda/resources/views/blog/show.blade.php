<x-app-layout>
    <div class="py-12 bg-white">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="prose lg:prose-xl mx-auto">
                <h1>{{ $post->titulo }}</h1>
                <p class="text-sm text-gray-500">
                    Publicado por {{ $post->autor->name }} el {{ $post->fecha_publicacion->format('d/m/Y') }}
                </p>

                @if($post->imagen_destacada_path)
                    <img class="w-full rounded-lg my-8" src="{{ asset('storage/' . $post->imagen_destacada_path) }}" alt="{{ $post->titulo }}">
                @endif

                <div>
                    {!! $post->contenido !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
