<?php
require_once '../Model/classModel.php';

class ReportstController extends Model
{

    /*               todays data                 */


    public function tsqData()
    {
        return $this->getSquaredData();
    }


    public function tcatData()
    {
        return $this->todayCatData();
    }


    public function twkData()
    {
        return $this->weekDataTSec();
    }


    /*               customize or finding data                 */


    public function cssqData($starting, $ending)
    {
        return $this->getCSSquaredData($starting, $ending);
    }
    public function cscatData($starting, $ending)
    {
        return $this->getCatCSData($starting, $ending);
    }
    public function csLineData($type, $date)
    {
        return $this->singleRangeDataCS($type, $date);
    }



    /*               analytics data                 */

    // other func
    public function getDataItem($itemtype, $order, $range, $data,$page)
    {
        return $this->itemsReport($itemtype, $order, $range, $data,$page);
    }
    
    
    public function getDataItemAnalSpec($itemtype,$range,$data,$spec)
    {
        return $this->itemsReportDataAnalytics($itemtype,$range,$data,$spec);
    }
}
