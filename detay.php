<?php 
include 'themes/header.php';
include 'themes/navbar.php';

if (isset($_GET['urunid'])) {

	$urunsor=$db->prepare("SELECT * FROM urun where urun_id=:urun_id AND urum_onay=1 AND urun_durum=1 order by urun_id DESC");
	$urunsor->execute(array(
		'urun_id'=> $_GET['urunid']
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
<body>


	<section class="section-content padding-y">
		<div class="container">

			<header class="section-heading">
				<h2 class="section-title"><?php echo $uruncek['urun_ad'] ?></h2>
			</header><!-- sect-heading -->

			<article>

				<div class="card">
					<div class="row no-gutters">
						<aside class="col-md-6">
							<article class="gallery-wrap">
								<div class="img-big-wrap">
									<div> <a href="#"><img src="themes/images/items/<?php echo $uruncek['urun_fotograf'] ?>"></a></div>
									<meta name="keywords" content="<?php echo $uruncek['urun_keyword'] ?>">
								</div> <!-- slider-product.// -->
								<div class="thumbs-wrap">
									<div class="alert alert-warning" role="alert">
										<b>FivemCode Market Sadece Aracı olmaktadır. Ürünü teslim edicek kişi satıcıdır. Satın al dediğinizde bunu kabul etmiş olmaktasınız. Sorumluluk kabul edilmeyecektir.</b>
									</div>
								</div> <!-- slider-nav.// -->
							</article> <!-- gallery-wrap .end// -->
						</aside>
						<?php 

						$urunsay=$db->prepare("SELECT COUNT(urun_id) as say FROM siparis_detay where urun_id=:id");
						$urunsay->execute(array(
							'id' => $_GET['urunid']
						));

						$saycek=$urunsay->fetch(PDO::FETCH_ASSOC);



						?>
						<main class="col-md-6 border-left">
							<article class="content-body">
								<title><?php echo $uruncek['urun_ad'] ?></title>
								<h2 class="title"><?php echo $uruncek['urun_ad'] ?></h2>

								<div class="rating-wrap my-3">

									<small class="label-rating text-muted"><p> <b>Bu ürünü satan kişi: <?php echo $kulllanici['uye_steamisim'] ?>  </b></p></small>
									<small class="label-rating text-success"> <i class="fa fa-clipboard-check"></i> <?php echo $saycek['say'] ?> kez sipariş edildi.</small>
								</div> <!-- rating-wrap.// -->

								<div class="mb-3">
									<var class="price h4"><?php echo $uruncek['urun_fiyat'] ?> ₺</var>

								</div> <!-- price-detail-wrap .// -->

								<p><?php echo $uruncek['urun_aciklama'] ?></p>
								<p><?php echo $uruncek['urun_detay'] ?></p>


								<dl class="row">
									<?php if (!$uruncek['urun_stok']==0): ?>
										<dt class="col-sm-3">Stok Adet:</dt>
										<dd class="col-sm-9"><?php echo $uruncek['urun_stok'] ?></dd>
									<?php endif ?>
									
									<dt class="col-sm-12">Ürün Hızlı Linki: <span class="badge badge-light"><a href="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ?>"><?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ?></a></span></dt>
									<br><br><div class="sharethis-inline-share-buttons"></div>
								</dl>


								<div class="form-row">
									<div class="form-group col-md flex-grow-0">

										<div class="input-group mb-3 input-spinner">



										</div>
									</div> <!-- col.// -->

								</div> <!-- row.// -->
								<hr> 
								 
								<?php if (isset($_SESSION['steamid'])): ?>
									<?php if ($uruncek['kullanici_id']==$kullanicicek['uye_id']){ ?>

										<button name="bosgec" type="button" class="btn btn-primary">Kanka Kendi Ürününüde Satın Almazsın.</button>

									<?php }else{ ?>

										<form action="odeme.php" method="post">
											<input type="hidden" name="urun_id" value="<?php echo $uruncek['urun_id'] ?>">
											<button name="odemeyap" type="submit" class="btn btn-primary">Satın Al</button>
											<a href="mesajgonder?kullanici_gel=<?php echo $kulllanici['uye_id'] ?>" class="btn btn-info">Mesaj Gönder</a>
										</form>

									<?php } ?>
									<br>
								<?php endif ?>
								<?php if (!isset($_SESSION['steamid'])): ?>
									<p>Tüm sistemsel özellikleri görebilmek satın alma işlemi yapmak için üye girişi yapmış olmalısınız.</p>
								<?php endif ?>
							</article> <!-- product-info-aside .// -->
						</main> <!-- col.// -->
					</div> <!-- row.// -->
				</div> <!-- card.// -->
			</article><br>
			<div class="row">
				<div class="col-md-4">
					<article class="card card-body">
						<figure class="itemside">
							<div class="aside">
								<span class="icon-sm rounded-circle bg-primary">
									<i class="fa fa-money-bill-alt white"></i>
								</span>
							</div>
							<figcaption class="info">
								<h6 class="title">İADE Hakkı</h6>
								<p class="text-muted">5 İş günü içersinde bir sorunla karşılaşıldığında iade edilebilir. Aksi durumlarda edilemez. </p>
							</figcaption>
						</figure> <!-- iconbox // -->
					</article> <!-- panel-lg.// -->
				</div><!-- col // -->
				<div class="col-md-4">
					<article class="card card-body">
						<figure class="itemside">
							<div class="aside">
								<span class="icon-sm rounded-circle bg-secondary">
									<i class="fa fa-comment-dots white"></i>
								</span>
							</div>
							<figcaption class="info">
								<h6 class="title">Destek Hakkı </h6>
								<p class="text-muted">FivemCode arayüz hakkında destek olmaktadır. Ürün hakkında bir destek olamaz.</p>
							</figcaption>
						</figure> <!-- iconbox // -->
					</article> <!-- panel-lg.// -->
				</div><!-- col // -->
				<div class="col-md-4">
					<article class="card card-body">
						<figure class="itemside">
							<div class="aside">
								<span class="icon-sm rounded-circle bg-success">
									<i class="fa fa-truck white"></i>
								</span>
							</div>
							<figcaption class="info">
								<h6 class="title">Teslimat</h6>
								<p class="text-muted">Ürünü satıcı teslim etmektedir. Teslim aldıktan sonra satın aldıklarım menüsünden ürünü onaylayınız. </p>
							</figcaption>
						</figure> <!-- iconbox // -->
					</article> <!-- panel-lg.// -->
				</div><!-- col // -->
			</div><br>
			<!-- ============================ COMPONENT 2 END .// ================================= -->

			<?php 

			$yorumsor=$db->prepare("SELECT yorumlar.*,uyeler.* FROM yorumlar INNER JOIN uyeler ON yorumlar.kullanici_id=uyeler.uye_id where urun_id=:id AND yorum_onay=1 order by yorum_zaman DESC LIMIT 10");
			$yorumsor->execute(array(
				'id' => $_GET['urunid']
			));

			if (!$yorumsor->rowCount()) {

				echo '<div class="box">
				<p>
				Bu ürün için bir yorum yapılmadı !
				</p>
				</div>
				';
			}

			while($yorumcek=$yorumsor->fetch(PDO::FETCH_ASSOC)) { ?>
				<br>
				<div class="box">
					<ul class="rating-stars">
						<li style="width:80%" class="stars-active">
							<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></li>
							<li>
								<?php if ($yorumcek['yorum_puan']==5) {
									echo '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> 
									<i class="fa fa-star"></i></li>';
								}elseif ($yorumcek['yorum_puan']==4) {
									echo '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></li>';
								}elseif ($yorumcek['yorum_puan']==3) {
									echo '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></li>';
								}elseif ($yorumcek['yorum_puan']==2) {
									echo '<i class="fa fa-star"></i><i class="fa fa-star"></li>';
								}elseif ($yorumcek['yorum_puan']==1) {
									echo '<i class="fa fa-star"></i></li>';
								}?>
							</li>
						</ul>
						<p>
							<b>Kullanıcı Adı:<?php echo $yorumcek['uye_steamisim'] ?></b><br>
							<?php echo $yorumcek['yorum_detay'] ?>
						</p>
					</div>
				<?php } ?>
			</div> <!-- container .//  -->
		</section>
		<!-- ========================= SECTION CONTENT END// ========================= -->
		 
		<?php
		include 'themes/footer.php';
		?>