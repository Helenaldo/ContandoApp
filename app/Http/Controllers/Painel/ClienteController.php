<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Services\PainelApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClienteController extends Controller
{
    private $apiService;

    public function __construct() {
        $this->apiService = new PainelApiService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = $this->apiService->get('/cliente');
        return view('painel.cliente.listar', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cidades = $this->apiService->get('/cidades')['data'];
        $errors = [];
        return view('painel.cliente.create', compact( 'cidades', 'errors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Obter cidades da API
        try {
            $cidades = $this->apiService->get('/cidades')['data'];
        } catch (\Exception $e) {
            return view('painel.cliente.create', [
                'errors' => ['error' => 'Erro ao obter cidades: ' . $e->getMessage()],
                'cidades' => [],
            ]);
        }

        // Validar dados
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
        $api = new PainelApiService();
        $response = $api->post('/cliente', $cliente);


         // Verifica se há erros na resposta
        if (isset($response['error'])) {
            return view('painel.cliente.create', [
                'errors' => is_array($response['message']) ? $response['message'] : [$response['message']],
                'cidades' => $cidades,
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
        $cliente = $this->apiService->get('/cliente/'. $id);
        $cidades = $this->apiService->get('/cidades')['data'];

        $errors = [];
        return view('painel.cliente.edit', compact( 'cidades', 'errors', 'cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cliente = $request->only([
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
            'tipo',
        ]);

        // Chama a API para atualizar o cliente
        $response = $this->apiService->put('/cliente/' . $id, $cliente);

        // Verifica se há erros na resposta
        if (isset($response['error'])) {
            return view('painel.cliente.edit', [
                'errors' => is_array($response['message']) ? $response['message'] : [$response['message']],
                'cliente' => $this->apiService->get('/cliente/'. $id),
                'cidades' => $this->apiService->get('/cidades')['data']
            ]);
        }

        // Se não houver erros, redireciona com mensagem de sucesso
        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->apiService->delete('/cliente/'. $id);
        return redirect()->route('clientes.index')->with('success', 'Cliente deletado com sucesso');
    }
}
