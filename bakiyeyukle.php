<?php 
include 'themes/header.php';
include 'themes/navbar.php';
error_reporting(0);

sessionKontrol();


if(isset($_POST['BakiyeYukle']) )
{
	if ($_POST['uyeid']=='' || $_POST['miktar']=="") {
		header("location: bakiyeyukle.php");
	}

	$miktar=$_POST['miktar'];
	$komisyon=($miktar/100)*5;
	$odenecek=(int)$miktar+$komisyon;
	$uyeid=$_POST['uyeid'];
	$sayiuret=randomNumber(5);
	$orderno=$uyeid + $sayiuret;
	$tarih=date('Y-m-d H:i:s');
	


	$query = $db->prepare("INSERT INTO bakiye_log SET
		uye_id = :uye_id,
		order_id= :order_id,
		bakiye_miktar = :bakiye_miktar,
		bakiye_tarih = :bakiye_tarih,
		bakiye_islem = :bakiye_islem");
	$insert = $query->execute(array(
		"uye_id" => $uyeid,
		"order_id" => $orderno,
		"bakiye_miktar" => $miktar,
		"bakiye_tarih" => $tarih,
		"bakiye_islem" => "Beklemede",
	));
	if ( $insert ){
		echo '
		<div class="alert alert-success" role="alert">
		Lütfen <b>BU SAYFAYI</b> yenilemeyiniz. veya kapatmayınız. Ödeme işlemleri tamamlanana kadar kalınız.
		</div>
		';


		$merchant_id 	= '176019';
		$merchant_key 	= 'jpFnF3LPR6384B4R';
		$merchant_salt	= 'TKhLor2323Q9SCc8';
	#
	## Müşterinizin sitenizde kayıtlı veya form vasıtasıyla aldığınız eposta adresi
		$email = guvenlik($_POST['email']);
	#
	## Tahsil edilecek tutar.
	$payment_amount	= $odenecek*100; //9.99 için 9.99 * 100 = 999 gönderilmelidir.
	#
	## Sipariş numarası: Her işlemde benzersiz olmalıdır!! Bu bilgi bildirim sayfanıza yapılacak bildirimde geri gönderilir.
	$merchant_oid = $orderno;
	#
	## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız ad ve soyad bilgisi
	$user_name = $_POST['firstname'];
	#
	## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız adres bilgisi
	$user_address = $_POST['address'];
	#
	## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız telefon bilgisi
	$user_phone = $_POST['ceptel'];
	#
	## Başarılı ödeme sonrası müşterinizin yönlendirileceği sayfa
	## !!! Bu sayfa siparişi onaylayacağınız sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
	## !!! Siparişi onaylayacağız sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
	$merchant_ok_url = "http://market.fivemcode.com/bakiyeyukle?durum=bakiyebasariliyuklendi";
	#
	## Ödeme sürecinde beklenmedik bir hata oluşması durumunda müşterinizin yönlendirileceği sayfa
	## !!! Bu sayfa siparişi iptal edeceğiniz sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
	## !!! Siparişi iptal edeceğiniz sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
	$merchant_fail_url = "http://market.fivemcode.com/bakiyeyukle?durum=bakiyeyuklenemedi";
	#
	## Müşterinin sepet/sipariş içeriği
	$user_basket = base64_encode(json_encode(array(
		array("Vip Üyelik", $odenecek, 1)))); // 1. ürün (Ürün Ad - Birim Fiyat - Adet );
	#
	/* ÖRNEK $user_basket oluşturma - Ürün adedine göre array'leri çoğaltabilirsiniz
	$user_basket = base64_encode(json_encode(array(
		array("Örnek ürün 1", "18.00", 1), // 1. ürün (Ürün Ad - Birim Fiyat - Adet )
		array("Örnek ürün 2", "33.25", 2), // 2. ürün (Ürün Ad - Birim Fiyat - Adet )
		array("Örnek ürün 3", "45.42", 1)  // 3. ürün (Ürün Ad - Birim Fiyat - Adet )
	)));
	*/
	############################################################################################

	## Kullanıcının IP adresi
	if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	} elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else {
		$ip = $_SERVER["REMOTE_ADDR"];
	}

	## !!! Eğer bu örnek kodu sunucuda değil local makinanızda çalıştırıyorsanız
	## buraya dış ip adresinizi (https://www.whatismyip.com/) yazmalısınız. Aksi halde geçersiz paytr_token hatası alırsınız.
	$user_ip=$ip;
	##

	## İşlem zaman aşımı süresi - dakika cinsinden
	$timeout_limit = "10";

	## Hata mesajlarının ekrana basılması için entegrasyon ve test sürecinde 1 olarak bırakın. Daha sonra 0 yapabilirsiniz.
	$debug_on = 1;

    ## Mağaza canlı modda iken test işlem yapmak için 1 olarak gönderilebilir.
	$test_mode = 0;

	$no_installment	= 1; // Taksit yapılmasını istemiyorsanız, sadece tek çekim sunacaksanız 1 yapın

	## Sayfada görüntülenecek taksit adedini sınırlamak istiyorsanız uygun şekilde değiştirin.
	## Sıfır (0) gönderilmesi durumunda yürürlükteki en fazla izin verilen taksit geçerli olur.
	$max_installment = 0;

	$currency = "TL";
	
	####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
	$hash_str = $merchant_id .$user_ip .$merchant_oid .$email .$payment_amount .$user_basket.$no_installment.$max_installment.$currency.$test_mode;
	$paytr_token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));
	$post_vals=array(
		'merchant_id'=>$merchant_id,
		'user_ip'=>$user_ip,
		'merchant_oid'=>$merchant_oid,
		'email'=>$email,
		'payment_amount'=>$payment_amount,
		'paytr_token'=>$paytr_token,
		'user_basket'=>$user_basket,
		'debug_on'=>$debug_on,
		'no_installment'=>$no_installment,
		'max_installment'=>$max_installment,
		'user_name'=>$user_name,
		'user_address'=>$user_address,
		'user_phone'=>$user_phone,
		'merchant_ok_url'=>$merchant_ok_url,
		'merchant_fail_url'=>$merchant_fail_url,
		'timeout_limit'=>$timeout_limit,
		'currency'=>$currency,
		'test_mode'=>$test_mode
	);
	
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1) ;
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	
	 // XXX: DİKKAT: lokal makinanızda "SSL certificate problem: unable to get local issuer certificate" uyarısı alırsanız eğer
     // aşağıdaki kodu açıp deneyebilirsiniz. ANCAK, güvenlik nedeniyle sunucunuzda (gerçek ortamınızda) bu kodun kapalı kalması çok önemlidir!
     // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	$result = @curl_exec($ch);

	if(curl_errno($ch))
		die("PAYTR IFRAME connection error. err:".curl_error($ch));

	curl_close($ch);
	
	$result=json_decode($result,1);

	if($result['status']=='success')
		$token=$result['token'];
	else
		die("PAYTR IFRAME failed. reason:".$result['reason']);
	#########################################################################

}
}

?>
<body>

	<section class="section-content padding-y">
		<div class="container">

			<header class="section-heading">
				<h2 class="section-title">Bakiye Yükleme Alanı</h2>
			</header><!-- sect-heading -->

			<article>
				<?php if ($token=="") { ?>
					<div class="alert alert-warning" role="alert">
						Ödeme sisteminin alt yapsından dolayı bakiye yüklerken <b>%5 komisyon</b> almaktadır. Bu ücret ödeme ekranında size yansıtılıcaktır!
						<b>BU SİSTEM FİVEMCODE PANELIN ALT SISTEMIDIR !</b>
					</div>
					<div class="card">
						<div class="card-body">
							<form action="bakiyeyukle.php" method="post">
								<div class="form-group row">
									<label for="firstname" class="col-4 col-form-label">Adınız:</label> 
									<div class="col-8">
										<input id="firstname" name="firstname" placeholder="Lütfen adınızı girin" type="text" class="form-control" required="required">
									</div>
								</div>
								<div class="form-group row">
									<label for="lastname" class="col-4 col-form-label">Soyadınız:</label> 
									<div class="col-8">
										<input id="lastname" name="lastname" placeholder="Lütfen soyadınızı girin" type="text" class="form-control" required="required">
									</div>
								</div>
								<div class="form-group row">
									<label for="email" class="col-4 col-form-label">E Posta Adresiniz:</label> 
									<div class="col-8">
										<input id="email" name="email" placeholder="@mail.com" type="email" class="form-control" required="required">
									</div>
								</div>
								<div class="form-group row">
									<label for="city" class="col-4 col-form-label">Şehriniz:</label> 
									<div class="col-8">
										<input id="city" name="city" placeholder="İstanbul" type="text" class="form-control" required="required">
									</div>
								</div>
								<div class="form-group row">
									<label for="state" class="col-4 col-form-label">İlçe</label> 
									<div class="col-8">
										<input id="state" name="state" placeholder="Kadıköy" type="text" class="form-control" required="required">
									</div>
								</div>
								<div class="form-group row">
									<label for="address" class="col-4 col-form-label">Adresiniz:</label> 
									<div class="col-8">
										<input id="address" name="address" placeholder="Adresiniz" type="text" class="form-control" required="required">
									</div>
								</div>
								<div class="form-group row">
									<label for="address" class="col-4 col-form-label">Cep Tel:</label> 
									<div class="col-8">
										<input id="ceptel" name="ceptel" placeholder="Cep Telefonunuz" type="number" class="form-control" required="required">
									</div>
								</div>
								<div class="form-group row">
									<label for="miktar" class="col-4 col-form-label">Yüklemek İstediğiniz Miktar:</label> 
									<div class="col-8">
										<input id="miktar" name="miktar"  required="required" placeholder="5" type="number" class="form-control">
									</div>
								</div>
								<div class="form-group row">
									<label for="odenecek" class="col-4 col-form-label">Ödenecek Tutar:</label> 
									<div class="col-8">
										<input id="odenecek" name="odenecek" readonly type="number" class="form-control">
										<input type="hidden" name="uyeid" value="<?php echo $kullanicicek['uye_id'] ?>">
									</div>
								</div>
								<button class="subscribe btn btn-primary btn-block" type="submit" name="BakiyeYukle"> Bakiye Yükle  </button>
							</form>
						</div> <!-- card-body.// -->
					</div>
				<?php }else { ?>

					<!-- Ödeme formunun açılması için gereken HTML kodlar / Başlangıç -->
					<script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
					<iframe src="https://www.paytr.com/odeme/guvenli/<?php echo $token;?>" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
					<script>iFrameResize({},'#paytriframe');</script>
					<!-- Ödeme formunun açılması için gereken HTML kodlar / Bitiş -->
				<?php } ?>
			</article>

		</div> <!-- container .//  -->
	</section>
	<!-- ========================= SECTION CONTENT END// ========================= -->

	<?php
	echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>';
	include 'themes/footer.php';
	?>
	<script type="text/javascript">

		$("#miktar").change(function(){
			var miktar=Number($("#miktar").val());
			var komisyon= Number((miktar/100)*5);
			var total=Number(miktar+komisyon);
			$('#odenecek').val(total);
		});	
	</script>