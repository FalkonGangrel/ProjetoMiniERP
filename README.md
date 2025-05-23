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
├── assets/               # Arquivos estáticos (css, js, imagens)
├── controllers/          # Controladores (lógica da aplicação)
├── helpers/              # Funções auxiliares
├── inc/                  # Configuração (clDB, .env, funções)
├── models/               # Modelos (interação com o banco de dados)
├── public/               # Pasta pública para index.php (ponto de entrada)
├── routes/               # Rotas (ex: pedidos.php, produtos.php)
├── sistema/              # Página principal do sistema (dashboard)
├── view/                 # Views (páginas HTML)
├── .env                  # Arquivo de variáveis de ambiente
├── sql_base.sql          # Script de criação do banco de dados
└── README.md             # Este arquivo
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

4. **Rodar o sistema:**

Acesse a pasta `public/` no navegador (configurado como raiz pública no Apache/Nginx) ou via servidor local:

```
http://localhost/ProjetoMiniERP/public/
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

## 🛠️ Manutenção e Contribuições

Este projeto está em desenvolvimento contínuo. Sugestões, melhorias e contribuições são bem-vindas!

---

**Autor:** Anderson Dias Takeno  
**Licença:** MIT
