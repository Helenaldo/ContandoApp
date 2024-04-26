<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    private $url;

    /**
     * Construtor da classe ApiService.
     * Define a URL base para as requisições API a partir de uma variável de ambiente ou usa um valor padrão.
     */
    public function __construct()
    {
        // Atribui a URL base para as requisições a partir de uma variável de ambiente ou usa um valor padrão se não estiver definida.
        $this->url = env('API_BASE_URL', 'http://default-url-if-not-set-in-env/api');
    }

    /**
     * Envia uma requisição GET para um endpoint específico usando um token de autenticação.
     *
     * @param string $endpoint Endpoint da API para a requisição GET.
     * @param string $token Token de autenticação para acesso à API.
     * @return array Resposta da API convertida em array.
     */
    public function get(string $endpoint, string $token): array
    {
        // Realiza uma requisição GET com o token de autenticação incluído no cabeçalho.
        $response = Http::acceptJson()->withToken($token)->get($this->url . $endpoint);

        // Verifica se a requisição foi bem-sucedida e retorna a resposta ou um erro.
        if ($response->successful()) {
            return $response->json();
        } else {
            return ['error' => 'Requisição falhou com o status: ' . $response->status()];
        }
    }

    /**
     * Envia uma requisição POST para um endpoint específico, opcionalmente usando um token de autenticação.
     *
     * @param string $endpoint Endpoint da API para a requisição POST.
     * @param array $data Dados a serem enviados na requisição POST.
     * @param string|null $token Token de autenticação opcional para acesso à API.
     * @return array Resposta da API convertida em array.
     */
    public function post(string $endpoint, array $data, ?string $token = null): array
    {
        // Realiza uma requisição POST, incluindo o token de autenticação se fornecido.
        if ($token) {
            $response = Http::acceptJson()->withToken($token)->post($this->url . $endpoint, $data);
        } else {
            $response = Http::acceptJson()->post($this->url . $endpoint, $data);
        }

        // Verifica se a requisição foi bem-sucedida e retorna a resposta ou um erro.
        if ($response->successful()) {
            return $response->json();
        } else {
            return ['error' => 'Requisição falhou com o status: ' . $response->status()];
        }
    }
}



// namespace App\Services;

// use Illuminate\Support\Facades\Http;

// Class ApiService{

//     protected $url = 'http://192.168.0.18:8000/api';

//     public function get($endpoint, $token) {
//         // Fazer uma requisição http get passando o token logado no header
//         $request = Http::acceptJson()->withToken($token)->get($this->url.$endpoint);
//         return $request->json();
//     }

//     public function post($endpoint,  $data, $token = null) {
//         if($token) {
//             $request = Http::acceptJson()->withToken($token)->post($this->url.$endpoint, $data);
//         } else {
//             $request = Http::acceptJson()->post($this->url.$endpoint, $data);
//         }
//         return $request->json();
//     }
// }
