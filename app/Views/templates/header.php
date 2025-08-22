<!-- app/Views/templates/header.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Mini ERP' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">MiniERP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuERP">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuERP">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/produtos">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="/estoque">Estoque</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pedidos">Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="/cupons">Cupons</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
