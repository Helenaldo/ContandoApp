<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Services\PainelApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    private $apiService;

    public function __construct() {
        $this->apiService = new PainelApiService;
    }
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $tenant = $this->apiService->get('/tenants/');
        return view('painel.config.escritorio.listar', compact('tenant'));
    }

    public function edit() {
        $tenant = $this->apiService->get('/tenants/');
        $cidades = $this->apiService->get('/cidades')['data'];
        return view('painel.config.escritorio.edit', compact('tenant', 'cidades'));
    }

    public function update(Request $request) {

        $dados = $request->only([
            'nome',
            'logradouro',
            'numero',
            'bairro',
            'complemento',
            'cidade_id',
        ]);

        $logo = $request->hasFile('logo') ? [
            'name' => 'logo',
            'file' => $request->file('logo') ] : [];

        // Substituir a logo
        if($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = Str::random(20).'.'.$file->getClientOriginalExtension();
            $file->move('upload', $fileName);

            $response = $this->apiService->post('/tenants', $dados,
                [
                    'name' => 'logo',
                    'file' => fopen(public_path('upload/'.$fileName), 'r')
                ]
            );

            unlink(public_path('upload/'.$fileName));
        } else {
            // Chama a API
            $response = $this->apiService->post('/tenants', $dados, $logo);

        }

        // Chama a API para atualizar o Tenant
        $response = $this->apiService->post('/tenants', $logo);

        // Verifica se há erros na resposta
        if (isset($response['error'])) {
            return redirect()->back()->with('errors', is_array($response['message']) ? $response['message'] : [$response['message']]);
        }

        // Se não houver erros, redireciona com mensagem de sucesso
        return redirect()
            ->route('tenant.listar')
            ->with('success', 'Dados atualizado com sucesso');
    }
}
