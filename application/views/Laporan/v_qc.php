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
		background:transparent;
		margin:0;
		padding:0;
		border:0;
	}

	.tmbl-cari {
		background:#f44336;
		color:#fff;
		font-weight:bold;
		padding:4px 8px;
		border:0;
		border-radius:5px
	}

	.lbl-besar{
		text-decoration: none;
		padding: 5px;
		color:#000;
		font-weight: bold;
	}

	.lbl-besar:hover{
		color:#000;
	}

	.ttggll, .ipt-txt {
		background:transparent;margin:0;padding:0;border:0
	}

	.cek-status-rk {
		background-color: #eef;
	}
	.cek-status-rk:hover {
		background-color: #dde;
	}
	.cek-status-rk:hover .edit-roll {
		background-color: #dde;
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

	.cek-status-retur {
		background-color: #fe9;
	}
	.cek-status-retur:hover {
		background-color: #ed8;
	}
	.cek-status-retur:hover .edit-roll {
		background:#ed8;
	}

	.cek-status-rk-rtr {
		background-color: #cb6;
	}
	.cek-status-rk-rtr:hover {
		background-color: #ba5;
	}
	.cek-status-rk-rtr:hover .edit-roll {
		background-color: #ba5;
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
	}else if($this->session->userdata('level') == "Finance"){
		$otorisasi = 'finance';
	}else if($this->session->userdata('level') == "Office"){
		$otorisasi = 'office';
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

					<div class="body" style="overflow:auto;white-space:nowrap">
						<input type="hidden" id="otorisasi" value="<?= $otorisasi ?>">
						<button class="tmbl-opsi" onclick="opsi('roll')">PER ROLL</button>
						<button class="tmbl-opsi" onclick="opsi('tgl')">PER TANGGAL</button><br/><br/>

						<div class="per_roll">
							<!-- <input type="text" name="jnsroll" id="jnsroll" maxlength="8" style="border:1px solid #ccc;padding:5px;border-radius:5px" autocomplete="off" placeholder="JENIS"> -->
							<!-- <input type="text" name="gsmroll" id="gsmroll" onkeypress="return hanyaAngka(event)" maxlength="3" style="border:1px solid #ccc;padding:5px;border-radius:5px" autocomplete="off" placeholder="GSM"> -->
							<!-- <input type="text" name="ukroll" id="ukroll" onkeypress="return aK(event)" maxlength="5" style="border:1px solid #ccc;padding:5px;border-radius:5px" autocomplete="off" placeholder="UKURAN"> -->
							<!-- <input type="text" name="proll" id="proll" style="border:1px solid #ccc;padding:5px;border-radius:5px" autocomplete="off" placeholder="NO. ROLL"> -->
							<!-- <button class="tmbl-cari" onclick="cariPer('rroll')">CARI</button> -->
							<table style="width:100%;color:#000">
								<tr>
									<td style="padding:0;border:0;width:10%"></td>
									<td style="padding:0;border:0;width:1%"></td>
									<td style="padding:0;border:0;width:89%"></td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">JENIS</td>
									<td style="padding:5px 3px;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="text" name="jnsroll" id="jnsroll" maxlength="8" class="form-control" autocomplete="off" placeholder="MH, BK, MN, WP, MH COLOR">
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">GSM</td>
									<td style="padding:5px 3px;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="text" name="gsmroll" id="gsmroll" onkeypress="return hanyaAngka(event)" maxlength="3" class="form-control" autocomplete="off" placeholder="110, 125, 150, dst">
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">UKURAN</td>
									<td style="padding:5px 3px;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="text" name="ukroll" id="ukroll" onkeypress="return aK(event)" maxlength="5" class="form-control" autocomplete="off" placeholder="110, 125, 150, 123.4, dst">
									</td>
								</tr>
								<tr>
									<td style="padding-bottom:5px;" colspan="2"></td>
									<td style="padding-bottom:5px;font-size:11px;color:#f00;font-style:italic">* koma pakai titik ( . )</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">ROLL</td>
									<td style="padding:5px 3px;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="text" name="proll" id="proll" class="form-control" autocomplete="off" placeholder="1/00123, 2/00123, 00123">
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">KETERANGAN</td>
									<td style="padding:5px 3px;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="text" name="keterangan" id="keterangan" class="form-control" autocomplete="off" placeholder="KETERANGAN">
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">STATUS</td>
									<td style="padding:5px 3px;text-align:center">:</td>
									<td style="padding:5px 0">
										<select name="plh_status" id="plh_status" class="form-control">
											<option value="ALL">SEMUA</option>
											<option value="STOK">STOK</option>
											<option value="BUFFER">BUFFER</option>
											<option value="RETUR">RETUR</option>
											<option value="PPI">PPI</option>
											<option value="PPISIZING">PPI SIZING</option>
											<option value="PPICALENDER">PPI CALENDER</option>
											<option value="PPIWARNA">PPI WARNA</option>
											<option value="PPIBAROKAHNUSANTARA">PPI BAROKAH / NUSANTARA</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0" colspan="2"></td>
									<td style="padding:5px 0">
										<button class="tmbl-cari" onclick="cariPer('rroll')">CARI</button>
									</td>
								</tr>
							</table>
						</div>

						<div class="per_tgl">
							<!-- <input type="date" name="tgl1" id="tgl1" style="margin-right:3px;padding:3px 5px;border:1px solid #ccc;border-radius:5px"> -->
							<!-- s/d -->
							<!-- <input type="date" name="tgl2" id="tgl2" style="margin-left:3px;padding:3px 5px;border:1px solid #ccc;border-radius:5px"> -->
							<!-- <button class="tmbl-cari" onclick="cariPer('ttgl')">CARI</button> -->
							<table style="width:100%;color:#000">
								<tr>
									<td style="padding:0;border:0;width:10%"></td>
									<td style="padding:0;border:0;width:1%"></td>
									<td style="padding:0;border:0;width:44%"></td>
									<td style="padding:0;border:0;width:1%"></td>
									<td style="padding:0;border:0;width:44%"></td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">TANGGAL</td>
									<td style="padding:5px 3px;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="date" name="tgl1" id="tgl1" class="form-control">
									</td>
									<td style="padding:5px 3px;text-align:center">s/d</td>
									<td style="padding:5px 0">
										<input type="date" name="tgl2" id="tgl2" class="form-control">
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">STATUS</td>
									<td style="padding:5px 3px;text-align:center">:</td>
									<td style="padding:5px 0" colspan="3">
										<select name="plh_status_tgl" id="plh_status_tgl" class="form-control">
											<option value="ALL">SEMUA</option>
											<option value="STOK">STOK</option>
											<option value="BUFFER">BUFFER</option>
											<option value="RETUR">RETUR</option>
											<option value="PPI">PPI</option>
											<option value="PPISIZING">PPI SIZING</option>
											<option value="PPICALENDER">PPI CALENDER</option>
											<option value="PPIBAROKAHNUSANTARA">PPI BAROKAH / NUSANTARA</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding:5px" colspan="2"></td>
									<td style="padding:5px 0" colspan="3">
										<button class="tmbl-cari" onclick="cariPer('ttgl')">CARI</button>
									</td>
								</tr>
							</table>
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
			<div class="modal-body" style="overflow:auto;white-space:nowrap;">
				<div class="isi-qc-terjual"></div>
				<div class="isi-qc-edit"></div>
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
		$("#plh_status").val("ALL");
		
		$("#proll").val("");
		$("#keterangan").val("");
		$("#tgl1").val("");
		$("#tgl2").val("");
		$("#plh_status_tgl").val("ALL");
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
		if(opsi == 'rroll'){
			plh_status = $("#plh_status").val();
		}else{
			plh_status = $("#plh_status_tgl").val();
		}

		roll = $("#proll").val();
		keterangan = $("#keterangan").val();
		tgl1 = $("#tgl1").val();
		tgl2 = $("#tgl2").val();
		// alert(jnsroll+' '+gsmroll+' '+ukroll+' '+roll+' '+tgl1+' '+tgl2+' '+opsi);
		$(".isi").show().html('MENCARI DATA . . .');
		$.ajax({
			url: '<?php echo base_url('Laporan/QCCariRoll'); ?>',
			type: "POST",
			data: ({
				jnsroll: jnsroll,
				gsmroll: gsmroll,
				ukroll: ukroll,
				plh_status: plh_status,
				roll: roll,
				keterangan: keterangan,
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
		$(".isi-qc-edit").html('');
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

	function cekRollEdit(idroll,roll){
		$(".isi-qc-terjual").html('');
		$(".isi-qc-edit").html('Tunggu Sebentar . . .');
		$("#modal-qc-list").modal("show");
		$.ajax({
			url: '<?php echo base_url('Laporan/QCShowEditRoll')?>',
			type: "POST",
			data: ({
				idroll,roll
			}),
			success: function(response){
				$(".isi-qc-edit").html(response);
			}
		});
	}

	function editRoll(i){ //
		otorisasi = $("#otorisasi").val();
		tgl = $("#etgl-"+i).val();
		g_ac = $("#eg_ac-"+i).val();
		rct = $("#erct-"+i).val();
		bi = $("#ebi-"+i).val();
		cobb = $("#ecobb-"+i).val();
		moisture = $("#emoisture-"+i).val();
		rm = $("#erm-"+i).val();
		nm_ker = $("#enm_ker-"+i).val().toUpperCase();
		g_label = $("#eg_label-"+i).val();
		width = $("#ewidth-"+i).val();
		diameter = $("#ediameter-"+i).val();
		weight = $("#eweight-"+i).val();
		joint = $("#ejoint-"+i).val();
		ket = $("#eket-"+i).val().toUpperCase();
		status = $("#opt_status-"+i).val();
		// alert(tgl+' - '+g_ac+' - '+rct+' - '+bi+' - '+nm_ker+' - '+g_label+' - '+width+' - '+diameter+' - '+weight+' - '+joint+' - '+ket+' - '+status);

		// MENAMPUNG DATA LAMA
		lroll = $("#lroll-"+i).val();
		lnm_ker = $("#lnm_ker-"+i).val();
		lg_label = $("#lg_label-"+i).val();
		lwidth = $("#lwidth-"+i).val();
		lweight = $("#lweight-"+i).val();
		ldiameter = $("#ldiameter-"+i).val();
		ljoint = $("#ljoint-"+i).val();
		lket = $("#lket-"+i).val();
		lstatus = $("#lstatus-"+i).val();
		// console.log(lroll,lnm_ker,lg_label,lwidth,lweight,ldiameter,ljoint,lket,lstatus);

		if (tgl == '' || nm_ker == '' || g_label == '' || width == '' || diameter == '' || weight == '' || joint == '') {
			showNotification("alert-danger", "DATA TANGGAL, JENIS, GSM, UKURAN, DIAMETER, BERAT, JOINT, TIDAK BOLEH KOSONG!!!", "bottom", "center", "", "");
			return;
		}
		// $(".edit-roll").prop("disabled", true);
		$("#btnn-edit-roll-"+i).prop("disabled", true);
		$.ajax({
			url: '<?php echo base_url('Master/editQCRoll') ?>',
			type: "POST",
			data: ({
				id : i,
				tgl : tgl,
				g_ac : g_ac,
				rct : rct,
				bi : bi,
				cobb : cobb,
				moisture : moisture,
				rm : rm,
				nm_ker : nm_ker,
				g_label : g_label,
				width : width,
				diameter : diameter,
				weight : weight,
				joint : joint,
				ket : ket,
				status : status,
				lroll: lroll, // menampung data lama
				lnm_ker: lnm_ker,
				lg_label: lg_label,
				lwidth: lwidth,
				lweight: lweight,
				ldiameter: ldiameter,
				ljoint: ljoint,
				lket: lket,
				lstatus: lstatus,
				edit: 'LapQC',
			}),
			success: function(data) {
				json = JSON.parse(data);
				if(json.data){
					showNotification("alert-success", "BERHASIL!!!", "top", "center", "", "");
				}else{
					swal(json.msg, "", "error");
				}

				$("#etgl-"+i).val(json.tgl).animateCss('fadeInRight');
				$("#eg_ac-"+i).val(json.g_ac).animateCss('fadeInRight');
				$("#erct-"+i).val(json.rct).animateCss('fadeInRight');
				$("#ebi-"+i).val(json.bi).animateCss('fadeInRight');
				$("#ecobb-"+i).val(json.cobb).animateCss('fadeInRight');
				$("#emoisture-"+i).val(json.moisture).animateCss('fadeInRight');
				$("#erm-"+i).val(json.rm).animateCss('fadeInRight');
				$("#enm_ker-"+i).val(json.nm_ker).animateCss('fadeInRight');
				$("#eg_label-"+i).val(json.g_label).animateCss('fadeInRight');
				$("#ewidth-"+i).val(json.width).animateCss('fadeInRight');
				$("#ediameter-"+i).val(json.diameter).animateCss('fadeInRight');
				$("#eweight-"+i).val(json.weight).animateCss('fadeInRight');
				$("#ejoint-"+i).val(json.joint).animateCss('fadeInRight');
				$("#eket-"+i).val(json.ket).animateCss('fadeInRight');
				$("#opt_status-"+i).val(json.status).animateCss('fadeInRight');

				// MENAMPUNG DATA LAMA
				$("#lroll-"+i).val(json.roll);
				$("#lnm_ker-"+i).val(json.nm_ker);
				$("#lg_label-"+i).val(json.g_label);
				$("#lwidth-"+i).val(json.width);
				$("#lweight-"+i).val(json.weight);
				$("#ldiameter-"+i).val(json.diameter);
				$("#ljoint-"+i).val(json.joint);
				$("#lket-"+i).val(json.ket);
				$("#lstatus-"+i).val(json.status);

				$("#btnn-edit-roll-"+i).prop("disabled", false);
			}
		});
	}
</script>
