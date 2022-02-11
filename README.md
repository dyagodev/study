# Study API
## _API para transferencias monetária entre usuários_

Study API permite enviar e receber dinheiro.

- Sistema de Antifraud integrado
- Notificações sobre recebimento de Transferencias
- Criado com carinho 💚

## Features

- Envio de Dinheiro entre Usuários
- Verificação de possíveis fraudes de transações
- Notificação sobre transferencias recebidas
- Validação de E-mail e CPF/CNPJ

## Tech

StudyAPI usa vários projetos de código aberto para funcionar corretamente:

- [Laravel] - Laravel é um framework de aplicação web com sintaxe expressiva e elegante!
- [PHP] - PHP é uma linguagem de script de uso geral popular que é especialmente adequada para desenvolvimento web.
- [MySQL] - O MySQL é um sistema de gerenciamento de banco de dados, que utiliza a linguagem SQL como interface.

E, claro, o próprio Suty API é de código aberto com um repositório público.

## Installation

Study API Requer [Docker](https://www.docker.com/) and [Docker-compose](https://docs.docker.com/compose/install/) para rodar.

Instale as dependências e devDependencies e inicie o servidor.

```sh
cd study
docker-compose up -d
docker-compose exec app php artisan migrate --seed
```
> Nota: Configure seu `.env` com os dados do banco de dados do container MySQL encontrado no `docker-compose.yml`.

Exemplo:
```sh
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=study
DB_USERNAME=study
DB_PASSWORD=study
```

> Nota: Configure seus dados para envio de notificações por E-mail.

Acesse os endpoints da aplicação:

```sh
yourdomain.com/api
```

#### Criação de Usuários:
```sh
yourdomain.com/api/users/store
```
Payload:
{
	"email": "teste2@picpay.com",
	"name": "Usuário Teste 01",
	"password": "1234567",
	"password_confirmation": "1234567",
	"cpf_cnpj": "11111111111",
	"user_type": 1
}
** Todos os campos são obrigatórios
> Nota: `user_type` 1 => Usuário Comum ou 2 => Lojistas.

Ao criar um usuário é automaticamente criado uma carteira virutal para o mesmo através de um Observer.

#### Envio de Valores:
```sh
yourdomain.com/api/orders/store
```

Payload:
{
	"amount": 10.00,
	"payer": 1,
	"payee": 2
}
** Todos os campos são obrigatórios
> Nota: `payer` id do usuário pagador e `payee` id do usuário beneficiário

Ao fazer envio de valor para um usuário, 
o usuário beneficiário recebe uma notificação 
por email que é processado por uma [Fila](https://laravel.com/docs/8.x/queues).

## License

MIT

**Free Software!**
