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
