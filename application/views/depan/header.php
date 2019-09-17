<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Filantropi</title>
	<link rel="icon" type="image/gif" href="<?php echo base_url('') ?>assets/img/brand/fi.png" />
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo base_url('') ?>assets/vendor/bootstrap431/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url('') ?>assets/vendor/bootstrap431/css/bootstrap1.min.css">

	<!-- Bootstrap CSS File -->
	<link href="<?php echo base_url('') ?>assets/vendor/bootstrap/css/bootstraps.min.css" rel="stylesheet">

	<!-- Favicons -->
	<link href="<?php echo base_url('') ?>assets/img/favicon.png" rel="icon">
	<link href="<?php echo base_url('') ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

	<!-- Libraries CSS Files -->
	<link href="<?php echo base_url('') ?>assets/vendor/font-awesome/css/font-awesomes.min.css" rel="stylesheet">
	<link href="<?php echo base_url('') ?>assets/vendor/animate/animates.min.css" rel="stylesheet">
	<link href="<?php echo base_url('') ?>assets/vendor/ionicons/css/ionicons.min.css" rel="stylesheet">
	<link href="<?php echo base_url('') ?>assets/vendor/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
	<link href="<?php echo base_url('') ?>assets/vendor/lightbox/css/lightbox.min.css" rel="stylesheet">

	<!-- Main Stylesheet File -->
	<link href="<?php echo base_url('') ?>assets/css/style.css" rel="stylesheet">


	<!-- FontAwesome -->
	<link rel="stylesheet" href="../use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo base_url('') ?>assets/css/alpha/stylesheet.css">
	<!-- Animate -->
	<link rel="stylesheet" href="<?php echo base_url('') ?>assets/vendor/animate/animate.min.css">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,500,600,700,700i|Montserrat:300,400,500,600,700" rel="stylesheet">



	<!-- Global site tag (gtag.js) - Google Analytics -->
	<link href="<?php echo base_url('') ?>assets/vendor/slick/slick-theme.css" rel="stylesheet">
	<link href="<?php echo base_url('') ?>assets/vendor/slick/slick.css" rel="stylesheet">
	<script src="https://use.fontawesome.com/85f6c3d1ae.js"></script>
	<script src="<?php echo base_url('') ?>assets/css/nucleo.css"></script>

	<link href="<?php echo base_url('') ?>assets/css/custom.css" rel="stylesheet">
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="navbarHero">
		<a class="navbar-brand">
			<img src="<?php echo base_url('') ?>assets/img/brand/fi.png" id='navLogo1' style="height:auto;width:2em">
			<img src="<?php echo base_url('') ?>assets/img/brand/fi-logo.png" id='navLogo2' style="height:auto;width:7em;padding-bottom:5px;display:none;">
		</a>
		<button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div id="my-nav" class="collapse navbar-collapse">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="<?php echo base_url('') ?>">Home<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown">Tentang Kami</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="<?php echo site_url('') ?>index.php/home/sejarah">Sejarah</a></li>
							<li><a class="dropdown-item" href="<?php echo site_url('') ?>/depan/visimisi">Visi & Misi</a></li>
							<li><a class="dropdown-item" href="<?php echo site_url('') ?>/depan/tujuan">Tujuan & Prinsip</a></li>
							<li><a class="dropdown-item" href="<?php echo site_url('') ?>/depan/siapakami">Siapa Kami</a></li>
							<li><a class="dropdown-item" href="#">Mitra</a></li>
							<div class="dropdown-divider"></div>
						</ul>
				</li>
					<li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown">Anggota</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="<?php echo site_url('') ?>/depan/keanggotaan">Keanggotaaan</a></li>
							<li><a class="dropdown-item" href="#">Organisasi</a></li>
							<div class="dropdown-divider"></div>
						</ul>
					</li>

			
					<li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown">Berita</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="<?php echo site_url('') ?>/depan/berita">Berita Internal</a></li>
							<li><a class="dropdown-item" href="<?php echo site_url('') ?>/depan/luar">Berita Luar</a></li>
							<div class="dropdown-divider"></div>
						</ul>
				
				</li>

				
					<li class="nav-item dropdown">
						<a class="nav-link" data-toggle="dropdown">Sumber Informasi</a>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="#">Galeri</a></li>
							<li><a class="dropdown-item" href="#">Standar & Pedoman</a></li>
							<li><a class="dropdown-item" href="#">Peta Filantropi</a></li>
							<div class="dropdown-divider"></div>
						</ul>
				
				</li>


				<li class="nav-item">
					<a class="nav-link" href="<?php echo site_url('') ?>/depan/khazanah">Khazanah<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo site_url('') ?>/depan/acara">Acara<span class="sr-only">(current)</span></a>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
				<li class="nav-item"><a class="nav-link" href="<?php echo site_url('') ?>/depan/registrasi" class="hover-white">Registrasi</a></li>
				<li class="nav-item"><a class="nav-link" href="<?php echo site_url('') ?>/depan/login" class="hover-white">Masuk</a></li>
				<li class="nav-item dropdown">
					<a class="nav-link" href="#" class="hover-white nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						<img src="<?php echo base_url('') ?>assets/img/flag/flag_indonesia.png" style="width:23px;height:13px;">
					</a>
					<div class="dropdown-menu" style="min-width:50px">
						<a class="nav-link" href="#"><img src="<?php echo base_url('') ?>assets/img/flag/flag_indonesia.png"></a><br>
						<a class="nav-link" href="#"><img src="<?php echo base_url('') ?>assets/img/flag/flag_english.png"></a><br>
					</div>
				</li>
			</ul>
		</div>
	</nav>
