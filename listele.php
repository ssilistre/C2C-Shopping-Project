<?php 
include 'themes/header.php';
include 'themes/navbar.php';

$kategorisor=$db->prepare("SELECT * FROM kategori order by kategori_sira ASC");
$kategorisor->execute();


if (isset($_GET['kategori'])) {

	$kategoriName=$_GET['kategori'];

	$kategoriad=$db->prepare("SELECT * FROM kategori WHERE kategori_ad=:kategori_ad");
	$kategoriad->execute(array(
		'kategori_ad'=> $kategoriName
	));
	$kategori=$kategoriad->fetch(PDO::FETCH_ASSOC);

	
	$urunsor=$db->prepare("SELECT * FROM urun where kategori_id=:kategori_id AND urum_onay=1 AND urun_durum=1 order by urun_id DESC");
	$urunsor->execute(array(
		'kategori_id'=> $kategori['kategori_id']
	));

	$sayi = $urunsor->rowCount(); 
	if ($sayi==0) {
		header('location:index.php');
	}

}else{

	$kategoriName="Tüm Ürünler";

	$urunsor=$db->prepare("SELECT * FROM urun where urum_onay=1 AND urun_durum=1 order by urun_id DESC");
	$urunsor->execute();

}


$toplamVeri = $db->query("SELECT * FROM urun where urum_onay=1 AND urun_durum=1 order by urun_id DESC")->fetchColumn();
$goster = 10;
$toplamSayfa = ceil($toplamVeri / $goster);
$sayfa = @$_GET["s"];
if($sayfa < 1) $sayfa = 1; 
if($sayfa > $toplamSayfa)
{
	$sayfa = (int)$toplamSayfa;
}
$limit = ($sayfa - 1) * $goster;

$veriler = $db->prepare("SELECT * FROM urun order by urun_id DESC LIMIT :basla, :bitir");
$veriler->bindValue(":basla",$limit,PDO::PARAM_INT);
$veriler->bindValue(":bitir",$goster,PDO::PARAM_INT);
$veriler->execute();




?>

<!-- ========================= SECTION PAGETOP ========================= -->
<section class="section-pagetop bg">
	<div class="container">
		<h2 class="title-page"><?php echo $kategoriName." kategorisindeki ürünler listeleniyor."; ?></h2>

	</div> <!-- container //  -->
</section>
<!-- ========================= SECTION INTRO END// ========================= -->

<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">
	<div class="container">

		<div class="row">
			<aside class="col-md-3">

				<div class="card">
					<article class="filter-group">
						<header class="card-header">
							<a href="#" data-toggle="collapse" data-target="#collapse_1" aria-expanded="true" class="">
								<i class="icon-control fa fa-chevron-down"></i>
								<h6 class="title">Kategoriler</h6>
							</a>
						</header>
						<div class="filter-content collapse show" id="collapse_1" style="">
							<div class="card-body">

								<ul class="list-menu">
									<?php 
									while ($kategoricek=$kategorisor->fetch(PDO::FETCH_ASSOC)) {

										?>
										<li><a href="listele.php?kategori=<?php echo $kategoricek['kategori_ad']?>"><?php echo $kategoricek['kategori_ad'] ?></a></li>
									<?php } ?>
								</ul>

							</div> <!-- card-body.// -->
						</div>
					</article> <!-- filter-group  .// -->

				</div> <!-- card.// -->

			</aside> <!-- col.// -->
			<main class="col-md-9">

				<header class="border-bottom mb-4 pb-3">
					<div class="form-inline">

						<select class="mr-2 form-control">
							<option>Latest items</option>
							<option>Trending</option>
							<option>Most Popular</option>
							<option>Cheapest</option>
						</select>
						<div class="btn-group">
							<a href="#" class="btn btn-outline-secondary active" data-toggle="tooltip" title="List view"> 
								<i class="fa fa-bars"></i></a>
								<a href="#" class="btn  btn-outline-secondary" data-toggle="tooltip" title="Grid view"> 
									<i class="fa fa-th"></i></a>
								</div>
							</div>
						</header><!-- sect-heading -->


						<!-- urun baslangic -->
						<?php 
						while ($uruncek=$veriler->fetch(PDO::FETCH_ASSOC)) {

							$satici_id=$uruncek['kullanici_id'];

							$kullanicisor=$db->prepare("SELECT * FROM uyeler WHERE uye_id=:uye_id");
							$kullanicisor->execute(array(
								'uye_id'=> $satici_id
							));
							$kulllanici=$kullanicisor->fetch(PDO::FETCH_ASSOC);


							?>
							<article class="card card-product-list">
								<div class="row no-gutters">
									<aside class="col-md-3">
										<a href="<?=seo($uruncek['urun_ad']).'/'.$uruncek['urun_id']?>" class="img-wrap"><img src="themes/images/items/<?php echo $uruncek['urun_fotograf'] ?>"></a>
									</aside> <!-- col.// -->
									<div class="col-md-6">
										<div class="info-main">
											<a href="<?=seo($uruncek['urun_ad']).'/'.$uruncek['urun_id']?>" class="h5 title"> <?php echo $uruncek['urun_ad'] ?>  </a>


											<p> <?php echo $uruncek['urun_aciklama'] ?> </p><br>
											<p> <b>Satıcı: <?php echo $kulllanici['uye_steamisim'] ?>  </b></p>
										</div> <!-- info-main.// -->
									</div> <!-- col.// -->
									<aside class="col-sm-3">
										<div class="info-aside">
											<div class="price-wrap">
												<span class="price h5"> <?php echo $uruncek['urun_fiyat'] ?> ₺ </span>	
											</div> <!-- info-price-detail // -->
											<p class="text-success">Digital Ürün</p>
											<br>
											<p>
												<a href="<?=seo($uruncek['urun_ad']).'/'.$uruncek['urun_id']?>" class="btn btn-primary btn-block"> Detayları Gör </a>

											</p>
										</div> <!-- info-aside.// -->
									</aside> <!-- col.// -->
								</div> <!-- row.// -->
							</article> 
							<!-- urun bitis// -->
						<?php }	?>

<nav aria-label="Page navigation sample">
							<ul class="pagination">
							<?php 
							for($i = 1; $i<=$toplamSayfa;$i++)
							{
								?>
								 
								<li class="page-item"><a class="page-link" href="listele.php?s=<?php echo $i;?>"><?php echo $i;?></a></li>
								<?php
							}
							?>

						</ul>
						</nav>
						 

					</main> <!-- col.// -->

				</div>

			</div> <!-- container .//  -->
		</section>
		<!-- ========================= SECTION CONTENT END// ========================= -->

		<?php
		include 'themes/footer.php';
		?>