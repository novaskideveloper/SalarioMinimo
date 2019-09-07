# Sistema que retorna os salários míminos

Sistema retorna um array com os valores do salário mínimo a parte da url: http://www.guiatrabalhista.com.br/guia/salario_minimo.htm

## Instalação

Clone o repositório e depois:

```shell
1 - cp .env.example .env
2 - composer install
3 - php artisan key:generate 
```

### Forma de uso

1 - Via http

```
php artisan serve
```

Agora abra: http://127.0.0.1:8000 para a visão de tabela

Para a visão de Json abra 

http://127.0.0.1:8000/api/table
