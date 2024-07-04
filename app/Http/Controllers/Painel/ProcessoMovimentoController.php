<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Services\PainelApiService;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $errors = [];
        $users = $this->apiService->get('/app/user');
        return view('painel.processo.movimento.create', compact('errors', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $errors = [];
        return view('painel.processo.movimento.edit', compact('errors', 'movimento', 'users'));
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
