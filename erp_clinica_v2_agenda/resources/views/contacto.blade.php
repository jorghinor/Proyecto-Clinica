<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="lg:text-center mb-10">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Contáctanos</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-lime-500 drop-shadow-[0_2px_2px_rgba(0,255,0,0.8)] animate-float sm:text-4xl">
                    Estamos aquí para ayudarte
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Envíanos un mensaje y te responderemos a la brevedad posible.
                </p>
            </div>

            <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Información de Contacto</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                También puedes encontrarnos en nuestras redes sociales o visitarnos en nuestra dirección.
                            </p>
                            <div class="mt-5 text-sm text-gray-600">
                                <p><strong>Dirección:</strong> Av. Principal #123, Ciudad Salud</p>
                                <p><strong>Teléfono:</strong> (123) 456-7890</p>
                                <p><strong>Email:</strong> info@clinicamedica.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-5" role="alert">
                                <strong class="font-bold">¡Éxito!</strong>
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        <form action="{{ route('contacto.store') }}" method="POST">
                            @csrf
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                            <input type="text" name="nombre" id="nombre" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('nombre') border-red-500 @enderror" value="{{ old('nombre') }}">
                                            @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" name="email" id="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('email') border-red-500 @enderror" value="{{ old('email') }}">
                                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="col-span-full">
                                            <label for="mensaje" class="block text-sm font-medium text-gray-700">Mensaje</label>
                                            <div class="mt-1">
                                                <textarea id="mensaje" name="mensaje" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md @error('mensaje') border-red-500 @enderror">{{ old('mensaje') }}</textarea>
                                            </div>
                                            @error('mensaje') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Enviar Mensaje
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sección del Mapa -->
            <div class="mt-10">
                <h3 class="text-lg font-medium leading-6 text-gray-900 text-center">Nuestra Ubicación</h3>
                <div id="map" class="mt-5 w-full rounded-lg shadow-md z-0" style="height: 400px;"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Coordenadas para Los Olivos, Cochabamba, Bolivia
            var lat = -17.383333;
            var lng = -66.166667;

            var map = L.map('map').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup('<b>Clínica ERP</b><br>Los Olivos, Cochabamba, Bolivia.')
                .openPopup();
        });
    </script>
</x-app-layout>
