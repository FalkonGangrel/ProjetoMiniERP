<?php

namespace App\Helpers;

class Util{

    public static function view(string $template, array $data = []): void
    {
        $templatePath = __DIR__ . '/../views/' . str_replace('.', '/', $template) . '.php';
    
        if (!file_exists($templatePath)) {
            die("View '{$template}' não encontrada.");
        }
    
        // Extrai os dados para uso na view
        extract($data);
    
        // Captura o conteúdo da view
        ob_start();
        require $templatePath;
        $content = ob_get_clean();
    
        // Usa o layout base
        require __DIR__ . '/../views/templates/base.php';
    }
    
    public static function redirect($url)
    {
        header("Location: $url");
        exit;
    }
    
    public static function e($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

}
