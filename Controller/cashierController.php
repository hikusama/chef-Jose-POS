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

    public function getAllProducts($category,$page)
    {
        return $this->getAllProductss($this->product_name, $category,$page);
    }
    public function getAllComboss($page)
    {
        return $this->getAllCombosModel($this->product_name,$page);
    }

    public function addToCart($type)
    {

        return $this->itemsForAddToCart($this->product_id,$type);
    }

    public function getRefNo():int {
        return $this->getOrderItemsLastId();
    }
    public function submitOrdersController($comboOrder)
    {
        $this->insertOrders($this->orders,$comboOrder);
    }



    public function getAllCategory()
    {
        return $this->getCategory();
    }
}
