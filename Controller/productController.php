<?php
require_once '../Model/classModel.php';

class ProductController extends Model {
    private $product_name;
    private $category_name;
    private $price;
    private $display_pic;
    private $quantity;


    public function __construct( $product_name, $category_name, $price, $display_pic, $quantity) {
        $this->product_name = $product_name;
        $this->category_name = $category_name;
        $this->price = $price;
        $this->display_pic = $display_pic;
        $this->quantity = $quantity;
    
    }

    public function addProduct($product_name, $category_name, $price, $display_pic, $quantity) {
        $this->insertProduct($this->product_name, $this->category_name, $this->price, $this->display_pic, $this->quantity);
    }
}