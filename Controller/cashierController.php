<?php


require_once '../model/classModel.php';


class cashierController extends Model
{

    private $orders;
    private $product_name;
    private $product_id;

    public function __construct($orders, $product_name, $product_id)
    {
        $this->orders = $orders;
        $this->product_name = $product_name;
        $this->product_id = $product_id;
    }

    public function getAllProducts($category)
    {
        return $this->getAllProductss($this->product_name, $category);
    }
    public function getAllComboss()
    {
        return $this->getAllCombosModel($this->product_name);
    }

    public function addToCart()
    {

        return $this->itemsForAddToCart($this->product_id);
    }

    public function getRefNo():int {
        return $this->getOrderItemsLastId();
    }
    public function submitOrders()
    {
        $this->insertOrders($this->orders);
    }



    public function getAllCategory()
    {
        return $this->getCategory();
    }
}
