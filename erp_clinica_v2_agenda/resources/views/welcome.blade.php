<x-app-layout>
    <div class="relative bg-white overflow-hidden" x-data="{ openModal: false, selectedProduct: {}, openTestimonioModal: false, selectedTestimonio: {}, openBlogModal: false, selectedPost: {}, openMedicoModal: false, selectedMedico: {} }">
        <!-- Sección Hero -->
        <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
            <div class="sm:text-center lg:text-left">
                <h1 class="text-4xl tracking-tight font-extrabold text-lime-500 drop-shadow-[0_2px_2px_rgba(0,255,0,0.8)] animate-float sm:text-5xl md:text-6xl">
                    <span class="block xl:inline">ERP Clínica Médica</span>
                    <span class="block text-indigo-600 xl:inline">Gestión Integral</span>
                </h1>
                <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                    Optimiza la administración de tu clínica con nuestra plataforma todo-en-uno. Pacientes, agenda, facturación, inventario y más, de forma eficiente y segura.
                </p>
                <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                    <div class="rounded-md shadow">
                        <a href="/admin" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                            Acceder al Panel
                        </a>
                    </div>
                    <div class="mt-3 sm:mt-0 sm:ml-3">
                        <a href="#productos" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">
                            Ver Productos
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <!-- Sección de Productos -->
        <section id="productos" class="py-16 bg-gray-50" x-data="{ visible: false }" x-intersect="visible = true">
            <div x-show="visible" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 transform -translate-y-10" x-transition:enter-end="opacity-100 transform translate-y-0" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Inventario</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-lime-500 drop-shadow-[0_2px_2px_rgba(0,255,0,0.8)] animate-float sm:text-4xl">
                        Nuestros Productos Destacados
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                        Explora los productos y suministros médicos que ofrecemos en nuestra clínica.
                    </p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($productos as $producto)
                        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-orange-glow transition-shadow duration-300 flex flex-col">
                            <div @click="selectedProduct = {{ json_encode($producto) }}; openModal = true" class="cursor-pointer flex-grow">
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
                            <!-- Botón Añadir al Carrito -->
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
            </div>
        </section>

        <!-- Sección de Testimonios -->
        <section class="py-16 bg-white" x-data="{ visible: false }" x-intersect="visible = true">
            <div x-show="visible" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 transform translate-y-10" x-transition:enter-end="opacity-100 transform translate-y-0" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center mb-10">
                    <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Opiniones</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-lime-500 drop-shadow-[0_2px_2px_rgba(0,255,0,0.8)] animate-float sm:text-4xl">
                        Lo que dicen nuestros pacientes
                    </p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @forelse($testimonios as $testimonio)
                        <div @click="selectedTestimonio = {{ json_encode($testimonio) }}; openTestimonioModal = true" class="cursor-pointer flex flex-col bg-gray-100 p-6 rounded-lg shadow-md hover:shadow-orange-glow transition-shadow duration-300">
                            <div class="flex items-center mb-4">
                                @if($testimonio->foto_paciente_path)
                                    <img class="h-12 w-12 rounded-full object-cover mr-4" src="{{ asset('storage/' . $testimonio->foto_paciente_path) }}" alt="{{ $testimonio->nombre_paciente }}">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 text-xl mr-4">
                                        {{ substr($testimonio->nombre_paciente, 0, 1) }}
                                    </div>
                                @endif
                                <div class="font-medium text-gray-900">{{ $testimonio->nombre_paciente }}</div>
                            </div>
                            <p class="text-gray-600 italic">"{{ $testimonio->testimonio }}"</p>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-gray-500">No hay testimonios disponibles en este momento.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Sección de Nuestros Médicos (Destacados) -->
        <section class="py-16 bg-gray-50" x-data="{ visible: false }" x-intersect="visible = true">
            <div x-show="visible" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 transform -translate-y-10" x-transition:enter-end="opacity-100 transform translate-y-0" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center mb-10">
                    <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Equipo Médico</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-lime-500 drop-shadow-[0_2px_2px_rgba(0,255,0,0.8)] animate-float sm:text-4xl">
                        Conoce a Nuestros Especialistas
                    </p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @forelse($medicosDestacados as $medico)
                        <div @click="selectedMedico = {{ json_encode($medico) }}; openMedicoModal = true" class="cursor-pointer flex flex-col bg-white p-6 rounded-lg shadow-md hover:shadow-orange-glow transition-shadow duration-300">
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
                            <p class="mt-2 text-sm text-gray-500">Teléfono: {{ $medico->telefono }}</p>
                            <p class="mt-1 text-sm text-gray-500">Email: {{ $medico->email }}</p>
                            <div class="mt-4">
                                <span class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Ver perfil &rarr;</span>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-gray-500">No hay médicos destacados en este momento.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Sección del Blog -->
        <section class="py-16 bg-white" x-data="{ visible: false }" x-intersect="visible = true">
            <div x-show="visible" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0 transform translate-y-10" x-transition:enter-end="opacity-100 transform translate-y-0" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center mb-10">
                    <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Nuestro Blog</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-lime-500 drop-shadow-[0_2px_2px_rgba(0,255,0,0.8)] animate-float sm:text-4xl">
                        Últimas Noticias y Artículos de Salud
                    </p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @forelse($postsRecientes as $post)
                        <div @click="selectedPost = {{ json_encode($post) }}; openBlogModal = true" class="cursor-pointer flex flex-col bg-gray-100 p-6 rounded-lg shadow-md hover:shadow-orange-glow transition-shadow duration-300">
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
            </div>
        </section>

        <!-- Modal de Producto -->
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
                                        <div class="h-48 w-full bg-gray-200 flex items-center justify-center text-gray-400 rounded-md">Sin Imagen</div>
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

        <!-- Modal de Testimonio -->
        <div x-show="openTestimonioModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openTestimonioModal" @click="openTestimonioModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="openTestimonioModal" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <div class="flex items-center mb-4">
                                    <template x-if="selectedTestimonio.foto_paciente_path">
                                        <img class="h-12 w-12 rounded-full object-cover mr-4" :src="'/storage/' + selectedTestimonio.foto_paciente_path" :alt="selectedTestimonio.nombre_paciente">
                                    </template>
                                    <template x-if="!selectedTestimonio.foto_paciente_path">
                                        <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 text-xl mr-4" x-text="selectedTestimonio.nombre_paciente ? selectedTestimonio.nombre_paciente.substring(0, 1) : ''"></div>
                                    </template>
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title" x-text="selectedTestimonio.nombre_paciente"></h3>
                                </div>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600 italic" x-text="selectedTestimonio.testimonio ? '&quot;' + selectedTestimonio.testimonio + '&quot;' : ''"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="openTestimonioModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Blog -->
        <div x-show="openBlogModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openBlogModal" @click="openBlogModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="openBlogModal" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title" x-text="selectedPost.titulo"></h3>
                                <div class="mt-2">
                                    <template x-if="selectedPost.imagen_destacada_path">
                                        <img class="h-48 w-full object-cover rounded-md" :src="'/storage/' + selectedPost.imagen_destacada_path" :alt="selectedPost.titulo">
                                    </template>
                                    <p class="text-sm text-gray-500 mt-4" x-html="selectedPost.contenido ? selectedPost.contenido.substring(0, 200) + '...' : ''"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <a :href="selectedPost.slug ? '/blog/' + selectedPost.slug : '#'" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Leer más
                        </a>
                        <button @click="openBlogModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Médico -->
        <div x-show="openMedicoModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openMedicoModal" @click="openMedicoModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="openMedicoModal" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <div class="flex items-center mb-4">
                                    <template x-if="selectedMedico.foto_path">
                                        <img class="h-16 w-16 rounded-full object-cover mr-4" :src="'/storage/' + selectedMedico.foto_path" :alt="selectedMedico.nombre">
                                    </template>
                                    <template x-if="!selectedMedico.foto_path">
                                        <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 text-2xl mr-4" x-text="selectedMedico.nombre ? selectedMedico.nombre.substring(0, 1) : ''"></div>
                                    </template>
                                    <div>
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title" x-text="selectedMedico.nombre"></h3>
                                        <p class="text-sm text-indigo-600" x-text="selectedMedico.especialidad ? selectedMedico.especialidad.nombre : 'Sin Especialidad'"></p>
                                    </div>
                                </div>
                                <div class="mt-4 border-t border-gray-200 pt-4">
                                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                                        <div class="sm:col-span-1">
                                            <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                            <dd class="mt-1 text-sm text-gray-900" x-text="selectedMedico.telefono"></dd>
                                        </div>
                                        <div class="sm:col-span-1">
                                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                                            <dd class="mt-1 text-sm text-gray-900" x-text="selectedMedico.email"></dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <a :href="selectedMedico.id ? '/medicos/' + selectedMedico.id : '#'" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Ver Perfil Completo
                        </a>
                        <button @click="openMedicoModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
