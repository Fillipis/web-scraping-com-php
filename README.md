# Fillipi | Programador

# :sunglasses: Web Scraping com PHP

### Objetivo: O código é um exemplo de web scraping usando a linguagem PHP para extrair informações de uma página web.

### Fluxo de execução:

1. Requisição da Página: O código inicia fazendo uma requisição para o URL da Apple (https://www.apple.com/br/app-store/) para obter o HTML da página.

2. Extração de Dados: Utiliza as funções ` extractEndereco ` e ` extractDadosEmpresa ` para buscar e retornar informações de duas partes específicas da página:
    - Endereço: Extrai os parágrafos dentro da div com a classe ac-gf-footer-shop.
    - Dados da Empresa (CNPJ): Extrai o texto dentro da div com a classe ac-gf-footer-legal-copyright.

### Observações:
    - Este código pode ser facilmente adaptado para outras páginas, alterando as URLs e classes dos elementos desejados.
    - Não há tratamento para JavaScript dinâmico ou interações com a página, o que significa que ele só funciona com HTML estático.