<style>
	.list-table {
		margin:0;padding:0;color:#000;font-size:12px;border-collapse:collapse
	}

	.list-pl, .list-pl-cek {
		padding-top:10px
	}

	.list-pl-d {
		color:#000
	}
</style>

<?php
	// SuperAdmin, Admin, QC, FG, User
	if($this->session->userdata('level') == "SuperAdmin"){
		$otorisasi = 'all';
	}else if($this->session->userdata('level') == "Admin"){
		$otorisasi = 'admin';
	}else if($this->session->userdata('level') == "QC"){
		$otorisasi = 'qc';
	}else if($this->session->userdata('level') == "FG"){
		$otorisasi = 'fg';
	}else{
		$otorisasi = 'user';
	}
?>

<section class="content">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							<ol class="breadcrumb">
								<li style="font-weight:bold">PENGIRIMAN</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<button disabled="disabled">PILIH :</button>
						<input type="date" name="ngirim-tgl" id="ngirim-tgl" value="<?= date('Y-m-d')?>">
						<button onclick="load_data()">CARI</button>
						
						<div class="list-pl"></div>
						<div class="list-pl-cek"></div>
					</div>
				</div>
			</div>
</section>

<!-- DETAIL LIST PO -->
<!-- <div class="modal fade bd-example-modal-lg" id="modal-stok-list" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">
				<div class="isi-stok-list"></div>
				<div class="isi-stok-tuan"></div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div> -->

<script>
	$(document).ready(function(){
		plh_tgl = $('#ngirim-tgl').val();
		$('.list-pl').html('').hide();
		// kosong();
		load_data(plh_tgl);
	});

	// function kosong(){
	// }

	function load_data(tgl){
		tgl = $("#ngirim-tgl").val();
		$.ajax({
			url: '<?php echo base_url('Master/pList'); ?>',
			type: "POST",
			data: ({
				tgl: tgl
			}),
			success: function(response){
				if(response){
					$(".list-pl").show().html(response);
					// cekQC();
				}else{
					$(".list-pl").show().html('DATA TIDAK DITEMUKAN');
				}
			}
		});
	}

	function btnCekQc(opl,i){
		// alert(opl+' '+i);
		$(".id-cek").html('');
		$(".t-plist-cek-" + i).html(`<table class="list-table">
			<tr>
				<td style="padding:5px;font-weight:bold">No.</td>
				<td style="padding:5px;font-weight:bold">Customer</td>
			</tr>
		</table>`);
	}

</script>
