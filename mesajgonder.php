<?php 
include 'themes/header.php';
include 'themes/navbar.php';

sessionKontrol();
$kullanicisor=$db->prepare("SELECT * FROM uyeler where uye_id=:id");
$kullanicisor->execute(array(
	'id' => $_GET['kullanici_gel']
));
$count = $kullanicisor->rowCount();
	if ($count<=0) {
		header('location:index.php');
		exit;
	}

$kullaniciceks=$kullanicisor->fetch(PDO::FETCH_ASSOC);

if ($kullaniciceks['uye_steamisim']=="") {
	$kullaniciad="Henüz kayıt etmemiş.";
	# code...
}else{
	$kullaniciad=$kullaniciceks['uye_steamisim'];
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
						<?php  if (@$_GET['durum']=="ok") { ?>
							<div class="alert alert-success" role="alert">
								Mesajınız başarılı bir şekilde <b><?php echo $kullaniciad ?></b> adlı kişiye gönderildi !
							</div>
						<?php }else{ ?>
						<h5 class="card-title mb-4">Mesaj Gönder </h5>	

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
									<input type="hidden" name="kullanici_gelid" value="<?php echo $_GET['kullanici_gel'] ?>">
									<button name="mesajgonder" type="submit" class="btn btn-primary">Mesaj gönder</button>
								</div>
							</div>
						</form>
					<?php } ?>
					</div> <!-- card-body .// -->
				</article> <!-- card.// -->

			</main> <!-- col.// -->
		</div>

	</div> <!-- container .//  -->
</section>
<!-- ========================= SECTION CONTENT END// ========================= -->

<?php
include 'themes/footerust.php';
include 'themes/footer.php';
?>