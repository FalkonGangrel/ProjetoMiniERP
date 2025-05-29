<div class="container mt-5">
    <h2>Cadastrar Pedido</h2>
    <form action="/pedidos/salvar" method="POST">
        <div class="mb-3">
            <label for="cliente" class="form-label">Nome do Cliente</label>
            <input type="text" class="form-control" id="cliente" name="cliente" required>
        </div>
        <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" step="0.01" class="form-control" id="total" name="total" required>
        </div>
        <div class="mb-3">
            <label for="frete" class="form-label">Frete</label>
            <input type="number" step="0.01" class="form-control" id="frete" name="frete">
        </div>
        <div class="mb-3">
            <label for="endereco" class="form-label">Endereço</label>
            <textarea class="form-control" id="endereco" name="endereco" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
