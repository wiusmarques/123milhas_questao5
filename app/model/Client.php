<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class Client extends Model
{

    private $message;
    private $fails;

    public function __construct($input)
    {
        $this->validateInput($input);
    }

    private function validateInput($input = []){
        
        $rules = [
            'name' => 'required',
            'phone_number' => 'required|unique:clients,phone_number',
            'cep' => 'required|integer',
            'address' => 'required',
            'address_number' => 'required'
        ];

        $validator = Validator::make($input, $rules);
        $this->fails = $validator->fails();
        $this->message = $validator->messages();

        $this->setValues($input);
    }

    private function setValues($input = []){
        $this->setName($input['name']);
        $this->setPhoneNumber($input['phone_number']);
        $this->setCep($input['cep']);
        $this->setAddress($input['address']);
        $this->setAddressNumber($input['address_number']);
    }

    private function setName($name){
        $this->name = $name;
    }

    private function setPhoneNumber($phone_number){
        $this->phone_number = $phone_number;
    }

    private function setCep($cep){
        $this->cep = $cep;
    }

    private function setAddress($address){
        $this->address = $address;
    }

    private function setAddressNumber($address_number){
        $this->address_number = $address_number;
    }

    public function getMessage(){
        return $this->message;
    }

    public function isValid(){
        
        if($this->fails){
            return false;
        }
        $this->message = "Cliente cadastrado com sucesso";
        return true;
        
    }
}
