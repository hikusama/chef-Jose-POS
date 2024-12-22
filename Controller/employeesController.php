<?php
require_once '../Model/classModel.php';

class Employees extends Model
{

    public function isUserNameExist($un)
    {
        if ($this->unExist($un)) {
            return true;
        } else {
            return false;
        }
    }

    public function isEmailExist($em)
    {
        if ($this->emailExist($em)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function is_invalid_email($em)
    {
        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    
    
    public function addCashierAccGate($info)
    {
        return $this->addCahier($info);
    }

}
