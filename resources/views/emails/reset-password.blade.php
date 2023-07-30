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

    <p>Percebemos que a senha da sua conta SlowShop foi alterada recentemente. Se foi você, ótimo! Sua conta agora está mais segura. 🚀</p>

    <p>Se você não fez essa alteração, por favor, entre em contato conosco imediatamente. Sua segurança é nossa prioridade e vamos te ajudar a recuperar o acesso à sua conta. 🛡️</p>

    <a href="mailto:slowshop@suporte.com" class="button">Entrar em contato</a>

    <p>Agradecemos por ser um membro valioso da nossa comunidade SlowShop. Juntos, tornamos o comércio online mais seguro para todos. 😄</p>

    <p>Atenciosamente,</p>
    <p>Equipe SlowShop 🚀</p>
</div>
</body>
</html>
