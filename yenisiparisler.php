<?php 
include 'themes/header.php';
include 'themes/navbar.php';


sessionKontrol();

$siparissor=$db->prepare("SELECT siparis.*,siparis_detay.*,uyeler.*,urun.* FROM siparis INNER JOIN siparis_detay ON siparis.siparis_id=siparis_detay.siparis_id INNER JOIN uyeler ON uyeler.uye_id=siparis_detay.kullanici_id INNER JOIN urun ON urun.urun_id=siparis_detay.urun_id where siparis.kullanici_idsatici=:kullanici_idsatici and siparis_detay.siparisdetay_onay=:onay or siparis_detay.siparisdetay_onay=:onays order by siparis_zaman DESC");

$siparissor->execute(array(
	'kullanici_idsatici' => $kullanicicek['uye_id'],
	'onay' => 0,
	'onays' => 1
));


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
				<article class="card  mb-3">
					<div class="card-body">
						<h5 class="card-title mb-4">Yeni Siparişler </h5>	

						<table class="table table-hover">
							<thead>
								<tr>

									<th scope="col">#</th>
									<th scope="col">Tarih</th>
									<th scope="col">Sipariş No</th>
									<th scope="col">Alıcı</th>
									<th scope="col">Ürün Ad</th>
									<th scope="col">Ürün Fiyat</th>
									<th scope="col">Detay Notu</th>
									<th scope="col">Durum</th>
								</tr>
							</thead>
							<tbody>
								<?php while ($sipariscek=$siparissor->fetch(PDO::FETCH_ASSOC)) { @$say++;?>
									<tr>


										<td><?php echo $say ?></td>
										<td><?php echo $sipariscek['siparis_zaman']?></td>
										<td><?php echo $sipariscek['siparis_id']?></td>
										<td><?php echo $sipariscek['uye_steamisim']?></td>
										<td><?php echo $sipariscek['urun_ad']?></td>	
										<td><?php echo $sipariscek['urun_fiyat']?></td>
										<?php if (!$sipariscek['siparisdetay_not']==""): ?>
											

											<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $say ?>">
												Sipariş Detay Notu
											</button> </td>
										<?php endif ?>
										<td><?php if ($sipariscek['siparisdetay_onay']==0) { ?>
											<form action="inc/action.php" method="post"> 
												<input type="hidden" name="urun_fiyat" value="<?php echo $sipariscek['siparisdetay_id']?>">
												<input type="hidden" name="siparis_uyeid" value="<?php echo $sipariscek['uye_id']?>">
												<input type="hidden" name="siparis_id" value="<?php echo $sipariscek['siparis_id']?>">
												<input type="hidden" name="urun_fiyat" value="<?php echo $sipariscek['urun_fiyat']?>">
												<button type="submit" name="urunteslim" class="btn btn-warning btn-xs">Onay Ver</button>
												<button type="submit" name="uruniptal" class="btn btn-danger btn-xs">İade Et</button></form>
											<?php }else if ($sipariscek['siparisdetay_onay']==1){  ?> 
												<button class="btn btn-success btn-xs">Alıcıdan Onay Bekliyor</button>



											</tr>
											<?php } ?>
											<!-- Modal -->
											<div class="modal fade" id="exampleModal<?php echo $say?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">Sipariş Not Detayı:</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<?php echo $sipariscek['siparisdetay_not']?>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
														</div>
													</div>
												</div>
											</div>
											 
										<?php } ?>
									 
								</tbody>
							</table>


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