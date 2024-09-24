<?php


require_once "cashier.model.php";


class cashier_controller extends cashier_model{

    public function getAllProducts():array{
        $controller_pdo = new cashier_model();

        $rows = $controller_pdo->getAllProducts();

        if ($rows) {
            return $rows;
        }else{
            return null;
        }
        
        
    }
    


    public function addToCart($prod_id):array{
        $controller_pdo = new cashier_model();
        
        $rows = $controller_pdo->itemsForAddToCart($prod_id);
    
        if ($rows) {
            return $rows;
        }else{
            return null;
        }




    }


}


