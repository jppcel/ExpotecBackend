# O uso do framework

Você pode usar o projeto do <a href="https://github.com/Expotec2017/ExpotecDocker" target="\_blank">container docker</a> que o @felipefrizzo fez, ou pode usar um semi-tutorial abaixo.

## O Artisan

Se você observar o projeto, você encontrará um arquivo chamado "artisan". Esse arquivo é um """"executável"""" do laravel para a criação de diversos itens do projeto, como migrations, controllers, models e assim vai. Além disso, ele é usado para executar comandos que são para executar o servidor de desenvolvimento local, migrar databases e assim vai(novamente...).

O nome artisan(Artesão) tem tudo a ver até com o framework: o Laravel diz que é para os Artesões da Web... :)

# O semi-tutorial

Requisitos:
- PHP (Mínimo PHP5) - https://blog.schoolofnet.com/2015/04/como-instalar-o-php-no-windows-do-jeito-certo-e-usar-o-servidor-embutido/;
- MariaDB (ou MySQL) - https://downloads.mariadb.org/;

## Pré-configurações

Com os requisitos instalados e configurados, vamos à configuração das variáveis de ambiente do Laravel.
copie o arquivo .env.example para .env e faça algumas alterações:

  Troque os seguintes campos para os dados de acesso ao banco. É necessário que tenha um banco de dados cadastrado para uso do laravel.

  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=homestead
  DB_USERNAME=homestead
  DB_PASSWORD=secret

## Baixando as dependências

Abra o CMD e acesse a pasta do projeto e baixe o composer(https://getcomposer.org/download/).

Após os comandos informados no site tenham sido executados, execute: "php composer.phar install"
Esse processo pode demorar um pouco. Ele vai baixar todas as dependências do projeto. Além disso, ele vai gerar uma chave que o projeto irá utilizar, mas enfim, isso é da parte de execução do Laravel.

## Migrando a base de dados

Com as dependências do projeto baixadas e as variáveis de ambiente configuradas, vamos migrar o banco de dados.
No laravel, temos arquivos de configuração que geram as tabelas do banco, esses são chamados de <i>migrations</i>.

Para executar as migrations é necessário apenas executar o seguinte comando do artisan: "php artisan migrate".

## Executando o servidor de testes

Agora estamos próximos de executar o inicial do projeto, mas antes temos que ter uma certeza: O laravel usa a porta 8000 do seu computador para poder executar o servidor de testes, então, tenha certeza que nenhum outro aplicativo ou software esteja usando essa porta para evitar problemas de execução.

Para executar o servidor de testes, execute no cmd na pasta do projeto: "php artisan serve".
Se tudo der certo ele vai aparecer o seguinte: <i>Laravel development server started: <http://127.0.0.1:8000></i>.
Se isso aconteceu, pode acessar o link que está aparecendo no cmd e você terá acesso ao servidor de testes.


# Não estou conseguindo executar aqui em meu computador dessa forma!

Então, utilize o <a href="https://github.com/Expotec2017/ExpotecDocker" target="\_blank">container docker</a> que o @felipefrizzo fez, é mais certo que irá funcionar.
