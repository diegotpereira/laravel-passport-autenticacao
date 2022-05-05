<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postar;

class PostController extends Controller
{
    //
	public function index() 
	{
		$postars = auth()->user()->postars;

		return response()->json([
			'success' => true,
			'data' => $postars
		]);
	}
	public function show($id)
	{
		$post = auth()->user()->postars()->find($id);

		if (!$post) {
			return response()->json([
				'success' => false,
				'message' => 'Postagem não encontrada'
			], 400);
		}
		return response()->json([
			'success' => true,
			'data' => $post->toArray()
		], 400);
	}
	public function store(Request $request)
	{
		$this->validate($request, [
			'titulo' => 'required',
			'descricao' => 'required'
		]);
		$post = new Postar();
		$post->titulo = $request->titulo;
		$post->descricao = $request->descricao;

		if (auth()->user()->postars()->save($post)) 
			return response()->json([
				'success' => true,
				'data' => $post->toArray()
			]);
		 else 
		   return response()->json([
			   'success' => false,
			   'message' => 'Postagem não adicionada'
		   ], 500);
	}
	public function update(Request $request, $id)
	{
		$post = auth()->user()->postars()->find($id);

		if (!$post) {
			return response()->json([
				'success' => false,
				'message' => 'Postagem não encontrada'
			], 400);
		}
		$updated = $post->fill($request->all())->save();

		if ($updated)
		 return response()->json([
			 'success' => true
		 ]);
		 else 
		 return response()->json([
			 'success' => false,
			 'message' => 'Postagem não pode ser atualizada'
		 ], 500);
	}
	public function destroy($id)
	{
		$post = auth()->user()->postars()->find($id);

		if (!$post) {
			return response()->json([
				'success' => false,
				'message' => 'Postagem não encontrada'
			], 400);
		}
		if ($post->delete()) {
			return response()->json([
				'success' => true
			]);
		} else {
			return response()->json([
				'success' => false,
				'message' => 'Postagem não pode ser deletada'
			], 500);
		}
	}
}
