<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="lg:text-center mb-10">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Nuestros Servicios</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-lime-500 drop-shadow-[0_2px_2px_rgba(0,255,0,0.8)] animate-float sm:text-4xl">
                    Especialidades Médicas
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Contamos con un equipo de profesionales altamente calificados en diversas áreas de la medicina para cuidar de tu salud.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($especialidades as $especialidad)
                    <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-orange-glow transition-shadow duration-300 flex flex-col">
                        <div class="px-4 py-5 sm:p-6 flex-grow">
                            <div class="flex items-center mb-4">
                                <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl font-bold mr-4">
                                    {{ substr($especialidad->nombre, 0, 1) }}
                                </div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $especialidad->nombre }}</h3>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Ofrecemos atención especializada en {{ strtolower($especialidad->nombre) }} con los mejores profesionales y tecnología de vanguardia.
                            </p>
                        </div>
                        <div class="px-4 py-4 bg-gray-50 border-t border-gray-100">
                            <a href="/citas/solicitar" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium flex items-center">
                                Agendar Cita <span aria-hidden="true" class="ml-1">&rarr;</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">No hay especialidades disponibles en este momento.</p>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $especialidades->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
