# TripManager

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/vuejs-%2335495e.svg?style=for-the-badge&logo=vuedotjs&logoColor=%234FC08D)
![SQLite](https://img.shields.io/badge/sqlite-%2307405e.svg?style=for-the-badge&logo=sqlite&logoColor=white)
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)

Sistema de gerenciamento de solicitações de viagens corporativas

<br>

## Introdução

Este projeto almeja prover um backend ([Laravel](https://laravel.com/docs/12.x)) e um frontend ([Vue](https://vuejs.org/guide/introduction.html)) para gerenciar solicitações de viagens corporativas.

<br>

> :warning: É a primeira vez que uso essas ferramentas. Há muito o que melhorar.

<br>

## Como executar

> É necessário ter instalado o [Docker](https://www.docker.com/) (e o compose) para execução dos containers.

<br>

Crie um arquivo `.env` na raíz da pasta `trip-api` com a mesma estrutura de [`.env.example`](/trip-api/.env.example). O arquivo já possui todos os dados necessários (e alguns desnecessários).

<br>

Agora, vá até a raíz da pasta `docker` do repositório e execute:
```bash
docker compose up --build 
```

<br>

Esse comando já executa as imagens da api, do web e instala o que é necessário.

<br>

A partir daí, a API deve estar em execução na porta 8000 e a interface na porta 5173.  

#### WEB
>> [127.0.0.1:5173](http://127.0.0.1:5173/)

#### API
>> [127.0.0.1:8000/docs](http://127.0.0.1:8000/docs)
  
<br>

> Você pode criar um usuário utilizando a rota `127.0.0.1:8000/api/register` ou acessando o site em `127.0.0.1:5173/register`

<br>

## Teste(s)

Por enquanto só existe um teste na api, que realiza o fluxo completo (registro, login, criação e edição de solicitação)  
  
Para executá-lo:
- Descubra o nome ou o ID do container da API em execução com `docker ps`
- Execute: `docker exec -it {nome-container-api-1} php artisan test`

<br>
<br>

##### [E se quiser ver algumas das outras ideias que já tive...](https://github.com/tiagofribeiro)
