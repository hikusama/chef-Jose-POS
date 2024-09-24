<?php
require_once '../model/classModel.php';

class ProductController extends Model {
    private $product_name;
    private $category_name;
    private $price;
    private $product_image;
    private $quantity;
    public $product_id;


public function __construct( $product_id=null, $product_name, $category_name, $price,  $product_image, $quantity) {
    $this->product_name = $product_name;
    $this->category_name = $category_name;
    $this->price = $price;
    $this->product_image = $product_image;
    $this->quantity = $quantity;

}

    public function addProducts() {
        $this->insertProduct($this->product_name, $this->category_name, $this->price, $this->product_image, $this->quantity);
    }

    public function updateProducts() {
        $this->editProduct($this->product_name, $this->category_name, $this->price, $this->product_image, $this->quantity);
    }

    public function deleteProducts() {
       return $this->product_delete($this->product_id);
    }

    public function showProducts() {
        return $this->showProduct();
    }
}