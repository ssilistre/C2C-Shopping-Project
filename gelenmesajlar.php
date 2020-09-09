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
				$mesajsor=$db->prepare("SELECT mesaj.*,uyeler.* FROM mesaj INNER JOIN uyeler ON mesaj.kullanici_gon=uyeler.uye_id where mesaj.kullanici_gel=:id order by mesaj_okuma,mesaj_zaman DESC");
				$mesajsor->execute(array(
					'id'=> $kullanicicek['uye_id']
				));


				?>
				<article class="card  mb-3">
					<div class="card-body">
						<h5 class="card-title mb-4">Gelen Mesajlar </h5>	
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">Mesaj Tarihi</th>
									<th scope="col">Gönderen</th>
									<th scope="col">Durum</th>
									<th scope="col">Detay</th>
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php while ($mesajcek=$mesajsor->fetch(PDO::FETCH_ASSOC)) { ?>
										<td><?php echo $mesajcek['mesaj_zaman'] ?></td>
										<td><?php echo $mesajcek['uye_steamisim'] ?></td>
										<td><?php if ($mesajcek['mesaj_okuma']==0) { ?>
											  <i style="color:green" class="fa fa-circle" aria-hidden="true">
										<?php }else { ?>
											 <i class="fa fa-circle" aria-hidden="true">

											<?php }?></td>


										<td><a href="mesajdetay.php?mesaj_id=<?php echo $mesajcek['mesaj_id'] ?>&kullanici_gon=<?php echo $mesajcek['kullanici_gon'] ?>"><span class="badge badge-info">Mesajı Oku</span></a>
											<td><a onclick="return confirm('Bu mesajı silmek istiyormusunuz? \n İşlem geri alınamaz...')" href="inc/action.php?gelenmesajsil=ok&mesaj_id=<?php echo $mesajcek['mesaj_id'] ?>"><button class="btn btn-danger btn-xs">Sil</button></a></td>
										</td> 
									</tr>






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