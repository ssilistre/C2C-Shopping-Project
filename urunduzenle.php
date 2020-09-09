<?php 
include 'themes/header.php';
include 'themes/navbar.php';

sessionKontrol();
?>
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">
	<div class="container">

		<div class="row">
			<?php include 'themes/solmenu.php'; ?>
			<main class="col-md-9">

				<?php include 'themes/profilust.php'; ?>
				<?php 

			 //	$_GET['urun_id']

				$urunsor=$db->prepare("SELECT * FROM urun WHERE urun_id=:urun_id AND kullanici_id=:kullanici_id AND urum_onay=1");
				$urunsor->execute(array(
					'kullanici_id'=> $kullanicicek['uye_id'],
					'urun_id'=> $_GET['urun_id']
				));
				$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
				$count = $urunsor->rowCount();
				if ($count<=0) {
					header('location:urunekle.php');
					exit;
				}
				?>
				<article class="card  mb-3">
					<div class="card-body">
						<h5 class="card-title mb-4">Ürün Düzenle </h5>	


						<form action="inc/action.php" method="post" enctype="multipart/form-data">
							<div class="form-group row">
								<label for="urun_fotograf" class="col-4 col-form-label">Ürün Mevcut Resim</label> 
								<div class="col-8">
									<a href="#" class="img-wrap"> <img width="200" src="themes/images/items/<?php echo $uruncek['urun_fotograf'] ?>"></a>
								</div>
							</div>
							<div class="form-group row">
								<label for="urun_fotograf" class="col-4 col-form-label">Ürün Resim</label> 
								<div class="col-8">
									<input id="urun_fotograf" name="urun_fotograf" value="<?php echo $uruncek['urun_fotograf']?>" type="file" class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<label for="kategori_id" class="col-4 col-form-label">Ürün Kategori</label> 
								<div class="col-8">
									<select id="kategori_id" name="kategori_id" required="required" class="custom-select" aria-describedby="kategori_idHelpBlock">
										<option value="0">Seçiniz</option>
										<?php 
										$kategorisor=$db->prepare("SELECT * FROM kategori order by kategori_sira ASC");
										$kategorisor->execute();

										while ($kategoricek=$kategorisor->fetch(PDO::FETCH_ASSOC)) {
											?>

											<option <?php if ($kategoricek['kategori_id']==$uruncek['kategori_id']) { echo "selected"; } ?>  value="<?php echo $kategoricek['kategori_id']  ?>"><?php echo $kategoricek['kategori_ad'] ?></option>
										<?php } ?>
									</select> 
									<span id="kategori_idHelpBlock" class="form-text text-muted">Hangi Kategoriye Ürün Ekleyeceksin ?</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="urun_ad" class="col-4 col-form-label">Ürünün Adı:</label> 
								<div class="col-8">
									<input id="urun_ad" name="urun_ad" value="<?php echo $uruncek['urun_ad']?>" placeholder="Örnek: Anti Cheat Sistemi" type="text" class="form-control" required="required">
								</div>
							</div>
							<div class="form-group row">
								<label for="urun_aciklama" class="col-4 col-form-label">Ürün Açıklama:</label> 
								<div class="col-8">
									<input id="urun_aciklama" name="urun_aciklama" value="<?php echo $uruncek['urun_aciklama']?>" placeholder="Ürünün kısa açıklamasını giriniz." type="text" class="form-control" required="required">
								</div>
							</div>
							<div class="form-group row">
								<label for="urun_fiyat" class="col-4 col-form-label">Ürünün Fiyatı:</label> 
								<div class="col-8">
									<input id="urun_fiyat" name="urun_fiyat" placeholder="10.00" type="text" value="<?php echo $uruncek['urun_fiyat']?>" aria-describedby="urun_fiyatHelpBlock" class="form-control" required="required"> 
									<span id="urun_fiyatHelpBlock" class="form-text text-muted">Sadece rakam giriniz.</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="urun_detay" class="col-4 col-form-label">Ürün Detay:</label> 
								<div class="col-8">
									<textarea id="urun_detay" class="ckeditor" name="urun_detay" cols="40" rows="3" class="form-control" aria-describedby="urun_detayHelpBlock" required="required"><?php echo $uruncek['urun_detay']?></textarea> 
									<span id="urun_detayHelpBlock" class="form-text text-muted">Detaylı bir ürün açıklaması girebilirsiniz. Editör kullanılabilir.</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="urun_stok" class="col-4 col-form-label">Ürün Stok:</label> 
								<div class="col-8">
									<input id="urun_stok" name="urun_stok" value="<?php echo $uruncek['urun_stok']?>" placeholder="Ürün kaçtane sınırsız ise boş bırakabilirsiniz." type="text" class="form-control" required="required">
								</div>
							</div> 
							<div class="form-group row">
								<label for="urun_stok" class="col-4 col-form-label">Ürün Etiketler:</label> 
								<div class="col-8">
									<input id="urun_keyword" name="urun_keyword" value="<?php echo $uruncek['urun_keyword']?>" placeholder="Anti Cheat , Anti-Cheat , Hile Koruma gibi gibi " type="text" class="form-control" required="required">
								</div>
							</div> 
							<div class="form-group row">
								<div class="offset-4 col-8">
									<input type="hidden" value="<?php echo $uruncek['urun_id'] ?>" name="urun_id">
									<input type="hidden" value="<?php echo $uruncek['urun_fotograf'] ?>" name="eski_yol">
									<button name="urunduzenle" type="submit" class="btn btn-primary">Ürünü Güncelle</button>
								</div>
							</div>
						</form>

						<div class="alert alert-danger" role="alert">
							Ürün düzenlendikten sonra <b>Ürün Ekle Sayfasındaki Onay bekleyen ürünlerde listelenir.</b> Onay aldıktan sonra yayınlanır.
						</div>
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