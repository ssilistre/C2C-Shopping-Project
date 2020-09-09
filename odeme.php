<?php 
include 'themes/header.php';
include 'themes/navbar.php';
sessionKontrol();



if (isset($_POST['odemeyap'])) {

	$urunsor=$db->prepare("SELECT * FROM urun where urun_id=:urun_id AND urum_onay=1 AND urun_durum=1 order by urun_id DESC");
	$urunsor->execute(array(
		'urun_id'=> $_POST['urun_id']
	));
	$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);
	$count = $urunsor->rowCount();
	if ($count<=0) {
		header('location:index.php');
		exit;
	}
	$satici_id=$uruncek['kullanici_id'];
	$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE uye_id=:uye_id");
	$kullanicisor->execute(array(
		'uye_id'=> $satici_id
	));
	$kulllanici=$kullanicisor->fetch(PDO::FETCH_ASSOC);
}else{
	header('location:index.php');

}


?>

<section class="section-content padding-y bg">
	<div class="container">

		<!-- ============================ COMPONENT 1 ================================= -->


		<div class="row">
			<aside class="col-lg-9">
				<div class="card">
					<table class="table table-borderless table-shopping-cart">
						<thead class="text-muted">
							<tr class="small text-uppercase">
								<th scope="col">Ürünler</th>
								<th scope="col" width="120">Adet</th>
								<th scope="col" width="120">Fiyat</th>
								<th scope="col" class="text-right" width="200"> </th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<figure class="itemside align-items-center">
										<div class="aside"><img src="themes/images/items/<?php echo $uruncek['urun_fotograf'] ?>" class="img-sm"></div>
										<figcaption class="info">
											<a href="#" class="title text-dark"><?php echo $uruncek['urun_ad'] ?></a>
											<p class="text-muted small"><?php echo $uruncek['urun_aciklama'] ?></p>
											<p class="text-muted small">Satıcı:<?php echo $kulllanici['uye_steamisim'] ?></p>
										</figcaption>
									</figure>
								</td>
								<td> 
									<select class="form-control">
										<option>1</option>
									</select> 
								</td>
								<td> 
									<div class="price-wrap"> 
										<var class="price"><?php echo $uruncek['urun_fiyat'] ?> ₺</var> 
										<small class="text-muted"> <?php echo $uruncek['urun_fiyat'] ?> ₺/Birim Fiyatı </small> 
									</div> <!-- price-wrap .// -->
								</td>

							</tr>
							<tr>

							</tbody>
						</table>

						<div class="card-body border-top">
							<form action="inc/action.php" method="post"> 
							<p> <b>Satıcıya Not:</b></p>
						<textarea id="urun_detay" class="ckeditor" name="siparisdetay_not" cols="40" rows="3" class="form-control" aria-describedby="urun_detayHelpBlock">
							<b>Satıcı Diyor ki;</b><?php echo $uruncek['urun_bilgi'] ?>
						</textarea> 
									<span id="urun_detayHelpBlock" class="form-text text-muted">Satıcıya iletmek istediğiniz mesajı bu alana yazabilirsiniz..</span><br>

							<p class="icontext"><i class="icon text-success fa fa-truck"></i> Ürünün teslimatı satıcının yoğunluğuna göre değişmektedir.</p>
						</div> <!-- card-body.// -->

					</div> <!-- card.// -->

				</aside> <!-- col.// -->
				<aside class="col-lg-3">



					<div class="card">
						<div class="card-body">
							<dl class="dlist-align">
								<dt>Senin Bakiyen:</dt>
								<dd class="text-right"> <?php echo $kullanicicek['uye_bakiye'] ?> ₺</dd>
							</dl>
							<dl class="dlist-align">
								<dt>Ödenecek:</dt>
								<dd class="text-right text-danger">- <?php echo $uruncek['urun_fiyat'] ?> ₺</dd>
							</dl>
							<hr>
							<dl class="dlist-align">
								<dt>Sana Kalıcak:</dt>
								<dd class="text-right text-dark b"><strong><?php 

								if ($kullanicicek['uye_bakiye']<$uruncek['urun_fiyat']) {
									echo 'Yetersiz Bakiye';
								}else{
									$kalanpara=$kullanicicek['uye_bakiye']-$uruncek['urun_fiyat'];
									echo $kalanpara.' ₺';

								}?></strong></dd>
							</dl>
							<br>
							<?php if ($kullanicicek['uye_bakiye']<$uruncek['urun_fiyat']) { ?>
								<a href="index.php" class="btn btn-light btn-block">Alışverişe Devam Et</a>
							<?php }else{?>
								 
								 
								<input type="hidden" name="satici_id" value="<?php echo $uruncek['kullanici_id'] ?>">
								<input type="hidden" name="uye_id" value="<?php echo $kullanicicek['uye_id'] ?>">
								<input type="hidden" name="urun_id" value="<?php echo $uruncek['urun_id'] ?>">
								<input type="hidden" name="urun_fiyat" value="<?php echo $uruncek['urun_fiyat'] ?>">
								<input type="hidden" name="uye_bakiye" value="<?php echo $kalanpara ?>">
								<button type="submit" name="sipariskayit" class="btn btn-primary btn-block"> Ödeme Yap </button></form><br>
								<a href="index.php" class="btn btn-light btn-block">Alışverişe Devam Et</a>
							<?php } ?>
						</div> <!-- card-body.// -->
					</div> <!-- card.// -->

				</aside> <!-- col.// -->


			</div> <!-- row.// -->
			<!-- ============================ COMPONENT 1 END .// ================================= -->
		</div> <!-- container .//  -->
	</section>
	<!-- ========================= SECTION CONTENT END// ========================= -->

	<?php
	include 'themes/footer.php';
	?>