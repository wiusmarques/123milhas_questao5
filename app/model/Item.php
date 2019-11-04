<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
class Item extends Model
{
    private $message;
    private $fails;

    public function __construct($input)
    {
        $rules = [
            'name' => 'required|unique:items,name',
            'elements' => 'required|json',
            'price' => 'required|json',
            'size' => 'required|json',
        ];

        $validator = Validator::make($input, $rules);
        $this->fails = $validator->fails();
        $this->message = $validator->messages();

        $this->setValues($input);
    }

    public function getMessage(){
        return $this->message;
    }

    public function isValid(){
        
        if($this->fails){
            return false;
        }
        $this->message = "Item cadastrado com sucesso";
        return true;
        
    }

    private function setValues($input = []){
        $this->setName($input['name']);
        $this->setElements($input['elements']);
        $this->setPrice($input['price']);
        $this->setSize($input['size']);
    }

    private function setName($name){
        $this->name = $name;
    }

    private function setElements($elements){
        $this->elements = $elements;
    }

    private function setPrice($price){
        $this->price = $price;
    }

    private function setSize($size){
        $this->size = $size;
    }
}
