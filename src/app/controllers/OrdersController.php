<?php

use Phalcon\Mvc\Controller;

/**
 * Index class
 * The first class to be loaded
 */
class OrdersController extends Controller
{
    public function indexAction()
    {
        $res = $this->mongoConnection->products->find()->toArray();
        $this->view->data = $res;
        if ($this->request->has('placeOrder')) {
            $r = $this->request->getPost();
            $products = new App\Components\helper();
            $status = $products->insertInOrders($r);
            if ($status)
                die("order placed successfully");
            else
                die("some error");
        }
    }

    public function getVariationsAction()
    {
        $id = $this->request->getPost('id');
        $res = $this->mongoConnection->products->findOne(
            ["_id" => new MongoDB\BSON\ObjectID($id)]
        );
        echo json_encode($res);
        die;
    }


    public function listAction()
    {
        $result = $this->mongoConnection->orders->find()->toArray();
        $this->view->data = $result;
        if ($this->request->has('Filter')) {
            $r = $this->request->getPost();
            // echo "<pre>";
            // print_r($r);
            // die;
            if (isset($r["status"])) {
                $status =  strtolower($r["status"]);  
                $res = $this->mongoConnection->orders->find(["status" => $status]);
                $this->view->data = $res->toArray();
            } if(isset($r["date"])) {
                $filter =  strtolower($r["date"]);
                $date = date('m/d/Y');
                if($filter == "today")
                {
                $res = $this->mongoConnection->orders->find(["date" => $date]);
                $this->view->data = $res->toArray();
                }
                else if($filter == "this week")
                {
                    $date = date('m/d/Y',strtotime('last Sunday'));
                    $res = $this->mongoConnection->orders->find(["date" => ['$gt' => $date]]);
                    $this->view->data = $res->toArray();
                }
                else if($filter == "this month")
                {
                    $date = date('m/d/Y',strtotime('first day of this month'));
                    $res = $this->mongoConnection->orders->find(["date" => ['$gt' => $date]]);
                    $this->view->data = $res->toArray();
                }
                else if($filter == "custom")
                {
                    $sDate = $r["start"];
                    $eDate = $r["end"];
                    $eDate = date('m/d/Y',strtotime("+1 day"));
                    $res = $this->mongoConnection->orders->find([
                        '$and' => [["date" => ['$gt' => $sDate]], ["date" => ['$lt' => $eDate]]]
                    ]);
                    $this->view->data = $res->toArray();
                }
            }
        }
    }

    public function changeStatusAction()
    {
        $id = $this->request->getPost('id');
        $value = $this->request->getPost('value');
        $value = strtolower($value);
        $this->mongoConnection->orders->updateOne(["_id" => new MongoDB\BSON\ObjectID($id)], ['$set' => ["status" => $value]]);
        die;
    }
}
