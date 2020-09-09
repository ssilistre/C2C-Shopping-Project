<?php 
include 'themes/header.php';
include 'themes/navbar.php';
sessionKontrol();


$mesajsor=$db->prepare("SELECT mesaj.*,uyeler.* FROM mesaj INNER JOIN uyeler ON mesaj.kullanici_gon=uyeler.uye_id where uyeler.uye_id=:id and mesaj.mesaj_id=:mesaj_id order by mesaj_zaman DESC");
$mesajsor->execute(array(
  'id' => $_GET['kullanici_gon'],
  'mesaj_id' => $_GET['mesaj_id']
));


$mesajcek=$mesajsor->fetch(PDO::FETCH_ASSOC);


if ($mesajcek['mesaj_okuma']==0) {


	$mesajguncelle=$db->prepare("UPDATE mesaj SET

		mesaj_okuma=:mesaj_okuma

		WHERE mesaj_id={$_GET['mesaj_id']}");


	$update=$mesajguncelle->execute(array(

		'mesaj_okuma' => 1

	));

}

if ($mesajcek['uye_steamisim']=="") {
	$kullaniciad="Henüz kayıt etmemiş.";
	# code...
}else{
	$kullaniciad=$mesajcek['uye_steamisim'];
}

?>
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">
	<div class="container">

		<div class="row">
			<?php include 'themes/solmenu.php'; ?>
			<main class="col-md-9">

				<?php include 'themes/profilust.php'; ?>
				<article class="card  mb-3">
					<div class="card-body">
						 
						<h5 class="card-title mb-4">Mesaj Detayı </h5>	

						 <p><b>Kimden: <?php echo $kullaniciad ?></b></p>
							<div class="form-group row">
								<label for="mesaj_detay" class="col-4 col-form-label">Mesaj Detayı:</label> 

								<div class="col-8">
									<?php echo $mesajcek['mesaj_detay']?>
								</div>
							</div> 

						 
					 
				</div> <!-- card-body .// -->
			</article> <!-- card.// -->

 <?php 

              if (@$_GET['gidenmesaj']!="ok") { ?>
			<article class="card  mb-3">
				<div class="card-body">
					 

						<h5 class="card-title mb-4">Mesajı Cevapla </h5>	

						<form action="inc/action.php" method="post">
							<div class="form-group row">
								<label for="kullanici_gel" class="col-4 col-form-label">Gönderilicek Kullanıcı:</label> 
								<div class="col-8">
									<input id="kullanici_gel" name="kullanici_gel" placeholder="Kullanıcı Adı veya üye nosu buraya gelicek." value="<?php echo $kullaniciad ?>" readonly="readonly" type="text" class="form-control" required="required">
								</div>
							</div>
							<div class="form-group row">
								<label for="mesaj_detay" class="col-4 col-form-label">Mesaj Detayı:</label> 
								<div class="col-8">
									<textarea id="mesaj_detay" class="ckeditor" name="mesaj_detay" cols="40" rows="5" class="form-control" aria-describedby="mesaj_detayHelpBlock" required="required"></textarea> 
									<span id="mesaj_detayHelpBlock" class="form-text text-muted">Mejınızı buraya yazınız.</span>
								</div>
							</div> 
							<div class="form-group row">
								<div class="offset-4 col-8">
									<input type="hidden" name="uye_id" value="<?php echo $kullanicicek['uye_id'] ?>">
									<input type="hidden" name="kullanici_gelid" value="<?php echo $_GET['kullanici_gon'] ?>">
									<button name="mesajgonder" type="submit" class="btn btn-primary">Mesaj gönder</button>
								</div>
							</div>
						</form>
				 
				</div> <!-- card-body .// -->
			</article> <!-- card.// -->
	<?php } ?>
		</main> <!-- col.// -->
	</div>

</div> <!-- container .//  -->
</section>
<!-- ========================= SECTION CONTENT END// ========================= -->

<?php
include 'themes/footerust.php';
include 'themes/footer.php';
?>