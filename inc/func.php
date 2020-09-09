<?php
//@session_start();
function seo($text) {
    $find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
    $replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
    $text = strtolower(str_replace($find, $replace, $text));
    $text = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $text);
    $text = trim(preg_replace('/\s+/', ' ', $text));
    $text = str_replace(' ', '-', $text);

    return $text;
}


function sessionKontrol(){
	if (!isset($_SESSION['steamid'])) {
		session_destroy();
		Header("Location:index.php?durum=kayitlidegilsin");
	}else{
		require 'db.php';
		$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE uye_steamid=:steamid");
		$kullanicisor->execute(array(
			'steamid'=> $_SESSION['steamid']
		));
		$say=$kullanicisor->rowCount();
		$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

		if ($say==0) {
			Header("Location:index.php?durum=izinsiz");

		}else{
			//echo $say;
		}
	}


	function guvenlik($gelen){
		$giden=strip_tags($gelen);
		return htmlspecialchars($giden);
	}

	function randomNumber($length)
	{
		$output = '';
		for($i = 0; $i < $length; $i++) {
			$output .= mt_rand(0, 9);
		}

		return $output;
	}

	function BuyukHarfCevir($text) 
	{
		$text = trim($text);
		$search = array('ç','ğ','ı','ö','ş','ü','i');
		$replace = array('Ç','Ğ','I','Ö','Ş','Ü','İ');
		$new_text = str_replace($search,$replace,$text);
		return mb_strtoupper($new_text);
	}

	function bildirimOlustur($mesaj,$uyeid){
		require $_SERVER['DOCUMENT_ROOT'].'/market/inc/db.php';
		$query = $db->prepare("INSERT INTO bildirim SET
			bildirim_detay = :bildirim_detay,
			bildirim_kime = :bildirim_kime");
		$insert = $query->execute(array(
			"bildirim_detay" => $mesaj,
			"bildirim_kime" => $uyeid,
		));
		if ( $insert ){
			return true;
		}else{
			return false;
		}	

	}
	function smsGonder($mesaj,$ceptel){

		$postUrl="http://sms.bizimsms.mobi:8080/api/smspost/v1"; 

		$postData="". "<sms>". "<username>*****</username>". "<password>******</password>". "<header>S.SILISTRE</header>". "<validity>***</validity>". "<message>". "<gsm>". "<no>".$ceptel."</no>". "</gsm>". "<msg>".$mesaj."</msg>". "</message>". "</sms>"; 

		$ch=curl_init(); curl_setopt($ch,CURLOPT_URL,$postUrl); curl_setopt($ch,CURLOPT_POSTFIELDS,$postData); curl_setopt($ch,CURLOPT_POST,1); curl_setopt($ch,CURLOPT_TIMEOUT,5); curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); curl_setopt($ch,CURLOPT_HTTPHEADER,Array("Content-Type: text/xml; charset=UTF-8")); 

		$response=curl_exec($ch); curl_close($ch); 

		return '['.$response.']'."\n"; 



	}

	function discordMesaj($message,$webhook)
{
    $data = array("content" => $message, "username" => "FivemCode Market Sistemi");
    $curl = curl_init($webhook);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    return curl_exec($curl);
}
}
?>
