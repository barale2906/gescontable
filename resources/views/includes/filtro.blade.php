
<form class=" max-w-3xl mx-auto">
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">
        {{$txt}}
    </label>
    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <input type="search"  wire:model.live="buscar"
        wire:keydown="buscaText()" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-cyan-300 rounded-lg bg-cyan-50 focus:ring-cyan-500 focus:border-cyan-500 dark:bg-cyan-700 dark:border-cyan-600 dark:placeholder-cyan-400 dark:text-white dark:focus:ring-cyan-500 dark:focus:border-cyan-500" placeholder="{{$txt}}"/>
        <a href="">
            <button type="button" class="text-black absolute end-2.5 bottom-2.5 bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
                <i class="fa-solid fa-eraser"></i>
            </button>
        </a>
    </div>
    <div class="inline-flex rounded-md shadow-sm">
        <a href="#" wire:click.prevent="filtroMostrar" aria-current="page" class="px-4 py-2 text-sm font-medium text-cyan-700  bg-cyan-400 border border-cyan-200 rounded-s-lg hover:bg-cyan-200 focus:z-10 focus:ring-2 focus:ring-cyan-700 focus:text-cyan-700 dark:bg-cyan-800 dark:border-cyan-700 dark:text-white dark:hover:text-white dark:hover:bg-cyan-700 dark:focus:ring-cyan-500 dark:focus:text-white">
            <i class="fa-solid fa-filter"></i>
        </a>
        @can($permiso)
            <a href="#" wire:click.prevent="creando" class="px-4 py-2 text-sm font-medium text-gray-900 bg-green-400 border border-gray-200 rounded-e-lg hover:bg-green-200 hover:text-green-700 focus:z-10 focus:ring-2 focus:ring-green-700 focus:text-green-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-green-500 dark:focus:text-white">
                <i class="fa-solid fa-plus"></i>
            </a>
        @endcan
    </div>
    @if ($is_filtro)
        <div class="grid md:grid-cols-6 md:gap-6">
            alex
        </div>
    @endif
</form>
