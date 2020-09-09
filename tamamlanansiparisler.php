<?php 
include 'themes/header.php';
include 'themes/navbar.php';



sessionKontrol();
$siparissor=$db->prepare("SELECT siparis.*,siparis_detay.*,uyeler.*,urun.* FROM siparis INNER JOIN siparis_detay ON siparis.siparis_id=siparis_detay.siparis_id INNER JOIN uyeler ON uyeler.uye_id=siparis_detay.kullanici_id INNER JOIN urun ON urun.urun_id=siparis_detay.urun_id where siparis.kullanici_idsatici=:kullanici_idsatici and siparis_detay.siparisdetay_onay=:onay order by siparis_zaman DESC");

$siparissor->execute(array(
	'kullanici_idsatici' => $kullanicicek['uye_id'],
	'onay' => 2
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
						<h5 class="card-title mb-4">Tamamlanan Siparişler </h5>	

						<table class="table table-hover">
							<thead>
								<tr>


									<th scope="col">Tarih</th>
									<th scope="col">Sipariş No</th>
									<th scope="col">Alıcı</th>
									<th scope="col">Ürün Ad</th>
									<th scope="col">Ürün Fiyat</th>
									<th scope="col">Detay</th>
									<th scope="col">Durum</th>
								</tr>
							</thead>
							<tbody>
								<?php while ($sipariscek=$siparissor->fetch(PDO::FETCH_ASSOC)) { @$say++;?>
									<tr>



										<td><?php echo $sipariscek['siparis_zaman']?></td>
										<td><?php echo $sipariscek['siparis_id']?></td>
										<td><?php echo $sipariscek['uye_steamisim']?></td>
										<td><?php echo $sipariscek['urun_ad']?></td>
										<td><?php echo $sipariscek['urun_fiyat']?></td>
										<?php if (!$sipariscek['siparisdetay_not']==""): ?>
											

											<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $say?>">
												Detay Notu
											</button> </td>
										<?php endif ?>
										<td><?php if ($sipariscek['siparisdetay_onay']==2) { ?>

											<button class="btn btn-success btn-xs">Tamamlandı</button></td>	
										</tr>
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