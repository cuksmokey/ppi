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
											<!-- <i class="material-icons">library_add</i> -->
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
											<!-- <th>Gramage Label</th> -->
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
						<div class="box-form">
							<div id="judul"></div>
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
										<div class="old_roll">
											<table>
												<tr>
													<td><input type="text" id="id1" class="angka form-control" maxlength="5" autocomplete="off"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" id="id2" class="angka form-control" maxlength="2" autocomplete="off"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" id="id3" class="angka form-control" maxlength="1" autocomplete="off"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" id="id4" class="form-control" maxlength="1" autocomplete="off"></td>
												</tr>
											</table>
										</div>
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
											<input type="hidden" id="getid" value="">
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
													<td><input type="text" style="text-align:center" id="id1kode" class="form-control" maxlength="1" autocomplete="off" placeholder="PM" tabindex="1" onkeypress="return hanyaPm(event)" value="<?php echo $kodePm; ?>" <?php echo $dkodepm; ?>></td>
													<td style="padding: 0 5px">/</td>
													<td><input type="text" style="text-align:center" id="id11" class="angka form-control" maxlength="5" autocomplete="off" placeholder="NOMOR ROLL" tabindex="2"></td>
													<td style="padding: 0 5px">/</td>
													<td><input type="text" style="text-align:center" id="id22" class="angka form-control" maxlength="2" autocomplete="off" placeholder="TAHUN"></td>
													<td><input type="text" style="text-align:center" id="id2bln" class="form-control" maxlength="1" autocomplete="off" placeholder="BULAN" onkeypress="return hanyaBln(event)"></td>
													<td style="padding: 0 5px">/</td>
													<td><input type="text" style="text-align:center" id="id44" class="angka form-control" maxlength="1" autocomplete="off" placeholder="0" tabindex="3"></td>
													<td><input type="text" style="text-align:center" id="id4kode" class="form-control" maxlength="1" autocomplete="off" placeholder="F/M/B" tabindex="4" onkeypress="return hanyaHuruf(event)"></td>
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
										<select id="nm_ker" class="form-control">
											<option value="">PILIH</option>
											<option value="WP">WP</option>
											<option value="MH">MH</option>
											<!-- <option value="MI">MI</option> -->
											<!-- <option value="TL">TL</option> -->
											<option value="BK">BK</option>
											<!-- <option value="BL">BL</option> -->
											<option value="MN">MN</option>
											<!-- <option value="ML">ML</option> -->
											<option value="MH COLOR">MH COLOR</option>
										</select>
										<!-- <input type="text" class="form-control" id="nm_ker"> -->
									</td>
								</tr>
								<!-- <tr>
									<td>Grammage Actual</td>
									<td style="padding:0 5px">:</td>
									<td><input type="text" class="form-control" id="g_ac" placeholder="0" autocomplete="off"></td>
									<td><input type="text" disabled="true" class="form-control" value="GSM" style="width: 30%;border: none"></td>
								</tr> -->
								<tr>
									<td style="padding:3px 0;font-weight:bold">GRAMATURE</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0">
										<select id="g_label" class="form-control">
											<option value="">PILIH</option>
											<!-- <option value="67">67</option> -->
											<option value="68">68</option>
											<option value="70">70</option>
											<option value="105">105</option>
											<option value="110">110</option>
											<option value="125">125</option>
											<option value="120">120</option>
											<option value="140">140</option>
											<option value="150">150</option>
											<option value="200">200</option>
										</select>
									</td>
									<td style="padding:3px 5px">
										GSM
										<!-- <input type="text" disabled="true" class="form-control" value="GSM" style="width: 30%;border: none"> -->
									</td>
								</tr>
								<tr>
									<td style="padding:3px 0;font-weight:bold">UKURAN</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0">
										<input type="text" class="angka form-control" placeholder="0" id="width" maxlength="5" autocomplete="off">
									</td>
									<td style="padding:3px 5px">
										CM
										<!-- <input type="text" disabled="true" class=" form-control" value="CM" style="width: 30%;border: none"> -->
									</td>
								</tr>
								<tr>
									<td style="padding:3px 0;font-weight:bold">DIAMATER</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0">
										<input type="text" class="angka form-control" placeholder="0" id="diameter" maxlength="5" autocomplete="off">
									</td>
									<td style="padding:3px 5px">
										CM
										<!-- <input type="text" disabled="true" class="form-control" value="CM" style="width: 30%;border: none"> -->
									</td>
								</tr>
								<tr>
									<td style="padding:3px 0;font-weight:bold">BERAT</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0">
										<input type="text" class="angka form-control" placeholder="0" id="weight" maxlength="5" autocomplete="off">
									</td>
									<td style="padding:3px 5px">
										KG
										<!-- <input type="text" disabled="true" class="form-control" value="KG" style="width: 30%;border: none"> -->
									</td>
								</tr>
								<!-- <tr>
									<td>RCT</td>
									<td style="padding:0 5px">:</td>
									<td>
										<input type="text" class="form-control" placeholder="0" id="rct" autocomplete="off">
									</td>
									<td>
										<input type="text" disabled="true" class="form-control" value="KGF" style="width: 30%;border: none">
									</td>
								</tr>
								<tr>
									<td>BI</td>
									<td style="padding:0 5px">:</td>
									<td>
										<input type="text" class="form-control" placeholder="0" id="bi" autocomplete="off">
									</td>
									<td>
										<input type="text" disabled="true" class="form-control" value="KPA.m2/G" style="width: 30%;border: none">
									</td>
								</tr> -->
								<tr>
									<td style="padding:3px 0;font-weight:bold">JOINT</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0">
										<input type="text" class="angka form-control" placeholder="0" id="joint" maxlength="3" autocomplete="off">
									</td>
								</tr>
								<tr>
									<td style="padding:3px 0;font-weight:bold">STATUS</td>
									<td style="padding:3px 5px">:</td>
									<td style="padding:3px 0">
										<select id="cek_status" class="form-control">
											<option value="">PILIH</option>
											<option value="0">STOCK</option>
											<option value="2">PPI</option>
											<option value="3">BUFFER</option>
										</select>
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

							<!-- <button type="button" class="btn-kembali btn btn-dark btn-sm waves-effect waves-circle waves-float"> -->
							<button type="button" class="btn-kembali btn btn-dark btn-default btn-sm waves-effect">
								<!-- <i class="material-icons">arrow_back</i> -->
								<b><span>BACK</span></b>
							</button> &nbsp;&nbsp;
							<button onclick="simpan()" id="btn-simpan" type="button" class="btn bg-light-green btn-sm waves-effect">
								<!-- <i class="material-icons">save</i> -->
								<b><span id="txt-btn-simpan">SIMPAN</span></b>
							</button> &nbsp;&nbsp;
							<button onclick="kosong()" type="button" class="btn btn-default btn-sm waves-effect">
								<!-- <i class="material-icons">note_add</i> -->
								<b><span>TAMBAH DATA</span></b>
							</button>
							<a type="button" id="btn-print" target="_blank" class="btn btn-default btn-sm waves-effect waves-float pull-right" style="display: none">
								<b><span>LABEL BESAR</span></b>
							</a> 
							<a type="button" id="btn-print-kcl" target="_blank" class="btn btn-default btn-sm waves-effect waves-float pull-right" style="display: none">
								<b><span>LABEL KECIL</span></b> 
							</a>
						</div>
					</div>
				</div>
			</div>
			<!-- #END# Exportable Table -->
		</div>
	</div>
</section>

<script>
	status = '';
	$(document).ready(function() {
		$(".box-form").hide();
		load_data();

		$("input.angka").keypress(function(event) { //input text number only
			return /\d/.test(String.fromCharCode(event.keyCode));
		});
	});

	$(".btn-add").click(function() {
		status = 'insert';
		kosong();
		getThnBlnRoll();
		// getmax();
		$(".box-data").hide();
		$(".old_roll").hide();
		$(".new_roll").show();
		$(".box-form").show();
		$("#judul").html('<h3>FORM TAMBAH DATA</h3>');
		// $('.box-form').animateCss('fadeInDown');
	});

	$(".btn-kembali").click(function() {
		$(".box-form").hide();
		$(".box-data").show();
		// $('.box-data').animateCss('fadeIn');
		load_data();
	});

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
		xno = $("#id44").val();
		xkode = $("#id4kode").val();

		if (kodepm == '' || kodepm == null) {
			roll = $("#id1").val() + "/" + $("#id2").val() + "/" + $("#id3").val() + "/" + $("#id4").val();
		} else {
			roll = kodepm + "/" + $("#id11").val() + "/" + $("#id22").val() + $("#id2bln").val() + "/" + $("#id44").val() + $("#id4kode").val();
		}

		tgl = $("#tgl").val();
		nm_ker = $("#nm_ker").val();
		// g_ac = $("#g_ac").val();
		g_label = $("#g_label").val();
		width = $("#width").val();
		weight = $("#weight").val();
		diameter = $("#diameter").val();
		joint = $("#joint").val();
		// rct = $("#rct").val();
		// bi = $("#bi").val();
		cstatus = $("#cek_status").val();
		ket = $("textarea#ket").val();

		// get data lama
		lnm_ker = $("#l-nm_ker").val();
		lg_label = $("#l-g_label").val();
		lwidth = $("#l-width").val();
		lweight = $("#l-weight").val();
		ldiameter = $("#l-diameter").val();
		ljoint = $("#l-joint").val();
		lket = $("#l-ket").val();
		lstatus = $("#l-status").val();
		getid = $("#getid").val();
		// alert(lnm_ker+' - '+lg_label+' - '+lwidth+' - '+lweight+' - '+ldiameter+' - '+ljoint+' - '+lket+' - '+lstatus+' - '+getid);

		if (kodepm == '' || kodepm == null) {
			if ($("#id1").val() == "" || $("#id2").val() == "" || $("#id3").val() == "" || $("#id4").val() == "") {
				showNotification("alert-info", "HARAP ISI NOMER ROLL LENGKAP", "bottom", "center", "", "");
				return;
			}
		} else {
			if (kodepm == "" || $("#id11").val() == "" || $("#id22").val() == "" || $("#id2bln").val() == "" || $("#id44").val() == "" || $("#id4kode").val() == "") {
				showNotification("alert-info", "HARAP ISI NOMER ROLL LENGKAP", "bottom", "center", "", "");
				return;
			}
		}

		if (nm_ker == "" || g_label == "" || width == "" || diameter == "" || joint == "") {
			showNotification("alert-info", "HARAP LENGKAPI FORM", "bottom", "center", "", "");
			return;
		}

		nr = $("#id11").val().length;
		if(nr < 5){
			showNotification("alert-info", "NOMER ROLL HARUS LENGKAP LIMA DIGIT", "bottom", "center", "", "");
			return;
		}

		if (cstatus == "") {
			showNotification("alert-info", "HARAP PILIH STATUS ROLL", "bottom", "center", "", "");
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
				cstatus: cstatus,
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
				xno: xno,
				xkode: xkode,
				jenis: "Timbangan"
			}),
			dataType: "json",
			success: function(data) {
				$("#btn-simpan").prop("disabled", false);
				if (data.data == true) {
					// showNotification("alert-success", "BERHASIL", "bottom", "center", "", "");
					swal("BERHASIL", "", "success");
					// $("#btn-print").attr("href", "<?php echo base_url('Master/print_timbangan?id=')?>" + roll);
					// $("#btn-print").show();
					// $("#btn-print-kcl").attr("href", "<?php echo base_url('Master/print_timbangan2?id=')?>" + roll);
					// $("#btn-print-kcl").show();
					status = 'update';
					$("#txt-btn-simpan").html("UPDATE");
					// alert(data.getid);
					tampil_edit(data.getid);
				} else {
					// showNotification("alert-danger", data.msg, "bottom", "center", "", "");
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

				if(json.ctk == 1){
					$(".box-data").show();
					$(".box-form").hide();
					swal("ROLL SUDAH DICETAK, TIDAL BISA EDIT DATA ROLL, HARAP HUB. QC", "", "error");
					load_data();
				}
				// else if(json.status != 0 && json.id_pl != 0){
				// 	$(".box-data").show();
				// 	$(".box-form").hide();
				// 	swal("DATA SUDAH TERJUAL!!!", "", "error");
				// 	load_data();
				// }
				else{
					$(".box-data").hide();
					$(".box-form").show();
					$(".new_roll").hide();
					$(".old_roll").hide();
					$("#judul").html('<h3>FORM EDIT DATA</h3>');
					status = "update";
					if(json.ctk == 0){	
						$("#btn-print").attr("href", "<?php echo base_url('Master/print_timbangan?id=')  ?>" + json.roll);
						$("#btn-print").show();
						$("#btn-print-kcl").attr("href", "<?php echo base_url('Master/print_timbangan2?id=')  ?>" + json.roll);
						$("#btn-print-kcl").show();
					}

					a = json.roll.split("/");

					$("#id1").prop("disabled", true);
					$("#id2").prop("disabled", true);
					$("#id3").prop("disabled", true);
					$("#id4").prop("disabled", true);

					if (json.pm == '' || json.pm == null) {
						$(".old_roll").show();
						$(".new_roll").hide();

						$("#id1").val(a[0]);
						$("#id2").val(a[1]);
						$("#id3").val(a[2]);
						$("#id4").val(a[3]);
					} else {
						$(".old_roll").hide();
						$(".new_roll").show();

						textthnbln = a[2].toString();
						athn = textthnbln.substr(0, 2);
						abln = textthnbln.substr(2, 1);

						textsetr = a[3].toString();
						anka = textsetr.substr(0, 1);
						ankod = textsetr.substr(1, 1);

						// $("#id1kode").val(a[0]).prop("disabled", true);
						$("#id1kode").val(a[0]);
						$("#id11").val(a[1]).prop("disabled", true);
						$("#id22").val(athn).prop("disabled", true);
						$("#id2bln").val(abln).prop("disabled", true);
						$("#id44").val(anka).prop("disabled", true);
						$("#id4kode").val(ankod).prop("disabled", true);
					}

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

					// cocok data lama
					$("#l-nm_ker").val(json.nm_ker);
					$("#l-g_label").val(json.g_label);
					$("#l-width").val(json.width);
					$("#l-weight").val(json.weight);
					$("#l-diameter").val(json.diameter);
					$("#l-joint").val(json.joint);
					$("#l-ket").val(json.ket);
					$("#l-status").val(json.status);
				}
			})
	}

	function deleteData(id, nm) {
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
								// reloadTable();
								load_data();
							} else {
								swal("ROLL SUDAH DICETAK, TIDAL BISA HAPUS DATA ROLL, HARAP HUB. QC", "", "error");
							}
						}
					});
				} else {
					swal("", "DATA BATAL DIHAPUS", "error");
				}
			});
	}

	function kosong() {
		$("#judul").html('<h3>FORM TAMBAH DATA</h3>');
		$("#btn-print").hide();
		$("#btn-print-kcl").hide();
		$(".old_roll").hide();
		$(".new_roll").show();

		status = "insert";

		// $("#acc").prop("disabled",false);

		$("#id1").prop("disabled", false);
		$("#id2").prop("disabled", false);
		$("#id3").prop("disabled", false);
		$("#id4").prop("disabled", false);

		$("#tgl").val("");
		$("#id1").val("");
		$("#id2").val("");
		$("#id3").val("");
		$("#id4").val("");
		$("#id11").val("").prop("disabled", false);
		$("#id22").val("").prop("disabled", false);
		$("#id44").val("").prop("disabled", false);
		$("#id2bln").val("").prop("disabled", false);
		// $("#id1kode").val("").prop("disabled", false);
		// $("#id1kode").val("");
		$("#id4kode").val("").prop("disabled", false);
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

		$("#getid").val("");
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
