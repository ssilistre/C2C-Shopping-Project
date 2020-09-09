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

				<article class="card  mb-3">
					<div class="card-body">
						<h5 class="card-title mb-4">Profilimi Düzenle </h5>	
						<?php if ($kullanicicek['uye_durum']==1) { ?>
							<div class="card">
								<div class="card-body">
									<h4 class="card-title">TC Doğrulama</h4>
									<form action="inc/action.php" method="post">
										<div class="form-group row">
											<label for="uye_tc" class="col-4 col-form-label">T.C Kimlik No:</label> 
											<div class="col-8">
												<div class="input-group">
													<div class="input-group-prepend">
														<div class="input-group-text">
															<i class="fa fa-address-card"></i>
														</div>
													</div> 
													<input id="uye_tc" name="uye_tc" placeholder="Yazınız." type="number" aria-describedby="uye_tcHelpBlock" required="required" class="form-control">
												</div> 
												<span id="uye_tcHelpBlock" class="form-text text-muted">Sistemde hiç bir şekilde kayıtlı tutulmamaktadır. Direk doğrulama işlemi için kullanılmaktadır.</span>
											</div>
										</div>
										<div class="form-group row">
											<label for="uye_ad" class="col-4 col-form-label">Ad:</label> 
											<div class="col-8">
												<input id="uye_ad" name="uye_ad" placeholder="Adınız örnek semih" type="text" class="form-control" required="required">
											</div>
										</div>
										<div class="form-group row">
											<label for="text" class="col-4 col-form-label">Soyadınız:</label> 
											<div class="col-8">
												<input id="text" name="uye_soyad" placeholder="Örnek akdkassda" type="text" class="form-control" required="required">
											</div>
										</div>
										<div class="form-group row">
											<label for="uye_dogumyili" class="col-4 col-form-label">Doğum Yılınız:</label> 
											<div class="col-8">
												<input id="uye_dogumyili" name="uye_dogumyili" placeholder="1994" type="number" class="form-control" aria-describedby="uye_dogumyiliHelpBlock"> 
												<span id="uye_dogumyiliHelpBlock" class="form-text text-muted">Sadece yılı yazmanız gerekiyor.</span>
											</div>
										</div> 
										<div class="form-group row">
											<div class="offset-4 col-8">
												<button name="tcdorula" type="submit" class="btn btn-primary">Doğrula</button>
											</div>
										</div>
									</form>
								</div> <!-- card-body.// -->
							</div>
						<?php } ?>
						<br>
						<!--- Profil Düzenleme-->
						<form action="inc/action.php" method="post">
							<div class="form-group row">
								<label for="uye_mail" class="col-4 col-form-label">Mail Adresin:</label> 
								<div class="col-8">
									<input id="uye_mail" name="uye_mail" placeholder="Mail Adresiniz @hotmail.com gibi" value="<?php echo $kullanicicek['uye_mail'] ?>" type="email" class="form-control" required="required" aria-describedby="uye_mailHelpBlock"> 
									<span id="uye_mailHelpBlock" class="form-text text-muted">Mail doğrulaması için gereklidir.</span>
								</div>
							</div>
							<div class="form-group row">
								<label for="uye_ceptel" class="col-4 col-form-label">Cep Telefonun:</label> 
								<div class="col-8">
									<input id="uye_ceptel" name="uye_ceptel" placeholder="05425425422" value="<?php echo $kullanicicek['uye_ceptel'] ?>" type="number" class="form-control" aria-describedby="uye_ceptelHelpBlock" required="required"> 
									<span id="uye_ceptelHelpBlock" class="form-text text-muted">SMS Doğrulaması için gereklidir.</span>
								</div>
							</div> 
							<div class="form-group row">
								<label class="col-4">Bildirimler Gelsin mi ?</label> 
								<div class="col-8">
									<div class="custom-control custom-radio custom-control-inline">
										<input name="uye_bildirim" id="uye_bildirim_0" type="radio" required="required" class="custom-control-input" value="1" aria-describedby="uye_bildirimHelpBlock"> 
										<label for="uye_bildirim_0" class="custom-control-label">Evet</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input name="uye_bildirim" id="uye_bildirim_1" type="radio" required="required" class="custom-control-input" value="0" aria-describedby="uye_bildirimHelpBlock"> 
										<label for="uye_bildirim_1" class="custom-control-label">Hayır</label>
									</div> 
									<span id="uye_bildirimHelpBlock" class="form-text text-muted">SMS ve Mail olarak siparişler bilgilendirme gelsin mi ? Not: 1 kere seçmeniz yeterlidir.</span>
								</div>
							</div> 
							<div class="form-group row">
								<div class="offset-4 col-8">
									<button name="profilguncelle" type="submit" class="btn btn-primary">Güncelle</button>
								</div>
							</div>
						</form>
						<!--- Profil Düzenleme bitiş -->
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