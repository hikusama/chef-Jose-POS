<?php
require_once '../Model/classModel.php';

class OverviewController extends Model
{


    public function countOrdersGateWay()
    {
        return $this->countOrders();
    }


    public function graphDataGateway()
    {
        return $this->graphData();
    }

    
    public function topProdGateWay()
    {
        return $this->topProd();
    }


    public function pieDataGateWay()
    {
        return $this->pieData();
    }


    public function salesGateWay()
    {
        return $this->salesPackData();
    }
    public function discountGateWay()
    {
        return $this->discountData();
    }


}
