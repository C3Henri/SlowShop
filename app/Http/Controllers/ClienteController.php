<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Mail\ForgotPassword;
use App\Mail\ResetPassword;
use App\Models\Cliente;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ClienteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required',
            'email' => 'required|email',
            'senha' => 'required|min:8',
        ], [
            'nome.required' => 'O campo nome é obrigatório!',
            'email.required' => 'O campo email é obrigatório!',
            'email.email' => 'O campo email deve ser um email válido!',
            'senha.required' => 'O campo senha é obrigatório!',
            'senha.min' => 'O campo senha deve ter no mínimo 8 caracteres!',
        ]);

        if (Cliente::where('email', $validated['email'])->exists()) {
            return response()->json([
                'message' => 'Email já cadastrado!',
            ], 409);
        }

        $cliente = new Cliente();
        $cliente->nome = $validated['nome'];
        $cliente->email = $validated['email'];
        $cliente->password = bcrypt($validated['senha']);
        $cliente->nivel_id = 1;
        $cliente->token_de_verificacao = Str::random(10) . uniqid() . Str::random(10);
        $cliente->save();

        Mail::to($cliente->email)->send(new EmailVerification($cliente));

        return response()->json([
            'message' => 'Cliente cadastrado com sucesso!',
            'email' => $cliente->email,
        ], 201);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'senha' => 'required|min:8',
        ], [
            'email.required' => 'O campo email é obrigatório!',
            'email.email' => 'O campo email deve ser um email válido!',
            'senha.required' => 'O campo senha é obrigatório!',
            'senha.min' => 'O campo senha deve ter no mínimo 8 caracteres!',
        ]);

        $cliente = Cliente::where('email', $validated['email'])->first();

        if ($cliente && Hash::check($validated['senha'], $cliente->password)) {
            
            if ($cliente->verificado == false) {
                return response()->json([
                    'message' => 'Email não verificado!',
                ], 401);
            }

            $tokenResult = $cliente->createToken('Personal Access Token');
            $token = $tokenResult->token;

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);
        }

        return response()->json([
            'message' => 'Email ou senha incorretos!',
        ], 401);
    }

    public function verifyEmail($token)
    {
        $cliente = Cliente::where('token_de_verificacao', $token)->first();

        if ($cliente) {
            $cliente->verificado = true;
            $cliente->token_de_verificacao = null;
            $cliente->save();

            return response()->json([
                'message' => 'Email verificado com sucesso!',
            ], 200);
        }

        return response()->json([
            'message' => 'Token inválido!',
        ], 401);
    }

    public function forgotPassword(Request $request)
    {
        $validated = $request->validate([
                'email' => 'required|email|exists:clientes',
            ], [
                'email.required' => 'O campo email é obrigatório!',
                'email.email' => 'O campo email deve ser um email válido!',
                'email.exists' => 'O email informado não está cadastrado!',
            ]);

        $cliente = Cliente::where('email', $validated['email'])->first();
        $cliente->token_de_recuperacao = Str::random(10) . uniqid() . Str::random(10);
        $cliente->data_de_expiracao_do_token_de_recuperacao = now()->addMinutes(30);
        $cliente->save();

        Mail::to($cliente->email)->send(new ForgotPassword($cliente));

        return response()->json([
            'message' => 'Email enviado com sucesso!',
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required',
            'senha' => 'required|min:8',
        ], [
            'token.required' => 'O campo token é obrigatório!',
            'senha.required' => 'O campo senha é obrigatório!',
            'senha.min' => 'O campo senha deve ter no mínimo 8 caracteres!',
        ]);

        $cliente = Cliente::where('token_de_recuperacao', $validated['token'])->first();
        
        if (!$cliente) {
            return response()->json([
                'message' => 'Token inválido!',
            ], 401);
        }

        if ($cliente->data_de_expiracao_do_token_de_recuperacao < now()) {
            return response()->json([
                'message' => 'Token expirado!',
            ], 401);
        }

        $cliente->password = bcrypt($validated['senha']);
        $cliente->token_de_recuperacao = null;
        $cliente->data_de_expiracao_do_token_de_recuperacao = null;
        $cliente->save();

        Mail::to($cliente->email)->send(new ResetPassword($cliente));

        return response()->json([
            'message' => 'Senha alterada com sucesso!',
        ], 200);
    }

    public function show(Request $request)
    {
        return response()->json([
            'cliente' => $request->user(),
        ], 200);
    }

    public function reviews(Request $request)
    {
        $validated = $request->validate([
            'data_inicial' => 'nullable|date',
            'data_final' => 'nullable|date:after_or_equal:data_inicial',
            'order' => 'nullable|in:asc,desc',
        ],
        [
            'data_inicial.date' => 'O campo data inicial deve ser uma data válida!',
            'data_final.date' => 'O campo data final deve ser uma data válida!',
            'data_final.after_or_equal' => 'O campo data final deve ser maior ou igual ao campo data inicial!',
            'order.in' => 'O campo order deve ser asc ou desc!',
        ]);

        $reviews = $request->user()->reviews()->with('produto');

        if ($request->filled('data_inicial')) {
            $reviews->whereDate('created_at', '>=', $validated['data_inicial']);
        }

        if ($request->filled('data_final')) {
            $reviews->whereDate('created_at', '<=', $validated['data_final']);
        }

        if ($request->filled('order')) {
            $reviews->orderBy('created_at', $validated['order']);
        }

        $reviews = $reviews->get();

        if ($reviews->isEmpty()) {
            return response()->json([
                'message' => 'Nenhuma avaliação encontrada!',
            ], 404);
        }

        return response()->json([
            'reviews' => $reviews,
        ], 200);
    }

    public function pedidos(Request $request)
    {
        $validated = $request->validate([
            'data_inicial' => 'nullable|date',
            'data_final' => 'nullable|date:after_or_equal:data_inicial',
            'entregue' => 'nullable|boolean',
            'order' => 'nullable|in:asc,desc'
        ],
        [
            'data_inicial.date' => 'O campo data inicial deve ser uma data válida!',
            'data_final.date' => 'O campo data final deve ser uma data válida!',
            'data_final.after_or_equal' => 'O campo data final deve ser maior ou igual ao campo data inicial!',
            'entregue.boolean' => 'O campo entregue deve ser true ou false!',
            'order.in' => 'O campo order deve ser asc ou desc!'
        ]);

        $pedidos = $request->user()->pedidos()->with('pedidos');

        if ($request->filled('data_inicial')) {
            $reviews->whereDate('created_at', '>=', $validated['data_inicial']);
        }

        if ($request->filled('data_final')) {
            $reviews->whereDate('created_at', '<=', $validated['data_final']);
        }

        if ($request->filled('entregue')) {
            $reviews->where('entregue', $validated['entregue']);
        }

        if ($request->filled('order')) {
            $reviews->orderBy('created_at', $validated['order']);
        }

        $pedidos = $pedidos->get();

        if ($pedidos->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum pedido encontrado!',
            ], 404);
        }

        return response()->json([
            'pedidos' => $pedidos,
        ], 200);
    }

    public function pedido(Request $request, $id)
    {
        $pedido = $request->user()->pedidos()->with('pedidos')->find($id);

        if (!$pedido) {
            return response()->json([
                'message' => 'Pedido não encontrado!',
            ], 404);
        }

        return response()->json([
            'pedido' => $pedido,
        ], 200);
    }

    public function updateReview(Request $request, $id)
    {
        $validated = $request->validate([
            'pontuacao' => 'required|integer|min:1|max:5',
            'descricao' => 'nullable|string',
        ],
        [
            'pontuacao.required' => 'O campo pontuação é obrigatório!',
            'pontuacao.integer' => 'O campo pontuação deve ser um número inteiro!',
            'pontuacao.min' => 'O campo pontuação deve ser no mínimo 1!',
            'pontuacao.max' => 'O campo pontuação deve ser no máximo 5!',
            'descricao.string' => 'O campo descrição deve ser uma string!',
        ]);

        $review = $request->user()->reviews()->find($id);

        if (!$review) {
            return response()->json([
                'message' => 'Avaliação não encontrada!',
            ], 404);
        }

        $review->pontuacao = $validated['pontuacao'];
        $review->descricao = $validated['descricao'];
        $review->save();

        return response()->json([
            'message' => 'Avaliação alterada com sucesso!',
        ], 200);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'nullable|string',
            'email' => 'nullable|email|unique:clientes',
            'senha' => 'nullable|min:8',
        ],
        [
            'email.email' => 'O campo email deve ser um email válido!',
            'email.unique' => 'O email informado já está cadastrado!',
            'senha.min' => 'O campo senha deve ter no mínimo 8 caracteres!',
        ]);

        $cliente = $request->user();

        if ($request->filled('nome')) {
            $cliente->nome = $validated['nome'];
        }

        if ($request->filled('email')) {
            $cliente->email = $validated['email'];
            $cliente->verificado = false;
            $cliente->token_de_verificacao = Str::random(10) . uniqid() . Str::random(10);
            Mail::to($cliente->email)->send(new EmailVerification($cliente));
        }

        if ($request->filled('senha')) {
            $cliente->password = bcrypt($validated['senha']);
        }

        $cliente->save();

        return response()->json([
            'message' => 'Cliente alterado com sucesso!',
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ]);
    }
}
