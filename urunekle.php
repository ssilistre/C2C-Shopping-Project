<?php 
include 'themes/header.php';
include 'themes/navbar.php';

sessionKontrol();


if ($kullanicicek['uye_yetki']==0) {
	header("Location:../index.php?durum=yetkinyok");
}
?>
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">
	<div class="container">

		<div class="row">
			<?php include 'themes/solmenu.php'; ?>
			<main class="col-md-9">

				<?php include 'themes/profilust.php'; ?>
				<?php

				$urunsor=$db->prepare("SELECT * FROM urun WHERE kullanici_id=:kullanici_id AND urum_onay=0");
				$urunsor->execute(array(
					'kullanici_id'=> $kullanicicek['uye_id']
				));
				$count = $urunsor->rowCount();
				if ($count>0) { ?>
					<article class="card  mb-3">
						<div class="card-body">
							<h5 class="card-title mb-4">Onay Bekleyen Ürünler </h5>	
							<table class="table table-hover">
								<thead>
									<tr>
										<th scope="col">Ürün Adı</th>
										<th scope="col">Ürün Durumu</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<?php while ($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) { ?>
											<?php if ($uruncek['urum_onay']==0) {
												$durum="Onay Bekliyor.";
											} ?>


											 
											<td><?php echo $uruncek['urun_ad'] ?></td>
											<td><?php echo $durum ?></td>
										</tr>






									<?php } ?>
								</tbody>
							</table>

						</div> <!-- card-body .// -->
					</article> <!-- card.// -->
				<?php } ?>
				<article class="card  mb-3">
					<div class="card-body">
						<h5 class="card-title mb-4">Ürün Ekle </h5>	


						<form action="inc/action.php" method="post" enctype="multipart/form-data">
							<div class="form-group row">
								<label for="urun_fotograf" class="col-4 col-form-label">Ürün Resimleri</label> 
								<div class="col-8">
									<input id="urun_fotograf" name="urun_fotograf[]" type="file" required="required" class="form-control">
									<span id="urun_fotografHelpBlock" class="form-text text-muted">Ürüne 1 Resim Eklemek Zorunludur. Diğerleri isteğe bağlıdır. 2 MB Sınır vardır.</span>
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

											<option value="<?php echo $kategoricek['kategori_id']  ?>"><?php echo $kategoricek['kategori_ad'] ?></option>
										<?php } ?>
									</select> 
									<span id="kategori_idHelpBlock" class="form-text text-muted">Hangi Kategoriye Ürün Ekleyeceksin ?</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="urun_ad" class="col-4 col-form-label">Ürünün Adı:</label> 
								<div class="col-8">
									<input id="urun_ad" name="urun_ad" placeholder="Örnek: Anti Cheat Sistemi" type="text" class="form-control" required="required">
								</div>
							</div>
							<div class="form-group row">
								<label for="urun_aciklama" class="col-4 col-form-label">Ürün Açıklama:</label> 
								<div class="col-8">
									<input id="urun_aciklama" name="urun_aciklama" placeholder="Ürünün kısa açıklamasını giriniz." type="text" class="form-control" required="required">
								</div>
							</div>
							<div class="form-group row">
								<label for="urun_fiyat" class="col-4 col-form-label">Ürünün Fiyatı:</label> 
								<div class="col-8">
									<input id="urun_fiyat" name="urun_fiyat" placeholder="10.00" type="text" aria-describedby="urun_fiyatHelpBlock" class="form-control" required="required"> 
									<span id="urun_fiyatHelpBlock" class="form-text text-muted">Sadece rakam giriniz.</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="urun_detay" class="col-4 col-form-label">Ürün Detay:</label> 
								<div class="col-8">
									<textarea id="urun_detay" class="ckeditor" name="urun_detay" cols="40" rows="3" class="form-control" aria-describedby="urun_detayHelpBlock" required="required"></textarea> 
									<span id="urun_detayHelpBlock" class="form-text text-muted">Detaylı bir ürün açıklaması girebilirsiniz. Editör kullanılabilir.</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="urun_stok" class="col-4 col-form-label">Ürün Stok:</label> 
								<div class="col-8">
									<input id="urun_stok" name="urun_stok" placeholder="Ürün kaçtane sınırsız ise 0 yazabilirsiniz." type="text" class="form-control" required="required">
								</div>
							</div> 
							<div class="form-group row">
								<label for="urun_stok" class="col-4 col-form-label">Ürün Etiketler:</label> 
								<div class="col-8">
									<input id="urun_keyword" name="urun_keyword" placeholder="Anti Cheat , Anti-Cheat , Hile Koruma gibi gibi " type="text" class="form-control" required="required">
								</div>
							</div> 
							<div class="form-group row">
								<label for="urun_bilgi" class="col-4 col-form-label">Alıcıdan İstediğiniz bilgi:</label> 
								<div class="col-8">
									<input id="urun_bilgi" name="urun_bilgi" placeholder="Örnek discord kullanıcı adınızı giriniz. " type="text" class="form-control" >
								</div>
							</div> 
							<div class="form-group row">
								<div class="offset-4 col-8">
									<button name="urunekle" type="submit" class="btn btn-primary">Ürün Ekle</button>
								</div>
							</div>
						</form>


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