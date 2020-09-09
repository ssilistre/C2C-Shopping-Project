<?php require ('steamauth/steamauth.php'); 

if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {

    exit("Bu sayfaya erişim yasak");

}

?>
<body>


	<header class="section-header">

		<section class="header-main border-bottom">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-2 col-4">
						<a href="index" class="brand-wrap">
							<img class="logo" src="themes/images/logos/logo.png">
						</a> <!-- brand-wrap.// -->
					</div>
					<div class="col-lg-6 col-sm-12">
						<form action="arama.php" class="search" method="post">
							<div class="input-group w-100">
								<input type="text" class="form-control"  name="aramayap" placeholder="Arama Yap">
								<div class="input-group-append">
									<button class="btn btn-primary" type="submit" name="ara">
										<i class="fa fa-search"></i>
									</button>
								</div>
							</div>
						</form> <!-- search-wrap .end// -->
					</div> <!-- col.// -->
					<div class="col-lg-4 col-sm-6 col-12">
						<?php
						if(isset($_SESSION['steamid'])) { ?>

							<div class="widgets-wrap float-md-right">
								<div class="widget-header  mr-3">
									<a href="gelenmesajlar.php" class="icon icon-sm rounded-circle border"><i class="fa fa-envelope "></i></a>
									<span class="badge badge-pill badge-danger notify">
										<?php 
										require 'inc/uyebilgicek.php';
										$mesajsay=$db->prepare("SELECT COUNT(mesaj_okuma) as say FROM mesaj where mesaj_okuma=:id and kullanici_gel=:kullanici_id");
										$mesajsay->execute(array(
											'id' => 0,
											'kullanici_id' => $kullanicicek['uye_id']
										));

										$saycek=$mesajsay->fetch(PDO::FETCH_ASSOC);

										echo $saycek['say'];

										?>
									</span>
								</div>
								<div class="widgets-wrap float-md-right">
									<div class="widget-header  mr-3">
										<a href="#" data-toggle="dropdown" data-offset="20,10" class="icon icon-sm rounded-circle border"><i class="fa fa-bell " ></i></a>
										<span class="badge badge-pill badge-danger notify">
											<?php 

											$bildirimsay=$db->prepare("SELECT COUNT(bildirim_okuma) as say FROM bildirim where bildirim_okuma=:id and bildirim_kime=:kullanici_id");
											$bildirimsay->execute(array(
												'id' => 0,
												'kullanici_id' => $kullanicicek['uye_id']
											));

											$bildirimsaycek=$bildirimsay->fetch(PDO::FETCH_ASSOC);


											echo $bildirimsaycek['say'];


											$bildirimsor=$db->prepare("SELECT * FROM bildirim where bildirim_kime=:bildirim_kime order by bildirim_zaman DESC");
											$bildirimsor->execute(array(
												'bildirim_kime'=> $kullanicicek['uye_id']
											));


											?>
										</span>
										<div class="dropdown-menu dropdown-menu-right">
											<?php while ($bildirimcek=$bildirimsor->fetch(PDO::FETCH_ASSOC)) { ?>
												<a class="dropdown-item" href="inc/action.php?bildirimoku=ok&bildirim_id=<?php echo $bildirimcek['bildirim_id'] ?>"><?php echo $bildirimcek['bildirim_detay'] ?></a>
											<?php } ?>
										</div> <!--  dropdown-menu .// -->
									</div>
								<?php  } ?>

								<div class="widget-header icontext">

									<div class="text">
										<?php
										if(!isset($_SESSION['steamid'])) {


    loginbutton("rectangle"); //login button
    
}  else {

	require ('steamauth/userInfo.php');
	echo '<img class="icon icon-sm rounded-circle border" src="'.$steamprofile['avatarfull'].'" alt="Profil Resmin" width="36" height="36">';
    //Protected content
	echo "Bakiye: ".$kullanicicek['uye_bakiye'].'₺ '.'<a href="logout"><b>Çıkış Yap</b></a>';

}    
?>  

<div> 

</div>
</div>
</div>

</div> <!-- widgets-wrap.// -->
</div> <!-- col.// -->
</div> <!-- row.// -->
</div> <!-- container.// -->
</section> <!-- header-main .// -->
</header> <!-- section-header.// -->


<nav class="navbar navbar-main navbar-expand-lg navbar-light border-bottom">
	<div class="container">

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav" aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="main_nav">
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link" href="index"><img src="https://image.flaticon.com/icons/svg/2885/2885645.svg" width="18" height="18" /> Anasayfa</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="onemlibilgilendirme"><img src="https://thumbs.gfycat.com/UniqueSizzlingFinwhale.webp" alt="" width="16" height="14" /> Önemli Bilgilendirme ! <img src="https://thumbs.gfycat.com/UniqueSizzlingFinwhale.webp" alt="" width="16" height="14" /></a>
				</li>
				<?php
				if(isset($_SESSION['steamid'])) { ?>
					<li class="nav-item">
						<a class="nav-link" href="bakiyeyukle"><img src="https://image.flaticon.com/icons/svg/845/845665.svg" width="18" height="18" /> Bakiye Yükle</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="profilim"><img src="https://image.flaticon.com/icons/svg/892/892781.svg" width="18" height="18" /> Profilim</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="desteksistemi"><img src="https://image.flaticon.com/icons/svg/1828/1828833.svg" width="18" height="18" /> Destek Talebi</a>
					</li>
					<?php if ($kullanicicek['uye_yetki']>=1) { ?>
						<li class="nav-item">
							<a class="nav-link" href="paracek"><img src="https://image.flaticon.com/icons/svg/639/639365.svg" width="18" height="18" /> Para Çek</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="urunekle"><img src="https://image.flaticon.com/icons/svg/2898/2898108.svg" width="18" height="18" /> Ürün Sat</a>
						</li>
					<?php } ?>
				<?php } ?>
			</ul>
		</div> <!-- collapse .// -->
	</div> <!-- container .// -->
</nav>

</header> <!-- section-header.// -->
