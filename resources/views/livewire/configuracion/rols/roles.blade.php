<div class="justify-center items-center">
    <div class="bg-blue-200 rounded-lg align-middle p-2 mb-2 text-center">
        <h1 class="text-xl uppercase">roles y permisos</h1>
    </div>

    @if ($is_modify)
        <div class="flex justify-end mb-4 ">
            @can('cf_rolesCrea')
                <div class="inline-flex rounded-md shadow-sm" role="group">
                    <button type="button" wire:click.prevent="show({{1}},{{3}})" class="px-4 py-2 text-sm font-medium text-blue-700 bg-cyan-300 border border-cyan-200 rounded-s-lg hover:bg-cyan-100 hover:text-cyan-700 focus:z-10 focus:ring-2 focus:ring-cyan-700 focus:text-cyan-700 dark:bg-gray-800 dark:border-cyan-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-500 dark:focus:text-white">
                        <i class="fa-solid fa-plus"></i> Crear
                    </button>

                    <button type="button" wire:click.prevent="show({{1}},{{2}})" class="px-4 py-2 text-sm font-medium text-yellow-700 bg-orange-200 border border-gray-200 rounded-e-lg hover:bg-orange-100 hover:text-orange-700 focus:z-10 focus:ring-2 focus:ring-orange-700 focus:text-orange-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-orange-500 dark:focus:text-white">
                        <i class="fa-solid fa-ship"></i> Asignar Permiso
                    </button>
                </div>
            @endcan
        </div>
        <div class="max-w-md mx-auto p-2 rounded-sm">
            <table class=" text-sm text-left text-gray-500 dark:text-gray-400 rounded-xl">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">

                        </th>
                        <th scope="col" class="px-6 py-3" >
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3" >
                            Roles
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $item)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @can('cf_rolesEdita')
                                    <div class="inline-flex rounded-md shadow-sm" role="group">
                                        @if ($item->status)
                                            <button type="button" wire:click.prevent="show({{$item->id}},{{0}})" class="px-4 py-2 text-sm font-medium text-blue-700 bg-cyan-300 border border-cyan-200 rounded-s-lg hover:bg-cyan-100 hover:text-cyan-700 focus:z-10 focus:ring-2 focus:ring-cyan-700 focus:text-cyan-700 dark:bg-gray-800 dark:border-cyan-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-500 dark:focus:text-white">
                                                <i class="fa-solid fa-marker"></i>
                                            </button>
                                        @endif

                                        <button type="button" wire:click.prevent="show({{$item->id}},{{1}})" class="px-4 py-2 text-sm font-medium text-yellow-700 bg-orange-200 border border-gray-200 rounded-e-lg hover:bg-orange-100 hover:text-orange-700 focus:z-10 focus:ring-2 focus:ring-orange-700 focus:text-orange-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-orange-500 dark:focus:text-white">
                                            <i class="fa-brands fa-creative-commons-sa"></i>
                                        </button>
                                    </div>
                                @endcan
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$item->id}}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                {{$item->name}}
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

    @if ($is_editing)
        @include('includes.edicion')
    @endif

    @if ($is_inactivar)
        @include('includes.inactivar')
    @endif

    @if ($is_permiso)
        @include('includes.edicion')
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
