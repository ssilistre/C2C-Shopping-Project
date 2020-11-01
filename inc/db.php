<?php
date_default_timezone_set('Europe/Istanbul');

try{
    $db = new PDO('mysql:host=*****;dbname=******;charset=utf8','*****','****');
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
