<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Services\PainelApiService;
use Illuminate\Http\Request;

class ClienteContatoController extends Controller
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
        $contatos = $this->apiService->get('/contato-cliente');
        return view('painel.cliente-contatos.listar', compact('contatos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $errors = [];
        $clientes = $this->apiService->get('/cliente');
        return view('painel.cliente-contatos.create', compact('errors', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar dados
        $contato = $request->only([
            'nome',
            'email',
            'telefone',
            'cliente_id'
        ]);

        // Chama a API
        $api = new PainelApiService();
        $response = $api->post('/contato-cliente', $contato);


        // Verifica se há erros na resposta
        if (isset($response['error'])) {
            $clientes = $this->apiService->get('/cliente');
            return view('painel.cliente-contatos.create', [
                'errors' => is_array($response['message']) ? $response['message'] : [$response['message']],
                'clientes' => $clientes
            ]);
        }

        // Se não houver erros, redireciona com mensagem de sucesso
        return redirect()->route('contatos.index')->with('success', 'Contato criado com sucesso');
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
        $contato = $this->apiService->get('/contato-cliente/'. $id);
        $errors = [];
        return view('painel.cliente-contatos.edit', compact('errors', 'contato'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contato = $request->only([
            'nome',
            'email',
            'telefone'
        ]);

        // Chama a API para atualizar o cliente
        $response = $this->apiService->put('/contato-cliente/' . $id, $contato);

        // Verifica se há erros na resposta
        if (isset($response['error'])) {
            return view('painel.cliente-contatos.edit', [
                'errors' => is_array($response['message']) ? $response['message'] : [$response['message']],
                'contato' => $this->apiService->get('/contato-cliente/'. $id)
            ]);
        }

        // Se não houver erros, redireciona com mensagem de sucesso
        return redirect()->route('contatos.index')->with('success', 'Contato atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->apiService->delete('/contato-cliente/'. $id);
        return redirect()->route('contatos.index')->with('success', 'Contato deletado com sucesso');
    }
}
