<?php

namespace  App\Resolvers;
use  App\Models\PaymentPlatform;
use  Exception;
class PaymentPlatformResolver{

    protected $paymentPlatforms;

    public function __construct(){
        $this->paymentPlatforms = PaymentPlatform::all();
    }

    public function  resolveService($paymentPlatformId){

        $name =  strtolower($this->paymentPlatforms->firstWhere('id',$paymentPlatformId)->name); //donde coincida y saca nombre

        $service = config("services.{$name}.class");

        if($service){
            return resolve($service); //
        }

        throw new Exception("the selected platform is not in the configuration",1);
    }
}
