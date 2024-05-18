<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ProductoController extends Controller
{
    // Método para mostrar el formulario de búsqueda
    public function index()
    {
        return view('buscar');
    }

    /**
     * Maneja la solicitud de búsqueda de productos.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP que contiene los datos del formulario.
     * @return \Illuminate\View\View La vista que muestra los resultados de la búsqueda.
     */
    public function buscar(Request $request)
    {
        // Obtener el término de búsqueda del formulario
        $producto = $request->input('producto');

        // Ejecutar el comando de Artisan para realizar la búsqueda
        Artisan::call('buscar:producto', ['producto' => $producto]);

        // Obtener los resultados del comando de Artisan
        $resultados = json_decode(Artisan::output(), true);

        // Retornar la vista de resultados con los resultados obtenidos
        return view('resultados', compact('resultados', 'producto'));
    }

}

