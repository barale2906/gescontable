<nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/dashboard" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{asset('img/logo.jpg')}}" class="h-8" alt="{{env('APP_NAME')}} Logo" />
            <span class="self-center text-lg font-semibold whitespace-nowrap dark:text-white">
                {{env('APP_NAME')}}
            </span>
        </a>
        <button data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-dropdown" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
            <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                @foreach ($menus as $item)
                    @can($item->permiso)
                        <li>
                            <button id="dropdownNavbarLink" data-dropdown-toggle="{{$item->id}}" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                                <i class="{{$item->icono}} mr-2"></i>
                                {{$item->name}}

                            </button>
                            <!-- Dropdown menu -->
                                <div id="{{$item->id}}" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                                        @foreach ($item->submenus as $sub)
                                            <li>
                                                <a href="{{route($sub->ruta)}}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white {{request()->routeIs($sub->identificaRuta) ? 'bg-gray-100' : ''}}">
                                                    <i class="{{$sub->icono}} mr-2"></i>
                                                    {{$sub->name}}
                                                </a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                        </li>
                    @endcan

                @endforeach

                <li>
                    <button id="dropdownNavbarLink" data-dropdown-toggle="perfil" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
                        {{ Auth::user()->name }}
                        <i class="fa-solid fa-chevron-down ml-2"></i>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="perfil" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <div class="py-1">
                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        </div>
                        <div class="py-1">
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</nav>
