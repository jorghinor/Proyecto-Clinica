<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="lg:text-center mb-10">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Nuestro Blog</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-lime-500 drop-shadow-[0_2px_2px_rgba(0,255,0,0.8)] animate-float sm:text-4xl">
                    Noticias y Artículos de Salud
                </p>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                @forelse($posts as $post)
                    <div class="flex flex-col bg-white p-6 rounded-lg shadow-md">
                        @if($post->imagen_destacada_path)
                            <img class="h-48 w-full object-cover rounded-md mb-4" src="{{ asset('storage/' . $post->imagen_destacada_path) }}" alt="{{ $post->titulo }}">
                        @endif
                        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $post->titulo }}</h3>
                        <p class="mt-2 text-sm text-gray-500">{{ Str::limit(strip_tags($post->contenido), 150) }}</p>
                        <div class="mt-4">
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Leer más &rarr;</a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">No hay artículos disponibles en este momento.</p>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
