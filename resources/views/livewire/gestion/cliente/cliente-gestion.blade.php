<div>

    @if ($is_asignado)
        <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white uppercase">
                {{$actual->name}} NIT: {{$actual->nit}} - {{$actual->DV}}
            </h5>
            <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                Datos importantes del cliente:
            </p>
            <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
                <a href="#" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                    <i class="fa-solid fa-circle-info"></i>
                    <div class="text-left rtl:text-right">
                        <div class="mb-1 text-xs">Representante Legal</div>
                        <div class="-mt-1 font-sans text-sm font-semibold capitalize">{{$actual->representante_legal}}</div>
                    </div>
                </a>
                <a href="#" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                    <i class="fa-solid fa-circle-info"></i>
                    <div class="text-left rtl:text-right">
                        <div class="mb-1 text-xs">Cédula Representante</div>
                        <div class="-mt-1 font-sans text-sm font-semibold">{{$actual->cedula_rl}}</div>
                    </div>
                </a>
                <a href="#" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                    <i class="fa-solid fa-circle-info"></i>
                    <div class="text-left rtl:text-right">
                        <div class="mb-1 text-xs">Dirección</div>
                        <div class="-mt-1 font-sans text-sm font-semibold">{{$actual->direccion}}</div>
                    </div>
                </a>
                <a href="#" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                    <i class="fa-solid fa-circle-info"></i>
                    <div class="text-left rtl:text-right">
                        <div class="mb-1 text-xs">Teléfono</div>
                        <div class="-mt-1 font-sans text-sm font-semibold">{{$actual->telefono}}</div>
                    </div>
                </a>
                <a href="#" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                    <i class="fa-solid fa-circle-info"></i>
                    <div class="text-left rtl:text-right">
                        <div class="mb-1 text-xs">Persona de contacto</div>
                        <div class="-mt-1 font-sans text-sm font-semibold">{{$actual->persona_contacto}}</div>
                    </div>
                </a>
                <a href="#" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                    <i class="fa-solid fa-circle-info"></i>
                    <div class="text-left rtl:text-right">
                        <div class="mb-1 text-xs">Correo Electrónico</div>
                        <div class="-mt-1 font-sans text-sm font-semibold">{{$actual->email}}</div>
                    </div>
                </a>
                <div class="max-w-sm p-1 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <i class="fa-solid fa-circle-info"></i>
                    <a href="#">
                        <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Software Contable</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
                        {{$actual->software_contable}}
                    </p>
                </div>
                <div class="max-w-sm p-1 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <i class="fa-solid fa-circle-info"></i>
                    <a href="#">
                        <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Usuario software</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
                        {{$actual->usuario}}
                    </p>
                </div>
                <div class="max-w-sm p-1 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <i class="fa-solid fa-circle-info"></i>
                    <a href="#">
                        <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Llave</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
                        {{$actual->llave}}
                    </p>
                </div>
                <div class="max-w-sm p-1 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <i class="fa-solid fa-circle-info"></i>
                    <a href="#">
                        <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Matricula</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
                        {{$actual->matricula}}
                    </p>
                </div>

            </div>

            <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                Seleccione lo que quiere hacer:
            </p>
            <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <i class="fa-solid fa-circle-info"></i>
                    <span class="-mt-1 font-sans text-sm font-semibold">Programación</span>
                </button>
                <button type="button" class="focus:outline-none text-white bg-cyan-700 hover:bg-cyan-800 focus:ring-4 focus:ring-cyan-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-green-800">
                    Gestión
                </button>
                <button type="button" wire:click.prevent="cargasoporte" class="focus:outline-none text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-900">
                    Cargar soporte
                </button>
                <button type="button" wire:click.prevent="activbitacoras" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">
                    Bitacora
                </button>
                <button type="button" wire:click.prevent="$dispatch('cancelando')" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                    Cancelar
                </button>
            </div>
        </div>
    @else
        <a href="" wire:click.prevent="$dispatch('cancelando')">
            <h1 class=" bg-cyan-300 text-center content-center font-semibold rounded-full p-4 text-3xl capitalize">
                No tiene asignado el cliente. <span class=" text-red-600">Volver</span>
            </h1>
        </a>
    @endif

    @if ($is_bitacora)
        <div class="w-full max-w-md p-4 bg-yellow-300 border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Bitacora de cambios de la información básica del cliente</h5>
                <a href="#" wire:click.prevent="volver" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                    Cerrar
                </a>
            </div>
            <div class="flow-root bg-yellow-300">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($bitacoras as $item)
                    <li class="py-3 sm:py-4">
                        <div class="flex items-center">
                            <div class="flex-1 min-w-0 ms-4">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{$item}}
                                </p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if ($is_soporte)
        <livewire:gestion.soporte.soportes-lista :id="$actual->id" />
    @endif

</div>
