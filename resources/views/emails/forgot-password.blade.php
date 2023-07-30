<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 0 auto;
            max-width: 600px;
            padding: 20px;
        }
        .logo {
            display: block;
            margin: 0 auto;
            width: 300px !important;
            height: 300px !important;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            color: #ffffff;
            background-color: #007BFF;
            border-radius: 25px;
            font-size: 16px;
            transition: all 0.5s;
            cursor: pointer;
            margin: 0 auto;
        }

        .button:hover {
            background-color: #0069D9;
            color: white;
        }

        .button:active {
            background-color: #0062CC;
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <img class="logo" src="cid:logo.svg" alt="Logo">

    <h1>Olá, {{ $cliente->nome }} 👋</h1>

    <p>Recebemos um pedido de redefinição de senha para sua conta na SlowShop. Nada a temer! Estamos aqui para ajudar você nessa tarefa. 🚀</p>

    <p>Para redefinir sua senha, basta clicar no botão abaixo. Mas atenção: se você solicitou a alteração da sua conta anteriormente, somente este link mais recente é válido. E lembre-se, a troca de senha é válida por 30 minutos, ou seja, até {{ $cliente->data_de_expiracao_do_token_de_recuperacao->format('d/m/Y H:i:s') }} 🕒.</p>

    <a href="{{ url('/redefinir-senha/' . $cliente->token_de_recuperacao) }}" class="button">Redefinir Senha</a>

    <p>Se não foi você que solicitou esta redefinição, sua conta pode estar comprometida. 😱 Por gentileza, recomendamos que altere a senha da sua conta. Caso não consiga ou precise de assistência, não hesite em entrar em contato com nosso suporte pelo email slowshop@suporte.com.</p>

    <p>Estamos sempre por perto para tornar sua experiência conosco ainda melhor! 😄</p>

    <p>Atenciosamente,</p>
    <p>Equipe SlowShop 🚀</p>
</div>
</body>
</html>
