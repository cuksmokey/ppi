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
						<h2>RENCANA PRODUKSI KERTAS</h2>
					</div>

					<div class="body">
						<input type="hidden" name="otorisasi" id="otorisasi" value="<?php echo $otorisasi; ?>">

						<div class="box-data" style="overflow:auto;white-space:nowrap;">
							DATA
						</div>

						<div class="box-form" style="overflow:auto;white-space:nowrap;">
							<table style="width: 100%;" border="1">
								<tr>
									<td style="width:20%;border:1px solid #000;padding:3px"></td>
									<td style="width:1%;border:1px solid #000;padding:3px"></td>
									<td style="width:79%;border:1px solid #000;padding:3px"></td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">TANGGAL</td>
									<td style="padding:5px 0;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="date" name="tgl" id="tgl" class="form-control">
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">JENIS</td>
									<td style="padding:5px 0;text-align:center">:</td>
									<td style="padding:5px 0">
										<select name="nm_ker" id="nm_ker" class="form-control">
											<option value="">PILIH</option>
											<option value="">MH</option>
											<option value="">BK</option>
											<option value="">WP</option>
											<option value="">MN</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">GRAMATURE</td>
									<td style="padding:5px 0;text-align:center">:</td>
									<td style="padding:5px 0">
										<select name="g_label" id="g_label" class="form-control">
											<option value="">PILIH</option>
											<option value="68">68</option>
											<option value="70">70</option>
											<option value="105">105</option>
											<option value="110">110</option>
											<option value="115">115</option>
											<option value="125">125</option>
											<option value="120">120</option>
											<option value="140">140</option>
											<option value="150">150</option>
											<option value="200">200</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">PM</td>
									<td style="padding:5px 0;text-align:center">:</td>
									<td style="padding:5px 0">
										<select name="pm" id="pm" class="form-control">
											<option value="">PILIH</option>
											<option value="1">1</option>
											<option value="2">2</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">ID RPK</td>
									<td style="padding:5px 0;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="text" name="id_rpk" id="id_rpk" class="form-control">
									</td>
								</tr>
								<tr>
									<td colspan="3" style="padding:15px 0"></td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">ITEM</td>
									<td style="padding:5px 0;text-align:center">:</td>
									<td style="padding:5px 0">
										<table style="width:100%">
											<tr>
												<td>
													<input type="number" name="1" id="1" class="form-control">
												</td>
												<td>
													<input type="number" name="1" id="1" class="form-control">
												</td>
												<td>
													<input type="number" name="1" id="1" class="form-control">
												</td>
												<td>
													<input type="number" name="1" id="1" class="form-control">
												</td>
												<td>
													<input type="number" name="1" id="1" class="form-control">
												</td>
											</tr>
											<tr>
												<td colspan="5" style="color:#f00;font-size:11px;font-style:italic">* koma pakai titik ( . )</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">TIMES</td>
									<td style="padding:5px 0;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="number" name="times" id="times" maxlength="3" class="form-control">
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">REFERENSI</td>
									<td style="padding:5px 0;text-align:center">:</td>
									<td style="padding:5px 0">
										<textarea name="ref" id="ref" class="form-control" style="resize:none;"></textarea>
									</td>
								</tr><tr>
									<td style="padding:5px 0" colspan="2"></td>
									<td style="padding:5px 0">
										<button>ADD</button>
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
