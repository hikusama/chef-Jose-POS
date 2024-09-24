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
    public function insertProduct($product_name, $category_name, $price, $quantity, $product_image) {
        $stmt = $this->connect()->prepare("INSERT INTO products (name, category, price, quantityInStock, product_image) VALUES (?, ?, ?, ?, ?);");
        if ($stmt->execute([$product_name, $category_name, $price, $quantity, $product_image])) {
            echo "Product added successfully.";
        } else {
            error_log("Error adding product: " . implode(", ", $stmt->errorInfo()));
        }
    }

    // EDIT PRODUCT 
    public function editProduct($product_name, $category_name, $price, $product_image, $quantity){
        $stmt = $this->connect()->prepare("UPDATE products SET product_name= :name, category_name= :category, price= :price, product_image= :product_image, quantity= :quantity WHERE id = :id" );
        $stmt->bindParam(':name', $product_name);
        $stmt->bindParam(':category', $category_name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':display_pic', $product_image);
        $stmt->bindParam(':quantity', $quantity);

        }

    //DELETE
    public function product_delete($product_id) {
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(1, $product_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
                return true;
            }
        error_log("Error deleting product: " . implode(", ", $stmt->errorInfo())); // Log error
        return false; 
    }

    //GET PRODUCT
    public function showProduct() {
        $sql = "SELECT * FROM products";    
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $rows =  $stmt->fetchAll(); 

        if ($rows) {
            return $rows;
        }else{
            return null;
        }
    }
// new
    public function getAllProducts():array {
        $sql = "SELECT * FROM products";
        $pdo = $this->connect();
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
        $sql = "SELECT * FROM products WHERE products.productId = ?";
        $pdo = $this->connect();
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
        

        
