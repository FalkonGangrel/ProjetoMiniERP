<?php
namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarEmailPedido($para, $nomeCliente, $pedido)
{
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST']; // Seu servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];        // Seu usuário SMTP
        $mail->Password = $_ENV['MAIL_PASSWORD'];        // Sua senha SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ou 'ssl'
        $mail->Port = 587; // ou 465 para SSL

        // Remetente e destinatário
        $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress($para, $nomeCliente);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = "Confirmação do Pedido #{$pedido['id']}";
        
        // Corpo do e-mail
        $body = "<h2>Obrigado pelo seu pedido, {$nomeCliente}!</h2>";
        $body .= "<p>Pedido: #{$pedido['id']}<br>";
        $body .= "Total: R$ ".number_format($pedido['total'], 2, ',', '.')."<br>";
        $body .= "Frete: R$ ".number_format($pedido['frete'], 2, ',', '.')."</p>";
        $body .= "<h4>Itens:</h4><ul>";

        foreach ($pedido['itens'] as $item) {
            $body .= "<li>{$item['produto_nome']} - {$item['variacao']} - Qtd: {$item['quantidade']} - Unitário: R$ "
                    .number_format($item['preco_unitario'], 2, ',', '.')."</li>";
        }
        $body .= "</ul>";

        $mail->Body = $body;

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Erro ao enviar e-mail: {$mail->ErrorInfo}");
        return false;
    }
}
