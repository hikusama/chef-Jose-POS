<?php
require_once '../Model/classModel.php';

class HistoryController extends Model
{
    private $ref;
    private $orderID;

    public function __construct($orderID, $ref)
    {
        $this->orderID = $orderID;
        $this->ref = $ref;
    }

    public function groupFind($date,$page) {
        return $this->getOrders($this->ref,$date,$page);
    }
    
    public function getOrderRecordControll() {
        return $this->getOrderRecord($this->ref);
    }

}
