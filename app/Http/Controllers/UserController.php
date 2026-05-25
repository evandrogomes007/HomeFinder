<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|stringmax:255',
                'email' => 'required|email|unique:email',
                'genero' => 'required|in:M,F',
                'password' => 'required|string|min:8'
            ]
        );

        $user = User::create($validated);
        return [$user, 'criado com sucesso'];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return 'usuario não encontrado';
        }

        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return 'usuario não encontrado';
        }

        $validated = $request->validate(
            [
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|stringmax:255',
                'email' => 'required|email|unique:email',
                'genero' => 'required|in:M,F',
                'password' => 'required|string|min:8'
            ]
        );

        $user->update($validated);
        return [$user, 'atualizado com sucesso'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return 'usuario não encontrado';
        }

        try {
            $user->delete();
        } catch (\Throwable $th) {
            return [$th, 'ocorreu um problema ao deletar o usuário'];
        }

        return 'usuario deletado com sucesso';
    }
}
