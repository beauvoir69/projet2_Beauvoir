<?php

class Product extends Crud
{
    public function __construct($host, $db, $user, $password)
    {
        parent::__construct($host, $db, $user, $password);
    }

    public function getAllProducts()
    {
        return $this->getAll("product");
    }

    public function getProductById($productId)
    {
        return $this->getById("product", $productId);
    }

    public function addProduct($productData)
    {
        return $this->add("product", $productData);
    }

    public function updateProductById($productId, $productData)
    {
        $this->updateById("product", $productId, $productData);
    }

    public function deleteProductById($productId)
    {
        return $this->delete("product", $productId);
    }
}