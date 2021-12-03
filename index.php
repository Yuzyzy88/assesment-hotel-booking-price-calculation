<!DOCTYPE html>
<html>

<head>
	<title>Perhitungan Kamar Hotel</title>
	<link rel="stylesheet" href="./css/bootstrap.css">

</head>

<body>
	<div class="container border">
		<h3 class="text-primary">Form Pemesanan Kamar Hotel</h3>

		<!-- Form untuk memasukkan data pemesanan. -->
		<form action="index.php" method="post" id="formTagihan">
			<div class="row">
				<!-- Masukan tanggal check-in. Tipe data date -->
				<div class="col-lg-2"><label for="tanggal">Tanggal Check-in:</label></div>
				<div class="col-lg-2"><input type="date" id="tglCekIn" name="tglCekIn"></div>
			</div>
			<div class="row">
				<!-- Masukan tanggal check-out. Tipe data date. -->
				<div class="col-lg-2"><label for="tanggal">Tanggal Check-out:</label></div>
				<div class="col-lg-2"><input type="date" id="tglCekOut" name="tglCekOut"></div>
			</div>
			<div class="row">
				<!-- Masukan pilihan lokasi hotel. -->
				<div class="col-lg-2"><label for="tipe">Cabang Hotel:</label></div>
				<div class="col-lg-2">
					<select id="lokasi" name="lokasi">
						<option value="">- Pilih Cabang -</option>
						<?php
						$location = array("Jakarta", "Bandung", "Semarang", "Yogyakarta", "Surabaya", "Denpasar");
						asort($location);
						//	Instruksi Kerja Nomor 7.
						// Menampilkan dropdown pilihan cabang/lokasi berdasarkan data pada array $lokasi.
						foreach ($location as $city_location) {
							echo '<option value="' . ucfirst($city_location) . '">' . $city_location . '</option>';
						}
						?>
					</select>
				</div>
			</div>
			<div class="row">
				<!-- Masukan data nama pelanggan. Tipe data text. -->
				<div class="col-lg-2"><label for="nama">Nama Pelanggan:</label></div>
				<div class="col-lg-2"><input type="text" id="nama" name="nama"></div>
			</div>
			<div class="row">
				<!-- Masukan data nomor identitas pelanggan. Tipe data number. -->
				<div class="col-lg-2"><label for="nomor">Nomor Identitas:</label></div>
				<div class="col-lg-2"><input type="number" id="noid" name="noid" maxlength="16"></div>
			</div>

			<div class="row">

				<div class="col-lg-2"><button class="btn btn-primary" type="submit" form="formTagihan" value="Pesan" name="Pesan">Pesan</button></div>
				<div class="col-lg-2"></div>
			</div>
		</form>
	</div>

	<?php

	if (isset($_POST['Pesan'])) {

		// create new object
		$dataPesanan = [
			'tglCekIn' => $_POST['tglCekIn'],
			'tglCekOut' => $_POST['tglCekOut'],
			'lokasi' => $_POST['lokasi'],
			'nama' => $_POST['nama'],
			'noid' => $_POST['noid']
		];

		function durasi($tglCekIn, $tglCekOut)
		{
			$date1 = date_create($tglCekIn);
			$date2 = date_create($tglCekOut);
			$diff = date_diff($date1, $date2);
			$durasi = $diff->format("%d%");

			return $durasi;
		}

		function hitung_tagihan_awal($cost_room, $total_durasi)
		{
			$calculate = $cost_room;
			$tagihan_awal = $calculate * $total_durasi;
			return $tagihan_awal;
		}

		$cekIn = $_POST['tglCekIn'];
		$cekOut = $_POST['tglCekOut'];
		$location = $_POST['lokasi'];
		$name = $_POST['nama'];
		$num = $_POST['noid'];

		$hargaKamar = 500000;

		$durasiInap = durasi($dataPesanan['tglCekIn'], $dataPesanan['tglCekOut']);
		$tagihanAwal = hitung_tagihan_awal($durasiInap, $hargaKamar);


		if ($tagihanAwal >= 1500000) {
			$diskon = $tagihanAwal * (10 / 100);
			$total_payment = $tagihanAwal - $diskon;
		} else {
			$diskon = $tagihanAwal * (5 / 100);
			$total_payment = $tagihanAwal - $diskon;
		}


		$tagihanAkhir = $tagihanAwal - $diskon;

		echo "
				<br/>
				<div class='container'>
				
					<div class='row'>
						<!-- Menampilkan tanggal check-in. -->
						<div class='col-lg-2'>Tanggal Check-in:</div>
						<div class='col-lg-2'>" . $cekIn . "</div>
					</div>
					<div class='row'>
						<!-- Menampilkan tanggal check-out. -->
						<div class='col-lg-2'>Tanggal Check-out:</div>
						<div class='col-lg-2'>" . $cekOut . "</div>
					</div>
					<div class='row'>
						<!-- Menampilkan lokasi/cabang hotel. -->
						<div class='col-lg-2'>Cabang:</div>
						<div class='col-lg-2'>" . $location . "</div>
					</div>
					<div class='row'>
						<!-- Menampilkan nama pelanggan. -->
						<div class='col-lg-2'>Nama Pelanggan:</div>
						<div class='col-lg-2'>" . $name . "</div>
					</div>
					<div class='row'>
						<!-- Menampilkan nomor identitas pelanggan. -->
						<div class='col-lg-2'>Nomor Identitas:</div>
						<div class='col-lg-2'>" . $num . "</div>
					</div>
					<div class='row'>
						<!-- Menampilkan durasi menginap. -->
						<div class='col-lg-2'>Durasi Menginap:</div>
						<div class='col-lg-2'>" . $durasiInap . " malam</div>
					</div>
					<div class='row'>
						<!-- Menampilkan tagihan awal (sebelum diskon). -->
						<div class='col-lg-2'>Tagihan Awal:</div>
						<div class='col-lg-2'>Rp" . number_format($tagihanAwal, 0, ".", ".") . ",-</div>
					</div>
					<div class='row'>
						<!-- Menampilkan tarif pemesanan. -->
						<div class='col-lg-2'>Diskon:</div>
						<div class='col-lg-2'>Rp" . number_format($diskon, 0, ".", ".") . ",-</div>
					</div>
					<div class='row'>
						<!-- Menampilkan tagihan akhir (setelah diskon). -->
						<div class='col-lg-2'>Tagihan Akhir:</div>
						<div class='col-lg-2'>Rp" . number_format($tagihanAkhir, 0, ".", ".") . ",-</div>
					</div>
			</div>
			";


		// input to file json
		$berkas = "data.json";

		// make the file an empty array
		if (!file_exists($berkas)) {
			file_put_contents($berkas, json_encode([]));
		}

		// read file
		$datafile = json_decode(file_get_contents($berkas), true);

		//create new object
		$list = [
			'tglCekIn' => $cekIn,
			'tglCekOut' => $cekOut,
			'lokasi' => $location,
			'nama' => $name,
			'noid' => $num,
			'diskon' => $diskon,
			'Tagihan Akhir' => $tagihanAkhir
		];

		// push new data to array
		array_push($datafile, $list);

		// output new array to file
		$dataJson = json_encode($datafile, JSON_PRETTY_PRINT);
		file_put_contents($berkas, $dataJson);
	}
	?>
</body>

</html>