<?php
date_default_timezone_set('Europe/Istanbul');

try{
    $db = new PDO('mysql:host=79.98.129.216;dbname=fivem21_market;charset=utf8','fivem21_market','Pr0gramc2');
    $db->query("SET CHARACTER SET utf8_general_ci");
   //echo 'Bağlantı Başarıyla gerçekleştirildi !';
}catch(PDOException $e){

    echo 'Hata: '.$e->getMessage();

}

$ayarsor=$db->prepare("SELECT * FROM ayarlar WHERE ayar_id=:id");
$ayarsor->execute(array(
  'id'=> 1
));
$ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC);

 

?>