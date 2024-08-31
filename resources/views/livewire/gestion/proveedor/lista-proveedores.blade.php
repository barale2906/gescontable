<div>
    <div class="justify-center items-center">
        <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
            <h1 class="text-xl uppercase">proveedores</h1>
        </div>
        @include('includes.filtro')
        @if ($is_modify)
        <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">

                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('name')">
                        Nombre
                        @if ($ordena != 'name')
                            <i class="fas fa-sort"></i>
                        @else
                            @if ($ordenado=='ASC')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('direccion')">
                        Dirección
                        @if ($ordena != 'direccion')
                            <i class="fas fa-sort"></i>
                        @else
                            @if ($ordenado=='ASC')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3" >
                        Teléfono
                    </th>
                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('email')">
                        Correo Electrónico
                        @if ($ordena != 'email')
                            <i class="fas fa-sort"></i>
                        @else
                            @if ($ordenado=='ASC')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    </th>

                    <th scope="col" class="px-6 py-3" >
                        Persona Contacto
                    </th>

                    <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('productos')">
                        Productos
                        @if ($ordena != 'productos')
                            <i class="fas fa-sort"></i>
                        @else
                            @if ($ordenado=='ASC')
                                <i class="fas fa-sort-up"></i>
                            @else
                                <i class="fas fa-sort-down"></i>
                            @endif
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proveedores as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="inline-flex rounded-md shadow-sm">
                                @can('cl_proveedorEdita')
                                    @if ($item->status)
                                        <button type="button" wire:click.prevent="show({{$item->id}},{{0}})" class="px-4 py-2 text-sm font-medium text-blue-700 bg-cyan-300 border border-cyan-200 rounded-s-lg hover:bg-cyan-100 hover:text-cyan-700 focus:z-10 focus:ring-2 focus:ring-cyan-700 focus:text-cyan-700 dark:bg-gray-800 dark:border-cyan-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-500 dark:focus:text-white">
                                            <i class="fa-solid fa-marker"></i>
                                        </button>
                                        <a href="#" wire:click.prevent="show({{$item->id}},{{1}})" class="px-4 py-2 text-sm font-medium text-gray-900 bg-yellow-400 border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-yellow-700 focus:z-10 focus:ring-2 focus:ring-yellow-700 focus:text-yellow-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-yellow-500 dark:focus:text-white">
                                            <i class="fa-brands fa-creative-commons-sa"></i>
                                        </a>
                                    @else
                                        <a href="#" wire:click.prevent="show({{$item->id}},{{1}})" class="px-4 py-2 text-sm font-medium text-gray-900 bg-green-400 border border-green-200 rounded-lg hover:bg-green-100 hover:text-green-700 focus:z-10 focus:ring-2 focus:ring-green-700 focus:text-green-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-green-500 dark:focus:text-white">
                                            <i class="fa-brands fa-creative-commons-sa mr-2"></i> Activar
                                        </a>
                                    @endif
                                @endcan
                            </div>
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$item->name}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                            {{$item->direccion}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                            {{$item->telefono}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                            {{$item->email}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                            {{$item->persona_contacto}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                            {{$item->productos}}
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>

            <div class="mt-2 p-1 w-auto rounded-lg grid grid-cols-2 gap-4 bg-blue-100">
                <div>
                    <label class="relative inline-flex items-center mb-4 cursor-pointer">
                        <span class="ml-3 mr-3 text-sm font-medium text-gray-900 dark:text-gray-300">Registros:</span>
                        <select wire:click="paginas($event.target.value)" id="countries" class="w-20 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value=15>15</option>
                            <option value=20>20</option>
                            <option value=50>50</option>
                            <option value=100>100</option>
                        </select>
                    </label>
                </div>
                <div>
                    {{ $proveedores->links() }}
                </div>
            </div>
        @endif
    </div>


    @if ($is_editing)
        @include('includes.edicion')
    @endif

    @if ($is_inactivar)
        @include('includes.inactivar')
    @endif

    @push('js')
        <script>
            document.addEventListener('livewire:initialized', function (){
                @this.on('alerta', (name)=>{
                    const variable = name;
                    console.log(variable['name'])
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: variable['name'],
                        showConfirmButton: false,
                        timer: 1500
                    })
                });
            });
        </script>
    @endpush
</div>
