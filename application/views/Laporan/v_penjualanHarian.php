<section class="content">
	<div class="container-fluid">
		<!-- Exportable Table -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							<ol class="breadcrumb">
								<li class="">Penjualan Harian</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<div class="box-data">
							<table style="width:100%">
								<tr>
									<td style="width:10%;border:1px solid #000;padding:5px"></td>
									<td style="width:1%;border:1px solid #000;padding:5px"></td>
									<td style="width:14%;border:1px solid #000;padding:5px"></td>
									<td style="width:5%;border:1px solid #000;padding:5px"></td>
									<td style="width:14%;border:1px solid #000;padding:5px"></td>
									<td style="width:56%;border:1px solid #000;padding:5px"></td>
								</tr>
								<tr>
									<td>Jenis</td>
									<td>:</td>
									<td>
										<select name="" id="jenis" class="form-control" style="margin: 5px">
											<option value="">Pilih . . .</option>
											<option value="ALL">SEMUA</option>
											<option value="MH">MH - MN</option>
											<option value="WP">WP</option>
											<option value="BK">BK</option>
										</select>
									</td>
								</tr>
								<!-- <tr>
									<td>Bulan</td>
									<td>:</td>
									<td>
										<select name="" id="bulan" class="form-control" style="margin: 5px">
											<option value="">Pilih . . .</option>
											<option value="01">Januari</option>
											<option value="02">Februari</option>
											<option value="03">Maret</option>
											<option value="04">April</option>
											<option value="05">Mei</option>
											<option value="06">Juni</option>
											<option value="07">Juli</option>
											<option value="08">Agustus</option>
											<option value="09">September</option>
											<option value="10">Oktober</option>
											<option value="11">November</option>
											<option value="12">Desember</option>
										</select>
									</td>
								</tr> -->
								<tr>
									<td>Tanggal</td>
									<td>:</td>
									<td>
										<input type="date" class="form-control" value="" id="tgl1" style="margin: 5px"> 
									</td>
									<td style="text-align:center">S/d</td>
									<td>
										<input type="date" class="form-control" value="" id="tgl2" style="margin: 5px">
									</td>
								</tr>
								<!-- <tr>
									<td>Tahun</td>
									<td>:</td>
									<td>
										<select name="" id="tahun" class="form-control" style="margin: 5px">
											<option value="">Pilih . . .</option>
											<option value="2020">2020</option>
											<option value="2021">2021</option>
											<option value="2022">2022</option>
										</select>
									</td>
								</tr> -->
								<tr>
									<td colspan="6" style="padding:10px"></td>
								</tr>
								<tr>
									<td style="text-align:center" colspan="6">
										<button type="button" onclick="cetak(0)" class="btn btn-default btn-sm waves-effect">
											Cetak Layar
										</button>
										<!-- <button type="button" onclick="cetak(1)" class="btn btn-default btn-sm waves-effect">
                                        <i class="material-icons">print </i>
                                        PDF
                                    </button> -->
										<!-- <button type="button" onclick="cetak(2)" class="btn btn-default btn-sm waves-effect">
                                        Download
                                    </button> -->
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<!-- #END# Exportable Table -->
			</div>
</section>

<script>
	function cetak(ctk) {
		jenis = $("#jenis").val();
		tgl1 = $("#tgl1").val();
		tgl2 = $("#tgl2").val();
		// bulan = $("#bulan").val();
		// tahun = $("#tahun").val();

		if (jenis == "") {
			showNotification("alert-info", "Pilih Jenis Kertas", "bottom", "right", "", "");
			return;
		}
		if (tgl1 == "") {
			showNotification("alert-info", "Pilih Tanggal Pertama", "bottom", "right", "", "");
			return;
		}
		if (tgl2 == "") {
			showNotification("alert-info", "Pilih Tanggal Kedua", "bottom", "right", "", "");
			return;
		}

		// if (bulan == "") {
		// 	showNotification("alert-info", "Pilih Bulan", "bottom", "right", "", "");
		// 	return;
		// }

		// if (tahun == "") {
		// 	showNotification("alert-info", "Pilih Tahun", "bottom", "right", "", "");
		// 	return;
		// }

		var url = "<?php echo base_url('Laporan/penjualanDetail?'); ?>";
		// window.open(url + 'jenis=' + jenis + '&bulan=' + bulan + '&tahun=' + tahun + '&ctk=0', '_blank');
		window.open(url + 'jenis=' + jenis + '&tgl1=' + tgl1 + '&tgl2=' + tgl2 + '&ctk=0', '_blank');
	}
</script>
