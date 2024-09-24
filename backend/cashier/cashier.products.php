<?php


require_once "cashier.controller.php";



class show_products extends cashier_controller
{

    public function response():array 
    {
        $pdoTemp = new cashier_controller();
        $products = $pdoTemp->getAllProducts();

        return $products;
    }


    // $category = $_POST['category'];







}


$category = 'all';
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if ($category === 'all') {

        $allProdTemp = new show_products();
        $allProd = $allProdTemp->response();

        if ($allProd != null) {

            foreach ($allProd as $prod) {
                echo '
                    <ol>
                        <li><img id="'. $prod['productID'] .'" src="data:image/jpeg;base64,'. base64_encode($prod['displayPic']) .'" alt="item"></li>
                        <li>
                            <h5>'. $prod['name'] . '</h5>
                            <h4><b>₱'. $prod['price'] .'</b></h4>
                        </li>
                    </ol>
                
                ';
            }


        }else{
            echo "No products..";
        }

        
    }




}else{
    echo "No asfafds";

}

