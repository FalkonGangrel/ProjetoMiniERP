<div class="container mt-5">
    <h2>Adicionar Estoque</h2>
    <form action="/estoques/salvar" method="POST">
        <div class="mb-3">
            <label for="produto_id" class="form-label">ID do Produto</label>
            <input type="number" class="form-control" id="produto_id" name="produto_id" required>
        </div>
        <div class="mb-3">
            <label for="variacao" class="form-label">Variação</label>
            <input type="text" class="form-control" id="variacao" name="variacao">
        </div>
        <div class="mb-3">
            <label for="quantidade" class="form-label">Quantidade</label>
            <input type="number" class="form-control" id="quantidade" name="quantidade" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
