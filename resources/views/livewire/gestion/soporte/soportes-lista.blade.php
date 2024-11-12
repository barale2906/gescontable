<div class=" bg-amber-50">

    <h1 class=" text-center font-semibold p-6">
        Cargando soporte / Generar Archivo Google
    </h1>

    <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-3 md:h-36">
        <div class="mb-6 p-2">
            <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Clase de documento</label>
            <select wire:model.live="tipo" id="tipo" class="w-full bg-amber-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 capitalize">
                <option >Elegir...</option>
                <option value=1>Generar Documento google</option>
                <option value=2>Cargar documento</option>
            </select>
        </div>

        @if ($tipo===2)
            <div class="mb-6">
                <label for="parametro" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Parámetro</label>
                <select wire:model.live="parametro" id="parametro" class="w-full bg-amber-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 capitalize">
                    <option >Elegir...</option>
                    @foreach ($parametros as $item)
                        <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                </select>
                @error('parametro')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>

            <div class="mb-6">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del soporte</label>
                <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full m-2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" wire:model.live="name">
                @error('name')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
            </div>

            <div class="mb-6">
                <label for="archivo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargue Archivo soporte</label>
                <input type="file" id="archivo" accept="image/jpg, image/bmp, image/png, image/jpeg, .pdf" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full m-2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" wire:model.live="archivo">
                @error('archivo')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
                <div wire:loading wire:target="archivo" class="text-center text-xl font-extrabold text-red-500 uppercase">Cargando...</div>
            </div>
            @if ($archivo)
                <a href="" wire:click.prevent="new()" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-upload"></i> Crear
                </a>
                <div wire:loading wire:target="new" class="text-center text-xl font-extrabold text-red-500 capitalize">¡Por favor espere! Cargando documento...</div>
            @endif
        @endif

        <a href="" wire:click.prevent="$dispatch('volviendo')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
            <i class="fa-solid fa-xmark"></i> Cancelar
        </a>
    </div>

    @if ($tipo===1)
        <livewire:google.gestion :id="$id"/>
    @endif

    <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-amber-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">

                </th>
                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('cliente')">
                    Cliente
                    @if ($ordena != 'cliente')
                        <i class="fas fa-sort"></i>
                    @else
                        @if ($ordenado=='ASC')
                            <i class="fas fa-sort-up"></i>
                        @else
                            <i class="fas fa-sort-down"></i>
                        @endif
                    @endif
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
                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('parame')">
                    Parámetro
                    @if ($ordena != 'parame')
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
                    Observaciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($soportes as $item)
                <tr class="bg-amber-50 border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-amber-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if ($item->google===1)
                            <a href="{{Storage::url($item->ruta)}}" target="_blank">
                                <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-orange-150 border border-gray-200 rounded-lg hover:bg-green-100 hover:text-orange-700 focus:z-10 focus:ring-2 focus:ring-orange-700 focus:text-orange-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-orange-500 dark:focus:text-white">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </a>
                        @else
                            <a href="{{ route('gestion.google', ['id' => $item->id]) }}">
                                <button type="button" class="px-4 py-2 text-sm font-medium text-gray-900 bg-orange-150 border border-gray-200 rounded-lg hover:bg-green-100 hover:text-orange-700 focus:z-10 focus:ring-2 focus:ring-orange-700 focus:text-orange-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-orange-500 dark:focus:text-white">
                                    <i class="fa-brands fa-google-drive"></i>
                                </button>
                            </a>
                        @endif

                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{$item->clien}}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                        {{$item->name}}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                        {{$item->parame}}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                        {{$item->observaciones}}
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-2 p-1 w-auto rounded-lg grid grid-cols-2 gap-4 bg-orange-100">
        <div>
            <label class="relative inline-flex items-center mb-4 cursor-pointer">
                <span class="ml-3 mr-3 text-sm font-medium text-gray-900 dark:text-gray-300">Registros:</span>
                <select wire:click="paginas($event.target.value)" id="countries" class="w-20 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500">
                    <option value=15>15</option>
                    <option value=20>20</option>
                    <option value=50>50</option>
                    <option value=100>100</option>
                </select>
            </label>
        </div>
        <div>
            {{ $soportes->links() }}
        </div>
    </div>
</div>
