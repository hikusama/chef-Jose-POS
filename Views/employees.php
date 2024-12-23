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
        $age = htmlspecialchars(trim($_POST['age']));
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
            $ageBD = $today->diff($bdcal)->y;
            if ((int)$age >= 18 && (int)$age <= 50) {
                if ((int)$ageBD == $age) {
                    if (preg_match('/^639\d{9}$/', $cn)) {
                        if (!($obj->is_invalid_email($em))) {
                            if (!isset($_POST['edit'])) {
                                if (!($obj->isEmailExist($em))) {
                                    http_response_code(200);
                                    $err =  "success";
                                } else {
                                    http_response_code(400);
                                    $err =  "<p>Email already in used.</p>";
                                }
                            } else {
                                http_response_code(200);
                                $err =  "success";
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
                    $err =  "<p>Age and Birth Year doesn't match.</p>";
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

                if ($pw != $cpw) {
                    if ($lengthPw < 8 && $lengthPw > 16) {
                    } else {
                        $errors["errr"] = "<p>Password didn't match.</p>";
                    }
                } else {
                    $errors["errr"] = "<p>Password must be 8 - 16 characters only.</p>";
                }
            }




            $bdcal = new DateTime($bd);
            $today = new DateTime();
            $ageBD = $today->diff($bdcal)->y;

            if (count($errors) === 0) {

                if (((int)$ageBD >= 18 && (int)$ageBD <= 50) || ((int)$age >= 18 && (int)$age <= 50)) {
                    if ((int)$ageBD === $age) {
                        if (preg_match('/^639\d{9}$/', $cn)) {
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
                        $errors['errr'] =  "<p>Age and Birth Year doesn't match.</p>";
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








    if (isset($_POST['transac']) && $_POST["transac"] === "allSecEdit") {
        $modif = json_decode($_POST['modifieds'], true);
        $modifieds = [];
        // $modifieds = array_merge(...$modifieds);
        foreach ($modif as $value) {
            // $modif["'".$value['field']."'"] = $value['value'];
            $modifieds[$value['field']] = $value['value'];
        }
        $userID = htmlspecialchars(trim($_POST['userID']));

        $fn = htmlspecialchars(trim($_POST['fnEdit']));
        $mn = htmlspecialchars(trim($_POST['mnEdit']));
        $ln = htmlspecialchars(trim($_POST['lnEdit']));
        $age = htmlspecialchars(trim($_POST['ageEdit']));

        $cn = htmlspecialchars(trim($_POST['cnEdit']));
        $bd = htmlspecialchars(trim($_POST['bdEdit']));
        $em = htmlspecialchars(trim($_POST['emEdit']));
        $addr = htmlspecialchars(trim($_POST['addrEdit']));

        $un = htmlspecialchars(trim($_POST['unEdit']));
        $pw = htmlspecialchars(trim($_POST['pwEdit']));
        $cpw = htmlspecialchars(trim($_POST['cpwEdit']));

        if (
            ce($fn) ||
            ce($mn) ||
            ce($ln) ||
            ce($age) ||

            ce($cn) ||
            ce($bd) ||
            ce($em) ||
            ce($addr) ||

            ce($un)
        ) {
            http_response_code(400);
            header("Content-Type: application/json");
            echo json_encode(["error" => "<p>Fill in all fields.</p>"]);
        } else {
            $errors = [];

            $ImageData = "";

            if (isset($_FILES['dpEdit']) && $_FILES['dpEdit']['error'] == 0) {
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                $fileExtension = strtolower(pathinfo($_FILES['dpEdit']['name'], PATHINFO_EXTENSION));
                $fileSize = $_FILES['dpEdit']['size'];

                $maxFileSize = 3 * 1024 * 1024;

                if (in_array($fileExtension, $allowedExtensions)) {
                    if ($fileSize <= $maxFileSize) {
                        $ImageData = file_get_contents($_FILES['dpEdit']['tmp_name']);
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
            if (count($errors) === 0 && isset($modifieds['un'])) {
                if ($obj->isUserNameExist($un)) {
                    $errors["errr"] = "<p>User name already exist.</p>";
                }
            }
            $lengthPw = strlen($pw);


            if (count($errors) === 0 && !ce($pw)) {
                if ($pw != $cpw) {
                    if ($lengthPw < 8 && $lengthPw > 16) {
                    } else {
                        $errors["errr"] = "<p>Password didn't match.</p>";
                    }
                } else {
                    $errors["errr"] = "<p>Password must be 8 - 16 characters only.</p>";
                }
            }




            $bdcal = new DateTime($bd);
            $today = new DateTime();
            $ageBD = $today->diff($bdcal)->y;

            if (count($errors) === 0) {

                if (((int)$ageBD >= 18 && (int)$ageBD <= 50) || ((int)$age >= 18 && (int)$age <= 50)) {
                    if ((int)$ageBD == $age) {
                        if (preg_match('/^639\d{9}$/', $cn)) {
                            if (!($obj->is_invalid_email($em))) {
                                if (isset($modifieds['em'])) {

                                    if (!($obj->isEmailExist($em))) {
                                    } else {
                                        $errors['errr'] =  "<p>Email already in used.</p>";
                                    }
                                }
                            } else {
                                $errors['errr'] =  "<p>Invalid email.</p>";
                            }
                        } else {
                            $errors['errr'] =  "<p>Enter a valid and 11 digits CP no.</p>";
                        }
                    } else {
                        $errors['errr'] =  "<p>Age and Birth Year doesn't match.</p>";
                    }
                } else {
                    $errors['errr'] =  "<p>User must be 18 - 50Y/O.</p>";
                }
            }

            if (count($errors) === 0 && count($modifieds) > 0) {
                $res = "";

                // if ($obj->addCashierAccGate([
                //     'un' => $un,
                //     'em' => $em,
                //     'pw' => $pw,
                //     'pf' => $ImageData,
                //     'fn' => $fn,
                //     'mn' => $mn,
                //     'ln' => $ln,
                //     'age' => $age,
                //     'bd' => $bd,
                //     'addr' => $addr,
                //     'cn' => $cn
                // ])) {
                //     http_response_code(200);
                //     $res = "success";
                // } else {
                //     http_response_code(400);
                //     $res = "<p>Something went wrong.</p>";
                // }

                if (isset($modifieds['pwEdit'])) {
                    $options = [
                        'cost' => 12
                    ];
                    $password = password_hash($pw, PASSWORD_BCRYPT, $options);
                    $modifieds["password"] = $password;
                }
                // var_dump($modifieds);
                $errorCount = 0;
                foreach ($modifieds as $key => $value) {
                    if (
                        $value == "userName" ||
                        $value == "email" ||
                        $value == "password"
                    ) {
                        if (!$obj->updateUserData(htmlspecialchars(trim($_POST["$key"])), $value, $userID)) {
                            $errorCount += 1;
                        }
                    } else {
                        if (isset($modifieds['dpEdit'])) {
                            if (!$obj->updateEmployeeData($ImageData, $value, $userID)) {
                                $errorCount += 1;
                            }
                        } else if (!$obj->updateEmployeeData(htmlspecialchars(trim($_POST["$key"])), $value, $userID)) {
                            $errorCount += 1;
                        }
                    }
                }
                if ($errorCount > 0) {
                    http_response_code(400);
                    $res = "Error executing";
                } else {
                    http_response_code(200);
                    $res = "success";
                }

                header("Content-Type: application/json");
                echo json_encode(["error" => $res]);
            } else {
                if (count($errors) === 0 && count($modifieds) === 0) {
                    $errors['errr'] = "<p>No modification needed.</p>";
                }

                http_response_code(400);
                header("Content-Type: application/json");

                echo json_encode(["error" => $errors['errr']]);
            }
        }
    }


    if (isset($_POST['transac']) && $_POST["transac"] === "editGet") {
        $id = intval(htmlspecialchars(trim($_POST['id'])));


        $obj = new Employees();
        $row = "";
        if (!empty($id)) {
            $row = $obj->getEmployeeDataByID($id);
        } else {
            http_response_code(400);
            $cont = "<p>No result for this refresh the page habibi.";
        }
        $cont = "";
        if ($row) {
            $cont = '
                    <form id="editCashierFrm">
                        <div id="cancelEdit"><i style="transform: rotate(45deg);" class="fas fa-plus"></i></div>
                        <li class="psm">
                            <div class="picSend">
                                <div class="imgss">
                                    <img class="' . $row['userID'] . '" src="data:image/jpeg;base64, ' . base64_encode($row['profilePic']) . '" id="prPicEdit" alt="">
                                </div>
                                <i class="fas fa-plus"></i>
                                <input type="file" id="picmhendpEdit" name="dpEdit" style="visibility: hidden;">
                            </div>
                        </li>
                        <section class="fsecEdit">
                            <h4>Edit Form 1/3</h4>

                            <li>
                                <label for="fnEdit">First name</label>
                                <input id="fnEdit" type="text" value="' . $row['fName'] . '" placeholder="First name..." name="fnEdit">
                            </li>
                            <li>
                                <label for="mnEdit">Middle name</label>
                                <input id="mnEdit" type="text" value="' . $row['mName'] . '" placeholder="Middle name..." name="mnEdit">
                            </li>
                            <li>
                                <label for="lnEdit">Last name</label>
                                <input id="lnEdit" type="text" value="' . $row['lName'] . '" placeholder="Last name.." name="lnEdit">
                            </li>
                            <li>
                                <label for="ageEdit">Age</label>
                                <input id="ageEdit" type="number" value="' . $row['age'] . '" placeholder="Age.." name="ageEdit" min="0">
                            </li>
                            <div class="errtypeEdit"></div>

                            <div class="proceedAction">
                                <button id="nxt1Edit" type="button">Next</button>
                            </div>
                        </section>
                        <section class="msecEdit">
                            <h4>Edit Form 2/3</h4>

                            <li>
                                <label for="cnEdit">Contact no.</label>
                                <input id="cnEdit" type="number" value="' . $row['contactno'] . '" placeholder="Contact no(639).." min="0" name="cnEdit">
                            </li>
                            <li>
                                <label for="bdEdit">Birth date</label>
                                <input id="bdEdit" type="date" value="' . $row['birthdate'] . '" placeholder="Birth date.." name="bdEdit">
                            </li>
                            <li>
                                <label for="emEdit">Email</label>
                                <input id="emEdit" type="text" value="' . $row['email'] . '" placeholder="Email.." name="emEdit">
                            </li>
                            <li>
                                <label for="addrEdit">Address</label>
                                <input id="addrEdit" type="text" value="' . $row['address'] . '" placeholder="Address.." name="addrEdit">
                            </li>
                            <div class="errtypeEdit"></div>
                            <div class="proceedAction">
                                <button id="back1Edit" type="button">Back</button>
                                <button id="nxt2Edit" type="button">Next</button>
                            </div>
                        </section>
                        <section class="lsecEdit">
                            <h4>Edit Form 3/3</h4>

                            <li>
                                <label for="unEdit">User name</label>
                                <input id="unEdit" type="text" value="' . $row['userName'] . '" placeholder="User name.." name="unEdit">
                            </li>
                            <li>
                                <label for="pwEdit">Password</label>
                                <input id="pwEdit" type="password" value="" placeholder="(leave empty if no need changes).." name="pwEdit">
                            </li>
                            <li>
                                <label for="cpwEdit">Confirm password</label>
                                <input id="cpwEdit" type="password" value="" placeholder="(leave empty if no need changes).." name="cpwEdit">
                            </li>
                            <div class="errtypeEdit"></div>

                            <div class="proceedAction">
                                <button id="back2Edit" type="button">Back</button>
                                <button id="submitEdit" type="button">Submit</button>
                            </div>
                        </section>
                    </form>
            ';
            http_response_code(200);
            unset($row['profilePic']);
            unset($row['password']);
            unset($row['userRole']);
        } else {
            http_response_code(400);
            $cont = "<p>No result for this refresh the page habibi.";
        }

        header("Content-Type: application/json");
        echo json_encode(["error" => $cont, "row" => $row]);
    }



    if (isset($_POST['transac']) && $_POST["transac"] === "delAccount") {
        $id = intval(htmlspecialchars(trim($_POST['id'])));
        $obj = new Employees();
        $error = "";
        if (!empty($id)) {
            if ($obj->delCahierAccount($id)) {
                http_response_code(200);
                $error = "success";
            } else {
                http_response_code(400);
                $error = "Error in deleting..";
            }
        } else {
            http_response_code(400);
            $error = "Error in deleting given(NO ID)..";
        }

        header("Content-Type: application/json");
        echo json_encode(["error" => $error]);
    }
    if (isset($_POST['transac']) && $_POST["transac"] === "findEmployee") {
        $name = htmlspecialchars(trim($_POST['name']));
        $page = htmlspecialchars(trim($_POST['page']));

        $obj = new Employees();


        if (!empty($name)) {
            $name = "%" . $name . "%";
        }
        $rows = "";
        try {
            $cont = "";
            $junk = $obj->findEmpGateway($name, $page);
            $rows = $junk['data'];
            http_response_code(200);
            if ($rows) {
                foreach ($rows as $row) {
                    $cont .= '
                <ol>
                        <li class="picselp">
                            <div class="brd">
                                <div class="wrap_pic">
                                    <img src="data:image/jpeg;base64, ' . base64_encode($row['profilePic']) . '" alt="">
                                </div>
                            </div>
                        </li>

                        <li class="infoDD">
                            <data>
                                <p>User Name:</p>
                                <p>' . $row['userName'] . '</p>
                            </data>
                            <data>
                                <p>First Name:</p>
                                <p>' . $row['fName'] . '</p>
                            </data>
                            <data>
                                <p>Middle Name:</p>
                                <p>' . $row['mName'] . '</p>
                            </data>
                            <data>
                                <p>Last Name:</p>
                                <p>' . $row['lName'] . '</p>
                            </data>
                            <data>
                                <p>Age:</p>
                                <p>' . $row['age'] . '</p>
                            </data>
                            <data>
                                <p>Birthdate:</p>
                                <p>' . $row['birthdate'] . '</p>
                            </data>
                            <data>
                                <p>Address:</p>
                                <p>' . $row['address'] . '</p>
                                </data>
                                <data>
                                <p>Contactno:</p>
                                <p>' . $row['fName'] . '</p>
                            </data>
                            <data>
                                <p>Email:</p>
                                <p>' . $row['email'] . '</p>
                            </data>
                            <data>
                                <p>Action:</p>
                                <p class="action" dt="' . $row['userID'] . '">
                                    <button id="editUs"><i class="fas fa-edit"></i> Edit</button>
                                    <button id="delUs"><i class="fas fa-trash"></i> Delete</button>
                                </p>
                            </data>

                            <div class="shw">
                                <button class="smcntrl"><i class="fas fa-arrow-down"></i> Show more.</button>
                            </div>
                        </li>
                    </ol>
                ';
                }
            } else {
                $cont = "<p>No results.</p>";
            }
            $rows = $cont;
        } catch (PDOException $th) {
            http_response_code(400);
            $rows = $th->getMessage();
        }

        header("Content-Type: application/json");
        echo json_encode(["error" => $rows]);
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
