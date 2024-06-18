<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PainelApiService
{
    private $url;

    /**
     * Construtor da classe ApiService.
     * Define a URL base para as requisições API a partir de uma variável de ambiente ou usa um valor padrão.
     */
    public function __construct()
    {
        // Atribui a URL base para as requisições a partir de uma variável de ambiente ou usa um valor padrão se não estiver definida.
        $this->url = env('API_PAINEL_BASE_URL', 'http://localhost:8000/api');
    }

    public function request($method, $endpoint, $data = null, $headers = []) {
        $token = $this->getCurrentToken();
        if($token) {
            // Realiza uma requisição GET com o token de autenticação incluído no cabeçalho.
            $response = Http::acceptJson()->withToken($token)->{$method}($this->url . $endpoint, $data);
            // $response = Http::acceptJson()->withToken($token)->get($this->url . $endpoint);
        } else {
            // $response = Http::acceptJson()->get($this->url . $endpoint);
            $response = Http::acceptJson()->{$method}($this->url . $endpoint, $data);
        }

        return $response;

    }

    /**
     * Envia uma requisição GET para um endpoint específico usando um token de autenticação.
     *
     * @param string $endpoint Endpoint da API para a requisição GET.
     * @param string $token Token de autenticação para acesso à API.
     * @return array Resposta da API convertida em array.
     */
    public function get(string $endpoint): array
    {
        $response = $this->request('get', $endpoint);

        // Verifica se a requisição foi bem-sucedida e retorna a resposta ou um erro.
        return $this->response('get', $response);
    }

    /**
     * Envia uma requisição POST para um endpoint específico, opcionalmente usando um token de autenticação.
     *
     * @param string $endpoint Endpoint da API para a requisição POST.
     * @param array $data Dados a serem enviados na requisição POST.
     * @param string|null $token Token de autenticação opcional para acesso à API.
     * @return array Resposta da API convertida em array.
     */
    public function post(string $endpoint, array $data): array
    {
        $response = $this->request('post', $endpoint, $data);

        // Verifica se a requisição foi bem-sucedida e retorna a resposta ou um erro.
        return $this->response('post', $response);

    }

    public function put(string $endpoint, array $data) {

        $response = $this->request('put', $endpoint, $data);

        // Verifica se a requisição foi bem-sucedida e retorna a resposta ou um erro.
        return $this->response('put', $response);
    }

    public function delete(string $endpoint) {

        $response = $this->request('delete', $endpoint);

        // Verifica se a requisição foi bem-sucedida e retorna a resposta ou um erro.
        return $this->response('delete', $response);
    }

    public function response($method, $response) {
        if($method == 'get' && !$response->successful()) {
            // Verifica se a requisição foi bem-sucedida e retorna a resposta ou um erro.
            return ['error' => 'Requisição falhou com o status: ' . $response->status()];
        }

        if(!$response->successful()) {
            $responseError = $response->json();
             return [
                 'error' => true,
                 'message' => $responseError['message'],
            ];
        }
        return $response->json();
    }

    private function getCurrentToken() {
        $token = session('authenticated');
        if($token) {
            return $token['token'];
        }
        return null;
    }

}
