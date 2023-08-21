<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livros = Livro::orderBy('dt_ini', 'desc')
                ->get();

        return view('livro.index', [
            'livros' => $livros
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('livro.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->method());
        // Recebe os dados do AJAX
        $data = [
            'dt_ini' => $request->input('dt_ini'),
            'dt_end' => $request->input('dt_end'),
            'texto' => $request->input('texto'),
            'usuario_id' => auth()->id(), // Obtém o ID do usuário autenticado
        ];

        $livro = Livro::create($data);

        if ($livro) {
            // Armazene uma mensagem de sucesso na sessão
            session()->flash('success', 'Livro gravado com sucesso!');
             // Redirecione para a rota de índice dos livros
            return redirect()->route('livro.index');

        } else {
            // Armazene uma mensagem de erro na sessão
            session()->flash('error', 'Erro ao gravar o livro. Tente novamente mais tarde.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Livro $livro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livro $livro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Livro $livro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Livro $livro)
    public function destroy($id)
    {
        //
    }
}
