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
        $users =  DB::table('users')
            ->orderBy('status')
            ->get();
            // dd($users);

        return view('user.index', [
            // 'users' => User::orderBy('status', 'asc')->get()
            'users' => $users
        ]);
    }

    public function autorizar(Request $request, $id)
    {
        $item = User::find($id);
        $item->status = 1;
        $item->update();

        // $novoStatus = $request->input('status');

        // $item->update([
        //     'status' => 1,
        // ]);

        return response()->json(['mensagem' => 'Status atualizado com sucesso']);
    

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
        //
    }
}
