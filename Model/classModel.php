<?php
require_once "../Connection/dbh.php";

class Model extends Connection {

    // GET USER
public function getUser($username, $password) {
    $stmt = $this->connect()->prepare('SELECT * FROM user WHERE userName = ?;');
    
    if (!$stmt->execute(array($username))) {
        $stmt = null;
        header("Location: /?error=stmtfailed");
        exit();
    }

    if ($stmt->rowCount() == 0) {
        $stmt = null;
        header("Location: /?error=usernotfound");
        exit();
    }

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;

    if (!password_verify($password, $user['password'])) {
        header("Location: /?error=wrongpassword");
        exit();
    }

    session_start();
    $_SESSION["userName"] = $user["userName"];
    
    $stmt = null;
}

// ADD PRODUCT
public function insertProduct($product_name, $category_name, $price, $display_pic, $quantity) {
    $stmt = $this->connect()->prepare("INSERT INTO products (name, category, price, displayPic, quantityInStock) VALUES (?, ?, ?, ?, ?);");
    if ($stmt->execute([$product_name, $category_name, $price, $display_pic, $quantity])) {
        echo "Product added successfully.";
    } else {
        echo "Error adding product: " . implode(", ", $stmt->errorInfo());
    }
}

// EDIT PRODUCT 
public function editProduct($product_name, $category_name, $price, $display_pic, $quantity){
    $stmt = $this->connect()->prepare("UPDATE products SET product_name= :name, category_name= :category, price= :price, display_pic= :displayPic, quantity= :quantity WHERE id = :id" );
    $stmt->bindParam(':name', $product_name);
    $stmt->bindParam(':category', $category_name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':display_pic', $display_pic);
    $stmt->bindParam(':quantity', $quantity);

    }



 }


    

    
