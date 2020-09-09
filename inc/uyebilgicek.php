<?php

$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE uye_steamid=:steamid");
$kullanicisor->execute(array(
  'steamid'=> $_SESSION['steamid']
));
$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

?>