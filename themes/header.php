<?php 
require 'inc/db.php';
require 'inc/func.php';

if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {

	exit("Bu sayfaya erişim yasak");

}

?>
<!DOCTYPE HTML>
<html lang="tr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="cache-control" content="max-age=604800" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php echo $ayarcek['ayar_description']; ?>">
	<meta name="keywords" content="<?php echo $ayarcek['ayar_keywords']; ?>">
	<meta name="author" content="<?php echo $ayarcek['ayar_author']; ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="http://localhost/market/" />
	<title><?php echo $ayarcek['ayar_title']; ?></title>
	<link href="themes/images/favicon.ico" rel="shortcut icon" type="image/x-icon">

	<!-- jQuery -->
	<script src="themes/js/jquery-2.0.0.min.js" type="text/javascript"></script>

	<!-- Bootstrap4 files-->
	<script src="themes/js/bootstrap.bundle.min.js" type="text/javascript"></script>
	<link href="themes/css/bootstrap.css" rel="stylesheet" type="text/css"/>

	<!-- Font awesome 5 -->
	<link href="themes/fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">

	<!-- custom style -->
	<link href="themes/css/ui.css" rel="stylesheet" type="text/css"/>
	<link href="themes/css/responsive.css" rel="stylesheet" media="only screen and (max-width: 1200px)" />
	<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f06d05bad0b8f0019e2affd&product=custom-share-buttons&cms=sop' async='async'></script>
	<!-- custom javascript -->
	<script src="themes/js/script.js" type="text/javascript"></script>
	<script src="//cdn.ckeditor.com/4.14.1/basic/ckeditor.js"></script>
	<script type="text/javascript">
/// some script

// jquery ready start
$(document).ready(function() {
	// jQuery code

}); 
// jquery end
</script>
<style>
.responsive {
  width: 100%;
  height: auto;
}
</style>
</head>