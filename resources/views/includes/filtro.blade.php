
<form class=" max-w-3xl mx-auto">
    <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-5 group">
            <label for="email-address-icon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{$txt}}</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" wire:model.live="buscar"
                wire:keydown="buscaText()" class="bg-cyan-50 border border-cyan-300 text-cyan-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block w-full ps-10 p-2.5  dark:bg-cyan-700 dark:border-cyan-600 dark:placeholder-cyan-400 dark:text-white dark:focus:ring-cyan-500 dark:focus:border-cyan-500" placeholder={{$txt}}>
            </div>
        </div>
        <div class="inline-flex rounded-md shadow-sm">
                <a href="#" wire:click.prevent="filtroMostrar" aria-current="page" class="px-4 py-2 text-sm font-medium text-cyan-700  bg-cyan-400 border border-cyan-200 rounded-s-lg hover:bg-cyan-200 focus:z-10 focus:ring-2 focus:ring-cyan-700 focus:text-cyan-700 dark:bg-cyan-800 dark:border-cyan-700 dark:text-white dark:hover:text-white dark:hover:bg-cyan-700 dark:focus:ring-cyan-500 dark:focus:text-white">
                    <i class="fa-solid fa-filter"></i>
                </a>
            @can($permiso)
                <a href="#" wire:click.prevent="" class="px-4 py-2 text-sm font-medium text-gray-900 bg-green-400 border border-gray-200 rounded-e-lg hover:bg-green-200 hover:text-green-700 focus:z-10 focus:ring-2 focus:ring-green-700 focus:text-green-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-green-500 dark:focus:text-white">
                    <i class="fa-solid fa-plus"></i>
                </a>
            @endcan
        </div>
    </div>
    @if ($is_filtro)
        <div class="grid md:grid-cols-6 md:gap-6">
            alex
        </div>
    @endif
</form>
