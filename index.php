<?php

function getWebPageContent(string $url): string {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36');
    
    $html = curl_exec($ch);
    curl_close($ch);
    
    return $html ?: '';
}

function extractEndereco(string $html, string $element_endereco): array {
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    libxml_clear_errors();
    
    $xpath = new DOMXPath($dom);
    $paragraphs = [];
    $nodes = $xpath->query("//div[contains(@class, '$element_endereco')]//p");
    
    foreach ($nodes as $node) {
        $paragraphs[] = trim($node->textContent);
    }
    
    return $paragraphs;
}

function extractDadosEmpresa(string $html, string $element_dados): array {
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    libxml_clear_errors();
    
    $xpath = new DOMXPath($dom);
    $dadosCNPJ = [];
    $nodes = $xpath->query("//div[contains(@class, '$element_dados')]");
    
    foreach ($nodes as $node) {
        $dadosCNPJ[] = trim($node->textContent);
    }
    
    return $dadosCNPJ;
}

$url = 'https://www.apple.com/br/app-store/';

$element_endereco = 'ac-gf-footer-shop';
$html = getWebPageContent($url);
$paragraphs = extractEndereco($html, $element_endereco);

echo "Endereço APPLE BR:" . PHP_EOL;
echo '<pre>';
print_r($paragraphs);
echo '</pre>';

$element_dados = 'ac-gf-footer-legal-copyright';
$dados_cnpj = extractDadosEmpresa($html, $element_dados);

echo "Dados CNPJ:" . PHP_EOL;
echo '<pre>';
print_r($dados_cnpj);
echo '</pre>';

/*
Fillipi | Programador

Web Scraping com PHP

Objetivo:
O código é um exemplo de web scraping usando PHP para extrair informações de uma página web.

Funcionalidades:

1. `getWebPageContent($url)`:
    - Realiza uma requisição HTTP para o URL fornecido e retorna o conteúdo HTML da página.
    - Utiliza cURL para obter o conteúdo com cabeçalhos adequados (como um navegador real) e configuração para seguir redirecionamentos.

2. `extractEndereco($html, $element_endereco)`:
    - Extrai os parágrafos (<p>) dentro de uma div com a classe especificada ($element_endereco).
    - Retorna o texto de cada parágrafo dentro dessa div como um array.

3. `extractDadosEmpresa($html, $element_dados)`:
    - Extrai o texto dentro de uma div com a classe especificada ($element_dados).
    - Retorna o conteúdo como um array com os dados coletados.

Fluxo de execução:

1. Requisição da Página: O código inicia fazendo uma requisição para o URL da Apple (https://www.apple.com/br/app-store/) para obter o HTML da página.

2. Extração de Dados: Utiliza as funções `extractEndereco` e `extractDadosEmpresa` para buscar e retornar informações de duas partes específicas da página:
    - Endereço: Extrai os parágrafos dentro da div com a classe ac-gf-footer-shop.
    - Dados da Empresa (CNPJ): Extrai o texto dentro da div com a classe ac-gf-footer-legal-copyright.

3. Exibição dos Resultados: Exibe os dados extraídos de cada uma das partes em formato legível.

Exemplos de saída:
    - Exibe os parágrafos extraídos de uma div específica.
    - Exibe os dados da empresa (no seu exemplo, informações como o CNPJ).

Observações:
    - Este código pode ser facilmente adaptado para outras páginas, alterando as URLs e classes dos elementos desejados.
    - Não há tratamento para JavaScript dinâmico ou interações com a página, o que significa que ele só funciona com HTML estático.

*/