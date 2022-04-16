<?php

use Phalcon\Mvc\Controller;

/**
 * Index class
 * The first class to be loaded
 */
class ProductsController extends Controller
{
    public function indexAction()
    {
        if ($this->request->has("addProduct")) {
            $data = $this->request->getPost();
            $products = new App\Components\helper();
            $status = $products->insertInProducts($data);
            if ($status)
                $this->response->redirect("products/listProducts");
            else
                $this->view->message = false;
        }
    }
    public function listProductsAction()
    {
        $result = $this->mongoConnection->products->find()->toArray();
        $this->view->data = $result;
    }

    public function deleteAction()
    {

        if ($this->request->has('id')) {
            $id = $this->request->get('id');
            $delRec = $this->mongoConnection->products->deleteOne([
                "_id" => new MongoDB\BSON\ObjectID($id)
            ]);
            $this->response->redirect("products/listProducts");
        }
    }

    public function editAction()
    {

        if ($this->request->has('id')) {
            $id = $this->request->get('id');
            $result = $this->mongoConnection->products->findOne(
                ["_id" => new MongoDB\BSON\ObjectID($id)]
            );
            if ($this->request->has('updateProduct')) {
                $data = $this->request->getPost();
                $products = new App\Components\helper();
                $status = $products->updateProduct($data, new MongoDB\BSON\ObjectID($id));
                if($status)
                {
                    $this->response->redirect("products/listProducts");
                }
            }
            $result = (array)$result;
            $this->view->data = $result;
        }
    }

    public function quickViewAction()
    {
        $id = $this->request->getPost('id');
        $result = $this->mongoConnection->products->findOne(
            [
                "_id" => new MongoDB\BSON\ObjectId($id)
            ]
        );
        echo json_encode($result);
        die;
    }
}
