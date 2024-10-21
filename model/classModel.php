    <?php
    require_once "../Connection/dbh.php";

    class Model extends Connection
    {



        //------------------------- LOGIN-SIGNUP THINGS -----------------------------

        // GET USER
        public function getUser($username, $password)
        {
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






        //------------------------- PRODUCT THINGS -----------------------------


        // ADD PRODUCT
        public function insertProduct($product_name, $category_name, $price, $quantity, $product_image)
        {
            $stmt = $this->connect()->prepare("INSERT INTO products (name,category_id, price, quantityInStock, displayPic) VALUES (?, ?, ?, ?, ?);");
            if ($stmt->execute([$product_name, $category_name, $price, $quantity, $product_image])) {
                return true;
            } else {
                error_log("Error adding product: " . implode(", ", $stmt->errorInfo()));
            }
        }

        // ADD category

        public function insertCategory($Add_category)
        {
            $stmt = $this->connect()->prepare("INSERT INTO category (category_name) VALUES (?);");
            if ($stmt->execute([$Add_category])) {
                return true;
            } else {
                error_log("Error adding product: " . implode(", ", $stmt->errorInfo()));
            }
        }

        // EDIT PRODUCT 
        public function editProduct($product_name, $category_name, $price, $product_image, $quantity)
        {
            $stmt = $this->connect()->prepare("UPDATE products SET product_name= :name, category_name= :category, price= :price, displayPic= :displayPic, quantity= :quantity WHERE id = :id");
            $stmt->bindParam(':name', $product_name);
            $stmt->bindParam(':category', $category_name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':display_pic', $product_image);
            $stmt->bindParam(':quantity', $quantity);
        }

        //DELETE
        public function product_delete($product_id)
        {
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
        public function showProduct()
        {
            $sql = "SELECT * FROM products";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            $rows =  $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                return $rows;
            } else {
                return null;
            }
        }


        // SEARCH W VIEW
        public function searchNView($product_name)
        {
            if (!empty($product_name)) {
                $product_name = "%" . $product_name . "%";
            }

            $sql = "SELECT * FROM products INNER JOIN category ON category.category_id = products.category_id";

            if (!empty($product_name)) {
                $sql .= " AND products.name LIKE :product_name OR category.category_name LIKE :product_name GROUP BY category.category_id";
            } else {
                $sql .= " GROUP BY products.productID";
            }



            $stmt = $this->connect()->prepare($sql);

            if (!empty($product_name)) {
                // $stmt->bindParam(':product_name', $product_name);
                $stmt->execute([':product_name' => $product_name]);
            }

            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                return $rows;
            } else {
                return null;
            }
        }



        // SEARCH W VIEW - COMBO BY ID
        public function searchNViewForComboByID($productIDArr){

            $ids = implode(',',array_fill(0,count($productIDArr),'?'));
 
            $sql = "SELECT name,productID,displayPic,price FROM products where products.productID IN ($ids)";

            $stmt = $this->connect()->prepare($sql);

            $stmt->execute($productIDArr);

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                return $rows;
            } else {
                return null;
            }


        }
        // SEARCH W VIEW - COMBO
        public function searchNViewForCombo($product_name,$selected)
        {
            $selectedKeys = array_keys($selected);
            $selectedQuery = implode(',', array_map(function($key) {
                return ":id_$key";
            }, $selectedKeys));
        
            $sql = "SELECT * FROM products 
                    INNER JOIN category ON category.category_id = products.category_id 
                    WHERE products.productID NOT IN (SELECT productID FROM comboitems)";
        
            if (!empty($selected)) {
                $sql .= " AND products.productID NOT IN ($selectedQuery)";
            }
        
            if (!empty($product_name)) {
                $product_name = "%" . $product_name . "%";
                $sql .= " AND (products.name LIKE :product_name OR category.category_name LIKE :product_name)";
            }
        
            $sql .= " GROUP BY products.productID";
        
            $stmt = $this->connect()->prepare($sql);
        
            $params = [];
            if (!empty($product_name)) {
                $params[':product_name'] = $product_name;
            }
        
            if (!empty($selected)) {
                foreach ($selectedKeys as $key => $value) {
                    $params[":id_$key"] = $selected[$value];
                }
            }
        
            $stmt->execute($params);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            return $rows ?: null;
        }


 










        //------------------------- CASHIER THINGS -----------------------------

        public function getAllProductss($product_name, $category)
        {
            if (!empty($product_name)) {
                $product_name = "%" . $product_name . "%";
            }


            $sql = "SELECT * FROM products";


            if (!empty($category)) {
                $sql .= " INNER JOIN category ON category.category_id = products.category_id WHERE category.category_id = :category";
            }

            if (!empty($product_name)) {
                if (empty($category)) {
                    $sql .= " WHERE products.name LIKE :product_name GROUP BY products.productID";
                } else {
                    $sql .= " AND products.name LIKE :product_name GROUP BY products.productID";
                }
            }

            $pdo = $this->connect();
            $stmt = $pdo->prepare($sql);
            if (!empty($product_name)) {
                $stmt->bindParam(':product_name', $product_name);
            }
            if (!empty($category)) {
                $stmt->bindParam(':category', $category);
            }
            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                return $rows;
            } else {
                return null;
            }
        }



        public function getCategory()
        {
            $sql = "SELECT * FROM category";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            $rows =  $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                return $rows;
            } else {
                return null;
            }
        }



        public function itemsForAddToCart($prod_id): array
        {
            $sql = "SELECT * FROM products WHERE products.productId = ?";
            $pdo = $this->connect();
            $stmt = $pdo->prepare($sql);

            $stmt->execute([$prod_id]);

            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rows) {
                return $rows;
            } else {
                return null;
            }
        }


        public function insertOrders($orders)
        {

            $stmt = $this->connect()->prepare("INSERT INTO orderitems (productID,quantity,unitPrice,ref_no) 
            VALUES (?, ?, ?, ?)");

            $ngiao = 0;
            foreach ($orders as $order) {
                // $stmt->bindParam("iiii",);
                if ($stmt->execute([$order['product_id'], $order['qntity'], $order['price'], (int)$order['refNo']])) {
                } else {
                    $ngiao = $ngiao + 1;
                }
            }
            if ($ngiao > 0) {
                return false;
            } else {
                $this->insertSumOrders($orders[0]['totalAmount'], $orders[0]['discount'], $orders[0]['discountType'],$orders[0]['refNo'],$orders[0]['pmethod'],$orders[0]['gcashName'],$orders[0]['gcashNum']);
            }
        }

        public function insertSumOrders($totalAmount, $discount, $discountType,$refNo,$pmethod,$gcashName,$gcashNum)
        {
            

            $stmt = $this->connect()->prepare("INSERT INTO orders (totalAmount,discount,discountType,ref_no,paymentMethod,gcashAccountName,gcashAccountNo)
            VALUES (?, ?, ?, ?, ?, ?, ?)");



            if ($stmt->execute([$totalAmount, $discount, $discountType,$refNo,$pmethod,$gcashName,$gcashNum])) {
            } else {
                return false;
            }
        }


        function getOrderItemsLastId(): int
        {
            $sql = "SELECT orderID FROM orders ORDER BY orderID DESC LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                $sql2 = "TRUNCATE TABLE orders";
                $stmt2 = $this->connect()->prepare($sql2);
                $stmt2->execute();
                if ($stmt2->execute()) {
                    return 1;
                }
            } else {
                $row =  $stmt->fetch(PDO::FETCH_ASSOC);
                $num = intval($row['orderID']);
                return $num + 1;
            }
        }
    }
