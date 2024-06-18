<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Services\PainelApiService;
use Illuminate\Http\Request;

class ClienteTributacaoController extends Controller
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
        $tributacoes = $this->apiService->get('/tributacao-cliente');
        return view('painel.cliente-tributacao.listar', compact('tributacoes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $errors = [];
        $clientes = $this->apiService->get('/cliente');
        return view('painel.cliente-tributacao.create', compact('errors', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd("chegou no tributação store");
        // Validar dados
        $tributacao = $request->only([
            'tipo', // Presumido, Simples Nacional, Real Trimestral, Real Anual, Isenta, Imune
            'data',
            'cliente_id'
        ]);

         // Chama a API
        $api = new PainelApiService();
        $response = $api->post('/tributacao-cliente', $tributacao);


         // Verifica se há erros na resposta
        if (isset($response['error'])) {
            return view('painel.cliente-tributacao.create', [
                'errors' => is_array($response['message']) ? $response['message'] : [$response['message']]
            ]);
        }

        // Se não houver erros, redireciona com mensagem de sucesso
        return redirect()->route('tributacao.index')->with('success', 'Tributação criada com sucesso');
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
        $tributacao = $this->apiService->get('/tributacao-cliente/'. $id);
        $errors = [];
        return view('painel.cliente-tributacao.edit', compact('errors', 'cliente', 'tributacao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tributacao = $request->only([
            'tipo', // Presumido, Simples Nacional, Real Trimestral, Real Anual, Isenta, Imune
            'data',
        ]);

        // Chama a API para atualizar o cliente
        $response = $this->apiService->put('/tributacao-cliente/' . $id, $tributacao);

        // Verifica se há erros na resposta
        if (isset($response['error'])) {
            return view('painel.cliente-tributacao.edit', [
                'errors' => is_array($response['message']) ? $response['message'] : [$response['message']],
                'tributacao' => $this->apiService->get('/tributacao-cliente/'. $id)
            ]);
        }

        // Se não houver erros, redireciona com mensagem de sucesso
        return redirect()->route('tributacao.index')->with('success', 'Cliente atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->apiService->delete('/tributacao-cliente/'. $id);
        return redirect()->route('tributacao.index')->with('success', 'Tributação deletada com sucesso');
    }
}
