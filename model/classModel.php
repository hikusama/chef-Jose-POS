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
        public function product_delete($ID)
        {
            $sql = "DELETE FROM products WHERE productID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $ID, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            }
            error_log("Error deleting product: " . implode(", ", $stmt->errorInfo())); // Log error
            return false;
        }

        public function combo_delete($combo_id)
        {
            $sql = "DELETE FROM combo WHERE comboID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $combo_id, PDO::PARAM_INT);

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


        public function searchNView($product_name, $page = 1)
        {
            $max_page_per_req = 10;

            $offset = ($page - 1) * $max_page_per_req;

            if (!empty($product_name)) {
                $product_name = "%" . $product_name . "%";
            }

            $sql = "SELECT * FROM products INNER JOIN category ON category.category_id = products.category_id";

            if (!empty($product_name)) {
                $sql .= " AND products.name LIKE :product_name OR category.category_name LIKE :product_name";
            }
            $sql .= " GROUP BY products.productID LIMIT :limit OFFSET :offset";


            $stmt = $this->connect()->prepare($sql);

            if (!empty($product_name)) {
                // $stmt->bindParam(':product_name', $product_name);
                $stmt->bindParam(':product_name', $product_name);
            }
            $stmt->bindParam(':limit', $max_page_per_req, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);


            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);




            $sql2Q = "SELECT COUNT(products.productID) AS total_rows FROM products";

            if (!empty($product_name)) {
                $sql2Q .= " INNER JOIN category ON category.category_id = products.category_id where products.name LIKE :product_name OR category.category_name LIKE :product_name";
            }
            $sql2 = $this->connect()->prepare($sql2Q);

            if (!empty($product_name)) {
                $sql2->bindParam(':product_name', $product_name);
            }

            $sql2->execute();

            $rows2 = $sql2->fetch(PDO::FETCH_ASSOC);
            $total_rows = ($rows2) ? (int)$rows2['total_rows'] : 0;



            $total_pages = ceil($total_rows / $max_page_per_req);


            if ($rows) {
                return [
                    'data' => $rows,
                    'total_pages' => $total_pages,
                    'current_page' => $page
                ];
            } else {
                return [
                    'data' => null,
                    'total_pages' => null,
                    'current_page' => null
                ];
            }
        }


        // SEARCH W VIEW - COMBO BY ID
        public function searchNViewForComboByID($productIDArr)
        {

            $ids = implode(',', array_fill(0, count($productIDArr), '?'));

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
        public function searchNViewForCombo($product_name, $selected)
        {
            $selectedKeys = array_keys($selected);
            $selectedQuery = implode(',', array_map(function ($key) {
                return ":id_$key";
            }, $selectedKeys));

            $sql = "SELECT * FROM products 
                    INNER JOIN category ON category.category_id = products.category_id";


            if (!empty($selected)) {
                $sql .= " WHERE products.productID NOT IN ($selectedQuery)";
                if (!empty($product_name)) {
                    $sql .= " AND";
                }
            } else if (!empty($product_name)) {
                $sql .= " WHERE";
            }

            if (!empty($product_name)) {
                $product_name = "%" . $product_name . "%";
                $sql .= " (products.name LIKE :product_name OR category.category_name LIKE :product_name)";
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


        // INSERT COMBO
        public function addCombo($combos, $comboIMG, $comboName, $comboCode, $comboPrice)
        {
            $sql = "INSERT INTO combo(displayPic,comboName,comboCode,comboPrice) values(?, ?, ?, ?)";

            $stmt = $this->connect()->prepare($sql);

            if ($stmt->execute([$comboIMG, $comboName, $comboCode, $comboPrice])) {
                $comboID = $this->getComboID();
                if ($this->comboItems($combos, $comboID)) {
                    return true;
                } else {
                    error_log("Error adding comboItems: " . implode(", ", $stmt->errorInfo()));
                }
            } else {
                error_log("Error adding combo: " . implode(", ", $stmt->errorInfo()));
            }
        }


        public function comboItems($combos, $comboID)
        {
            $sql = "INSERT INTO comboitems(comboID,productID) values(?, ?)";

            $stmt = $this->connect()->prepare($sql);


            $errorCount = 0;
            foreach ($combos as $c) {

                if ($stmt->execute([$comboID, $c])) {
                } else {
                    $errorCount += 1;
                }
            }

            return ($errorCount > 0) ? true : false;
        }


        // CHECKING EXISTENSE   
        public function checkComboName($check)
        {
            $sql = "SELECT comboName FROM combo where comboName = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$check]);
            $row =  $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ?: null;
        }

        public function checkComboCode($check)
        {
            $sql = "SELECT comboCode FROM combo where comboCode = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$check]);
            $row =  $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ?: null;
        }

        public function getComboID()
        {
            $sql = "SELECT comboID FROM combo ORDER BY comboID DESC LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            $row =  $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['comboID'] ?: null;
        }

        // SEARCH COMBO   
        public function findCombo($comboName, $page = 1)
        {

            $max_page_per_req = 10;

            $offset = ($page - 1) * $max_page_per_req;

            $sql = "SELECT combo.*,COUNT(comboitems.comboID) AS total_comboID FROM combo left join comboitems on combo.comboID = comboitems.comboID";

            if (!empty($comboName)) {
                $sql .= " WHERE combo.comboName LIKE :comboName OR combo.comboCode LIKE :comboName";
            }

            $sql .= " GROUP BY combo.comboID LIMIT :limit OFFSET :offset";

            $stmt = $this->connect()->prepare($sql);


            if (!empty($comboName)) {
                $comboName = "%" . $comboName . "%";
                $stmt->bindParam(":comboName", $comboName);
            }
            $stmt->bindParam(':limit', $max_page_per_req, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


            $sql2 = "SELECT COUNT(comboitems.comboID) AS total_rows FROM comboitems";

            if (!empty($comboName)) {
                $sql2 .= " right join combo on combo.comboID = comboitems.comboID WHERE combo.comboName LIKE :comboName OR combo.comboCode LIKE :comboName";
            }

            $stmt2 = $this->connect()->prepare($sql2);

            if (!empty($comboName)) {
                $comboName = "%" . $comboName . "%";
                $stmt->bindParam(":comboName", $comboName);
            }

            $stmt2->execute();

            $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $total_rows = ($rows2) ? (int)$rows2['total_rows'] : 0;


            $total_pages = ceil($total_rows / $max_page_per_req);


            if ($rows) {
                return [
                    'data' => $rows,
                    'total_pages' => $total_pages,
                    'current_page' => $page
                ];
            } else {
                return [
                    'data' => null,
                    'total_pages' => null,
                    'current_page' => null
                ];
            }


            error_log("Error adding combo: " . implode(", ", $stmt->errorInfo()));
        }












        //------------------------- HISTORY THINGS -----------------------------



        public function getOrderRecord($ref)
        {


            $sql = "SELECT ord.*, oi.*, pr.name,c.comboName FROM orders as ord
            left join orderitems as oi on ord.ref_no = oi.ref_no
            left join products as pr on oi.productID = pr.productID
            left join comboitems as ci on pr.productID = ci.productID
            left join combo as c on oi.comboID = c.comboID
            where ord.ref_no = :ref";

            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':ref', $ref);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


            if ($rows) {
                return $rows;
            } else {
                return null;
            }
        }


        public function getOrders($ref, $date, $page)
        {

            $max_page_per_req = 15;

            $offset = ($page - 1) * $max_page_per_req;


            $sql = "SELECT orderID,totalAmount,ref_no,orderDate,orderTime FROM orders";

            $sqlTemp = "";

            if (!empty($ref)) {
                $ref = "%" . $ref . "%";

                if (!empty($date)) {
                    $sql .= " WHERE ref_no LIKE :ref and ";
                    $sql .= $date;
                    $sqlTemp = " WHERE ref_no LIKE :ref and ";
                    $sqlTemp .= $date;
                } else {
                    $sql .= " WHERE ref_no LIKE :ref";
                    $sqlTemp = " WHERE ref_no LIKE :ref";
                }
            } else if (!empty($date)) {
                $sql .= " WHERE ";
                $sql .= $date;
                $sqlTemp .= " WHERE ";
                $sqlTemp .= $date;
            }
            $sql .= " GROUP BY orderID LIMIT :limit OFFSET :offset";

            $stmt = $this->connect()->prepare($sql);
            if (!empty($ref)) {
                $stmt->bindParam(':ref', $ref);
            }
            $stmt->bindParam(':limit', $max_page_per_req, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);


            // if (!empty($date)) {
            //     $stmt->bindParam(':date', $date);
            // }

            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);




            $sql2 = "SELECT COUNT(orders.orderID) AS total_rows FROM orders";


            if (!empty($ref) || !empty($date)) {
                $sql2 .= $sqlTemp;
            }

            $stmt2 = $this->connect()->prepare($sql2);

            if (!empty($ref)) {
                $stmt2->bindParam(':ref', $ref);
            }

            $stmt2->execute();

            $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $total_rows = ($rows2) ? (int)$rows2['total_rows'] : 0;


            $total_pages = ceil($total_rows / $max_page_per_req);


            if ($rows) {
                return [
                    'data' => $rows,
                    'total_pages' => $total_pages,
                    'current_page' => $page
                ];
            } else {
                return [
                    'data' => null,
                    'total_pages' => null,
                    'current_page' => null
                ];
            }


            error_log("Error adding combo: " . implode(", ", $stmt->errorInfo()));
        }


























        //------------------------- CASHIER THINGS -----------------------------

        public function getAllCombosModel($comboName)
        {
            if (!empty($comboName)) {
                $comboName = "%" . $comboName . "%";
            }


            $sql = "SELECT * FROM combo";


            if (!empty($comboName)) {
                $sql .= " WHERE combo.comboName LIKE :comboName GROUP BY combo.comboID";
            }

            $stmt = $this->connect()->prepare($sql);
            if (!empty($comboName)) {
                $stmt->bindParam(':comboName', $comboName);
            }

            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                return $rows;
            } else {
                return null;
            }
        }


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


        public function itemsForAddToCart($prod_id, $type): array
        {
            $sql = "";
            if ($type == "prd") {
                $sql = "SELECT * FROM products WHERE productId = ?";
            } else if ($type == "cmb") {
                $sql = "SELECT * FROM combo WHERE comboId = ?";
            } else {
                echo "Something went wrong...";
                return null;
            }
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


        public function insertOrders($prodOrders, $comboOrder)
        {
            $orders = array_merge($prodOrders, $comboOrder);

            $stmt = $this->connect()->prepare("INSERT INTO orderitems (productID,itemType,quantity,unitPrice,ref_no) 
            VALUES (?, ?, ?, ?, ?)");
            $stmt2 = $this->connect()->prepare("INSERT INTO orderitems (comboID,itemType,quantity,unitPrice,ref_no) 
            VALUES (?, ?, ?, ?, ?)");

            $stmtF = $this->connect()->prepare("INSERT INTO orders (totalAmount,discount,discountType,ref_no,paymentMethod,gcashAccountName,gcashAccountNo,subtotal)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");



            if ($stmtF->execute([$orders[0]['totalAmount'], $orders[0]['discount'], $orders[0]['discountType'], $orders[0]['refNo'], $orders[0]['pmethod'], $orders[0]['gcashName'], $orders[0]['gcashNum'],$orders[0]['subtotal']])) {
            } else {
                return false;
            }
            $ngiao = 0;
            if ($prodOrders) {
                foreach ($prodOrders as $prd) {
                    // $stmt->bindParam("iiii",);
                    if (
                        ($stmt->execute([$prd['product_id'], "product", $prd['qntity'], $prd['price'], (int)$prd['refNo']]))
                    ) {
                    } else {
                        $ngiao = $ngiao + 1;
                    }
                }
            }
            if ($ngiao > 0) {
                return false;
            }
            if ($comboOrder) {
                foreach ($comboOrder as $cmb) {
                    // $stmt->bindParam("iiii",);
                    if (
                        ($stmt2->execute([$cmb['combo_id'], "combo", $cmb['qntity'], $cmb['price'], (int)$cmb['refNo']]))
                    ) {
                    } else {
                        $ngiao = $ngiao + 1;
                    }
                }
            }


            if ($ngiao > 0) {
                return false;
            }
        }


        function getOrderItemsLastId(): int
        {
            $sql = "SELECT orderID FROM orders ORDER BY orderID DESC LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                $F1 = $this->connect()->prepare(
                    "DELETE FROM comboitems;
                ALTER TABLE chef_jose_db.orderitems DROP FOREIGN KEY ref_bfk_2;
                TRUNCATE TABLE orders;
                ALTER TABLE `orderitems` ADD CONSTRAINT `ref_bfk_2` FOREIGN KEY (`ref_no`) REFERENCES `orders`(`ref_no`) ON DELETE CASCADE ON UPDATE RESTRICT"
                );
                if ($F1->execute()) {
                    return 1;
                }
            } else {
                $row =  $stmt->fetch(PDO::FETCH_ASSOC);
                $num = intval($row['orderID']);
                return $num + 1;
            }
        }

        public function isCategoryExist($cat)
        {
            $stmt = $this->connect()->prepare("SELECT category_name FROM category where category_name = ?");
            $stmt->execute([$cat]);
            $rows =  $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rows) {
                return true;
            } else {
                return false;
            }
        }
    }
