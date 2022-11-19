<section class="content">
	<div class="container-fluid">

		<!-- Exportable Table -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							<ol class="breadcrumb">
								<li class="">Master P O </li>
							</ol>
						</h2>

					</div>

					<div class="body">

						<div class="box-data">
							<table width="100%">
								<tr>
									<td align="left"> <button type="button" class="btn-add btn btn-default btn-sm waves-effect">
											<i class="material-icons">library_add</i>
											<span>New</span>
										</button>
									</td>
								</tr>
							</table>


							<br><br>
							<table id="datatable11" class="table table-bordered table-striped table-hover dataTable ">
								<thead>
									<tr>
										<th>ID</th>
										<th>Nama Perusahaan</th>
										<th>Tanggal</th>
										<th>PO</th>
										<th>Nama Ker</th>
										<th>GSM</th>
										<th>Width</th>
										<th>Total Berat</th>
										<th width="15%">Aksi</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>

						<!-- box form -->
						<div class="box-form">
							<center>
								<div id="judul"></div>
							</center>
							<table width="70%">
								<tr>
									<td colspan="4">
										<!-- <input type="hidden" id="id" value="" class="form-control" style="width: 40%"> -->
										<input type="hidden" id="nm_perusahaan_lama" value="" class="form-control" style="width: 40%">
										<!-- <input type="text" id="nm_perusahaan" value="" class="form-control" style="width: 40%"> -->
									</td>
								</tr>
								<tr>
									<td>Nama Perusahaan</td>
									<td>:</td>
									<td colspan="2">
										<select name="" id="nm_perusahaan" class="form-control" style="margin: 5px">
											<option value="0">Pilih Perusahaan</option>
											<?php

											include 'connect.php';

											$sql = mysql_query("SELECT id,pimpinan,nm_perusahaan FROM m_perusahaan");
											while ($data = mysql_fetch_array($sql)) {

											?>

												<option value="<?= $data['id'] ?>"><?= $data['id'] ?> || <?= $data['pimpinan'] ?> || <?= $data['nm_perusahaan'] ?> </option>

											<?php
											}
											?>

										</select>
									</td>
								</tr>
								<tr>
									<td>Tanggal</td>
									<td>:</td>
									<td colspan="2">
										<input type="date" id="tgl" value="<?php echo date('Y-m-d') ?>" class="form-control" style="width: 40%">
									</td>
								</tr>
								<tr>
									<td>Nama Kertas</td>
									<td>:</td>
									<td colspan="2">
										<select id="nm_ker" class="form-control" style="width: 40%">
											<option value="">Pilih</option>
											<option value="WP">WP</option>
											<option value="MH">MH</option>
											<option value="BK">BK</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Grammage Label</td>
									<td>:</td>
									<td>
										<select id="g_label" class="form-control">
											<option value="">Pilih</option>
											<option value="67">67</option>
											<option value="68">68</option>
											<option value="70">70</option>
											<option value="110">110</option>
											<option value="125">125</option>
											<option value="140">140</option>
											<option value="150">150</option>
										</select>
									</td>
									<td>
										<input type="text" disabled="true" class="form-control" value="GSM" style="width: 30%;border: none">
									</td>
								</tr>
								<tr>
									<td>Width</td>
									<td>:</td>
									<td>
										<input type="text" class="form-control" placeholder="0" id="width">
									</td>
									<td>
										<input type="text" disabled="true" class=" form-control" value="CM" style="width: 30%;border: none">
									</td>
								</tr>
								<tr>
									<td>Total Berat</td>
									<td>:</td>
									<td>
										<input type="text" class="form-control" placeholder="0" id="tonase">
									</td>
									<td>
										<input type="text" disabled="true" class="form-control" value="KG" style="width: 30%;border: none">
									</td>
								</tr>
								<tr>
									<td>No PO</td>
									<td>:</td>
									<td colspan="2">
										<input type="text" class="form-control" id="no_po">
									</td>
								</tr>
								<tr>
									<td colspan="3" align="right">
										<br>

									</td>
								</tr>
							</table>


							<!-- <button type="button" class="btn-kembali btn btn-dark btn-sm waves-effect waves-circle waves-float"> -->
							<button type="button" class="btn-kembali btn btn-dark btn-default btn-sm waves-effect">
								<!-- <i class="material-icons">arrow_back</i> -->
								<b><span>BACK</span></b>
							</button> &nbsp;&nbsp;&nbsp;&nbsp;
							<button onclick="simpan()" id="btn-simpan" type="button" class="btn bg-light-green btn-sm waves-effect">
								<!-- <i class="material-icons">save</i> -->
								<b><span id="txt-btn-simpan">SIMPAN</span></b>
							</button> &nbsp;&nbsp;&nbsp;&nbsp;
							<button onclick="kosong()" type="button" class="btn btn-default btn-sm waves-effect">
								<!-- <i class="material-icons">note_add</i> -->
								<b><span>TAMBAH DATA</span></b>
							</button>
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
		// getmax();
		$(".box-data").hide();
		$(".box-form").show();
		$("#judul").html('<h3> Tambah Data Master PO</h3>');
		$('.box-form').animateCss('fadeInDown');
	});

	$(".btn-kembali").click(function() {
		$(".box-form").hide();
		$(".box-data").show();
		$('.box-data').animateCss('fadeIn');
		load_data();
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
				"url": '<?php echo base_url(); ?>Master/load_data',
				"data": ({
					jenis: "PoMaster"
				}),
				"type": "POST"
			},
			responsive: true,
			"pageLength": 10,
			"language": {
				"emptyTable": "Tidak ada data.."
			},
			"order": [
				[0, "asc"]
			]
		});

	}


	function simpan() {
		// roll = $("#id1").val()+"/"+$("#id2").val()+"/"+$("#id3").val()+"/"+$("#id4").val();

		// id  = $("#id").val();
		// id_perusahaan_lama = $("#nm_perusahaan_lama").val();
		id_perusahaan = $("#nm_perusahaan").val();
		tgl = $("#tgl").val();
		nm_ker = $("#nm_ker").val();
		g_label = $("#g_label").val();
		width = $("#width").val();
		tonase = $("#tonase").val();
		no_po = $("#no_po").val();

		if (id_perusahaan == "" || nm_ker == "" || g_label == "" || width == "" || tonase == "" || no_po == "") {
			showNotification("alert-info", "Harap Lengkapi Form", "bottom", "center", "", "");
			return;
		}

		$("#btn-simpan").prop("disabled", true);

		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>Master/' + status,
			data: ({
				id_perusahaan: id_perusahaan,
				tgl: tgl,
				nm_ker: nm_ker,
				g_label: g_label,
				width: width,
				tonase: tonase,
				no_po: no_po,
				jenis: "PoMaster"
			}),
			dataType: "json",
			success: function(data) {
				$("#btn-simpan").prop("disabled", true);
				if (data.data == true) {

					reloadTable();
					showNotification("alert-success", "Berhasil", "bottom", "center", "", "");

					status = 'update';

				} else {
					showNotification("alert-danger", "Nama Perusahaan, Jenis Kertas , GSM, dan Ukuran Sudah Ada ", "bottom", "center", "", "");
				}

			}
		});
	}

	function tampil_edit(id) {
		$(".box-data").hide();
		$(".box-form").show();
		$('.box-form').animateCss('fadeInDown');
		$("#judul").html('<h3> Form Edit Data Master PO</h3>');

		status = "update";

		$.ajax({
				url: '<?php echo base_url('Master/get_edit'); ?>',
				type: 'POST',
				data: {
					id: id,
					jenis: "PoMaster"
				},
			})
			.done(function(data) {
				json = JSON.parse(data);

				$("#nm_perusahaan").val(json.id_perusahaan).prop("disabled", true);
				$("#tgl").val(json.tgl);
				$("#nm_ker").val(json.nm_ker).prop("disabled", true).attr('style', 'background:#ddd;width:40%');
				$("#g_label").val(json.g_label).prop("disabled", true).attr('style', 'background:#ddd;');
				$("#width").val(json.width).prop("disabled", true).attr('style', 'background:#ddd;');
				$("#tonase").val(json.tonase);
				$("#no_po").val(json.no_po);

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
							jenis: "PoMaster"
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

	// function confirmCekPo(id,nm){
	//     swal({
	//       title: "Apakah Anda Yakin Konfirmasi Data ?",
	//       text: nm,
	//       type: "warning",
	//       showCancelButton: true,
	//       confirmButtonClass: "btn-danger",
	//       confirmButtonText: "Ya",
	//       cancelButtonText: "Batal",
	//       closeOnConfirm: false,
	//       closeOnCancel: false
	//     },
	//     function(isConfirm) {
	//       if (isConfirm) {
	//         $.ajax({
	//           url   : '<?php echo base_url(); ?>Master/confirm_cek_po',
	//           type  : "POST",
	//           data  : {id: id},
	//           success : function(data){
	//             if (data == 1) {
	//             swal("Berhasil", "", "success");
	//             reloadTable();

	//             }else{
	//               swal("Data Sudah Melakukan Konfirmasi", "", "error");
	//             }
	//           }
	//         });

	//       } else {
	//         swal("", "Data Batal Di Konfirmasi", "error");
	//       }
	//     });
	// }

	function kosong() {
		$("#judul").html('<h3> Form Tambah Data</h3>');
		status = "insert";
		$("#id").val("");
		$("#nm_perusahaan_lama").val("");
		$("#nm_perusahaan").val("").prop("disabled", false);
		$("#tgl").val("");
		$("#nm_ker").val("").prop("disabled", false).attr('style', 'background:#fff;width:40%');
		$("#g_label").val("").prop("disabled", false).attr('style', 'background:#fff;');
		$("#width").val("").prop("disabled", false).attr('style', 'background:#fff;');
		$("#tonase").val("");
		$("#no_po").val("");

		$("#btn-simpan").prop("disabled", false);
		$("#txt-btn-simpan").html("Simpan");
	}
</script>
