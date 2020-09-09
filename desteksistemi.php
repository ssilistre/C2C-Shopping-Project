<?php 
include 'themes/header.php';
include 'themes/navbar.php';

$biletsor=$db->prepare("SELECT * FROM destek where uye_id=:uye_id OR destek_durum=0 OR destek_durum=1 OR destek_durum=2 order by destek_id DESC LIMIT 10");
$biletsor->execute(array(
	'uye_id'=> $kullanicicek['uye_id']
));




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
						<h5 class="card-title mb-4">Destek Sistemi</h5>	

						<button type="button" class="btn btn-info" data-toggle="modal" data-target="#biletOlustur">
							Bilet Oluştur
						</button><br><br>

						<table class="table table-hover">
							<thead>
								<tr>	
									<th scope="col">#</th>
									<th scope="col">Bilet Konusu</th>
									<th scope="col">Bilet Detay</th>
									<th scope="col">Bilet Durum</th>
								</tr>
							</thead>
							<tbody>
								<?php while ($biletcek=$biletsor->fetch(PDO::FETCH_ASSOC)) {  @$say++;?>
									<tr>
										<th scope="col"><?php echo $say ?></th>
										<?php if ($biletcek['destek_durum']==0) {
											$durum='<span class="badge badge-danger">Yanıt Bekliyor.</span>';
										}else if ($biletcek['destek_durum']==1) {
											$durum='<span class="badge badge-secondary">İşlemde.</span>';
										}else if ($biletcek['destek_durum']==2) {
											$durum='<span class="badge badge-success">Cevaplandı.</span>';
										}?>
										<td><?php echo $biletcek['destek_konu'] ?></td>
										<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detaydestek<?php echo $say ?>">
											Talep İçeriği
										</button> </td>
										<td><?php echo $durum ?></td>
									</tr>
									<!-- Modal -->
									<div class="modal fade" id="detaydestek<?php echo $say ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Destek Detay Konu: <?php echo $biletcek['destek_konu'] ?></h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<?php 

													$biledetaysor=$db->prepare("SELECT * FROM destek_detay where destek_id=:destek_id LIMIT 10");
													$biledetaysor->execute(array(
														'destek_id'=> $biletcek['destek_id']
													));
													while ($biletdetaycek=$biledetaysor->fetch(PDO::FETCH_ASSOC)) {
														?>
														<div class="box">
															<p>
																<b>Talep: </b><?php echo $biletdetaycek['destek_detay_soru']?>
															</p>
														</div><br>
														<?php if (!$biletdetaycek['destek_detay_yanit']==""): ?>
															<div class="box">
																<p>
																	<b>Destek Ekibi: </b> <?php echo $biletdetaycek['destek_detay_yanit'] ?>
																	
																</p>
															</div>
														<?php endif ?>
														<br> 
													<?php } ?>
													<div class="box">
														<div class="form-group row">
															<label for="destek_detay" class="col-4 col-form-label">Ticket Yanıtınız:</label> 
															<div class="col-8">
																<form action="inc/action.php" method="post">
																	<textarea id="destek_detay" name="destek_detay_soru" cols="40" rows="5" class="ckeditor" aria-describedby="destek_detayHelpBlock" required="required"></textarea> 
																	<span id="destek_detayHelpBlock" class="form-text text-muted">Bu alana istediğinizi yazıp gönderebilirsiniz.</span>
																</div>
															</div> 
														</div> 
													</div>
													<div class="modal-footer">
														<input type="hidden" value="<?php echo $biletcek['destek_id'] ?>" name="destek_id">
														<button name="biletYanitla" type="submit" class="btn btn-primary">Yanıtla</button>
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
													</div>
												</form>
											</div>
										</div>
									</div>
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
<!-- Modal -->
<div class="modal fade" id="biletOlustur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Bilet Oluştur</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="inc/action.php" method="post">
					<div class="form-group row">
						<label for="destek_konu" class="col-4 col-form-label">Konu:</label> 
						<div class="col-8">
							<input id="destek_konu" name="destek_konu" placeholder="Ne olursa yardıma hazırız :)" type="text" class="form-control" required="required">
						</div>
					</div>
					<div class="form-group row">
						<label for="destek_detay" class="col-4 col-form-label">Mesajınız:</label> 
						<div class="col-8">
							<textarea id="destek_detay" name="destek_detay" cols="40" rows="5" class="ckeditor" aria-describedby="destek_detayHelpBlock" required="required"></textarea> 
							<span id="destek_detayHelpBlock" class="form-text text-muted">Bu alana istediğinizi yazıp gönderebilirsiniz.</span>
						</div>
					</div> 


				</div>
				<div class="modal-footer">
					<input type="hidden" name="uye_id" value="<?php echo $kullanicicek['uye_id'] ?>">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
					<button name="biletUret" type="submit" class="btn btn-primary">Gönder</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
include 'themes/footerust.php';
include 'themes/footer.php';
?>