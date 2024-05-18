<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BuscarProducto extends Command
{
    protected $signature = 'buscar:producto {producto}';
    protected $description = 'Buscar un producto en Google Shopping';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Maneja la ejecución del comando para buscar productos usando la API de Google Custom Search.
     *
     * @return void
     */
    public function handle()
    {
        // Obtener el término de búsqueda del argumento pasado al comando
        $producto = $this->argument('producto');

        // Obtener la API Key y el Custom Search Engine ID desde el archivo .env
        $apiKey = env('GOOGLE_API_KEY');
        $searchEngineId = env('GOOGLE_SEARCH_ENGINE_ID');

        // URL de la API de Google Custom Search
        $apiUrl = 'https://www.googleapis.com/customsearch/v1';

        // Realizar la solicitud a la API de Google Custom Search
        $response = Http::get($apiUrl, [
            'key' => $apiKey,
            'cx' => $searchEngineId,
            'q' => $producto,
        ]);

        // Inicializar el array para almacenar los resultados
        $resultados = [];

        // Verificar si la solicitud fue exitosa
        if ($response->successful()) {
            // Decodificar la respuesta JSON
            $data = $response->json();

            // Registrar la respuesta para depuración
            Log::debug('Respuesta de la API de Google Custom Search', $data);

            // Verificar si hay resultados en la respuesta
            if (isset($data['items'])) {
                // Iterar sobre los elementos de la respuesta
                foreach ($data['items'] as $item) {
                    // Obtener el enlace del resultado
                    $link = $item['link'];

                    // Verificar si el enlace pertenece a "La Casa del Electrodoméstico"
                    if (strpos($link, 'lacasadelelectrodomestico.com') !== false) {
                        // Recortar la URL para que solo incluya la parte hasta /offers
                        $googleShoppingUrl = strtok($link, '?');

                        // Obtener el ID del producto de "La Casa del Electrodoméstico" desde la URL
                        preg_match('/IDArticulo~(\d+)/', $link, $matches);
                        $idLacasaelectro = $matches[1] ?? null;

                        // Agregar el resultado al array de resultados
                        $resultados[] = [
                            'google_shopping_url' => $googleShoppingUrl,
                            'id_lacasaelectro' => $idLacasaelectro,
                        ];
                    }
                }
            }
        } else {
            // Registrar un error si la solicitud no fue exitosa
            Log::error('Error en la solicitud a la API de Google Custom Search', [
                'response' => $response->json(),
                'producto' => $producto
            ]);
        }

        // Verificar si no se encontraron resultados
        if (empty($resultados)) {
            // Registrar un aviso si no se encontraron resultados para la consulta
            Log::warning('No se encontraron resultados para la consulta: ' . $producto);
        }

        // Devolver los resultados como salida del comando
        $this->line(json_encode($resultados));
    }
}

