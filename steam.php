<?php
include "inc/db.php";
require 'steamauth/steamauth.php';

if(isset($_SESSION['steamid'])) {
	$steamid=$_SESSION['steamid'];
	$row = $db->query("SELECT * FROM uyeler WHERE uye_steamid = '{$steamid}'")->fetch(PDO::FETCH_ASSOC);
	if ( $row ){
		//print_r($row);
		//echo '<br>';
		//print_r($row['eposta']);
		$_SESSION['sess_user_id']   = $row['uye_id'];
		$_SESSION['sess_user_eposta'] = $row['uye_mail'];
		$_SESSION['sess_durum'] = $row['uye_durum'];
		$_SESSION['sess_urunsayisi'] = $row['uye_urunsayisi'];
		$_SESSION['sess_yetki'] = $row['uye_yetki'];
		$_SESSION['sess_uyebakiye'] = $row['uye_bakiye'];
		$uyeno=$row['uye_id'];
		include 'themes/yukleniyor.php';
		header("refresh:1;url=index.php");//veya site içi bir sayfa
		exit;
	}else{
		require ('steamauth/userInfo.php');	
		//echo 'Şuan için kayıt oluşturamıyoruz. Lütfen 22:00 da tekrar gelin.';

		$query = $db->prepare("INSERT INTO uyeler SET
			uye_steamid = :steamid,
			uye_steamisim = :uye_steamisim");
		$insert = $query->execute(array(
			"steamid" => $steamid,
			"uye_steamisim" => $steamprofile['personaname']
		));
		if ( $insert ){
			$last_id = $db->lastInsertId();
			//print "insert işlemi başarılı!";
			$row = $db->query("SELECT * FROM uyeler WHERE uye_steamid = '{$steamid}'")->fetch(PDO::FETCH_ASSOC);
			if ( $row ){
				$_SESSION['sess_user_id']   = $row['uye_id'];
				$_SESSION['sess_user_eposta'] = $row['uye_mail'];
				$_SESSION['sess_durum'] = $row['uye_durum'];
				$_SESSION['sess_urunsayisi'] = $row['uye_urunsayisi'];
				$_SESSION['sess_yetki'] = $row['uye_yetki'];
				$_SESSION['sess_uyebakiye'] = $row['uye_bakiye'];
				$uyeno=$row['uye_id'];
				include 'themes/yukleniyor.php';
				header("refresh:2;url=index.php");//veya site içi bir sayfa
				exit;
			}
		}
	}

}else {
//Giriş Yapmamış Kullanıcı.
	header("location: index.php");
	exit;

}
exit;
?>