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
						<h2>
							<ol class="breadcrumb">
								<li class="">RENCANA PRODUKSI KIRIMAN</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<input type="hidden" name="otorisasi" id="otorisasi" value="<?php echo $otorisasi; ?>">

						<div class="box-data" style="overflow:auto;white-space:nowrap;">
							DATA
						</div>

						<div class="box-form" style="overflow:auto;white-space:nowrap;">
							<table style="width: 100%;">
								<tr>
									<td style="width:20%;border:1px solid #000;padding:5px"></td>
									<td style="width:1%;border:1px solid #000;padding:5px"></td>
									<td style="width:79%;border:1px solid #000;padding:5px"></td>
								</tr>
								<tr>
									<td>TANGGAL</td>
									<td>:</td>
									<td></td>
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
