<x-app-layout>
    <div class="py-12 bg-gray-50" x-data="{ openModal: false, selectedProduct: {} }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="lg:text-center mb-10">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Nuestro Catálogo</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-lime-500 drop-shadow-[0_2px_2px_rgba(0,255,0,0.8)] animate-float sm:text-4xl">
                    Productos Médicos
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    Descubre la variedad de productos y suministros disponibles en nuestra clínica.
                </p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($productos as $producto)
                    <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-orange-glow transition-shadow duration-300 flex flex-col">
                        <div @click="selectedProduct = {{ json_encode($producto) }}; openModal = true" class="cursor-pointer">
                            @if($producto->imagen_path)
                                <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $producto->imagen_path) }}" alt="{{ $producto->nombre }}">
                            @else
                                <div class="h-48 w-full bg-gray-200 flex items-center justify-center text-gray-400">
                                    Sin Imagen
                                </div>
                            @endif
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $producto->nombre }}</h3>
                                <p class="mt-2 text-sm text-gray-500">{{ Str::limit($producto->descripcion, 100) }}</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-xl font-bold text-indigo-600">${{ number_format($producto->precio_venta, 2) }}</span>
                                    <span class="text-sm text-gray-500">Stock: {{ $producto->stock_total }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 pb-5 mt-auto">
                            <a href="{{ route('cart.add', $producto->id) }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Añadir al Carrito
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">No hay productos disponibles en este momento.</p>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $productos->links() }}
            </div>
        </div>

        <!-- Modal -->
        <div x-show="openModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openModal" @click="openModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="openModal" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title" x-text="selectedProduct.nombre"></h3>
                                <div class="mt-2">
                                    <template x-if="selectedProduct.imagen_path">
                                        <img class="h-48 w-full object-cover rounded-md" :src="'/storage/' + selectedProduct.imagen_path" :alt="selectedProduct.nombre">
                                    </template>
                                    <template x-if="!selectedProduct.imagen_path">
                                        <div class="h-48 w-full bg-gray-200 flex items-center justify-center text-gray-400 rounded-md">
                                            Sin Imagen
                                        </div>
                                    </template>
                                    <p class="text-sm text-gray-500 mt-4" x-text="selectedProduct.descripcion"></p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-xl font-bold text-indigo-600" x-text="'$' + parseFloat(selectedProduct.precio_venta).toFixed(2)"></span>
                                        <span class="text-sm text-gray-500" x-text="'Stock: ' + selectedProduct.stock_total"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <a :href="'/add-to-cart/' + selectedProduct.id" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Añadir al Carrito
                        </a>
                        <button @click="openModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
