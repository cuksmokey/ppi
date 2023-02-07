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

	.txt-area-new {
		position:absolute;top:0;right:0;left:0;bottom:0;width:100%;height:100%;resize:none;background:none;margin:0;padding:5px;border:0;
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
		/* background: #eee */
		background: rgba(233, 233, 233, 0.5);
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

	.inp-abs {
		position:absolute;top:0;right:0;left:0;bottom:0;border:0;margin:0;padding:5px;text-align:center;background:none;
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

	.lbl-besar{
		text-decoration: none;
		padding: 5px;
		color:#000;
		font-weight: bold;
	}

	.lbl-besar:hover{
		color:#000;
	}

	.btn-req-lbl {
		background: #2C74B3;
		border: 1px solid #0A2647;
		border-radius: 3px;
		color: #fff;
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
	}else if($this->session->userdata('level') == "Corrugated"){
		$otorisasi = 'cor';
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

					<div class="body" style="overflow:auto;white-space:nowrap;">
						<input type="hidden" id="otorisasi" value="<?php echo $otorisasi; ?>">
						<input type="hidden" id="v-id-pt" value="">
						<input type="hidden" id="v-id-pl" value="">
						<input type="hidden" id="v-opl" value="">
						<input type="hidden" id="v-tgl-pl" value="">
						<input type="hidden" id="v-ii" value="">
						<input type="hidden" id="v-roll-cari" value="">
						<!-- <input type="text" id="v-id-pl" value=""> -->

						<div class="ilist plh-opsi-plrk" style="color:#000;font-size:12px">
							<?php if($otorisasi == 'all' || $otorisasi == 'admin'){?>
								<button id="btn-opsi-pl" onclick="pilih_opsi('pl')">PACKING LIST</button>
							<?php } ?>
							<?php if($otorisasi == 'all' || $otorisasi == 'admin' || $otorisasi == 'qc' || $otorisasi == 'fg' || $otorisasi == 'cor'){?>
								<button id="btn-opsi-rk" onclick="pilih_opsi('rk')">RENCANA KIRIM</button>
							<?php } ?>
							<?php if($otorisasi == 'all' || $otorisasi == 'admin' || $otorisasi == 'fg' || $otorisasi == 'office'){?>
								<button id="btn-opsi-lap" onclick="pilih_opsi('lap')">LAPORAN KIRIMAN</button>
							<?php } ?>
						</div>

						<div class="list-btn-pl" style="overflow:auto;white-space:nowrap;">
							<?php if($otorisasi == 'all' || $otorisasi == 'admin'){?>
							<div style="margin-top:15px;color:#000;font-size:12px"><button onclick="btnAdd()">ADD</button></div>
							<?php }?>

							<div class="ilist box-data-pl">
								<div style="color:#000;font-size:12px">
									<button disabled="disabled">PILIH :</button>
									<input type="date" id="tgl-list-pl" value="<?= date('Y-m-d')?>">
									<button onclick="load_data_pl()">CARI</button>
								</div>

								<div class="list-pl"></div>
							</div>

							<div class="ilist box-form-pl" style="overflow:auto;white-space:nowrap;">
								<!-- BOX FORM PL -->
								<div class="box-form-pl-cust">
									<table style="width:100%">
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
											<td style="padding:5px;font-weight:bold">PILIH</td>
											<td style="padding:5px">:</td>
											<td style="padding:5px" colspan="3">
												<select class="form-control" id="fkepada" style="width:100%" autocomplete="off"></select>
											</td>
										</tr>
										<tr>
											<td style="padding:5px;font-weight:bold">KEPADA</td>
											<td style="padding:5px">:</td>
											<td style="padding:5px" colspan="3">
												<input type="text" id="fnmpt" class="form-control" style="background:#e9e9e9" disabled>
												<input type="hidden" id="fid" value="">
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
								</div>

								<div class="box-form-pl-po" style="overflow:auto;white-space:nowrap;">
									<table style="margin-top:15px;width:100%">
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
											<td style="padding:5px;font-weight:bold">JENIS</td>
											<td style="padding:5px;text-align:center">:</td>
											<td style="padding:5px">
												<select id="fjenis" class="form-control" style="width:100%" autocomplete="off"></select>
											</td>
										</tr>
										<tr>
											<td style="padding:5px;font-weight:bold">GAMATURE</td>
											<td style="padding:5px">:</td>
											<td style="padding:5px">
												<!-- <div class="fplhplgsm"></div> -->
												<select id="fplhplgsm" class="form-control" style="width:100%" autocomplete="off"></select>
											</td>
											<td style="padding:5px"></td>
										</tr>
									</table>
								</div>

								<div class="cek_no_sj"></div>

								<div class="box-form-pl-no" style="overflow:auto;white-space:nowrap;">
									<table style="margin-top:15px;width:100%">
										<tr>
											<td style="width:15%;padding:5px"></td>
											<td style="width:1%;padding:5px"></td>
											<td style="width:25%;padding:5px"></td>
											<td style="width:auto;padding:5px"></td>
											<td style="width:auto;padding:5px"></td>
										</tr>
										<tr>
											<td style="padding:5px;font-weight:bold">RENCANA KIRIM</td>
											<td style="padding:5px;text-align:center">:</td>
											<td style="padding:5px">
												<input type="date" id="ftglrk" class="form-control">
											</td>
										</tr>
										<tr>
											<td style="padding:5px;font-weight:bold">KIRIM TANGGAL</td>
											<td style="padding:5px;text-align:center">:</td>
											<td style="padding:5px">
												<input type="date" id="ftgl" class="form-control">
											</td>
										</tr>
										<tr>
											<td style="padding:5px;font-weight:bold">PAJAK</td>
											<td style="padding:5px;text-align:center">:</td>
											<td style="padding:5px;text-align:center">
												<select id="fplhpajak" class="form-control" disabled style="background:#e9e9e9">
													<option value="">PILIH</option>
													<option value="ppn">PPN</option>
													<option value="non">NON PPN</option>
												</select>
											</td>
										</tr>
										<tr>
											<td style="padding:5px;font-weight:bold">NO SURAT JALAN</td>
											<td style="padding:5px;text-align:center">:</td>
											<td style="padding:5px" colspan="3">
												<table style="width:100%">
													<tr>
														<td><input type="text" id="fnosj" class="form-control" placeholder="NO" autocomplete="off" maxlength="4" onkeypress="return hanyaAngka(event)"></td>
														<td style="padding:0 5px">/</td>
														<td><input type="text" id="froll" class="form-control" placeholder="ROLL" value="ROLL" autocomplete="off" disabled style="background:#e9e9e9"></td>
														<td style="padding:0 5px">/</td>
														<td><input type="text" id="fbulan" class="form-control" placeholder="BULAN" autocomplete="off" disabled style="background:#e9e9e9"></td>
														<td style="padding:0 5px">/</td>
														<td><input type="text" id="ftahun" class="form-control" placeholder="TAHUN" autocomplete="off" disabled style="background:#e9e9e9"></td>
														<td style="padding:0 5px">/</td>
														<td><input type="text" id="fpajak" class="form-control" placeholder="PAJAK" autocomplete="off" maxlength="1" disabled style="background:#e9e9e9"></td>
														<td style="padding:0 5px">/</td>
														<td><input type="text" id="fquality" class="form-control" placeholder="JENIS" autocomplete="off" maxlength="2" disabled style="background:#e9e9e9"></td>
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
														<td><input type="text" id="fnoso" class="form-control" placeholder="NO" autocomplete="off" maxlength="4" disabled style="background:#e9e9e9"></td>
														<td style="padding:0 5px">/</td>
														<td><input type="text" id="fsoroll" class="form-control" placeholder="SO-ROLL" value="SO-ROLL" autocomplete="off" disabled style="background:#e9e9e9"></td>
														<td style="padding:0 5px">/</td>
														<td><input type="text" id="fsobulan" class="form-control" placeholder="BULAN" autocomplete="off"  disabled style="background:#e9e9e9"></td>
														<td style="padding:0 5px">/</td>
														<td><input type="text" id="fsotahun" class="form-control" placeholder="TAHUN" autocomplete="off" disabled style="background:#e9e9e9"></td>
														<td style="padding:0 5px">/</td>
														<td><input type="text" id="fsopajak" class="form-control" placeholder="PAJAK" autocomplete="off" maxlength="1" disabled style="background:#e9e9e9"></td>
														<td style="padding:0 5px">/</td>
														<td><input type="text" id="fsoquality" class="form-control" placeholder="JENIS" autocomplete="off" maxlength="2" disabled style="background:#e9e9e9"></td>
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
														<td><input type="text" id="fnopkb" class="form-control" placeholder="NO" autocomplete="off" maxlength="4" disabled style="background:#e9e9e9"></td>
														<td style="padding:0 5px">/</td>
														<td><input type="text" id="ftahun-pkb" class="form-control" placeholder="TAHUN" autocomplete="off" disabled style="background:#e9e9e9"></td>
														<td style="padding:0 5px">/</td>
														<td><input type="text" id="fjns-pkb" class="form-control" placeholder="JENIS" autocomplete="off" maxlength="2" disabled style="background:#e9e9e9"></td>
													</tr>
												</table>
											</td>
											<td style="padding:5px;text-align:right" colspan="2">
												<button onclick="addCartPl('cart')">ADD</button>
											</td>
										</tr>
									</table>
								</div>

								<div class="show-add-cart-pl" style="overflow:auto;white-space:nowrap;"></div>

								<div class="show-edit-cart-pl" style="overflow:auto;white-space:nowrap;"></div>

								<div style="overflow:auto;white-space:nowrap;">
									<table style="margin:15px 0 0;padding:0;width:100%;">
									<tr>
										<td style="padding:2px;width:15%"></td>
										<td style="padding:2px;width:1%"></td>
										<td style="padding:2px;width:34%"></td>
										<td style="padding:2px;width:50%"></td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">PILIH</td>
										<td style="padding:5px;font-weight:bold">:</td>
										<td style="padding:5px">
											<select class="form-control" id="plnopol" style="width:100%" autocomplete="off"></select>
										</td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">NOPOL</td>
										<td style="padding:5px;font-weight:bold">:</td>
										<td style="padding:5px">
											<input type="text" id="txtnopol" class="form-control" style="background:#e9e9e9" disabled>
										</td>
										<td style="padding:5px"></td>
									</tr>
									</table>
								</div>

								<button onclick="btnBack()" style="margin-top:15px">BACK</button>
								<button onclick="addPlNopol()" class="btn-add-nopol" style="display:none;">EDIT NOPOL</button>
							</div>
						</div>
						
						<div class="list-btn-rk" style="overflow:auto;white-space:nowrap;">
							<?php if($otorisasi == 'all' || $otorisasi == 'admin' || $otorisasi == 'fg'){?>
							<div style="margin-top:15px;color:#000;font-size:12px"><button onclick="btnAddrk()">ADD</button></div>
							<?php }?>

							<!-- <div class="ilist box-data-rk">BOX RK</div> -->
							<div class="ilist box-data-rk" style="overflow:auto;white-space:nowrap;">
								<div style="color:#000;font-size:12px">
									<button disabled="disabled">PILIH :</button>
									<input type="date" id="tgl-list-rk" value="<?= date('Y-m-d')?>">
									<button onclick="load_data()">CARI</button>
								</div>

								<div style="margin-top:15px" class="list-rk"></div>
							</div>

							<div class="ilist box-form-rk" style="overflow:auto;white-space:nowrap;">
								<table style="width:100%">
									<tr>
										<td style="width:15%;padding:5px"></td>
										<td style="width:1%;padding:5px"></td>
										<td style="width:10%;padding:5px"></td>
										<td style="width:5%;padding:5px"></td>
										<td style="width:auto;padding:5px"></td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">RENCANA KIRIM</td>
										<td style="padding:5px">:</td>
										<td style="padding:5px" colspan="2">
											<input type="date" id="rktgl" class="form-control">
										</td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">PACKING LIST</td>
										<td style="padding:5px">:</td>
										<td style="padding:5px" colspan="3">
											<select id="rkpl" class="form-control" style="width:100%"></select>
										</td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">PO</td>
										<td style="padding:5px">:</td>
										<td style="padding:5px" colspan="3">
											<select id="rkpo" class="form-control" style="width:100%"></select>
										</td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">JENIS</td>
										<td style="padding:5px">:</td>
										<td style="padding:5px" colspan="3">
											<select id="rkjenis" class="form-control" style="width:100%"></select>
										</td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">GRAMATURE</td>
										<td style="padding:5px">:</td>
										<td style="padding:5px" colspan="3">
											<select id="rkglabel" class="form-control" style="width:100%"></select>
										</td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">UKURAN</td>
										<td style="padding:5px">:</td>
										<td style="padding:5px" colspan="3">
											<select id="rkukuran" class="form-control" style="width:100%"></select>
										</td>
									</tr>
									<tr>
										<td style="padding:5px;font-weight:bold">JUMLAH ROLL</td>
										<td style="padding:5px">:</td>
										<td style="padding:5px">
											<input type="text" id="rkjmlroll" class="form-control">
										</td>
										<td style="padding:5px">
											<button onclick="addCartRk()">ADD</button>
										</td>
									</tr>
								</table>

								<div class="show-cart-rk" style="margin-top:15px"></div>
								
								<div class="show-list-edit-rk" style="margin-top:15px"></div>

								<button onclick="btnBackRk()" style="margin-top:15px">BACK</button>
							</div>
						</div>

						<div class="list-btn-lap" style="overflow:auto;white-space:nowrap;">
							<div class="ilist box-data-lap" style="color:#000;font-size:12px">
								<button disabled="disabled">PILIH :</button>
								<input type="date" id="tgl-list-lap" value="<?= date('Y-m-d')?>">
								s/d
								<input type="date" id="tgl-list-lap2" value="<?= date('Y-m-d')?>">
								<button onclick="load_data_lap()">CARI</button>

								<div style="margin-top:15px" class="list-lap"></div>
							</div>
						</div>
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

<div class="modal fade bd-example-modal-lg" id="modal-lap-kiriman" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" >
			<div class="modal-header"></div>
			<div class="modal-body" style="overflow:auto;white-space:nowrap;">
				<div class="isi-lap-kiriman"></div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<script>
	otorisasi = $("#otorisasi").val();
	option = '';
	pilihbtnrencana = '';

	$(document).ready(function(){
		// alert(otorisasi);
		// plh_tgl = $('#ngirim-tgl').val();
		$('.list-rk').html('').hide();
		$(".plh-opsi-plrk").hide();
		$(".list-btn-pl").hide();
		$(".list-btn-rk").hide();
		$(".list-btn-lap").hide();

		$(".box-form-rk").hide();
		// kosong();
		// rkkosong();

		if(otorisasi == 'all' || otorisasi == 'admin' || otorisasi == 'office'){
			$(".plh-opsi-plrk").show();
			$("#btn-opsi-pl").show();
			$("#btn-opsi-rk").show();
			$("#btn-opsi-lap").show();
		}else if(otorisasi == 'qc' || otorisasi == 'cor'){
			$(".plh-opsi-plrk").show();
			$("#btn-opsi-pl").hide();
			$("#btn-opsi-lap").hide();
		}else if(otorisasi == 'fg'){
			$(".plh-opsi-plrk").show();
			$("#btn-opsi-lap").show();
			$("#btn-opsi-pl").hide();
		}else{
			$(".plh-opsi-plrk").hide();
		}

		$(".show-add-cart-pl").load("<?php echo base_url('Master/dessCartPl') ?>");
		$(".show-cart-rk").load("<?php echo base_url('Master/dessCartRk') ?>");
	});

	function pilih_opsi(plrk){
		if(plrk == 'pl'){
			$(".list-btn-pl").show();
			$(".list-btn-rk").hide();
			$(".list-btn-lap").hide();
			$(".box-data-pl").show();
			$(".box-form-pl").hide();
			kosong();
		}else if(plrk == 'rk'){
			$(".list-btn-pl").hide();
			$(".list-btn-rk").show();
			$(".list-btn-lap").hide();
			$(".box-data-rk").show();
			$(".box-form-rk").hide();
			rkkosong();
		}else{
			$(".list-btn-pl").hide();
			$(".list-btn-rk").hide();
			$(".list-btn-lap").show();
			$(".box-data-lap").show();
			// rkkosong();
			$(".list-lap").hide();
		}
	}

	// LAPORAN PENGIRIMAN

	function load_data_lap(){
		tgl1 = $("#tgl-list-lap").val();
		tgl2 = $("#tgl-list-lap2").val();
		// alert(tgl1+' - '+tgl2);
		if(tgl1 == '' || tgl2 == ''){
			swal("HARAP PILIH TANGGAL!", "", "error");
			return;
		}

		$(".list-lap").show().html('MEMUAT DATA . . .');
		$.ajax({
			url: '<?php echo base_url('Master/LoadLaporanPengiriman')?>',
			type: "POST",
			data: ({
				tgl1, tgl2
			}),
			success: function(res){
				$(".list-lap").html(res);
			}
		})
	}

	function cekLapKiriman(tgl,idpt,idex){
		// $(".modal-body").html('');
		$(".isi-lap-kiriman").html('MEMUAT DATA . . .');
		$("#modal-lap-kiriman").modal("show");
		$.ajax({
			url: '<?php echo base_url('Master/cekLapKiriman')?>',
			type: "POST",
			data: ({
				tgl,idpt,idex
			}),
			success: function(res){
				$(".isi-lap-kiriman").html(res);
			}
		})
	}

	//

	function load_pt() {
		$('#fnopo').val("").prop("disabled", true);
		load_po('');
		$('#fjenis').val("").prop("disabled", true);
		plhPlPoJns('');
		$('#fplhplgsm').val("").prop("disabled", true);
		plhPlGsm('');
		$('#fkepada').select2({
			allowClear: true,
			placeholder: '- - SELECT - -',
			ajax: {
				dataType: 'json',
				url: '<?php echo base_url(); ?>/Master/loadPtPO',
				data: function(params) {
					if (params.term == undefined) {
						return {
							search: "",
							opsi: "pl"
						}
					} else {
						return {
							search: params.term,
							opsi: "pl"
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
		$("#fnmpt").val(data[0].nm_perusahaan);
		$("#fnama").val(data[0].pimpinan);
		$("#falamat").val(data[0].alamat);
		$("#ftelp").val(data[0].no_telp);

		$('#fnopo').val("");
		load_po(data[0].id);
		$('#fjenis').val("").prop("disabled", true);
		plhPlPoJns('');
		$('#fplhplgsm').val("").prop("disabled", true);
		plhPlGsm('');
		
		$('#fnopo').prop("disabled", false);
	});

	function load_po(fid) {
		$('#fnopo').select2({
			allowClear: true,
			placeholder: '- - SELECT - -',
			ajax: {
				dataType: 'json',
				url: '<?php echo base_url(); ?>/Master/loadPlPO',
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

		$("#fnosj").val("");
		$("#fnoso").val("");
		$("#fnopkb").val("");
		opsiPajak(data[0].id)

		$('#fjenis').val("");
		plhPlPoJns(data[0].id);
		
		$('#fjenis').prop("disabled", false);
		$('#fplhplgsm').val("").prop("disabled", true);
		plhPlGsm('');
	});

	// function plhPlPoJns(id_po,no_po){
	function plhPlPoJns(idpo_nopo){
		$('#fjenis').select2({
			allowClear: true,
			placeholder: '- - SELECT - -',
			ajax: {
				dataType: 'json',
				url: '<?php echo base_url(); ?>/Master/loadPlJns',
				data: function(params) {
					if (params.term == undefined) {
						return {
							search: "",
							idpo_nopo: idpo_nopo,
						}
					} else {
						return {
							search: params.term,
							idpo_nopo: idpo_nopo,
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
	$('#fjenis').on('change', function() {
		data = $('#fjenis').select2('data');

		$("#fnosj").val("");
		$("#fnoso").val("");
		$("#fnopkb").val("");
		
		$('#fplhplgsm').val("");
		plhPlGsm('');
		plhPlGsm(data[0].id);

		$('#fplhplgsm').prop("disabled", false);

		csjfjenis = $('#fjenis').val();
		cek_no_sj(csjfjenis);
		loadNmKerSj(data[0].id);
	});

	function opsiPajak(id){
		// alert(id);
		$.ajax({
			url: '<?php echo base_url('Master/opsiPajak')?>',
			type: "POST",
			data: ({
				id: id,
			}),
			success: function(json){
				data = JSON.parse(json);
				if(data.pajak == 'ppn'){
					ppnornon = 'A';
				}else if(data.pajak == 'non'){
					ppnornon = 'B';
				}else{
					ppnornon = '';
				}
				$('#fplhpajak').val(data.pajak);
				$("#fpajak").val(ppnornon);
				$("#fsopajak").val(ppnornon);
			}
		})
	}

	$('#ftgl').on('change', function() { // OPSI PAJAK
		ftgl = $("#ftgl").val();
		getThnBlnRoll(ftgl);

		csjfjenis = $('#fjenis').val();
		// csjfjenis = $('#fnopo').val();
		cek_no_sj(csjfjenis);
	});

	function cek_no_sj(id){
		// alert(id);
		csjftgl = $('#ftgl').val();
		csjfplhpajak = $('#fplhpajak').val();
		// alert(id+' - '+csjftgl+' - '+csjfplhpajak);
		$(".cek_no_sj").html('. . .');
		$.ajax({
			url: '<?php echo base_url('Master/cek_no_sj')?>',
			type: "POST",
			data: ({
				id: id,
				tgl: csjftgl,
				pjk: csjfplhpajak,
			}),
			success: function(data){
				// console.log(data)
				$(".cek_no_sj").html(data);
			}
		})
	}

	function loadNmKerSj(id){
		$.ajax({
			url: '<?php echo base_url('Master/loadNmKerSj')?>',
			type: "POST",
			data: ({
				id: id
			}),
			success: function(response){
				data = JSON.parse(response)
				$("#fquality").val(data.nm_ker);
				$("#fsoquality").val(data.nm_ker);
				$("#fjns-pkb").val(data.nm_ker);
			}
		})
	}

	function plhPlGsm(idpo_nopo_nmker){
		$('#fplhplgsm').select2({
			allowClear: true,
			placeholder: '- - SELECT - -',
			ajax: {
				dataType: 'json',
				url: '<?php echo base_url(); ?>/Master/loadPlPlhGsm',
				data: function(params) {
					if (params.term == undefined) {
						return {
							search: "",
							idpo_nopo_nmker: idpo_nopo_nmker,
						}
					} else {
						return {
							search: params.term,
							idpo_nopo_nmker: idpo_nopo_nmker,
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

	//

	function load_nopol() {
		$('#plnopol').select2({
			allowClear: true,
			placeholder: '- - SELECT - -',
			ajax: {
				dataType: 'json',
				url: '<?php echo base_url(); ?>/Master/loadPlNopol',
				data: function(params) {
					if (params.term == undefined) {
						return {
							search: "",
						}
					} else {
						return {
							search: params.term,
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
	$('#plnopol').on('change', function() {
		data = $('#plnopol').select2('data');
		// alert(data[0].id);
		// $("#plnopol").val(data[0].id);
		nopoll = data[0].id.split("_ex_");
		$("#txtnopol").val(nopoll[1]+' - '+nopoll[2]);
	});

	//

	function kosong(){ // reset id_pl
		$(".box-data-pl").show();
		$(".box-form-pl").hide();
		$("#v-id-pt").val('');
		$("#v-id-pl").val('');
		$("#v-opl").val('');
		$("#v-tgl-pl").val('');
		$("#v-ii").val('');

		$("#fid").val("");
		$("#fnmpt").val("");
		$("#fnama").val("");
		$("#falamat").val("");
		$("#ftelp").val("");

		$("#fnosj").val("");
		$("#fnoso").val("");
		$("#fnopkb").val("");
		$('#ftglrk').val("").prop("disabled", false).removeAttr('style');
		$('#ftgl').val("").prop("disabled", false).removeAttr('style');
		$('#fplhpajak').val("");
		$("#fquality").val("");
		$("#fsoquality").val("");
		$("#fjns-pkb").val("");

		$('#fkepada').val("");
		load_pt();
		$('#fnopo').val("");
		load_po('');
		$('#fjenis').val("");
		plhPlPoJns('');
		$("#fplhplgsm").val("");
		plhPlGsm('');
		$(".show-add-cart-pl").load("<?php echo base_url('Master/dessCartPl') ?>");

		pilihbtnrencana = 'pl';
		load_data_pl();
		
		$(".cek_no_sj").html('');
		$(".show-edit-cart-pl").html('');
		pl = 'simpan';
		vopl = '';

		load_nopol();
		$('#plnopol').val("");
		$("#txtnopol").val("");
		$(".btn-add-nopol").hide();
	}

	function btnAdd(){
		kosong();
		// tglpl = $("#tgl-list-pl").val();
		// getThnBlnRoll();
		// load_data_pl();
		$(".box-data-pl").hide();
		$(".box-form-pl").show();
		$(".box-form-pl-cust").show();
	}

	function btnBack(){
		kosong();
		$(".box-data-pl").show();
		$(".box-form-pl").hide();
	}

	function getThnBlnRoll(ftgl) {
		// let num = new Date().getFullYear();
		let num = ftgl;
		let text = num.toString();
		let tahun = text.substr(2, 2);
		let bulan = text.substr(5, 2);
		// alert(text+' - '+tahun+' - '+bulan);

		// let bulan;
		switch (bulan) {
			case '01':
				bulan = "I";
				break;
			case '02':
				bulan = "II";
				break;
			case '03':
				bulan = "III";
				break;
			case '04':
				bulan = "IV";
				break;
			case '05':
				bulan = "V";
				break;
			case '06':
				bulan = "VI";
				break;
			case '07':
				bulan = "VII";
				break;
			case '08':
				bulan = "VIII";
				break;
			case '09':
				bulan = "IX";
				break;
			case '10':
				bulan = "X";
				break;
			case '11':
				bulan = "XI";
				break;
			case '12':
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

	$("#fnosj").keyup(function(){
		$("#fnoso").val(this.value);
		$("#fnopkb").val(this.value);
	})

	function load_data_pl(){
		// alert('list pl');
		tglpl = $("#tgl-list-pl").val();
		$(".list-pl").html('<div style="color:#000;padding-top:10px">SEDANG MEMUAT . . .</div>');
		$.ajax({
			url: '<?php echo base_url('Master/load_pl')?>',
			type: "POST",
			data: ({
				tglpl: tglpl,
				pilihbtnrencana,
				otorisasi
			}),
			success: function(response){
				// $("#show-list-pl").html(response)
				$(".list-pl").html(response);
			}
		});
	}

	function editPL(idpt,tglpl,opl,i){
		// alert(idpt+' - '+tglpl+' - '+opl+' - '+i);
		$(".id-cek").html('');
		$(".box-data-pl").hide();
		$(".box-form-pl").show();
		$('#fnopo').val("").prop("disabled", true);
		load_po('');
		$('#fjenis').val("").prop("disabled", true);
		plhPlPoJns('');
		$('#fplhplgsm').val("").prop("disabled", true);
		plhPlGsm('');
		$.ajax({
			url: '<?php echo base_url('Master/editPL')?>',
			type: "POST",
			data: ({
				idpt: idpt,
				tglpl: tglpl,
				opl: opl,
				i: i,
			}),
			success: function(json){
				data = JSON.parse(json);
				$(".box-form-pl-cust").hide();
				$(".box-form-pl-po").show();
				$(".box-form-pl-no").show();
				$('#fnopo').prop("disabled", false);
				$("#fkepada").val(data.cust);
				$("#fnmpt").val(data.fnmpt);
				$("#fnama").val(data.fnama);
				$("#falamat").val(data.falamat);
				$("#ftelp").val(data.ftelp);
				$("#ftglrk").val(data.ftglrk).prop("disabled", true).attr('style', 'background:#e9e9e9');
				$("#ftgl").val(data.ftgl).prop("disabled", true).attr('style', 'background:#e9e9e9');
				
				getThnBlnRoll(data.ftgl);
				load_po(data.cust);

				pl = 'edit';
				vopl = data.opl;
				showEditPl(idpt,tglpl,opl,i);

				$(".btn-add-nopol").show();
				$("#v-id-pl").val(data.fidrk);
				$("#v-id-pt").val(idpt);
				$("#v-opl").val(opl);
				$("#v-tgl-pl").val(tglpl);
				$("#v-ii").val(i);

				load_nopol();
				$('#plnopol').val("");
				$("#txtnopol").val(data.fidexpd);
			}
		})
	}

	function hapusPL(idpt,idrk,tglpl,opl,i){
		// alert(idpt+' - '+tglpl+' - '+opl+' - '+i);
		swal({
			title: "Apakah Anda Yakin ?",
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
					url: '<?php echo base_url('Master/hapusPL')?>',
					type: "POST",
					data:({
						idpt,idrk,tglpl,opl
					}),
					success: function(json){
						data = JSON.parse(json)
						if(data.res){
							swal(data.msg, "", "success");
							// kosong();
							load_data_pl();
						}
					}
				});
			}else{
				swal("BATAL DIHAPUS!", "", "error");
			}
		});
	}

	function showEditPl(idpt,tglpl,opl,i){
		// alert(idpt+' - '+tglpl+' - '+opl+' - '+i);
		$.ajax({
			url: '<?php echo base_url('Master/showEditPl')?>',
			type: "POST",
			data: ({
				idpt,tglpl,opl,i
			}),
			success: function(data){
				$(".show-edit-cart-pl").html(data);
			}
		})
	}

	function showEditPlHapus(idpt,tglpl,opl,i,id_rk,nm_ker,g_label,idpl){
		// alert(idpt+' - '+tglpl+' - '+opl+' - '+i+' - '+id_rk+' - '+idpl);
		$.ajax({
			url: '<?php echo base_url('Master/showEditPlHapus')?>',
			type: "POST",
			data: ({
				idpt,tglpl,opl,i,id_rk,nm_ker,g_label,idpl
			}),
			success: function(json){
				data = JSON.parse(json);
				if(data.res){
					swal(data.msg, "", data.info);
					editPL(idpt,tglpl,opl,i)
				}
			}
		})
	}

	function addPlNopol(){
		fnopol = $('#plnopol').val();
		fvidrk = $("#v-id-pl").val();
		fvidpt = $("#v-id-pt").val();
		fvopl = $("#v-opl").val();
		fvtglpl = $("#v-tgl-pl").val();
		fvii = $("#v-ii").val();
		// alert(fnopol+' - '+fvidrk+' - '+fvidpt+' - '+fvtglpl+' - '+fvopl+' - '+fvii);
		if(fnopol == '' || fnopol == undefined){
			swal("NOPOL TIDAK BOLEH KOSONG", "", "error");
			return;
		}

		if(fvidrk == ''){
			swal("CEK DULU BARU BISA TAMBAH NOPOL!", "", "error");
			return;
		}

		$.ajax({
			url: '<?php echo base_url('Master/addPlNopol')?>',
			type: "POST",
			data: ({
				fnopol,fvidrk,fvidpt,fvopl,fvtglpl,fvii
			}),
			success: function(json){
				data = JSON.parse(json);
				if(data.res){
					swal(data.msg, "", data.info);
					editPL(fvidpt,fvtglpl,fvopl,fvii);
				}
			}
		})
	}

	function addCartPl(opsi){
		// alert(pl);
		fkepada = $("#fkepada").val(); // id_pt
		fnmpt = $("#fnmpt").val();
		fnama = $("#fnama").val();
		falamat = $("#falamat").val();
		ftelp = $("#ftelp").val();
		// alert(fid+' - '+fkepada+' - '+fnmpt+' - '+fnama+' - '+falamat+' - '+ftelp);

		ftglrk = $("#ftglrk").val();
		ftgl = $("#ftgl").val();
		fplhpajak = $("#fplhpajak").val();
		// alert(ftgl+' - '+fplhpajak);

		fnosj = $("#fnosj").val();
		froll = $("#froll").val();
		fbulan = $("#fbulan").val();
		ftahun = $("#ftahun").val();
		fpajak = $("#fpajak").val();
		fquality = $("#fquality").val();
		noSJ = fnosj+'/'+froll+'/'+fbulan+'/'+ftahun+'/'+fpajak+'/'+fquality;
		// alert(fnosj+' - '+froll+' - '+fbulan+' - '+ftahun+' - '+fpajak+' - '+fquality);

		fnoso = $("#fnoso").val();
		fsoroll = $("#fsoroll").val();
		fsobulan = $("#fsobulan").val();
		fsotahun = $("#fsotahun").val();
		fsopajak = $("#fsopajak").val();
		fsoquality = $("#fsoquality").val();
		noSOSJ = fnoso+'/'+fsoroll+'/'+fsobulan+'/'+fsotahun+'/'+fsopajak+'/'+fsoquality;
		// alert(fnoso+' - '+fsoroll+' - '+fsobulan+' - '+fsotahun+' - '+fsopajak+' - '+fsoquality);

		fnopkb = $("#fnopkb").val();
		ftahunpkb = $("#ftahun-pkb").val();
		fjnspkb = $("#fjns-pkb").val();
		noPKB = fnopkb+'/'+ftahunpkb+'/'+fjnspkb;
		// alert(fnopkb+' - '+ftahunpkb+' - '+fjnspkb);

		fnopo = $("#fnopo").val();
		fjenis = $("#fjenis").val();
		fplhplgsm = $("#fplhplgsm").val();
		// alert(fnopo+' - '+fjenis+' - '+fplhplgsm+' - '+noSJ);

		if(pl == 'simpan'){
			if(fkepada == '' || fnmpt == '' || fnama == '' || falamat == '' || ftelp == ''){
				swal("HARAP PILIH CUSTOMER!", "", "error");
				return;
			}
		}
		
		if(ftglrk == '' || ftgl == '' || fplhpajak == ''){
			swal("HARAP LENGKAPI TGL KIRIM / RENCANA KIRIM / PILIH PAJAK!", "", "error");
			return;
		}

		if(fnopo == '' || fjenis == '' || fplhplgsm == '' || fnopo == null || fjenis == null || fplhplgsm == null || fnopo == undefined || fjenis == undefined || fplhplgsm == undefined){
			swal("HARAP LENGKAPI NO PO / JENIS / GRAMATURE", "", "error");
			return;
		}

		if(fnosj == '' || froll == '' || fbulan == '' || ftahun == '' || fpajak == '' || fquality == '' || fnoso == '' || fsoroll == '' || fsobulan == ''  || fsotahun == '' || fsopajak == '' || fsoquality == '' || fnopkb == '' || ftahunpkb == '' || fjnspkb == '') {
			swal("HARAP LENGKAPI NO SURAT!", "", "error");
			return;
		}

		if(fnosj.toString().length < 3){
			swal("NOMER SURAT JALAN MINIMAL 3 DIGIT!", "", "error");
			return;
		}

		$.ajax({
			url: '<?php echo base_url('Master/addCartPl')?>',
			type: "POST",
			data: ({
				fkepada: fkepada,
				fnmpt: fnmpt,
				fnama: fnama,
				falamat: falamat,
				ftelp: ftelp,
				ftglrk: ftglrk,
				ftgl: ftgl,
				fplhpajak: fplhpajak,
				noSJ: noSJ,
				noSOSJ: noSOSJ,
				noPKB: noPKB,
				fnopkb: fnopkb,
				ftahunpkb: ftahunpkb,
				fjnspkb: fjnspkb,
				fnopo: fnopo,
				fjenis: fjenis,
				fplhplgsm: fplhplgsm,
				pilihan: opsi,
				pl: pl,
				opl: vopl,
			}),
			success: function(response){
				json = JSON.parse(response);
				if(json.data == 'cart'){
					if(json.opsi){
						$(".show-add-cart-pl").load("<?php echo base_url('Master/showCartPl') ?>");
						// swal(json.msg, "", "success");
					}else{
						swal(json.msg, "", "error");
					}
				}else{ // simpan
					if(json.opsi){
						swal(json.msg, "", "success");
						kosong();
					}else{
						swal(json.msg, "", "error");
					}
				}
			}
		});
	}

	function hapusCartPl(rowid){
		$.ajax({
			url: '<?php echo base_url('Master/hapusCartPl')?>',
			type: "POST",
			data: ({
				rowid: rowid,
			}),
			success: function(response) {
				$(".show-add-cart-pl").load("<?php echo base_url('Master/showCartPl') ?>");
			}
		})
	}

	///////////////////////////////////////////////////////////////////////////////////////
	// RENCANA KIRIM

	function btnAddrk(){
		rkkosong();
		$(".box-data-rk").hide();
		$(".box-form-rk").show();
		$('#rkpl').val("").prop('disabled', true);
		load_rkpl();
		$('#rkpo').val("").prop('disabled', true);
		load_rkpo();
		$('#rkjenis').val("").prop('disabled', true);
		load_rkjns();
		$('#rkglabel').val("").prop('disabled', true);
		load_rkgsm();
		$("#rkukuran").val("").prop('disabled', true);
		load_rkuk();

		$("#rkjmlroll").val("").prop('disabled', true).attr('style', 'background:#e9e9e9');
	}

	function btnBackRk(){
		rkkosong();
		$(".box-data-rk").show();
		$(".box-form-rk").hide();
	}

	function rkkosong(){
		$("#v-id-pl").val('');
		$("#v-opl").val('');
		$("#v-tgl-pl").val('');
		$("#v-ii").val('');

		$("#rktgl").val("").prop('disabled', false);
		$("#rkpl").val("");
		$("#rkpo").val("");
		$("#rkjenis").val("");
		$("#rkglabel").val("");
		$("#rkukuran").val("");
		$("#rkjmlroll").val("");

		$(".box-data-rk").show();
		$(".box-form-rk").hide();
		$(".show-cart-rk").load("<?php echo base_url('Master/dessCartRk') ?>");

		pilihbtnrencana = 'rk';
		tgl = $("#tgl-list-rk").val();
		load_data(tgl);

		$(".show-list-edit-rk").html('');
		option = 'insert';
	}

	// 

	$('#rktgl').on('change', function() {
		$('#rkpl').val("").prop('disabled', false);
		$('#rkpo').val("").prop('disabled', true);
		load_rkpo();
		$('#rkjenis').val("").prop('disabled', true);
		load_rkjns();
		$('#rkglabel').val("").prop('disabled', true);
		load_rkgsm();
		$('#rkukuran').val("").prop('disabled', true);
		load_rkuk();
		$("#rkjmlroll").val("").prop('disabled', true).attr('style', 'background:#e9e9e9');
		rktgl = $("#rktgl").val();
		load_rkpl(rktgl);
	});

	function load_rkpl(rktgl) {
		$('#rkpl').select2({
			allowClear: true,
			placeholder: '- - SELECT - -',
			ajax: {
				dataType: 'json',
				url: '<?php echo base_url(); ?>/Master/loadRkPl',
				data: function(params) {
					if (params.term == undefined) {
						return {
							search: "",
							rktgl: rktgl,
						}
					} else {
						return {
							search: params.term,
							rktgl: rktgl,
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
	$('#rkpl').on('change', function() {
		data = $('#rkpl').select2('data');

		$('#rkpo').val("").prop('disabled', false);
		load_rkpo(data[0].id);
		$('#rkjenis').val("").prop('disabled', true);
		load_rkjns();
		$('#rkglabel').val("").prop('disabled', true);
		load_rkgsm();
		$('#rkukuran').val("").prop('disabled', true);
		load_rkuk();

		$("#rkjmlroll").val("").prop('disabled', true).attr('style', 'background:#e9e9e9');
	});

	function load_rkpo(opl_tglpl) {
		$('#rkpo').select2({
			allowClear: true,
			placeholder: '- - SELECT - -',
			ajax: {
				dataType: 'json',
				url: '<?php echo base_url(); ?>/Master/loadRkPo',
				data: function(params) {
					if (params.term == undefined) {
						return {
							search: "",
							opl_tglpl: opl_tglpl,
						}
					} else {
						return {
							search: params.term,
							opl_tglpl: opl_tglpl,
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
	$('#rkpo').on('change', function() {
		data = $('#rkpo').select2('data');

		$('#rkjenis').val("").prop('disabled', false);
		load_rkjns(data[0].id);
		$('#rkglabel').val("").prop('disabled', true);
		load_rkgsm();
		$("#rkukuran").val("").prop('disabled', true);
		load_rkuk();

		$("#rkjmlroll").val("").prop('disabled', true).attr('style', 'background:#e9e9e9');
		// rkpo rkjenis rkglabel rkukuran
	});

	function load_rkjns(opl_tglpl_nopo) {
		$('#rkjenis').select2({
			allowClear: true,
			placeholder: '- - SELECT - -',
			ajax: {
				dataType: 'json',
				url: '<?php echo base_url(); ?>/Master/loadRkJns',
				data: function(params) {
					if (params.term == undefined) {
						return {
							search: "",
							opl_tglpl_nopo: opl_tglpl_nopo,
						}
					} else {
						return {
							search: params.term,
							opl_tglpl_nopo: opl_tglpl_nopo,
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
	$('#rkjenis').on('change', function() {
		data = $('#rkjenis').select2('data');

		$('#rkglabel').val("").prop('disabled', false);
		load_rkgsm(data[0].id);
		$("#rkukuran").val("").prop('disabled', true);
		load_rkuk();

		$("#rkjmlroll").val("").prop('disabled', true).attr('style', 'background:#e9e9e9');
		// rkpo rkjenis rkglabel rkukuran
	});

	function load_rkgsm(opl_tglpl_nopo_nmker) {
		$('#rkglabel').select2({
			allowClear: true,
			placeholder: '- - SELECT - -',
			ajax: {
				dataType: 'json',
				url: '<?php echo base_url(); ?>/Master/loadRkGsm',
				data: function(params) {
					if (params.term == undefined) {
						return {
							search: "",
							opl_tglpl_nopo_nmker: opl_tglpl_nopo_nmker,
						}
					} else {
						return {
							search: params.term,
							opl_tglpl_nopo_nmker: opl_tglpl_nopo_nmker,
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
	$('#rkglabel').on('change', function() {
		data = $('#rkglabel').select2('data');

		$("#rkukuran").val("").prop('disabled', false);
		load_rkuk(data[0].id);

		$("#rkjmlroll").val("").prop('disabled', true).attr('style', 'background:#e9e9e9');
		// rkpo rkjenis rkglabel rkukuran
	});

	function load_rkuk(opl_tglpl_nopo_nmker_glabel) {
		$('#rkukuran').select2({
			allowClear: true,
			placeholder: '- - SELECT - -',
			ajax: {
				dataType: 'json',
				url: '<?php echo base_url(); ?>/Master/loadRkUkuran',
				data: function(params) {
					if (params.term == undefined) {
						return {
							search: "",
							opl_tglpl_nopo_nmker_glabel: opl_tglpl_nopo_nmker_glabel,
						}
					} else {
						return {
							search: params.term,
							opl_tglpl_nopo_nmker_glabel: opl_tglpl_nopo_nmker_glabel,
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
	$('#rkukuran').on('change', function() {
		data = $('#rkukuran').select2('data');
		$("#rkjmlroll").val("").prop('disabled', false).attr('style', 'background:#fff');
		// rkpo rkjenis rkglabel rkukuran
	});

	//

	function addCartRk(){ //
		rkukuran = $("#rkukuran").val();
		rkjmlroll = $("#rkjmlroll").val();
		// alert(option)
		if(rkukuran == '' || rkjmlroll == ''){
			swal("HARAP LENGKAPI FORM!", "", "error");
			return;
		}

		$.ajax({
			url: '<?php echo base_url('Master/addCartRk')?>',
			type: "POST",
			data: ({
				rkukuran: rkukuran,
				rkjmlroll: rkjmlroll,
				option
			}),
			success: function(response) {
				$(".show-cart-rk").load("<?php echo base_url('Master/showCartRk') ?>");
			}
		})
	}

	function simpanCartRk(){
		rkukuran = $("#rkukuran").val();
		tgl = $("#tgl-list-rk").val();
		// alert(option);
		// alert(rkukuran);
		$.ajax({
			url: '<?php echo base_url('Master/simpanCartRk')?>',
			type: "POST",
			data:({
				rkukuran: rkukuran,
				option
			}),
			success: function(json) {
				data = JSON.parse(json);
				if(data.data){
					swal(data.msg, "", "success");
					rkkosong()
				}
			}
		})
	}

	function hapusCartRk(rowid){
		$.ajax({
			url: '<?php echo base_url('Master/hapusCartRk')?>',
			type: "POST",
			data:({
				rowid: rowid,
			}),
			success: function(response) {
				$(".show-cart-rk").load("<?php echo base_url('Master/showCartRk') ?>");
			}
		})
	}

	// 

	function load_data(tgl){
		tgl = $("#tgl-list-rk").val();
		$(".list-rk").show().html('<div class="notfon">SEDANG MEMUAT . . .</div>');
		$.ajax({
			url: '<?php echo base_url('Master/pList'); ?>',
			type: "POST",
			data: ({
				tgl: tgl,
				pilihbtnrencana,otorisasi
			}),
			success: function(response){
				$(".list-rk").show().html(response);
			}
		});
	}

	function btnRencana(id_rk,opl,tgl_pl,brencana,i){ // KLIK PROSES
		$("#v-id-pl").val(id_rk);
		$("#v-opl").val(opl);
		$("#v-tgl-pl").val(tgl_pl);
		$("#v-ii").val(i);
		$(".t-plist-hasil-input-" + i).load("<?php echo base_url('Master/destroyCartInputRoll') ?>");
		$(".id-cek").html('');
		$(".t-plist-rencana-" + i).html('MEMUAT RENCANA KIRIM . . .');
		$.ajax({
			url: '<?php echo base_url('Master/pListRencana')?>',
			type: "POST",
			data: ({
				opl: opl,
				tgl_pl: tgl_pl,
				i: i,
				otorisasi,id_rk
			}),
			success: function(response) {
				$(".t-plist-rencana-" + i).html(response);
				if(brencana == 'pl'){
					prosesPL(id_rk,opl,tgl_pl,brencana,i);
				}
				hasilInputSementara(id_rk,i,brencana);
			}
		});
	}

	function prosesPL(id_rk,opl,tgl_pl,brencana,i){
		$(".t-plist-proses-pl-"+i).html('. . .');
		$.ajax({
			url: '<?php echo base_url('Master/prosesPL')?>',
			type: "POST",
			data: ({
				id_rk,opl,tgl_pl,brencana,i,otorisasi
			}),
			success: function(res){
				$(".t-plist-proses-pl-"+i).html(res);
			}
		})
	}

	function entryPL(id_rk,opl,tgl_pl,brencana,i,idpl,idroll,rstatus){
		// alert(idpl);
		$.ajax({
			url: '<?php echo base_url('Master/entryPL')?>',
			type: "POST",
			data: ({
				idpl,idroll,rstatus,id_rk
			}),
			success: function(json){
				data = JSON.parse(json)
				if(data.res){
					swal(data.msg, "", data.info)
					btnRencana(id_rk,opl,tgl_pl,brencana,i)
				}
			}
		})
	}

	function entryPlAllIn(idrk,nm_ker,glabel,width,idpl,plh){
		// vidpl = $("#v-id-pl").val();
		vopl = $("#v-opl").val();
		vtglpl = $("#v-tgl-pl").val();
		vii = $("#v-ii").val();
		// btnRencana(id_rk,opl,tgl_pl,brencana,i)
		// alert(idrk+' - '+nm_ker+' - '+glabel+' - '+width+' || '+idpl+' || '+vopl+' - '+vtglpl+' - '+vii);
		$.ajax({
			url: '<?php echo base_url('Master/entryPlAllIn')?>',
			type: "POST",
			data: ({
				idrk,nm_ker,glabel,width,idpl
			}),
			success: function(json){
				data = JSON.parse(json)
				if(data.res){
					swal(data.msg, "", "success");
					btnRencana(idrk,vopl,vtglpl,plh,vii)
				}
			}
		})
	}

	function entryBatalPL(idroll,rroll,rstatus,idrk,plh){
		vopl = $("#v-opl").val();
		vtglpl = $("#v-tgl-pl").val();
		vii = $("#v-ii").val();
		// alert(idroll+' - '+rstatus+' - '+idrk+' - '+plh+' || '+vopl+' - '+vtglpl+' - '+vii);
		swal({
			title: "Kembalikan ke Rencana Kirim ?",
			text: rroll,
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
					url: '<?php echo base_url('Master/entryBatalPL')?>',
					type: "POST",
					data: ({
						idroll,rstatus,idrk
					}),
					success: function(json){
						data = JSON.parse(json)
						if(data.res){
							swal(data.msg, "", "success");
							btnRencana(idrk,vopl,vtglpl,plh,vii)
						}
					}
				});
			}else{
				swal("BATAL DIBATALKAN!", "", "error");
			}
		});
	}

	function pLsJokeY(idrk,tglpl,opl,plh,cek){
		vopl = $("#v-opl").val();
		vtglpl = $("#v-tgl-pl").val();
		vii = $("#v-ii").val();
		// alert(idrk+' - '+tglpl+' - '+opl+' |||||| '+vopl+' - '+vtglpl+' - '+vii);
		swal({
			title: cek+" kah ?",
			text: idrk,
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
					url: '<?php echo base_url('Master/pLsJokeY')?>',
					type: "POST",
					data: ({
						idrk,tglpl,opl,cek
					}),
					success: function(json){
						data = JSON.parse(json);
						if(data.res){
							swal(data.msg, "", "success");
							btnRencana(idrk,vopl,vtglpl,plh,vii)
						}
					}
				})
			}else{
				swal("EH GAK JADI", "", "error");
			}
		});
	}

	function btnRencanaEdit(id_rk,opl,tgl_pl,i){
		// alert(id_rk+' - '+opl+' - '+tgl_pl+' - '+i);
		$(".box-data-rk").hide();
		$(".box-form-rk").show();
		$('#rkpl').val("").prop('disabled', true);
		load_rkpl();
		$('#rkpo').val("").prop('disabled', true);
		load_rkpo();
		$('#rkjenis').val("").prop('disabled', true);
		load_rkjns();
		$('#rkglabel').val("").prop('disabled', true);
		load_rkgsm();
		$("#rkukuran").val("").prop('disabled', true);
		load_rkuk();
		$("#rkjmlroll").val("").prop('disabled', true).attr('style', 'background:#e9e9e9');
		$(".show-list-edit-rk").html('');
		
		$.ajax({
			url: '<?php echo base_url('Master/btnRencanaEdit')?>',
			type: "POST",
			data: ({
				id_rk: id_rk,
				opl: opl,
				tgl_pl: tgl_pl,
			}),
			success: function(json){
				data = JSON.parse(json);
				$("#rktgl").val(data.tgl).prop('disabled', true);
				$("#rkpl").val(data.tgl).prop('disabled', true);
				$('#rkpo').val("").prop('disabled', false);
				load_rkpo(data.id);
				showListEditRk(id_rk,opl,tgl_pl,i);
				option = 'update'
			}
		})
	}

	function btnRencanaHapus(id_rk,opl,tgl_pl,i){
		// alert(id_rk+' - '+opl+' - '+tgl_pl+' - '+i);
		swal({
			title: "Apakah Anda Yakin ?",
			text: "ID RK : " + id_rk,
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
					url: '<?php echo base_url('Master/btnRencanaHapus')?>',
					type: "POST",
					data: ({
						id_rk,opl,tgl_pl,i
					}),
					success: function(json){
						data = JSON.parse(json);
						if(data.res){
							swal(data.msg, "", "success");
							rkkosong();
						}
					}
				});
			}else{
				swal("BATAL DIHAPUS!", "", "error");
			}
		});
	}

	function showListEditRk(id_rk,opl,tgl_pl,i){
		// alert(id_rk)
		$(".show-list-edit-rk").html('MEMUAT . . .');
		$.ajax({
			url: '<?php echo base_url('Master/showListEditRk')?>',
			type: "POST",
			data: ({
				id_rk,opl,tgl_pl,i
			}),
			success: function(data){
				$(".show-list-edit-rk").html(data);
			}
		})
	}
	
	function editListRk(id,nm_ker,g_label,width,id_rk,opl,tgl_pl,i,ii,ljmlroll){
		ejmlroll = $("#elrkroll-" + ii).val();
		// alert(ejmlroll);
		$.ajax({
			url: '<?php echo base_url('Master/editListRk')?>',
			type: "POST",
			data: ({
				id,ejmlroll,ljmlroll
			}),
			success: function(json){
				data = JSON.parse(json);
				if(data.response){
					swal(data.msg, "", "success");
					btnRencanaEdit(id_rk,opl,tgl_pl,i)
				}else{
					swal(data.msg, "", "error");
				}
			}
		})
	}

	function hapusListRk(id,nm_ker,g_label,width,id_rk,opl,tgl_pl,i){
		// alert(id)
		swal({
			title: "Apakah Anda Yakin ?",
			text: nm_ker+''+g_label+' - '+width,
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
					url: '<?php echo base_url('Master/hapusListRk')?>',
					type: "POST",
					data: ({
						id
					}),
					success: function(json){
						data = JSON.parse(json);
						if(data.response){
							swal(data.msg, "", "success");
							btnRencanaEdit(id_rk,opl,tgl_pl,i)
						}
					}
				})
			}else{
				swal("BATAL DIHAPUS!", "", "error");
			}
		});
	}

	function hasilInputSementara(id_rk,i,plh) {
		$(".t-plist-input-sementara-" + i).html('<div style="margin:15px 0;color:#000">. . .</div>');
		$.ajax({
			url: '<?php echo base_url('Master/pListInputSementara')?>',
			type: "POST",
			data: ({
				id_rk: id_rk,
				i: i,
				plh,otorisasi
			}),
			success: function(response){
				$(".t-plist-input-sementara-" + i).html(response);
			}
		});
	}

	function cekOkRk(idrk,plh,i,cek){
		// alert(idrk+' - '+plh+' - '+i+' - '+cek);
		vidpl = $("#v-id-pl").val();
		vopl = $("#v-opl").val();
		vtglpl = $("#v-tgl-pl").val();
		if(cek == 'ok'){
			txt = "CEK QC OK ?";
		}else{
			txt = "BATAL OK ?";
		}
		swal({
			title: txt,
			text: "ID RK : "+idrk,
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
					url: '<?php echo base_url('Master/cekOkRk')?>',
					type: "POST",
					data: ({
						idrk,i,cek
					}),
					success: function(json){
						data = JSON.parse(json)
						if(data.res){
							swal(data.msg, "", "success");
							btnRencana(idrk,vopl,vtglpl,plh,i)
						}
					}
				});
			}else{
				swal("BATAL CEK OK!", "", "error");
			}
		});
	}

	function btnInputRoll(i,nm_ker,g_label,width,roll='',cari=''){ // KLIK JUMLAH PADA RENCARA KIRIMAN
		// alert(i+' - '+id_pl+' - '+nm_ker+' - '+g_label+' - '+width+' - '+roll+' - '+cari);
		// v_id_pl = $("#v-id-pl").val();
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
		id_rk = $("#v-id-pl").val();
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
				id_rk: id_rk,
				i: i,
			}),
			success: function(response){
				data = JSON.parse(response);
				if(data){
					swal(data.isi.options.roll, "", "success");
					$(".t-plist-hasil-input-" + i).load("<?php echo base_url('Master/showCartInputRoll') ?>");
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
		xroll = $('#vcariroll-'+i).val();
		btnInputRoll(i,nm_ker,g_label,width,xroll,cari);
	}

	function simpanInputRoll(){
		// alert('simpan');
		v_id_rk = $("#v-id-pl").val();
		v_opl = $("#v-opl").val();
		v_tgl_pl = $("#v-tgl-pl").val();
		v_ii = $("#v-ii").val();
		// alert(v_id_rk+' - '+v_opl+' - '+v_tgl_pl+' - '+v_ii);
		$.ajax({
			url: '<?php echo base_url('Master/simpanInputRoll')?>',
			type: "POST",
			success: function(response){
				btnRencana(v_id_rk,v_opl,v_tgl_pl,pilihbtnrencana,v_ii);
			}
		});
	}

	function editRollRk(id,vdiameter,vseset,vberat,i){
		// alert(id);
		$(".plistinputroll").html('');
		id_rk = $("#v-id-pl").val();
		opl = $("#v-opl").val();
		tgl_pl = $("#v-tgl-pl").val();

		seset = $("#his-seset-" + id).val();
		diameter = $("#his-diameter-" + id).val();
		// alert(id+' - '+seset+' - '+vberat);
		$.ajax({
			url: '<?php echo base_url('Master/editRollRk')?>',
			type: "POST",
			data: ({
				id: id,
				seset: seset,
				diameter: diameter,
				vdiameter,vseset,vberat,id_rk,pilihbtnrencana
			}),
			success: function(json){
				data = JSON.parse(json)
				if(data.res){
					swal(data.msg, "", data.info);
					// hasilInputSementara(id_rk,i,pilihbtnrencana);
					btnRencana(id_rk,opl,tgl_pl,pilihbtnrencana,i);
				}
			}
		})
	}

	function reqLabelRk(id,idrk,i){
		// alert(id+' - '+idrk+' - '+i);
		$.ajax({
			url: '<?php echo base_url('Master/reqLabelRk')?>',
			type: "POST",
			data: ({
				id
			}),
			success: function(json){
				data = JSON.parse(json);
				if(data.res){
					swal(data.msg, "", "success")
					hasilInputSementara(idrk,i,pilihbtnrencana);
				}
			}
		})
	}

	function batalRollRk(id,i){
		id_rk = $("#v-id-pl").val();
		opl = $("#v-opl").val();
		tgl_pl = $("#v-tgl-pl").val();
		// $("#v-ii").val();
		$(".plistinputroll").html('');
		// alert(id+' - '+i+' - '+id_rk);
		$.ajax({
			url: '<?php echo base_url('Master/batalRollRk')?>',
			type: "POST",
			data: ({
				id,id_rk,pilihbtnrencana
			}),
			success: function(json){
				data = JSON.parse(json);
				if(data.res){
					swal(data.msg, "", data.info);
					btnRencana(id_rk,opl,tgl_pl,pilihbtnrencana,i);
					// hasilInputSementara(id_rk,i,pilihbtnrencana);
				}
			}
		})
	}

	//

	function konfirmasiBatalCor(id,pilihan,i){
		// alert(id);
		$(".plistinputroll").html('');
		id_rk = $("#v-id-pl").val();
		opl = $("#v-opl").val();
		tgl_pl = $("#v-tgl-pl").val();
		$.ajax({
			url: '<?php echo base_url('Master/konfirmasiBatalCor')?>',
			type: "POST",
			data: ({
				id,pilihan,id_rk
			}),
			success: function(json){
				data = JSON.parse(json);
				if(data.res){
					swal(data.msg, "", data.info);
					btnRencana(id_rk,opl,tgl_pl,pilihbtnrencana,i);
				}
			}
		});
	}

	//

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

	//

	function hanyaAngka(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}

</script>
