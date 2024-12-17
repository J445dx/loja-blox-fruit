<?php
function gerarPixPayload($chavePix, $valor, $descricao) {
    // Estrutura básica do PIX Copia e Cola
    $pix = [
        '00' => '01', // Payload Format Indicator
        '26' => [ // Merchant Account Information
            '00' => 'br.gov.bcb.pix', // GUI do PIX
            '01' => $chavePix,       // Chave PIX
        ],
        '52' => '0000', // Merchant Category Code (padrão)
        '53' => '986',  // Moeda: BRL (986)
        '54' => number_format($valor, 2, '.', ''), // Valor
        '58' => 'BR',   // País
        '59' => 'pagamentoonline', // Nome do beneficiário
        '60' => 'Cidade', // Cidade do beneficiário
        '62' => [ // Additional Data Field Template
            '05' => $descricao // Descrição do pagamento
        ]
    ];

    // Converte a estrutura do PIX em um payload formatado
    return formatPayload($pix);
}

function formatPayload($data) {
    $result = '';
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $value = formatPayload($value); // Recursão para subníveis
        }
        $length = str_pad(strlen($value), 2, '0', STR_PAD_LEFT); // Tamanho do valor
        $result .= $key . $length . $value; // Chave + Tamanho + Valor
    }
    return $result . '6304' . calculateCRC16($result . '6304'); // CRC16 no final
}

function calculateCRC16($payload) {
    $polynomial = 0x1021;
    $crc = 0xFFFF;

    for ($offset = 0; $offset < strlen($payload); $offset++) {
        $crc ^= (ord($payload[$offset]) << 8);
        for ($bitwise = 0; $bitwise < 8; $bitwise++) {
            if ($crc & 0x8000) {
                $crc = ($crc << 1) ^ $polynomial;
            } else {
                $crc <<= 1;
            }
        }
    }

    return strtoupper(dechex($crc & 0xFFFF));
}

// Exemplo de uso
$chavePix = "jheysonpereira439@gmail.com"; // Substitua pela sua chave PIX
$valor = 20; // Valor da transação em reais
$descricao = "pagar"; // Descrição opcional

$codigoCopiaCola = gerarPixPayload($chavePix, $valor, $descricao);

echo "Código Copia e Cola PIX:<br>";
echo "<textarea rows='5' cols='50'>$codigoCopiaCola</textarea>";
?>