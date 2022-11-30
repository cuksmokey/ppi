<style>
	.list-table {
		margin:0;padding:0;color:#000;font-size:12px;border-collapse:collapse
	}

	.list-pl, .list-pl-cek {
		padding-top:10px
	}

	.txt-area-i {
		background:transparent;margin:0;padding:0;border:0;resize:none;width:100%;height:20px
	}

	.list-p-biru {
		background: #ccf
	}
	.list-p-biru:hover {
		background: #dde
	}

	.list-p-kuning {
		background: #ffc
	}
	.list-p-kuning:hover {
		background: #eed
	}

	.list-p-merah {
		background: #fcc
	}
	.list-p-merah:hover {
		background: #edd
	}

	.list-p-hijau {
		background: #cfc
	}
	.list-p-hijau:hover {
		background: #ded
	}

	.list-p-putih {
		background: #fff
	}
	.list-p-putih:hover {
		background: #eee
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
				}else{
					$(".list-pl").show().html('DATA TIDAK DITEMUKAN');
				}
			}
		});
	}

	function btnRencana(opl,tgl_pl,i){
		$(".t-plist-hasil-input-" + i).load("<?php echo base_url('Master/destroyCartInputRoll') ?>");
		// alert(opl+' '+tgl_pl+' '+i);
		$(".id-cek").html('');
		$.ajax({
			url: '<?php echo base_url('Master/pListRencana')?>',
			type: "POST",
			data: ({
				opl: opl,
				tgl_pl: tgl_pl,
				i: i
			}),
			success: function(response) {
				if(response){
					$(".t-plist-rencana-" + i).html(response);
				}else{
					$(".t-plist-rencana-" + i).html('TIDAK ADA DATA');
				}
			}
		});
	}

	function btnInputRoll(i,nm_ker,g_label,width,roll=''){
		$(".t-plist-hasil-input-" + i).load("<?php echo base_url('Master/destroyCartInputRoll') ?>");
		// alert(i+' - '+nm_ker+' - '+g_label+' - '+width);
		$(".t-plist-input-" + i).html('Memuat Data...');
		$.ajax({
			url: '<?php echo base_url('Master/pListInputRoll')?>',
			type: "POST",
			data: ({
				i: i, 
				nm_ker: nm_ker, 
				g_label: g_label, 
				width: width, 
				roll: roll, 
			}),
			success: function(response){
				if(response){
					$(".t-plist-input-" + i).html(response);
					$('#roll').val(roll);
				}else{
					$(".t-plist-input-" + i).html('TIDAK ADA DATA');
				}
			}
		});
	}

	// function cartInputRoll(id,roll,nm_ker,g_label,diameter,width,weight,joint,ket,i){
	function cartInputRoll(id,roll,i){
		$.ajax({
			url: '<?php echo base_url('Master/pListCartInputRoll')?>',
			type: "POST",
			data: ({
				id: id,
				roll: roll,
				// nm_ker: nm_ker,
				// g_label: g_label,
				// diameter: diameter,
				// width: width,
				// weight: weight,
				// joint: joint,
				// ket: ket,
				i: i,
			}),
			success: function(response){
				if(response){
					$(".t-plist-hasil-input-" + i).html(response);
				}else{
					$(".t-plist-hasil-input-" + i).html('NOTHING');
				}
			}
		});
	}

	function hapusCartInputRoll(rowid,i){
		// alert(rowid+' - '+i);
		$.ajax({
			url: '<?php echo base_url('Master/hapusCartInputRoll')?>',
			type: "POST",
			data: ({
				rowid: rowid
			}),
			success: function(response){
				$(".t-plist-hasil-input-" + i).html(response);
			}
		});
	}

	function cariRoll(i,nm_ker,g_label,width,cari){
		xroll = $('#roll').val();
		alert(i+' - '+nm_ker+' - '+g_label+' - '+width+' - '+xroll+' - '+cari);
		// btnInputRoll(i,nm_ker,g_label,width,xroll);
	}

</script>
