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
				$urunsor=$db->prepare("SELECT * FROM urun WHERE kullanici_id=:kullanici_id AND urum_onay=1");
				$urunsor->execute(array(
					'kullanici_id'=> $kullanicicek['uye_id']
				));


				?>
				<article class="card  mb-3">
					<div class="card-body">
						<h5 class="card-title mb-4">Satıştaki Ürünlerim </h5>	
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">Ürün Adı</th>
									<th scope="col">Ürün Açıklama</th>
									<th scope="col">Ürün Fiyat</th>
									<th scope="col">Ürün İşlemleri</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php while ($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) { ?>
										<td><?php echo $uruncek['urun_ad'] ?></td>
										<td><?php echo $uruncek['urun_aciklama'] ?></td>
										<td><?php echo $uruncek['urun_fiyat'] ?></td>
										<?php if ($uruncek['urun_durum']==0){ ?>
											<td><a href="inc/action.php?yayinla=ok&urun_id=<?php echo $uruncek['urun_id'] ?>"><span class="badge badge-danger">Yayına Al</span></a>
											<?php }else{ ?>
													<td><a href="inc/action.php?yayindankaldir=ok&urun_id=<?php echo $uruncek['urun_id'] ?>"><span class="badge badge-danger">Yayından Kaldır</span></a> 
														<?php } ?>|<a href="urunduzenle.php?urun_id=<?php echo $uruncek['urun_id'] ?>" ><span class="badge badge-info">Düzenle</span></a>   <?php if ($uruncek['urun_onecikar']==0) { ?>
															 
														 |<a href="inc/action.php?onecikar=ok&urun_id=<?php echo $uruncek['urun_id'] ?>"><span class="badge badge-success">Öne Çıkar</span></a></td><?php }?>
													</tr>






												<?php } ?>
											</tbody>
										</table>


										<span class="badge badge-dark">Öne Çıkartma Hakkı: <?php echo $kullanicicek['uye_onecikartmahak'] ?></span>
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