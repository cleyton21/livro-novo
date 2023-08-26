<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LivroController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            // Verifica se o usuário é um Usuário Comum
            if ($user && $user->perfil != 'Usuário Comum') {
                return $next($request);
            }

            abort(403, 'Acesso não autorizado'); // Acesso negado para outros perfis
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $livros = Livro::orderBy('dt_ini', 'desc')
        //         ->get();
        $livros = Livro::with('users')  // Carrega os usuários relacionados
                    ->orderBy('dt_ini', 'desc')
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
