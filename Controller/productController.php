<?php
require_once '../Model/classModel.php';

class ProductController extends Model
{
    private $product_name;
    private $category_name;
    private $price;
    private $product_image;
    private $availability;
    public $product_id;
    private $Add_category;


    public function __construct($product_id, $product_name, $category_name, $price,  $product_image, $availability, $Add_category)
    {
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->category_name = $category_name;
        $this->price = $price;
        $this->product_image = $product_image;
        $this->availability = $availability;
        $this->Add_category = $Add_category;
    }

    public function addProducts()
    {
        $this->insertProduct($this->product_name, $this->category_name, $this->price, $this->product_image, $this->availability);
    }
    public function addCategory()
    {
        $this->insertCategory($this->Add_category);
    }

    // public function updateProducts()
    // {
    //     $this->editProduct($this->product_name, $this->category_name, $this->price, $this->product_image, $this->availability);
    // }

    public function getCat()
    {
        return $this->getCategory();
    }

    public function getProdSearch($selected_page)
    {
        return $this->searchNView($this->product_name,$selected_page);
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

    public function is_empty_inputs($product_name, $category_name, $price, $availability)
    {

        if (
            empty($product_name) ||
            empty($category_name) ||
            empty($price) ||
            empty($availability)
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
    
    
    public function insertCombo($combos,$cimg, $cn, $ccd, $cpr,$av)
    {
        return $this->addCombo($combos, $cimg, $cn, $ccd, $cpr,$av);
    }


    public function findCatGt($categoryName,$page)
    {
        return $this->findCategory($categoryName,$page);
    }


    public function findComboGt($comboName,$page)
    {
        return $this->findCombo($comboName,$page);
    }
    
    public function delete_things($ID,$state){
        if ($state === 1) {
            return $this->product_delete($ID);
            
        }else if($state === 2){
            return $this->category_delete($ID);

        }else if($state === 3){
            return $this->combo_delete($ID);
        }
    }


}
