<?php
require_once '../Model/classModel.php';

class ProductController extends Model
{
    private $product_name;
    private $category_name;
    private $price;
    private $product_image;
    private $quantity;
    public $product_id;
    public $Add_category;


    public function __construct($product_id, $product_name, $category_name, $price,  $product_image, $quantity, $Add_category)
    {
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->category_name = $category_name;
        $this->price = $price;
        $this->product_image = $product_image;
        $this->quantity = $quantity;
        $this->Add_category = $Add_category;
    }

    public function addProducts()
    {
        $this->insertProduct($this->product_name, $this->category_name, $this->price, $this->product_image, $this->quantity);
    }
    public function addCategory()
    {
        $this->insertCategory($this->Add_category);
    }

    public function updateProducts()
    {
        $this->editProduct($this->product_name, $this->category_name, $this->price, $this->product_image, $this->quantity);
    }

    public function deleteProducts()
    {
        return $this->product_delete($this->product_id);
    }

    public function getCat()
    {
        return $this->getCategory();
    }

    public function getProdSearch()
    {
        return $this->searchNView($this->product_name);
    }

    public function getProdSearchComboByID()
    {
        return $this->searchNViewForComboByID($this->product_name);
    }

    public function getProdSearchCombo($selected)
    {
        return $this->searchNViewForCombo($this->product_name, $selected);
    }

    public function showProducts()
    {
        return $this->showProduct();
    }

    public function is_empty_inputs($product_name, $category_name, $price, $quantity)
    {

        if (
            empty($product_name) ||
            empty($category_name) ||
            empty($price) ||
            empty($quantity)
        ) {
            return true;
        } else {
            return false;
        }
    }


    public function checkCombo($check, $type)
    {
        if ($type == "comboName") {
            return $this->checkComboName($check);
        } else if ($type == "comboCode") {
            return $this->checkComboCode($check);
        }
    }
    
    
    public function insertCombo($combos,$cimg, $cn, $ccd, $cpr)
    {
        return $this->addCombo($combos, $cimg, $cn, $ccd, $cpr);
    }


    public function findComboGt($comboName)
    {
        return $this->findCombo($comboName);
    }


}
