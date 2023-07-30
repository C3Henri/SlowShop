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

    <p>Parabéns pelo seu cadastro! Nós da SlowShop ficamos muito felizes em tê-lo como cliente. Sinta-se à vontade para aproveitar nossas ótimas promoções. Preço baixo é o nosso lema!</p>

    <p>Caso precise, não hesite em entrar em contato com nosso suporte 24 horas em slowshop@suporte.com.</p>

    <p>Se você não fez este cadastro, simplesmente ignore este e-mail.</p>

    <a href="{{ url('/verificar-email/' . $cliente->token_de_verificacao) }}" class="button">Verificar Email</a>

    <p>Atenciosamente,</p>
    <p>Equipe SlowShop 🚀</p>
</div>
</body>
</html>
