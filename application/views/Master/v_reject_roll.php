<?php
	if($this->session->userdata('level') == "SuperAdmin"){
		$otorisasi = 'all';
	}else if($this->session->userdata('level') == "Admin"){
		$otorisasi = 'admin';
	}else if($this->session->userdata('level') == "QC"){
		$otorisasi = 'qc';
	}else if($this->session->userdata('level') == "FG"){
		$otorisasi = 'fg';
	}else if($this->session->userdata('level') == "Finance"){
		$otorisasi = 'finance';
	}else if($this->session->userdata('level') == "Office"){
		$otorisasi = 'office';
	}else if($this->session->userdata('level') == "Corrugated"){
		$otorisasi = 'cor';
	}else{
		$otorisasi = 'user';
	}
?>

<style>
	.box-data, .box-form {
		padding-top:15px;
		color: #000
	}

	.list-table:hover {
		background: #eee;
	}
</style>

<section class="content">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>REJECT PENGIRIMAN ROLL</h2>
					</div>

					<div class="body">
						<input type="hidden" name="otorisasi" id="otorisasi" value="<?php echo $otorisasi; ?>">

						<div class="box-data" style="overflow:auto;white-space:nowrap;">
							DATA
						</div>

						<div class="box-form" style="overflow:auto;white-space:nowrap;">
							<table style="width:fit-content" border="1">
								<tr>
									<td style="padding:5px 0;border:1px solid #000"></td>
									<td style="width:1%;padding:5px 0;border:1px solid #000"></td>
									<td style="padding:5px 0;border:1px solid #000"></td>
									<td style="padding:5px 0;border:1px solid #000"></td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">TANGGAL</td>
									<td style="padding:5px 0">:</td>
									<td style="padding:5px 0">
										<input type="date" name="tgl" id="tgl" class="form-control">
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">KIRIMAN KE</td>
									<td style="padding:5px 0">:</td>
									<td style="padding:5px 0">
										<select name="kirimke" id="kirimke" class="form-control">
											<option value="">PILIH</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">TAHUN</td>
									<td style="padding:5px 0">:</td>
									<td style="padding:5px 0">
										<select name="pl" id="pl" class="form-control">
											<option value="">PILIH</option>
											<option value="2020">2020</option>
											<option value="2021">2021</option>
											<option value="2022">2022</option>
											<option value="2023">2023</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">PACKING LIST</td>
									<td style="padding:5px 0">:</td>
									<td style="padding:5px 0">
										<select name="pl" id="pl" class="form-control">
											<option value="">PILIH</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">ROLL</td>
									<td style="padding:5px 0">:</td>
									<td style="padding:5px 0">
										<select name="roll" id="roll" class="form-control">
											<option value="">PILIH</option>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	status = '';
	otorisasi = $("#otorisasi").val();

	$(document).ready(function() {
		// 
	});
</script>
