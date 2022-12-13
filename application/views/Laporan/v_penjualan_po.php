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

<style>
	.scroll-horizontal{
		background: #fff;
		overflow: auto;
		white-space: nowrap;
	}
	
	.ll-tr:hover {
		background: rgba(222, 222, 222, 0.5);
	}

	.notip {
		font-size:12px;color:#000;padding:5px;
	}

	.ll {
		padding-top:15px;
	}

	.inp-kosong {
		margin:0;padding:0;border:0;background: none;
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
								<li style="font-weight:bold">PENJUALAN PO</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<button class="btn-c-po" onclick="add_box()">ADD</button>

						<div class="table-cari" style="margin-top:15px">
							<table style="width:100%">
								<tr>
									<td style="width:50%">
										<input type="text" name="cari_po" id="cari_po" class="form-control" autocomplete="off" placeholder="CARI">
									</td>
									<td><button onclick="caripo()">CARI</button></td>
								</tr>
							</table>
						</div>

						<!-- TAMPIL DATA LIST -->
						<div class="ll box-data">
							<div class="box-data-cek"></div>
							<div class="box-data-list"></div>
						</div>

						<!-- TAMPIL DATA FORM -->
						<div class="ll box-form" style="overflow:auto;white-space:nowrap;">
							<table style="width:100%" border="">
								<tr>
									<td style="width:15%;padding:5px"></td>
									<td style="width:1%;padding:5px"></td>
									<td style="width:20%;padding:5px"></td>
									<td style="width:34%;padding:5px"></td>
									<td style="width:30%;padding:5px"></td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">TANGGAL</td>
									<td style="padding:5px">:</td>
									<td style="padding:5px">
										<input type="date" name="ftgl" id="ftgl" class="form-control">
									</td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">PAJAK</td>
									<td style="padding:5px">:</td>
									<td style="padding:5px;text-align:center">
										<!-- <button onclick="oppn('ppn')">PPN</button>
										-
										<button onclick="oppn('non')">NON</button> -->
										<select name="fpajak" id="fpajak" class="form-control">
											<option value="">PILIH</option>
											<option value="ppn">PPN</option>
											<option value="non">NON PPN</option>
										</select>
									</td>
									<!-- <td style="padding:5px">
										<input type="hidden" id="fpajak" value="">
										<input type="text" id="fpajak-txt" class="inp-kosong" disabled>
									</td> -->
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">KEPADA</td>
									<td style="padding:5px">:</td>
									<td style="padding:5px" colspan="3">
										<!-- <input type="text" id="fkepada" class="form-control"> -->
										<select class="form-control" id="fkepada" style="width:100%" autocomplete="off"></select>
									</td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">NAMA</td>
									<td style="padding:5px">:</td>
									<td style="padding:5px" colspan="3">
										<input type="text" id="fnama" class="form-control" style="background:#e9e9e9" disabled>
										<input type="hidden" id="fid" value="">
									</td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">ALAMAT</td>
									<td style="padding:5px">:</td>
									<td style="padding:5px" colspan="3">
										<!-- <input type="text" id="flamat" class="form-control"> -->
										<textarea name="falamat" id="falamat" rows="5" class="form-control" style="resize:none;background:#e9e9e9" disabled></textarea>
									</td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">NO. TELP</td>
									<td style="padding:5px">:</td>
									<td style="padding:5px" colspan="3">
										<input type="text" id="ftelp" class="form-control" style="background:#e9e9e9" disabled>
									</td>
								</tr>
							</table>

							<table style="width:100%;margin-top:15px" border="1">
								<tr>
									<td style="width:15%;padding:5px"></td>
									<td style="width:1%;padding:5px"></td>
									<td style="width:auto;padding:5px"></td>
									<td style="width:auto;padding:5px"></td>
									<td style="width:auto;padding:5px"></td>
									<td style="width:auto;padding:5px"></td>
									<td style="width:auto;padding:5px"></td>
									<td style="width:auto;padding:5px"></td>
									<td style="width:auto;padding:5px"></td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">NO. PO</td>
									<td style="padding:5px">:</td>
									<td style="padding:5px" colspan="7">
										<input type="text" id="fno-po" colspan="6" class="form-control">
									</td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">ITEMS</td>
									<td style="padding:5px">:</td>
									<td style="padding:5px">
										<input type="text" id="fjenis" class="form-control" style="text-align:center" maxlength="2" placeholder="JENIS" onkeypress="return hHuruf(event)">
									</td>
									<td style="padding:5px">
										<input type="text" id="fgsm" class="form-control" style="text-align:center" maxlength="3" placeholder="GSM" onkeypress="return hAngka(event)">
									</td>
									<td style="padding:5px">
										<input type="text" id="fukuran" class="form-control" style="text-align:center" maxlength="6" placeholder="UKURAN" onkeypress="return aKt(event)">
									</td>
									<td style="padding:5px">
										<input type="text" id="ftonase" class="form-control" style="text-align:center" maxlength="8" placeholder="TONASE">
									</td>
									<td style="padding:5px">
										<input type="text" id="fjmlroll" class="form-control" style="text-align:center" maxlength="3" placeholder="JML ROLL" onkeypress="return hAngka(event)">
									</td>
									<td style="padding:5px">
										<input type="text" id="fharga" class="form-control" style="text-align:center" maxlength="8" placeholder="HARGA">
									</td>
									<td style="padding:5px;text-align:center">
										<button onclick="addCartPO()">ADD</button>
									</td>
								</tr>							
							</table>

							

							<div class="ll">
								<button onclick="kosong()">BACK</button>
							</div>
						</div>

						<div class="cart-po"></div>

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
		$(".cart-po").load("<?php echo base_url('Master/dessCartPO') ?>");
		$(".box-data").show();
		$(".box-form").hide();
		kosong();
		// load_pt();
	});

	// ftgl fpajak fkepada fnama falamat ftelp
 	// fjenis fgsm fukuran ftonase fjmlroll fharga
	function kosong(){
		$("#fno-po").val("");
		$("#fid").val("");
		$("#ftgl").val("");
		$("#fpajak").val("");
		// $("#fpajak-txt").val("");
		$("#fnama").val("");
		$("#falamat").val("");
		$("#ftelp").val("");
		$("#fjenis").val("");
		$("#fgsm").val("");
		$("#fukuran").val("");
		$("#ftonase").val("");
		$("#fjmlroll").val("");
		$("#fharga").val("");
		$(".box-data").show();
		$(".box-form").hide(); 
		$("#fkepada").val("");

		$(".table-cari").show();
		load_pt();
		load_data('');

		$(".cart-po").html('');
		$(".cart-po").load("<?php echo base_url('Master/dessCartPO') ?>");
	}

	$("#fjenis").on({
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

	let rftonase = document.getElementById('ftonase');
	rftonase.addEventListener('keyup', function(e){
		rftonase.value = formatRupiah(this.value);
	});
	let rfharga = document.getElementById('fharga');
	rfharga.addEventListener('keyup', function(e){
		rfharga.value = formatRupiah(this.value);
	});
	/* Fungsi formatRupiah */
	function formatRupiah(angka, prefix){
		let number_string = angka.replace(/[^,\d]/g, '').toString(),
		split = number_string.split(','),
		sisa = split[0].length % 3,
		rupiah = split[0].substr(0, sisa),
		ribuan = split[0].substr(sisa).match(/\d{3}/gi);
		if(ribuan){
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		return rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
	}

	function aKt(evt) { // angkatitik
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 46 || charCode > 57))
			return false;
		return true;
	}
	function hAngka(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}
	function hHuruf(evt) {
		let charCode = (evt.which) ? evt.which : event.keyCode
		if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode > 32) {
			return false;
		}
		return true;
	}

	function load_pt() {
		$('#fkepada').select2({
			allowClear: true,
			placeholder: '- - SELECT - -',
			ajax: {
				dataType: 'json',
				url: '<?php echo base_url(); ?>/Master/loadPtPO',
				delay: 800,
				data: function(params) {
					if (params.term == undefined) {
						return {
							search: "",
							opsi: "po",
						}
					} else {
						return {
							search: params.term,
							opsi: "po",
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
	$('#fkepada').on('change', function() {
		data = $('#fkepada').select2('data');
		$("#fid").val(data[0].id);
		$("#fnama").val(data[0].pimpinan);
		// $("#fnama").val(data[0].nm_perusahaan);
		$("#falamat").val(data[0].alamat);
		$("#ftelp").val(data[0].no_telp);
	});

	function add_box(){
		$(".box-data-cek").html('');
		kosong();
		$(".table-cari").hide();
		$(".box-data").hide();
		$(".box-form").show();
	}

	function caripo(){
		cari = $("#cari_po").val();
		load_data(cari);
	}

	//

	function load_data(caripo){
		// alert(caripo)
		$(".box-data-list").html('MEMUAT DATA');
		$.ajax({
			url: '<?php echo base_url('Master/loadDataPO')?>',
			type: "POST",
			data: ({
				caripo: caripo,
			}),
			success: function(response){
				if(response){
					$(".box-data-list").html(response);
				}else{
					$(".box-data-list").html('TIDAK DITEMUKAN DATA');
				}
			}
		})
	}

	function btnCek(id,i,opsi){
		// alert(id+' - '+i+' - '+opsi);
		$(".btn-cek").html('');
		$(".btn-c-po").prop("disabled", true);
		$(".btn-cek-list-" + i).html('<div class="notip">MEMUAT DATA . . .</div>');
		$.ajax({
			url: '<?php echo base_url('Master/btnCekShow')?>',
			type: "POST",
			data: ({
				id: id,
				opsi: opsi,
				// i: i,
			}),
			success: function(response){
				if(response){
					$(".btn-cek-list-" + i).html(response);
					$(".btn-c-po").prop("disabled", false);
				}else{
					$(".btn-cek-list-" + i).html('not');
				}
			}
		})
	}

	function btnOpen(id,id_po,no_po,i){
		// alert(id+' - '+id_po+' - '+no_po+' - '+i)
		// Master/btnOpenShow
		// $(".btn-c-po").prop("disabled", true).attr('style', 'background:#ccc');
		$(".btn-c-po").prop("disabled", true);
		$(".ll-open").html('');
		$(".btn-open-list-" + i).html('<div class="notip">MEMUAT DATA . . .</div>');
		$.ajax({
			url: '<?php echo base_url('Laporan/newPenPO')?>',
			type: "POST",
			data: ({
				id: id,
				id_po: id_po,
				// no_po: no_po,
				// i: i,
				ctk: 0,
			}),
			success: function(response){
				if(response){
					$(".btn-open-list-" + i).html(response);
					// $(".btn-c-po").prop("disabled", false).removeAttr( "style");
					$(".btn-c-po").prop("disabled", false);
				}else{
					$(".btn-open-list-" + i).html('not');
				}
			}
		})
	}

	//

	function addCartPO(){
		fjenis = $("#fjenis").val();
		fgsm = $("#fgsm").val();
		fukuran = $("#fukuran").val();
		ftonase = $("#ftonase").val().split('.').join('');
		fjmlroll = $("#fjmlroll").val();
		fharga = $("#fharga").val().split('.').join('');
		// alert(fjenis+' - '+fgsm+' - '+fukuran+' - '+ftonase+' - '+fjmlroll+' - '+fharga);
		if (fjenis == '' || fgsm == '' || fukuran == '' || ftonase == '' || fjmlroll == '' || fharga == '') {
			swal("HARAP LENGKAPI FORM ITEMS ! ! !", "", "error");
			return;
		}

		$.ajax({
			url: '<?php echo base_url('Master/addCartPO')?>',
			type: "POST",
			data: ({
				fjenis: fjenis,
				fgsm: fgsm,
				fukuran: fukuran,
				ftonase: ftonase,
				fjmlroll: fjmlroll,
				fharga: fharga,
			}),
			success: function(response){
				$('.cart-po').load("<?php echo base_url('Master/showCartPO')?>");
			}
		})
	}
	
	function hapusCartPO(rowid){
		$.ajax({
			url: '<?php echo base_url('Master/hapusCartPO')?>',
			type: "POST",
			data: ({
				rowid: rowid
			}),
			success: function(response){
				$('.cart-po').load("<?php echo base_url('Master/showCartPO')?>");
			}
		});
	}

	function simpanCart(){
		// alert('simpanCart');
		fkepada = $("#fkepada").val();
		fno_po = $("#fno-po").val();
		fid = $("#fid").val();
		ftgl = $("#ftgl").val();
		fpajak = $("#fpajak").val();

		if (fkepada == '') {
			swal("PILIH CUSTOMER !", "", "error"); return;
		}
		if (fno_po == '') {
			swal("HARAP INPUT NOMER PO !", "", "error"); return;
		}
		if (fid == '') {
			swal("HARAP PILIH CUSTOMER !", "", "error"); return;
		}
		if (ftgl == '') {
			swal("HARAP PILIH TANGGAL !", "", "error"); return;
		}
		if (fpajak == '') {
			swal("HARAP PILIH JENIS PAJAK !", "", "error"); return;
		}

		$.ajax({
			url: '<?php echo base_url('Master/simpanCartPO')?>',
			type: "POST",
			data: ({
				fid: fid,
				fno_po: fno_po,
				ftgl: ftgl,
				fpajak: fpajak,
			}),
			success: function(response){
				if(response){
					// alert('berhasil');
					kosong();
				}else{
					alert('gagal');
				}
			}
		});
	}

</script>
