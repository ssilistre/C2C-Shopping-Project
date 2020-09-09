<?php 
include 'themes/header.php';
include 'themes/navbar.php';
?>
<body>


	<section class="section-content padding-y">
		<div class="container">

			<header class="section-heading">
				<h2 class="section-title">Ekstra Özellik Alın!</h2>
			</header><!-- sect-heading -->

			<article>


				<div class="card-deck mb-3 text-center">
					<div class="card">
						<div class="card-header">
							<h5 class="my-0">1 Adet Ürün Ekleme</h5>
						</div>
						<div class="card-body">
							<h1 class="card-title pricing-card-title">5 ₺ <small class="text-muted">/ Adet</small></h1>
							<ul class="list-unstyled mt-3 mb-4">
								<li>Ürün Ekleme Hakkı</li>
								<li>Daha fazla ürün ekleyebilirsiniz.</li>
								<span class="badge badge-info"> Şuan ki üyelik tipiniz.</span>
							</ul>
							<?php if (isset($_SESSION['steamid'])) { ?>
								<form action="inc/action.php" method="post">
									<input type="hidden" value="<?php echo $kullanicicek['uye_urunsayisi'] ?>" name="uye_urunsayisi">
									<input type="hidden" value="<?php echo $kullanicicek['uye_bakiye'] ?>" name="uye_bakiye">
									<input type="hidden" value="<?php echo $kullanicicek['uye_id'] ?>" name="uye_id">
									<button name="urunhaksatinal" type="submit" class="btn btn-block btn-primary">Şimdi Satın Al</button>
								</form>
							<?php }else{ ?>
								<button name="bos" type="submit" class="btn btn-block btn-primary">Önce Giriş Yapınız !</button>
							<?php } ?>
						</div>
					</div>
					<div class="card">
						<div class="card-header">
							<h5 class="my-0">1 Adet Öne Çıkartma Hakkı</h5> 
						</div>
						<div class="card-body">
							<h1 class="card-title pricing-card-title">10 ₺<small class="text-muted">/ Adet</small></h1>
							<ul class="list-unstyled mt-3 mb-4">
								<li>Ürünlerinizi anasayfaya taşıyın !</li>
								<li>1 Kere kullanılabilen bir şeydir !</li>
								<span class="badge badge-info"> Site bakiyesi ile satın alınabilir.</span>
							</ul>
							<?php if (isset($_SESSION['steamid'])) { ?>
								<form action="inc/action.php" method="post">
									<input type="hidden" value="<?php echo $kullanicicek['uye_onecikartmahak'] ?>" name="uye_onecikartmahak">
									<input type="hidden" value="<?php echo $kullanicicek['uye_bakiye'] ?>" name="uye_bakiye">
									<input type="hidden" value="<?php echo $kullanicicek['uye_id'] ?>" name="uye_id">
									<button name="onecikartmahaksatinal" type="submit" class="btn btn-block btn-primary">Şimdi Satın Al</button>
								</form>
							<?php }else{ ?>
								<button name="bos" type="submit" class="btn btn-block btn-primary">Önce Giriş Yapınız !</button>
							<?php } ?>
						</div>
					</div>
					<div class="card">
						<div class="card-header">
							<h5 class="my-0">Vip Üyelik</h5>
						</div>
						<div class="card-body">
							<h1 class="card-title pricing-card-title">55 ₺ <small class="text-muted">/ Aylık</small></h1>
							<ul class="list-unstyled mt-3 mb-4">
								<li>10 Ürün Ekleme</li>
								<li>10 TL para çekim limiti</li>
								<li>3 Ürün Anasayfada Öne Çıkartma</li>
								<li>Kazanılan Para 5 iş günü içersinde hesaba geçer.</li>
								<span class="badge badge-info"> Site bakiyesi ile satın alınabilir.</span>
							</ul>
							<a href="#" disabled="" class="btn btn-block btn-light">Şu an için kapalı !</a>
						</div>
					</div>
				</div> <!-- card-deck.// -->

				<!-- ============================ COMPONENT PRICING 1 END .// ================================= -->

				<br><br>


			</div> <!-- col.// -->
		</div> <!-- row.// -->

	</article>

</div> <!-- container .//  -->
</section>
<!-- ========================= SECTION CONTENT END// ========================= -->

<?php
include 'themes/footer.php';
?>