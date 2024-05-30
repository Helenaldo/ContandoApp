<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClienteController extends Controller
{
    private $apiService;

    public function __construct() {
        $this->apiService = new ApiService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = $this->apiService->get('/cliente');
        //dd($clientes);
        // $this->apiService->get('/clientes');

        return view('painel.cliente.listar', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cidades = Http::get(env("API_PAINEL_BASE_URL"). '/cidades')['data'];
        $errors = [];
        return view('painel.cliente.create', compact( 'cidades', 'errors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cliente = $request->only([
            'tipo_identificacao', // CNPJ ou CPF
            'cpf_cnpj',
            'nome',
            'fantasia',
            'cep',
            'logradouro',
            'numero',
            'bairro',
            'complemento',
            'cidade_id',
            'data_entrada',
            'data_saida',
            'tipo', // Matriz ou Filial
        ]);

        // Chama a API
        $api = new ApiService;
        $response = $api->post('/cliente', $cliente);


        // Verifica se há erros na resposta
        if (isset($response['error'])) {
            return view('painel.cliente.create', [
                'errors' => is_array($response['error']) ? $response['error'] : [$response['error']],
            ]);
        }
        // Se não houver erros, redireciona com mensagem de sucesso
        return redirect()->route('clientes.index')->with('success', 'Cliente criado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
