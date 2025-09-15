<?php
	session_start();

	$random=rand(1, 3);
	$Player="👮🏻‍♂️"; // yang muncul pertama kali di player
	$Robot="🧑🏻‍💻"; // yang muncul pertama kali di robot
	$hasil=""; // hasil pertama adalah kosong 
	$lopePlayer="❤️❤️❤️"; // nyawa plyaer
	$lopeRobot="❤️❤️❤️"; // nyawa robot

	if (isset($_POST['reset'])) {
		session_unset();
	}
	
	// ketika tombol yang di pilihan di klik
	if (isset($_POST{'🖐'}) || isset($_POST['✌️']) || isset($_POST['✊']))
	{

		//ketika player memilih
		if (isset($_POST['🖐'])) {
			$Player="🖐";
		}elseif (isset($_POST['✌️'])) {
			$Player="✌️";
		}elseif (isset($_POST['✊'])) {
			$Player="✊";
		}

		// ketika robot memilih 
		if ($random == 1) {
			$Robot ="🖐";
		}elseif ($random == 2) {
			$Robot ="✌️";
		}elseif ($random == 3) {
			$Robot ="✊";
		}
	}

		if ($Player == $Robot) {
			$hasil="hasil seri 😞";
		}elseif(
			// syarat ketika player menang
			($Player=="🖐" && $Robot=="✊") ||
			($Player=="✌️" && $Robot=="🖐") ||
			($Player=="✊" && $Robot=="✌️")

			)
		{
			$hasil="Kamu Menang 🥳";
		}elseif(
			// syarat ketika robot menang
			($Robot=="🖐" && $Player=="✊") ||
			($Robot=="✌️" && $Player=="🖐") ||
			($Robot=="✊" && $Player=="✌️")
			
			)
		{
			$hasil="Kamu Kalah 🥹";
		}

		// logika pengurangan nyawa robot dan player
		// 1. kita simpan dulu sejumlah nyawa robot dan player (Session)
		// 2. kita tampilkan kembali nyawa robot dan player sesuai dengan jumlah saat selesai suit

		if ($hasil=="Kamu Menang 🥳") {
			// cek apakah session nyawa robot ada?
			if (!isset($_SESSION['nyawaRobot'])) {
				// membuat session nyawa robot dengan isi 2
					$_SESSION['nyawaRobot']=2;
				}elseif ($_SESSION['nyawaRobot']==2) {
					// ubah session nyawa robot jadi 1
					$_SESSION['nyawaRobot']=1;
				}elseif ($_SESSION['nyawaRobot']==1) {
					// ubah session nyawa robot jadi 0
					$_SESSION['nyawaRobot']=0;
				}
		}elseif ($hasil=="Kamu Kalah 🥹") {
			// cek apakah session nyawa player ada?
			if (!isset($_SESSION['nyawaPlayer'])) {
				// membuat session nyawa player dengan isi 2
					$_SESSION['nyawaPlayer']=2;
				}elseif ($_SESSION['nyawaPlayer']==2) {
					// ubah session nyawa player jadi 1
					$_SESSION['nyawaPlayer']=1;
				}elseif ($_SESSION['nyawaPlayer']==1) {
					// ubah session nyawa player jadi 0
					$_SESSION['nyawaPlayer']=0;
				}
			}
		// menyimpan nyawa selesai

		if (isset($_SESSION['nyawaPlayer']) || isset($_SESSION['nyawaRobot'])) {

			// khusus untuk mengurusi nyawa Robot
			if (isset($_SESSION['nyawaRobot'])) {
				$nyawaRobot=$_SESSION['nyawaRobot'];

				if ($nyawaRobot==2) {
					$lopeRobot="❤️❤️";
				}elseif ($nyawaRobot==1) {
					$lopeRobot="❤️";
				}elseif ($nyawaRobot==0) {
					$lopeRobot="";
				}
			}

			// khusus untuk mengurusi nyawa player
			if (isset($_SESSION['nyawaPlayer'])) {
				$nyawaPlayer=$_SESSION['nyawaPlayer'];

				if ($nyawaPlayer==2) {
					$lopePlayer="❤️❤️";
				}elseif ($nyawaPlayer==1) {
					$lopePlayer="❤️";
				}elseif ($nyawaPlayer==0) {
					$lopePlayer="";
				}
			}
		}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>suit</title>
	<!-- koneksikan dengan bootstrap CSS -->
	<link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css"></link>
	<!-- koneksikan dengan CSS sendiri -->
	<link rel="stylesheet" type="text/css" href="asset/css/style.css">

	<!-- koneksikan dengan JS bootstrap -->
	<script src="asset/js/bootstrap.bundle.min.js"></script>
</head>
<body>
	<div class="bg-img">
		<div class="bg-atas d-flex text-light">
			<div class="kiri col-6 ps-4 d-flex align-items-center">
				<h1>👮🏻‍♂️</h1>
				<h4><?= $lopePlayer ?></h4>
			</div>
			<div class="kanan col-6 text-end pe-3 d-flex align-items-center justify-content-end">
				<h4><?= $lopeRobot ?></h4>
				<h1>🧑🏻‍💻</h1>
			</div>
		</div>

		<!-- yang di tengah -->
		<div class="body d-flex align-items-center justify-content-center flex-column" style="min-height:85vh">

			<!-- tombol reset -->
			<form method="post" action="">
				<button type="submit" name="reset" class="btn btn-outline-light">Reset</button>
			</form>
			<br>

			<!-- ini tombol start -->
			<button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#PilihEmoji">start</button>
			<br>

			<!-- ini area arena -->
			<div class="arena bg-glases p-3 col-lg-8 row text-light">
				<div class="col-4 kiri  p-3">
					<h5 class="">Player</h5>
					<h1 style="font-size:80px" class="text-center"><?= $Player	 ?></h1>
				</div>
				<div class="col-4 tengah p-3 text-center d-flex align-items-center justify-content-center flex-column">
					<p class="fw-bold" style="font-size:60px">VS</p>
				</div>
				<div class="col-4 kanan p-3 text-end">
					<h5 class="">Robot</h5>
					<h1 style="font-size:80px" class="text-center"><?= $Robot ?></h1>
				</div>
			</div>
			<!-- modal pilih emoji -->
			<div class="modal fade" id="PilihEmoji" tabindex="-1" aria-labelledby="PilihanEmoji" aria-hidden="true">

			  <div class="modal-dialog modal-dialog-centered">
			    <div class="modal-content bg-glases text-light">
			      <div class="modal-header">
			        <h1 class="modal-title fs-5" id="PilihanEmoji">Pilih Emoji</h1>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      </div>
			      <div class="modal-body text-center">
			      	<form method="post">
				      	<!-- ketika kita pilih kertas -->
				        <button class="btn btn-outline-light" name="🖐">
				        	<h1>🖐</h1>
				        </button>

				        	<!-- ketika kita pilih gunting -->
				        <button class="btn btn-outline-light mx-5 " name="✌️">
				        	<h1>✌️</h1>
				        </button>

				        	<!-- ketika kita pilih batu -->
				        <button class="btn btn-outline-light " name="✊">
				        	<h1>✊</h1>
				        </button>
			        </form>
			      </div>
			    </div>
			  </div>
			</div>
			<!-- modal end -->
			

			<!-- modal ketika pesan muncul -->
			<div class="modal fade" id="ModalPesan" tabindex="-1" aria-labelledby="ModalPesan" aria-hidden="true">

			  <div class="modal-dialog modal-dialog-centered">
			    <div class="modal-content bg-glases text-light">
			     <div class="modal-body text-center">
					<h1><?= $hasil ?></h1>
				</div>
			   </div>
			  </div>
			 </div>
			 <!-- modal pesan end -->
			</div>
	</div>
</body>
</html>

<?php if (!empty($hasil)) : ?>
	<script>
		var hasilModal = new bootstrap.Modal(document.getElementById('ModalPesan'));
		hasilModal.show();
	</script>

<?php endif ?>