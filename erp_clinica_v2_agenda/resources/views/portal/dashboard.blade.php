<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">¡Bienvenido, {{ Auth::guard('paciente')->user()->nombre }}!</h2>
                            <p class="mt-1 text-gray-600">Este es tu portal de paciente.</p>
                        </div>
                        <form method="POST" action="{{ route('portal.logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>

                    <div x-data="{ activeTab: 'citas' }" class="mt-8">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                <a href="#" @click.prevent="activeTab = 'citas'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'citas', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'citas' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Mis Citas
                                </a>
                                <a href="#" @click.prevent="activeTab = 'recetas'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'recetas', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'recetas' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Mis Recetas
                                </a>
                                <a href="#" @click.prevent="activeTab = 'resultados'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'resultados', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'resultados' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Mis Resultados
                                </a>
                            </nav>
                        </div>

                        <!-- Contenido de Mis Citas -->
                        <div x-show="activeTab === 'citas'" class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Mis Citas</h3>
                            @if($citas->isEmpty())
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">Aún no tienes citas registradas.</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Médico</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Especialidad</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observación</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        @foreach($citas as $cita)
                                                            <tr>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cita->medico->nombre }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cita->medico->especialidad->nombre }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                        @if($cita->estado === 'atendido') bg-green-100 text-green-800
                                                                        @elseif($cita->estado === 'reservado') bg-yellow-100 text-yellow-800
                                                                        @elseif($cita->estado === 'cancelado') bg-red-100 text-red-800
                                                                        @else bg-gray-100 text-gray-800 @endif">
                                                                        {{ ucfirst($cita->estado) }}
                                                                    </span>
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($cita->observacion, 30) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Contenido de Mis Recetas -->
                        <div x-show="activeTab === 'recetas'" class="mt-6" style="display: none;">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Mis Recetas</h3>
                            @if($recetas->isEmpty())
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">Aún no tienes recetas registradas.</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Emisión</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Médico</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicamentos</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Indicaciones</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Archivo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        @foreach($recetas as $receta)
                                                            <tr>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($receta->fecha_emision)->format('d/m/Y') }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $receta->medico->nombre }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($receta->medicamentos, 50) }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($receta->indicaciones, 50) }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                                    @if($receta->archivo_path)
                                                                        <a href="{{ asset('storage/' . $receta->archivo_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Ver PDF</a>
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Contenido de Mis Resultados -->
                        <div x-show="activeTab === 'resultados'" class="mt-6" style="display: none;">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Mis Resultados</h3>
                            @if($resultados->isEmpty())
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">Aún no tienes resultados registrados.</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                                <table class="min-w-full divide-y divide-gray-200">
                                                    <thead class="bg-gray-50">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Resultado</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo Examen</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Archivo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                        @foreach($resultados as $resultado)
                                                            <tr>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($resultado->fecha_resultado)->format('d/m/Y') }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $resultado->tipo_examen }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($resultado->descripcion, 50) }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                                    <a href="{{ asset('storage/' . $resultado->archivo_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Ver Archivo</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
