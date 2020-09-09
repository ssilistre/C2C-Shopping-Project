<?php 
include 'themes/header.php';
include 'themes/navbar.php';

$kategorisor=$db->prepare("SELECT * FROM kategori order by kategori_sira ASC");
$kategorisor->execute();

$arama=$_POST['aramayap'];


 
	$kategoriName="Tüm Ürünler";

	$urunsor=$db->prepare("SELECT * FROM urun WHERE urun_ad Like ? AND urum_onay=1 AND urun_durum=1 order by urun_id DESC");
	$urunsor->execute(array(
		"%$arama%"
	));


	  




?>

<!-- ========================= SECTION PAGETOP ========================= -->
<section class="section-pagetop bg">
	<div class="container">
		<h2 class="title-page"><?php echo $kategoriName; ?></h2>

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
					<article class="filter-group">
						<header class="card-header">
							<a href="#" data-toggle="collapse" data-target="#collapse_2" aria-expanded="true" class="">
								<i class="icon-control fa fa-chevron-down"></i>
								<h6 class="title">Brands </h6>
							</a>
						</header>
						<div class="filter-content collapse show" id="collapse_2" style="">
							<div class="card-body">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" checked="" class="custom-control-input">
									<div class="custom-control-label">Mercedes  
										<b class="badge badge-pill badge-light float-right">120</b>  </div>
									</label>
									<label class="custom-control custom-checkbox">
										<input type="checkbox" checked="" class="custom-control-input">
										<div class="custom-control-label">Toyota 
											<b class="badge badge-pill badge-light float-right">15</b>  </div>
										</label>
										<label class="custom-control custom-checkbox">
											<input type="checkbox" checked="" class="custom-control-input">
											<div class="custom-control-label">Mitsubishi 
												<b class="badge badge-pill badge-light float-right">35</b> </div>
											</label>
											<label class="custom-control custom-checkbox">
												<input type="checkbox" checked="" class="custom-control-input">
												<div class="custom-control-label">Nissan 
													<b class="badge badge-pill badge-light float-right">89</b> </div>
												</label>
												<label class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input">
													<div class="custom-control-label">Honda 
														<b class="badge badge-pill badge-light float-right">30</b>  </div>
													</label>
												</div> <!-- card-body.// -->
											</div>
										</article> <!-- filter-group .// -->
										<article class="filter-group">
											<header class="card-header">
												<a href="#" data-toggle="collapse" data-target="#collapse_3" aria-expanded="true" class="">
													<i class="icon-control fa fa-chevron-down"></i>
													<h6 class="title">Price range </h6>
												</a>
											</header>
											<div class="filter-content collapse show" id="collapse_3" style="">
												<div class="card-body">
													<input type="range" class="custom-range" min="0" max="100" name="">
													<div class="form-row">
														<div class="form-group col-md-6">
															<label>Min</label>
															<input class="form-control" placeholder="$0" type="number">
														</div>
														<div class="form-group text-right col-md-6">
															<label>Max</label>
															<input class="form-control" placeholder="$1,0000" type="number">
														</div>
													</div> <!-- form-row.// -->
													<button class="btn btn-block btn-primary">Apply</button>
												</div><!-- card-body.// -->
											</div>
										</article> <!-- filter-group .// -->
										<article class="filter-group">
											<header class="card-header">
												<a href="#" data-toggle="collapse" data-target="#collapse_4" aria-expanded="true" class="">
													<i class="icon-control fa fa-chevron-down"></i>
													<h6 class="title">Sizes </h6>
												</a>
											</header>
											<div class="filter-content collapse show" id="collapse_4" style="">
												<div class="card-body">
													<label class="checkbox-btn">
														<input type="checkbox">
														<span class="btn btn-light"> XS </span>
													</label>

													<label class="checkbox-btn">
														<input type="checkbox">
														<span class="btn btn-light"> SM </span>
													</label>

													<label class="checkbox-btn">
														<input type="checkbox">
														<span class="btn btn-light"> LG </span>
													</label>

													<label class="checkbox-btn">
														<input type="checkbox">
														<span class="btn btn-light"> XXL </span>
													</label>
												</div><!-- card-body.// -->
											</div>
										</article> <!-- filter-group .// -->
										<article class="filter-group">
											<header class="card-header">
												<a href="#" data-toggle="collapse" data-target="#collapse_5" aria-expanded="false" class="">
													<i class="icon-control fa fa-chevron-down"></i>
													<h6 class="title">More filter </h6>
												</a>
											</header>
											<div class="filter-content collapse in" id="collapse_5" style="">
												<div class="card-body">
													<label class="custom-control custom-radio">
														<input type="radio" name="myfilter_radio" checked="" class="custom-control-input">
														<div class="custom-control-label">Any condition</div>
													</label>

													<label class="custom-control custom-radio">
														<input type="radio" name="myfilter_radio" class="custom-control-input">
														<div class="custom-control-label">Brand new </div>
													</label>

													<label class="custom-control custom-radio">
														<input type="radio" name="myfilter_radio" class="custom-control-input">
														<div class="custom-control-label">Used items</div>
													</label>

													<label class="custom-control custom-radio">
														<input type="radio" name="myfilter_radio" class="custom-control-input">
														<div class="custom-control-label">Very old</div>
													</label>
												</div><!-- card-body.// -->
											</div>
										</article> <!-- filter-group .// -->
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
											while ($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) {

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
															<a href="detay.php?urunid=<?php echo $uruncek['urun_id'] ?>" class="img-wrap"><img src="themes/images/items/<?php echo $uruncek['urun_fotograf'] ?>"></a>
														</aside> <!-- col.// -->
														<div class="col-md-6">
															<div class="info-main">
																<a href="detay.php?urunid=<?php echo $uruncek['urun_id'] ?>" class="h5 title"> <?php echo $uruncek['urun_ad'] ?>  </a>


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
																	<a href="detay.php?urunid=<?php echo $uruncek['urun_id'] ?>" class="btn btn-primary btn-block"> Detayları Gör </a>
																	<a href="#" class="btn btn-light btn-block"><i class="fa fa-heart"></i> 
																		<span class="text">Sepete Ekle</span> 
																	</a>
																</p>
															</div> <!-- info-aside.// -->
														</aside> <!-- col.// -->
													</div> <!-- row.// -->
												</article> 
												<!-- urun bitis// -->
											<?php }	?>


											<nav aria-label="Page navigation sample">
												<ul class="pagination">
													<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
													<li class="page-item active"><a class="page-link" href="#">1</a></li>
													<li class="page-item"><a class="page-link" href="#">2</a></li>
													<li class="page-item"><a class="page-link" href="#">3</a></li>
													<li class="page-item"><a class="page-link" href="#">Next</a></li>
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