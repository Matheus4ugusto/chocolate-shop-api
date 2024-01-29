<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        p {
            margin-top: 20px;
            font-size: 16px;
        }

        p.header {
            font-size: 18px;
            font-weight: bold;
        }

        p.footer {
            margin-top: 50px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
<p class="header">Olá, {{$user->name}}!</p>
<p>Seu pedido {{$order->id}} foi pago e logo será enviado!</p>

<ul>
    @foreach($order->products as $product)
        <li>{{$product->name}}, Preço unitário: {{number_format($product->pivot->unit_price,2,',','.')}},
            Qtd.: {{$product->pivot->quantity}}, Total:
            R$ {{number_format($product->pivot->total_price,2,',','.')}}</li>
    @endforeach
</ul>

<p>Obrigado pela preferência</p>
<br/>
<p class="footer">Chocolate Shop</p>
</body>
</html>
