<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Livro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    public function index(): View
    {
        $userId = Auth::id(); // Obtém o ID do usuário logado

        $livros = Livro::where('usuario_id', $userId)
            ->orderBy('dt_ini', 'desc')
            ->get();

            // dd($livros);

        return view('chirps.index', [
            'chirps' => $livros
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'message' => 'required|string|max:255',
        // ]);

        // $request->user()->chirps()->create($validated);
 
        // return redirect(route('chirps.index'));

        $messages = [
            'dt_ini.required' => 'Erro: A data inicial é obrigatória.',
            'dt_end.required' => 'Erro: A data final é obrigatória.',
            'dt_end.after' => 'Erro: A data final deve ser maior que a data inicial.',
            'texto.required' => 'Erro: O campo de texto é obrigatório.',
        ];
    
        $validator = Validator::make($request->all(), [
            'dt_ini' => 'required|date',
            'dt_end' => 'required|date|after:dt_ini',
            'texto' => 'required|string',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

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
            return redirect()->route('chirps.index');

        } else {
            // Armazene uma mensagem de erro na sessão
            session()->flash('error', 'Erro ao gravar o livro. Tente novamente mais tarde.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        $this->authorize('update', $chirp);
 
        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        $this->authorize('update', $chirp);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $chirp->update($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        //
    }
}
