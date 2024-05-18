<!DOCTYPE html>
<html>
<head>
    <title>Resultados de Búsqueda</title>
</head>
<body>
    <h1>Resultados de Búsqueda</h1>
    @if(isset($resultados) && count($resultados) > 0)
        <ul>
            @foreach($resultados as $resultado)
                <li>
                    <a href="{{ $resultado['google_shopping_url'] }}" target="_blank">
                        {{ $resultado['google_shopping_url'] }}
                    </a>
                    <p>ID de La Casa del Electrodoméstico: {{ $resultado['id_lacasaelectro'] }}</p>
                </li>
            @endforeach
        </ul>
    @else
        <p>No se encontraron resultados.</p>
    @endif
</body>
</html>
