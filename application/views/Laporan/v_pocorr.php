<section class="content">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							<ol class="breadcrumb">
								<li class="">PO Corrugated</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<div class="box-data">

							<select name="" id="plh_corr" class="form-control" style="width:20%">
								<option value="">-- PILIH --</option>
								<option value="box">BOX</option>
								<option value="sheet">SHEET</option>
							</select>
							<br>

							<input type="text" class="form-control" id="cari_po" autocomplete="off" placeholder="CARI NAMA ATAU NOMER PO">
							<br>

							<!-- <button onclick="" id="btn-print" type="button" class="btn btn-sm waves-effect" style="background:#8BC34A;color:#1B630A">
								<i class="material-icons">print</i>
								<b><span id="txt-btn-simpan">PRINT</span></b>
							</button>
							<br/><br/> -->

							<table style="width:100%;color:#000">
								<tr>
									<td style="width:5%;"></td>
									<td style="width:55%;"></td>
									<td style="width:14%;"></td>
									<td style="width:5%;"></td>
									<td style="width:8%;"></td>
									<td style="width:8%;"></td>
									<td style="width:5%;"></td>
								</tr>
								<tr>
									<td style="background:#ccc;color:#000;border:1px solid #ccc;padding:5px;font-weight:bold;text-align:center">NO</td>
									<td style="background:#ccc;color:#000;border:1px solid #ccc;padding:5px;font-weight:bold;text-align:center">UKURAN</td>
									<td style="background:#ccc;color:#000;border:1px solid #ccc;padding:5px;font-weight:bold;text-align:center">SUBSTANCE</td>
									<td style="background:#ccc;color:#000;border:1px solid #ccc;padding:5px;font-weight:bold;text-align:center">FLUTE</td>
									<td style="background:#ccc;color:#000;border:1px solid #ccc;padding:5px;font-weight:bold;text-align:center">QTY</td>
									<td style="background:#ccc;color:#000;border:1px solid #ccc;padding:5px;font-weight:bold;text-align:center">(Rp.)</td>
									<td style="background:#ccc;color:#000;border:1px solid #ccc;padding:5px;font-weight:bold;text-align:center">BB</td>
								</tr>
							</table>
							<div class="tmpl_isi">
								<div class="headd"></div>
								<div class="txtIsi"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
</section>

<script>

$(document).ready(function(){
	$(".headd").html('');
	$(".txtIsi").html('');
});

$('#cari_po').keyup(async () => {
	let plh_corr = $('#plh_corr').val();
	let cari = $('#cari_po').val();
	
	await $.ajax({
		url: '<?php echo base_url('Laporan/CariPoCorr'); ?>',
		type: "POST",
		data: ({
			plh_corr: plh_corr,
			cari: cari,
		}),
		success: function(response){
			if(response){
				$(".headd").hide();
				$(".txtIsi").html(response);
			}else{
				$(".headd").show();
				$(".txtIsi").html('');
			}
		}
	});
});

// async function BtnPrint() {

// }

</script>
