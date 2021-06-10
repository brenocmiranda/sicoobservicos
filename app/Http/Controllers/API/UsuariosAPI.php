<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Usuarios;

class UsuariosAPI extends Controller
{

    public function index()
    {
        $usuarios = Usuarios::where('id', '<>', 1)->where('status', 'Ativo')->select('id', 'login')->orderBy('login', 'ASC')->get();
        return $usuarios;
    }

    public function create()
    {
        return false;
    }

    public function store(Request $request)
    {
       return false;
    }

    public function show($id)
    {
        return false;
    }

    public function edit($id)
    {
        return false;
    }

    public function update(Request $request, $id)
    {
        return false;
    }

    public function destroy($id)
    {
        return false;
    }
}
