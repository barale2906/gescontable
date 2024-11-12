<div>
    <h1 class=" text-center uppercase sm:text-xs md:text-4xl font-extrabold">
        programaciones por semana.
    </h1>
    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-1 p-2 w-auto rounded-lg ">
        <div></div>
        <div class="mb-6 ring-1 ring-zinc-600 rounded-md p-2">
            <label for="filtrodesde" class="block mb-2 text-xs md:text-sm font-medium text-gray-900 dark:text-white">Hasta que fecha</label>
            <div class="relative z-0 w-full mb-5 group">
                <input type="date" wire:model.live="filtrodesde" class="block py-2.5 px-0 w-full text-xs md:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-orange-500 focus:outline-none focus:ring-0 focus:border-orange-600 peer"  />
                <label for="filtrodesde" class="peer-focus:font-medium absolute text-xs md:text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-orange-600 peer-focus:dark:text-orange-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Hasta que fecha (Mostrará 7 días adelante a la fecha elegida.)</label>
            </div>
        </div>
    </div>

    @if ($is_consulta)
        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-2 bg-orange-100 p-2 w-auto rounded-lg ">
            @foreach ($dias as $item)
                <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">{{$item}}</h5>
                    </div>
                    <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($programaciones as $value)
                                    @if ($value->fin===$item)
                                        <li class="py-3 sm:py-4">
                                            <div class="flex items-center">
                                                <div class="flex-1 min-w-0 ms-4">
                                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white capitalize">
                                                        {{$value->cliente->name}}
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        {{$value->name}}
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        Desde: {{$value->inicio}} - Hasta: {{$value->fin}}
                                                    </p>
                                                </div>
                                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                    @if ($value->status)
                                                                <span class=" text-red-600 font-extrabold"> <i class="fa-solid fa-bell"></i></span>
                                                            @else
                                                                <span class=" text-green-600">
                                                                    <i class="fa-solid fa-check"></i>
                                                                </span>
                                                            @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                    </div>
                </div>
            @endforeach


        </div>
    @else
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span class="font-medium">¡NO TIENE CLIENTES ASIGNADOS! </span> Para realizar muchas de las funciones dentro del sistema deberá tener clientes asignados, informe al administrador del sistema.
        </div>
    @endif
</div>
