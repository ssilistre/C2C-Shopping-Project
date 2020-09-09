<?php 
include 'themes/header.php';
include 'themes/navbar.php';


sessionKontrol();
$siparissor=$db->prepare("SELECT * FROM siparis WHERE kullanici_id=:kullanici_id order by siparis_zaman DESC ");
$siparissor->execute(array(
	'kullanici_id'=> $kullanicicek['uye_id']
));




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
						<h5 class="card-title mb-4">Satın Aldıklarım </h5>	

						<table class="table table-hover">
							<thead>
								<tr>

									<th scope="col">Sipariş Tarihi</th>
									<th scope="col">Sipariş Numarası</th>
									<th scope="col">Detay</th>
								</tr>
							</thead>
							<tbody>
								<?php while ($sipariscek=$siparissor->fetch(PDO::FETCH_ASSOC)) { ?>
									<tr>



									<td><?php echo $sipariscek['siparis_zaman']?></td>
									<td><?php echo $sipariscek['siparis_id']?></td>
									<td><a href="siparisdetay.php?siparis_id=<?php echo $sipariscek['siparis_id'] ?>"><button class="btn btn-info btn-block">Detay</button></a></td>
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