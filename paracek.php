<?php 
include 'themes/header.php';
include 'themes/navbar.php';

sessionKontrol();
if ($kullanicicek['uye_yetki']==0) {
	header("Location:../index.php?durum=yetkinyok");
}

$paraceksor=$db->prepare("SELECT * FROM paracek where paracek_uyeid=:paracek_uyeid order by paracek_zaman DESC");
$paraceksor->execute(array(
	'paracek_uyeid'=> $kullanicicek['uye_id']
));









?>
<body>


	<section class="section-content padding-y">
		<div class="container">

			<header class="section-heading">
				<h2 class="section-title">Ücret İşlemleri</h2>
			</header><!-- sect-heading -->

			<article>

				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Para Çekimi Talep Et !</h4>
						<h5 class="card-subtitle mb-2 text-muted">Bakiyeniz : <?php echo $kullanicicek['uye_bakiye'].' ₺ ' ?></h5>
						<form action="inc/action.php" method="post">
							<div class="form-group row">
								<label for="paracek_miktar" class="col-4 col-form-label">Çekeceğiniz Miktar:</label> 
								<div class="col-8">
									<input id="paracek_miktar" name="paracek_miktar" placeholder="Üyelik tiplerine göre değişmektedir. En az default 50 tldir." type="number" class="form-control" required="required">
								</div>
							</div>
							<div class="form-group row">
								<label for="text" class="col-4 col-form-label">Ad Soyad:</label> 
								<div class="col-8">
									<input id="text" name="text" readonly="readonly" placeholder="Adınız soyadınız"  value="<?php echo $kullanicicek['uye_adsoyad']?> " type="text" class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<label for="iban" class="col-4 col-form-label">IBAN:</label> 
								<div class="col-8">
									<input id="iban" name="iban" readonly="readonly" value="<?php echo $kullanicicek['uye_iban']?>" type="text" class="form-control">
								</div>
							</div> 
							<div class="form-group row">
								<div class="offset-4 col-8">
									<input type="hidden" name="uye_id" value="<?php echo $kullanicicek['uye_id']?>">
									<input type="hidden" name="uye_bakiye" value="<?php echo $kullanicicek['uye_bakiye']?>">
									<button name="paracekistek" type="submit" class="btn btn-primary">Talep Gönder</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<br>

				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Bekleyen Talepler!</h5>
						<div class="alert alert-warning" role="alert">
							Standart Üyeliklerde Para 10 iş günü içinde hesabınıza geçer !
						</div>
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Miktar</th>
									<th scope="col">Talep Tarihi</th>
									<th scope="col">Talep Durumu</th>
								</tr>
							</thead>
							<tbody>
								<?php while ($paracekgetir=$paraceksor->fetch(PDO::FETCH_ASSOC)) {   ?>
									<tr>
										<th scope="row"> </th>
										<td><?php echo $paracekgetir['paracek_miktar'] ?></td>
										<td><?php echo $paracekgetir['paracek_zaman'] ?></td>
										<td><?php if ($paracekgetir['paracek_durum']==0 & $paracekgetir['paracek_onay']==0) { ?>
											<button class="btn btn-warning">Bekliyor</button>
											<?php	}else{ ?> 
												<button class="btn btn-success">Onaylandı</button>
									 <?php } ?>	 </td></tr>
									<?php } ?>	 
										 
								</tbody>
							</table>
						</div>
					</div>


				</article>

			</div> <!-- container .//  -->
		</section>
		<!-- ========================= SECTION CONTENT END// ========================= -->

		<?php
		include 'themes/footer.php';
		?>