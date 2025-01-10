<?php



require_once '../Controller/employeesController.php';
session_start();



if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['transac']) && $_POST['transac'] === "validateP") {
        $fn = htmlspecialchars(trim($_POST['fn']));
        $mn = htmlspecialchars(trim($_POST['mn']));
        $ln = htmlspecialchars(trim($_POST['ln']));
        $age = htmlspecialchars(trim($_POST['age']));

        $errors = [];
        if (empty($fn)) {
            $errors['fn'] = "fname";
        }
        if (empty($mn)) {
            $errors['mn'] = "mname";
        }
        if (empty($ln)) {
            $errors['ln'] = "lname";
        }
        if (empty($age)) {
            $errors['age'] = "age";
        }

        header("Content-Type: application/json");
        if ($errors) {
            echo json_encode(["listErr" => $errors, "res" => "failed", "msg" => "<p>Fill in all fields.</p>"]);
            return;
        }
        if ((int)$age >= 18 && (int)$age <= 50) {
            echo json_encode(["listErr" => "", "res" => "good", "msg" => ""]);
        } else {
            echo json_encode(["listErr" => ["age" => "age"], "res" => "failed", "msg" => "<p>User must be 18 - 50Y/O.</p>"]);
        }
    }



    if (isset($_POST['transac']) && $_POST['transac'] === "executingLoginf") {
        $type = htmlspecialchars(trim($_POST['type']));
        $username = htmlspecialchars(trim($_POST['username']));
        $curpw = htmlspecialchars(trim($_POST['curpw']));
        $npw = htmlspecialchars(trim($_POST['npw']));
        $cnpw = htmlspecialchars(trim($_POST['cnpw']));

        $userID = $_SESSION['userID'];
        $obj = new Employees();
        $errors = [];
        $msg = "";
        $modifieds = [];

        if (empty($username)) {
            $errors['username'] = "username";
        }


        header("Content-Type: application/json");
        if ($errors) {
            echo json_encode(["listErr" => $errors, "res" => "failed", "msg" => "<p>Fill in all fields.</p>"]);
            return;
        }




        $org = "";
        if (!empty($userID)) {
            $org = $obj->getAdminData($userID);
        } else {
            http_response_code(200);
            $cont = "<p>No result for this refresh the page habibi.";
            echo json_encode(["listErr" => "", "res" => "failed", "msg" => $cont]);
        }

        if (isNotSame($org['userName'], $username)) {
            $modifieds['userName'] = $username;
        }

        if (isset($modifieds["userName"])) {
            if ($obj->getUserEdData($username)) {
                $errors[] = "userName";
                $msg = "<p>Username already used.</p>";
            }
        }

        if ($errors) {
            echo json_encode(["listErr" => $errors, "res" => "failed", "msg" => $msg]);
            return;
        }


        if (!empty($curpw)) {
            if (!password_verify($curpw, $org['password'])) {
                $errors[] = "curpw";
                $msg = "<p>Incorrect password.</p>";
            }
            if ($errors) {
                echo json_encode(["listErr" => $errors, "res" => "failed", "msg" => $msg]);
                return;
            }

            if (empty($npw)) {
                $errors["curpwD"] = "curpwD";
                $errors["npw"] = "npw";
            }
            if (empty($cnpw)) {
                $errors["curpwD"] = "curpwD";
                $errors["cnpw"] = "cnpw";
            }
            if ($errors) {
                echo json_encode(["listErr" => $errors, "res" => "failed", "msg" => "<p>Fill in all fields.</p>"]);
                return;
            }

            $lengthPw = strlen($npw);
            $lengthPw = intval($lengthPw);

            if ($npw === $cnpw) {
                if (!($lengthPw >= 8 && $lengthPw <= 16)) {
                    $msg = "<p>Password must be 8 - 16 characters only.</p>";
                    $errors = [
                        "curpwD" => "curpwD",
                        "npw" => "npw",
                        "cnpw" => "cnpw",
                    ];
                } else {
                    $modifieds['password'] = $npw;
                }
            } else {
                $errors = [
                    "curpwD" => "curpwD",
                    "npw" => "npw",
                    "cnpw" => "cnpw",
                ];
                $msg = "<p>Password didn't match.</p>";
            }

            if ($errors) {
                echo json_encode(["listErr" => $errors, "res" => "failed", "msg" => $msg]);
                return;
            }
        } else {

            if (
                !empty($npw) ||
                !empty($cnpw)
            ) {
                $errors[] = "curpw";
                $msg = "<p>Verify the current password.</p>";
            }

            if ($errors) {
                echo json_encode(["listErr" => $errors, "res" => "failed", "msg" => $msg]);
                return;
            }
        }


        if ($modifieds) {
            $res = "good";
            $action = "";
            $msg = "";
            $listGood = [];
            if ($type === "validate") {
                $msg = '<p style="color:#03d503">Ready for changes...</p>';
                $action = "validated";
                if (isset($modifieds["password"])) {
                    $listGood = [
                        "npw" => "npw",
                        "cnpw" => "cnpw",
                    ];
                }
            } else if ($type === "execute") {
                $errorCount = 0;
                if (isset($modifieds['password'])) {
                    $options = [
                        'cost' => 12
                    ];
                    $password = password_hash($npw, PASSWORD_BCRYPT, $options);
                    $modifieds["password"] = $password;
                }
                foreach ($modifieds as $key => $value) {
                    if ($key === "userName") {
                        $_SESSION["userName"] = $value;
                    }

                    if (!$obj->updateUserData($value, $key, $userID)) {
                        $errorCount += 1;
                    }
                }
                if ($errorCount > 0) {
                    $msg = "User updation failed...";
                    $action = "executionFailed";
                } else {
                    $action = "executed";
                    $msg = "User updated successfully...";
                }
            }
            echo json_encode(["listGood" => $listGood, "listErr" => "", "res" => $res, "action" => $action, "msg" => $msg]);
        } else {
            echo json_encode(["listErr" => "", "res" => "failed", "msg" => "<p>No changes made.</p>"]);
        }
    }



    if (isset($_POST['transac']) && $_POST['transac'] === "executingAd") {
        $type = htmlspecialchars(trim($_POST['type']));
        $aname = htmlspecialchars(trim($_POST['aname']));
        $email = htmlspecialchars(trim($_POST['email']));

        $userID = $_SESSION['userID'];

        $errors = [];
        if (empty($aname)) {
            $errors['name'] = "aname";
        }

        if (empty($email)) {
            $errors['email'] = "email";
        }

        header("Content-Type: application/json");
        if ($errors) {
            echo json_encode(["go" => 1, "listErr" => $errors, "res" => "failed", "msg" => "<p>Fill in all fields.</p>"]);
            return;
        }


        $obj = new Employees();
        $modifieds = [];
        $errorsS = "";
        $msg = "";

        $userID = $_SESSION['userID'];
        $org = "";
        if (!empty($userID)) {
            $org = $obj->getAdminData($userID);
        } else {
            http_response_code(200);
            $cont = "<p>No result for this refresh the page habibi.";
            echo json_encode(["listErr" => "", "res" => "failed", "msg" => $cont]);
        }

        if (isNotSame($org['email'], $email)) {
            $modifieds['email'] = $email;
        }

        if (!($obj->is_invalid_email($email))) {
            if (isset($modifieds['email'])) {
                if ($obj->isEmailExist($email)) {
                    $msg =  "<p>Email already in used.</p>";
                    $errorsS = "email";
                }
            }
        } else {
            $msg =  "<p>Invalid email.</p>";
            $errorsS = "email";
        }

        if ($errorsS) {
            echo json_encode(["go" => 1, "listErr" => $errorsS, "res" => "failed", "msg" => $msg]);
            return;
        }


        if (isNotSame($org['name'], $aname)) {
            $modifieds['name'] = $aname;
        }




        if ($modifieds) {
            $res = "good";
            $action = "";
            $msg = "";
            if ($type === "validate") {
                $msg = '<p style="color:#03d503">Ready for changes...</p>';
                $action = "validated";
            } else if ($type === "execute") {
                $errorCount = 0;
                foreach ($modifieds as $key => $value) {
                    if ($key === "email") {
                        if (!$obj->updateUserData($value, $key, $userID)) {
                            $errorCount += 1;
                        }
                    } else {
                        if (!$obj->updateAdminData($value, $key, $userID)) {
                            $errorCount += 1;
                        }
                    }
                }
                if ($errorCount > 0) {
                    $msg = "User updation failed...";
                    $action = "executionFailed";
                } else {
                    $action = "executed";
                    $msg = "User updated successfully...";
                }
            }
            echo json_encode(["listErr" => "", "res" => $res, "action" => $action, "msg" => $msg]);
        } else {

            echo json_encode(["listErr" => "", "res" => "failed", "msg" => "<p>No changes made.</p>"]);
        }
    }



    if (isset($_POST['transac']) && $_POST['transac'] === "executingEm") {
        $fn = htmlspecialchars(trim($_POST['fn']));
        $mn = htmlspecialchars(trim($_POST['mn']));
        $ln = htmlspecialchars(trim($_POST['ln']));
        $age = htmlspecialchars(trim($_POST['age']));

        $bd = htmlspecialchars(trim($_POST['bd']));
        $email = htmlspecialchars(trim($_POST['email']));
        $cn = htmlspecialchars(trim($_POST['cn']));
        $addr = htmlspecialchars(trim($_POST['addr']));

        $imgChange = htmlspecialchars(trim($_POST['imgChange']));
        $type = htmlspecialchars(trim($_POST['type']));

        $errorsF = [];
        if (empty($fn)) {
            $errorsF['fn'] = "fname";
        }
        if (empty($mn)) {
            $errorsF['mn'] = "mname";
        }
        if (empty($ln)) {
            $errorsF['ln'] = "lname";
        }
        if (empty($age)) {
            $errorsF['age'] = "age";
        }

        header("Content-Type: application/json");
        if ($errorsF) {
            echo json_encode(["go" => 1, "listErr" => $errorsF, "res" => "failed", "msg" => "<p>Fill in all fields.</p>"]);
            return;
        }
        if ((int)$age >= 18 && (int)$age <= 50) {
        } else {
            echo json_encode(["go" => 1, "listErr" => ["age" => "age"], "res" => "failed", "msg" => "<p>User must be 18 - 50Y/O.</p>"]);
            return;
        }

        $product_image = "";
        $msg = "";
        $imgerr = 0;
        if (isset($_FILES['imgSelect']) && $_FILES['imgSelect']['error'] == 0) {

            $image_file_type = strtolower(pathinfo($_FILES['imgSelect']['name'], PATHINFO_EXTENSION));
            $fileSize = $_FILES['imgSelect']['size'];

            $maxFileSize = 3 * 1024 * 1024;
            $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
            if (!in_array($image_file_type, $allowed_types)) {
                $msg = '<p>Invalid format ( <b style="font-size:1rem;">jpg, png, jpeg, gif</b> )</p>';
                $imgerr += 1;
            } else {
                if ($fileSize <= $maxFileSize) {
                    $product_image = file_get_contents($_FILES['imgSelect']['tmp_name']);
                } else {
                    $imgerr += 1;
                    $msg = "<p>The file size exceeds the maximum allowed limit (3 MB)!</p>";
                }
            }
        } else {
            $msg = "<p>Please insert image of cashier.</p>";
            $imgerr += 1;
        }

        if ($imgerr > 0) {
            echo json_encode(["listErr" => ["img" => "img"], "res" => "failed", "msg" => $msg]);
            return;
        }

        $errorsL = [];
        $errorsS = "";
        if (empty($bd)) {
            $errorsL['bd'] = "Birthdate";
        }
        if (empty($addr)) {
            $errorsL['addr'] = "Address";
        }
        if (empty($cn)) {
            $errorsL['cn'] = "Contactno";
        }
        if (empty($email)) {
            $errorsL['email'] = "email";
        }


        if ($errorsF) {
            echo json_encode(["listErr" => $errorsF, "res" => "failed", "msg" => "<p>Fill in all fields.</p>"]);
            return;
        }
        $obj = new Employees();



        $userID = $_SESSION['userID'];
        $role = $_SESSION['userRole'];

        $bdcal = new DateTime($bd);
        $today = new DateTime();
        $ageBD = $today->diff($bdcal)->y;
        $obj = new Employees();
        $org = "";
        if (!empty($userID)) {
            $org = $obj->getEmployeeDataByID($userID);
        } else {
            http_response_code(200);
            $cont = "<p>No result for this refresh the page habibi.";
            echo json_encode(["listErr" => "", "res" => "failed", "msg" => $cont]);
        }

        $modifieds = [];
        if (isNotSame($org['email'], $email)) {
            $modifieds['email'] = $email;
        }

        if ((int)$ageBD == (int)$age) {
            if (preg_match('/^639\d{9}$/', $cn)) {
                if (!($obj->is_invalid_email($email))) {
                    if (isset($modifieds['email'])) {
                        if ($obj->isEmailExist($email)) {
                            $msg =  "<p>Email already in used.</p>";
                            $errorsS = "email";
                        }
                    }
                } else {
                    $msg =  "<p>Invalid email.</p>";
                    $errorsS = "email";
                }
            } else {
                $msg =  "<p>Enter a valid and 11 digits CP no.</p>";
                $errorsS = "Contactno";
            }
        } else {
            $msg =  "<p>Age and Birth Year doesn't match.</p>";
            $errorsS = "Birthdate";
        }


        if ($errorsS) {
            echo json_encode(["listErr" => $errorsS, "res" => "failed", "msg" => $msg]);
            return;
        }

        if (isNotSame($org['fName'], $fn)) {
            $modifieds['fName'] = $fn;
        }
        if (isNotSame($org['mName'], $mn)) {
            $modifieds['mName'] = $mn;
        }
        if (isNotSame($org['lName'], $ln)) {
            $modifieds['lName'] = $ln;
        }
        if (isNotSame($org['age'], $age)) {
            $modifieds['age'] = $age;
        }


        if (isNotSame($org['birthdate'], $bd)) {
            $modifieds['birthdate'] = $bd;
        }
        if (isNotSame($org['contactno'], $cn)) {
            $modifieds['contactno'] = $cn;
        }
        if (isNotSame($org['email'], $email)) {
            $modifieds['email'] = $email;
        }
        if (isNotSame($org['address'], $addr)) {
            $modifieds['address'] = $addr;
        }

        if ($imgChange > 0) {
            $modifieds['profilePic'] = $product_image;
        }



        if ($modifieds) {
            $res = "good";
            $action = "";
            $msg = "";
            if ($type === "validate") {
                $msg = '<p style="color:#03d503">Ready for changes...</p>';
                $action = "validated";
            } else if ($type === "execute") {
                $errorCount = 0;
                foreach ($modifieds as $key => $value) {
                    if ($key === "email") {
                        if (!$obj->updateUserData($value, $key, $userID)) {
                            $errorCount += 1;
                        }
                    } else {
                        if (!$obj->updateEmployeeData($value, $key, $userID)) {
                            $errorCount += 1;
                        }
                    }
                }
                if ($errorCount > 0) {
                    $msg = "Info updation failed...";
                    $action = "executionFailed";
                } else {
                    $action = "executed";
                    $msg = "Info updated successfully...";
                }
            }

            echo json_encode(["listErr" => "", "res" => $res, "action" => $action, "msg" => $msg]);
        } else {

            echo json_encode(["listErr" => "", "res" => "failed", "msg" => "<p>No changes made.</p>"]);
        }
    }









    if (isset($_POST['transac']) && $_POST['transac'] === "getForm") {

        $type = htmlspecialchars(trim($_POST['formType']));


        $id = $_SESSION['userID'];
        $role = $_SESSION['userRole'];
        $obj = new Employees();

        $form = "";
        $org = "";
        if ($type === "personalData") {
            $data = "";
            if ($role === "Admin") {
                $data = $obj->getAdminPersonalDataEdit($id);
                $form = getAdminPersonInfo($data);
                $data = [
                    "name" => $data['name'],
                    "email" => $data['email']
                ];
            } else if ($role === "Employee") {
                $data = $obj->getEmpPersonalDataEdit($id);
                $form = getPersonInfo($data);
                unset($data['password'], $data['userRole'], $data['employeeID'], $data['email'], $data['userID'], $data['profilePic']);
            }
            $org = $data;
        } else if ($type === "loginData") {
            $data = $obj->getUserLoginDataEdit($id);
            $form = getLoginInfo($data);
            unset($data['userID']);
            $org = $data;
        }




        header("Content-Type: application/json");
        echo json_encode(["form" => $form, "formType" => $type, "orgData" => $org]);
    }
}



function getLoginInfo($data)
{

    return '
    <form id="changepw">
    <div class="headgg">
        <h3  dt="' . $data['userID'] . '" class="dta" ><i class="fas fa-key"></i> Change login credentials</h3>
        <button type="button" id="exitEditPw" title="Cancel">
            <i class="fas fa-plus" title="Cancel"></i>
        </button>
    </div>
    <li>
        <i class="fas fa-user"></i>
        <input autocomplete="off" value="' . $data['userName'] . '"   id="username" name="username" type="text" placeholder="Username...">
        <label for="username">Username</label>
    </li>
    <li>
        <i class="fas fa-key"></i>
        <input id="curpw" name="curpw" type="password" placeholder="Current (leave empty if no need)...">
        <label for="curpw">Current password</label>
    </li>
    <li>
        <i class="fas fa-user-cog"></i>
        <input id="npw" name="npw" type="password" placeholder="New (leave empty if no need)...">
        <label for="npw">New password</label>
    </li>
    <li>
        <i class="fas fa-user-cog"></i>
        <input id="cnpw" name="cnpw" type="password" placeholder="Confirm (leave empty if no need)...">
        <label for="cnpw">Confirm new password</label>
    </li>
    <button type="submit" class="logG" value="validate" id="validateNPW"><i class="fas fa-check-square"></i> Validate</button>
</form>
<div class="responseCpw">
    <p></p>
</div>
    
    ';
}
// submitNPW

function getAdminPersonInfo($data)
{

    return '
        <form id="changeAdpinfo">
            <div class="headgg">
                <h3 dt="' . $data['adminID'] . '" class="dta" ><i class="fas fa-key"></i> Edit personal info</h3>
                <button type="button" id="exitEditPw" title="Cancel">
                    <i class="fas fa-plus" title="Cancel"></i>
                </button>
            </div>
                <li>
                    <i class="fas fa-user"></i>
                    <input id="aname" name="aname" type="text" value="' . $data['name'] . '" placeholder="Name...">
                    <label for="aname">Name</label>
                </li>
                <li>
                    <i class="fas fa-envelope"></i>
                    <input id="email" name="email" type="text" value="' . $data['email'] . '" placeholder="Email...">
                    <label for="email">Email</label>
                </li>
                <button type="submit" value="validate" class="adIn" id="valFAd"><i class="fas fa-check-square"></i> Validate</i></button>
        </form>
        <div class="responseCPINFO">
        </div>
    ';
}
// valFAd
// submitFAd


function getPersonInfo($data)
{

    return '
        <form id="changepinfo">
            <div class="headgg">
                <h3><i class="fas fa-key"></i> Edit personal info</h3>
                <button type="button" id="exitEditPw" title="Cancel">
                    <i class="fas fa-plus" title="Cancel"></i>
                </button>
            </div>
            <div class="dpSec">
                <div class="selP">
                    <div class="imgwrSet">
                        <img src="data:image/jpeg;base64, ' . base64_encode($data['profilePic']) . '" id="dpf" dt="' . $data['employeeID'] . '" class="dta" alt="">
                    </div>
                    <label for="imgSelect"><i class="fas fa-plus"></i></label>
                </div>
                <input type="file" id="imgSelect" name="imgSelect">
            </div>
            <div class="firstForm dpl">
                <li>
                    <i class="fas fa-user"></i>
                    <input id="fname" name="fn" type="text" value="' . $data['fName'] . '" placeholder="First name...">
                    <label for="First name">First name</label>
                </li>
                <li>
                    <i class="fas fa-user"></i>
                    <input id="mname" name="mn" type="text" value="' . $data['mName'] . '"  placeholder="Middle name...">
                    <label for="Middle name">Middle name</label>
                </li>
                <li>
                    <i class="fas fa-user"></i>
                    <input id="lname" name="ln" type="text" value="' . $data['lName'] . '"  placeholder="Last name...">
                    <label for="Last name">Last name</label>
                </li>
                <li>
                    <i class="fas fa-user"></i>
                    <input id="age" name="age" type="text" value="' . $data['age'] . '" placeholder="Age...">
                    <label for="Age">Age</label>
                </li>
                <button type="button" id="valF">Next <i class="fas fa-arrow-right"></i></button>
            </div>

            <div class="secondForm">
                <li style="
    width: 100%;
">
                    <i class="fas fa-user"></i>
                    <input id="Birthdate" name="bd" type="date" value="' . $data['birthdate'] . '"  placeholder="Birthdate...">
                    <label for="Birthdate">Birthdate</label>
                </li>
                <li>
                    <i class="fas fa-user"></i>
                    <input id="Address" name="addr" type="text" value="' . $data['address'] . '" placeholder="Address...">
                    <label for="Address">Address</label>
                </li>
                <li>
                    <i class="fas fa-user"></i>
                    <input id="Contactno" name="cn" type="text" value="' . $data['contactno'] . '" placeholder="Contact no(639)...">
                    <label for="Contact no">Contact no</label>
                </li>
                <li>
                    <i class="fas fa-user"></i>
                    <input id="email" name="email" type="text" value="' . $data['email'] . '" placeholder="Email...">
                    <label for="email">Name</label>
                </li>
                <div class="botD">
                    <button type="button" id="backCPINFO"><i class="fas fa-arrow-left"></i> Back</button>
                    <button type="button" class="sbon" value="validate" id="validateCPINFO"><i class="fas fa-check-square"></i> Validate</button>
                </div>
            </div>


        </form>
        <div class="responseCPINFO">
        </div>
    ';
    // submitCPINFO
    // validateCPINFO
}


function isNotSame($org, $test)
{
    if ($org != $test) {
        return true;
    }
    return false;
}
