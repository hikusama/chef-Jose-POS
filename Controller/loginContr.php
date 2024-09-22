<?php
require_once '../Model/classModel.php';

class Logincontr extends Model {
    private $username;
    private $password;
    private $errors = array();

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function loginUser() {

        if (!empty($this->errors)) {
            $errorString = implode(",", $this->errors);
            header("Location: ../index.php?error=" . urlencode($errorString));
            exit();
        }

        $this->getUser($this->username, $this->password);
    }

}