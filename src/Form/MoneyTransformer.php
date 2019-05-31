<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 31.05.19
 * Time: 20:03
 */

namespace App\Form;


use Symfony\Component\Form\CallbackTransformer;

class MoneyTransformer extends CallbackTransformer
{
    public function __construct()
    {
        parent::__construct(
            function ($valueCents){
                return sprintf('%0.2f', $valueCents/100);
            },
            function ($value){
                return is_numeric($value) ? round($value*100) : $value;
            });
    }
}