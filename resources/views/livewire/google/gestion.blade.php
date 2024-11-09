<div>
    <div class="grid md:grid-cols-3 md:gap-1">
        <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
            <label for="nombre" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Nombre del archivo</label>
            <div class="relative z-0 w-full mb-5 group">
                <input wire:model.live="nombre" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"  />
                <label for="nombre" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nombre</label>
            </div>
        </div>
        <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

            <label for="tipo" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Tipo documento</label>
            <select wire:model.live="tipo" id="tipo"
            class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                <option >Tipo ...</option>
                <option value=1>Hoja de Cálculo</option>
                <option value=2>Documento de texto</option>
                <option value=3>Presentación</option>
            </select>
        </div>

        <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">

            <label for="param" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">
                Carpeta de gestión
            </label>
            <select wire:model.live="param" id="param"
            class="block py-2.5 px-2 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2 capitalize">
                <option >Carpeta ...</option>
                @foreach ($parametros as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <button type="button" wire:click.prevent="definicion" class="focus:outline-none text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-900">
        Google
    </button>
    @if ($is_google)
        <div class="w-full h-screen">
            <iframe
                src="{{$ruta}}"
                class="w-full h-full border-0"
                title="Google"
            ></iframe>
        </div>
    @endif
</div>
