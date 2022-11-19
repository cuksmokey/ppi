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
							<table id="datatable11" class="table table-bordered table-striped table-hover dataTable ">
								<thead>
									<tr>
										<th>Roll Number</th>
										<th>Tanggal</th>
										<th>Nama Ker</th>
										<th>Gramage Label</th>
										<th>Gramage (GSM)</th>
										<th>Width (CM)</th>
										<th>Diameter (CM)</th>
										<th>Weight (KG)</th>
										<th>Joint</th>
										<th>Keterangan</th>
										<th width="15%">Aksi</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>

						<!-- box form -->
						<div class="box-form">
							<div id="judul"></div>
							<table style="width:100%">
								<tr>
									<td style="width:13%"></td>
									<td style="width:auto"></td>
									<td style="width:auto"></td>
									<td style="width:auto"></td>
								</tr>
								<tr>
									<td>Roll Number</td>
									<td style="padding:0 5px">:</td>
									<td colspan="2">
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
											<table>
												<tr>
													<td><input type="text" style="text-align:center" id="id1kode" class="angka form-control" maxlength="1" autocomplete="off" placeholder="PM" tabindex="1" onkeypress="return hanyaPm(event)"></td>
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
									<td>Tanggal</td>
									<td style="padding:0 5px">:</td>
									<td colspan="2">
										<input type="date" id="tgl" value="<?php echo date('Y-m-d') ?>" class="form-control" style="width: 40%">
									</td>
								</tr>
								<tr>
									<td>Nama Kertas</td>
									<td style="padding:0 5px">:</td>
									<td colspan="2">
										<select id="nm_ker" class="form-control" style="width:40%">
											<option value="">Pilih</option>
											<option value="WP">WP</option>
											<option value="MH">MH</option>
											<option value="MI">MI</option>
											<option value="TL">TL</option>
											<option value="BK">BK</option>
											<option value="BL">BL</option>
											<option value="MN">MN</option>
											<option value="ML">ML</option>
											<option value="MH COLOR">MH COLOR</option>
										</select>
										<!-- <input type="text" class="form-control" id="nm_ker"> -->
									</td>
								</tr>
								<tr>
									<td>Grammage Actual</td>
									<td style="padding:0 5px">:</td>
									<td><input type="text" class="form-control" id="g_ac" placeholder="0" autocomplete="off"></td>
									<td><input type="text" disabled="true" class="form-control" value="GSM" style="width: 30%;border: none"></td>
								</tr>
								<tr>
									<td>Grammage Label</td>
									<td style="padding:0 5px">:</td>
									<td>
										<select id="g_label" class="form-control">
											<option value="">Pilih</option>
											<option value="67">67</option>
											<option value="68">68</option>
											<option value="70">70</option>
											<option value="105">105</option>
											<option value="110">110</option>
											<option value="125">125</option>
											<option value="140">140</option>
											<option value="150">150</option>
											<option value="200">200</option>
										</select>
									</td>
									<td>
										<input type="text" disabled="true" class="form-control" value="GSM" style="width: 30%;border: none">
									</td>
								</tr>
								<tr>
									<td>Width</td>
									<td style="padding:0 5px">:</td>
									<td>
										<input type="text" class="form-control" placeholder="0" id="width" autocomplete="off">
									</td>
									<td>
										<input type="text" disabled="true" class=" form-control" value="CM" style="width: 30%;border: none">
									</td>
								</tr>
								<tr>
									<td>Weight</td>
									<td style="padding:0 5px">:</td>
									<td>
										<input type="text" class="form-control" placeholder="0" id="weight" autocomplete="off">
									</td>
									<td>
										<input type="text" disabled="true" class="form-control" value="KG" style="width: 30%;border: none">
									</td>
								</tr>
								<tr>
									<td>Diamater</td>
									<td style="padding:0 5px">:</td>
									<td>
										<input type="text" class="form-control" placeholder="0" id="diameter" autocomplete="off">
									</td>
									<td>
										<input type="text" disabled="true" class="form-control" value="CM" style="width: 30%;border: none">
									</td>
								</tr>
								<tr>
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
								</tr>
								<tr>
									<td>Joint</td>
									<td style="padding:0 5px">:</td>
									<td colspan="2">
										<input type="text" class="form-control" placeholder="0" id="joint" autocomplete="off">
									</td>
								</tr>
								<tr>
									<td>Status</td>
									<td style="padding:0 5px">:</td>
									<td>
										<select id="cek_status" class="form-control">
											<option value="">Pilih</option>
											<option value="0">STOCK</option>
											<option value="2">PPI</option>
											<option value="3">BUFFER</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td style="padding:0 5px">:</td>
									<td colspan="2">
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
							<a type="button" id="btn-print" target="blank" class="btn btn-default btn-sm waves-effect waves-float pull-right" style="display: none">
								<b><span>LABEL BESAR</span></b>
							</a> 
							<a type="button" id="btn-print-kcl" target="blank" class="btn btn-default btn-sm waves-effect waves-float pull-right" style="display: none">
								<b><span>LABEL KECIL</span></b>
							</a>
						</div>
					</div>
				</div>
			</div>
			<!-- #END# Exportable Table -->
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
		$("#judul").html('<h3> Form Tambah Data</h3>');
		$('.box-form').animateCss('fadeInDown');
	});

	$(".btn-kembali").click(function() {
		$(".box-form").hide();
		$(".box-data").show();
		$('.box-data').animateCss('fadeIn');
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
				[2, "asc"]
			]
		});
	}

	function simpan() {
		kodepm = $("#id1kode").val();
		kodebln = $("#id2bln").val();
		koderew = $("#id4kode").val();

		if (kodepm == '' || kodepm == null) {
			roll = $("#id1").val() + "/" + $("#id2").val() + "/" + $("#id3").val() + "/" + $("#id4").val();
		} else {
			roll = kodepm + "/" + $("#id11").val() + "/" + $("#id22").val() + $("#id2bln").val() + "/" + $("#id44").val() + $("#id4kode").val();
		}

		tgl = $("#tgl").val();
		nm_ker = $("#nm_ker").val();
		g_ac = $("#g_ac").val();
		g_label = $("#g_label").val();
		width = $("#width").val();
		weight = $("#weight").val();
		diameter = $("#diameter").val();
		joint = $("#joint").val();
		rct = $("#rct").val();
		bi = $("#bi").val();
		cstatus = $("#cek_status").val();
		ket = $("textarea#ket").val();

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

		if (nm_ker == "" || g_ac == "" || g_label == "" || width == "" || diameter == "" || joint == "" || rct == "" || bi == "") {
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
		// alert(nr);
		// cek_status

		$("#btn-simpan").prop("disabled", true);
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>Master/' + status, // 62
			data: ({
				id: roll,
				kodepm: kodepm,
				tgl: tgl,
				nm_ker: nm_ker,
				g_ac: g_ac,
				g_label: g_label,
				width: width,
				weight: weight,
				diameter: diameter,
				joint: joint,
				ket: ket,
				rct: rct,
				bi: bi,
				cstatus: cstatus,
				jenis: "Timbangan"
			}),
			dataType: "json",
			success: function(data) {
				$("#btn-simpan").prop("disabled", false);
				if (data.data == true) {
					// reloadTable();
					showNotification("alert-success", "Berhasil", "bottom", "center", "", "");
					$("#btn-print").attr("href", "<?php echo base_url('Master/print_timbangan?id=')?>" + roll);
					$("#btn-print").show();
					$("#btn-print-kcl").attr("href", "<?php echo base_url('Master/print_timbangan2?id=')?>" + roll);
					$("#btn-print-kcl").show();
					status = 'update';
					$("#txt-btn-simpan").html("Update");
				} else {
					showNotification("alert-danger", "Roll Number Sudah Ada", "bottom", "center", "", "");
					status = 'insert';
				}
			}
		});
	}

	function tampil_edit(id) {
		$(".box-data").hide();
		$(".box-form").show();
		$(".new_roll").hide();
		$(".old_roll").hide();
		$('.box-form').animateCss('fadeInDown');
		$("#judul").html('<h3> Form Edit Data</h3>');

		status = "update";
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

				$("#btn-print").attr("href", "<?php echo base_url('Master/print_timbangan?id=')  ?>" + json.roll);
				$("#btn-print").show();
				$("#btn-print-kcl").attr("href", "<?php echo base_url('Master/print_timbangan2?id=')  ?>" + json.roll);
				$("#btn-print-kcl").show();

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

					$("#id1kode").val(a[0]).prop("disabled", true);
					$("#id11").val(a[1]).prop("disabled", true);
					$("#id22").val(athn).prop("disabled", true);
					$("#id2bln").val(abln).prop("disabled", true);
					$("#id44").val(anka).prop("disabled", true);
					$("#id4kode").val(ankod).prop("disabled", true);
				}

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
								swal("Berhasil", "", "success");
								reloadTable();

							} else {
								swal("Data Sudah dilakukan transaksi", "", "error");
							}
						}
					});
				} else {
					swal("", "Data Batal dihapus", "error");
				}
			});
	}

	function kosong() {
		$("#judul").html('<h3> Form Tambah Data</h3>');
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

		$("#id1").val("");
		$("#id2").val("");
		$("#id3").val("");
		$("#id4").val("");
		$("#id11").val("").prop("disabled", false);
		$("#id22").val("").prop("disabled", false);
		$("#id44").val("").prop("disabled", false);
		$("#id2bln").val("").prop("disabled", false);
		$("#id1kode").val("").prop("disabled", false);
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
		getThnBlnRoll();

		$("#txt-btn-simpan").html("Simpan");
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
