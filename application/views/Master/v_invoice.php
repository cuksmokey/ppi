<section class="content">
	<div class="container-fluid">
		<!-- Exportable Table -->
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							<ol class="breadcrumb">
								<li class="">INVOICE</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<div class="box-data">
							<table width="100%">
								<tr>
									<!-- <td align="left"> -->
									<td style="text-align: left;">
										<button type="button" class="btn-add btn btn-default btn-sm waves-effect">
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
										<th style="width:3%">No</th>
										<th style="width:15%">Tanggal</th>
										<th style="width:22%">No Invoice</th>
										<th style="width:22%">Kepada</th>
										<th style="width:22%">Nama Perusahaan</th>
										<th style="width:16%">Aksi</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>

						<!-- box form -->
						<div class="box-form">
							<!-- <center> -->
								<div style="text-align: center;" id="judul"></div>
							<!-- </center> -->
							<table width="100%">
								<tr>
									<td style="width:20%"></td>
									<td style="width:1%"></td>
									<td style="width:54%"></td>
									<td style="width:25%"></td>
								</tr>
								<tr>
									<td>No Invoice</td>
									<td>:</td>
									<td colspan="2">
										<input type="text" class="form-control" id="no_invoice" autocomplete="off">
										<input type="hidden" id="no_invoice_lama" value="">
										<input type="hidden" id="id_edit" value="">
										<input type="hidden" id="id_tgl" value="">
										<input type="hidden" id="id_pt" value="">
										<input type="hidden" id="id_pl_inv" value="">
										<input type="hidden" id="terbilang" value="">
										<input type="hidden" id="ket_kekurangan" value="">
									</td>
								</tr>
								<tr>
									<td>Tanggal Buat Invoice</td>
									<td>:</td>
									<td colspan="2" style="padding:5px 0 2px">
										<input type="date" id="tgl_b_inv" value="<?php echo date('Y-m-d') ?>" class="form-control" style="width: 40%">
									</td>
								</tr>
								<tr>
									<td>Tanggal Jatuh Tempo</td>
									<td>:</td>
									<td colspan="2" style="padding:3px 0 2px">
										<input type="date" id="jto" value="<?php echo date('Y-m-d') ?>" class="form-control" style="width: 40%">
									</td>
								</tr>
								<tr>
									<td>Pajak</td>
									<td>:</td>
									<td colspan="2" style="padding:3px 0 5px">
										<select name="" id="plh_pajak" class="form-control" style="width:40%">
											<option value="">-- PILIH --</option>
											<option value="1">PPN 10%</option>
											<option value="2">PPN 10% + PPH22</option>
											<option value="3">NON PPN</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Pilih Surat Jalan</td>
									<td>:</td>
									<td colspan="2">
										<select class="form-control" id="no_surat" style="width: 100%" autocomplete="off">
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="4">
										<hr>Dikirim Ke
										<hr>
									</td>
								</tr>
								<tr>
									<td>Kepada</td>
									<td>:</td>
									<td colspan="2">
										<input type="text" class="form-control" id="kepada" autocomplete="off">
									</td>
								</tr>
								<tr>
									<td>Nama Perusahaan</td>
									<td>:</td>
									<td colspan="2" style="padding:5px 0">
										<input type="text" class="form-control" id="nm_perusahaan" autocomplete="off">
										<input type="hidden" id="id_perusahaan" value="">
									</td>
								</tr>
								<tr>
									<td>Alamat Perusahaan</td>
									<td>:</td>
									<td colspan="2">
										<textarea id="alamat_perusahaan" rows="5" class="form-control"></textarea>
									</td>
								</tr>
							</table>

							<!-- LIST HARGA PO -->
							<table width="100%">
								<tr>
									<td><button type="button" onclick="btnTambahHarga('harga')" class="btn-plus-harga btn btn-default btn-sm waves-effect">
											<i class="material-icons">book</i>
											<span>List Harga PO</span>
										</button>
									</td>
								</tr>
							</table>
							<br>

							<table class="table" style="margin-bottom:0;background-color: grey; color:white">
								<thead>
									<tr>
										<th style="width:5%;text-align:center">NO</th>
										<th style="width:31%">NO PO</th>
										<th style="width:16%">GSM</th>
										<th style="width:16%">ITEM</th>
										<th style="width:20%;text-align:center">HARGA</th>
										<th style="width:12%;text-align:center">AKSI</th>
									</tr>
								</thead>
								<tbody id="detail_harga_po" style="vertical-align:middle">
								</tbody>
							</table>
							<table style="background:#c0c0c0;color:#333;vertical-align:middle;width:100%">
								<thead>
									<tr>
										<th style="width:5%;padding:0"></th>
										<th style="width:31%;padding:0"></th>
										<th style="width:16%;padding:0"></th>
										<th style="width:16%;padding:0"></th>
										<th style="width:20%;padding:0"></th>
										<th style="width:12%;padding:0"></th>
									</tr>
								</thead>
								<tbody id="edit_detail_harga_po">
								</tbody>
							</table>

							<br />
							<!-- LIST BARANG -->
							<table width="100%">
								<tr>
									<td><button type="button" onclick="btnTambahHarga('tambah')" class="btn-plus-data btn btn-default btn-sm waves-effect">
											<i class="material-icons">book</i>
											<span>List Item</span>
										</button>
									</td>
								</tr>
							</table>
							<br>

							<table class="table" style="margin-bottom:0;background-color: grey; color:white;vertical-align:middle">
								<thead>
									<tr>
										<th style="width:5%;text-align:center">NO</th>
										<th style="width:31%">NO PO</th>
										<th style="width:9%">GSM</th>
										<th style="width:9%">ITEM</th>
										<th style="width:7%">QTY</th>
										<th style="width:9%;text-align:center">BERAT</th>
										<th style="width:9%;text-align:center">SESET</th>
										<th style="width:9%;text-align:center">HASIL</th>
										<th style="width:12%;text-align:center">AKSI</th>
									</tr>
								</thead>
								<tbody id="detail_cart">
								</tbody>
							</table>
							<table style="background:#c0c0c0;color:#333;vertical-align:middle;width:100%">
								<thead>
									<tr>
										<th style="width:5%;padding:0"></th>
										<th style="width:31%;padding:0"></th>
										<th style="width:9%;padding:0"></th>
										<th style="width:9%;padding:0"></th>
										<th style="width:7%;padding:0"></th>
										<th style="width:9%;padding:0"></th>
										<th style="width:9%;padding:0"></th>
										<th style="width:9%;padding:0"></th>
										<th style="width:12%;padding:0"></th>
									</tr>
								</thead>
								<tbody id="edit_detail_cart">
								</tbody>
							</table>

							<br />
							<!-- RINCIAN PEMBAYARANNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN -->
							<div class="rincian-pembayaran">
								<table style="border-collapse:collapse;vertical-align:top;width:100%;color:#000">
									<thead>
										<tr>
											<th style="width:35%;padding:5px 0">RINCIAN</th>
											<th style="width:20%;padding:5px 0;text-align:center">JUMLAH</th>
											<th style="width:20%;padding:5px 0;text-align:center">HARGA</th>
											<th style="width:25%;padding:5px 0;text-align:center">TOTAL</th>
										</tr>
									</thead>
									<tbody id="detail_cart_rincian_pembayaran" style="background:#fff">
									</tbody>
								</table>
								<table style="border-collapse:collapse;vertical-align:top;width:100%;color:#000">
									<thead>
										<tr>
											<th style="width:35%;padding:0"></th>
											<th style="width:20%;padding:0"></th>
											<th style="width:20%;padding:0"></th>
											<th style="width:25%;padding:0"></th>
										</tr>
									</thead>
									<tbody id="detail_cart_pay_pembayaran" style="background:#fff">
									</tbody>
								</table>

								<br />
								<table width="100%">
									<tr>
										<td style="width:10%"></td>
										<td style="width:1%"></td>
										<td style="width:10%"></td>
										<td style="width:79%"></td>
									</tr>
									<tr>
										<td>Tanggal Cetak</td>
										<td>:</td>
										<td>
											<input type="date" id="tgl_ctk" value="" class="form-control">
										</td>
										<td style="padding:0 10px"><a type="button" id="btn-print" target="blank" class="btn btn-default btn-sm waves-effect" style="display:none">
												<i class="material-icons">print</i>
												<b><span>PRINT</span></b>
											</a>
											<button type="button" id="btn-print-disable" target="blank" class="btn btn-default btn-sm waves-effect"">
												<i class=" material-icons">print</i>
												<b><span>PRINT</span></b>
											</button>
										</td>
									</tr>
								</table>

								<br />
								<table class="table" style="margin-bottom:0;background-color: grey; color:white">
									<thead>
										<tr>
											<th style="width:5%;text-align:center">NO</th>
											<th style="width:45%;text-align:right">EDIT JUMLAH BAYAR</th>
											<th style="width:15%;text-align:center">JUMLAH BAYAR</th>
											<th style="width:10%;text-align:center">TGL BAYAR</th>
											<th style="width:25%;text-align:center">AKSI</th>
										</tr>
									</thead>
									<tbody id="detail_cart_paid" style="background:#c0c0c0;color:#333">
									</tbody>
								</table>

								<br />
								<table style="border-collapse:collapse;vertical-align:top;width:100%;color:#000">
									<tr>
										<td style="width:5%"></td>
										<td style="width:45%;text-align:right;padding-right:12px;color:#333">tambah pembayaran :</td>
										<td style="width:15%">
											<input type="text" id="jml_bayar" onkeypress="return hanyaAngka(event)" class="form-control" style="font-weight:bold;text-align:right;color:#000" placeholder="0" autocomplete="off">
											<input type="hidden" id="sub_sementara" value="">
										</td>
										<td style="width:10%"><input type="date" style="text-align:right" id="tgl_bayar" value="" class="form-control"></td>
										<td style="width:25%;text-align:center"><button type="button" onclick="payInvoice()" id="btnn-pay" class="btn btn-sm waves-effect" style="background:#287FB8;color:#fff;font-weight:bold">TAMBAH</button></td>
									</tr>
								</table>
							</div>

							<br>
							<button type="button" class="btn-kembali btn btn-dark btn-default btn-sm waves-effect">
								<i class="material-icons">arrow_back</i>
								<b><span>BACK</span></b>
							</button> &nbsp;&nbsp;
							<!-- <button type="button" class="btn-kembali btn btn-dark btn-circle waves-effect waves-circle waves-float">
								<i class="material-icons">arrow_back</i>
							</button> -->
							<button onclick="kosong()" type="button" class="btn btn-default btn-sm waves-effect">
								<i class="material-icons">note_add</i>
								<b><span>TAMBAH DATA</span></b>
							</button> &nbsp;&nbsp;
							<button onclick="simpan()" id="btn-simpan" type="button" class="btn btn-sm waves-effect" style="background:#8BC34A;color:#1B630A">
								<i class="material-icons">save</i>
								<b><span id="txt-btn-simpan">SIMPAN</span></b>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- #END# Exportable Table -->
		</div>
</section>

<!-- DETAIL LIST SESET -->
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="width: 150%; left: -200px">
			<div class="modal-header">
				<!-- <h4 class="modal-title" id="largeModalLabel">Modal title</h4> -->
			</div>
			<div class="modal-body">
				<div class="box-add">
					<table id="datatable-add" class="table table-bordered table-striped table-hover dataTable" style="font-weight:bold;width:100%">
						<thead>
							<tr>
								<th>NO SJ</th>
								<th>NO PO</th>
								<th>GSM</th>
								<th>ITEM</th>
								<th>QTY</th>
								<th>BERAT</th>
								<th>SESET</th>
								<th>AKSI</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<!-- DETAIL LIST PO -->
<div class="modal fade" id="modal-list-po" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="width: 150%; left: -200px">
			<div class="modal-header">
				<!-- <h4 class="modal-title" id="largeModalLabel">Modal title</h4> -->
			</div>
			<div class="modal-body">
				<div class="box-add">
					<table id="datatable-list-harga-po" width="100%" class="table table-bordered table-striped table-hover dataTable" style="font-weight:bold">
						<thead>
							<tr>
								<th>NO PO</th>
								<th>GSM</th>
								<th>JENIS</th>
								<th>HARGA</th>
								<th>AKSI</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
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
		load_sj();
	});

	function hanyaAngka(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}

	function formatNumber(num) {
		return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
	}

	$("#no_invoice").on({
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

	$(".btn-add").click(function() {
		status = 'insert';
		kosong();
		// getmax();
		$(".box-data").hide();
		$(".box-form").show();
		$("#judul").html('<h3> Form Tambah Data</h3>');
		$('.box-form').animateCss('fadeInDown');
	});

	$(".btn-kembali").click(function() {
		$(".box-form").hide();
		$(".box-data").show();
		$('.box-data').animateCss('fadeIn');
		kosong();
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
					jenis: "Invoice"
				}),
				"type": "POST"
			},
			responsive: true,
			"pageLength": 25,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});
	}

	// SIMPAN DATA INVOICE HEADER
	function simpan() {
		no_invoice = $("#no_invoice").val();
		no_invoice_lama = $("#no_invoice_lama").val();
		id_edit = $("#id_edit").val();
		jto = $("#jto").val();
		tgl_b_inv = $("#tgl_b_inv").val();
		tgl_ctk = $("#tgl_ctk").val();
		plh_pajak = $("#plh_pajak").val();
		no_surat = $("#no_surat").val();
		kepada = $("#kepada").val();
		nm_perusahaan = $("#nm_perusahaan").val();
		id_perusahaan = $("#id_perusahaan").val();
		alamat_perusahaan = $("#alamat_perusahaan").val();

		if (status == "update") {
			cart = $('#detail_cart').html(`<div></div>`);
			cart_harga_po = $('#detail_harga_po').html(`<div></div>`);
			urrl = 'update_inv';
		} else {
			cart = $('#detail_cart').html();
			cart_harga_po = $('#detail_harga_po').html();
			urrl = 'insert';
		}

		if (no_invoice == '' || jto == '' || tgl_b_inv == '' || plh_pajak == '' || kepada == '' || nm_perusahaan == '' || alamat_perusahaan == '' || cart == '' || cart_harga_po == '') {
			showNotification("alert-danger", "HARAP LENGKAPI FORM", "bottom", "right", "", "");
			return;
		}

		$("#btn-simpan").prop("disabled", true);

		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>Master/' + urrl,
			data: ({
				id_edit: id_edit,
				no_invoice: no_invoice,
				no_invoice_lama: no_invoice_lama,
				jto: jto,
				tgl_b_inv: tgl_b_inv,
				tgl_ctk: tgl_ctk,
				plh_pajak: plh_pajak,
				kepada: kepada,
				id_perusahaan: id_perusahaan,
				nm_perusahaan: nm_perusahaan,
				alamat_perusahaan: alamat_perusahaan,
				jenis: "Invoice"
			}),
			dataType: "json",
			success: function(data) {
				$("#btn-simpan").prop("disabled", false);
				if (data.data == true) {
					showNotification("alert-success", "BERHASIL!!!", "bottom", "right", "", "");
					kosong();
					editDataInv(data.id, data.invv);
					$('.box-form').animateCss('fadeInDown');
				} else {
					showNotification("alert-danger", data.msg, "bottom", "right", "", "");
				}
			}
		});
	}

	// EDIT
	function editDataInv(id, no_inv) {
		$(".box-data").hide();
		$(".box-form").show();
		$(".rincian-pembayaran").show();
		$("#judul").html('<h3>FORM EDIT INVOICE</h3>');

		$("#no_surat").prop("disabled", true);
		$(".btn-plus-data").prop("disabled", true);
		$(".btn-plus-harga").prop("disabled", true);

		status = "update";

		// alert(id+' - '+no_inv);

		$.ajax({
				url: '<?php echo base_url('Master/get_edit'); ?>',
				type: 'POST',
				data: {
					id: id,
					no_inv: no_inv,
					jenis: "editInv"
				},
			})
			.done(function(data) {
				json = JSON.parse(data);
				$("#no_surat").prop("disabled", true);
				$(".btn-plus-data").prop("disabled", true);
				$(".btn-plus-harga").prop("disabled", true);

				$("#no_invoice").val(json.header.no_invoice);
				$("#no_invoice_lama").val(json.header.no_invoice);
				$("#id_edit").val(json.header.id);
				$("#jto").val(json.header.jto);
				$("#tgl_b_inv").val(json.header.tgl);
				$("#plh_pajak").val(json.header.ppn);
				$("#kepada").val(json.header.kepada);
				$("#id_perusahaan").val(json.header.id_perusahaan);
				$("#nm_perusahaan").val(json.header.nm_perusahaan);
				$("textarea#alamat_perusahaan").val(json.header.alamat_perusahaan);

				// ATUR TOMBOL PRINT INVOICE
				$("#tgl_ctk").val(json.header.tgl_ctk);
				if (json.header.tgl_ctk == null || json.header.tgl_ctk == '0000-00-00') {
					$("#btn-print").hide();
					$("#btn-print-disable").prop("disabled", true).show();
				} else {
					$("#btn-print-disable").hide();
					$("#btn-print").attr("href", "<?php echo base_url('laporan/print_invoice_v2?no_invoice=')  ?>" + json.header.no_invoice);
					$("#btn-print").show();
				}

				// LIST DATA INVOICE
				html_list = '';
				for (var i = 0; i < json.list.length; i++) {
					ii = i + 1;
					html_list += `<tr>
						<td style="border-bottom:1px solid #fff;padding:10px;font-weight:bold;text-align:center">${ii}</td>
						<td style="border-bottom:1px solid #fff;padding:10px;font-weight:bold">${json.list[i].no_po}</td>
						<td style="border-bottom:1px solid #fff;padding:10px;font-weight:bold">${json.list[i].g_label}</td>
						<td style="border-bottom:1px solid #fff;padding:10px;font-weight:bold">${json.list[i].width}</td>
						<td style="border-bottom:1px solid #fff;padding:10px;font-weight:bold">${json.list[i].qty}</td>
						<td style="border-bottom:1px solid #fff;padding:10px;font-weight:bold;text-align:right">${formatNumber(json.list[i].weight)} KG</td>
						<td style="border-bottom:1px solid #fff;padding:10px;"><input style="font-weight:bold;text-align:right" type="text" class="form-control" id="e_seset${i}" placeholder="0" autocomplete="off" onkeypress="return hanyaAngka(event)" value="${json.list[i].seset}"></td>
						<td style="border-bottom:1px solid #fff;padding:10px;font-weight:bold;text-align:right">${formatNumber(json.list[i].weight - json.list[i].seset)} KG</td>
            			<td style="border-bottom:1px solid #fff;padding:10px;text-align:center"><button type="button" onclick="addToCartEdit('${json.list[i].id}','${json.header.no_invoice}','${json.list[i].weight}','${i}','h','p','list')" id="btnn-eedit${i}" class="btn btn-default btn-sm" style="font-weight:bold">EDIT</button></td>
					</tr>`;
				}
				$("#edit_detail_cart").html(html_list);
				// END LIST DATA INVOICE

				// TAMPIL HARGA INVOICE
				html_harga = '';
				for (var h = 0; h < json.harga.length; h++) {
					hh = h + 1;
					html_harga += `<tr>
						<td style="border-bottom:1px solid #fff;padding:10px;font-weight:bold;text-align:center">${hh}</td>
						<td style="border-bottom:1px solid #fff;padding:10px;font-weight:bold">${json.harga[h].no_po}</td>
						<td style="border-bottom:1px solid #fff;padding:10px;font-weight:bold">${json.harga[h].g_label}</td>
						<td style="border-bottom:1px solid #fff;padding:10px;font-weight:bold">${json.harga[h].nm_ker}</td>
						<td style="border-bottom:1px solid #fff;padding:10px;font-weight:bold"><input style="font-weight:bold;text-align:right" type="text" class="form-control" id="e_harga${h}" placeholder="0" autocomplete="off" onkeypress="return hanyaAngka(event)" value="${json.harga[h].harga}"></td>
            			<td style="border-bottom:1px solid #fff;padding:10px;text-align:center"><button type="button" onclick="addToCartEdit('${json.harga[h].id}','${json.header.no_invoice}','weight','i','${h}','p','harga')" id="btnn-eedit${h}" class="btn btn-default btn-sm" style="font-weight:bold">EDIT</button></td>
					</tr>`;
				}
				$("#edit_detail_harga_po").html(html_harga);
				// END TAMPIL HARGA INVOICE

				// TAMPIL RINCIAN PEMBAYARAN
				rinc = '';
				subtotal = 0;
				for (var r = 0; r < json.harga.length; r++) {
					zzt = json.rincian[r].jml_weight - json.rincian[r].jml_seset;
					itot = json.rincian[r].harga * zzt;
					subtotal += itot;

					rinc += `<tr>
						<td style="font-weight:bold;padding:6px 0">${json.rincian[r].no_po} - ${json.rincian[r].nm_ker} - ${json.rincian[r].g_label} GSM</td>
						<td style="font-weight:bold;padding:6px 0;text-align:right">${formatNumber(zzt)}</td>
						<td style="font-weight:bold;padding:6px 0;text-align:right">${formatNumber(json.rincian[r].harga)}</td>
						<td style="font-weight:bold;padding:6px 0;text-align:right">${formatNumber(itot)}</td>
					</tr>`;
				}
				rinc += `<tr>
					<td colspan="2"></td>
					<td style="font-weight:bold;padding:6px 0;text-align:right">Sub Total</td>
					<td style="font-weight:bold;padding:6px 0;text-align:right">${formatNumber(subtotal)}</td>
				</tr>`;

				// RUMUS
				if (json.header.ppn == 1) { // PPN 10%
					terbilang = subtotal + (0.1 * subtotal);
				} else if (json.header.ppn == 2) { // PPH22
					terbilang = subtotal + (0.1 * subtotal) + (0.01 * subtotal);
				} else { // NON PPN
					terbilang = subtotal;
				}
				$("#terbilang").val(terbilang);

				ppn10 = 0.1 * subtotal;
				pph22 = 0.01 * subtotal;

				txtppn = `<tr>
					<td colspan="2"></td>
					<td style="font-weight:bold;padding:6px 0;text-align:right">PPN 10%</td>
					<td style="font-weight:bold;padding:6px 0;text-align:right">${formatNumber(ppn10)}</td>
				</tr>`;

				if (json.header.ppn == 1) { // PPN 10 %
					rinc += txtppn;
				} else if (json.header.ppn == 2) { // PPH22
					rinc += txtppn + `<tr>
						<td colspan="2"></td>
						<td style="font-weight:bold;padding:6px 0;text-align:right">PPH22</td>
						<td style="font-weight:bold;padding:6px 0;text-align:right">${formatNumber(pph22)}</td>
					</tr>`;
				} else {
					rinc += '';
				}

				// TOTAL
				rinc += `<tr>
					<td colspan="2"></td>
					<td style="font-weight:bold;padding:6px 0;text-align:right">Total</td>
					<td style="border-bottom:1px solid #000;font-weight:bold;padding:6px 0 10px;text-align:right">${formatNumber(terbilang)}</td>
				</tr>`;
				$("#detail_cart_rincian_pembayaran").html(rinc);
				// END TAMPIL RINCIAN PEMBAYARAN

				// DETAIL PAY PEMBAYARAN
				html_pay = '';
				subharga = 0;
				for (var dpay = 0; dpay < json.rincpay.length; dpay++) {
					ddpay = dpay + 1;
					subharga += Number.parseInt(json.rincpay[dpay].jumlah);

					html_pay += `<tr>
						<td colspan="2"></td>
						<td style="font-weight:bold;padding:6px 0;text-align:right">Pembayaran-${ddpay}</td>
						<td style="font-weight:bold;padding:6px 0;text-align:right">${formatNumber(json.rincpay[dpay].jumlah)}</td>
					</tr>`;
				}

				kekurangan = terbilang - subharga;
				html_pay += `<tr>
						<td colspan="2"></td>
						<td style="font-weight:bold;padding:6px 0;text-align:right">Kekurangan</td>
						<td style="border-top:1px solid #000;font-weight:bold;padding:6px 0;text-align:right">${formatNumber(kekurangan)}</td>
					</tr>`;
				$("#detail_cart_pay_pembayaran").html(html_pay);
				$("#ket_kekurangan").val(kekurangan);
				// END DETAIL PAY PEMBAYARAN

				// KEKURANGAN BAYAR
				html_kurang = '';

				subjumlah = 0;
				for (var kpay = 0; kpay < json.rincpay.length; kpay++) {
					dkpay = kpay + 1;
					html_kurang += `<tr>
						<td style="font-weight:bold;padding:10px;text-align:center">${dkpay}</td>
						<td style="font-weight:bold;padding:10px;text-align:center"></td>
						<td style="padding:10px 0"><input style="font-weight:bold;text-align:right" type="text" class="form-control" id="e_payinv${kpay}" placeholder="0" autocomplete="off" onkeypress="return hanyaAngka(event)" value="${formatNumber(json.rincpay[kpay].jumlah)}"></td>
						<td style="font-weight:bold;padding:10px 0"><input type="date" id="e_tgl_bayar${kpay}" value="${json.rincpay[kpay].tgl_bayar}" style="text-align:right" class="form-control"></td>
						<td style="font-weight:bold;padding:10px;text-align:center"><button type="button" onclick="addToCartEdit('${json.rincpay[kpay].id}','${json.header.no_invoice}','${json.rincpay[kpay].jumlah}','i','h','${kpay}','payinv')" id="btnn-eedit${kpay}" class="btn btn-default btn-sm">EDIT</button> | <button type="button" onclick="deleteData('${json.rincpay[kpay].id}','${json.header.no_invoice}','hargainv')" class="btn btn-sm" style="background:red;color:#000">HAPUS</button></td>
					</tr>`;
					subjumlah += Number.parseInt(json.rincpay[kpay].jumlah);
				}
				$("#sub_sementara").val(subjumlah);
				$("#detail_cart_paid").html(html_kurang);
				// END KEKURANGAN BAYAR
			})
	}

	function payInvoice() {
		ket_kekurangan = $("#ket_kekurangan").val();
		no_inv = $("#no_invoice").val();
		tgl_bayar = $("#tgl_bayar").val();
		i_jml_bayar = $("#jml_bayar").val().split(".").join("");

		if (i_jml_bayar == 0 || i_jml_bayar == '') {
			jml_bayar = 0;
		} else {
			jml_bayar = i_jml_bayar;
		}

		// alert(no_inv+' - '+tgl_bayar+' - '+jml_bayar+' - '+ket_kekurangan);

		if (jml_bayar == 0) {
			swal("JUMLAH BAYAR TIDAK BOLEH KOSONG ! ! !", "", "error");
			return;
		}
		if (tgl_bayar == '' || tgl_bayar == '0000-00-00') {
			swal("TANGGAL BAYAR TIDAK BOLEH KOSONG ! ! !", "", "error");
			return;
		}
		kurang = Number.parseInt(ket_kekurangan);
		if(jml_bayar > kurang){
			swal("MELEBIHI PEMBAYARAN ! ! !", "", "error");
			return;
		}

		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>Master/update_inv',
			data: ({
				no_inv: no_inv,
				tgl_bayar: tgl_bayar,
				jml_bayar: jml_bayar,
				jenis: "payInv"
			}),
			dataType: "json",
			success: function(data) {
				$("#btn-simpan").prop("disabled", false);
				if (data.data == true) {
					showNotification("alert-success", "BERHASIL!!!", "bottom", "right", "", "");
					editDataInv(data.id, data.invvv);
					$("#tgl_bayar").val("");
					$("#jml_bayar").val("");
				} else {
					showNotification("alert-danger", data.msg, "bottom", "right", "", "");
				}
			}
		});
	}

	// LIST ITEM INVOICE
	function addToCart(no_po = '', no_surat = '', no_pkb = '', nm_ker = '', g_label = '', width = '', qty = '', weight = '', opsi, i) {
		berat = $("#berat" + i).val();
		seset = $("#seset" + i).val();
		harga_inv = $("#harga_inv" + i).val();

		if (seset == 0 || seset == undefined) {
			i_seset = 0;
		} else {
			i_seset = seset;
		}

		if (harga_inv == 0 || harga_inv == undefined || harga_inv == '') {
			i_harga_inv = 0;
		} else {
			i_harga_inv = harga_inv;
		}

		// alert(no_po+' - '+nm_ker+' - '+g_label+' - '+width+' - '+qty+' - '+weight+' - '+i_seset+' - '+i_harga_inv+' - '+i);

		k_qty = Number.parseInt(i_seset);
		k_weight = Number.parseInt(weight);

		if (i_harga_inv == 0 && opsi == 2) {
			swal("JUMLAH BAYAR TIDAK BOLEH KOSONG ! ! !", "", "error");
			return;
		}

		if (i_seset > k_weight) {
			swal("SESET LEBIH DARI BERAT ASLI ! ! !", "", "error");
		} else {
			$.ajax({
				url: "<?php echo base_url(); ?>Master/addCartInvoice",
				method: "POST",
				data: {
					no_po: no_po,
					no_surat: no_surat,
					no_pkb: no_pkb,
					nm_ker: nm_ker,
					g_label: g_label,
					width: width,
					qty: qty,
					weight: weight,
					seset: i_seset,
					harga_inv: i_harga_inv,
					opsi: opsi,
					i: i,
				},
				success: function(data) {
					// swal("Berhasil Ditambahkan", "", "success");
					if (opsi == 1) {
						$("#seset" + i).attr('style', 'background:#ccc;text-align:right');
						$('#detail_cart').html(data);
					} else {
						$("#harga_inv" + i).attr('style', 'background:#ccc;text-align:right');
						$('#detail_harga_po').html(data);
					}
				}
			});
		}
	}

	// EDIT LIST ITEM INVOICE
	function addToCartEdit(id, no_inv, weight, i = '0', h = '0', p = '0', opsi) {
		$("#btn-simpan").prop("disabled", false);
		// $("#e_seset" + i).prop("disabled", true).attr('style', 'background:#bbb;font-weight:bold;text-align:right');
		// $("#btnn-eedit" + i).prop("disabled", true);		
		ii_seset = $("#e_seset" + i).val();
		ii_harga = $("#e_harga" + h).val();
		ii_payinv = $("#e_payinv" + p).val();
		ii_tgl_bayar = $("#e_tgl_bayar" + p).val();

		if (ii_seset == '' || ii_seset == undefined) {
			i_seset = 0;
		} else {
			i_seset = ii_seset;
		}

		if (ii_harga == '' || ii_harga == undefined) {
			i_harga = 0;
		} else {
			i_harga = ii_harga;
		}

		if (ii_payinv == '' || ii_payinv == undefined) {
			i_payinv = 0;
		} else {
			i_payinv = ii_payinv.split(".").join("");
		}

		if (ii_tgl_bayar == '' || ii_tgl_bayar == '0000-00-00') {
			i_tgl_bayar = '';
		} else {
			i_tgl_bayar = ii_tgl_bayar;
		}

		k_qty = Number.parseInt(i_seset);
		k_payinv = Number.parseInt(i_payinv);
		k_weight = Number.parseInt(weight);

		subtotall = $("#sub_sementara").val();
		xterbilang = $("#terbilang").val();
		e_weight = (subtotall - k_weight) + k_payinv;

		// alert('id='+id+' - no_inv='+no_inv+' - weight='+weight+' - id='+i+' - '+h+' - '+p+' - opsi='+opsi+' - seset='+i_seset+' - byr_lama='+subtotall+' - pay='+i_payinv+' - rumus='+formatNumber(e_weight)+' - terbilang='+formatNumber(xterbilang));

		if (k_qty > k_weight && opsi === 'list') {
			swal("SESET LEBIH DARI BERAT ASLI ! ! !", "", "error");
			return;
		}
		
		if (i_harga == 0 && opsi === 'harga') {
			swal("EDIT HARGA PO TIDAK BOLEH KOSONG ! ! !", "", "error");
			return;
		}

		if (i_payinv == 0 && opsi === 'payinv') {
			swal("EDIT HARGA INVOICE TIDAK BOLEH KOSONG ! ! !", "", "error");
			return;
		}
		
		if(e_weight > xterbilang && opsi === 'payinv'){
			swal("MELEBIHI PEMBAYARAN ! ! !", "", "error");
			return;
		}

		if (i_tgl_bayar == '' && opsi === 'payinv') {
			swal("EDIT TANGGAL HARGA INVOICE TIDAK BOLEH KOSONG ! ! !", "", "error");
			return;
		}

		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>Master/update_inv',
			data: ({
				id: id,
				no_inv: no_inv,
				i_seset: i_seset,
				i_harga: i_harga,
				i_payinv: i_payinv,
				i_tgl_bayar: i_tgl_bayar,
				opsi: opsi,
				jenis: "editInvListBarang"
			}),
			dataType: "json",
			success: function(data) {
				$("#btn-simpan").prop("disabled", false);
				if (data.data == true) {
					showNotification("alert-success", "BERHASIL!!!", "bottom", "right", "", "");
					kosong();
					editDataInv(data.id, data.invvv);
					$("#e_seset" + i).animateCss('fadeInRight');
					$("#e_harga" + h).animateCss('fadeInRight');
					$("#e_payinv" + p).animateCss('fadeInRight');
					$("#e_tgl_bayar" + p).animateCss('fadeInRight');
				} else {
					showNotification("alert-danger", "Gagal Edit!", "bottom", "right", "", "");
				}
			}
		});
	}

	function deleteData(id, nm, opsi) {
		// alert(id+' - '+nm+' - '+opsi);
		swal({
				title: "Hapus Data ?",
				text: "",
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
							no_invoice: nm,
							opsi: opsi,
							jenis: "hapus_inv"
						},
						dataType: "json",
						success: function(data) {
							if (data.data === 1) {
								swal("Berhasil Di Hapus", "", "success");
								reloadTable();
							}else if (data.data === true) {
								swal("Berhasil Di Hapus", "", "success");
								editDataInv(data.id, data.invv);
							} else {
								swal("error", "", "error");
							}
						}
					});
				} else {
					swal("", "Data Batal Di Hapus.", "error");
				}
			});
	}

	function confirmData(id, nm) {
		// alert(id+' - '+nm);
		swal({
				title: "Apakah Anda Yakin Konfirmasi Data ?",
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
						url: '<?php echo base_url(); ?>Master/confirm',
						type: "POST",
						data: {
							id: id
						},
						success: function(data) {
							if (data == 1) {
								swal("Berhasil", "", "success");
								reloadTable();
							} else {
								swal("Data Sudah Melakukan Konfirmasi", "", "error");
							}
						}
					});
				} else {
					swal("", "Data Batal Di Konfirmasi", "error");
				}
			});
	}

	function kosong() {
		$("#judul").html('<h3>Form Tambah Data</h3>');
		$(".rincian-pembayaran").hide();
		status = "insert";

		$(".btn-plus-data").prop("disabled", false);
		$(".btn-plus-harga").prop("disabled", false);

		$("#no_invoice").val("");
		$("#no_invoice_lama").val("");
		$("#id_edit").val("");
		$("#jto").val("");
		$("#tgl_b_inv").val("");
		$("#tgl_bayar").val("");
		$("#plh_pajak").val("");
		$("#no_surat").val("").prop("disabled", false);
		$("#kepada").val("");
		$("#id_perusahaan").val("");
		$("#nm_perusahaan").val("");
		$("textarea#alamat_perusahaan").val("");
		$("#id_tgl").val("");
		$("#id_pt").val("");
		$("#id_pl_inv").val("");
		
		$("#jml_bayar").val("");
		$("#sub_sementara").val("");
		$("#terbilang").val("");
		$("#ket_kekurangan").val("");
		
		$('#detail_cart').load("<?php echo base_url(); ?>Master/destroy_cart_inv");
		$('#detail_harga_po').load("<?php echo base_url(); ?>Master/destroy_cart_inv");

		$("#edit_detail_cart").html("");
		$("#edit_detail_harga_po").html("");
		$("#detail_cart_rincian_pembayaran").html("");
		$("#detail_cart_pay_pembayaran").html("");
		$("#detail_cart_paid").html("");
	}

	// LIST INPUT SESET ITEM SURAT JALAN
	function btnTambahHarga(opsi) {
		no_surat = $("#no_surat").val();
		id_tgl = $("#id_tgl").val();
		id_pt = $("#id_pt").val();
		id_pl_inv = $("#id_pl_inv").val();

		// alert(id_tgl + ' - ' +id_pt + ' - ' + id_pl_inv);

		if (no_surat == null) {
			showNotification("alert-danger", "HARAP PILIH DATA DAHULU ! ! !", "bottom", "right", "", "");
			return;
		}

		if (opsi == 'tambah') {
			group = 1;
		} else { //harga
			group = 2;
		}

		load_barang(id_tgl, id_pt, id_pl_inv, group);

		if (opsi == 'tambah') {
			$("#modal-tambah").modal("show");
		} else {
			$("#modal-list-po").modal("show");
		}

	};

	// LOAD SURAT JALAN
	function load_barang(id_tgl, id_pt, id_pl_inv, group) {
		if (group == 1) {
			vTable = $('#datatable-add');
		} else {
			vTable = $('#datatable-list-harga-po');
		}

		var table = vTable.DataTable();
		table.destroy();
		tabel = vTable.DataTable({
			"processing": true,
			"pageLength": true,
			"paging": true,
			"ajax": {
				"url": '<?php echo base_url(); ?>Master/load_data',
				"data": ({
					jenis: "list_barang",
					// no_surat: no_surat,
					id_tgl: id_tgl,
					id_pt: id_pt,
					id_pl_inv: id_pl_inv,
					group: group,
				}),
				"type": "POST"
			},
			responsive: true,
			"pageLength": 25,
			"language": {
				"emptyTable": "Tidak ada data.."
			}
		});
	}

	function load_sj() {
		$('#no_surat').select2({
			// minimumInputLength: 3,
			allowClear: true,
			placeholder: '- - SELECT - -',
			ajax: {
				dataType: 'json',
				url: '<?php echo base_url(); ?>/Master/load_sj',
				delay: 800,
				data: function(params) {
					if (params.term == undefined) {
						return {
							search: ""
						}
					} else {
						return {
							search: params.term
						}
					}
				},
				processResults: function(data, page) {
					return {
						results: data
					};
				},
			}
		});
	}

	// TAMPIL DI KOLOM
	$('#no_surat').on('change', function() {
		data = $('#no_surat').select2('data');
		$("#id_perusahaan").val(data[0].id_perusahaan);
		$("#nm_perusahaan").val(data[0].nm_perusahaan);
		$("textarea#alamat_perusahaan").val(data[0].alamat);
		$("#kepada").val(data[0].pimpinan);
		$("#id_tgl").val(data[0].tgl);
		$("#id_pt").val(data[0].id_pt);
		$("#id_pl_inv").val(data[0].id_pl_inv);
	});

	var rupiah = document.getElementById("jml_bayar");
	rupiah.addEventListener("keyup", function(e) {
		rupiah.value = formatRupiah(this.value);
	});

	/* Fungsi formatRupiah */
	function formatRupiah(angka, prefix) {
		var number_string = angka.replace(/[^,\d]/g, "").toString(),
			split = number_string.split(","),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);

		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if (ribuan) {
			separator = sisa ? "." : "";
			rupiah += separator + ribuan.join(".");
		}

		return rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
	}
</script>
