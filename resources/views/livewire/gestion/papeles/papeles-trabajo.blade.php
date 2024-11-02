<div>

    <h1 class=" text-center font-semibold p-6">
        Listado de movimientos para <span class=" uppercase">{{$elegido->name}}</span>
    </h1>
    @include('includes.filtro')
    <table class=" text-sm text-left text-gray-500 dark:text-gray-400  m-4">
        <thead class=" bg-green-200 text-xs text-gray-700  dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" colspan="8" class="px-6 py-3 uppercase text-center" >
                    Estos son los campos del archivo csv con el que se debe cargar los datos, se deben cargar en este mismo orden.
                </th>
            </tr>
            <tr>
                <th scope="col" class="px-6 py-3" >
                    Fecha del movimiento (aaaa-mm-dd con este formato)
                </th>
                <th scope="col" class="px-6 py-3" >
                    Documento (factura, recibo caja, remisión, etc)
                </th>
                <th scope="col" class="px-6 py-3" >
                    Número Documento
                </th>
                <th scope="col" class="px-6 py-3" >
                    A nombre de quien esta el documento (destinatario)
                </th>
                <th scope="col" class="px-6 py-3" >
                    Documento del destinatario
                </th>
                <th scope="col" class="px-6 py-3">
                    Valor
                </th>
                <th scope="col" class="px-6 py-3">
                    IVA
                </th>
                <th scope="col" class="px-6 py-3">
                    Total
                </th>
            </tr>
        </thead>
    </table>
    <div class="grid sm:grid-cols-1 md:grid-cols-5 gap-3 m-3">

        @if (!$filtroparametro)
            <div class="mb-6">
                <label for="archivo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargue Archivo soporte</label>
                <input type="file" id="archivo" accept=".csv" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full m-2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.live="archivo">
                @error('archivo')
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">¡IMPORTANTE!</span>  {{ $message }} .
                    </div>
                @enderror
                <div wire:loading wire:target="archivo" class="text-center text-xl font-extrabold text-red-500 uppercase">Cargando...</div>
            </div>

            @if ($archivo)
                <a href="" wire:click.prevent="cargar()" class="text-black bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                    <i class="fa-solid fa-upload"></i> Crear
                </a>
            @endif

            <a href="" wire:click.prevent="$dispatch('volviendo')" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-cyan-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                <i class="fa-solid fa-xmark"></i> Cancelar
            </a>
            <div class="relative z-0 w-full mb-5 group">
                <select wire:model.live="param" id="param"
                    class="block py-2.5 px-2 w-full text-xs md:text-sm capitalize text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer mb-2">
                        <option value=0>A Calcular...</option>
                        @foreach ($parametros as $item)
                            <option value={{$item->id}}>{{$item->name}} - {{$item->porcentaje}} %</option>
                        @endforeach
                    </select>
                <label for="param" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Item a calcular</label>
            </div>
        @endif


        @if ($paradeta)
            <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                <h5 class="mb-2 text-md font-bold tracking-tight text-gray-900 dark:text-white uppercase">{{$paradeta->name}}</h5>
                <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-sm font-extrabold">{{$paradeta->porcentaje}} %</dt>
                        <dd class="text-gray-500 text-xs dark:text-gray-400">Porcentaje Aplicado</dd>
                    </div>
                    @if ($valor)
                        <div class="flex flex-col items-center justify-center">
                            <dt class="mb-2 text-sm font-extrabold">$ {{number_format($valor->sum('valor'), 0, ',', '.')}}</dt>
                            <dd class="text-gray-500 text-xs dark:text-gray-400">Valor Calculado</dd>
                        </div>
                    @endif
                </div>
            </a>
            @if ($valor && !$filtroparametro)
                <div id="alert-additional-content-1" class="p-4 mb-4 text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <h3 class="text-lg font-medium">CONFIRMA LA TRANSACCIÓN</h3>
                    </div>
                    <div class="mt-2 mb-4 text-sm">
                        ¿Esta seguro(a) de cargar esta información?, al generarla es irrversible el proceso.
                    </div>
                    <div class="flex">
                        <button type="button" wire:click.prevent="confirmar" class="text-white bg-blue-800 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="me-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                            <path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
                            </svg>
                            Guardar Calculos
                        </button>
                        @if ($is_confirma)
                            <button type="button" wire:click.prevent="finalizar" class="text-blue-800 bg-transparent border border-blue-800 hover:bg-blue-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-blue-600 dark:border-blue-600 dark:text-blue-400 dark:hover:text-white dark:focus:ring-blue-800" data-dismiss-target="#alert-additional-content-1" aria-label="Close">
                                ¡Seguro(a), de clic aquí!
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        @endif
    </div>

    @if ($is_errores)
        @foreach ($crterrores as $item)
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">Error:</span> {{$item}}.
            </div>
        @endforeach
    @endif

    <table class=" text-sm text-left text-gray-500 dark:text-gray-400 mt-4">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('id')">
                    id
                    @if ($ordena != 'id')
                        <i class="fas fa-sort"></i>
                    @else
                        @if ($ordenado=='ASC')
                            <i class="fas fa-sort-up"></i>
                        @else
                            <i class="fas fa-sort-down"></i>
                        @endif
                    @endif
                </th>
                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('fecha')">
                    Fecha
                    @if ($ordena != 'fecha')
                        <i class="fas fa-sort"></i>
                    @else
                        @if ($ordenado=='ASC')
                            <i class="fas fa-sort-up"></i>
                        @else
                            <i class="fas fa-sort-down"></i>
                        @endif
                    @endif
                </th>
                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('documento')">
                    Documento
                    @if ($ordena != 'documento')
                        <i class="fas fa-sort"></i>
                    @else
                        @if ($ordenado=='ASC')
                            <i class="fas fa-sort-up"></i>
                        @else
                            <i class="fas fa-sort-down"></i>
                        @endif
                    @endif
                </th>
                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('numero')">
                    Número Documento
                    @if ($ordena != 'numero')
                        <i class="fas fa-sort"></i>
                    @else
                        @if ($ordenado=='ASC')
                            <i class="fas fa-sort-up"></i>
                        @else
                            <i class="fas fa-sort-down"></i>
                        @endif
                    @endif
                </th>
                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('destinatario')">
                    Destinatario
                    @if ($ordena != 'destinatario')
                        <i class="fas fa-sort"></i>
                    @else
                        @if ($ordenado=='ASC')
                            <i class="fas fa-sort-up"></i>
                        @else
                            <i class="fas fa-sort-down"></i>
                        @endif
                    @endif
                </th>
                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('documento_dest')">
                    Documento Destinatario
                    @if ($ordena != 'documento_dest')
                        <i class="fas fa-sort"></i>
                    @else
                        @if ($ordenado=='ASC')
                            <i class="fas fa-sort-up"></i>
                        @else
                            <i class="fas fa-sort-down"></i>
                        @endif
                    @endif
                </th>
                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('valor')">
                    Valor
                    @if ($ordena != 'valor')
                        <i class="fas fa-sort"></i>
                    @else
                        @if ($ordenado=='ASC')
                            <i class="fas fa-sort-up"></i>
                        @else
                            <i class="fas fa-sort-down"></i>
                        @endif
                    @endif
                </th>
                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('iva')">
                    IVA
                    @if ($ordena != 'iva')
                        <i class="fas fa-sort"></i>
                    @else
                        @if ($ordenado=='ASC')
                            <i class="fas fa-sort-up"></i>
                        @else
                            <i class="fas fa-sort-down"></i>
                        @endif
                    @endif
                </th>
                <th scope="col" class="px-6 py-3" style="cursor: pointer;" wire:click="organizar('total')">
                    Total
                    @if ($ordena != 'total')
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
                    Calculos
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($papeles as $item)
                @if (!$filtroparametro)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            @if ($param)
                                <a href="" wire:click.prevent="calculo({{$item->id}})" class="text-black bg-gradient-to-r from-blue-300 via-blue-400 to-blue-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                    <i class="fa-solid fa-upload"></i>
                                </a>
                                @if ($valor)
                                    @foreach ($valor as $val)
                                        @if ($val->papele_id===$item->id)
                                            <a href="" wire:click.prevent="eliminar({{$val->id}})" class="text-black bg-gradient-to-r from-orange-300 via-orange-400 to-orange-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-orange-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                                $ {{number_format($val->valor, 0, ',', '.')}}
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                            <a href="" wire:click.prevent="eliminarregistro({{$item->id}})" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                            @if ($is_borraregistro && $borrareg===$item->id)
                                <a href="" wire:click.prevent="eliminarconfirma({{$item->id}})" class="text-black bg-gradient-to-r from-red-300 via-red-400 to-red-500 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 capitalize">
                                    <i class="fa-solid fa-trash-can"></i> Borrar Documento
                                </a>
                            @endif
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$item->fecha}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                            {{$item->documento}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                            {{$item->numero}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                            {{$item->destinatario}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                            {{$item->documento_dest}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize text-right">
                            $ {{number_format($item->valor, 0, ',', '.')}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize text-right">
                            $ {{number_format($item->iva, 0, ',', '.')}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize text-right">
                            $ {{number_format($item->total, 0, ',', '.')}}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize text-center">
                            {{$item->calculos}}
                        </th>
                    </tr>
                @else
                    @foreach ($valor as $val)
                        @if ($val->papele_id===$item->id)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-green-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                                        <span class="font-medium uppercase">{{$paradeta->name}}</span> $ {{number_format($val->valor, 0, ',', '.')}}
                                    </div>
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$item->fecha}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                    {{$item->documento}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                    {{$item->numero}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                    {{$item->destinatario}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
                                    {{$item->documento_dest}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize text-right">
                                    $ {{number_format($item->valor, 0, ',', '.')}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize text-right">
                                    $ {{number_format($item->iva, 0, ',', '.')}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize text-right">
                                    $ {{number_format($item->total, 0, ',', '.')}}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize text-center">
                                    {{$item->calculos}}
                                </th>
                            </tr>
                        @endif
                    @endforeach
                @endif

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
            {{ $papeles->links() }}
        </div>
    </div>
</div>
