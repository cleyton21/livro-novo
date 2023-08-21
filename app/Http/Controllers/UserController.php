<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $users =  DB::table('users')
        //     ->orderBy('perfil')
        //     ->orderBy('status')
        //     ->get();

        $users = User::orderByRaw("CASE WHEN status = 2 THEN 2 ELSE 1 END")
                ->orderByRaw("CASE WHEN status = 0 THEN 1 WHEN status = 1 THEN 2 END")
                ->orderByRaw("FIELD(perfil, 'admin', 'secretaria', 'sargenteante', 'usuario comum')")
                ->get();



        return view('user.index', [
            // 'users' => User::orderBy('status', 'asc')->get()
            'users' => $users
        ]);
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

        // if($item){
        //     return response()->json([
        //         'status'=>200,
        //         'item'=>$item
        //     ]);
        // }else{
        //     return response()->json([
        //         'status'=>404,
        //         'message'=>"Campo não encontrado"
        //     ]);
        // }
        
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
        //
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
