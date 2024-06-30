<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Services\PainelApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
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
        $users = $this->apiService->get('/app/user');
        return view('painel.user.listar', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $errors = [];
        return view('painel.user.create', compact('errors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar dados
        $user = $request->only([
            'name',
            'email',
            'status',
            'password',
            'password_confirmation',
            'avatar'
        ]);

        // Chama a API
        $response = $this->apiService->post('/app/user', $user);


        // Verifica se há erros na resposta
        if (isset($response['error'])) {
            return view('painel.user.create', [
                'errors' => is_array($response['message']) ? $response['message'] : [$response['message']]
            ]);
        }

        // Salvar o Avatar
        if($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $imageName = Str::random(20).'.'.$image->getClientOriginalExtension();
            $image->move('upload', $imageName);

            $createAvatar = $this->apiService->post('/app/user/avatar', [
                'user_id' => $response['userNew']['id'],
                ],
                [
                    'name' => 'avatar',
                    'file' => fopen(public_path('upload/'.$imageName), 'r')
                ]
            );
            unlink(public_path('upload/'.$imageName));
        }

        // Se não houver erros, redireciona com mensagem de sucesso
        return redirect()->route('user.index')->with('success', 'Usuário criada com sucesso');
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
        $user = $this->apiService->get('/app/user/'. $id);
        $errors = [];
        return view('painel.user.edit', compact('errors', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dados = $request->only([
            'name',
            'email',
            'status',
            'avatar'
        ]);

        // Chama a API para atualizar o cliente
        $response = $this->apiService->put('/app/user/' . $id, $dados);

        // Verifica se há erros na resposta
        if (isset($response['error'])) {
            return view('painel.user.edit', [
                'errors' => is_array($response['message']) ? $response['message'] : [$response['message']],
                'user' => $this->apiService->get('/app/user/'. $id)
            ]);
        }

        // atualizar o Avatar
        if($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $imageName = Str::random(20).'.'.$image->getClientOriginalExtension();
            $image->move('upload', $imageName);

            $createAvatar = $this->apiService->post('/app/user/avatar', [
                'user_id' => $id,
                ],
                [
                    'name' => 'avatar',
                    'file' => fopen(public_path('upload/'.$imageName), 'r')
                ]
            );
            unlink(public_path('upload/'.$imageName));
        }

        // Se não houver erros, redireciona com mensagem de sucesso
        return redirect()->route('user.index')->with('success', 'Usuário atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->apiService->delete('/app/user/'. $id);
        return redirect()->route('user.index')->with('success', 'Usuário deletado com sucesso');
    }
}
