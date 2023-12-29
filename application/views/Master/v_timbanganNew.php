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

<style>
	.btn-rpk, .btn-tdk {
		background: #ccc;
		font-weight: bold;
		padding: 6px 8px;
		border: 0;
	}

	.btn-pilih{
		background: #fff;
		font-weight: bold;
		padding: 6px 8px;
		border: 3px solid #0f0;
		border-width: 0 0 0 4px;
	}

	.bg-iya {
		background: #ccc;
		font-weight: bold;
	}

	.bg-tdk {
		background: #fff;
	}

	.btn-gg {
		background: none;
		background: transparent;
		margin: 0;
		padding: 0;
		border:0
	}

	.not-tt{
		background: #fff;
	}

	.plh-tt{
		background: #0f0;
		text-decoration: underline;
		font-weight: bold;
	}

	.new-tt{
		font-weight: bold;
		background: #e9e9e9 !important;
	}

	.tr-dtl-rpk:hover{
		background: rgba(230, 230, 230, 0.5);
	}
</style>

<section class="content">
	<div class="container-fluid">
		<!-- Exportable Table -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							<ol class="breadcrumb">
								<li class="">MASTER TIMBANGAN</li>
							</ol>
						</h2>

					</div>

					<div class="body">
						<div class="box-data">
							<table width="100%">
								<tr>
									<td> <button type="button" class="btn-add btn btn-default btn-sm waves-effect">
											<b><span>NEW</span></b>
										</button>
									</td>
								</tr>
							</table>


							<br><br>
							<div style="margin-top:15px;overflow:auto;white-space:nowrap;">
								<table id="datatable11" class="table table-bordered table-striped table-hover dataTable ">
									<thead>
										<tr>
											<th>ROLL</th>
											<th>TANGGAL</th>
											<th>JENIS</th>
											<th>GSM</th>
											<th>UKURAN</th>
											<th>DIAMETER</th>
											<th>BERAT</th>
											<th>JOINT</th>
											<th>KETERANGAN</th>
											<th width="15%">AKSI</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>

						<!-- box form -->
						<div class="box-form" style="color:#000">
							<input type="hidden" id="box-data-id-rpk" value="">
							<input type="hidden" id="box-data-idx" value="">
							<div class="box-load-nmker"></div>
							<div class="box-load-rpk" style="padding-bottom:10px;border-bottom: 8px solid #aaa;"></div>

							<table style="width:100%">
								<tr>
									<td style="padding:5px;width:13%"></td>
									<td style="padding:5px;width:auto"></td>
									<td style="padding:5px;width:20%"></td>
									<td style="padding:5px;width:auto"></td>
								</tr>
								<tr>
									<td style="padding:3px 0;font-weight:bold">ROLL NUMBER</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0" colspan="2">
										<div class="new_roll">
											<?php
												if($this->session->userdata('level') == "Rewind1"){
													$kodePm = '1';
													$dkodepm = 'disabled';
												}else if($this->session->userdata('level') == "Rewind2"){
													$kodePm = '2';
													$dkodepm = 'disabled';
												}else{
													$kodePm = '';
													$dkodepm = '';
												} 
											?>
											<input type="hidden" id="id_rpk" value="">
											<input type="hidden" id="i_rpk" value="">
											<input type="hidden" id="getid" value="">
											<input type="hidden" id="l-tgl" value="">
											<input type="hidden" id="l-nm_ker" value="">
											<input type="hidden" id="l-g_label" value="">
											<input type="hidden" id="l-width" value="">
											<input type="hidden" id="l-weight" value="">
											<input type="hidden" id="l-diameter" value="">
											<input type="hidden" id="l-joint" value="">
											<input type="hidden" id="l-ket" value="">
											<input type="hidden" id="l-status" value="">
											<table>
												<tr>
													<td><input type="text" id="id1kode" class="form-control" maxlength="1" autocomplete="off" placeholder="PM" tabindex="1" onkeypress="return hanyaPm(event)" value="<?php echo $kodePm; ?>"></td>
													<td style="padding: 0 5px">/</td>
													<td><input type="text" id="id11" class="angka form-control" maxlength="5" autocomplete="off" placeholder="NOMOR ROLL" tabindex="2"></td>
													<td style="padding: 0 5px">/</td>
													<td><input type="text" id="id22" class="angka form-control" maxlength="2" autocomplete="off" placeholder="TAHUN"></td>
													<td><input type="text" id="id2bln" class="form-control" maxlength="1" autocomplete="off" placeholder="BULAN" onkeypress="return hanyaBln(event)"></td>
													<td style="padding: 0 5px">/</td>
													<td><input type="text" id="id44" class="angka form-control" maxlength="1" autocomplete="off" placeholder="0" tabindex="3"></td>
													<td><input type="text" id="id4kode" class="form-control" maxlength="1" autocomplete="off" placeholder="F/M/B" tabindex="4" onkeypress="return hanyaHuruf(event)"></td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
								<tr>
									<td style="padding:3px 0;font-weight:bold">TANGGAL</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0">
										<input type="date" id="tgl" value="" class="form-control">
									</td>
								</tr>
								<tr>
									<td style="padding:3px 0;font-weight:bold">NAMA KERTAS</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0">
										<input type="text" id="nm_ker" class="form-control new-tt" autocomplete="off" placeholder="PILIH" disabled>
									</td>
								</tr>
								<tr>
									<td style="padding:3px 0;font-weight:bold">GRAMATURE</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0">
										<input type="text" id="g_label" class="form-control new-tt" autocomplete="off" placeholder="PILIH" disabled>
									</td>
									<td style="padding:3px 5px">GSM</td>
								</tr>
								<tr>
									<td style="padding:3px 0;font-weight:bold">UKURAN</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0">
										<input type="text" id="width" class="form-control new-tt" autocomplete="off" placeholder="PILIH" disabled>
									</td>
									<td style="padding:3px 5px">CM</td>
								</tr>
								<tr>
									<td style="padding:3px 0;font-weight:bold">DIAMATER</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0">
										<input type="text" class="angka form-control" placeholder="0" id="diameter" maxlength="5" autocomplete="off">
									</td>
									<td style="padding:3px 5px">CM</td>
								</tr>
								<tr>
									<td style="padding:3px 0;font-weight:bold">BERAT</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0">
										<input type="text" class="angka form-control" placeholder="0" id="weight" maxlength="5" autocomplete="off">
									</td>
									<td style="padding:3px 5px">KG</td>
								</tr>
								<tr>
									<td style="padding:3px 0;font-weight:bold">JOINT</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0">
										<input type="text" class="angka form-control" placeholder="0" id="joint" maxlength="3" autocomplete="off">
									</td>
								</tr>
								<tr>
									<td style="padding:3px 0;font-weight:bold">KETERANGAN</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0" colspan="2">
										<textarea id="ket" cols="30" rows="5" class="form-control"></textarea>
									</td>
								</tr>
								<tr>
									<td colspan="4" style="padding:5px"></td>
								</tr>
							</table>

							<button type="button" class="btn-kembali btn btn-dark btn-default btn-sm waves-effect">
								<b><span>BACK</span></b>
							</button> &nbsp;&nbsp;
							<?php if($otorisasi != 'admin') { ?>
							<button onclick="simpan()" id="btn-simpan" type="button" class="btn bg-light-green btn-sm waves-effect">
								<b><span id="txt-btn-simpan">SIMPAN</span></b>
							</button> &nbsp;&nbsp;
							<?php } ?>
							<!-- <button onclick="kosong()" type="button" class="btn btn-default btn-sm waves-effect">
								<b><span>TAMBAH DATA</span></b>
							</button> -->
						</div>
					</div>
				</div>
			</div>
			<!-- #END# Exportable Table -->
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
	status = '';
	$(document).ready(function() {
		$(".box-form").hide();
		load_data();

		$("input.angka").keypress(function(event) { //input text number only
			return /\d/.test(String.fromCharCode(event.keyCode));
		});
	});

	function aK(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		// alert(charCode);
		if (charCode > 31 && (charCode < 46 || charCode > 57))
			return false;
		return true;
	}

	$(".btn-add").click(function() {
		status = 'insert';
		kosong();
		getThnBlnRoll();
		// getIRpk();
		// loadRollRpkBaru();
		loadJnmKer();
		$(".box-data").hide();
		$(".new_roll").show();
		$(".box-form").show();
	});

	$(".btn-kembali").click(function() {
		$(".box-form").hide();
		$(".box-data").show();
		load_data();
	});

	function loadJnmKer(){
		// alert(pm);
		$(".box-load-nmker").html('MEMUAT JENIS KERTAS ...');
		$(".box-load-rpk").html('');
		$.ajax({
			url: '<?php echo base_url('Master/loadJnmKer')?>',
			type: "POST",
			success: function(res){
				$(".box-load-nmker").html(res);
			}
		})
	}

	function loadRollRpkBaru(pm = '',nmker){
		$(".box-load-rpk").html('');
		$("#box-data-id-rpk").val("");
		$.ajax({
			url: '<?php echo base_url("Master/loadRollRpkBaru")?>',
			type: "POST",
			data: ({
				pm,nmker
			}),
			success: function(res){
				data = JSON.parse(res);
				$("#box-data-id-rpk").val(data.data);
				$("#box-data-idx").val(data.ll);
				getIRpk(data.kd_pm,nmker);
			}
		});
	}

	function getIRpk(kd_pm,nmker){
		id_rpk = $("#box-data-id-rpk").val();
		i = $("#box-data-idx").val();
		$(".box-load-rpk").html('MEMUAT RPK...');
		$.ajax({
			url: '<?php echo base_url("Master/getIRpk")?>',
			type: "POST",
			data: ({
				kd_pm,nmker
			}),
			success: function(res){
				$(".box-load-rpk").html(res);
				btnDetailRpk(i,id_rpk);
			}
		});
	}

	function btnDetailRpk(i,id_rpk){
		$(".btn-all").removeClass("btn-pilih").addClass("btn-tdk");
		$(".btn-rpk-"+i).removeClass("btn-tdk").addClass("btn-pilih");
		kosong();
		$(".clr-trpk").html('');
		$(".clr-gdng").html('');
		$(".dtl-list-trpk-"+i).html('Loading...');
		$.ajax({
			url: '<?php echo base_url("Master/btnDetailRpk")?>',
			type: "POST",
			data: ({
				i,id_rpk,timbangan: 'timbangan'
			}),
			success: function(res){
				$(".dtl-list-trpk-"+i).html(res);
			}
		})
	}

	function plhUkRpk(i,idx,id_rpk,nm_ker,g_label,width,www,i_rpk){
		$.ajax({
			url: '<?php echo base_url("Master/plhUkRpk")?>',
			type: "POST",
			data: ({
				idx,id_rpk,nm_ker,g_label,width,www,i_rpk
			}),
			success: function(res){
				data = JSON.parse(res);
				if(data.data == true){
					$(".clr-tt").removeClass("plh-tt").addClass("not-tt");
					$(".dtl-t-rpk-"+idx+'-'+www).removeClass("not-tt").addClass("plh-tt");
					$("#nm_ker").val(nm_ker);
					$("#g_label").val(g_label);
					$("#width").val(width);
					$("#id_rpk").val(idx);
					$("#i_rpk").val(i_rpk);
				}else{
					swal("LIST INI SUDAH DI CLOSE!! HUB. QC", "", "error");
					btnDetailRpk(i,id_rpk);
				}
			}
		});
	}

	function btnAksiListRpk(i,idx,id_rpk,stat){
		$.ajax({
			url: '<?php echo base_url("Master/btnAksiListRpk")?>',
			type: "POST",
			data: ({
				i,idx,id_rpk,stat
			}),
			success: function(res){
				data = JSON.parse(res);
				swal(data.msg, "", "success");
				btnDetailRpk(i,id_rpk);
			}
		});
	}

	function CekListGdNg(i,idx,id_rpk,stat,width=""){
		// alert(i+' - '+idx+' - '+id_rpk+' - '+stat+' - '+width);
		$(".tdllgg").removeClass("bg-iya").addClass("bg-tdk");
		$(".td-gdng-"+idx+"-"+stat).removeClass("bg-tdk").addClass("bg-iya");
		$(".list-gd-ng-"+i).html('<div style="margin-bottom:5px">Loading...</div>');
		$.ajax({
			url: '<?php echo base_url("Master/CekListGdNg")?>',
			type: "POST",
			data: ({
				i,idx,id_rpk,stat,width,timbangan: 'timbangan'
			}),
			success: function(res){
				$(".list-gd-ng-"+i).html(res);
			}
		});
	}

	function xclgd(i){
		$(".list-gd-ng-"+i).html("");
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

	function hanyaPm(evt) {
		let charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode == 49 || charCode == 50 || charCode == 97 || charCode == 98) {
			return true;
		}
		return false;
	}

	function hanyaBln(evt) {
		let charCode = (evt.which) ? evt.which : event.keyCode
		// alert(charCode) // 97 - 108, 65 -  76
		if (charCode == 65 || charCode == 66 || charCode == 67 || charCode == 68 || charCode == 69 || charCode == 70 || charCode == 71 || charCode == 72 || charCode == 73 || charCode == 74 || charCode == 75 || charCode == 76 || charCode == 97 || charCode == 98 || charCode == 99 || charCode == 100 || charCode == 101 || charCode == 102 || charCode == 103 || charCode == 104 || charCode == 105 || charCode == 106 || charCode == 107 || charCode == 108) {
			return true;
		}
		return false;
	}

	function hanyaHuruf(evt) {
		let charCode = (evt.which) ? evt.which : event.keyCode
		if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode > 32) {
			return false;
		}
		return true;
	}

	$("#id2bln").on({
		keydown: function(e) {
			if (e.which === 32)
				return false;
		},
		keyup: function() {
			this.value = this.value.toUpperCase();
		},
		change: function() {
			this.value = this.value.replace(/\s/g, "");
		}
	});

	$("#id4kode").on({
		keydown: function(e) {
			if (e.which === 32)
				return false;
		},
		keyup: function() {
			this.value = this.value.toUpperCase();
		},
		change: function() {
			this.value = this.value.replace(/\s/g, "");
		}
	});

	function reloadTable() {
		table = $('#datatable11').DataTable();
		tabel.ajax.reload(null, false);
	}

	function load_data() {
		var table = $('#datatable11').DataTable();
		table.destroy();
		tabel = $('#datatable11').DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Master/load_data', // 183
				"data": ({
					jenis: "Timbangan"
				}),
				"type": "POST"
			},
			responsive: true,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			},
			"order": [
				[0, "desc"]
			]
		});
	}

	function simpan() {
		// BUAT CEK ROLL
		kodepm = $("#id1kode").val();
		xroll = $("#id11").val();
		xth = $("#id22").val();
		xbln = $("#id2bln").val();
		xno = $("#id44").val();
		xkode = $("#id4kode").val();

		roll = kodepm + "/" + $("#id11").val() + "/" + $("#id22").val() + $("#id2bln").val() + "/" + $("#id44").val() + $("#id4kode").val();

		tgl = $("#tgl").val();
		nm_ker = $("#nm_ker").val();
		g_label = $("#g_label").val();
		width = $("#width").val();
		weight = $("#weight").val();
		diameter = $("#diameter").val();
		joint = $("#joint").val();
		cstatus = $("#cek_status").val();
		ket = $("textarea#ket").val();

		// get data lama
		ltgl = $("#l-tgl").val();
		lnm_ker = $("#l-nm_ker").val();
		lg_label = $("#l-g_label").val();
		lwidth = $("#l-width").val();
		lweight = $("#l-weight").val();
		ldiameter = $("#l-diameter").val();
		ljoint = $("#l-joint").val();
		lket = $("#l-ket").val();
		lstatus = $("#l-status").val();
		getid = $("#getid").val();
		id_rpk = $("#id_rpk").val();
		i_rpk = $("#i_rpk").val();
		// alert(lnm_ker+' - '+lg_label+' - '+lwidth+' - '+lweight+' - '+ldiameter+' - '+ljoint+' - '+lket+' - '+lstatus+' - '+getid);

		if (kodepm == "" || $("#id11").val() == "" || $("#id22").val() == "" || $("#id2bln").val() == "" || $("#id44").val() == "" || $("#id4kode").val() == "") {
			showNotification("alert-info", "HARAP ISI NOMER ROLL LENGKAP", "bottom", "center", "", "");
			return;
		}
		if (tgl == "" || nm_ker == "" || g_label == "" || width == "" || diameter == "" || joint == "" || id_rpk == "" || i_rpk == "") {
			showNotification("alert-info", "HARAP LENGKAPI FORM", "bottom", "center", "", "");
			return;
		}

		nr = $("#id11").val().length;
		if(nr < 5){
			showNotification("alert-info", "NOMER ROLL HARUS LENGKAP LIMA DIGIT", "bottom", "center", "", "");
			return;
		}

		$("#btn-simpan").prop("disabled", true);
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>Master/' + status, // 62
			data: ({
				id: roll,
				tgl: tgl,
				nm_ker: nm_ker,
				g_ac: 0,
				g_label: g_label,
				width: width,
				weight: weight,
				diameter: diameter,
				joint: joint,
				ket: ket,
				rct: 0,
				bi: 0,
				id_rpk,
				i_rpk,
				cstatus: 1,
				ltgl: ltgl,
				lnm_ker: lnm_ker,
				lg_label: lg_label,
				lwidth: lwidth,
				lweight: lweight,
				ldiameter: ldiameter,
				ljoint: ljoint,
				lket: lket,
				lstatus: lstatus,
				getid: getid,
				kodepm: kodepm,
				xroll: xroll,
				xth: xth,
				xbln: xbln,
				xno: xno,
				xkode: xkode,
				jenis: "Timbangan"
			}),
			dataType: "json",
			success: function(data) {
				$("#btn-simpan").prop("disabled", false);
				if (data.data == true) {
					swal("BERHASIL", "", "success");
					if(status == 'insert'){
						status = 'insert';
						kosong();
						loadRollRpkBaru('',nm_ker);
					}else{
						status = 'update';
						$("#txt-btn-simpan").html("UPDATE");
						tampil_edit(data.getid);
					}
				} else {
					swal(data.msg, "", "error");
					status = 'insert';
				}
			}
		});
	}

	function tampil_edit(id) {
		$("#getid").val(id);
		
		$.ajax({
			url: '<?php echo base_url('Master/get_edit'); ?>', // 1030
			type: 'POST',
			data: {
				id: id,
				jenis: "Timbangan"
			},
		})
		.done(function(data) {
			json = JSON.parse(data);

			if(json.status == 0 || json.status == 2 || json.status == 3){
				$(".box-data").show();
				$(".box-form").hide();
				swal("ROLL SUDAH DICEK OK!, TIDAL BISA EDIT DATA ROLL, HARAP HUB. QC", "", "error");
				load_data();
			}else if(json.ctk == 1){
				$(".box-data").show();
				$(".box-form").hide();
				swal("ROLL SUDAH DICETAK, TIDAL BISA EDIT DATA ROLL, HARAP HUB. QC", "", "error");
				load_data();
			}else{
				$(".box-load-rpk").html('');
				$(".box-data").hide();
				$(".box-form").show();
				$(".new_roll").show();
				status = "update";

				a = json.roll.split("/");
				textthnbln = a[2].toString();
				athn = textthnbln.substr(0, 2);
				abln = textthnbln.substr(2, 1);
				textsetr = a[3].toString();
				anka = textsetr.substr(0, 1);
				ankod = textsetr.substr(1, 1);

				$("#id1kode").val(a[0]);
				$("#id11").val(a[1]).prop("disabled", true).attr('style', 'background:#e9e9e9;text-align:center');
				$("#id22").val(athn).prop("disabled", true).attr('style', 'background:#e9e9e9;text-align:center');
				$("#id2bln").val(abln).prop("disabled", true).attr('style', 'background:#e9e9e9;text-align:center');
				$("#id44").val(anka).prop("disabled", true).attr('style', 'background:#e9e9e9;text-align:center');
				$("#id4kode").val(ankod).prop("disabled", true).attr('style', 'background:#e9e9e9;text-align:center');

				$("#tgl").val(json.tgl);
				$("#nm_ker").val(json.nm_ker);
				$("#g_ac").val(json.g_ac);
				$("#g_label").val(json.g_label);
				$("#width").val(json.width);
				$("#weight").val(json.weight);
				$("#diameter").val(json.diameter);
				$("#joint").val(json.joint);
				$("#rct").val(json.rct);
				$("#bi").val(json.bi);
				$("#cek_status").val(json.status);
				$("textarea#ket").val(json.ket);
				$("#id_rpk").val(json.id_rpk);
				$("#i_rpk").val(json.i_rpk);

				// cocok data lama
				$("#l-tgl").val(json.tgl);
				$("#l-nm_ker").val(json.nm_ker);
				$("#l-g_label").val(json.g_label);
				$("#l-width").val(json.width);
				$("#l-weight").val(json.weight);
				$("#l-diameter").val(json.diameter);
				$("#l-joint").val(json.joint);
				$("#l-ket").val(json.ket);
				$("#l-status").val(json.status);
			}
		});
	}

	function deleteData(id, nm) { //
		swal({
				title: "Apakah Anda Yakin ?",
				text: nm,
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Ya",
				cancelButtonText: "Batal",
				closeOnConfirm: false,
				closeOnCancel: false
			},
			function(isConfirm) {
				if (isConfirm) {
					$.ajax({
						url: '<?php echo base_url(); ?>Master/hapus/',
						type: "POST",
						data: {
							id: id,
							jenis: "Timbangan"
						},
						success: function(data) {
							if (data == 1) {
								swal("BERHASIL!", "", "success");
								load_data();
							} else {
								swal("ROLL SUDAH DICEK/DICETAK, TIDAL BISA HAPUS DATA ROLL, HARAP HUB. QC", "", "error");
							}
						}
					});
				} else {
					swal("DATA BATAL DIHAPUS", "", "error");
				}
			});
	}

	function kosong() {
		$(".new_roll").show();

		status = "insert";

		$("#id1").prop("disabled", false);
		$("#id2").prop("disabled", false);
		$("#id3").prop("disabled", false);
		$("#id4").prop("disabled", false);

		$("#id1kode").prop("disabled", true).attr('style', 'background:#e9e9e9;text-align:center');
		$("#tgl").val("");
		$("#id1").val("");
		$("#id2").val("");
		$("#id3").val("");
		$("#id4").val("");
		$("#id11").val("").prop("disabled", false).attr('style', 'background:#fff;text-align:center');
		$("#id22").val("").prop("disabled", false).attr('style', 'background:#fff;text-align:center');
		$("#id44").val("").prop("disabled", false).attr('style', 'background:#fff;text-align:center');
		$("#id2bln").val("").prop("disabled", false).attr('style', 'background:#fff;text-align:center');
		$("#id4kode").val("").prop("disabled", false).attr('style', 'background:#fff;text-align:center');
		$("#nm_ker").val("");
		$("#g_ac").val("");
		$("#g_label").val("");
		$("#width").val("");
		$("#weight").val("");
		$("#diameter").val("");
		$("#joint").val("");
		$("#rct").val("");
		$("#bi").val("");
		$("#cek_status").val("");
		$("#ket").val("");

		$("#id_rpk").val("");
		$("#i_rpk").val("");
		$("#getid").val("");
		$("#l-tgl").val("");
		$("#l-nm_ker").val("");
		$("#l-g_label").val("");
		$("#l-width").val("");
		$("#l-weight").val("");
		$("#l-diameter").val("");
		$("#l-joint").val("");
		$("#l-ket").val("");
		$("#l-status").val("");

		getThnBlnRoll();

		$("#txt-btn-simpan").html("SIMPAN");
	}

	function getThnBlnRoll() {
		let num = new Date().getFullYear();
		let text = num.toString();
		let tahun = text.substr(2, 2);

		let bulan;
		switch (new Date().getMonth()) {
			case 0:
				bulan = "A";
				break;
			case 1:
				bulan = "B";
				break;
			case 2:
				bulan = "C";
				break;
			case 3:
				bulan = "D";
				break;
			case 4:
				bulan = "E";
				break;
			case 5:
				bulan = "F";
				break;
			case 6:
				bulan = "G";
				break;
			case 7:
				bulan = "H";
				break;
			case 8:
				bulan = "I";
				break;
			case 9:
				bulan = "J";
				break;
			case 10:
				bulan = "K";
				break;
			case 11:
				bulan = "L";
				break;
			default:
				bulan = "";
		}

		$("#id22").val(tahun);
		$("#id2bln").val(bulan);
	}
</script>
