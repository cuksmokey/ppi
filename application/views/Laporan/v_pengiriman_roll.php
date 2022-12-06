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

	.status-stok {
		background-color: #fff;
	}
	.status-stok:hover {
		background-color: #eee;
	}
	/* .cek-status-stok:hover .edit-roll {
		background-color: #eee;
	} */

	.status-buffer {
		background-color: #fee;
	}
	.status-buffer:hover {
		background-color: #edd;
	}
	/* .cek-status-buffer:hover .edit-roll {
		background:#edd;
	} */

	.notfon {
		color:#000;padding:5px 0 0
	}

	.btn-cari-inp-roll {
		padding:5px 8px;font-weight:bold
	}

	.ilist {
		padding-top:15px
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
						<input type="hidden" id="otorisasi" value="<?php echo $otorisasi; ?>">
						<input type="hidden" id="v-id-pl" value="">
						<input type="hidden" id="v-opl" value="">
						<input type="hidden" id="v-tgl-pl" value="">
						<input type="hidden" id="v-ii" value="">
						<!-- <input type="text" id="v-id-pl" value=""> -->

						<div class="ilist plh-opsi-plrk">
							<button id="btn-opsi-pl" onclick="pilih_opsi('pl')">PACKING LIST</button>
							<button id="btn-opsi-rk" onclick="pilih_opsi('rk')">RENCANA KIRIM</button>
						</div>

						<div class="list-btn-pl">
							<div style="margin-top:15px"><button onclick="btnAdd()">ADD</button></div>
							
							<div class="ilist box-data-pl">LIST BOX PL</div>

							<div class="ilist box-form-pl" style="overflow:auto;white-space:nowrap;">
								<!-- BOX FORM PL -->
								<table style="width:100%" border="1">
									<tr>
										<td style="width:15%;padding:5px"></td>
										<td style="width:1%;padding:5px"></td>
										<td style="width:25%;padding:5px"></td>
										<td style="width:auto;padding:5px"></td>
										<td style="width:auto;padding:5px"></td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold" colspan="5">KIRIM KE:</td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">KEPADA</td>
										<td style="padding:5px">:</td>
										<td style="padding:5px" colspan="3">
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

								<table style="margin-top:15px;width:100%" border="1">
									<tr>
										<td style="width:15%;padding:5px"></td>
										<td style="width:1%;padding:5px"></td>
										<td style="width:25%;padding:5px"></td>
										<td style="width:auto;padding:5px"></td>
										<td style="width:auto;padding:5px"></td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">TANGGAL</td>
										<td style="padding:5px;text-align:center">:</td>
										<td style="padding:5px">
											<input type="date" name="ftgl" id="ftgl" class="form-control">
										</td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">PAJAK</td>
										<td style="padding:5px;text-align:center">:</td>
										<td style="padding:5px;text-align:center">
											<select name="fplhpajak" id="fplhpajak" class="form-control">
												<option value="">PILIH</option>
												<option value="MH">PPN</option>
												<option value="MN">NON PPN</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">JENIS</td>
										<td style="padding:5px;text-align:center">:</td>
										<td style="padding:5px">
											<select name="fjenis" id="fjenis" class="form-control">
												<option value="">PILIH</option>
												<option value="MH">MH</option>
												<option value="MN">MN</option>
												<option value="BK">BK</option>
												<option value="WP">WP</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">NO SURAT JALAN</td>
										<td style="padding:5px;text-align:center">:</td>
										<td style="padding:5px" colspan="3">
											<table style="width:100%">
												<tr>
													<td><input type="text" name="fno-sj" id="fno-sj" class="form-control" placeholder="NO" autocomplete="off" maxlength="4"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" name="froll" id="froll" class="form-control" placeholder="ROLL" value="ROLL" autocomplete="off"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" name="fbulan" id="fbulan" class="form-control" placeholder="BULAN" autocomplete="off"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" name="ftahun" id="ftahun" class="form-control" placeholder="TAHUN" autocomplete="off"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" name="fpajak" id="fpajak" class="form-control" placeholder="PAJAK" autocomplete="off" maxlength="1" disabled style="background:#e9e9e9"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" name="fquality" id="fquality" class="form-control" placeholder="JENIS" autocomplete="off" maxlength="2" disabled style="background:#e9e9e9"></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">NO SO</td>
										<td style="padding:5px;text-align:center">:</td>
										<td style="padding:5px" colspan="3">
											<table style="width:100%">
												<tr>
													<td><input type="text" name="fno-so" id="fno-so" class="form-control" placeholder="NO" autocomplete="off" maxlength="4"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" name="fsoroll" id="fsoroll" class="form-control" placeholder="SO-ROLL" value="SO-ROLL" autocomplete="off"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" name="fsobulan" id="fsobulan" class="form-control" placeholder="BULAN" autocomplete="off"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" name="fsotahun" id="fsotahun" class="form-control" placeholder="TAHUN" autocomplete="off"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" name="fsopajak" id="fsopajak" class="form-control" placeholder="PAJAK" autocomplete="off" maxlength="1" disabled style="background:#e9e9e9"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" name="fsoquality" id="fsoquality" class="form-control" placeholder="JENIS" autocomplete="off" maxlength="2" disabled style="background:#e9e9e9"></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">NO PKB</td>
										<td style="padding:5px;text-align:center">:</td>
										<td style="padding:5px">
											<table style="width:100%">
												<tr>
													<td><input type="text" name="fno-pkb" id="fno-pkb" class="form-control" placeholder="NO" autocomplete="off" maxlength="4"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" name="ftahun-pkb" id="ftahun-pkb" class="form-control" placeholder="TAHUN" autocomplete="off"></td>
													<td style="padding:0 5px">/</td>
													<td><input type="text" name="ftahun-pkb" id="ftahun-pkb" class="form-control" placeholder="JENIS" autocomplete="off" maxlength="2" disabled style="background:#e9e9e9"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>

								<table style="margin-top:15px;width:100%" border="1">
									<tr>
										<td style="width:15%;padding:5px"></td>
										<td style="width:1%;padding:5px"></td>
										<td style="width:25%;padding:5px"></td>
										<td style="width:auto;padding:5px"></td>
										<td style="width:auto;padding:5px"></td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">NO PO</td>
										<td style="padding:5px">:</td>
										<td style="padding:5px" colspan="3">
											<select class="form-control" id="fnopo" style="width:100%" autocomplete="off"></select>
										</td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">GAMATURE</td>
										<td style="padding:5px">:</td>
									</tr>
								</table>


								<button>BACK</button>
								<button>SIMPAN</button>
							</div>
						</div>
						
						<div class="list-btn-rk">
							<div class="ilist box-data-rk">BOX RK</div>
							<div class="ilist box-form-rk">BOX FORM RK</div>
						</div>

						<!-- <button disabled="disabled">PILIH :</button>
						<input type="date" name="ngirim-tgl" id="ngirim-tgl" value="<?= date('Y-m-d')?>">
						<button onclick="load_data()">CARI</button> -->
						
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
	otorisasi = $("#otorisasi").val();

	$(document).ready(function(){
		// alert(otorisasi);
		// plh_tgl = $('#ngirim-tgl').val();
		$('.list-pl').html('').hide();
		$(".plh-opsi-plrk").hide();
		$(".list-btn-pl").hide();
		$(".list-btn-rk").hide();
		kosong();
		load_po('');

		if(otorisasi == 'all' || otorisasi == 'admin'){
			$(".plh-opsi-plrk").show();
			$("#btn-opsi-pl").show();
			$("#btn-opsi-rk").show();
		}else if(otorisasi == 'qc' || otorisasi == 'fg'){
			$(".plh-opsi-plrk").show();
			$("#btn-opsi-pl").hide();
		}else{
			$(".plh-opsi-plrk").hide();
		}

		// load_data(plh_tgl)else{};
	});

	//

	function load_pt() {
		$('#fnopo').val("");

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
	$('#fkepada').on('change', function() {
		data = $('#fkepada').select2('data');
		$("#fid").val(data[0].id);
		$("#fnama").val(data[0].pimpinan);
		$("#falamat").val(data[0].alamat);
		$("#ftelp").val(data[0].no_telp);
		load_po(data[0].id);
	});

	function load_po(fid) {
		// fid = $("#fid").val();
		// alert(fid);
		$('#fnopo').select2({
			allowClear: true,
			placeholder: '- - SELECT - -',
			ajax: {
				dataType: 'json',
				url: '<?php echo base_url(); ?>/Master/loadPlPO',
				delay: 800,
				data: function(params) {
					if (params.term == undefined) {
						return {
							search: "",
							fid: fid,
						}
					} else {
						return {
							search: params.term,
							fid: fid,
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
	$('#fnopo').on('change', function() {
		data = $('#fnopo').select2('data');
		plhPlGsm(data[0].id_po,data[0].nm_ker,data[0].g_label)
		// $("#fid").val(data[0].id);
		// $("#fnama").val(data[0].pimpinan);
		// $("#falamat").val(data[0].alamat);
		// $("#ftelp").val(data[0].no_telp);
	});

	function plhPlGsm(){
// 
	}

	//

	function kosong(){ // reset id_pl
		$(".box-data-pl").show();
		$(".box-form-pl").hide();
		$("#v-id-pl").val('');
		$("#v-opl").val('');
		$("#v-tgl-pl").val('');
		$("#v-ii").val('');

		$("#fid").val("");
		$("#fnama").val("");
		$("#falamat").val("");
		$("#ftelp").val("");

		$('#fkepada').val("");
		load_pt();
		$('#fnopo').val("");
		load_po();
		getThnBlnRoll();
	}

	function pilih_opsi(plrk){
		if(plrk == 'pl'){
			$(".list-btn-pl").show();
			$(".list-btn-rk").hide();
		}else{
			$(".list-btn-pl").hide();
			$(".list-btn-rk").show();
		}
	}

	function btnAdd(){
		kosong();
		getThnBlnRoll();
		$(".box-data-pl").hide();
		$(".box-form-pl").show();
	}

	function getThnBlnRoll() {
		let num = new Date().getFullYear();
		let text = num.toString();
		let tahun = text.substr(2, 2);

		let bulan;
		switch (new Date().getMonth()) {
			case 0:
				bulan = "I";
				break;
			case 1:
				bulan = "II";
				break;
			case 2:
				bulan = "III";
				break;
			case 3:
				bulan = "IV";
				break;
			case 4:
				bulan = "V";
				break;
			case 5:
				bulan = "VI";
				break;
			case 6:
				bulan = "VII";
				break;
			case 7:
				bulan = "VIII";
				break;
			case 8:
				bulan = "IX";
				break;
			case 9:
				bulan = "X";
				break;
			case 10:
				bulan = "XI";
				break;
			case 11:
				bulan = "XII";
				break;
			default:
				bulan = "";
		}

		$("#ftahun").val(tahun);
		$("#fsotahun").val(tahun);
		$("#ftahun-pkb").val(tahun);

		$("#fbulan").val(bulan);
		$("#fsobulan").val(bulan);
	}

	function load_data(tgl){
		kosong();
		tgl = $("#ngirim-tgl").val();
		$(".list-pl").show().html('<div class="notfon">SEDANG MEMUAT . . .</div>');
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
					$(".list-pl").show().html('<div class="notfon">DATA TIDAK DITEMUKAN</div>');
				}
			}
		});
	}

	function btnRencana(id_pl,opl,tgl_pl,i){ // KLIK PROSES
		kosong();
		$("#v-id-pl").val(id_pl);
		$("#v-opl").val(opl);
		$("#v-tgl-pl").val(tgl_pl);
		$("#v-ii").val(i);
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
					hasilInputSementara(id_pl,i);
				}else{
					$(".t-plist-rencana-" + i).html('<div style="notfon">BELUM ADA RENCANA KIRIMAN</div>');
				}
			}
		});
	}

	function hasilInputSementara(id_pl,i) {
		// alert(id_pl)
		$(".t-plist-input-sementara-" + i).html('<div class="notfon">MEMUAT DATA</div>');
		$.ajax({
			url: '<?php echo base_url('Master/pListInputSementara')?>',
			type: "POST",
			data: ({
				id_pl: id_pl,
			}),
			success: function(response){
				if(response){
					$(".t-plist-input-sementara-" + i).html(response);
				}else{
					$(".t-plist-input-sementara-" + i).html('');
				}
			}
		});
	}

	function btnInputRoll(i,nm_ker,g_label,width,roll='',cari=''){ // KLIK JUMLAH PADA RENCARA KIRIMAN
		// alert(i+' - '+id_pl+' - '+nm_ker+' - '+g_label+' - '+width+' - '+roll+' - '+cari);
		v_id_pl = $("#v-id-pl").val();
		if(cari == ''){
			$(".t-plist-hasil-input-" + i).load("<?php echo base_url('Master/destroyCartInputRoll') ?>");
		}
		$(".t-plist-input-" + i).html('<div class="notfon">MEMUAT DATA . . .</div>');
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
	function cartInputRoll(id,roll,status,i){
		id_pl = $("#v-id-pl").val();
		// alert(id_pl);
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
				status: status,
				id_pl: id_pl,
				i: i,
			}),
			success: function(response){
				json = JSON.parse(response);
				// console.log(json);
				if(json.data){
					$(".t-plist-hasil-input-" + i).load("<?php echo base_url('Master/showCartInputRoll') ?>");
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
				// $(".t-plist-hasil-input-" + i).html(response);
				$(".t-plist-hasil-input-" + i).load("<?php echo base_url('Master/showCartInputRoll') ?>");
			}
		});
	}

	function cariRoll(i,nm_ker,g_label,width,xroll='',cari){
		// alert(i+' - '+nm_ker+' - '+g_label+' - '+width+' - '+xroll+' - '+cari);
		xroll = $('#roll').val();
		btnInputRoll(i,nm_ker,g_label,width,xroll,cari);
	}

	function simpanInputRoll(){
		// alert('simpan');
		v_id_pl = $("#v-id-pl").val();
		v_opl = $("#v-opl").val();
		v_tgl_pl = $("#v-tgl-pl").val();
		v_ii = $("#v-ii").val();
		// alert(v_opl+' - '+v_tgl_pl+' - '+v_ii);
		$.ajax({
			url: '<?php echo base_url('Master/simpanInputRoll')?>',
			type: "POST",
			success: function(response){
				// data = JSON.parse(response);
				btnRencana(v_id_pl,v_opl,v_tgl_pl,v_ii);
			}
		});
	}

</script>
