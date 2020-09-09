<?php

 

    $orderID = "42331";
    $hash = "7b9b282f6958ad3c64d86bea743c9831";

    $ch = curl_init('https://www.payhesap.com/api/pay/checkOrder');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, array('hash' => $hash));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);;
    $result = json_decode(curl_exec($ch));
    echo $result.'<br>';
    //$orderID ile siparişinizn işlemlerini yapabilirsiniz
    if($result['STATUS'] == 1 ){
        echo 'Ödeme Başarılı';
    }else{
        echo 'Ödeme Başarısız';
    }


 




