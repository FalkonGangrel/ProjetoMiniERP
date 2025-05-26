<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Mini ERP - Início</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Mini ERP</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/produtos">Produtos</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container text-center">
        <h1 class="mb-4">Bem-vindo ao Mini ERP</h1>
        <p class="lead">Escolha uma das opções abaixo para começar:</p>

        <div class="row mt-5">
            <div class="col-md-6">
                <a href="/produtos" class="btn btn-success btn-lg w-100 mb-3">Gerenciar Produtos</a>
            </div>
            <div class="col-md-6">
                <a href="/relatorios" class="btn btn-secondary btn-lg w-100 mb-3">Relatórios</a>
            </div>
        </div>
    </div>

    <footer class="bg-light text-center text-muted py-3 mt-5">
        Mini ERP © <?= date('Y') ?> - Desenvolvido por Anderson Takeno
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
