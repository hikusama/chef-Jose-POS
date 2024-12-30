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
                header("Location: ../index.php?error=stmtfailed");
                exit();
            }

            if ($stmt->rowCount() == 0) {
                $stmt = null;
                header("Location: ../index.php?error=usernotfound");
                exit();
            }

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = null;

            if (!password_verify($password, $user['password'])) {
                header("Location: ../index.php?error=wrongpassword");
                exit();
            }

            session_start();
            $_SESSION["userName"] = $user["userName"];
            $_SESSION["userID"] = $user["userID"];
            $_SESSION["userRole"] = $user["userRole"];

            $stmt = null;
            return $user["userRole"];
        }









        //------------------------- OVERVIEW THINGS -----------------------------



        public function countOrders()
        {
            $sql = "SELECT 
        (SELECT COUNT(*) FROM orders WHERE DATE(orderDate) = CURDATE()) AS today,
        (SELECT COUNT(*) FROM orders WHERE DATE(orderDate) = CURDATE() - INTERVAL 1 DAY) AS lastday,
        (SELECT COUNT(*) FROM orders WHERE YEARWEEK(orderDate,1) = YEARWEEK(CURDATE(),1)) AS thisweek,
        (SELECT COUNT(*) FROM orders WHERE YEARWEEK(orderDate,1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK,1)) AS lastweek,
        (SELECT COUNT(*) FROM orders) as total
        ";
            $stmt = $this->connect()->prepare($sql);
            if ($stmt->execute()) {
                $rws = $stmt->fetch(PDO::FETCH_ASSOC);
                return $rws;
            }
            return null;
        }





        public function graphData()
        {
            $sql = "SELECT 
                    SUM(CASE WHEN MONTH(orderDate) = 1 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS janT,
                    SUM(CASE WHEN MONTH(orderDate) = 2 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS febT,
                    SUM(CASE WHEN MONTH(orderDate) = 3 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS marT,
                    SUM(CASE WHEN MONTH(orderDate) = 4 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS aprT,
                    SUM(CASE WHEN MONTH(orderDate) = 5 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS mayT,
                    SUM(CASE WHEN MONTH(orderDate) = 6 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS juneT,
                    SUM(CASE WHEN MONTH(orderDate) = 7 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS julT,
                    SUM(CASE WHEN MONTH(orderDate) = 8 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS augT,
                    SUM(CASE WHEN MONTH(orderDate) = 9 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS septT,
                    SUM(CASE WHEN MONTH(orderDate) = 10 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS octT,
                    SUM(CASE WHEN MONTH(orderDate) = 11 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS novT,
                    SUM(CASE WHEN MONTH(orderDate) = 12 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS decT,

                    SUM(CASE WHEN MONTH(orderDate) = 1 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) - 1 THEN totalAmount ELSE 0 END) AS janL,
                    SUM(CASE WHEN MONTH(orderDate) = 2 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) - 1 THEN totalAmount ELSE 0 END) AS febL,
                    SUM(CASE WHEN MONTH(orderDate) = 3 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) - 1 THEN totalAmount ELSE 0 END) AS marL,
                    SUM(CASE WHEN MONTH(orderDate) = 4 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) - 1 THEN totalAmount ELSE 0 END) AS aprL,
                    SUM(CASE WHEN MONTH(orderDate) = 5 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) - 1 THEN totalAmount ELSE 0 END) AS mayL,
                    SUM(CASE WHEN MONTH(orderDate) = 6 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) - 1 THEN totalAmount ELSE 0 END) AS juneL,
                    SUM(CASE WHEN MONTH(orderDate) = 7 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) - 1 THEN totalAmount ELSE 0 END) AS julL,
                    SUM(CASE WHEN MONTH(orderDate) = 8 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) - 1 THEN totalAmount ELSE 0 END) AS augL,
                    SUM(CASE WHEN MONTH(orderDate) = 9 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) - 1 THEN totalAmount ELSE 0 END) AS septL,
                    SUM(CASE WHEN MONTH(orderDate) = 10 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) - 1 THEN totalAmount ELSE 0 END) AS octL,
                    SUM(CASE WHEN MONTH(orderDate) = 11 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) - 1 THEN totalAmount ELSE 0 END) AS novL,
                    SUM(CASE WHEN MONTH(orderDate) = 12 AND YEAR(orderDate) = YEAR(CURRENT_DATE()) - 1 THEN totalAmount ELSE 0 END) AS decL
                    FROM orders";
            $stmt = $this->connect()->prepare($sql);
            if ($stmt->execute()) {
                $rws = $stmt->fetch(PDO::FETCH_ASSOC);
                return $rws;
            }
            return null;
        }





        public function pieData()
        {
            $sql = "SELECT 
            SUM(CASE WHEN orderDate = CURRENT_DATE THEN totalAmount ELSE 0 END) AS today_total,
            SUM(CASE WHEN orderDate = CURRENT_DATE - INTERVAL 1 DAY THEN totalAmount ELSE 0 END) AS yesterday_total,
            SUM(CASE WHEN YEARWEEK(orderDate,1) = YEARWEEK(CURRENT_DATE,1) THEN totalAmount ELSE 0 END) AS thisweek,
            SUM(CASE WHEN YEARWEEK(orderDate,1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK,1) THEN totalAmount ELSE 0 END) AS lastweek 
            FROM orders";
            $stmt = $this->connect()->prepare($sql);
            if ($stmt->execute()) {
                $rws = $stmt->fetch(PDO::FETCH_ASSOC);
                return $rws;
            }
            return null;
        }


        public function salesPackData()
        {
            $sql = "SELECT 
            SUM(totalAmount) AS total,
            SUM(CASE WHEN orderDate = CURRENT_DATE THEN totalAmount ELSE 0 END) AS today_total,
            SUM(CASE WHEN MONTH(orderDate) = MONTH(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS thismonth
            FROM orders";
            $stmt = $this->connect()->prepare($sql);
            if ($stmt->execute()) {
                $rws = $stmt->fetch(PDO::FETCH_ASSOC);
                return $rws;
            }
            return null;
        }

        public function discountData()
        {
            $sql = "SELECT 
            SUM(discount) AS total,
            SUM(CASE WHEN orderDate = CURRENT_DATE THEN discount ELSE 0 END) AS today_total,
            SUM(CASE WHEN MONTH(orderDate) = MONTH(CURRENT_DATE()) THEN discount ELSE 0 END) AS thismonth
            FROM orders";
            $stmt = $this->connect()->prepare($sql);
            if ($stmt->execute()) {
                $rws = $stmt->fetch(PDO::FETCH_ASSOC);
                return $rws;
            }
            return null;
        }

        public function topProd()
        {
            $sql = "SELECT 
                prd.displayPic,
                prd.name,
                SUM(ord.quantity)  AS total_order FROM products AS prd 
                LEFT JOIN orderitems AS ord ON ord.productID = prd.productID GROUP BY prd.productID
                ORDER BY total_order DESC LIMIT 10 OFFSET 0";
            $stmt = $this->connect()->prepare($sql);
            if ($stmt->execute()) {
                $rws = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $rws;
            }
            return null;
        }







        //------------------------- REPORTS THINGS -----------------------------

        /*               today data                 */
        public function getSquaredData()
        {

            $sql = "SELECT 
                                SUM(CASE WHEN DATE(orderDate) = CURRENT_DATE THEN discount ELSE 0 END) AS today_discount,
                                SUM(CASE WHEN DATE(orderDate) = CURRENT_DATE THEN 1 ELSE 0 END) AS today_orders,
                                SUM(CASE WHEN DATE(orderDate) = CURRENT_DATE THEN totalAmount ELSE 0 END) AS today_sales,
        
                                SUM(CASE WHEN DATE(orderDate) = CURRENT_DATE - INTERVAL 1 DAY THEN discount ELSE 0 END) AS Ltoday_discount,
                                SUM(CASE WHEN DATE(orderDate) = CURRENT_DATE - INTERVAL 1 DAY THEN 1 ELSE 0 END) AS Ltoday_orders,
                                SUM(CASE WHEN DATE(orderDate) = CURRENT_DATE - INTERVAL 1 DAY THEN totalAmount ELSE 0 END) AS Ltoday_sales,
        
                            -- current things
                                SUM(CASE WHEN MONTH(orderDate) = MONTH(CURRENT_DATE()) THEN totalAmount ELSE 0 END) AS salesmonth,
                                SUM(CASE WHEN MONTH(orderDate) = MONTH(CURRENT_DATE()) THEN discount ELSE 0 END) AS discountmonth,
                                SUM(CASE WHEN MONTH(orderDate) = MONTH(CURRENT_DATE()) THEN 1 ELSE 0 END) AS ordersmonth,

                                SUM(CASE WHEN YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN totalAmount ELSE 0 END) AS salesweek,  
                                SUM(CASE WHEN YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN discount ELSE 0 END) AS discountweek,  
                                SUM(CASE WHEN YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS ordersweek,  

                            -- last things
                                SUM(CASE WHEN MONTH(orderDate) = MONTH(CURRENT_DATE()) - 1 THEN totalAmount ELSE 0 END) AS Lsalesmonth,
                                SUM(CASE WHEN MONTH(orderDate) = MONTH(CURRENT_DATE()) - 1 THEN discount ELSE 0 END) AS Ldiscountmonth,
                                SUM(CASE WHEN MONTH(orderDate) = MONTH(CURRENT_DATE()) - 1 THEN 1 ELSE 0 END) AS Lordersmonth,

                                SUM(CASE WHEN YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS Lsalesweek,  
                                SUM(CASE WHEN YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS Ldiscountweek,  
                                SUM(CASE WHEN YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS Lordersweek,  


                                SUM(CASE WHEN paymentMethod = 'G-Cash' AND DATE(orderDate) = CURRENT_DATE THEN 1 ELSE 0 END) AS gcash_count,
                                SUM(CASE WHEN paymentMethod = 'Cash' AND DATE(orderDate) = CURRENT_DATE THEN 1 ELSE 0 END) AS cash_count
                            FROM orders;";
            $stmt = $this->connect()->prepare($sql);
            if ($stmt->execute()) {
                $rw = $stmt->fetch(PDO::FETCH_ASSOC);
                return $rw;
            }
            return null;
        }


        public function todayCatData()
        {

            $sql = "SELECT 
                        c.category_name,
                        SUM(CASE WHEN DATE(o.orderDate) = CURRENT_DATE THEN 1 ELSE 0 END) AS total_sold_today
                    FROM 
                        category c
                    LEFT JOIN 
                        products p ON c.category_id = p.category_id
                    LEFT JOIN 
                        orderitems oi ON p.productID = oi.productID
                    LEFT JOIN 
                        orders o ON oi.ref_no = o.ref_no
                    GROUP BY 
                        c.category_id, c.category_name
                    ORDER BY 
                        total_sold_today DESC;
                    ";
            $stmt = $this->connect()->prepare($sql);
            if ($stmt->execute()) {
                $rws = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $rws;
            }
            return null;
        }



        public function weekDataTSec()
        {

            $sql = "SELECT 
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 2 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS tmonOrders,  
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 2 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN totalAmount ELSE 0 END) AS tmonSales,
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 2 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN discount ELSE 0 END) AS tmonDiscount,

                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 3 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS ttueOrders,  
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 3 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN totalAmount ELSE 0 END) AS ttueSales,
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 3 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN discount ELSE 0 END) AS ttueDiscount,

                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 4 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS twedOrders,  
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 4 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN totalAmount ELSE 0 END) AS twedSales,
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 4 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN discount ELSE 0 END) AS twedDiscount,

                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 5 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS tthuOrders,  
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 5 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN totalAmount ELSE 0 END) AS tthuSales,
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 5 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN discount ELSE 0 END) AS tthuDiscount,

                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 6 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS tfriOrders,  
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 6 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN totalAmount ELSE 0 END) AS tfriSales,
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 6 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN discount ELSE 0 END) AS tfriDiscount,

                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 7 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS tsatOrders,  
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 7 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN totalAmount ELSE 0 END) AS tsatSales,
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 7 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN discount ELSE 0 END) AS tsatDiscount,

                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 1 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS tsunOrders,  
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 1 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN totalAmount ELSE 0 END) AS tsunSales,
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 1 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURDATE(), 1) THEN discount ELSE 0 END) AS tsunDiscount,



                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 2 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS tlmonOrders,  
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 2 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN totalAmount ELSE 0 END) AS tlmonSales,
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 2 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN discount ELSE 0 END) AS tlmonDiscount,

                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 3 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS tltueOrders,  
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 3 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN totalAmount ELSE 0 END) AS tltueSales,
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 3 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN discount ELSE 0 END) AS tltueDiscount,

                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 4 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS tlwedOrders,  
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 4 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN totalAmount ELSE 0 END) AS tlwedSales,
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 4 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN discount ELSE 0 END) AS tlwedDiscount,

                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 5 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS tlthuOrders,  
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 5 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN totalAmount ELSE 0 END) AS tlthuSales,
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 5 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN discount ELSE 0 END) AS tlthuDiscount,

                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 6 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS tlfriOrders,  
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 6 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN totalAmount ELSE 0 END) AS tlfriSales,
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 6 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN discount ELSE 0 END) AS tlfriDiscount,

                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 7 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS tlsatOrders,  
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 7 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN totalAmount ELSE 0 END) AS tlsatSales,
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 7 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN discount ELSE 0 END) AS tlsatDiscount,

                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 1 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS tlsunOrders,  
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 1 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN totalAmount ELSE 0 END) AS tlsunSales,
                        SUM(CASE WHEN DAYOFWEEK(orderDate) = 1 AND YEARWEEK(orderDate, 1) = YEARWEEK(CURRENT_DATE - INTERVAL 1 WEEK, 1) THEN discount ELSE 0 END) AS tlsunDiscount
                    FROM 
                        orders;";
            $stmt = $this->connect()->prepare($sql);
            if ($stmt->execute()) {
                $rws = $stmt->fetch(PDO::FETCH_ASSOC);
                return $rws;
            }
            return null;
        }




        /*               customize or finding data                 */

        public function getCSSquaredData($starting, $ending)
        {
            $sql = "";

            if (!empty($ending)) {
                $sql = "SELECT 
                            SUM(CASE WHEN DATE(orderDate) BETWEEN :starting AND :ending  THEN discount ELSE 0 END) AS today_discount,
                            SUM(CASE WHEN DATE(orderDate) = :starting - INTERVAL 1 DAY THEN discount ELSE 0 END) AS yesterday_discount,
                            SUM(CASE WHEN DATE(orderDate) BETWEEN :starting AND :ending THEN 1 ELSE 0 END) AS today_orders,
                            SUM(CASE WHEN DATE(orderDate) BETWEEN :starting AND :ending THEN totalAmount ELSE 0 END) AS today_sales,
                            SUM(CASE WHEN paymentMethod = 'G-Cash' AND DATE(orderDate) BETWEEN :starting AND :ending THEN 1 ELSE 0 END) AS gcash_count,
                            SUM(CASE WHEN paymentMethod = 'Cash' AND DATE(orderDate) BETWEEN :starting AND :ending THEN 1 ELSE 0 END) AS cash_count
                        FROM orders ";
            } else {
                $sql = "SELECT 
                            SUM(CASE WHEN DATE(orderDate) = :starting  THEN discount ELSE 0 END) AS today_discount,
                            SUM(CASE WHEN DATE(orderDate) = :starting - INTERVAL 1 DAY THEN discount ELSE 0 END) AS yesterday_discount,
                            SUM(CASE WHEN DATE(orderDate) = :starting THEN 1 ELSE 0 END) AS today_orders,
                            SUM(CASE WHEN DATE(orderDate) = :starting THEN totalAmount ELSE 0 END) AS today_sales,
                            SUM(CASE WHEN paymentMethod = 'G-Cash' AND DATE(orderDate) = :starting THEN 1 ELSE 0 END) AS gcash_count,
                            SUM(CASE WHEN paymentMethod = 'Cash' AND DATE(orderDate) = :starting THEN 1 ELSE 0 END) AS cash_count
                        FROM orders ";
            }


            $stmt = $this->connect()->prepare($sql);

            if (!empty($starting)) {
                $stmt->bindParam(":starting", $starting);
                if (!empty($ending)) {
                    $stmt->bindParam(":ending", $ending);
                }
            }

            if ($stmt->execute()) {
                $rw = $stmt->fetch(PDO::FETCH_ASSOC);
                return $rw;
            }
            return null;
        }


        public function getCatCSData($starting, $ending)
        {

            $sql = "SELECT 
                        c.category_name,";
            if (!empty($ending)) {
                $sql .= " SUM(CASE WHEN DATE(o.orderDate) BETWEEN :starting AND :ending THEN 1 ELSE 0 END) AS total_sold_today";
            } else {
                $sql .= " SUM(CASE WHEN DATE(o.orderDate) = :starting THEN 1 ELSE 0 END) AS total_sold_today";
            }

            $sql .= "
                        
                    FROM 
                        category c
                    LEFT JOIN 
                        products p ON c.category_id = p.category_id
                    LEFT JOIN 
                        orderitems oi ON p.productID = oi.productID
                    LEFT JOIN 
                        orders o ON oi.ref_no = o.ref_no
                    GROUP BY 
                        c.category_id, c.category_name
                    ORDER BY 
                        total_sold_today DESC;
                    ";
            $stmt = $this->connect()->prepare($sql);
            if (!empty($starting)) {
                $stmt->bindParam(":starting", $starting);
                if (!empty($ending)) {
                    $stmt->bindParam(":ending", $ending);
                }
            }
            if ($stmt->execute()) {
                $rws = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $rws;
            }
            return null;
        }





        public function csChartQuery($type)
        {
            $sql = "";

            if ($type === "weekcs") {
                $sql = "SELECT 
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 2 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN 1 ELSE 0 END) AS tmonOrders,  
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 2 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN totalAmount ELSE 0 END) AS tmonSales,
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 2 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN discount ELSE 0 END) AS tmonDiscount,

                SUM(CASE WHEN DAYOFWEEK(orderDate) = 3 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN 1 ELSE 0 END) AS ttueOrders,  
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 3 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN totalAmount ELSE 0 END) AS ttueSales,
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 3 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN discount ELSE 0 END) AS ttueDiscount,

                SUM(CASE WHEN DAYOFWEEK(orderDate) = 4 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN 1 ELSE 0 END) AS twedOrders,  
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 4 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN totalAmount ELSE 0 END) AS twedSales,
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 4 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN discount ELSE 0 END) AS twedDiscount,

                SUM(CASE WHEN DAYOFWEEK(orderDate) = 5 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN 1 ELSE 0 END) AS tthuOrders,  
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 5 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN totalAmount ELSE 0 END) AS tthuSales,
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 5 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN discount ELSE 0 END) AS tthuDiscount,

                SUM(CASE WHEN DAYOFWEEK(orderDate) = 6 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN 1 ELSE 0 END) AS tfriOrders,  
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 6 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN totalAmount ELSE 0 END) AS tfriSales,
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 6 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN discount ELSE 0 END) AS tfriDiscount,

                SUM(CASE WHEN DAYOFWEEK(orderDate) = 7 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN 1 ELSE 0 END) AS tsatOrders,  
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 7 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN totalAmount ELSE 0 END) AS tsatSales,
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 7 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN discount ELSE 0 END) AS tsatDiscount,

                SUM(CASE WHEN DAYOFWEEK(orderDate) = 1 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN 1 ELSE 0 END) AS tsunOrders,  
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 1 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN totalAmount ELSE 0 END) AS tsunSales,
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 1 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected, 1) THEN discount ELSE 0 END) AS tsunDiscount,



                SUM(CASE WHEN DAYOFWEEK(orderDate) = 2 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS tlmonOrders,  
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 2 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN totalAmount ELSE 0 END) AS tlmonSales,
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 2 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN discount ELSE 0 END) AS tlmonDiscount,

                SUM(CASE WHEN DAYOFWEEK(orderDate) = 3 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS tltueOrders,  
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 3 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN totalAmount ELSE 0 END) AS tltueSales,
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 3 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN discount ELSE 0 END) AS tltueDiscount,

                SUM(CASE WHEN DAYOFWEEK(orderDate) = 4 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS tlwedOrders,  
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 4 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN totalAmount ELSE 0 END) AS tlwedSales,
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 4 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN discount ELSE 0 END) AS tlwedDiscount,

                SUM(CASE WHEN DAYOFWEEK(orderDate) = 5 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS tlthuOrders,  
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 5 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN totalAmount ELSE 0 END) AS tlthuSales,
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 5 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN discount ELSE 0 END) AS tlthuDiscount,

                SUM(CASE WHEN DAYOFWEEK(orderDate) = 6 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS tlfriOrders,  
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 6 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN totalAmount ELSE 0 END) AS tlfriSales,
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 6 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN discount ELSE 0 END) AS tlfriDiscount,

                SUM(CASE WHEN DAYOFWEEK(orderDate) = 7 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS tlsatOrders,  
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 7 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN totalAmount ELSE 0 END) AS tlsatSales,
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 7 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN discount ELSE 0 END) AS tlsatDiscount,

                SUM(CASE WHEN DAYOFWEEK(orderDate) = 1 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN 1 ELSE 0 END) AS tlsunOrders,  
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 1 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN totalAmount ELSE 0 END) AS tlsunSales,
                SUM(CASE WHEN DAYOFWEEK(orderDate) = 1 AND YEARWEEK(orderDate, 1) = YEARWEEK(:dateSelected - INTERVAL 1 WEEK, 1) THEN discount ELSE 0 END) AS tlsunDiscount
                FROM orders";
            } else if ($type === "monthcs") {
                $sql = "SELECT 
                ---- SALES
                SUM(CASE WHEN MONTH(orderDate) = 1 AND YEAR(orderDate) = YEAR(:dateSelected) THEN totalAmount ELSE 0 END) AS janTS,
                SUM(CASE WHEN MONTH(orderDate) = 2 AND YEAR(orderDate) = YEAR(:dateSelected) THEN totalAmount ELSE 0 END) AS febTS,
                SUM(CASE WHEN MONTH(orderDate) = 3 AND YEAR(orderDate) = YEAR(:dateSelected) THEN totalAmount ELSE 0 END) AS marTS,
                SUM(CASE WHEN MONTH(orderDate) = 4 AND YEAR(orderDate) = YEAR(:dateSelected) THEN totalAmount ELSE 0 END) AS aprTS,
                SUM(CASE WHEN MONTH(orderDate) = 5 AND YEAR(orderDate) = YEAR(:dateSelected) THEN totalAmount ELSE 0 END) AS mayTS,
                SUM(CASE WHEN MONTH(orderDate) = 6 AND YEAR(orderDate) = YEAR(:dateSelected) THEN totalAmount ELSE 0 END) AS juneTS,
                SUM(CASE WHEN MONTH(orderDate) = 7 AND YEAR(orderDate) = YEAR(:dateSelected) THEN totalAmount ELSE 0 END) AS julTS,
                SUM(CASE WHEN MONTH(orderDate) = 8 AND YEAR(orderDate) = YEAR(:dateSelected) THEN totalAmount ELSE 0 END) AS augTS,
                SUM(CASE WHEN MONTH(orderDate) = 9 AND YEAR(orderDate) = YEAR(:dateSelected) THEN totalAmount ELSE 0 END) AS septTS,
                SUM(CASE WHEN MONTH(orderDate) = 10 AND YEAR(orderDate) = YEAR(:dateSelected) THEN totalAmount ELSE 0 END) AS octTS,
                SUM(CASE WHEN MONTH(orderDate) = 11 AND YEAR(orderDate) = YEAR(:dateSelected) THEN totalAmount ELSE 0 END) AS novTS,
                SUM(CASE WHEN MONTH(orderDate) = 12 AND YEAR(orderDate) = YEAR(:dateSelected) THEN totalAmount ELSE 0 END) AS decTS,

                SUM(CASE WHEN MONTH(orderDate) = 1 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN totalAmount ELSE 0 END) AS janLS,
                SUM(CASE WHEN MONTH(orderDate) = 2 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN totalAmount ELSE 0 END) AS febLS,
                SUM(CASE WHEN MONTH(orderDate) = 3 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN totalAmount ELSE 0 END) AS marLS,
                SUM(CASE WHEN MONTH(orderDate) = 4 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN totalAmount ELSE 0 END) AS aprLS,
                SUM(CASE WHEN MONTH(orderDate) = 5 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN totalAmount ELSE 0 END) AS mayLS,
                SUM(CASE WHEN MONTH(orderDate) = 6 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN totalAmount ELSE 0 END) AS juneLS,
                SUM(CASE WHEN MONTH(orderDate) = 7 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN totalAmount ELSE 0 END) AS julLS,
                SUM(CASE WHEN MONTH(orderDate) = 8 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN totalAmount ELSE 0 END) AS augLS,
                SUM(CASE WHEN MONTH(orderDate) = 9 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN totalAmount ELSE 0 END) AS septLS,
                SUM(CASE WHEN MONTH(orderDate) = 10 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN totalAmount ELSE 0 END) AS octLS,
                SUM(CASE WHEN MONTH(orderDate) = 11 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN totalAmount ELSE 0 END) AS novLS,
                SUM(CASE WHEN MONTH(orderDate) = 12 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN totalAmount ELSE 0 END) AS decLS,
                
                ---- DISCOUNT
                SUM(CASE WHEN MONTH(orderDate) = 1 AND YEAR(orderDate) = YEAR(:dateSelected) THEN discount ELSE 0 END) AS janTD,
                SUM(CASE WHEN MONTH(orderDate) = 2 AND YEAR(orderDate) = YEAR(:dateSelected) THEN discount ELSE 0 END) AS febTD,
                SUM(CASE WHEN MONTH(orderDate) = 3 AND YEAR(orderDate) = YEAR(:dateSelected) THEN discount ELSE 0 END) AS marTD,
                SUM(CASE WHEN MONTH(orderDate) = 4 AND YEAR(orderDate) = YEAR(:dateSelected) THEN discount ELSE 0 END) AS aprTD,
                SUM(CASE WHEN MONTH(orderDate) = 5 AND YEAR(orderDate) = YEAR(:dateSelected) THEN discount ELSE 0 END) AS mayTD,
                SUM(CASE WHEN MONTH(orderDate) = 6 AND YEAR(orderDate) = YEAR(:dateSelected) THEN discount ELSE 0 END) AS juneTD,
                SUM(CASE WHEN MONTH(orderDate) = 7 AND YEAR(orderDate) = YEAR(:dateSelected) THEN discount ELSE 0 END) AS julTD,
                SUM(CASE WHEN MONTH(orderDate) = 8 AND YEAR(orderDate) = YEAR(:dateSelected) THEN discount ELSE 0 END) AS augTD,
                SUM(CASE WHEN MONTH(orderDate) = 9 AND YEAR(orderDate) = YEAR(:dateSelected) THEN discount ELSE 0 END) AS septTD,
                SUM(CASE WHEN MONTH(orderDate) = 10 AND YEAR(orderDate) = YEAR(:dateSelected) THEN discount ELSE 0 END) AS octTD,
                SUM(CASE WHEN MONTH(orderDate) = 11 AND YEAR(orderDate) = YEAR(:dateSelected) THEN discount ELSE 0 END) AS novTD,
                SUM(CASE WHEN MONTH(orderDate) = 12 AND YEAR(orderDate) = YEAR(:dateSelected) THEN discount ELSE 0 END) AS decTD,

                SUM(CASE WHEN MONTH(orderDate) = 1 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN discount ELSE 0 END) AS janLD,
                SUM(CASE WHEN MONTH(orderDate) = 2 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN discount ELSE 0 END) AS febLD,
                SUM(CASE WHEN MONTH(orderDate) = 3 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN discount ELSE 0 END) AS marLD,
                SUM(CASE WHEN MONTH(orderDate) = 4 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN discount ELSE 0 END) AS aprLD,
                SUM(CASE WHEN MONTH(orderDate) = 5 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN discount ELSE 0 END) AS mayLD,
                SUM(CASE WHEN MONTH(orderDate) = 6 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN discount ELSE 0 END) AS juneLD,
                SUM(CASE WHEN MONTH(orderDate) = 7 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN discount ELSE 0 END) AS julLD,
                SUM(CASE WHEN MONTH(orderDate) = 8 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN discount ELSE 0 END) AS augLD,
                SUM(CASE WHEN MONTH(orderDate) = 9 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN discount ELSE 0 END) AS septLD,
                SUM(CASE WHEN MONTH(orderDate) = 10 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN discount ELSE 0 END) AS octLD,
                SUM(CASE WHEN MONTH(orderDate) = 11 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN discount ELSE 0 END) AS novLD,
                SUM(CASE WHEN MONTH(orderDate) = 12 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN discount ELSE 0 END) AS decLD,

                ---- ORDERS
                SUM(CASE WHEN MONTH(orderDate) = 1 AND YEAR(orderDate) = YEAR(:dateSelected) THEN 1 ELSE 0 END) AS janTO,
                SUM(CASE WHEN MONTH(orderDate) = 2 AND YEAR(orderDate) = YEAR(:dateSelected) THEN 1 ELSE 0 END) AS febTO,
                SUM(CASE WHEN MONTH(orderDate) = 3 AND YEAR(orderDate) = YEAR(:dateSelected) THEN 1 ELSE 0 END) AS marTO,
                SUM(CASE WHEN MONTH(orderDate) = 4 AND YEAR(orderDate) = YEAR(:dateSelected) THEN 1 ELSE 0 END) AS aprTO,
                SUM(CASE WHEN MONTH(orderDate) = 5 AND YEAR(orderDate) = YEAR(:dateSelected) THEN 1 ELSE 0 END) AS mayTO,
                SUM(CASE WHEN MONTH(orderDate) = 6 AND YEAR(orderDate) = YEAR(:dateSelected) THEN 1 ELSE 0 END) AS juneTO,
                SUM(CASE WHEN MONTH(orderDate) = 7 AND YEAR(orderDate) = YEAR(:dateSelected) THEN 1 ELSE 0 END) AS julTO,
                SUM(CASE WHEN MONTH(orderDate) = 8 AND YEAR(orderDate) = YEAR(:dateSelected) THEN 1 ELSE 0 END) AS augTO,
                SUM(CASE WHEN MONTH(orderDate) = 9 AND YEAR(orderDate) = YEAR(:dateSelected) THEN 1 ELSE 0 END) AS septTO,
                SUM(CASE WHEN MONTH(orderDate) = 10 AND YEAR(orderDate) = YEAR(:dateSelected) THEN 1 ELSE 0 END) AS octTO,
                SUM(CASE WHEN MONTH(orderDate) = 11 AND YEAR(orderDate) = YEAR(:dateSelected) THEN 1 ELSE 0 END) AS novTO,
                SUM(CASE WHEN MONTH(orderDate) = 12 AND YEAR(orderDate) = YEAR(:dateSelected) THEN 1 ELSE 0 END) AS decTO,

                SUM(CASE WHEN MONTH(orderDate) = 1 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN 1 ELSE 0 END) AS janLO,
                SUM(CASE WHEN MONTH(orderDate) = 2 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN 1 ELSE 0 END) AS febLO,
                SUM(CASE WHEN MONTH(orderDate) = 3 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN 1 ELSE 0 END) AS marLO,
                SUM(CASE WHEN MONTH(orderDate) = 4 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN 1 ELSE 0 END) AS aprLO,
                SUM(CASE WHEN MONTH(orderDate) = 5 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN 1 ELSE 0 END) AS mayLO,
                SUM(CASE WHEN MONTH(orderDate) = 6 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN 1 ELSE 0 END) AS juneLO,
                SUM(CASE WHEN MONTH(orderDate) = 7 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN 1 ELSE 0 END) AS julLO,
                SUM(CASE WHEN MONTH(orderDate) = 8 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN 1 ELSE 0 END) AS augLO,
                SUM(CASE WHEN MONTH(orderDate) = 9 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN 1 ELSE 0 END) AS septLO,
                SUM(CASE WHEN MONTH(orderDate) = 10 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN 1 ELSE 0 END) AS octLO,
                SUM(CASE WHEN MONTH(orderDate) = 11 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN 1 ELSE 0 END) AS novLO,
                SUM(CASE WHEN MONTH(orderDate) = 12 AND YEAR(orderDate) = YEAR(:dateSelected) - 1 THEN 1 ELSE 0 END) AS decLO
                FROM orders";
            }

            return $sql;
        }



        public function singleRangeDataCS($type, $dateSelected)
        {
            $sql = $this->csChartQuery($type);

            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":dateSelected", $dateSelected);
            if ($stmt->execute()) {
                $rws = $stmt->fetch(PDO::FETCH_ASSOC);
                return $rws;
            }
            return null;
        }










        /*               analytics data               */




        public function itemsReport($itemtype, $order, $range, $data, $page = 1, $search)
        {
            if (!empty($search)) {
                $search = "%" . $search . "%";
            }

            $max_page_per_req = 15;

            $offset = ($page - 1) * $max_page_per_req;
            $select = $itemtype === "products" ? "products" : "combo";
            $id = $itemtype === "products" ? "productID" : "comboID";
            $name = $itemtype === "products" ? "name" : "comboName";

            $sql = "SELECT 
                pcr.displayPic, 
                pcr." . $name . " AS item, 
                pcr." . $id . " AS itemID,
                SUM(CASE WHEN ";

            if (count($range) === 1) {
                $sql .= "DATE(ord.orderDate) = ?";
                $sql .= " THEN $data ELSE 0 END) AS selData,
                        SUM(CASE WHEN DATE(ord.orderDate) = DATE_SUB(?, INTERVAL 1 DAY) THEN $data ELSE 0 END) AS beforeData";
            } else {
                $sql .= "DATE(ord.orderDate) BETWEEN ? AND ?";
                $sql .= " THEN $data ELSE 0 END) AS selData,
                SUM(CASE WHEN DATE(ord.orderDate) = DATE_SUB(?, INTERVAL 1 DAY) THEN $data ELSE 0 END) AS beforeData";
            }
            $sql .= ",SUM(CASE WHEN YEARWEEK(ord.orderDate, 1) = YEARWEEK(?, 1) THEN $data ELSE 0 END) AS TW
                     ,SUM(CASE WHEN YEARWEEK(ord.orderDate, 1) = YEARWEEK(? - INTERVAL 1 WEEK, 1) THEN $data ELSE 0 END) AS LW";

            $sql .= " FROM 
                " . $select . " AS pcr
              LEFT JOIN 
                orderitems AS oi ON oi." . $id . " = pcr." . $id . "
              LEFT JOIN 
                orders AS ord ON ord.ref_no = oi.ref_no";
            if (!empty($search)) {
                $sql .= " WHERE pcr." . $name . " LIKE ? ";
            }
            $sql .= "
              GROUP BY 
                pcr." . $name . "
              ORDER BY selData " . $order . " LIMIT ? OFFSET ?";
            $stmt = $this->connect()->prepare($sql);

            $paramIndex = 1;
            if (count($range) === 1) {
                $stmt->bindValue($paramIndex++, $range[0], PDO::PARAM_STR);
                $stmt->bindValue($paramIndex++, $range[0], PDO::PARAM_STR);
                $stmt->bindValue($paramIndex++, $range[0], PDO::PARAM_STR);
                $stmt->bindValue($paramIndex++, $range[0], PDO::PARAM_STR);
            } else {
                $stmt->bindValue($paramIndex++, $range[0], PDO::PARAM_STR);
                $stmt->bindValue($paramIndex++, $range[1], PDO::PARAM_STR);
                $stmt->bindValue($paramIndex++, $range[1], PDO::PARAM_STR);
                $stmt->bindValue($paramIndex++, $range[0], PDO::PARAM_STR);
                $stmt->bindValue($paramIndex++, $range[0], PDO::PARAM_STR);
            }
            if (!empty($search)) {
                $stmt->bindValue($paramIndex++, $search, PDO::PARAM_STR);
            }
            $stmt->bindValue($paramIndex++, $max_page_per_req, PDO::PARAM_INT);
            $stmt->bindValue($paramIndex++, $offset, PDO::PARAM_INT);
            // $stmt->bindParam(':limit', $max_page_per_req, PDO::PARAM_INT);
            // $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


            $sql2Q = "SELECT COUNT(pcr." . $id . ") AS total_rows FROM $select AS pcr";
            if (!empty($search)) {
                $sql2Q .= " WHERE pcr." . $name . " LIKE :search ";
            }
            $sql2 = $this->connect()->prepare($sql2Q);
            if (!empty($search)) {
                $sql2->bindParam(":search", $search, PDO::PARAM_STR);
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
                    'data' => NULL,
                    'total_pages' => NULL,
                    'current_page' => NULL
                ];
            }


            return null;
        }

        public function itemsReportDataAnalytics($itemtype, $range, $data, $spec)
        {
            $select = $itemtype === "products" ? "products" : "combo";
            $id = $itemtype === "products" ? "productID" : "comboID";

            $sql = "";
            if (count($range) === 1) {

                $sql = "SELECT 
                    SUM(CASE WHEN DAYOFWEEK(ord.orderDate) = 2 AND YEARWEEK(ord.orderDate,1) = YEARWEEK(:date_selected, 1) THEN $data ELSE 0 END) AS mon,
                    SUM(CASE WHEN DAYOFWEEK(ord.orderDate) = 3 AND YEARWEEK(ord.orderDate,1) = YEARWEEK(:date_selected, 1) THEN $data ELSE 0 END) AS tue,
                    SUM(CASE WHEN DAYOFWEEK(ord.orderDate) = 4 AND YEARWEEK(ord.orderDate,1) = YEARWEEK(:date_selected, 1) THEN $data ELSE 0 END) AS wed,
                    SUM(CASE WHEN DAYOFWEEK(ord.orderDate) = 5 AND YEARWEEK(ord.orderDate,1) = YEARWEEK(:date_selected, 1) THEN $data ELSE 0 END) AS thu,
                    SUM(CASE WHEN DAYOFWEEK(ord.orderDate) = 6 AND YEARWEEK(ord.orderDate,1) = YEARWEEK(:date_selected, 1) THEN $data ELSE 0 END) AS fri,
                    SUM(CASE WHEN DAYOFWEEK(ord.orderDate) = 7 AND YEARWEEK(ord.orderDate,1) = YEARWEEK(:date_selected, 1) THEN $data ELSE 0 END) AS sat,
                    SUM(CASE WHEN DAYOFWEEK(ord.orderDate) = 1 AND YEARWEEK(ord.orderDate,1) = YEARWEEK(:date_selected, 1) THEN $data ELSE 0 END) AS sun,

                    SUM(CASE WHEN DAYOFWEEK(ord.orderDate) = 2 AND YEARWEEK(ord.orderDate,1) = YEARWEEK(:date_selected - INTERVAL 1 WEEK, 1) THEN $data ELSE 0 END) AS lmon,
                    SUM(CASE WHEN DAYOFWEEK(ord.orderDate) = 3 AND YEARWEEK(ord.orderDate,1) = YEARWEEK(:date_selected - INTERVAL 1 WEEK, 1) THEN $data ELSE 0 END) AS ltue,
                    SUM(CASE WHEN DAYOFWEEK(ord.orderDate) = 4 AND YEARWEEK(ord.orderDate,1) = YEARWEEK(:date_selected - INTERVAL 1 WEEK, 1) THEN $data ELSE 0 END) AS lwed,
                    SUM(CASE WHEN DAYOFWEEK(ord.orderDate) = 5 AND YEARWEEK(ord.orderDate,1) = YEARWEEK(:date_selected - INTERVAL 1 WEEK, 1) THEN $data ELSE 0 END) AS lthu,
                    SUM(CASE WHEN DAYOFWEEK(ord.orderDate) = 6 AND YEARWEEK(ord.orderDate,1) = YEARWEEK(:date_selected - INTERVAL 1 WEEK, 1) THEN $data ELSE 0 END) AS lfri,
                    SUM(CASE WHEN DAYOFWEEK(ord.orderDate) = 7 AND YEARWEEK(ord.orderDate,1) = YEARWEEK(:date_selected - INTERVAL 1 WEEK, 1) THEN $data ELSE 0 END) AS lsat,
                    SUM(CASE WHEN DAYOFWEEK(ord.orderDate) = 1 AND YEARWEEK(ord.orderDate,1) = YEARWEEK(:date_selected - INTERVAL 1 WEEK, 1) THEN $data ELSE 0 END) AS lsun,
                

                    SUM(CASE WHEN MONTH(ord.orderDate) = 1 AND YEAR(ord.orderDate) = YEAR(:date_selected) THEN $data ELSE 0 END) AS janT,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 2 AND YEAR(ord.orderDate) = YEAR(:date_selected) THEN $data ELSE 0 END) AS febT,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 3 AND YEAR(ord.orderDate) = YEAR(:date_selected) THEN $data ELSE 0 END) AS marT,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 4 AND YEAR(ord.orderDate) = YEAR(:date_selected) THEN $data ELSE 0 END) AS aprT,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 5 AND YEAR(ord.orderDate) = YEAR(:date_selected) THEN $data ELSE 0 END) AS mayT,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 6 AND YEAR(ord.orderDate) = YEAR(:date_selected) THEN $data ELSE 0 END) AS juneT,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 7 AND YEAR(ord.orderDate) = YEAR(:date_selected) THEN $data ELSE 0 END) AS julT,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 8 AND YEAR(ord.orderDate) = YEAR(:date_selected) THEN $data ELSE 0 END) AS augT,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 9 AND YEAR(ord.orderDate) = YEAR(:date_selected) THEN $data ELSE 0 END) AS septT,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 10 AND YEAR(ord.orderDate) = YEAR(:date_selected) THEN $data ELSE 0 END) AS octT,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 11 AND YEAR(ord.orderDate) = YEAR(:date_selected) THEN $data ELSE 0 END) AS novT,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 12 AND YEAR(ord.orderDate) = YEAR(:date_selected) THEN $data ELSE 0 END) AS decT,

                    SUM(CASE WHEN MONTH(ord.orderDate) = 1 AND YEAR(ord.orderDate) = YEAR(:date_selected) - 1 THEN $data ELSE 0 END) AS janL,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 2 AND YEAR(ord.orderDate) = YEAR(:date_selected) - 1 THEN $data ELSE 0 END) AS febL,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 3 AND YEAR(ord.orderDate) = YEAR(:date_selected) - 1 THEN $data ELSE 0 END) AS marL,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 4 AND YEAR(ord.orderDate) = YEAR(:date_selected) - 1 THEN $data ELSE 0 END) AS aprL,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 5 AND YEAR(ord.orderDate) = YEAR(:date_selected) - 1 THEN $data ELSE 0 END) AS mayL,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 6 AND YEAR(ord.orderDate) = YEAR(:date_selected) - 1 THEN $data ELSE 0 END) AS juneL,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 7 AND YEAR(ord.orderDate) = YEAR(:date_selected) - 1 THEN $data ELSE 0 END) AS julL,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 8 AND YEAR(ord.orderDate) = YEAR(:date_selected) - 1 THEN $data ELSE 0 END) AS augL,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 9 AND YEAR(ord.orderDate) = YEAR(:date_selected) - 1 THEN $data ELSE 0 END) AS septL,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 10 AND YEAR(ord.orderDate) = YEAR(:date_selected) - 1 THEN $data ELSE 0 END) AS octL,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 11 AND YEAR(ord.orderDate) = YEAR(:date_selected) - 1 THEN $data ELSE 0 END) AS novL,
                    SUM(CASE WHEN MONTH(ord.orderDate) = 12 AND YEAR(ord.orderDate) = YEAR(:date_selected) - 1 THEN $data ELSE 0 END) AS decL
                ";
            } else {
                $sql = "SELECT SUM(CASE WHEN DATE(ord.orderDate) BETWEEN :date_selected AND :date_selected2 THEN $data ELSE 0 END) AS slsum";
            }
            $sql .= " FROM  $select AS pcr
            LEFT JOIN 
                orderitems AS oi ON oi.$id = pcr.$id
            LEFT JOIN 
                orders AS ord ON ord.ref_no = oi.ref_no
            WHERE oi.$id = :item";

            $stmt = $this->connect()->prepare($sql);

            if (count($range) === 1) {

                $stmt->bindParam(":item", $spec, PDO::PARAM_INT);
                $stmt->bindParam(":date_selected", $range[0], PDO::PARAM_STR);
            } else {
                $stmt->bindParam(":item", $spec, PDO::PARAM_INT);
                $stmt->bindParam(":date_selected", $range[0], PDO::PARAM_STR);
                $stmt->bindParam(":date_selected2", $range[1], PDO::PARAM_STR);
                // $stmt->bindValue(39, $spec, PDO::PARAM_INT);

            }


            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        }



        // public function itemsReportProd($data, $rtype, $order, $starting, $ending)
        // {
        //     $sql = "";
        //     $sum = "";
        //     if ($data == "orders") {
        //         $sum = "1";
        //     } else {
        //         $sum = "ord.totalAmount";
        //     }

        //     $wsome = "";


        //     if ($rtype == "single") {

        //         $wsome = " SUM(CASE WHEN DATE(ord.orderDate) = :starting THEN " . $sum . " ELSE 0 END) AS selData, ";

        //     } else if ($rtype == "double") {

        //         $wsome = " SUM(CASE WHEN DATE(ord.orderDate) BETWEEN :starting AND :ending THEN " . $sum . " ELSE 0 END) AS selData, ";

        //     }
        //     $sql = "SELECT
        //                     pr.name, 
        //                     pr.displayPic, 
        //                     oi.productID,
        //                     $wsome
        //                     SUM(CASE WHEN DATE(ord.orderDate) = :starting - INTERVAL 1 DAY THEN " . $sum . "  ELSE 0 END) AS ydata
        //                 FROM 
        //                     products AS pr
        //                 LEFT JOIN 
        //                     orderitems AS oi ON oi.productID = pr.productID
        //                 LEFT JOIN 
        //                     orders AS ord ON ord.ref_no = oi.ref_no
        //                 GROUP BY 
        //                     pr.name 
        //                 ORDER BY selData ";


        //     $stmt = $this->connect()->prepare($sql);
        //     if ($stmt->execute()) {
        //         $rws = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //         return $rws;
        //     }
        //     return null;
        // }


























        //------------------------- PRODUCT THINGS -----------------------------


        // DUMP DATA 
        public function dumpReqData($id)
        {
            $sql = "SELECT * FROM combo AS cb INNER JOIN comboitems AS ci ON ci.comboID = cb.comboID WHERE cb.comboID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$id]);
            $rows =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                return $rows;
            } else {
                return null;
            }
        }


        // FORM DATA PRODUCT
        public function productData($id)
        {
            $sql = "SELECT * FROM products INNER JOIN category ON category.category_id = products.category_id WHERE products.productID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$id]);
            $rows =  $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rows) {
                return $rows;
            } else {
                return null;
            }
        }
        
        public function updateProductThings($id,$col,$data)
        {
            $stmt = $this->connect()->prepare("UPDATE products SET $col = ? where productID = ?");
            if ($stmt->execute([$data,$id])) {
                return true;
            } else {
                return false;
            }
        }


        //  name	price	availability
        public function productDataLight($id)
        {
            $sql = "SELECT 
            prd.name,
            prd.price,
            prd.category_id,
            prd.availability 
            FROM products AS prd WHERE prd.productID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$id]);
            $rows =  $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rows) {
                return $rows;
            } else {
                return null;
            }
        }
        public function categoryData($id)
        {
            $sql = "SELECT * FROM category WHERE category_id = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$id]);
            $rows =  $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rows) {
                return $rows;
            } else {
                return null;
            }
        }
        public function comboDataLight($id)
        {
            $sql = "SELECT cb.comboName,cb.comboCode,cb.availability,cb.comboPrice,ci.productID FROM combo AS cb INNER JOIN comboitems AS ci ON ci.comboID = cb.comboID WHERE cb.comboID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$id]);
            $rows =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                return $rows;
            } else {
                return null;
            }
        }
        public function comboData($id)
        {
            $sql = "SELECT * FROM combo INNER JOIN comboItems ON combo.comboID = comboItems.comboID WHERE combo.comboID = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$id]);
            $rows =  $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rows) {
                return $rows;
            } else {
                return null;
            }
        }


        // ADD PRODUCT
        public function insertProduct($product_name, $category_name, $price, $availability, $product_image)
        {
            $stmt = $this->connect()->prepare("INSERT INTO products (name,category_id, price, availability, displayPic) VALUES (?, ?, ?, ?, ?);");
            if ($stmt->execute([$product_name, $category_name, $price, $availability, $product_image])) {
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
        // public function editProduct($product_name, $category_name, $price, $product_image, $quantity)
        // {
        //     $stmt = $this->connect()->prepare("UPDATE products SET product_name= :name, category_name= :category, price= :price, displayPic= :displayPic, quantity= :quantity WHERE id = :id");
        //     $stmt->bindParam(':name', $product_name);
        //     $stmt->bindParam(':category', $category_name);
        //     $stmt->bindParam(':price', $price);
        //     $stmt->bindParam(':display_pic', $product_image);
        //     $stmt->bindParam(':quantity', $quantity);
        // }


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
        public function category_delete($category_id)
        {
            $sql = "DELETE FROM category WHERE category_id = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $category_id, PDO::PARAM_INT);

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
            $sql .= " GROUP BY products.productID ORDER BY products.productID DESC LIMIT :limit OFFSET :offset";


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

            $sql .= " GROUP BY products.productID LIMIT 20";

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
        public function addCombo($combos, $comboIMG, $comboName, $comboCode, $comboPrice, $availability)
        {
            $sql = "INSERT INTO combo(displayPic,comboName,comboCode,comboPrice,availability) values(?, ?, ?, ?, ?)";

            $stmt = $this->connect()->prepare($sql);

            if ($stmt->execute([$comboIMG, $comboName, $comboCode, $comboPrice, $availability])) {
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
                $stmt2->bindParam(":comboName", $comboName);
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
        }


        // SEARCH CATEGORY   
        public function findCategory($categoryName, $page = 1)
        {

            $max_page_per_req = 10;

            $offset = ($page - 1) * $max_page_per_req;

            $sql = "SELECT category.*,COUNT(products.productID) as total_prod FROM category left join products on category.category_id = products.category_id";

            if (!empty($categoryName)) {
                $sql .= " WHERE category.category_name LIKE :categoryName";
            }

            $sql .= " GROUP BY category.category_id limit :limit OFFSET :offset";

            $stmt = $this->connect()->prepare($sql);


            if (!empty($categoryName)) {
                $categoryName = "%" . $categoryName . "%";
                $stmt->bindParam(":categoryName", $categoryName);
            }
            $stmt->bindParam(':limit', $max_page_per_req, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


            $sql2 = "SELECT COUNT(category.category_id) as total_cat FROM category";

            if (!empty($categoryName)) {
                $sql2 .= " WHERE category.category_name LIKE :categoryName";
            }

            $stmt2 = $this->connect()->prepare($sql2);

            if (!empty($categoryName)) {
                $stmt2->bindParam(":categoryName", $categoryName);
            }

            $stmt2->execute();

            $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $total_rows = ($rows2) ? (int)$rows2['total_cat'] : 0;


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












        //------------------------- HISTORY THINGS -----------------------------


        public function delOrders($ref)
        {
            $sql = "DELETE FROM orders WHERE ref_no = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(1, $ref, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        public function getOrderRecord($ref)
        {


            $sql = "SELECT ord.*,ord.ref_no as rff, oi.*, pr.name,c.comboName FROM orders as ord
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

        public function getAllCombosModel($comboName, $page = 1)
        {
            $max_page_per_req = 25;
            $offset = ($page - 1) * $max_page_per_req;

            if (!empty($comboName)) {
                $comboName = "%" . $comboName . "%";
            }


            $sql = "SELECT * FROM combo";


            if (!empty($comboName)) {
                $sql .= " WHERE combo.comboName LIKE :comboName GROUP BY combo.comboID";
            }
            $sql .= " LIMIT :limit OFFSET :offset";

            $stmt = $this->connect()->prepare($sql);
            if (!empty($comboName)) {
                $stmt->bindParam(':comboName', $comboName);
            }
            $stmt->bindParam(':limit', $max_page_per_req, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);




            // count page 
            $sql2 = "SELECT COUNT(combo.comboID) AS total_rows FROM combo";


            if (!empty($comboName)) {
                $sql2 .= " WHERE combo.comboName LIKE :comboName GROUP BY combo.comboID";
            }

            $stmt2 = $this->connect()->prepare($sql2);

            if (!empty($comboName)) {
                $stmt2->bindParam(':comboName', $comboName);
            }



            $stmt2->execute();
            $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $total_rows = ($rows2) ? (int)$rows2['total_rows'] : 0;


            $total_pages = ceil($total_rows / $max_page_per_req);


            if ($stmt->execute()) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            } else {
                return null;
            }
        }


        public function getAllProductss($product_name, $category, $page = 1)
        {

            // fme
            $max_page_per_req = 25;

            $offset = ($page - 1) * $max_page_per_req;

            if (!empty($product_name)) {
                $product_name = "%" . $product_name . "%";
            }


            $sql = "SELECT * FROM products";


            if (!empty($category)) {
                $sql .= " INNER JOIN category ON category.category_id = products.category_id WHERE category.category_id = :category";
            }

            if (!empty($product_name)) {
                if (empty($category)) {
                    $sql .= " WHERE products.name LIKE :product_name";
                } else {
                    $sql .= " AND products.name LIKE :product_name";
                }
            }
            $sql .= " GROUP BY products.productID ORDER BY products.availability = 'Available' DESC LIMIT :limit OFFSET :offset";



            $pdo = $this->connect();
            $stmt = $pdo->prepare($sql);
            if (!empty($product_name)) {
                $stmt->bindParam(':product_name', $product_name);
            }
            if (!empty($category)) {
                $stmt->bindParam(':category', $category);
            }
            $stmt->bindParam(':limit', $max_page_per_req, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);



            // count page 
            $sql2 = "SELECT COUNT(products.productID) AS total_rows FROM products";


            if (!empty($category)) {
                $sql2 .= " INNER JOIN category ON category.category_id = products.category_id WHERE category.category_id = :category";
            }

            if (!empty($product_name)) {
                if (empty($category)) {
                    $sql2 .= " WHERE products.name LIKE :product_name";
                } else {
                    $sql2 .= " AND products.name LIKE :product_name";
                }
            }
            $stmt2 = $this->connect()->prepare($sql2);

            if (!empty($product_name)) {
                $stmt2->bindParam(':product_name', $product_name);
            }
            if (!empty($category)) {
                $stmt2->bindParam(':category', $category);
            }

            $stmt2->execute();
            $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $total_rows = ($rows2) ? (int)$rows2['total_rows'] : 0;


            $total_pages = ceil($total_rows / $max_page_per_req);


            if ($stmt->execute()) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

            $stmtF = $this->connect()->prepare("INSERT INTO orders (totalAmount,discount,discountType,ref_no,paymentMethod,gcashAccountName,gcashAccountNo,subtotal,tendered)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");



            if ($stmtF->execute([$orders[0]['totalAmount'], $orders[0]['discount'], $orders[0]['discountType'], $orders[0]['refNo'], $orders[0]['pmethod'], $orders[0]['gcashName'], $orders[0]['gcashNum'], $orders[0]['subtotal'], $orders[0]['tendered']])) {
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


        public function getCategoryName($id)
        {
            $stmt = $this->connect()->prepare("SELECT category_name FROM category where category_id = ?");
            $stmt->execute([$id]);
            $rows =  $stmt->fetch(PDO::FETCH_ASSOC);

            if ($rows) {
                return $rows['category_name'];
            } else {
                return null;
            }
        }



        public function updateCategoryName($id,$catName)
        {
            $stmt = $this->connect()->prepare("UPDATE category SET category_name = ? where category_id = ?");
            if ($stmt->execute([$catName,$id])) {
                return true;
            } else {
                return false;
            }
        }












        //------------------------- EMPLOYEES THINGS -----------------------------

        public function unExist($un)
        {
            $stmt = $this->connect()->prepare('SELECT userName FROM user WHERE userName = ?;');

            if ($stmt->execute([$un])) {
                if ($stmt->rowCount() == 0) {
                    return false;
                } else {
                    return true;
                }
            }
        }

        public function emailExist($em)
        {
            $stmt = $this->connect()->prepare("SELECT email FROM user WHERE email = ?");
            if ($stmt->execute([$em])) {
                if ($stmt->rowCount() == 0) {
                    return false;
                } else {
                    return true;
                }
            }
        }

        public function delCahierAccount($uid)
        {
            $sql = "DELETE FROM user WHERE userID = ?";
            $stmt = $this->connect()->prepare($sql);
            if ($stmt->execute([$uid])) {
                return true;
            } else {
                return false;
            }
        }



        public function addCahier($info)
        {

            $sql = "INSERT INTO user(userRole,userName,email,password) VALUES(?, ?, ?, ?);";

            $options = [
                'cost' => 12
            ];
            $password = password_hash($info['pw'], PASSWORD_BCRYPT, $options);

            $obj = $this->connect();
            $stmt = $obj->prepare($sql);

            if ($stmt->execute(["Employee", $info['un'], $info['em'], $password])) {
                (int)$uid = $obj->lastInsertId();
                if ($this->addCahierInfo($info, $uid)) {
                    return true;
                } else {
                    return !$this->delCahierAccount($uid);
                }
            } else {
                return false;
            }
        }

        public function addCahierInfo($info, $uid)
        {

            $sql = "INSERT INTO 
                    employees(userID,profilePic,fName,mName,lName,age,birthdate,address,contactno) 
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?);";

            $stmt = $this->connect()->prepare($sql);
            if ($stmt->execute([
                $uid,
                $info['pf'],
                $info['fn'],
                $info['mn'],
                $info['ln'],
                $info['age'],
                $info['bd'],
                $info['addr'],
                $info['cn']
            ])) {

                return true;
            } else {
                return false;
            }
        }

        public function findEmp($name, $page)
        {

            $max_page_per_req = 15;

            $offset = ($page - 1) * $max_page_per_req;


            $sql = "SELECT * FROM employees LEFT JOIN user ON user.userID = employees.userID";

            if (!empty($name)) {
                $sql .= " WHERE fName LIKE :name OR mName LIKE :name OR lName LIKE :name";
            }
            $sqlF = $sql . " LIMIT :limit OFFSET :offset";

            $stmt = $this->connect()->prepare($sqlF);
            if (!empty($name)) {
                $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            }
            $stmt->bindParam(':limit', $max_page_per_req, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);




            // count page 
            $sql2 = "SELECT COUNT(employees.employeeID) AS total_rows FROM employees LEFT JOIN user ON user.userID = employees.userID";


            if (!empty($name)) {
                $sql2 .= " WHERE fName LIKE :name OR mName LIKE :name OR lName LIKE :name";
            }

            $stmt2 = $this->connect()->prepare($sql2);

            if (!empty($name)) {
                $stmt2->bindParam(":name", $name, PDO::PARAM_STR);
            }

            $stmt2->execute();
            $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $total_rows = ($rows2) ? (int)$rows2['total_rows'] : 0;


            $total_pages = ceil($total_rows / $max_page_per_req);


            if ($stmt->execute()) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            } else {
                return null;
            }
        }



        public function updateEmployeeData($data, $keyVal, $id)
        {
            $stmt = $this->connect()->prepare(
                "UPDATE employees SET $keyVal = ? WHERE userID = ?"
            );
            if ($stmt->execute([$data, $id])) {
                return true;
            } else {
                return false;
            }
        }

        public function updateUserData($data, $keyVal, $id)
        {
            $stmt = $this->connect()->prepare(
                "UPDATE user SET $keyVal = ? WHERE userID = ?"
            );
            if ($stmt->execute([$data, $id])) {
                return true;
            } else {
                return false;
            }
        }


        public function getEmployeeData($id)
        {

            $sql = "SELECT * FROM employees LEFT JOIN user ON user.userID = employees.userID WHERE user.userID = ?;";
            $stmt = $this->connect()->prepare($sql);

            if ($stmt->execute([$id])) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row;
            } else {
                return false;
            }
        }
    }
