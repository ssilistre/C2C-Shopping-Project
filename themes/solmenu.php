<?php 
if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {

    exit("Bu sayfaya erişim yasak");

}

?>
<aside class="col-md-3">
	<ul class="list-group">
		<a class="list-group-item" href="profilim"> Benim Profilim  </a>
		<a class="list-group-item" href="satinaldiklarim"> Satın Aldıklarım </a>
		<a class="list-group-item" href="referans"> Referans Sistemi </a>
		<a class="list-group-item" href="gelenmesajlar"> Gelen Mesajlar</a>
		<a class="list-group-item" href="gidenmesajlar"> Giden Mesajlar </a>
		<a class="list-group-item" href="desteksistemi"> Destek Sistemi </a>
		<?php 
		if ($kullanicicek['uye_yetki']>=1) {
			echo '<hr>';
			echo '<a class="list-group-item" href="urunekle"> Ürün Ekle </a>';
			echo '<a class="list-group-item" href="urunlerim"> Satıştaki Ürünlerim </a>';
			echo '<a class="list-group-item" href="yenisiparisler">  Yeni Siparişler  </a>';
			echo '<a class="list-group-item" href="tamamlanansiparisler"> Tamamlanan Siparişler </a>';
			echo '<a class="list-group-item" href="vip"> <b>Ekstra Özellik Satın Al</b> </a>';
		}

		?>




	</ul>
	</aside> <!-- col.// -->