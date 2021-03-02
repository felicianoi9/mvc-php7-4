# MVC - PHP-7.4

Este é um projeto de uma estrutura básica de MVC com php 7.4, com autenticação de usuário, recuperação de senha muito funcional, ultilizando, MYSQL, ajax, Template Engine... com envio de email...

## Como instalar
1. clone o projeto
2. No terminal, rode o comando: composer install
3. Crie o arquivo .env e insira dados de conexão com banco de dados, url do projeto, seus dados do Sendgrid para envio de emails:
> Uma forma de fazer:
> no terminal, dentro da pasta do projeto, faça: cp env-copy .env
> depois, abra o arquivo .env com o editor preferido e preencha:]
>ROOT=http://urldasuaapp.test
>
>DATABASE_DRIVER=mysql
>DATABASE_HOST=127.0.0.1 ou localhost ou mysql se estiver usando laradock
>DATABASE_PORT=3306
>DATABASE_DB_NAME=nome_do_seu_banco_de_dados
>DATABASE_USER_NAME=nome_do_usuario_do_banco
>DATABASE_PASSWORD=senha_do_seu_usuario
>
>MAIL_SEND_GRID_HOST=smtp.sendgrid.net
>MAIL_SEND_GRID_PORT=verificar na sua conta sendgrid
>MAIL_SEND_GRID_USER=verificar na sua conta sendgrid
>MAIL_SEND_GRID_PASS=verificar na sua conta sendgrid
>MAIL_SEND_GRID_FROM_NAME=Nome_de_envio
>MAIL_SEND_GRID_FROM_EMAIL=Email_de_envio

## Banco de dados
Dentro do seu banco MySQL, importe o banco de dados da pasta db-basic

Agora, acesse http://urldasuaapp.test ( a url de seu projeto ) e aproveite, crie uma usuário e divirta-se!



