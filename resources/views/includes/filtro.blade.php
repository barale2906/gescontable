
<form class=" max-w-3xl mx-auto">
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">
        {{$txt}}
    </label>
    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <input type="search"  wire:model.live="buscar"
        wire:keydown="buscaText()" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-orange-300 rounded-lg bg-orange-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-orange-700 dark:border-orange-600 dark:placeholder-orange-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="{{$txt}}"/>
        <a href="">
            <button type="button" class="text-black absolute end-2.5 bottom-2.5 bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                <i class="fa-solid fa-eraser"></i>
            </button>
        </a>
    </div>
    <div class="inline-flex rounded-md shadow-sm">
        <a href="#" wire:click.prevent="filtroMostrar" aria-current="page" class="px-4 py-2 text-sm font-medium text-orange-700  bg-orange-400 border border-orange-200 rounded-s-lg hover:bg-orange-200 focus:z-10 focus:ring-2 focus:ring-orange-700 focus:text-orange-700 dark:bg-orange-800 dark:border-orange-700 dark:text-white dark:hover:text-white dark:hover:bg-orange-700 dark:focus:ring-orange-500 dark:focus:text-white">
            <i class="fa-solid fa-filter"></i>
        </a>
        @can($permiso)
            <a href="#" wire:click.prevent="creando" class="px-4 py-2 text-sm font-medium text-gray-900 bg-yellow-400 border border-yellow-200 rounded-e-lg hover:bg-yellow-200 hover:text-yellow-700 focus:z-10 focus:ring-2 focus:ring-yellow-700 focus:text-yellow-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-yellow-500 dark:focus:text-white">
                <i class="fa-solid fa-plus"></i>
            </a>
        @endcan
    </div>
    @if ($is_filtro)
        <div class="grid md:grid-cols-3 md:gap-1">
            @if ($is_fecha)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
                    <label for="filtrofecdes" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="date" wire:model.live="filtrofecdes" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-orange-500 focus:outline-none focus:ring-0 focus:border-orange-600 peer"  />
                        <label for="filtrofecdes" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-orange-600 peer-focus:dark:text-orange-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Desde</label>
                    </div>
                    @if ($filtrofecdes)
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="date" wire:model.live="filtrofechas" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-orange-500 focus:outline-none focus:ring-0 focus:border-orange-600 peer"  />
                            <label for="filtrofechas" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-orange-600 peer-focus:dark:text-orange-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Hasta</label>
                        </div>
                    @endif
                </div>
            @endif
            @if ($is_parametro)
                <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

                    <label for="filtroparametro" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Parámetro</label>
                    <select wire:model.live="filtroparametro" id="filtroparametro"
                    class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-orange-500 focus:outline-none focus:ring-0 focus:border-orange-600 peer mb-2 capitalize">
                        <option >parametro</option>
                        @foreach ($parametros as $item)
                            <option value={{$item->id}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>
    @endif

</form>
