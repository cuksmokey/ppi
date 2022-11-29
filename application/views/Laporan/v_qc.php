<style>
	.tmbl-opsi {
		background: #f44336;
		padding: 5px 7px;
		color: #fff;
		font-weight: bold;
		border: 0;
		border-radius: 5px;
		cursor: pointer;
	}

	.tmbl-opsi:hover, .tmbl-cari:hover {
		background: #c40316;
	}

	.tmbl-cek-roll {
		background:transparent;margin:0;padding:0;border:0
	}

	.tmbl-cari {
		background:#f44336;
		color:#fff;
		font-weight:bold;
		padding:4px 8px;
		border:0;
		border-radius:5px
	}

	.ttggll, .ipt-txt {
		background:transparent;margin:0;padding:0;border:0
	}
	
	.cek-status-stok {
		background-color: #fff;
	}
	.cek-status-stok:hover {
		background-color: #eee;
	}
	.cek-status-stok:hover .edit-roll {
		background-color: #eee;
	}

	.cek-status-buffer {
		background-color: #fee;
	}
	.cek-status-buffer:hover {
		background-color: #edd;
	}
	.cek-status-buffer:hover .edit-roll {
		background:#edd;
	}

	.cek-status-terjual {
		background-color: #dfd;
	}
	.cek-status-terjual:hover {
		background-color: #cec;
	}

	.opt_status {
		background:none;border:0;
	}

	.edit-roll {
		background:#fff
	}
	
	textarea {
		outline: none;
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
								<li style="font-weight:bold">LIST ROLL</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<input type="hidden" id="otorisasi" value="<?= $otorisasi ?>">
						<button class="tmbl-opsi" onclick="opsi('roll')">PER ROLL</button>
						<button class="tmbl-opsi" onclick="opsi('tgl')">PER TANGGAL</button><br/><br/>

						<div class="per_roll">
							<input type="text" name="jnsroll" id="jnsroll" maxlength="8" style="border:1px solid #ccc;padding:5px;border-radius:5px" autocomplete="off" placeholder="JENIS">
							<input type="text" name="gsmroll" id="gsmroll" onkeypress="return hanyaAngka(event)" maxlength="3" style="border:1px solid #ccc;padding:5px;border-radius:5px" autocomplete="off" placeholder="GSM">
							<input type="text" name="ukroll" id="ukroll" onkeypress="return aK(event)" maxlength="5" style="border:1px solid #ccc;padding:5px;border-radius:5px" autocomplete="off" placeholder="UKURAN">
							<input type="text" name="proll" id="proll" style="border:1px solid #ccc;padding:5px;border-radius:5px" autocomplete="off" placeholder="NO. ROLL">
							<button class="tmbl-cari" onclick="cariPer('rroll')">CARI</button>
						</div>

						<div class="per_tgl">
							<input type="date" name="tgl1" id="tgl1" style="margin-right:3px;padding:3px 5px;border:1px solid #ccc;border-radius:5px">
							s/d
							<input type="date" name="tgl2" id="tgl2" style="margin-left:3px;padding:3px 5px;border:1px solid #ccc;border-radius:5px">
							<button class="tmbl-cari" onclick="cariPer('ttgl')">CARI</button>
						</div><br/>

						<div class="isi"></div>
						
					</div>
				</div>
			</div>
</section>

<div class="modal fade bd-example-modal-lg" id="modal-qc-list" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">
				<div class="isi-qc-terjual"></div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(".per_roll").hide();
		$(".per_tgl").hide();
		kosong();
	});

	function kosong(){
		$("#jnsroll").val("");
		$("#gsmroll").val("");
		$("#ukroll").val("");
		$("#proll").val("");
		$("#tgl1").val("");
		$("#tgl2").val("");
	}

	$("#jnsroll").on({
		// keydown: function(e) {
		// 	if (e.which === 32)
		// 		return false;
		// },
		keyup: function() {
			this.value = this.value.toUpperCase();
		},
		// change: function() {
		// 	this.value = this.value.replace(/\s/g, "");
		// }
	});

	function hanyaAngka(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}

	function aK(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		// alert(charCode);
		if (charCode > 31 && (charCode < 46 || charCode > 57))
			return false;
		return true;
	}

	function opsi(opsi){
		if(opsi == 'roll'){
			kosong();
			$(".per_roll").show();
			$(".per_tgl").hide();
			$(".isi").html('').hide();
		}else{
			kosong();
			$(".per_roll").hide();
			$(".per_tgl").show();
			$(".isi").html('').hide();
		}
	}

	function cariPer(opsi){ //
		otorisasi = $("#otorisasi").val();
		jnsroll = $("#jnsroll").val();
		gsmroll = $("#gsmroll").val();
		ukroll = $("#ukroll").val();
		roll = $("#proll").val();
		tgl1 = $("#tgl1").val();
		tgl2 = $("#tgl2").val();
		// alert(jnsroll+' '+gsmroll+' '+ukroll+' '+roll+' '+tgl1+' '+tgl2+' '+opsi);
		$(".isi").show().html('Mencari Data . . .');
		$.ajax({
			url: '<?php echo base_url('Laporan/QCCariRoll'); ?>',
			type: "POST",
			data: ({
				jnsroll: jnsroll,
				gsmroll: gsmroll,
				ukroll: ukroll,
				roll: roll,
				tgl1: tgl1,
				tgl2: tgl2,
				opsi: opsi, // ROLL, TGL
				otori: otorisasi,
				stat: '',
				vtgl: '',
				vtgl2: '',
				pm: '',
			}),
			success: function(response){
				if(response){
					$(".isi").html(response);
				}else{
					$(".isi").html('Data Tidak ditemukan...');
				}
			}
		});
	};

	function cek_roll(id){
		$(".isi-qc-terjual").html('Tunggu Sebentar . . .');
		$("#modal-qc-list").modal("show");
		$.ajax({
			url: '<?php echo base_url('Laporan/QCRollTerjual') ?>',
			type: "POST",
			data: ({
				id: id
			}),
			success: function(response) {
				$(".isi-qc-terjual").html(response);
			}
		});
	}

	function editRoll(i){ //
		otorisasi = $("#otorisasi").val();
		tgl = $("#etgl-"+i).val();
		g_ac = $("#eg_ac-"+i).val();
		rct = $("#erct-"+i).val();
		bi = $("#ebi-"+i).val();
		nm_ker = $("#enm_ker-"+i).val().toUpperCase();
		g_label = $("#eg_label-"+i).val();
		width = $("#ewidth-"+i).val();
		diameter = $("#ediameter-"+i).val();
		weight = $("#eweight-"+i).val();
		joint = $("#ejoint-"+i).val();
		ket = $("#eket-"+i).val().toUpperCase();
		status = $("#opt_status-"+i).val();
		// alert(tgl+' - '+g_ac+' - '+rct+' - '+bi+' - '+nm_ker+' - '+g_label+' - '+width+' - '+diameter+' - '+weight+' - '+joint+' - '+ket+' - '+status+' - '+pilihan);
		if (nm_ker == '' || g_label == '' || width == '' || diameter == '' || weight == '' || joint == '') {
			showNotification("alert-danger", "DATA JENIS, GSM, UKURAN, DIAMETER, BERAT, JOINT, TIDAK BOLEH KOSONG!!!", "bottom", "center", "", "");
			return;
		}
		$.ajax({
			url: '<?php echo base_url('Master/editQCRoll') ?>',
			type: "POST",
			data: ({
				id : i,
				tgl : tgl,
				g_ac : g_ac,
				rct : rct,
				bi : bi,
				nm_ker : nm_ker,
				g_label : g_label,
				width : width,
				diameter : diameter,
				weight : weight,
				joint : joint,
				ket : ket,
				status : status,
				edit: 'LapQC',
			}),
			success: function(data) {
				json = JSON.parse(data);
				showNotification("alert-success", "BERHASIL!!!", "top", "center", "", "");
				$("#etgl-"+i).val(json.tgl).animateCss('fadeInRight');
				$("#eg_ac-"+i).val(json.g_ac).animateCss('fadeInRight');
				$("#erct-"+i).val(json.rct).animateCss('fadeInRight');
				$("#ebi-"+i).val(json.bi).animateCss('fadeInRight');
				$("#enm_ker-"+i).val(json.nm_ker).animateCss('fadeInRight');
				$("#eg_label-"+i).val(json.g_label).animateCss('fadeInRight');
				$("#ewidth-"+i).val(json.width).animateCss('fadeInRight');
				$("#ediameter-"+i).val(json.diameter).animateCss('fadeInRight');
				$("#eweight-"+i).val(json.weight).animateCss('fadeInRight');
				$("#ejoint-"+i).val(json.joint).animateCss('fadeInRight');
				$("#eket-"+i).val(json.ket).animateCss('fadeInRight');
				$("#opt_status-"+i).val(json.status).animateCss('fadeInRight');
			}
		});
	}

	// function NumberFormat(num) {
	// 	return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
	// }

</script>
