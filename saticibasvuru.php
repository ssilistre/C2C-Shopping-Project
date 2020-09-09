<?php 
include 'themes/header.php';
include 'themes/navbar.php';
sessionKontrol();
$basvurusor=$db->prepare("SELECT * FROM satici WHERE uye_id=:uye_id");
$basvurusor->execute(array(
  'uye_id'=> $kullanicicek['uye_id']
));
$basvurucek=$basvurusor->fetch(PDO::FETCH_ASSOC);

?>
<body>


<section class="section-content padding-y">
<div class="container">

<header class="section-heading">
	<h2 class="section-title">Satıcı Başvuru Formu</h2>
</header><!-- sect-heading -->

<article>

<?php if (!$kullanicicek['uye_tc']==""){ ?>
<?php if (@$basvurucek['satici_onay']==null) { ?>
<form action="inc/action.php" method="post">
  <div class="form-group row">
    <label for="magza_tip" class="col-4 col-form-label">Satıcı Tipiniz:</label> 
    <div class="col-8">
      <select id="magza_tip" name="magza_tip" aria-describedby="magza_tipHelpBlock" required="required" class="custom-select">
        <option value="0">Seçiniz</option>
        <option value="Bireysel">Bireysel</option>
        <option value="Kurumsal">Kurumsal</option>
      </select> 
      <span id="magza_tipHelpBlock" class="form-text text-muted">Kurumsal ve Bireysel olarak ayrılmaktadır.</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="text" class="col-4 col-form-label">Hesap Sahibinin Adı Soyadı:</label> 
    <div class="col-8">
      <input id="text" name="satici_adsoyad" type="text" class="form-control" value="<?php echo $kullanicicek['uye_adsoyad'] ?>" readonly="readonly" required="required" aria-describedby="textHelpBlock"> 
      <span id="textHelpBlock" class="form-text text-muted">Banka bilgileriniz uyuşmaz ise ödeme alamazsınız.</span>
    </div>
  </div>
  <div class="form-group row">
    <label for="magza_iban" class="col-4 col-form-label">IBAN :</label> 
    <div class="col-8">
      <input id="magza_iban" name="iban" placeholder="TR00000000000000000000000" type="text" required="required" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="email" class="col-4 col-form-label">Satıcı Mail :</label> 
    <div class="col-8">
      <input id="email" name="email" placeholder="info@magaza.com" type="text" readonly="readonly" value="<?php echo $kullanicicek['uye_mail'] ?>" required="required" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="magza_ceptel" class="col-4 col-form-label">Satıcı Cep Tel :</label> 
    <div class="col-8">
      <input id="magza_ceptel" name="magza_ceptel" placeholder="05425425425425" readonly="readonly" value="<?php echo $kullanicicek['uye_ceptel'] ?>" type="text" required="required" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="magza_adres" class="col-4 col-form-label">Adresiniz:</label> 
    <div class="col-8">
      <textarea id="magza_adres" name="magza_adres" cols="40" rows="5" class="form-control" aria-describedby="magza_adresHelpBlock" required="required"></textarea> 
      <span id="magza_adresHelpBlock" class="form-text text-muted">Lütfen doğru şekilde giriniz.</span><br>
 <div class="alert alert-success" role="alert">
  <?php echo $kullanicicek['uye_bakiye'] ?> bakiyenizden tek seferlik <b>5 ₺</b> başvuru ücreti kesilecektir. Not: Başvurunuz onaylanmaz ise bakiyeniz geri verilmez.
</div>
    </div>
  </div> 

  <div class="form-group row">
    <div class="offset-4 col-8">
      <button name="saticibasvuru" type="submit" class="btn btn-primary">Başvuru Yap</button>
    </div>
  </div>
</form>
<?php }elseif ($basvurucek['satici_onay']==1) {
	 
    $uyeid=$kullanicicek['uye_id'];
	$profilguncelle=$db->prepare("UPDATE uyeler SET
			uye_yetki=:uye_yetki WHERE uye_id='$uyeid'");

		$update=$profilguncelle->execute(array(
			':uye_yetki' => 1
		));

		if ($update) {
			echo 'Başvurunuz onaylandı..';
		}else {
			 
		}
}


else {
	echo 'Başvurunuz inceleniyor.. <br> Eğer bir nedenden ötürü başvurunuz kabul edilmez ise tekrar başvuru yapamazsınız.';
} ?>
</article>
<?php }else{ ?>
Profilinizi doldurmalı ve T.C doğrulamalısınız.
<?php }?>
</div> <!-- container .//  -->
</section>
<!-- ========================= SECTION CONTENT END// ========================= -->

<?php
include 'themes/footer.php';
?>