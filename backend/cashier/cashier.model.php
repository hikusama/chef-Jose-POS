<?php
require_once "../../connection/dbh.php";


class cashier_model extends Connection{

    public function getAllProducts():array {
        $pdotemp = new Connection();
        $sql = "SELECT * FROM products";
        $pdo = $pdotemp->connect();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rows) {
            return $rows;
        }else{
            return null;
        }
        

    
    
    
    
    
    
    }



    public function itemsForAddToCart($prod_id):array {

        $pdotemp = new Connection();
        $sql = "SELECT * FROM products WHERE products.productId = ?";
        $pdo = $pdotemp->connect();
        $stmt = $pdo->prepare($sql);

        $stmt->execute([$prod_id]);

        $rows = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($rows) {
            return $rows;
        }else{
            return null;
        }
 
    }

}

