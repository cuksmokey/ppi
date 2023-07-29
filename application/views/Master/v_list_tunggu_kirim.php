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

	.all-list-gg:hover {
		background: rgba(238, 238, 238, 0.5);
	}

	.lnk:hover {
		text-decoration: underline;
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
								<li style="font-weight:bold">LIST MENUNGGU KIRIMAN</li>
							</ol>
						</h2>
					</div>

					<div class="body">

						<button class="tmbl-plh-all-list btn-r-cust tmbl-plh" style="font-size:12px;color:#000" onclick="plh_menu('allList')">SEMUA LIST</button>
						<button class="tmbl-plh-all-list btn-r-cust tmbl-plh" style="font-size:12px;color:#000" onclick="plh_menu('perCustomer')">PER CUSTOMER</button>
						<!-- <button class="tmbl-plh" style="font-size:12px;color:#000" onclick="plh_menu('rekapan')">REKAPAN</button> -->

						<div class="menu-list" style="padding-top:10px;font-size:12px">
							<?php
								$qGsm = $this->db->query("SELECT nm_ker,g_label FROM po_master po
								WHERE g_label!='120' AND po.status='open'
								AND (jml_roll!='0' OR ket LIKE '%PENDING%') AND id_perusahaan!='210' AND id_perusahaan!='217' AND nm_ker!='WP'
								GROUP BY nm_ker,g_label");
							?>

							<div class="form-btn-all-list"></div>
							
							<?php foreach($qGsm->result() as $txt) { ?>
								<div class="grp-all-list isi-all-list-<?= $txt->nm_ker ?><?= $txt->g_label ?>"></div>
							<?php } ?>
						</div>

						<div class="menu-customer" style="padding-top:10px;font-size:12px">
							<div class="isi-customer"></div>
						</div>

						<!-- <div class="menu-rekapan" style="padding-top:10px;font-size:12px">
							<div class="isi-rekap"></div>
						</div> -->

					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade bd-example-modal-lg" id="modal-kurang-kirim" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">
				<div class="popup-list-kurang-kirim"></div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<script>
	status = '';
	otorisasi = $("#otorisasi").val();

	$(document).ready(function() {
		$(".menu-list").hide();
		$(".menu-customer").hide();
		$(".menu-rekapan").hide();
		kosong();
	});

	function plh_menu(plh) {
		if(plh == 'allList'){
			$(".grp-all-list").html('');
			$(".menu-list").show();
			$(".menu-customer").hide();
			$(".menu-rekapan").hide();
			tkLoadBtnKerGlabel();
		}else if(plh == 'perCustomer'){
			$(".menu-list").hide();
			$(".menu-customer").show();
			$(".menu-rekapan").hide();
			tkLoadCustomer();
		}else if(plh == 'rekapan'){
			$(".menu-list").hide();
			$(".menu-customer").hide();
			$(".menu-rekapan").show();
			loadRekap();
		}	
	}

	function kosong() {

	}

	//

	function tkLoadBtnKerGlabel(){
		$(".form-btn-all-list").html('');
		$(".form-btn-all-list").html('MEMUAT JENIS, GSM . . .');
		$.ajax({
			url: '<?php echo base_url('Laporan/loadtkBtnAllList'); ?>',
			type: "POST",
			success: function(res){
				$(".form-btn-all-list").html('');
				$(".form-btn-all-list").html(res);
			}
		})
	}

	function btnTkAllListPer(nmker,glabel){
		// alert(nmker+' '+glabel);
		$(".tmbl-plh-all-list").prop("disabled", true);
		$(".isi-all-list-" + nmker+glabel).html('<div style="padding:10px 0 0;color:#000">MEMUAT DATA - '+nmker+glabel+' . . .</div>');
		$.ajax({
			url: '<?php echo base_url('Laporan/loadTkAllListPer'); ?>',
			type: "POST",
			data: ({
				nmker,glabel
			}),
			success: function(res){
				$(".isi-all-list-" + nmker+glabel).html(res);
				$(".tmbl-plh-all-list").prop("disabled", false);
			}
		})
	}

	function cekTungguKirim(nm_ker,g_label,width,id){
		// alert(nm_ker+' '+g_label+' '+width+' '+id);
		$(".popup-list-kurang-kirim").html('Tunggu Sebentar . . .');
		$("#modal-kurang-kirim").modal("show");
		$.ajax({
			url: '<?php echo base_url('Laporan/PopupTungguKirim') ?>',
			type: "POST",
			data: ({
				nm_ker,g_label,width,id
			}),
			success: function(response) {
				$(".popup-list-kurang-kirim").html(response);
			}
		});
	}

	function cekKirimanTkRoll(no_surat,no_po,nm_ker,g_label,width,i){
		// alert(no_surat+' '+no_po+' '+nm_ker+' '+g_label+' '+width); clear-tmpl-roll
		$(".clear-tmpl-roll").html('');
		$(".tmpl-roll-tk-kirim-" + i).html('<div style="padding-left:5px">MEMUAT . . .</div>');
		$.ajax({
			url: '<?php echo base_url('Laporan/PopupTkKiriman') ?>',
			type: "POST",
			data: ({
				no_surat,no_po,nm_ker,g_label,width,i
			}),
			success: function(response) {
				$(".tmpl-roll-tk-kirim-" + i).html(response);
			}
		});
	}

	//

	function tkLoadCustomer(){
		$(".isi-customer").html('');
		$(".isi-customer").html('MEMUAT CUSTOMER . . .');
		$.ajax({
			url: '<?php echo base_url('Laporan/loadTkCustomer'); ?>',
			type: "POST",
			// data: ({
			// }),
			success: function(res){
				$(".isi-customer").html('');
				$(".isi-customer").html(res);
			}
		})
	}

	function btnRCust(i,id){
		// alert(i+' '+id);
		$(".btn-cek").html('');
		$(".btn-r-cust").prop("disabled", true);
		$(".isi-rincian-customer-" + i).html('<div style="padding:5px 0" class="notip">MEMUAT DATA . . .</div>');
		$.ajax({
			url: '<?php echo base_url('Laporan/BtnRCustList')?>',
			type: "POST",
			data: ({
				i, id
			}),
			success: function(response){
				$(".isi-rincian-customer-" + i).html(response);
				$(".btn-r-cust").prop("disabled", false);
			}
		})
	}

	//

	function loadRekap(){
		$(".isi-rekap").html('');
		$(".isi-rekap").html('MEMUAT REKAPAN . . .');
		$.ajax({
			url: '<?php echo base_url('Laporan/loadRekap'); ?>',
			type: "POST",
			// data: ({
			// }),
			success: function(res){
				$(".isi-rekap").html('');
				$(".isi-rekap").html(res);
			}
		})
	}

</script>
