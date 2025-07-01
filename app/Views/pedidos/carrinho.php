<div class="container mt-4">
    <h2>Pedido</h2>

    <div class="card mb-3 p-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label for="produto" class="form-label">Produto</label>
                <select id="produto" class="form-select select2">
                    <option value="">Selecione</option>
                    <?php foreach ((new \App\Models\Produto())->listarTodos() as $produto): ?>
                        <option value="<?= $produto['id'] ?>"><?= $produto['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="variacao" class="form-label">Variação</label>
                <select id="variacao" class="form-select" disabled>
                    <option value="">Selecione o produto</option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="preco_unitario" class="form-label">Preço Unitário (R$)</label>
                <input type="number" id="preco_unitario" class="form-control" step="0.01" min="0">
            </div>

            <div class="col-md-2">
                <label for="quantidade" class="form-label">Qtd</label>
                <input type="number" id="quantidade" class="form-control" value="1" min="1">
            </div>

            <div class="col-md-1">
                <label for="adicionarItem" class="form-label">&nbsp;</label>
                <button id="adicionarItem" class="btn btn-success w-100">+</button>
            </div>
        </div>
    </div>

    <table class="table table-bordered" id="tabelaItens">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Variação</th>
                <th>Qtd</th>
                <th>Preço</th>
                <th>Total</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <div class="card p-3 mb-3">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="cep">CEP</label>
                <input type="text" class="form-control" id="cep">
            </div>
            <div class="col-md-8">
                <label for="endereco">Endereço</label>
                <input type="text" class="form-control" id="endereco">
            </div>
            <div class="col-md-6">
                <label for="cliente">Cliente</label>
                <input type="text" class="form-control" id="cliente">
            </div>
            <div class="col-md-3">
                <label for="frete">Frete (R$)</label>
                <input type="number" id="frete" class="form-control" value="0" step="0.01">
            </div>
            <div class="col-md-3">
                <label for="total">Total (R$)</label>
                <input type="text" class="form-control" id="total" readonly>
            </div>
        </div>
    </div>

    <button class="btn btn-primary" id="finalizarPedido">Finalizar Pedido</button>
</div>

<script>
let itens = [];
let variacoesDisponiveis = {}; // id => {variacao, preco, quantidade}

function atualizarTabela() {
    const tbody = document.querySelector("#tabelaItens tbody");
    tbody.innerHTML = "";
    let total = 0;

    itens.forEach((item, i) => {
        const subtotal = item.quantidade * item.preco;
        total += subtotal;

        const row = `<tr>
            <td>${item.produto_nome}</td>
            <td>${item.variacao_nome}</td>
            <td>${item.quantidade}</td>
            <td>R$ ${item.preco.toFixed(2)}</td>
            <td>R$ ${subtotal.toFixed(2)}</td>
            <td><button class="btn btn-danger btn-sm" onclick="removerItem(${i})">Remover</button></td>
        </tr>`;
        tbody.innerHTML += row;
    })

    const frete = parseFloat(document.querySelector("#frete").value) || 0;
    document.querySelector("#total").value = (total + frete).toFixed(2);
}

function removerItem(index) {
    itens.splice(index, 1);
    atualizarTabela();
}

function carregarVariacoes(produtoId) {
    if (!produtoId) {
        document.querySelector("#variacao").innerHTML = '<option value="">Selecione o produto</option>';
        document.querySelector("#variacao").disabled = true;
        return;
    }

    fetch(`/api/estoques/por-produto/${produtoId}`)
        .then(resp => resp.json())
        .then(data => {
            opts = false;
            variacoesDisponiveis = {};
            const select = document.querySelector("#variacao");
            select.innerHTML = '<option value="">Selecione</option>';
            data.forEach(v => {
                variacoesDisponiveis[v.id] = v;
                select.innerHTML += `<option value="${v.id}" data-preco="${v.preco}">${v.variacao} - R$ ${v.preco}</option>`;
                opts = true;
            })
            if(opts){
                select.disabled = false;
            }else{
                select.disabled = true;
            }
        })
}

// Evento: produto selecionado => carregar variações

$("#produto").on("change", function() {
    const valor = $(this).val();
    carregarVariacoes(valor);
})

// Evento: variação selecionada => auto-preenchimento do preço

document.querySelector("#variacao").addEventListener("change", function() {
    const variacaoId = this.value;
    if (variacoesDisponiveis[variacaoId]) {
        document.querySelector("#preco_unitario").value = variacoesDisponiveis[variacaoId].preco;
    } else {
        document.querySelector("#preco_unitario").value = "";
    }
});

// Evento: botão adicionar item

document.querySelector("#adicionarItem").addEventListener("click", () => {
    const produtoSelect = document.querySelector("#produto");
    const produto_id = produtoSelect.value;
    const produto_nome = produtoSelect.options[produtoSelect.selectedIndex].text;
    const variacao_id = document.querySelector("#variacao").value;
    const quantidade = parseInt(document.querySelector("#quantidade").value);
    const preco_unitario = parseFloat(document.querySelector("#preco_unitario").value);

    if (!produto_id || !variacao_id || quantidade <= 0) {
        alert("Preencha todos os campos corretamente.");
        return;
    }

    const v = variacoesDisponiveis[variacao_id]
    if (!v || v.quantidade < quantidade) {
        alert("Estoque insuficiente para essa variação.");
        return;
    }

    if (isNaN(preco_unitario) || preco_unitario < 0) {
        alert("Preço inválido.");
        return;
    }

    itens.push({
        produto_id,
        produto_nome,
        variacao: variacao_id,
        variacao_nome: v.variacao,
        quantidade,
        preco: preco_unitario
    })

    atualizarTabela()
    document.querySelector("#variacao").value = ""
    document.querySelector("#quantidade").value = 1
})

// Evento: finalizar pedido

document.querySelector("#finalizarPedido").addEventListener("click", () => {
    const cliente = document.querySelector("#cliente").value
    const endereco = document.querySelector("#endereco").value
    const cep = document.querySelector("#cep").value
    const frete = parseFloat(document.querySelector("#frete").value) || 0
    const total = parseFloat(document.querySelector("#total").value) || 0

    if (!cliente || !endereco || !cep || itens.length === 0) {
        alert("Preencha os dados do cliente e adicione itens.")
        return
    }

    fetch('/pedidos/salvar', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ cliente, endereco, cep, frete, total, itens })
    })
    .then(resp => resp.text())
    .then(msg => {
        alert(msg)
        location.reload()
    })
    .catch(() => alert("Erro ao salvar pedido"))
})

// Atualiza o endereço com o CEP

document.querySelector("#cep").addEventListener("blur", () => {
    const cep = document.querySelector("#cep").value.replace(/\D/g, '');
    if (cep.length !== 8) return;

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (data.erro) {
                alert("CEP inválido");
            } else {
                document.querySelector("#endereco").value = `${data.logradouro}, ${data.bairro}, ${data.localidade}-${data.uf}`;
            }
        })
        .catch(() => alert("Erro ao consultar CEP"));
});

// Atualiza total ao mudar o frete

document.querySelector("#frete").addEventListener("input", atualizarTabela)
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        $('.select2').select2()
    })
</script>
