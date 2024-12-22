<?php

require_once '../Controller/employeesController.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {


    if (isset($_POST['transac']) && $_POST["transac"] === "firstSec") {
        $fn = htmlspecialchars(trim($_POST['fn']));
        $mn = htmlspecialchars(trim($_POST['mn']));
        $ln = htmlspecialchars(trim($_POST['ln']));
        $age = htmlspecialchars(trim($_POST['age']));
        $err = "";
        if (
            ce($fn) ||
            ce($mn) ||
            ce($ln) ||
            ce($age)
        ) {

            http_response_code(400);
            $err =  "<p>Fill in all fields.</p>";
        } else {
            if ((int)$age >= 18 && (int)$age <= 50) {
                http_response_code(200);
            } else {
                http_response_code(400);
                $err =  "<p>User must be 18 - 50Y/O.</p>";
            }
        }

        header("Content-Type: application/json");
        echo json_encode(["error" => $err]);
    }




    if (isset($_POST['transac']) && $_POST["transac"] === "secondSec") {
        $cn = htmlspecialchars(trim($_POST['cn']));
        $bd = htmlspecialchars(trim($_POST['bd']));
        $em = htmlspecialchars(trim($_POST['em']));
        $addr = htmlspecialchars(trim($_POST['addr']));
        $err = "";
        if (
            ce($cn) ||
            ce($bd) ||
            ce($em) ||
            ce($addr)
        ) {

            http_response_code(400);
            $err = "<p>Fill in all fields.</p>";
        } else {
            $obj = new Employees();
            $bdcal = new DateTime($bd);
            $today = new DateTime();
            $age = $today->diff($bdcal)->y;
            if ((int)$age >= 18 && (int)$age <= 50) {
                if (preg_match('/^09\d{9}$/', $cn)) {
                    if (!($obj->is_invalid_email($em))) {
                        if (!($obj->isEmailExist($em))) {
                            http_response_code(200);
                        } else {
                            http_response_code(400);
                            $err =  "<p>Email already in used.</p>";
                        }
                    } else {
                        http_response_code(400);
                        $err =  "<p>Invalid email.</p>";
                    }
                } else {
                    http_response_code(400);
                    $err =  "<p>Enter a valid and 11 digits CP no.</p>";
                }
            } else {
                http_response_code(400);
                $err =  "<p>User must be 18 - 50Y/O.</p>";
            }

            header("Content-Type: application/json");
        }
        echo json_encode(["error" => $err]);
    }

    if (isset($_POST['transac']) && $_POST["transac"] === "allSec") {
        $fn = htmlspecialchars(trim($_POST['fn']));
        $mn = htmlspecialchars(trim($_POST['mn']));
        $ln = htmlspecialchars(trim($_POST['ln']));
        $age = htmlspecialchars(trim($_POST['age']));

        $cn = htmlspecialchars(trim($_POST['cn']));
        $bd = htmlspecialchars(trim($_POST['bd']));
        $em = htmlspecialchars(trim($_POST['em']));
        $addr = htmlspecialchars(trim($_POST['addr']));

        $un = htmlspecialchars(trim($_POST['un']));
        $pw = htmlspecialchars(trim($_POST['pw']));
        $cpw = htmlspecialchars(trim($_POST['cpw']));


        if (
            ce($fn) ||
            ce($mn) ||
            ce($ln) ||
            ce($age) ||

            ce($cn) ||
            ce($bd) ||
            ce($em) ||
            ce($addr) ||

            ce($un) ||
            ce($pw) ||
            ce($cpw)
        ) {

            http_response_code(400);
            header("Content-Type: application/json");
            echo json_encode(["error" => "<p>Fill in all fields.</p>"]);
        } else {
            $errors = [];

            $ImageData = "";

            if (isset($_FILES['dp']) && $_FILES['dp']['error'] == 0) {
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                $fileExtension = strtolower(pathinfo($_FILES['dp']['name'], PATHINFO_EXTENSION));
                $fileSize = $_FILES['dp']['size']; // Size of the uploaded file in bytes

                $maxFileSize = 3 * 1024 * 1024;

                if (in_array($fileExtension, $allowedExtensions)) {
                    if ($fileSize <= $maxFileSize) {
                        $ImageData = file_get_contents($_FILES['dp']['tmp_name']);
                    } else {
                        $errors["errr"] = "<p>The file size exceeds the maximum allowed limit (3 MB).</p>";
                    }
                } else {
                    $errors["errr"] = "<p>Only JPG and PNG files are allowed for profile pictures.</p>";
                }
            } else {
                $errors["errr"] = "<p>Please insert a profile.</p>";
            }



            $obj = new Employees();
            if (count($errors) === 0) {
                if ($obj->isUserNameExist($un)) {
                    $errors["errr"] = "<p>User name already exist.</p>";
                }
            }
            $lengthPw = strlen($pw);

            if (count($errors) === 0) {

                if ($pw === $cpw) {
                    if ($lengthPw < 8 && $lengthPw > 16) {
                        $errors["errr"] = "<p>Password must be 8 - 16 characters only.</p>";
                    }
                } else {
                    $errors["errr"] = "<p>Password didn't match.</p>";
                }
            }




            $bdcal = new DateTime($bd);
            $today = new DateTime();
            $ageBD = $today->diff($bdcal)->y;

            if (count($errors) === 0) {

                if (((int)$ageBD >= 18 && (int)$ageBD <= 50) || ((int)$age >= 18 && (int)$age <= 50)) {
                    if (preg_match('/^09\d{9}$/', $cn)) {
                        if (!($obj->is_invalid_email($em))) {
                            if (!($obj->isEmailExist($em))) {
                            } else {
                                $errors['errr'] =  "<p>Email already in used.</p>";
                            }
                        } else {
                            $errors['errr'] =  "<p>Invalid email.</p>";
                        }
                    } else {
                        $errors['errr'] =  "<p>Enter a valid and 11 digits CP no.</p>";
                    }
                } else {
                    $errors['errr'] =  "<p>User must be 18 - 50Y/O.</p>";
                }
            }

            if (count($errors) === 0) {
                $res = "";
                if ($obj->addCashierAccGate([
                    'un' => $un,
                    'em' => $em,
                    'pw' => $pw,
                    'pf' => $ImageData,
                    'fn' => $fn,
                    'mn' => $mn,
                    'ln' => $ln,
                    'age' => $age,
                    'bd' => $bd,
                    'addr' => $addr,
                    'cn' => $cn
                ])) {
                    http_response_code(200);
                    $res = "success";
                } else {
                    http_response_code(400);
                    $res = "<p>Something went wrong.</p>";
                }

                header("Content-Type: application/json");
                echo json_encode(["error" => $res]);
            } else {

                http_response_code(400);
                header("Content-Type: application/json");

                echo json_encode(["error" => $errors['errr']]);
            }
        }
    }

    /*

        if (            !ce($("#cn").val()) &&
        !ce($("#bd").val()) &&
        !ce($("#em").val()) &&
        !ce($("#addr").val())
    ) {            !ce($("#fn").val()) &&
        !ce($("#mn").val()) &&
        !ce($("#ln").val()) &&
        !ce($("#age").val())
            !ce($("#un").val()) &&
            !ce($("#pw").val()) &&
            !ce($("#cpw").val())


*/
}


function ce($arg)
{
    if (empty($arg)) {
        return true;
    }
    return false;
}
