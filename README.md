# ProjetoMiniERP

![GitHub repo size](https://img.shields.io/github/repo-size/FalkonGangrel/ProjetoMiniERP)
![GitHub stars](https://img.shields.io/github/stars/FalkonGangrel/ProjetoMiniERP?style=social)
![GitHub issues](https://img.shields.io/github/issues/FalkonGangrel/ProjetoMiniERP)
![GitHub license](https://img.shields.io/github/license/FalkonGangrel/ProjetoMiniERP)

Um sistema de gestão empresarial (Mini ERP) simples desenvolvido em **PHP** com padrão **MVC**, utilizando **MySQL** como banco de dados e **Bootstrap** para a interface. Ideal para fins didáticos e pequenas aplicações de controle de produtos, pedidos e estoque.

## 🧰 Tecnologias Utilizadas

- **PHP** (sem framework)
- **MySQL** / **MariaDB**
- **Bootstrap** (interface responsiva)
- **Padrão MVC** (Model-View-Controller)
- **Variáveis de Ambiente (.env)** para configuração
- **Conexão com o banco via mysqli** (classe `clDB`)
- **Prepared Statements** para segurança nas consultas
- **Composer** opcional (para autoload futuro)

## 📁 Estrutura de Pastas

```
ProjetoMiniERP/
├── app/
│   ├── Controllers/          # Lógica da aplicação (ProdutoController, PedidoController, EstoqueController)
│   ├── Core/                 # Núcleo do sistema (Router.php, clDotEnv.php etc.)
│   ├── Models/               # Modelos do sistema (Produto.php, Pedido.php, Estoque.php)
│   ├── Views/
│   │   ├── templates/        # Layout base (header.php, footer.php, base.php)
│   │   ├── produtos/         # Views de produtos (lista.php)
│   │   ├── pedidos/          # Views de pedidos (lista.php)
│   │   └── estoques/         # Views de estoque (lista.php)
│   └── helpers/              # Funções auxiliares (view.php)
├── config/                   # Arquivos de configuração
├── public/                   # Raiz pública (index.php, .htaccess)
├── routes/                   # Rotas registradas (web.php)
├── sql/                      # Base de dados (sql_base.sql)
├── .env                      # Variáveis de ambiente
├── composer.json             # Autoload e dependências
└── README.md                 # Este arquivo
```

## ⚙️ Configuração do Ambiente

1. **Clonar o repositório:**

```bash
git clone https://github.com/FalkonGangrel/ProjetoMiniERP.git
cd ProjetoMiniERP
```

2. **Criar o banco de dados:**

Importe o arquivo `sql_base.sql` no seu banco de dados MySQL ou MariaDB:

```sql
SOURCE caminho/para/sql_base.sql;
```

3. **Configurar o arquivo `.env`:**

Crie um arquivo `.env` na raiz com os seguintes dados:

```
DB_HOST=localhost
DB_USER=seu_usuario
DB_PASS=sua_senha
DB_NAME=db_mini_erp
```

4. **Configurar o Apache para rodar na porta 8090:**

Abra o arquivo de configuração do Apache (`httpd.conf` ou `httpd-vhosts.conf`) e adicione:

```apache
Listen 8090

<VirtualHost *:8090>
    DocumentRoot "E:/Trabalhos/Projetos/ProjetoMiniERP/public"
    <Directory "E:/Trabalhos/Projetos/ProjetoMiniERP/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

> ⚠️ Use **barra normal `/`** mesmo no Windows e certifique-se que o módulo `mod_rewrite` está habilitado no Apache.

Reinicie o Apache após a alteração.

5. **Rodar o sistema:**

Acesse no navegador:

```
http://localhost:8090/
```

ou diretamente para alguma rota registrada, como:

```
http://localhost:8090/produtos
```

## 🧾 Tabelas Incluídas

O script `sql_base.sql` cria as seguintes tabelas:

- `produtos`: Cadastro de produtos
- `estoques`: Controle de estoque por variação
- `pedidos`: Registro de pedidos com total, frete e endereço
- `cupons`: Códigos promocionais com regras de uso

As tabelas possuem integridade relacional e índices otimizados.

## 📌 Funcionalidades em Desenvolvimento

- [x] Cadastro e listagem de produtos
- [x] Controle de estoque
- [x] Registro de pedidos
- [x] Aplicação de cupons de desconto
- [ ] Tela de login e controle de usuários
- [ ] Relatórios gerenciais
- [ ] API REST para integração externa

## 📼 Manutenção e Contribuições

Este projeto está em desenvolvimento contínuo. Sugestões, melhorias e contribuições são bem-vindas!

---

**Autor:** Anderson Dias Takeno  
**Licença:** MIT
