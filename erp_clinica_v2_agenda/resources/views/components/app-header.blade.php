<header class="relative">
    <div class="absolute inset-0">
        <img class="h-full w-full object-cover" src="https://images.unsplash.com/photo-1532938911079-1b06ac7ceec7?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Clínica Médica">
        <div class="absolute inset-0 bg-indigo-700 bg-opacity-75 mix-blend-multiply"></div>
    </div>
    <div class="relative z-10 py-6">
        <nav class="relative max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8" aria-label="Global">
            <div class="flex items-center flex-1">
                <div class="flex items-center justify-between w-full md:w-auto">
                    <a href="/" class="-m-1.5 p-1.5">
                        <span class="sr-only">ERP Clínica Médica</span>
                        <span class="text-2xl font-bold text-white">Clínica ERP</span>
                    </a>
                    <div class="-mr-2 flex items-center md:hidden">
                        <button type="button" class="bg-indigo-900 rounded-md p-2 inline-flex items-center justify-center text-indigo-200 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-900 focus:ring-white" aria-expanded="false" x-data="{ open: false }" @click="open = !open">
                            <span class="sr-only">Abrir menú principal</span>
                            <svg class="h-6 w-6" x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="h-6 w-6" x-show="open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="hidden space-x-8 md:flex md:ml-10">
                    <a href="/" class="text-base font-medium text-white hover:text-indigo-50">Inicio</a>
                    <a href="/especialidades" class="text-base font-medium text-white hover:text-indigo-50">Servicios</a>
                    <a href="/productos" class="text-base font-medium text-white hover:text-indigo-50">Productos</a>
                    <a href="/medicos" class="text-base font-medium text-white hover:text-indigo-50">Nuestros Médicos</a>
                    <a href="/citas/solicitar" class="text-base font-medium text-white hover:text-indigo-50">Solicitar Cita</a>
                    <a href="/contacto" class="text-base font-medium text-white hover:text-indigo-50">Contacto</a>
                </div>
            </div>
            <div class="hidden md:flex items-center justify-end md:flex-1">
                <a href="{{ route('cart.index') }}" class="text-white hover:text-indigo-50 mr-4 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if(count(session('cart', [])) > 0)
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                            {{ count(session('cart', [])) }}
                        </span>
                    @endif
                </a>

                @auth('paciente')
                    <div x-data="{ open: false }" @click.away="open = false" class="relative">
                        <button @click="open = !open" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Hola, {{ Auth::guard('paciente')->user()->nombre }}
                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <a href="{{ route('portal.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-0">Dashboard</a>
                            <form method="POST" action="{{ route('portal.logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-2">Cerrar Sesión</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('portal.login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Portal Paciente</a>
                    <a href="/admin" class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-100">Acceso Personal</a>
                @endauth
            </div>
        </nav>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="absolute z-20 top-0 inset-x-0 p-2 transition transform origin-top md:hidden" x-data="{ open: false }" x-show="open" @click.away="open = false">
        <div class="rounded-lg shadow-md bg-white ring-1 ring-black ring-opacity-5 overflow-hidden">
            <div class="px-5 pt-4 flex items-center justify-between">
                <div>
                    <span class="text-2xl font-bold text-indigo-600">Clínica ERP</span>
                </div>
                <div class="-mr-2">
                    <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" @click="open = false">
                        <span class="sr-only">Cerrar menú</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Inicio</a>
                <a href="/especialidades" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Servicios</a>
                <a href="/productos" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Productos</a>
                <a href="/medicos" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Nuestros Médicos</a>
                <a href="/citas/solicitar" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Solicitar Cita</a>
                <a href="/contacto" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Contacto</a>
                <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    Carrito
                    @if(count(session('cart', [])) > 0)
                        <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ count(session('cart', [])) }}</span>
                    @endif
                </a>
                @auth('paciente')
                    <a href="{{ route('portal.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">Dashboard Paciente</a>
                    <form method="POST" action="{{ route('portal.logout') }}" class="block">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100">Cerrar Sesión</button>
                    </form>
                @else
                    <a href="{{ route('portal.login') }}" class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100">Portal Paciente</a>
                    <a href="/admin" class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100">Acceso Personal</a>
                @endauth
            </div>
        </div>
    </div>
</header>
