<?php 
if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {

	exit("Bu sayfaya erişim yasak");

}

?>
<!-- ========================= FOOTER ========================= -->
<footer class="section-footer border-top">
	<div class="container">
		<section class="footer-top padding-y">
			<div class="row">
				<aside class="col-md col-6">
					<h6 class="title">Şikayet Hattı</h6>
					<ul class="list-unstyled">
						<li> <a href="dolandiricisikayet">Dolandırıcı Şikayet</a></li>
						<li> <a data-toggle="modal" data-target="#reklam" href="#">Reklam Alanları</a></li>
					</ul>
				</aside>
				<aside class="col-md col-6">
					<h6 class="title">Haklar</h6>
					<ul class="list-unstyled">
						<li> <a href="iadetalepet">İade Talep Etme</a></li>
						<li> <a href="#">Ürün Onaylama</a></li>

					</ul>
				</aside>
				<aside class="col-md col-6">
					<h6 class="title">Destek Sistemi</h6>
					<ul class="list-unstyled">
						<li> <a data-toggle="modal" data-target="#iletisim" href="#">Bizimle İletişime Geç</a></li>
						<li> <a data-toggle="modal" data-target="#sss" href="#">Sıkça Sorulan Sorular</a></li>
					</ul>
				</aside>
				<aside class="col-md col-6">
					<h6 class="title">Hesap İşlemleri</h6>
					<ul class="list-unstyled">
						<li> <a href="saticibasvuru.php"> Satıcı Başvurusu </a></li>
						<li> <a href="vip.php"> Extra Özellikler </a></li>
					</ul>
				</aside>
				<aside class="col-md">
					<h6 class="title">Sosyal Medya</h6>
					<ul class="list-unstyled">
						<li><a href="<?php echo $ayarcek['ayar_discord'] ?>"> <i class="fab fa-discord"></i> Discord </a></li>
						<li><a href="<?php echo $ayarcek['ayar_youtube'] ?>"> <i class="fab fa-youtube"></i> Youtube </a></li>
					</ul>
				</aside>
			</div> <!-- row.// -->
		</section>	<!-- footer-top.// -->

		<section class="footer-bottom border-top row">
			<div class="col-md-2">
				<p class="text-muted"> &copy 2020 FivemCode </p>
			</div>
			<div class="col-md-8 text-md-center">
				<span  class="px-2">bilgilendirme@fivemcode.com</span>

			</div>
			<div class="col-md-2 text-md-right text-muted">
				<i class="fab fa-lg fa-cc-visa"></i>
				<i class="fab fa-lg fa-cc-paypal"></i>
				<i class="fab fa-lg fa-cc-mastercard"></i>
			</div>
		</section>
	</div><!-- //container -->
</footer>
<!-- ========================= FOOTER END // ========================= -->

<!-- Modal -->
<div class="modal fade" id="iletisim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="iletisimLabel">İletişim Formu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Yakında eklenecektir. Lütfen discord adresinden @SSilistre ulaşın.   <a href="https://discord.gg/tD5AXcA ">Discord </a>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
				<button type="button" class="btn btn-primary">Gönder</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="sss" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="iletisimLabel">S.S.S</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Yakında eklenecektir. Lütfen discord adresinden @SSilistre ulaşın.   <a href="https://discord.gg/tD5AXcA ">Discord </a>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="reklam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="iletisimLabel">Reklam Alanları</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
					Yakında eklenecektir. Lütfen discord adresinden @SSilistre ulaşın.   <a href="https://discord.gg/tD5AXcA ">Discord </a>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
			</div>
		</div>
	</div>
</div>
</body>
</html>