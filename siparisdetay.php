<?php 
include 'themes/header.php';
include 'themes/navbar.php';

sessionKontrol();

$siparissor=$db->prepare("SELECT urun.*,uyeler.*,siparis.*,siparis_detay.*  FROM siparis INNER JOIN siparis_detay ON siparis.siparis_id=siparis_detay.siparis_id INNER JOIN urun ON urun.urun_id=siparis_detay.urun_id INNER JOIN uyeler ON uyeler.uye_id=siparis_detay.kullanici_idsatici where siparis.siparis_id=:siparis_detay_id");
$siparissor->execute(array(
	'siparis_detay_id'=> $_GET['siparis_id']
));
$sipariscek=$siparissor->fetch(PDO::FETCH_ASSOC);


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
						<h5 class="card-title mb-4"><?php echo $_GET['siparis_id'] ?> numaralı sipariş detayı; </h5>	

						<table class="table table-hover">
							<thead>
								<tr>

									<th scope="col">Ürün Adı</th>
									<th scope="col">Satıcı</th>
									<th scope="col">Fiyat</th>
									<th scope="col">İşlem Durumu</th>
								</tr>
							</thead>
							<tbody>

								<tr>
									<td><?php echo $sipariscek['urun_ad'] ?></td>
									<td><span class="badge badge-dark"><?php echo $sipariscek['uye_steamisim'] ?></span></td>
									<td><?php echo $sipariscek['urun_fiyat']?>₺</td>
									<td><?php if ($sipariscek['siparisdetay_onay']==1) { ?>
										<form action="inc/action.php" method="post"> 
											<input type="hidden" name="urun_fiyat" value="<?php echo $sipariscek['urun_fiyat']?>">
											<input type="hidden" name="satici_ad" value="<?php echo $sipariscek['uye_steamisim']?>">
											<input type="hidden" name="siparis_id" value="<?php echo $sipariscek['siparis_id']?>">
											<input type="hidden" name="satici_id" value="<?php echo $sipariscek['kullanici_idsatici']?>">
											<button type="submit" name="onayver" class="btn btn-warning btn-xs">Onay Ver</button></form>
										<?php }else if ($sipariscek['siparisdetay_onay']==2){  ?> 
											<button class="btn btn-success btn-xs">Onaylandı</button></td>

										<?php }else{ ?>

											<button class="btn btn-warning btn-xs">Teslimi bekleniyor.</button></td>
										<?php } ?>
									</tr>

								</tbody>
							</table>

							<?php if ($sipariscek['siparisdetay_onay']==2 and $sipariscek['siparisdetay_yorum']==0) {?>
								<div class="card">
									<div class="card-body">
										<h5 class="card-title">Ürün ve Satıcı Hakkında Yorum Yaparmısın ?</h5>
										<h6 class="card-subtitle mb-2 text-muted">Selam deneyimini merak ediyoruz. Bize kısaca bir yorum bırakırmısın ?</h6>
										<form action="inc/action.php" method="post">
											<div class="form-group row">
												<label class="col-4">Kaç Puan Veriyorsun ?</label> 
												<div class="col-8">
													<div class="custom-control custom-radio custom-control-inline">
														<input name="urun_puan" id="urun_puan_0" type="radio" class="custom-control-input" value="1" aria-describedby="urun_puanHelpBlock" required="required"> 
														<label for="urun_puan_0" class="custom-control-label">1</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input name="urun_puan" id="urun_puan_1" type="radio" class="custom-control-input" value="2" aria-describedby="urun_puanHelpBlock" required="required"> 
														<label for="urun_puan_1" class="custom-control-label">2</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input name="urun_puan" id="urun_puan_2" type="radio" class="custom-control-input" value="3" aria-describedby="urun_puanHelpBlock" required="required"> 
														<label for="urun_puan_2" class="custom-control-label">3</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input name="urun_puan" id="urun_puan_3" type="radio" class="custom-control-input" value="4" aria-describedby="urun_puanHelpBlock" required="required"> 
														<label for="urun_puan_3" class="custom-control-label">4</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input name="urun_puan" id="urun_puan_4" type="radio" class="custom-control-input" value="5" aria-describedby="urun_puanHelpBlock" required="required"> 
														<label for="urun_puan_4" class="custom-control-label">5</label>
													</div> 
													<span id="urun_puanHelpBlock" class="form-text text-muted">Bu ürün ve hizmet için kaç puan veriyorsun.</span>
												</div>
											</div>
											<div class="form-group row">
												<label for="yorum_detay" class="col-4 col-form-label">Yorumun:</label> 
												<div class="col-8">
													<textarea id="yorum_detay" name="yorum_detay" cols="40" rows="5" required="required" class="form-control" aria-describedby="yorum_detayHelpBlock"></textarea> 
													<span id="yorum_detayHelpBlock" class="form-text text-muted">Ürün hakkında söylemek istediğin bir şey var ise lütfen doldur.</span>
												</div>
											</div> 
											<div class="form-group row">
												<div class="offset-4 col-8">
													<input type="hidden" name="urun_id" value="<?php echo $sipariscek['urun_id'] ?>">
													<input type="hidden" name="uye_id" value="<?php echo $kullanicicek['uye_id'] ?>">
													<input type="hidden" name="siparis_id" value="<?php echo $_GET['siparis_id'] ?>">
													<button name="urun_yorumyap" type="submit" class="btn btn-primary">Yorum Yap</button>
												</div>
											</div>
										</form>

									</div>
								</div>
							<?php }else{ ?>
								<div class="box">
									<p>
										<center>Yorum bölümü satın alınan ürüne onay verdikten sonra açılmaktadır.</center>
									</p>
								</div>
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