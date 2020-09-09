<?php 
if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {

    exit("Bu sayfaya erişim yasak");

}


?>
<article class="card mb-3">
	<div class="card-body">

		<figure class="icontext">
			<div class="icon">
				<img class="rounded-circle img-sm border" src="<?php echo $steamprofile['avatarfull']; ?>">
			</div>
			<div class="text">
				<strong><?php if ($kullanicicek['uye_adsoyad']=="") {
					echo $steamprofile['realname']; 
				}else{
					echo $kullanicicek['uye_adsoyad']; 
				} echo '';  if ($kullanicicek['uye_durum']>=2) {
					echo ' <img src="https://image.flaticon.com/icons/svg/2932/2932879.svg" alt="T.C Onaylı" width="24" height="24" />';
				}?></strong> <br> 
				<?php echo $kullanicicek['uye_mail'] ?> <br>
			</div>
		</figure>
		<hr>




		<article class="card-group">
			<figure class="card bg">
				<div class="p-3">
					<h5 class="card-title">Ürün Satışı Yapabilir mi ?</h5>
					<span><?php if ($kullanicicek['uye_yetki']>=1) {
						echo 'Yapabilir.';
					}else{
						echo 'Yapamaz.';
					} ?></span>
				</div>
			</figure>
			<figure class="card bg">
				<div class="p-3">
					<h5 class="card-title">Kaç Adet Ürün Ekleyebilir ?</h5>
					<span><?php echo $kullanicicek['uye_urunsayisi'] ?></span>
				</div>
			</figure>
			<figure class="card bg">
				<div class="p-3">
					<h5 class="card-title">Üyelik Tipi Nedir ?</h5>
					<span><?php 
					if ($kullanicicek['uye_yetki']==1) {
						echo 'Standart Üyelik';
					}elseif ($kullanicicek['uye_yetki']==2) {
						echo 'Pro Üyelik';
					}elseif ($kullanicicek['uye_yetki']==3) {
						echo 'Kurumsal Üyelik';
					}else{
						echo 'Sadece Alışveriş';
					}



					?></span>
				</div>
			</figure>
			<figure class="card bg">
				<div class="p-3">
					<h5 class="card-title"><?php if ($kullanicicek['uye_yetki']==0) {
						echo 'Satıcı Üyeliğine Başvurmak Istermisin ?';
					}else{
						echo 'Extra Özellik Satın Almak istermisin ?';
					} ?></h5>
					<span><?php if ($kullanicicek['uye_yetki']==0) {
						echo '<a href="saticibasvuru.php" class="btn rounded-pill btn-success">Başvuru Yap</a>';
					}else{
						echo '<a href="vip.php" class="btn rounded-pill btn-success">Özellik Al</a>';
					} ?></span>
				</div>
			</figure>
		</article>


	</div> <!-- card-body .// -->
				</article> <!-- card.// -->