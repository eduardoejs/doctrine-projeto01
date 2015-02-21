<?php

namespace EJS\Produtos\Mapper;

use EJS\Produtos\Entity\Produto;
use Doctrine\ORM\EntityManager;

class ProdutoMapper {

    private $em;
    private $produto;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function listProdutos()
    {
        try{
            $repository = $this->em->getRepository("EJS\Produtos\Entity\Produto");
            $result = $repository->findAll();

            return $result;
        } catch (PDOException $e) {
            echo "Erro: ";
            die("{$e->getMessage()}");
        }
    }

    public function listProdutoById($id){
        try{
            $repository = $this->em->getRepository("EJS\Produtos\Entity\Produto");
            $result = $repository->find($id);
            return $result;
        } catch (PDOException $e) {
            echo "Erro: ";
            die("{$e->getMessage()}");
        }
    }

    public function insertProduto(Produto $produto){
        try{
            $this->em->persist($produto);
            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            echo "Erro: ";
            die("{$e->getMessage()}");
        }
    }

    public function updateProduto(Produto $produto){

        try{
            $entity = $this->em->getReference(get_class($produto), $produto->getId());

            $entity->setId($produto->getId());
            $entity->setNome($produto->getNome());
            $entity->setDescricao($produto->getDescricao());
            $entity->setValor($produto->getValor());

            $this->em->persist($entity);
            $this->em->flush();

            return $entity;
        } catch (PDOException $e) {
            echo "Erro: ";
            die("{$e->getMessage()}");
        }
    }

    public function deleteProduto(Produto $produto){


        //$produto = $this->em->find('EJS\Produtos\Entity\Produto', $produto->getId());
        try{

            $produto = $this->em->getReference("EJS\Produtos\Entity\Produto", $produto->getId());
            $this->em->remove($produto);
            $this->em->flush();
            return true;

        } catch (PDOException $e) {
            echo "Erro: ";
            die("{$e->getMessage()}");
        }

    }
} 