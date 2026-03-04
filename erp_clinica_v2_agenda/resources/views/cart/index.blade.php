<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-6">Tu Carrito de Compras</h2>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(count($cart) > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($cart as $id => $details)
                                    <tr data-id="{{ $id }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($details['image'])
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">
                                                            {{ substr($details['name'], 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $details['name'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ $details['price'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" value="{{ $details['quantity'] }}" class="quantity update-cart w-16 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ $details['price'] * $details['quantity'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button class="remove-from-cart text-red-600 hover:text-red-900">Eliminar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-right">
                                        <h3 class="text-xl font-bold">Total: ${{ $total }}</h3>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('productos') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Seguir Comprando
                            </a>
                            <form action="{{ route('cart.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                    Finalizar Pedido
                                </button>
                            </form>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-10">Tu carrito está vacío.</p>
                        <div class="text-center">
                            <a href="{{ route('productos') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Ir a la tienda &rarr;</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        document.querySelectorAll(".update-cart").forEach(function (element) {
            element.addEventListener("change", function (e) {
                e.preventDefault();
                var ele = e.target;
                var tr = ele.closest("tr");
                var id = tr.getAttribute("data-id");

                axios.patch('{{ route('cart.update') }}', {
                    id: id,
                    quantity: ele.value
                }).then(function (response) {
                    window.location.reload();
                });
            });
        });

        document.querySelectorAll(".remove-from-cart").forEach(function (element) {
            element.addEventListener("click", function (e) {
                e.preventDefault();
                var ele = e.target;
                var tr = ele.closest("tr");
                var id = tr.getAttribute("data-id");

                if(confirm("¿Estás seguro de que quieres eliminar este producto?")) {
                    axios.delete('{{ route('cart.remove') }}', {
                        data: { id: id }
                    }).then(function (response) {
                        window.location.reload();
                    });
                }
            });
        });
    </script>
</x-app-layout>
