<?php

namespace App\Components;

use Phalcon\Di\Injectable;

class helper extends Injectable
{

    public function insertInProducts($data)
    {

        $details = $this->getAdditional($data);
        $varient = $this->getVariations($data);
       
        $arr = [
            "Name" => $data['name'],
            "Category" => $data['categoryName'],
            "price" => $data['price'],
            "stock" => $data['stock'],
            "additional" => $details,
            "variations" => $varient
        ];
        $this->mongoConnection->products->insertOne($arr);
        return true;
    }

    public function insertInOrders($data)
    {
        print_r($data);
        $date = date('m/d/Y'); 
        $arr = [
            "Name" => $data['customerName'],
            "quantity" => (int)$data['quantity'],
            "product" => $data['product'],
            "varient" => $data['varient'],
            "price" => $data['price'],
            "total" => $data["price"]*$data["quantity"],
            "date" => $date,
            "status" => "paid"
        ];
        $this->mongoConnection->orders->insertOne($arr);
        return true;
    }


    public function updateProduct($data, $id)
    {
        $details = $this->getAdditional($data);
        $varient = $this->getVariations($data);

        $arr = [
            "Name" => $data['name'],
            "Category" => $data['categoryName'],
            "price" => $data['price'],
            "stock" => $data['stock'],
            "additional" => $details,
            "variations" => $varient
        ];
        $this->mongoConnection->products->updateOne(["_id" => $id], ['$set' => $arr]);
        return true;
    }

    public function getAdditional($data)
    {
        $keys = array_keys($data);
        $r = 1;
        $details = [];
        for ($i = 0; $i < count($data); $i++) {
            //-----------------------------------If any additional fields present ------------------------------//
            if (str_contains($keys[$i], 'label-')) {
                $details += [
                    $data["label-" . $r] => $data["value-" . $r]
                ];
                $r++;
            }
        }
        return $details;
    }

    public function getVariations($formdata)
    {
        $variation = [];
        $a = 1;
        while ($a > 0) {
            $n = 1;
            if (isset($formdata["labelV-$a-$n"])) {
                $variation += [
                    $a - 1 => array("price" => $formdata["priceV-$a"])
                ];
                for ($n = 1; $n < 10; $n++) {
                    if (array_key_exists("labelV-$a-$n", $formdata)) {
                        $variation[$a - 1] += array(
                            $formdata["labelV-$a-$n"] => $formdata["valueV-$a-$n"],
                        );
                    } else {
                        break;
                    }
                }
            } else {
                break;
            }
            $a++;
        }
        echo "<pre>";
        print_r($variation);
         foreach ($variation as $key => $value) {
            
         }
        die;
        return $variation;
    }
}
