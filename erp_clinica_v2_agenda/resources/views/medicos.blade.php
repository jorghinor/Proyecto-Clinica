<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="lg:text-center mb-10">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Nuestro Equipo</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-lime-500 drop-shadow-[0_2px_2px_rgba(0,255,0,0.8)] animate-float sm:text-4xl">
                    Conoce a Nuestros Médicos
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Profesionales dedicados a tu bienestar, con experiencia en diversas especialidades.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($medicos as $medico)
                    <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-orange-glow transition-shadow duration-300 flex flex-col">
                        <div class="px-4 py-5 sm:p-6 flex-grow">
                            <div class="flex items-center mb-4">
                                @if($medico->foto_path)
                                    <img class="h-16 w-16 rounded-full object-cover mr-4" src="{{ asset('storage/' . $medico->foto_path) }}" alt="{{ $medico->nombre }}">
                                @else
                                    <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 text-2xl mr-4">
                                        {{ substr($medico->nombre, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $medico->nombre }}</h3>
                                    <p class="text-sm text-indigo-600">{{ $medico->especialidad->nombre ?? 'Sin Especialidad' }}</p>
                                </div>
                            </div>
                            <div class="mt-4 border-t border-gray-100 pt-4">
                                <p class="text-sm text-gray-500 flex items-center mb-2">
                                    <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    {{ $medico->telefono }}
                                </p>
                                <p class="text-sm text-gray-500 flex items-center">
                                    <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    {{ $medico->email }}
                                </p>
                            </div>
                        </div>
                        <div class="px-4 py-4 bg-gray-50 border-t border-gray-100">
                            <a href="{{ route('medicos.perfil', $medico) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium flex items-center justify-center">
                                Ver Perfil Completo <span aria-hidden="true" class="ml-1">&rarr;</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">No hay médicos registrados en este momento.</p>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $medicos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
