<!doctype html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>{{config('app.name', 'Laravel')}}</title>
    <link rel="icon" href="{{asset('storage/ico/favicon.ico')}}">

    <!-- Scripts -->
    <script src="{{asset('js/app.js')}}"></script>

    <!-- Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyARXT3C5cJ7pgk9pwhIPzEdASmMjCyhZjc"></script>

    <!-- Google Gráficas -->
    <script src="https://www.google.com/jsapi"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">

    <!-- Fontawesome By CIRG -->
    <link rel="stylesheet" href="{{asset('fontawesome/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('fontawesome/css/brands.css')}}">
    <link rel="stylesheet" href="{{asset('fontawesome/css/solid.css')}}">
    <link rel="stylesheet" href="{{asset('fontawesome/css/regular.css')}}">

    <!-- Detepicker By CIRG -->
    <script src="{{asset('datetimepicker/js/gijgo.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('datetimepicker/css/gijgo.min.css')}}">
    <!-- Detepicker languaje By CIRG -->
    <script src="{{asset('datetimepicker/js/messages/messages.es-es.min.js')}}"></script>

    <!-- Checkbox By CIRG -->
    <link rel="stylesheet" href="{{asset('checkbox/css/bootstrap4-toggle.min.css')}}">
    <script src="{{asset('checkbox/js/bootstrap4-toggle.js')}}"></script>

    <!-- Custom File Input By CIRG -->
    <link rel="stylesheet" href="{{asset('bs-custom-file-input/css/bs-custom-file-input.css')}}">
    <script src="{{asset('bs-custom-file-input/js/bs-custom-file-input.min.js')}}"></script>

    <!-- Custom Tag Input By CIRG -->
    <link rel="stylesheet" href="{{asset('tag-input/tagsinput.css')}}">
    <script src="{{asset('tag-input/tagsinput.js')}}"></script>

    <!-- Custom Chosen By CIRG -->
    <link rel="stylesheet" href="{{asset('chosen/component-chosen.min.css')}}">
    <script src="{{asset('chosen/chosen.js')}}"></script>

    <!-- Custom Confirm By CIRG -->
    <link rel="stylesheet" href="{{asset('confirm/dist/jquery-confirm.min.css')}}">
    <script src="{{asset('confirm/dist/jquery-confirm.min.js')}}"></script>

    <!-- Custom QRCode By CIRG -->
    <script src="{{asset('QRCode/QRCode.js')}}" type="text/javascript">
    
    <!-- Maps By CIRG -->
    <script src="{{asset('maps/maps.add.js')}}"></script>
    <script src="{{asset('maps/maps.view.js')}}"></script>

    <!-- Graficas By CIRG -->
    <script src="{{asset('graficas/graficas.js')}}"></script>

    <!-- Custom By CIRG -->
    <script src="{{asset('js/custom.js')}}"></script>

</head>
<body class="intranet-fondo">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand text-white" href="{{url('/')}}">
                    {{config('app.name', 'Laravel')}}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        @auth
                            
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-sitemap icon-color"></i> Catálogos<span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @can('viewAny', \App\Models\Articulo::class)
                                        <a class="dropdown-item" href="{{url('/articulos')}}">
                                            <i class="fas fa-desktop icon-color"></i> Artículos
                                        </a>
                                    @endcan
                                    @can('viewAny', \App\Models\Marca::class)
                                        <a class="dropdown-item" href="{{url('/marcas')}}">
                                            <i class="fas fa-tag icon-color"></i> Marcas
                                        </a>
                                    @endcan
                                    @can('viewAny', \App\Models\Operativo::class)
                                        <a class="dropdown-item" href="{{url('/operativos')}}">
                                            <i class="fab fa-microsoft icon-color"></i> Sistemas operativos
                                        </a>
                                    @endcan
                                    @can('viewAny', \App\Models\Area::class)
                                        <a class="dropdown-item" href="{{url('/areas')}}">
                                            <i class="fas fa-building icon-color"></i> Áreas
                                        </a>
                                    @endcan
                                    @can('viewAny', \App\Models\Categoria::class)
                                        <a class="dropdown-item" href="{{url('/categorias')}}">
                                            <i class="fas fa-user-tag icon-color"></i> Categorías
                                        </a>
                                    @endcan
                                    @can('viewAny', \App\Models\Puesto::class)
                                        <a class="dropdown-item" href="{{url('/puestos')}}">
                                            <i class="fas fa-user-shield icon-color"></i> Puestos
                                        </a>
                                    @endcan
                                    @can('viewAny', \App\Models\Funcionario::class)
                                        <a class="dropdown-item" href="{{url('/funcionarios')}}">
                                            <i class="fas fa-user-tie icon-color"></i> Funcionarios
                                        </a>
                                    @endcan
                                    @can('viewAny', \App\Models\Cedula::class)
                                        <a class="dropdown-item" href="{{url('/cedulas')}}">
                                            <i class="fas fa-file-alt icon-color"></i> Cédulas
                                        </a>
                                    @endcan

                                    <div class="dropdown-divider"></div>
                                    
                                    @can('viewAny', \App\Models\Fabrica::class)
                                        <a class="dropdown-item" href="{{url('/fabricas')}}">
                                            <i class="fas fa-industry icon-color"></i> Fabricas
                                        </a>
                                    @endcan
                                    @can('viewAny', \App\Models\Vtipo::class)
                                        <a class="dropdown-item" href="{{url('/tipos')}}">
                                            <i class="fas fa-car icon-color"></i> Tipos
                                        </a>
                                    @endcan
                                    @can('viewAny', \App\Models\Transmision::class)
                                        <a class="dropdown-item" href="{{url('/transmisiones')}}">
                                            <i class="fas fa-cogs icon-color"></i> Transmisiones
                                        </a>
                                    @endcan
                                    @can('viewAny', \App\Models\Combustible::class)
                                        <a class="dropdown-item" href="{{url('/combustibles')}}">
                                            <i class="fas fa-gas-pump icon-color"></i> Combustibles
                                        </a>
                                    @endcan
                                    @can('viewAny', \App\Models\Vauto::class)
                                        <a class="dropdown-item" href="{{url('/autos')}}">
                                            <i class="fas fa-car-side icon-color"></i> Autos
                                        </a>
                                    @endcan
                                </div>
                            </li>
                
                            @can('viewAny', \App\Models\Vbien::class)
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-desktop icon-color"></i> Bienes<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @can('viewAny', \App\Models\Vbien::class)
                                            <a class="dropdown-item" href="{{url('/bienes')}}">
                                                <i class="fas fa-desktop icon-color"></i> Bienes
                                            </a>
                                        @endcan
                                        @can('viewAny', \App\Models\Retorno::class)
                                            <a class="dropdown-item" href="{{url('/retornos')}}">
                                                <i class="fas fa-desktop icon-color"></i> Devolución
                                            </a>
                                        @endcan
                                        @can('viewAny', \App\Models\Vpase::class)
                                            <a class="dropdown-item" href="{{url('/pases')}}">
                                                <i class="fas fa-file-alt icon-color"></i> Pase de salida
                                            </a>
                                        @endcan

                                        <div class="dropdown-divider"></div>

                                        @can('viewAny', \App\Models\Resguardo::class)
                                            <a class="dropdown-item" href="{{url('/resguardos')}}">
                                                <i class="fas fa-print icon-color"></i> Impresión resguardos
                                            </a>
                                        @endcan
                                        @can('viewAny', \App\Models\Devolucion::class)
                                            <a class="dropdown-item" href="{{url('/devoluciones')}}">
                                                <i class="fas fa-print icon-color"></i> Impresión devoluciones
                                            </a>
                                        @endcan
                                    </div>                                
                                </li>
                            @endcan

                            @can('viewAny', \App\Models\Factura::class)
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-file-invoice-dollar icon-color"></i> Facturas<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @can('viewAny', \App\Models\Factura::class)
                                            <a class="dropdown-item" href="{{url('/facturas')}}">
                                                <i class="fas fa-file-invoice-dollar icon-color"></i> Facturas
                                            </a>
                                        @endcan
                                        @can('viewAny', \App\Models\Vvale::class)
                                            <a class="dropdown-item" href="{{url('/vales')}}">
                                                <i class="fas fa-file-alt icon-color"></i> Vales
                                            </a>
                                        @endcan
                                    </div>                                
                                </li>
                            @endcan

                            @can('viewAny', \App\Models\Pemexfactura::class)
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-file-invoice-dollar icon-color"></i> Pemex<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @can('viewAny', \App\Models\Pemexfactura::class)
                                            <a class="dropdown-item" href="{{url('/pemexfacturas')}}">
                                                <i class="fas fa-file-invoice-dollar icon-color"></i> Donaciones
                                            </a>
                                        @endcan
                                        @can('viewAny', \App\Models\Vpemexvale::class)
                                            <a class="dropdown-item" href="{{url('/pemexvales')}}">
                                                <i class="fas fa-file-alt icon-color"></i> Dotaciones
                                            </a>
                                        @endcan
                                    </div>                                
                                </li>
                            @endcan

                            @can('viewAny', \App\Models\User::class)
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-users icon-color"></i> Usuarios<span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @can('viewAny', \App\Models\Role::class)
                                            <a class="dropdown-item" href="{{url('/roles')}}">
                                                <i class="fas fa-user-tag icon-color"></i> Roles
                                            </a>
                                        @endcan
                                        @can('viewAny', \App\Models\User::class)
                                            <a class="dropdown-item" href="{{url('/usuarios')}}">
                                                <i class="fas fa-user icon-color"></i> Usuarios
                                            </a>
                                        @endcan
                                    </div>
                                </li>
                            @endcan

                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{route('login') }}">{{__('Acceso')}}</a>
                            </li>
                            {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('register')}}">{{__('Registro')}}</a>
                                </li>
                            @endif --}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-tie icon-color"></i> {{Auth::user()->name}}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('logout')}}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-power-off icon-color"></i> {{__('Salir')}}
                                    </a>

                                    <form id="logout-form" action="{{route('logout')}}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>