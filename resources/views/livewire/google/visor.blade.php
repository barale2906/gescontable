<div class="iframe-container">
    @if ($documento && $is_ver)
        <iframe
            src="{{$documento->ruta}}"
            title="Google"
        ></iframe>
    @else
        <h1 class="h1">
            ¡No tiene acceso al documento por favor confirme con el administrador del sistema.!
        </h1>
        <br><br><br><br>
    @endif
    <a href="{{route('gestion.clientes')}}">
        VOLVER
    </a>
</div>
