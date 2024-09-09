# Sobre o projeto:
1. Construído com PHP com o framework Laravel;
2. Consumo API do TMDB para exbição dos filmes e avaliações;
4. Utilização do cache para evitar algumas chamadas recorrentes na API do TMDB para buscar gêneros de filmes, filmes populares e filmes mais bem avaliados;
5. Autenticação de usuários JetStream;
6. Banco de dados MySQL hospedado na Azure Cloud (atualmente desligado);
7. Deploy realizado na Azure na URL: https://mymoviesapp.azurewebsites.net/ (atualmente desligado)

# Instruções para Execução do Projeto Localmente
## Passo 1: Clone o projeto e navegue até a pasta raiz, em seguida crie o arquivo `.env`

1. Faça uma cópia do arquivo `.env.example` e nomeie-a como `.env`.

    ```bash
    cp .env.example .env
    ```

## Passo 2: Configurar o Certificado SSL

1. Localize o arquivo `DigiCertGlobalRootCA.crt.pem` na pasta raiz do projeto.

2. Abra o arquivo `.env` em um editor de texto.

3. Encontre a constante `DB_SSL_CA` e defina o caminho local do certificado SSL. Para obter o caminho:
   - Navegue até a pasta do projeto.
   - Clique com o botão direito no arquivo `DigiCertGlobalRootCA.crt.pem`.
   - Selecione "Propriedades" e copie o local do arquivo.
   - Cole o local na constante `DB_SSL_CA` no arquivo `.env`.

   **Nota:** Substitua as barras invertidas `\` por barras normais `/` no caminho do certificado SSL.

    ```env
    DB_SSL_CA=/caminho/para/DigiCertGlobalRootCA.crt.pem
    ```

## Passo 3: Instalar Dependências

1. Execute o comando abaixo para instalar as dependências do projeto:

    ```bash
    composer install
    ```

## Passo 4: Configurar o Ambiente Local

1. Abra o arquivo `Providers/AppServiceProvider.php`.

2. Encontre a linha que contém o código abaixo:

    ```php
    URL::forceScheme('https');
    ```

3. Comente essa linha para desativar o esquema HTTPS quando estiver executando localmente:

    ```php
    // URL::forceScheme('https');
    ```

## Passo 5: Executar a Aplicação

1. Finalmente, execute a aplicação com o comando abaixo:

    ```bash
    php artisan serve
    ```


