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
				<h5 class="card-title mb-4">Referans Sistemi </h5>	

			 Güncellenicek

			 
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