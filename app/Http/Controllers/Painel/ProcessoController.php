<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Services\PainelApiService;
use Illuminate\Http\Request;

class ProcessoController extends Controller
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
        $processos = $this->apiService->get('/processos');
        return view('painel.processo.listar', compact('processos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $errors = [];
        $clientes = $this->apiService->get('/cliente');
        $users = $this->apiService->get('/app/user');
        return view('painel.processo.create', compact('errors', 'clientes', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar dados
        $processo = $request->only([
            'cliente_id',
            'user_id',
            'numero',
            'titulo',
            'data',
            'prazo',
        ]);

        // Chama a API
        $response = $this->apiService->post('/processos', $processo);


        // Verifica se há erros na resposta
        if (isset($response['error'])) {
            $clientes = $this->apiService->get('/cliente');
            return view('painel.processo.create', [
                'errors' => is_array($response['message']) ? $response['message'] : [$response['message']],
                'clientes' => $clientes
            ]);
        }

        // Se não houver erros, redireciona com mensagem de sucesso
        return redirect()->route('processo.index')->with('success', 'Processo criado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $processo = $this->apiService->get('/processos/'. $id);
        return view('painel.processo.movimento.listar', compact('processo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $processo = $this->apiService->get('/processos/'. $id);
        $users = $this->apiService->get('/app/user');
        $errors = [];
        return view('painel.processo.edit', compact('errors', 'processo', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $processo = $request->only([
            'cliente_id',
            'user_id',
            'numero',
            'titulo',
            'data',
            'prazo',
        ]);

        // Chama a API para atualizar o cliente
        $response = $this->apiService->put('/processos/' . $id, $processo);

        // Verifica se há erros na resposta
        if (isset($response['error'])) {
            return view('painel.processo.edit', [
                'errors' => is_array($response['message']) ? $response['message'] : [$response['message']],
                'users' => $this->apiService->get('/app/user'),
                'processo' => $this->apiService->get('/processos/'. $id)
            ]);
        }

        // Se não houver erros, redireciona com mensagem de sucesso
        return redirect()->route('processo.index')->with('success', 'Processo atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Faz a chamada para excluir o processo e captura a resposta da API
        try {
            $response = $this->apiService->delete('/processos/' . $id);

            // Verifica se a exclusão foi bem-sucedida com base no código de status
            if (isset($response['error']) && $response['error'] == true) {
                return redirect()->route('processo.index')->with('error', 'Não é possível excluir o processo, pois existem movimentos relacionados.');
            } else {
                return redirect()->route('processo.index')->with('success', 'Processo deletado com sucesso');
            }
        } catch (\Exception $e) {
            // Em caso de erro na comunicação com a API ou outra exceção, retorna a mensagem de erro
            return redirect()->route('processo.index')->with('error', 'Ocorreu um erro ao tentar excluir o processo.');
        }
    }
}
