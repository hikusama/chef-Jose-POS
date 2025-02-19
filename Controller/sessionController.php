<?php
require_once '../model/classModel.php';

class SessionController extends Model
{

    private $userID;
    private $sessionToken;

    public function __construct($userID, $sessionToken) {
        $this->userID = $userID;
        $this->sessionToken = $sessionToken;
    }

    public function getSessionGate(){
        return $this->getSession($this->userID,$this->sessionToken);
    }

}