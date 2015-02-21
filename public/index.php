<?php

require_once __DIR__ . '/../config/bootstrap.php';

use EJS\Produtos\Controller\ProdutoController;
use EJS\Produtos\Entity\Produto;
use EJS\Produtos\Mapper\ProdutoMapper;
use EJS\Produtos\Service\ProdutoService;
use EJS\Database\Conexao;
use Symfony\Component\HttpFoundation\Request;

//container de serviços
$app['produtoService'] = function() use($em){
    $produto = new Produto();
    $produtoMapper = new ProdutoMapper($em);
    $produtoService = new ProdutoService($produto, $produtoMapper);

    return $produtoService;
};

$app->mount('/api/produtos', new ProdutoController());

$app->run();