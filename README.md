# 📝 Gerenciador de Tarefas

Um aplicativo web desenvolvido em **Laravel** para gerenciamento de tarefas com sistema de **prioridades**, **categorias**, **prazos** e **gráficos de desempenho**.

## 🚀 Funcionalidades Principais

✅ **Cadastro de Tarefas** Crie novas tarefas com título, categoria, urgência e data de prazo.

✅ **Filtro Dinâmâmico** Visualize tarefas por status (todas, pendentes ou concluídas).

✅ **Categorização** Classifique suas tarefas em:  
🏠 *Pessoal*
💼 *Trabalho*
📚 *Estudos*
💊 *Saúde*

✅ **Níveis de Urgência**
🔴 *Alta*
🟡 *Média*
🟢 *Baixa*
Cada tarefa exibe uma borda colorida de acordo com sua prioridade.

✅ **Prazos Inteligentes** - Exibe a data limite de cada tarefa;  
- Calcula quanto tempo falta ou se está atrasada;  
- Mostra o prazo de forma clara (ex: “Faltam 3 dias”).

✅ **Gráficos Interativos** Visualize:
- Progresso geral (concluídas, pendentes e atrasadas);
- Distribuição das tarefas por urgência.

✅ **Interface Amigável e Responsiva** Layout limpo, cores equilibradas e ícones para rápida identificação.

---

## ⚙️ Tecnologias Utilizadas

- **Laravel 10+**
- **PHP 8.2+**
- **Bootstrap 5**
- **Chart.js** (para gráficos)
- **Carbon** (para manipulação de datas)
- **SQLite / MySQL** (banco de dados)
- **Blade Templates**

---

## 🧩 Estrutura do Projeto
app/Http
       └── Controller.php
       └── TaskController.php
        
# Lógica principal das tarefas
app/Models
         └── Task.php
    
# Modelo de dados
resources/views
              └── tasks
                      └── index.blade.php
        
# Página principal
resources/views
              └── tasks
                      └── edit.blade.php

# Edição de tarefas
resources/views
              └── tasks
                      └── chart.blade.php

# Visualização de gráficos
database/migrations
    

## 🛠️ Instalação e Configuração

1.  **Clone o repositório**
    git clone [https://github.com/mikeEchoRomeoEchoUniform/to-do-list.git](https://github.com/mikeEchoRomeoEchoUniform/to-do-list.git)
    cd .../to-do-list

2.  **Instale as dependências**
    composer install

3.  **Configure o ambiente**

    Copie o arquivo `.env.example`:
    cp .env.example .env

    Configure seu banco de dados no arquivo `.env`:

    DB_CONNECTION=sqlite
    DB_DATABASE=/XAMPP/htdocs/to-do-list/database.sqlite

4.  **Gere a chave da aplicação**
    php artisan key:generate

5.  **Crie as tabelas**
    php artisan migrate

6.  **Inicie o servidor**
    php artisan serve

Acesse o projeto em: http://127.0.0.1:8000

---

## 📊 Gráficos

O sistema inclui gráficos automáticos usando Chart.js:
- **Gráfico de status:** mostra a proporção de tarefas concluídas, pendentes e atrasadas.
- **Gráfico de urgência:** indica a quantidade de tarefas por nível de prioridade.

Para acessar, visite: `/tasks/chart`

---

## 📅 Prazos

Cada tarefa pode ter um prazo (`due_date`), exibido diretamente na lista:
- **Verde** → dentro do prazo
- **Amarelo** → próximo do vencimento (2 dias)
- **Vermelho** → atrasado

---

## 💡 Melhorias Futuras

- [ ] Adicionar autenticação (login e usuários)
- [ ] Notificações de tarefas atrasadas
- [ ] Filtros por categoria
- [ ] Dark mode 🌙

---

## 👨‍💻 Autor

Desenvolvido por **Arthur Mereu** — estudante de Engenharia Elétrica e de Informática para Internet