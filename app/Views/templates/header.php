<!-- app/Views/templates/header.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Mini ERP' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Favico-->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/apple-touch-icon.png">
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon-16x16.png">
    <link rel="manifest" href="/assets/img/site.webmanifest">
    <!--CSS-->
    <link href="/assets/css/estilo.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!--Scripts-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">MiniERP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuERP">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuERP">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/usuarios">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link" href="/produtos">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="/estoques">Estoque</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pedidos">Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="/cupons">Cupons</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Conteúdo principal -->
    <main class="container mt-4">
