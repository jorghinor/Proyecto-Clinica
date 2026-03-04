<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <div class="sm:flex sm:space-x-5">
                            <div class="flex-shrink-0">
                                @if($medico->foto_path)
                                    <img class="h-24 w-24 rounded-full object-cover" src="{{ asset('storage/' . $medico->foto_path) }}" alt="{{ $medico->nombre }}">
                                @else
                                    <div class="h-24 w-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 text-3xl">
                                        {{ substr($medico->nombre, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                                <p class="text-xl font-bold text-gray-900 sm:text-2xl">{{ $medico->nombre }}</p>
                                <p class="text-sm font-medium text-indigo-600">{{ $medico->especialidad->nombre ?? 'Sin Especialidad' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 border-t border-gray-200 pt-5">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $medico->telefono }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $medico->email }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Biografía (Ejemplo)</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
