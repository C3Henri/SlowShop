<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Mail\ForgotPassword;
use App\Mail\ResetPassword;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Categoria;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'page' => 'nullable|integer',
            'limit' => 'nullable|integer',
            'order_preco' => 'nullable|in:asc,desc',
            'order_data' => 'nullable|in:asc,desc',
            'order_pontuacao' => 'nullable|in:asc,desc'
        ], [
            'page.integer' => 'O campo page deve ser um número inteiro!',
            'limit.integer' => 'O campo limit deve ser um número inteiro!',
            'order_preco.in' => 'O campo order_preco deve ser asc ou desc!',
            'order_data.in' => 'O campo order_data deve ser asc ou desc!',
            'order_pontuacao.in' => 'O campo order_pontuacao deve ser asc ou desc!',
        ]);

        $query = Produto::query();

        if($request->filled('order_preco')) {
            $query->orderBy('preco', $validated['order_preco']);
        }
        
        if($request->filled('order_pontuacao')){
            $query->orderBy('created_at', $validated['order_data']);
        }
    
        if($request->filled('order_pontuacao')){
            $query->orderBy('pontuacao_media', $validated['order_pontuacao']);
        }
    
        if($request->filled('page') && $request->filled('limit')) {
            $page = $validated['page'];
            $limit = $validated['limit'];
            $produtos = $query->paginate($limit, ['*'], 'page', $page);
        } else {
            $produtos = $query->get();
        }

        if ($produtos->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum produto encontrado!',
            ], 404);
        }

        return response()->json([
            'produtos' => $produtos,
        ], 200);
    }

    public function show($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json([
                'message' => 'Produto não encontrado!',
            ], 404);
        }

        return response()->json([
            'produto' => $produto,
        ], 200);
    }

    public function reviews($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json([
                'message' => 'Produto não encontrado!',
            ], 404);
        }

        $reviews = $produto->reviews()->with('cliente:id,nome_abreviado,nivel_id')->get();

        if ($reviews->isEmpty()) {
            return response()->json([
                'message' => 'Nenhuma review encontrada!',
            ], 404);
        }

        return response()->json([
            'reviews' => $reviews,
        ], 200);
    }

    public function categoria($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'message' => 'Categoria não encontrada!',
            ], 404);
        }

        $produtos = $categoria->produtos()->get();

        if ($produtos->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum produto encontrado!',
            ], 404);
        }

        return response()->json([
            'produtos' => $produtos,
        ], 200);
    }
}
