<?php

namespace EJS\Produtos\Service;

use EJS\Database\Conexao;
use EJS\Produtos\Entity\Produto;
use EJS\Produtos\Mapper\ProdutoMapper;

class ProdutoService {

    private $produto;
    private $produtoMapper;


    function __construct(Produto $produto, ProdutoMapper $produtoMapper) {
        $this->produto = $produto;
        $this->produtoMapper = $produtoMapper;

    }

    public function listProdutos()
    {
        $produtoMapper = $this->produtoMapper;
        $result = $produtoMapper->listProdutos();

        $produtos = array();
        foreach($result as $produto)
        {
            $p = array();
            $p['id'] = $produto->getId();
            $p['nome'] = $produto->getNome();
            $p['descricao'] = $produto->getDescricao();
            $p['valor'] = $produto->getValor();

            $produtos[] = $p;
        }

        //return $result;
        return $produtos;
    }

    public function listProdutoById($id){
        $result = $this->produtoMapper->listProdutoById($id);

        if($result != null)
        {
            $produto = array();
            $produto['id'] = $result->getId();
            $produto['nome'] = $result->getNome();
            $produto['descricao'] = $result->getDescricao();
            $produto['valor'] = $result->getValor();
            return $produto;
        }
        else{
            return false;
        }
    }

    public function insertProduto($data){
        $this->produto->setNome($data['nome'])
                      ->setDescricao($data['descricao'])
                      ->setValor($data['valor']);
        if(empty($data['nome']) or empty($data['descricao']) or empty($data['valor'])){
            return ["STATUS" => "Erro: Você deve informar todos os valores"];
        }elseif(!is_numeric($data['valor'])){
            return ["STATUS" => "O formato do campo Valor está incorreto. (Não use vírgula)"];
        }
        else{
            if($this->produtoMapper->insertProduto($this->produto)){
                return ["STATUS" => "Registro cadastrado com sucesso"];
            }
        }
    }

    public function alterarProduto($data){
        $this->produto->setId($data['id']);
        $this->produto->setNome($data['nome']);
        $this->produto->setDescricao($data['descricao']);
        $this->produto->setValor($data['valor']);

        if(empty($data['nome']) or empty($data['descricao']) or empty($data['valor'])){
            return ["STATUS" => "Erro: Você deve informar todos os valores"];
        }elseif(!is_numeric($data['valor'])){
            return ["STATUS" => "O formato do campo Valor está incorreto. (Não use vírgula)"];
        }
        else{
            if($this->produtoMapper->updateProduto($this->produto)){
                return ["STATUS" => "Registro alterado com sucesso"];
            }
        }
    }

    public function deleteProduto($data)
    {
        $this->produto->setId($data);
        return $this->produtoMapper->deleteProduto($this->produto);
    }
}