# Simple Tests Plan

## Feature: B001 - Autenticação no admin
### Test Case 1
- **Scenario**: Usuário solicita autenticação no sistema com credenciais (login e password) VÁLIDAS;
- **Given**: Um usuário "admin" com senha "admin";
- **When**: O usuário ativa rota de autenticação;
- **Then 1**: Uma sessão é criada para o usuário;
- **Then 2**: Usuário é redirecionado para a página inicial do admin;

### Test Case 2
- **Scenario**: Usuário solicita autenticação no sistema com credenciais (login e password) INVÁLIDAS;
- **Given**: Um usuário "admin" com senha em branco;
- **When**: O usuário ativa rota de autenticação;
- **Then 1**: Uma mensagem de erro (Exception) é lançada;

## Feature: B002 - Criação de um novo usuário no admin
### Test Case 1
- **Scenario**: Usuário autenticado no admin solicita a criação de um novo usuário;
- **Given**: os dados (name: Carlos; login: carlos; email: carlos@mail.com; nrphone: 27981000090; inadmin: 1)
- **When**: o usuário ativa rota de criação de usuário (create);
- **Then 1**: é criado no banco um registro com os dados informados

### Test Case 2
- **Given**: um usuário autenticado no admin preenche o formulário com alguma das informações (name, login, email, password e inadmin) faltando;
- **When**: o usuário ativa rota de criação de usuário (create);
- **Then 1**: uma mensagem de erro é retornada;

## Feature: B003 - Atualização de um usuário no admin
### Test Case 1
- **Given**: um usuário autenticado no admin (em qualquer tela que dê acesso ao formulário de atualização);
- **When**: ativa a rota para o formulário de atualização (clica no botão referente ao usuário que deseja atualizar);
- **Then 1**: os dados do usuário informado são retornados do banco;

### Test Case 2
- **Given**: um usuário autenticado no admin preenche o formulário com todas as informações (name, login, email, password e inadmin) do novo usuário que deve ser criado;
- **When**: o usuário ativa rota de atualização de usuário (update);
- **Then 1**: um usuário é registrado no banco