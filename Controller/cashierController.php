<?php


require_once '../Model/classModel.php';


class cashierController extends Model{

    public function getAllProducts() {
        $rows = $this->getAllProductss(); 
        if ($rows) {
            return $rows;
        } else {
            return null;
        }
    }
    
    public function addToCart($prod_id):array{
        
        $rows = $this->itemsForAddToCart($prod_id);
        if ($rows) {
            return $rows;
        }else{
            return null;
        }
    }

}


