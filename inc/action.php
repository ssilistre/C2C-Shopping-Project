<?php
session_start();
//////Düzeltilecek yerler
require 'func.php';
require 'db.php';
include 'uyebilgicek.php';
 /////////////

sessionKontrol();


if(isset($_POST['tcdorula']) ){

	$uyesteamid=$_SESSION['steamid'];

	$yas=date('Y')-guvenlik($_POST['uye_dogumyili']);
	$komisyon=10;
	
	if ($yas<=17) {
		echo $komisyon=20;
	}

//guvenlik($_POST['uye_ad']),guvenlik($_POST['uye_soyad'])
/*echo guvenlik($_POST['uye_soyad']);
echo '<br>';
echo guvenlik($_POST['uye_tc']);
echo '<br>';
echo guvenlik($_POST['uye_ad']);
echo '<br>';
echo guvenlik($_POST['uye_dogumyili']);
echo '<br>';*/
$client = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");
try {
	$result = $client->TCKimlikNoDogrula([
		'TCKimlikNo' => guvenlik($_POST['uye_tc']),
		'Ad' => BuyukHarfCevir(guvenlik($_POST['uye_ad'])),
		'Soyad' => BuyukHarfCevir(guvenlik($_POST['uye_soyad'])),
		'DogumYili' => guvenlik($_POST['uye_dogumyili'])
	]);
	if ($result->TCKimlikNoDogrulaResult) {
		echo 'T.C. Kimlik No Doğru';
		echo $uyesteamid;
		$adsoyad=guvenlik($_POST['uye_ad']).' '.guvenlik($_POST['uye_soyad']);
		$profilguncelle=$db->prepare("UPDATE uyeler SET
			uye_tc=:uye_tc,
			uye_adsoyad=:uye_adsoyad,
			uye_komisyon=:uye_komisyon,
			uye_durum=:uye_durum WHERE uye_steamid='$uyesteamid'");

		$update=$profilguncelle->execute(array(
			':uye_tc' => guvenlik($_POST['uye_tc']),
			':uye_adsoyad' => $adsoyad,
			':uye_komisyon' => $komisyon,
			':uye_durum' => 2 
		));

		if ($update) {
			header("Location:../profilim.php?durum=ok");
		}else {
			header("Location:../profilim.php?durum=no");
		}
	} else {
		header("Location:../profilim.php?durum=hatalitc");
	}
} catch (Exception $e) {
	echo $e->faultstring;
}


}


if(isset($_POST['profilguncelle']) ){

	$uyesteamid=$_SESSION['steamid'];



	$profilguncelle=$db->prepare("UPDATE uyeler SET
		uye_mail=:uye_mail,
		uye_ceptel=:uye_ceptel,
		uye_bildirim=:uye_bildirim WHERE uye_steamid='$uyesteamid'");

	$update=$profilguncelle->execute(array(
		':uye_mail' => guvenlik($_POST['uye_mail']),
		':uye_ceptel' => guvenlik($_POST['uye_ceptel']),
		':uye_bildirim' => guvenlik($_POST['uye_bildirim'])
	));

	if ($update) {
		header("Location:../profilim.php?durum=ok");
	}else {
		header("Location:../profilim.php?durum=no");
	}



}

if(isset($_POST['saticibasvuru']) ){



	$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE uye_steamid=:steamid");
	$kullanicisor->execute(array(
		'steamid'=> $_SESSION['steamid']
	));
	$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

	$eposta=$kullanicicek['uye_mail'];
	$ceptel=$kullanicicek['uye_ceptel'];



	if ($kullanicicek['uye_bakiye']<5) {
		header("Location:../saticibasvuru.php?durum=yetersizbakiye");
	}else{
		$uye_id=$kullanicicek['uye_id'];
		$yenibakiye=$kullanicicek['uye_bakiye']-5;
		//burada üyenin bakiyesi eksilir.
		$profilguncelle=$db->prepare("UPDATE uyeler SET
			uye_bakiye=:uye_bakiye WHERE uye_id='$uye_id'");

		$update=$profilguncelle->execute(array(
			':uye_bakiye' => $yenibakiye,
		));

		if ($update) {
			$query = $db->prepare("INSERT INTO satici SET
				uye_id = :uye_id,
				satici_tipi = :satici_tipi,
				satici_hesapadsoyad = :satici_hesapadsoyad,
				satici_iban = :satici_iban,
				satici_mail = :satici_mail,
				satici_ceptel = :satici_ceptel,
				satici_adres = :satici_adres,
				satici_onay = :satici_onay");
			$insert = $query->execute(array(
				"uye_id" => $uye_id,
				"satici_tipi" => guvenlik($_POST['magza_tip']),
				"satici_hesapadsoyad" => guvenlik($_POST['satici_adsoyad']),
				"satici_iban" => guvenlik($_POST['iban']),
				"satici_mail" => $eposta,
				"satici_ceptel" => $ceptel,
				"satici_adres" => guvenlik($_POST['magza_adres']),
				"satici_onay" => 0,
			));
			if ( $insert ){
				$profilguncelle=$db->prepare("UPDATE uyeler SET
					uye_iban=:uye_iban WHERE uye_id='$uye_id'");

				$update=$profilguncelle->execute(array(
					':uye_iban' => guvenlik($_POST['iban']),
				));

				if ($update) {
					bildirimOlustur("Satıcı Başvurunuz alınmıştır.",$uye_id);
					echo 'Ok';
					header("Location:../saticibasvuru.php?durum=ok");
				}else {
					header("Location:../saticibasvuru.php?durum=no");
					echo 'YOk';
				}	 
				header("Location:../saticibasvuru.php?durum=ok");
			}else {
				header("Location:../saticibasvuru.php?durum=no");
			}

		//eksilme işlemi biter.
		}


	}
}


if(isset($_POST['urunekle']) ){
	$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE uye_steamid=:steamid");
	$kullanicisor->execute(array(
		'steamid'=> $_SESSION['steamid']
	));
	$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
	$urunsayisi=$kullanicicek['uye_urunsayisi'];
	$uye_id=$kullanicicek['uye_id'];
	if ($kullanicicek['uye_urunsayisi']<=0) {
		header("Location:../urunekle.php?durum=hakkinizkalmadi");
		exit;
	}


	if ($_FILES['urun_fotograf']['size']>1048576) {
		
		echo "Bu dosya boyutu çok büyük";

		Header("Location:../urunekle.php?durum=dosyabuyuk");

	}

	$gecici_isim=$_FILES['urun_fotograf']['tmp_name'];
	$dosya_ismi=rand(100000,999999).$_FILES['urun_fotograf']['name'];
	move_uploaded_file($gecici_isim,"../themes/images/items/$dosya_ismi");
	$query = $db->prepare("INSERT INTO urun SET
		kullanici_id = :kullanici_id,
		kategori_id = :kategori_id,
		urun_ad = :urun_ad,
		urun_aciklama = :urun_aciklama,
		urun_detay = :urun_detay,
		urun_fiyat = :urun_fiyat,
		urun_stok = :urun_stok,
		urun_bilgi= :urun_bilgi,
		urun_fotograf = :urun_fotograf,
		urun_keyword = :urun_keyword");
	$insert = $query->execute(array(
		"kullanici_id" => $uye_id,
		"kategori_id" => guvenlik($_POST['kategori_id']),
		"urun_ad" => guvenlik($_POST['urun_ad']),
		"urun_aciklama" => guvenlik($_POST['urun_aciklama']),
		"urun_detay" => $_POST['urun_detay'],
		"urun_fiyat" => guvenlik($_POST['urun_fiyat']),
		"urun_stok" => guvenlik($_POST['urun_stok']),
		"urun_bilgi" => guvenlik($_POST['urun_bilgi']),
		"urun_fotograf" => $dosya_ismi,
		"urun_keyword" => guvenlik($_POST['urun_keyword']),
	));
	if ( $insert ){

		$urunsayisi--;
		$profilguncelle=$db->prepare("UPDATE uyeler SET
			uye_urunsayisi=:uye_urunsayisi WHERE uye_id='$uye_id'");

		$update=$profilguncelle->execute(array(
			':uye_urunsayisi' => $urunsayisi
		));

		if ($update) {
			echo 'Ok';
			bildirimOlustur("Ürününüz onaylanınca yayına alınıcaktır.",$uye_id);
			header("Location:../urunekle.php?durum=ok");
		}else {
			header("Location:../urunekle.php?durum=no");
			echo 'YOk';
		}	 



	}else {
		echo 'alakasiz';
		header("Location:../urunekle.php?durum=no");
	}


}


if(isset($_POST['urunduzenle']) ){
	$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE uye_steamid=:steamid");
	$kullanicisor->execute(array(
		'steamid'=> $_SESSION['steamid']
	));
	$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
	$urunsayisi=$kullanicicek['uye_urunsayisi'];
	$uye_id=$kullanicicek['uye_id'];
	 



	if ($_FILES['urun_fotograf']['size']>0) {


		if ($_FILES['urun_fotograf']['size']>1048576) {

			echo "Bu dosya boyutu çok büyük";

			Header("Location:../urunduzenle.php?durum=dosyabuyuk");

		}

		$gecici_isim=$_FILES['urun_fotograf']['tmp_name'];
		$dosya_ismi=rand(100000,999999).$_FILES['urun_fotograf']['name'];
		move_uploaded_file($gecici_isim,"../themes/images/items/$dosya_ismi");
		$query = $db->prepare("UPDATE urun SET
			kategori_id = :kategori_id,
			urun_ad = :urun_ad,
			urun_aciklama = :urun_aciklama,
			urun_detay = :urun_detay,
			urun_fiyat = :urun_fiyat,
			urun_stok = :urun_stok,
			urum_onay= :urum_onay,
			urun_fotograf = :urun_fotograf,
			urun_keyword = :urun_keyword WHERE urun_id={$_POST['urun_id']}");
		$update = $query->execute(array(
			"kategori_id" => guvenlik($_POST['kategori_id']),
			"urun_ad" => guvenlik($_POST['urun_ad']),
			"urun_aciklama" => guvenlik($_POST['urun_aciklama']),
			"urun_detay" => $_POST['urun_detay'],
			"urun_fiyat" => guvenlik($_POST['urun_fiyat']),
			"urun_stok" => guvenlik($_POST['urun_stok']),
			"urum_onay" => 0,
			"urun_fotograf" => $dosya_ismi,
			"urun_keyword" => guvenlik($_POST['urun_keyword']),
		));

		$urun_id=$_POST['urun_id'];
		if ( $update ){
			$resimsilunlink=$_POST['eski_yol'];
			unlink("../themes/images/items/$resimsilunlink");
			echo 'Ok';
			bildirimOlustur("Ürününüz onaylanınca yayına alınıcaktır.",$uye_id);
			header("Location:../urunekle.php?durum=urunduzenlemeok");
		}else {
			header("Location:../urunduzenle.php?durum=no&urun_id=$urun_id");
			echo 'YOk';
		}	 



		


	}else{

		$query = $db->prepare("UPDATE urun SET
			kategori_id = :kategori_id,
			urun_ad = :urun_ad,
			urun_aciklama = :urun_aciklama,
			urun_detay = :urun_detay,
			urun_fiyat = :urun_fiyat,
			urun_stok = :urun_stok,
			urum_onay= :urum_onay,
			urun_keyword = :urun_keyword WHERE urun_id={$_POST['urun_id']}");
		$update = $query->execute(array(
			"kategori_id" => guvenlik($_POST['kategori_id']),
			"urun_ad" => guvenlik($_POST['urun_ad']),
			"urun_aciklama" => guvenlik($_POST['urun_aciklama']),
			"urun_detay" => $_POST['urun_detay'],
			"urun_fiyat" => guvenlik($_POST['urun_fiyat']),
			"urun_stok" => guvenlik($_POST['urun_stok']),
			"urum_onay" => 0,
			"urun_keyword" => guvenlik($_POST['urun_keyword']),
		));

		$urun_id=$_POST['urun_id'];
		if ( $update ){
			echo 'Ok';
			bildirimOlustur("Ürününüz onaylanınca yayına alınıcaktır.",$uye_id);
			header("Location:../urunduzenle.php?durum=urunduzenlemeok");
			exit;
		}else {
			header("Location:../urunduzenle.php?durum=no&urun_id=$urun_id");
			echo 'YOk';
			exit;
		}	 




	}

}


if (@$_GET['yayindankaldir']=="ok") {
	$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE uye_steamid=:steamid");
	$kullanicisor->execute(array(
		'steamid'=> $_SESSION['steamid']
	));
	$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
	$count = $kullanicisor->rowCount();
	if ($count<0) {
		header("Location:../index.php?durum=kayitlidegilsin");
		exit;
	}else{
		$query = $db->prepare("UPDATE urun SET
			urun_durum= :urun_durum WHERE kullanici_id={$kullanicicek['uye_id']} AND urun_id={$_GET['urun_id']}");
		$update = $query->execute(array(
			"urun_durum" => 0
		));

		$urun_id=$_GET['urun_id'];
		if ( $update ){

			echo 'Ok';
			header("Location:../urunlerim.php?durum=yayindankaldirok");
			exit;
		}else {
			header("Location:../urunduzenle.php?durum=yayindankaldirno");
			echo 'YOk';
			exit;
		}	 
	}
	



}



if (@$_GET['yayinla']=="ok") {

	$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE uye_steamid=:steamid");
	$kullanicisor->execute(array(
		'steamid'=> $_SESSION['steamid']
	));
	$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
	$count = $kullanicisor->rowCount();
	if ($count<0) {
		header("Location:../index.php?durum=kayitlidegilsin");
		exit;
	}else{
		$query = $db->prepare("UPDATE urun SET
			urun_durum= :urun_durum WHERE kullanici_id={$kullanicicek['uye_id']} AND urun_id={$_GET['urun_id']}");
		$update = $query->execute(array(
			"urun_durum" => 1
		));

		$urun_id=$_GET['urun_id'];
		if ( $update ){
			echo 'Ok';
			header("Location:../urunlerim.php?durum=yayinlaok");
			exit;
		}else {
			header("Location:../urunduzenle.php?durum=yayinlano");
			echo 'YOk';
			exit;
		}	 

	}
	


}


if (@$_GET['onecikar']=="ok") {

	$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE uye_steamid=:steamid");
	$kullanicisor->execute(array(
		'steamid'=> $_SESSION['steamid']
	));
	$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
	$count = $kullanicisor->rowCount();
	$hak=$kullanicicek['uye_onecikartmahak'];
	if ($count<0) {
		header("Location:../index.php?durum=kayitlidegilsin");
	}else{

		if ($kullanicicek['uye_onecikartmahak']<=0) {
			header("Location:../urunlerim.php?durum=onecikartmahakkinyok");
			exit;
		}


		$query = $db->prepare("UPDATE urun SET
			urun_onecikar= :urun_onecikar WHERE kullanici_id={$kullanicicek['uye_id']} AND urun_id={$_GET['urun_id']}");
		$update = $query->execute(array(
			"urun_onecikar" => 1
		));

		$urun_id=$_GET['urun_id'];
		if ( $update ){
			$hak--;
			$sonuc = $db->exec("UPDATE uyeler SET uye_onecikartmahak = $hak WHERE uye_id = {$kullanicicek['uye_id']} ");
			echo 'Ok';
			header("Location:../urunlerim.php?durum=onecikarok");
			exit;
		}else {
			header("Location:../urunduzenle.php?durum=onecikarno");
			exit;
			echo 'YOk';
		}	 

	}
	


}

if(isset($_POST['sipariskayit']) ){

	$kaydet=$db->prepare("INSERT INTO siparis SET
		kullanici_id=:id,
		kullanici_idsatici=:idsatici
		");
	$insert=$kaydet->execute(array(
		'id'=> htmlspecialchars($_POST['uye_id']),
		'idsatici'=> htmlspecialchars($_POST['satici_id']),
	));

	if ($insert) {
		echo "İşlem Başarılı <br>";
		$siparis_id=$db->lastInsertId();
		$siparisKaydet=$db->prepare("INSERT INTO siparis_detay SET
			siparis_id=:siparis_id,
			kullanici_id=:id,
			kullanici_idsatici=:idsatici,
			urun_id=:urun_id,
			urun_fiyat=:urun_fiyat,
			siparisdetay_not=:siparisdetay_not
			");
		$insertKaydet=$siparisKaydet->execute(array(
			'siparis_id'=> $siparis_id,
			'id'=> htmlspecialchars($_POST['uye_id']),
			'idsatici'=> htmlspecialchars($_POST['satici_id']),
			'urun_id'=> htmlspecialchars($_POST['urun_id']),
			'urun_fiyat'=> htmlspecialchars($_POST['urun_fiyat']),
			'siparisdetay_not'=> $_POST['siparisdetay_not'],
		));
		echo $_POST['siparisdetay_not'];
		if ($insertKaydet) {
			$uye_id=htmlspecialchars($_POST['uye_id']);
			//Ürün siparişleri tamam şimdi üye bakiyesini düşüyorum.
			$profilguncelle=$db->prepare("UPDATE uyeler SET
				uye_bakiye=:uye_bakiye WHERE uye_id='$uye_id'");

			$update=$profilguncelle->execute(array(
				':uye_bakiye' => htmlspecialchars($_POST['uye_bakiye'])
			));

			if ($update) {
				bildirimOlustur("Yeni bir siparişiniz var.",$_POST['satici_id']);
				$kullanicisors=$db->prepare("SELECT * FROM uyeler WHERE uye_id=:steamid");
				$kullanicisors->execute(array(
					'steamid'=> $_POST['satici_id']
				));
				$kullaniciceks=$kullanicisors->fetch(PDO::FETCH_ASSOC);
				if ($kullaniciceks['uye_bildirim']==1) {
					
					if (!$kullaniciceks['uye_ceptel']=="") {
			//echo $kullaniciceks['uye_ceptel'].'<br>';
						echo smsGonder("Market Fivemden yeni bir sipariş aldınız.. Lütfen kontrol ediniz.",$kullaniciceks['uye_ceptel']);

					}
				}
				echo 'Ok';
				header("Location:../satinaldiklarim.php?durum=ok");
			}else {
				header("Location:../satinaldiklarim.php?durum=no");
				echo 'YOk';
			}	 
		}

	}else{
 	//header("Location:../index.php");
		echo "HATA <br>";
	}
	/*
	echo $_POST['satici_id'].'<br>';
	echo $_POST['uye_id'].'<br>';
	echo $_POST['urun_id'].'<br>';
	echo $_POST['urun_fiyat'].'<br>';
	echo $_POST['uye_bakiye'].'<br>';*/

}



if(isset($_POST['onayver']) ){
	$bakiye= $_POST['urun_fiyat'].'<br>';
	$saticiad=$_POST['satici_ad'].'<br>';
	$satici_id=$_POST['satici_id'];

	$query = $db->prepare("UPDATE siparis_detay SET
		siparisdetay_onay=2,
		siparisdetay_onayzaman=:siparisdetay_onayzaman WHERE siparis_id=:siparis_id");
	$update = $query->execute(array(
		"siparisdetay_onayzaman" => date('Y-m-d H:i:s'),
		"siparis_id" => $_POST['siparis_id']
	));
	if ( $update ){
		$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE uye_id=:uye_id");
		$kullanicisor->execute(array(
			'uye_id'=> $satici_id
		));
		$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

		$komisyon_oran=$kullanicicek['uye_komisyon'];
		$uyebakiye=(float)$kullanicicek['uye_bakiye'];
		$komisyon=((float)$bakiye/100)*(float)$komisyon_oran;
		$odenecek=(float)$bakiye-(float)$komisyon;
		echo $odenecek.' tl karşı tarafa ödenecek.';
		$profilguncelle=$db->prepare("UPDATE uyeler SET
			uye_bakiye=:uye_bakiye WHERE uye_id='$satici_id'");

		$update=$profilguncelle->execute(array(
			':uye_bakiye' => $odenecek+$uyebakiye
		));

		if ($update) {
			if ($kullanicicek['uye_bildirim']==1) {


				if (!$kullanicicek['uye_ceptel']=="") {
			//echo $kullaniciceks['uye_ceptel'].'<br>';
					echo smsGonder("Fivem Market Alıcı ürüne onay verdi bakiyeniz hesabınıza yüklendi.",$kullanicicek['uye_ceptel']);

				}
			}
			bildirimOlustur("Alıcı onay verdi. Hesabınıza bakiyeniz yüklendi.",$satici_id);
			echo 'Ok';
			header("Location:../satinaldiklarim.php?durum=ok");
		}else {
			header("Location:../satinaldiklarim.php?durum=no");
			echo 'YOk';
		}	 

		//header("Location:../urunlerim.php?durum=yayinlaok");
		exit;
	}else {
		//header("Location:../urunduzenle.php?durum=yayinlano");
		echo 'YOk';
		exit;
	}	 

}



if(isset($_POST['urunteslim']) ){
	$siparis_uyeid=$_POST['siparis_uyeid'];
	$query = $db->prepare("UPDATE siparis_detay SET
		siparisdetay_onay=1 WHERE siparis_id=:siparis_id");
	$update = $query->execute(array(
		"siparis_id" => $_POST['siparis_id']
	));

	if ( $update ){
		echo bildirimOlustur("Satın aldığınız ürün teslim edildi Lütfen onay verin!",$siparis_uyeid);
		$kullanicisors=$db->prepare("SELECT * FROM uyeler WHERE uye_id=:steamid");
		$kullanicisors->execute(array(
			'steamid'=> $siparis_uyeid
		));
		$kullaniciceks=$kullanicisors->fetch(PDO::FETCH_ASSOC);
		if ($kullaniciceks['uye_bildirim']==1) {

			if (!$kullaniciceks['uye_ceptel']=="") {
			//echo $kullaniciceks['uye_ceptel'].'<br>';
				echo smsGonder("Market Fivemden satın aldığınız ürün teslim edildi. Lütfen onay veriniz.",$kullaniciceks['uye_ceptel']);

			}
		}
		header("Location:../yenisiparisler.php?durum=ok");
	}else{
		header("Location:../yenisiparisler.php?durum=no");
	}
}


if(isset($_POST['urun_yorumyap']) ){
	$siparis_id=$_POST['siparis_id'];
	$query = $db->prepare("INSERT INTO yorumlar SET
		yorum_puan = :yorum_puan,
		yorum_detay = :yorum_detay,
		kullanici_id = :kullanici_id,
		urun_id = :urun_id");
	$insert = $query->execute(array(
		"yorum_puan" => guvenlik($_POST['urun_puan']),
		"yorum_detay" => guvenlik($_POST['yorum_detay']),
		"kullanici_id" => guvenlik($_POST['uye_id']),
		"urun_id" => guvenlik($_POST['urun_id']),
	));
	if ( $insert ){
		$yorumguncelle=$db->prepare("UPDATE siparis_detay SET
			siparisdetay_yorum=:siparisdetay_yorum WHERE siparis_id='$siparis_id'");

		$update=$yorumguncelle->execute(array(
			':siparisdetay_yorum' => 1
		));

		if ($update) {
			header("Location:../siparisdetay.php?siparis_id=$siparis_id&durum=ok");
		}else {
			header("Location:../siparisdetay.php?siparis_id=$siparis_id&durum=no");
		}
		exit;
	}else {
		header("Location:../siparisdetay.php?siparis_id=$siparis_id&durum=no");
		exit;
	}
}



if(isset($_POST['mesajgonder']) ){
	$kullanici_gel=guvenlik($_POST['kullanici_gelid']);
	$query = $db->prepare("INSERT INTO mesaj SET
		kullanici_gel = :kullanici_gel,
		kullanici_gon = :kullanici_gon,
		mesaj_detay = :mesaj_detay");
	$insert = $query->execute(array(
		"kullanici_gel" => $kullanici_gel,
		"kullanici_gon" => guvenlik($_POST['uye_id']),
		"mesaj_detay" => $_POST['mesaj_detay']
	));
	if ( $insert ){
		
		$kullanicisors=$db->prepare("SELECT * FROM uyeler WHERE uye_id=:steamid");
		$kullanicisors->execute(array(
			'steamid'=> $kullanici_gel
		));
		$kullaniciceks=$kullanicisors->fetch(PDO::FETCH_ASSOC);
		if ($kullaniciceks['uye_bildirim']==1) {
			
			
			if (!$kullaniciceks['uye_ceptel']=="") {
			//echo $kullaniciceks['uye_ceptel'].'<br>';
				echo smsGonder("Market Fivemden bir mesajınız var. Lütfen siteden kontrol ediniz.",$kullaniciceks['uye_ceptel']);

			}
		}
		echo bildirimOlustur("Yeni bir mesajınız var !",$kullanici_gel);
		header("Location:../mesajgonder.php?kullanici_gel=$kullanici_gel&durum=ok");
	}else {
		header("Location:../mesajgonder.php?kullanici_gel=$kullanici_gel&durum=no");
	}
}


if (@$_GET['gidenmesajsil']=="ok") {
	$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE uye_steamid=:steamid");
	$kullanicisor->execute(array(
		'steamid'=> $_SESSION['steamid']
	));
	$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
	$count = $kullanicisor->rowCount();
	if ($count<0) {
		header("Location:../index.php?durum=kayitlidegilsin");
		exit;
	}else{
		$sil=$db->prepare("DELETE from mesaj WHERE mesaj_id=:mesaj_id");
		$kontrol=$sil->execute(array(
			'mesaj_id' => $_GET['mesaj_id']));

		if ($kontrol) {
			header("Location:../gidenmesajlar.php?durum=ok");
		}else{
			header("Location:../gidenmesajlar.php?durum=no");
		}
	}
	



}


if (@$_GET['gelenmesajsil']=="ok") {
	$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE uye_steamid=:steamid");
	$kullanicisor->execute(array(
		'steamid'=> $_SESSION['steamid']
	));
	$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
	$count = $kullanicisor->rowCount();
	if ($count<0) {
		header("Location:../index.php?durum=kayitlidegilsin");
		exit;
	}else{
		$sil=$db->prepare("DELETE from mesaj WHERE mesaj_id=:mesaj_id");
		$kontrol=$sil->execute(array(
			'mesaj_id' => $_GET['mesaj_id']));

		if ($kontrol) {
			header("Location:../gelenmesajlar.php?durum=ok");
		}else{
			header("Location:../gelenmesajlar.php?durum=no");
		}
	}
	



}




if (@$_GET['bildirimoku']=="ok") {
	$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE uye_steamid=:steamid");
	$kullanicisor->execute(array(
		'steamid'=> $_SESSION['steamid']
	));
	$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);
	$count = $kullanicisor->rowCount();
	if ($count<0) {
		header("Location:../index.php?durum=kayitlidegilsin");
		exit;
	}else{
		$mesajguncelle=$db->prepare("UPDATE bildirim SET
			bildirim_okuma=:bildirim_okuma
			WHERE bildirim_id={$_GET['bildirim_id']}");
		$update=$mesajguncelle->execute(array(
			'bildirim_okuma' => 1
		));
		if ($update) {

			$sil=$db->prepare("DELETE from bildirim WHERE bildirim_id=:bildirim_id");
			$kontrol=$sil->execute(array(
				'bildirim_id' => $_GET['bildirim_id']));

			if ($kontrol) {
				header("Location:../index.php?durum=bildirimokundu");
			}else{
				header("Location:../index.php?durum=bildirimokunamadi");
			}
		}else{
			header("Location:../index.php?durum=bildirimokunamadi");
		}
	}
	



}




if(isset($_POST['paracekistek']) ){
	$uye_id=guvenlik($_POST['uye_id']);
	$bakiye=guvenlik($_POST['uye_bakiye']);
	$miktar=guvenlik($_POST['paracek_miktar']);
	$enaz=50;
	if ($miktar<$enaz) {
		header("Location:../paracek.php?durum=bakiyeyetersiz");
		exit;
	}


	if ($bakiye<=$miktar) {
		header("Location:../paracek.php?durum=bakiyeyetersiz");
		exit;
	}else{
		$yeniBakiye=$bakiye-guvenlik($_POST['paracek_miktar']);
		$query = $db->prepare("INSERT INTO paracek SET
			paracek_miktar = :paracek_miktar,
			paracek_uyeid = :paracek_uyeid");
		$insert = $query->execute(array(
			"paracek_miktar" => guvenlik($_POST['paracek_miktar']),
			"paracek_uyeid" => $uye_id
		));
		if ( $insert ){
			$profilguncelle=$db->prepare("UPDATE uyeler SET
				uye_bakiye=:uye_bakiye WHERE uye_id='$uye_id'");

			$update=$profilguncelle->execute(array(
				':uye_bakiye' => $yeniBakiye 
			));

			if ($update) {
				//bildirimOlustur("Para çekme talebi oluşturuldu.",$uye_id);
				header("Location:../paracek.php?durum=ok");
				bildirimOlustur("Para çekme isteğiniz alınmıştır.",$uye_id);
				exit;
			}else {
				header("Location:../paracek.php?durum=no");
				exit;
			}
		}
	}
}



if(isset($_POST['biletUret']) ){
	$uye_id=guvenlik($_POST['uye_id']);
	$query = $db->prepare("INSERT INTO destek SET
		uye_id = :uye_id,
		destek_konu = :destek_konu,
		destek_detay = :destek_detay");
	$insert = $query->execute(array(
		"destek_konu" => guvenlik($_POST['destek_konu']),
		"destek_detay" => $_POST['destek_detay'],
		"uye_id" => $uye_id
	));
	$destek_id=$db->lastInsertId();
	if ( $insert ){
		$query = $db->prepare("INSERT INTO destek_detay SET
			destek_id = :destek_id,
			destek_detay_soru = :destek_detay_soru");
		$destekdetay = $query->execute(array(
			"destek_id" => $destek_id,
			"destek_detay_soru" => $_POST['destek_detay']
		));
		if ($destekdetay) {
			bildirimOlustur("Yardım talebiniz oluşturuldu. Cevap geldiğinde yeni bir bildirim alıcaksınız.",$uye_id);
			header("Location:../desteksistemi.php?durum=ok");
		}else{
			header("Location:../desteksistemi.php?durum=no");
		}
	}



}


if(isset($_POST['uruniptal']) ){
	$siparis_uyeid=$_POST['siparis_uyeid'];
	$urun_fiyat=$_POST['urun_fiyat'];
	$query = $db->prepare("UPDATE siparis_detay SET
		siparisdetay_onay=2 WHERE siparis_id=:siparis_id");
	$update = $query->execute(array(
		"siparis_id" => $_POST['siparis_id']
	));

	if ( $update ){
		echo bildirimOlustur("Satın aldığınız ürün iptal edildi!",$siparis_uyeid);
		$kullanicisors=$db->prepare("SELECT * FROM uyeler WHERE uye_id=:steamid");
		$kullanicisors->execute(array(
			'steamid'=> $siparis_uyeid
		));
		$kullaniciceks=$kullanicisors->fetch(PDO::FETCH_ASSOC);
		if ($kullanicicek['uye_bildirim']==1) {

			if (!$kullaniciceks['uye_ceptel']=="") {
			//echo $kullaniciceks['uye_ceptel'].'<br>';
				echo smsGonder("Market Fivemden satın aldığınız ürün iptal edildi bakiye geri yüklendi.",$kullaniciceks['uye_ceptel']);

			}


		}
		$uye_id=$kullaniciceks['uye_id'];
		$yenibakiye=$kullaniciceks['uye_bakiye']+$urun_fiyat;

		$profilguncelle=$db->prepare("UPDATE uyeler SET
			uye_bakiye=:uye_bakiye WHERE uye_id='$uye_id'");

		$update=$profilguncelle->execute(array(
			':uye_bakiye' => $yenibakiye,
		));

		if ($update) {
			header("Location:../yenisiparisler.php?durum=ok");
		}else{
			header("Location:../yenisiparisler.php?durum=no");
		}

		
	}else{
		header("Location:../yenisiparisler.php?durum=no");
	}
}





if(isset($_POST['urunhaksatinal']) ){
	echo $_POST['uye_urunsayisi'];
	$uyeid=$_POST['uye_id'];

	if ($_POST['uye_bakiye']<5) {
		header("Location:../vip.php?durum=yetersizbakiye");
		exit;
	}
	$yenisayi=$_POST['uye_urunsayisi']+1;
	$yenibakiye=(float)$_POST['uye_bakiye']-5;
	$profilguncelle=$db->prepare("UPDATE uyeler SET
		uye_urunsayisi=:uye_urunsayisi, 
		uye_bakiye = :uye_bakiye WHERE uye_steamid={$_SESSION['steamid']}");

	$update=$profilguncelle->execute(array(
		':uye_urunsayisi' => $yenisayi,
		':uye_bakiye' => $yenibakiye
	));

	if ($update) {
		bildirimOlustur("1 Adet Ürün Ekleme Satın Alındı.",$uyeid);
		header("Location:../vip.php?durum=ok");
	}else {
		header("Location:../vip.php?durum=no");
	}

}




if(isset($_POST['onecikartmahaksatinal']) ){
	if ($_POST['uye_bakiye']<5) {
		header("Location:../vip.php?durum=yetersizbakiye");
		exit;
	}
	$uyeid=$_POST['uye_id'];
	echo $_POST['uye_onecikartmahak'];
	$yenisayi=$_POST['uye_onecikartmahak']+1;
	$yenibakiye=(float)$_POST['uye_bakiye']-10;
	$profilguncelle=$db->prepare("UPDATE uyeler SET
		uye_onecikartmahak=:uye_onecikartmahak, 
		uye_bakiye = :uye_bakiye WHERE uye_steamid={$_SESSION['steamid']}");

	$update=$profilguncelle->execute(array(
		':uye_onecikartmahak' => $yenisayi,
		':uye_bakiye' => $yenibakiye
	));

	if ($update) {
		bildirimOlustur("1 Adet Ürün Öne Çıkartma Satın Alındı.",$uyeid);
		header("Location:../vip.php?durum=ok");
	}else {
		header("Location:../vip.php?durum=no");
	}
}





if(isset($_POST['biletYanitla']) ){
	echo $_POST['destek_id'].'<br>';
	echo $_POST['destek_detay_soru'];
	$query = $db->prepare("INSERT INTO destek_detay SET
		destek_id = :destek_id,
		destek_detay_soru = :destek_detay_soru");
	$insert = $query->execute(array(
		"destek_id" => guvenlik($_POST['destek_id']),
		"destek_detay_soru" =>  $_POST['destek_detay_soru']
	));
	if ($insert) {
		$query = $db->prepare("UPDATE destek SET
			destek_durum=0 WHERE destek_id=:destek_id");
		$update = $query->execute(array(
			"destek_id" => guvenlik($_POST['destek_id'])
		));
		if ($update) {
			header("Location:../desteksistemi.php?durum=ok");
		}else{
			header("Location:../desteksistemi.php?durum=no");
		}

	}else{
		header("Location:../desteksistemi.php?durum=no");
	}
}


?>