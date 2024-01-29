<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recuperação de Senha</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        div {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        p {
            font-size: 16px;
            line-height: 1.5;
        }

        h2 {
            color: #0066cc;
        }

        p.footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
<div>
    <h2>Recuperação de Senha</h2>
    <p>Olá, {{$token->user->name}}!</p>
    <p>Recebemos uma solicitação para recuperar a senha da sua conta. Utilize o código abaixo para redefinir sua
        senha:</p>

    <p style="font-size: 20px; color: #0066cc; font-weight: bold;">{{ $token->token }}</p>

    <p>Este código é válido por 1 hora. Se você não solicitou a recuperação da senha, ignore este e-mail.</p>
    <p>Obrigado!</p>
</div>

<p class="footer">Equipe de Suporte - Chocolate Shop</p>
</body>
</html>
