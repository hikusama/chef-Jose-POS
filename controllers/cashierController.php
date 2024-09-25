<?php


require_once '../model/classModel.php';


class cashierController extends Model{

    public function getAllProducts(): array {
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


