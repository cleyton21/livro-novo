<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
         // Verifica se o usuário está logado
         if (Auth::check()) {
            $user = Auth::user();
            // Verifica o perfil do usuário
            if ($user->perfil == "Usuário Comum") {
                return redirect()->route('chirps.index');
            }
        }

        $users = User::all(); // Recupera todos os usuários

        // Inicializa um array para armazenar as somas de cada posto_grad
        $postoGradSums = [];

        foreach ($users as $user) {
            $postoGrad = $user->postograd;

            if (!isset($postoGradSums[$postoGrad])) {
                $postoGradSums[$postoGrad] = 0;
            }

            // Somamos 1 para cada ocorrência do valor de posto_grad
            $postoGradSums[$postoGrad] += 1;
        }

        $postoGradLabels = array_keys($postoGradSums);
        $postoGradData = array_values($postoGradSums);

        // dd($postoGradLabels, $postoGradData);   

        $totalUsuarios = User::count(); // Conta o total de usuários na tabela
        $totalLivros = Livro::count(); // Conta o total de livros preenchidos
        $totalUsuariosStatusZero = User::where('status', 0)->count(); // Conta o total de usuários com status igual a 0

        return view('dashboard', compact('totalUsuarios', 'totalLivros', 'totalUsuariosStatusZero', 'postoGradLabels', 'postoGradData')); // Passa o total de usuários para a view
    }   
}

