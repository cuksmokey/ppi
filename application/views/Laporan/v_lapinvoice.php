<section class="content">
	<div class="container-fluid">
		<!-- Exportable Table -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							<ol class="breadcrumb">
								<li class="">Laporan Invoice</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<div class="box-data">
							<table width="80%">
								<tr>
									<td width="15%">Pilih</td>
									<td>:</td>
									<td>
										<select name="" id="pilih" class="form-control" style="margin: 5px">
											<!-- <option value="kosong">Pilih . . .</option> -->
											<option value="0">ALL</option>
											<?php include 'connect.php';
											$sql = mysql_query("SELECT id_pt,CASE WHEN a.nm_perusahaan != '-' AND a.kepada != '-' THEN CONCAT(a.kepada, ' - ', a.nm_perusahaan)
											WHEN a.nm_perusahaan != '-' AND a.kepada = '-' THEN a.nm_perusahaan
											WHEN a.nm_perusahaan = '-' AND a.kepada != '-' THEN a.kepada ELSE a.nm_perusahaan END AS notice,kepada,nm_perusahaan FROM invoice_header a
												GROUP BY id_pt ORDER BY kepada,nm_perusahaan");
											while ($data = mysql_fetch_array($sql)) { ?>
												<option value="<?= $data['id_pt'] ?>"><?= $data['notice'] ?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<tr>
									<td width="15%">Bulan</td>
									<td>:</td>
									<td>
										<select name="" id="bulan" class="form-control" style="margin: 5px">
											<!-- <option value="">Pilih . . .</option> -->
											<option value="0">ALL</option>
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
								</tr>
								<tr>
									<td width="15%">Tahun</td>
									<td>:</td>
									<td>
										<select name="" id="tahun" class="form-control" style="margin: 5px">
											<option value="">Pilih . . .</option>
											<!-- <option value="2020">2020</option> -->
											<option value="2021">2021</option>
											<option value="2022">2022</option>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="5">
										<br>
									</td>
								</tr>
								<tr>
									<td colspan="5">
										<br>
									</td>
								</tr>
								<tr>
									<td align="center" colspan="5">
										<button type="button" onclick="cetak(0)" class="btn btn-default btn-sm waves-effect">
											Cetak Layar
										</button>
										<button type="button" onclick="cetak(1)" class="btn btn-default btn-sm waves-effect">
											<i class="material-icons">print </i>
											PDF
										</button>
										<!-- <button type="button" onclick="cetak(2)" class="btn btn-default btn-sm waves-effect">
											EXCEL
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
		i_pilih = $("#pilih").val();
		i_bulan = $("#bulan").val();
		i_tahun = $("#tahun").val();

		// if (i_pilih == "kosong") {
		// 	showNotification("alert-info", "Pilih Terlebih Dahulu", "bottom", "right", "", "");
		// 	return;
		// }

		if (i_tahun == "") {
			showNotification("alert-info", "Pilih Tahun", "bottom", "right", "", "");
			return;
		}

		if (i_pilih == 0) {
			pilih = '';
		} else {
			pilih = i_pilih;
		}

		if(i_bulan == 0){
			tgll = i_tahun;
		}else{
			tgll = i_tahun+'-'+i_bulan;
		}

		var url = "<?php echo base_url('Laporan/lapPiutangInvoice?'); ?>";
		// window.open(url + 'kepada=' + pilih, '_blank');
		window.open(url+'kepada='+pilih+'&tgl='+tgll+'&ctk='+ctk,'_blank');

	}
</script>
