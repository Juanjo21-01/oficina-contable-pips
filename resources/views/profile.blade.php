<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border-2 border-gray-200 dark:border-gray-700 rounded-md">
                    <livewire:profile.update-profile-information-form />
                </div>
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border-2 border-gray-200 dark:border-gray-700 rounded-md">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border-2 dark:border-gray-700">
                <div class="max-w-7xl mx-auto space-y-4">
                    <!-- Tabla de Clientes Relacionados -->
                    <div class="flex justify-between">
                        <h3 class="text-xl font-semibold text-teal-600 dark:text-teal-400 p-2">Últimos Clientes
                            Registrados</h3>
                        {{-- boton para visitar la pagina de clientes --}}
                        <div class="flex justify-end">
                            <a href="{{ route('clientes.index') }}" wire:navigate
                                class="flex items-center text-teal-600 dark:text-teal-400 hover:underline">
                                <span>Ver todos los clientes</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-full overflow-hidden rounded-lg shadow-lg border mx-auto dark:border-gray-700 mb-4">
                        <div class="w-full overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr
                                        class="text-xs font-semibold tracking-widest text-center text-gray-500 uppercase border-b-2  dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-4 py-3 w-1/12">No.</th>
                                        <th class="px-4 py-3 w-4/12">Nombres</th>
                                        <th class="px-4 py-3 w-2/12">DPI</th>
                                        <th class="px-4 py-3 w-3/12">Correo</th>
                                        <th class="px-4 py-3 w-2/12">NIT</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @if (Auth::user()->clientes->isEmpty())
                                        <tr class="text-gray-700 dark:text-gray-400 text-center">
                                            <td class="px-4 py-3" colspan="5">No hay registros</td>
                                        </tr>
                                    @endif
                                    @foreach (Auth::user()->clientes->sortByDesc('created_at')->take(5) as $cliente)
                                        <tr class="text-gray-700 dark:text-gray-400 text-center">
                                            <td class="px-4 py-3 w-1/12 font-semibold">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-3 w-4/12">
                                                <p class="font-semibold">{{ $cliente->nombres }}
                                                    {{ $cliente->apellidos }}
                                                </p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                                    {{ $cliente->direccion }}
                                                </p>
                                            </td>
                                            <td class="px-4 py-3 w-2/12">{{ $cliente->dpi }}</td>
                                            <td class="px-4 py-3 w-3/12">{{ $cliente->email }}</td>
                                            <td class="px-4 py-3 w-2/12">{{ $cliente->nit }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border-2 dark:border-gray-700">
                <div class="max-w-7xl mx-auto space-y-4">
                    <!-- Tabla de Trámites Relacionados -->
                    <div class="flex justify-between">
                        <h3 class="text-xl font-semibold text-teal-600 dark:text-teal-400 p-2">Últimos Trámites
                            Realizados</h3>
                        {{-- boton para visitar la pagina de tramites --}}
                        <div class="flex justify-end">
                            <a href="{{ route('tramites.index') }}" wire:navigate
                                class="flex items-center text-teal-600 dark:text-teal-400 hover:underline">
                                <span>Ver todos los trámites</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-full overflow-hidden rounded-lg shadow-lg border mx-auto dark:border-gray-700 mb-4">
                        <div class="w-full overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr
                                        class="text-xs font-semibold tracking-widest text-center text-gray-500 uppercase border-b-2  dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-4 py-3 w-1/12">No.</th>
                                        <th class="px-4 py-3 w-4/12">Cliente</th>
                                        <th class="px-4 py-3 w-3/12">Tipo de trámite</th>
                                        <th class="px-4 py-3 w-2/12">Precio</th>
                                        <th class="px-4 py-3 w-2/12">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @if (Auth::user()->tramites->isEmpty())
                                        <tr class="text-gray-700 dark:text-gray-400 text-center">
                                            <td class="px-4 py-3" colspan="5">No hay registros</td>
                                        </tr>
                                    @endif
                                    @foreach (Auth::user()->tramites->sortByDesc('created_at')->take(5) as $tramite)
                                        <tr class="text-gray-700 dark:text-gray-400 text-center">
                                            <td class="px-4 py-3 font-semibold w-1/12">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-3 w-4/12">{{ $tramite->cliente->nombres }}
                                                {{ $tramite->cliente->apellidos }} </td>
                                            <td class="px-4 py-3 w-3/12">{{ $tramite->tipoTramite->nombre }}</td>
                                            <td class="px-4 py-3 w-2/12">Q. {{ $tramite->precio }}</td>
                                            <td class="px-4 py-3 font-semibold w-2/12">
                                                {{ date('d/m/Y', strtotime($tramite->fecha)) }}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg max-w-xl mx-auto border-2 dark:border-gray-700">
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div>
</x-app-layout>
