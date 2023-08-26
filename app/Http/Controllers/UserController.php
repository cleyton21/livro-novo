<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
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
        $usersChunked = [];

        User::orderByRaw("CASE WHEN status = 2 THEN 2 ELSE 1 END")
            ->orderByRaw("CASE WHEN status = 0 THEN 1 WHEN status = 1 THEN 2 END")
            ->orderByRaw("FIELD(perfil, 'Admin', 'Secretaria', 'Sargenteante', 'Usuário Comum')")
            ->chunk(50, function ($users) use (&$usersChunked) {
                $usersChunked[] = $users;
            });

        return view('user.index', ['usersChunked' => $usersChunked]);

    }

    // public function autorizar(Request $request, $id)
    // {
    //     $item = User::find($id);
    //     $novoStatus = $request->input('novoStatus');
    //     $item->status = $novoStatus;
    //     $item->update();

    //     if ($item->update()) {
    //         return response()->json(['mensagem' => 'Status atualizado com sucesso']);
    //     }

    //     return response()->json(['mensagem' => 'Erro ao atualizar...Tente novamente']);

    // }

    public function autorizar(Request $request, $id)
    {
        $item = User::find($id);

        // Verifica se o usuário está tentando mudar o próprio status
        if (auth()->user()->id === $item->id) {
            return response()->json([
                'success' => false,
                'mensagem' => 'Você não pode mudar o seu próprio status',
            ]);
        }

        // Verifica se o usuário está tentando mudar o último status com valor 1
        if ($item->status === 1 && User::where('status', 1)->count() === 1) {
            return response()->json([
                'success' => false,
                'mensagem' => 'Não é permitido Negar o acesso do último usuário autorizado',
            ]);
        }

        $novoStatus = $request->input('novoStatus');
        $item->status = $novoStatus;
        $item->update();

        if ($item->update()) {
            return response()->json(['mensagem' => 'Status atualizado com sucesso']);
        }

        return response()->json(['mensagem' => 'Erro ao atualizar... Tente novamente']);
    }


    public function mudarPerfil(Request $request, $id)
    {
        $item = User::find($id);

        // Verifica se o ID do usuário sendo alterado é igual ao ID do usuário logado
        if ($item->id === Auth::id()) {
            return response()->json(['mensagem' => 'Não é permitido alterar o próprio perfil']);
        }

        // Verifica se o usuário é o último admin
        if ($item->perfil === 'Admin' && User::where('perfil', 'Admin')->count() === 1) {
            return response()->json(['mensagem' => 'Não é permitido alterar o último perfil de admin']);
        }

        $novoPerfil = $request->input('novoPerfil');
        $item->perfil = $novoPerfil;

        if ($item->update()) {
            return response()->json(['mensagem' => 'Perfil atualizado com sucesso']);
        }

        return response()->json(['mensagem' => 'Erro ao atualizar... Tente novamente']);
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

    public function atualizarSenha(Request $request, $id)
    {
        $user = User::find($id);

        $novaSenha = $request->input('nova_senha');
        $user->password = Hash::make($novaSenha);
        // $user->update();
        
        if($user->update()) {
            return response()->json(['mensagem' => 'Senha atualizada com sucesso.']);
        }
        
        return response()->json(['mensagem' => 'Erro ao atualizar.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
    
        // Verifica se o usuário está tentando excluir a si mesmo
        if ($user->id === auth()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Você não pode excluir a si mesmo',
            ]);
        }
    
        // Verifica se o usuário é o último admin
        if ($user->perfil === 'Admin' && User::where('perfil', 'Admin')->count() === 1) {
            return response()->json([
                'success' => false,
                'message' => 'Não é permitido excluir o último admin do sistema',
            ]);
        }
    
        if ($user->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Usuário excluído com sucesso!',
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Erro ao excluir... Tente novamente!',
        ]);
    }
    

}
