<!DOCTYPE html>
<html>
<head>
    <title>Buscar Producto</title>
</head>
<body>
    <h1>Buscar Producto</h1>
    <form action="{{ route('buscar') }}" method="POST">
        @csrf
        <label for="producto">Nombre, referencia o SKU del producto:</label>
        <input type="text" id="producto" name="producto" required>
        <button type="submit">Buscar</button>
    </form>
</body>
</html>
