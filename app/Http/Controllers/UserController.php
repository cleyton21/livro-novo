<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usersChunked = [];

        User::orderByRaw("CASE WHEN status = 2 THEN 2 ELSE 1 END")
            ->orderByRaw("CASE WHEN status = 0 THEN 1 WHEN status = 1 THEN 2 END")
            ->orderByRaw("FIELD(perfil, 'admin', 'secretaria', 'sargenteante', 'usuario comum')")
            ->chunk(50, function ($users) use (&$usersChunked) {
                $usersChunked[] = $users;
            });

        return view('user.index', ['usersChunked' => $usersChunked]);

    }

    public function autorizar(Request $request, $id)
    {
        $item = User::find($id);
        $novoStatus = $request->input('novoStatus');
        $item->status = $novoStatus;
        $item->update();

        if ($item->update()) {
            return response()->json(['mensagem' => 'Status atualizado com sucesso']);
        }

        return response()->json(['mensagem' => 'Erro ao atualizar...Tente novamente']);

    }

    public function mudarPerfil(Request $request, $id)
    {
        $item = User::find($id);
        $novoPerfil = $request->input('novoPerfil');
        $item->perfil = $novoPerfil;
        $item->update();

        if ($item->update()) {
            return response()->json(['mensagem' => 'Perfil atualizado com sucesso']);
        }

        return response()->json(['mensagem' => 'Erro ao atualizar...Tente novamente']);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userType = Auth::user()->perfil; // Obtém o perfil do usuário logado

        // Se o usuário logado for um admin, todas as opções estarão disponíveis
        // Se for secretaria, apenas "sargenteante" e "usuario_comum" estarão disponíveis
        // Se for sargenteante, apenas "usuario_comum" estará disponível
        $allowedProfiles = [];
        if ($userType === 'Admin') {
            $allowedProfiles = ['Admin', 'Secretaria', 'Sargenteante', 'Usuário Comum'];
        } elseif ($userType === 'Secretaria') {
            $allowedProfiles = ['Sargenteante', 'Usuário Comum'];
        } elseif ($userType === 'Sargenteante') {
            $allowedProfiles = ['Usuário Comum'];
        }

        return view('user.create', compact('allowedProfiles'));     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'postograd' => [
                'required',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('postograd', $request->postograd)
                                 ->where('nome_guerra', $request->nome_guerra);
                }),
            ],
            'nome_guerra' => 'required|string|max:255',
            'nome_completo' => 'required|string|max:255',
            'cel' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'perfil' => 'required|in:Admin,Secretaria,Sargenteante,Usuário Comum',
        ], [
            'postograd.required' => 'O campo Posto/Graduação é obrigatório.',
            'postograd.unique' => 'Este Posto/Graduação em combinação com o Nome de Guerra já está sendo utilizado.',
            'nome_guerra.required' => 'O campo Nome de Guerra é obrigatório.',
            'nome_completo.required' => 'O campo Nome Completo é obrigatório.',
            'cel.required' => 'O campo Celular é obrigatório.',
            'email.required' => 'O campo Email é obrigatório.',
            'email.email' => 'Insira um endereço de email válido.',
            'email.unique' => 'Este email já está sendo utilizado.',
            'password.required' => 'O campo Senha é obrigatório.',
            'password.min' => 'A senha deve conter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da senha não coincide.',
            'perfil.required' => 'O campo Perfil é obrigatório.',
            'perfil.in' => 'Perfil selecionado é inválido.',
        ]);   

        // Crie o usuário
        $cad = User::create([
            'postograd' => $request->postograd,
            'nome_guerra' => $request->nome_guerra,
            'nome_completo' => $request->nome_completo,
            'cel' => $request->cel,
            'email' => $request->email,
            'perfil' => $request->perfil,
            'status' => 1,
            'password' => bcrypt($request->password),
        ]);

        if(!$cad) {
            return redirect()->back()->withErrors(['Erro ao cadastrar usuário.'])->withInput();
        }
        
        return redirect()->route('user.index')->with('success', 'Usuário cadastrado com sucesso.');

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
        //
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
        $livro = User::findOrFail($id);
        $del = $livro->delete();

        if($del) {
            return response()->json([
                'success' => true,
                'message' => 'Usuário excluído com sucesso!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao excluir... Tente novamente!!!',
        ]);
    }
}
