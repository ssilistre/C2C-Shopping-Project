<?php 
include 'themes/header.php';
include 'themes/navbar.php';


$urunsor=$db->prepare("SELECT * FROM urun WHERE urum_onay=1 AND urun_durum=1 order by urun_id DESC LIMIT 8");
$urunsor->execute();


$_urunsoronecikar=$db->prepare("SELECT * FROM urun WHERE urum_onay=1 AND urun_durum=1 AND urun_onecikar=1 order by urun_id DESC LIMIT 5");
$_urunsoronecikar->execute();
$sayi_onecikar = $_urunsoronecikar->rowCount();



if ($sayi_onecikar==1) {
	$urunsoronecikar=$db->prepare("SELECT * FROM urun WHERE urum_onay=1 AND urun_durum=1 AND urun_onecikar=1 order by urun_id DESC LIMIT 5");
	$urunsoronecikar->execute();
}else{

$id = array_flip((int)$sayi_onecikar); // Dizideki anahtarlar ve degerleri yer değiştir
	$rastgele_id = array_rand($id, 5); //diziden rastgele 5 adet anahtar seç
	$rastgele_id = implode(',',$rastgele_id);
	$urunsoronecikar=$db->prepare("SELECT * FROM urun WHERE urun_id AND urum_onay=1 AND urun_durum=1 AND urun_onecikar=1 IN(' .$rastgele_id. ')");
	$urunsoronecikar->execute();

}










?>


<!-- ========================= SECTION MAIN ========================= -->
<section class="section-main bg padding-y">
	<div class="container">

		<div class="row">
			<aside class="col-md-3">
				<nav class="card">
					<ul class="menu-category">
						<li> <a href="listele?kategori=Anti-Cheat"><span class="badge badge-danger">Anti Cheat</span></a> </li>
						<li><a href="listele?kategori=Paket-Satisi"><span class="badge badge-primary">Paket Satışı</span></a></li>
						<li><a href="listele?kategori=Fivem-Keyi"><span class="badge badge-success">Fivem Key</span></a></li>
						<li><a href="listele?kategori=Bagisci-Paketleri"><span class="badge badge-warning">Bağışcı Paketleri</span></a></li>				
						<li><a href="listele?kategori=Tasarim-Isleri"><span class="badge badge-secondary">Tasarım İşleri</span></a></li>
						<li><a href="listele?kategori=Diger"><span class="badge badge-dark">Diğer Şeyler</span></a></li>

					</ul>
				</nav>
			</aside> <!-- col.// -->
			<div class="col-md-9">
				<article class="banner-wrap">
					<img src="themes/images/banners/last.png" class="w-100 rounded">
				</article>
			</div> <!-- col.// -->
		</div> <!-- row.// -->
	</div> <!-- container //  -->
</section>
<!-- ========================= SECTION MAIN END// ========================= -->

<!-- ========================= SECTION  ========================= -->

<section class="section-name padding-y-sm">
	<div class="container">

		<header class="section-heading">
			<a href="listele" class="btn btn-outline-primary float-right">Tüm Satılanlar</a>
			<h3 class="section-title">Satışta Olan Ürünler</h3>
		</header><!-- sect-heading -->

		<br>
		<br>

		<?php if ($sayi_onecikar>0) { ?>

			<div class="card card-body">
				<b>Öne  Çıkan Ürünler:</b>
				<div class="row">
					<?php while ($uruncekonecikar=$urunsoronecikar->fetch(PDO::FETCH_ASSOC)) { ?>
						<div class="col-md-3">
							<figure class="itemside mb-2">
								<div class="aside"><img src="themes/images/items/<?php echo $uruncekonecikar['urun_fotograf'] ?>" class="border img-sm"></div>
								<figcaption class="info align-self-center">
									<a href="<?=seo($uruncekonecikar['urun_ad']).'/'.$uruncekonecikar['urun_id']?>" class="title"><?php echo $uruncekonecikar['urun_ad']?></a>
									<strong class="price"><?php echo $uruncekonecikar['urun_fiyat']?> ₺</strong>
								</figcaption>
							</figure>
						</div> <!-- col.// -->
					<?php } ?>

				</div> <!-- row.// -->
			</div> <!-- card.// -->

			<br><br>
		<?php } ?>
		<div class="row">
			<?php while ($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) { ?>
				<div class="col-md-3">
					<div href="#" class="card card-product-grid">
						<a href="<?=seo($uruncek['urun_ad']).'/'.$uruncek['urun_id']?>" class="img-wrap"> <img src="themes/images/items/<?php echo $uruncek['urun_fotograf'] ?>"> </a>
						<figcaption class="info-wrap">
							<a href="<?=seo($uruncek['urun_ad']).'/'.$uruncek['urun_id']?>" class="title"><?php echo $uruncek['urun_ad'] ?></a>
							<div class="price mt-1"><?php echo $uruncek['urun_fiyat'] ?> ₺</div> <!-- price-wrap.// -->
						</figcaption>

					</div>
				</div> <!-- col.// -->



			<?php } ?>
		</div> <!-- row.// -->

	</div> <!-- row.// -->

</div><!-- container // -->
</section>
<!-- ========================= SECTION  END// ========================= -->



<?php
include 'themes/footerust.php';
include 'themes/footer.php';
?>