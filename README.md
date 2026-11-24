# Blog com painel administrativo

Projeto em **PHP 8 + Symfony 7.4 + Twig + Doctrine**, com cadastro de posts e usuários.

> 🚧 Em desenvolvimento.

## Funcionalidades

- CRUD de posts: cadastro, listagem com busca e filtro por status, visualização, edição e exclusão
- Rascunho/publicado, categoria e autor (relacionamento com usuário)
- CRUD de usuários
- Validação de formulários com mensagens em português
- Proteção CSRF e layout responsivo com CSS próprio

## Tecnologias

- PHP 8.2+ / Symfony 7.4
- Twig
- Doctrine ORM + Migrations
- MariaDB/MySQL
- AssetMapper (sem Node.js)

## Como rodar localmente

```bash
git clone <url-do-repositorio>
cd crud-twig
composer install

# configure o banco em .env.local
echo 'DATABASE_URL="mysql://usuario:senha@127.0.0.1:3306/crud_twig?serverVersion=11.8.6-MariaDB&charset=utf8mb4"' > .env.local

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

symfony serve   # ou: php -S 127.0.0.1:8000 -t public
```

Acesse `http://127.0.0.1:8000/posts`.
