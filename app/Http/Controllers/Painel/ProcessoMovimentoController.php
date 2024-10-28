<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessoMovimentoStoreRequest;
use App\Services\PainelApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProcessoMovimentoController extends Controller
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
        $processo_id = request()->query('processo_id');
        $processo = $this->apiService->get('/processos/'. $processo_id);
        return view('painel.processo.movimento.listar', compact('processo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $processo_id = request()->query('processo_id');
        $processo = $this->apiService->get('/processos/'. $processo_id);
        $errors = session('errors', []);
        $users = $this->apiService->get('/app/user');
        return view('painel.processo.movimento.create', compact('errors', 'users', 'processo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProcessoMovimentoStoreRequest $request)
    {
        // Validar dados
        $processoMovimento = $request->only([
            'cliente_id',
            'user_id',
            'processo_id',
            'data',
            'descricao',
        ]);

        $anexo = $request->hasFile('anexo') ? [
            'name' => 'anexo',
            'file' => $request->file('anexo') ] : [];

            // Salvar o anexo
            if($request->hasFile('anexo')) {
                $file = $request->file('anexo');
                $fileName = Str::random(20).'.'.$file->getClientOriginalExtension();
                $file->move('upload', $fileName);

                $response = $this->apiService->post('/processos/movimentos', $processoMovimento,
                    [
                        'name' => 'anexo',
                        'file' => fopen(public_path('upload/'.$fileName), 'r')
                    ]
                );

                unlink(public_path('upload/'.$fileName));
            } else {
                // Chama a API
                $response = $this->apiService->post('/processos/movimentos', $processoMovimento, $anexo);

            }

        // Verifica se há erros na resposta
        if (isset($response['error'])) {
            $users = $this->apiService->get('/app/user');

            return view('painel.processo.movimento.create', [
                'errors' => is_array($response['message']) ? $response['message'] : [$response['message']],
                'users' => $users
            ]);
        }

        // Se não houver erros, redireciona com mensagem de sucesso
        return redirect()
            ->route('movimento.index', ['processo_id' => $processoMovimento['processo_id']])
            ->with('success', 'Movimento criado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $errors = [];
        $processo = $this->apiService->get('/processos/movimentos/'. $id);
        return view('painel.processo.movimento.create', compact('errors','processo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $movimento = $this->apiService->get('/processos/movimentos/'. $id);

        $users = $this->apiService->get('/app/user');
        $errors = session('errors', []);
        return view('painel.processo.movimento.edit', compact('errors', 'movimento', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $movimento = $request->only([
            'cliente_id',
            'user_id',
            'processo_id',
            'data',
            'descricao',
        ]);

        $anexo = $request->hasFile('anexo') ? [
            'name' => 'anexo',
            'file' => $request->file('anexo') ] : [];

        // Substituir anexo
        if($request->hasFile('anexo')) {
            $file = $request->file('anexo');
            $fileName = Str::random(20).'.'.$file->getClientOriginalExtension();
            $file->move('upload', $fileName);

            $response = $this->apiService->put('/processos/movimentos', $movimento,
                [
                    'name' => 'anexo',
                    'file' => fopen(public_path('upload/'.$fileName), 'r')
                ]
            );

            unlink(public_path('upload/'.$fileName));
        } else {
            // Chama a API
            $response = $this->apiService->put('/processos/movimentos', $movimento, $anexo);

        }

        // Chama a API para atualizar o movimento
        $response = $this->apiService->put('/processos/movimentos/' . $id, $movimento);

        // Verifica se há erros na resposta
        if (isset($response['error'])) {
            return redirect()->back()->with('errors', is_array($response['message']) ? $response['message'] : [$response['message']]);
        }

        // Se não houver erros, redireciona com mensagem de sucesso
        return redirect()
            ->route('movimento.index', ['processo_id' => $movimento['processo_id']])
            ->with('success', 'Movimento atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movimento = $this->apiService->get('/processos/movimentos/'. $id);

        $this->apiService->delete('/processos/movimentos/'. $id);

        return redirect()
            ->route('movimento.index', ['processo_id' => $movimento['processo_id']])
            ->with('success', 'Movimento deletado com sucesso');
    }
}
