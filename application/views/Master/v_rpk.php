<?php
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

<style>
	.box-data, .box-close, .box-k-note {
		padding-top:15px;
		font-size:12px;
		color: #000
	}

	.list-table:hover {
		background: #eee;
	}

	.pi{
		background: none;
		border:3px solid #fff;
		border-width: 0 0 3px;
		margin: 0;
		padding: 5px 12px;
	}

	.edrpk {
		position:absolute;top:0;right:0;left:0;bottom:0;border:0;margin:0;padding:5px;text-align:center;background:none;
	}

	.bg-iya {
		background: #ccc;
		font-weight: bold;
	}

	.bg-tdk {
		background: #fff;
	}

	.bg-iyh {
		text-decoration: underline;
	}

	.btn-gg {
		background: none;
		background: transparent;
		margin: 0;
		padding: 0;
		border:0
	}

	.btn-gg2 {
		background: none;
		background: transparent;
		margin: 0;
		padding: 5px 0;
		border:0
	}

	.btn-gg-iya {
		background: #eee;
		margin: 0;
		padding: 5px;
		border:0;
		border-left: 3px solid #0f0;
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

	.btn-ntd {
		background: none;
		background: transparent;
		margin: 0;
		padding: 0 6px;
		border:0;
		font-weight: bold;
	}

	.btn-ntd:hover{
		text-decoration: underline;
	}

	.ff-ll-note{
		width: 100%;
		background: none;
		background: transparent;
		border: 0;
		padding: 6px 120px 6px 6px;
	}

	.td-ntd:hover{
		background: rgba(225, 225, 225, 0.5);
	}
	.tr-dtl-rpk:hover{
		background: rgba(230, 230, 230, 0.5);
	}

	.inpt-idrpk-ref{
		margin:0;
		padding:6px 12px;
		border: 3px solid #888;
		border-width: 0 0 3px;
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
								<li style="font-weight:bold">RENCANA PRODUKSI KERTAS</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<input type="hidden" name="otorisasi" id="otorisasi" value="<?php echo $otorisasi; ?>">

						<div class="box-btn" style="font-size:12px;font-weight:bold;color:#000">
							<button onclick="btnOpsi('data')">OPEN</button>
							<button onclick="btnOpsi('close')">CLOSE</button>
							<?php if($otorisasi == "all" || $otorisasi == "qc") { ?>
								<button onclick="btnOpsi('add')">ADD RPK BARU</button>
							<?php } ?>
						</div>

						<div class="box-data" style="overflow:auto;white-space:nowrap;">
							<!-- <div class="box-data-roll"></div> -->
							<input type="hidden" id="box-data-id-rpk" value="">
							<input type="hidden" id="box-data-nm-ker" value="">
							<input type="hidden" id="box-data-idx" value="">
							<div class="box-data-list-pm"></div>
							<div class="box-data-list-nmker"></div>
							<div class="box-data-list" style="margin-top:5px"></div>
						</div>

						<div class="box-close" style="overflow:auto;white-space:nowrap;">
							<div class="box-close-list-pm"></div>
							<div class="box-close-list"></div>
						</div>

						<div class="box-from-loading"></div>
						<div class="box-form" style="font-size:12px;color:#000;overflow:auto;white-space:nowrap;">
							<div style="margin-bottom:15px;font-size:12px;font-weight:bold;color:#000"><button onclick="btnOpsi('kembali')">KEMBALI</button></div>
							<table class="box-form-kop">
								<tr>
									<td style="padding:5px 0;font-weight:bold">TANGGAL</td>
									<td style="padding:5px;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="date" name="tgl" id="tgl" value="<?php echo date("Y-m-d")?>" class="tgl form-control">
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">PM</td>
									<td style="padding:5px;text-align:center">:</td>
									<td style="padding:5px 0">
										<select name="pm" id="pm" class="pm form-control">
											<option value="">PILIH</option>
											<option value="1">1</option>
											<option value="2">2</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">JENIS</td>
									<td style="padding:5px;text-align:center">:</td>
									<td style="padding:5px 0">
										<select name="nm_ker" id="nm_ker" class="nm_ker form-control">
											<option value="">PILIH</option>
											<option value="BK">BK</option>
											<option value="BL">BL</option>
											<option value="MH">MH</option>
											<option value="MF">MF</option>
											<option value="MF-B">MF-B</option>
											<option value="ML">ML</option>
											<option value="MN">MN</option>
											<option value="TL">TL</option>
											<option value="TL-B">TL-B</option>
											<option value="WP">WP</option>
											<option value="WS">WS</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">GRAMATURE</td>
									<td style="padding:5px;text-align:center">:</td>
									<td style="padding:5px 0">
										<select name="g_label" id="g_label" class="g_label form-control">
											<option value="">PILIH</option>
											<option value="65">65</option>
											<option value="68">68</option>
											<option value="70">70</option>
											<option value="85">85</option>
											<option value="105">105</option>
											<option value="110">110</option>
											<option value="115">115</option>
											<option value="120">120</option>
											<option value="125">125</option>
											<option value="140">140</option>
											<option value="150">150</option>
											<option value="200">200</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">NO RPK</td>
									<td style="padding:5px;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="hidden" id="tampung-id_rpk" value="">
										<input type="text" name="id_rpk" id="id_rpk" style="background:none;width:100%;font-weight:bold;border:0;padding:0;text-align:center" disabled readonly>
									</td>
									<td style="padding:5px;text-align:center">-</td>
									<td style="padding:5px 0">
										<input type="text" name="id_rpk_ref" id="id_rpk_ref" class="id_rpk_ref inpt-idrpk-ref" placeholder="RINCIAN-RPK" autocomplete="off">
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">LENGTH</td>
									<td style="padding:5px 3px;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="hidden" id="h_length" value="">
										<input type="text" name="k_length" id="k_length" class="form-control" placeholder="0" autocomplete="off">
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">SPEED</td>
									<td style="padding:5px 3px;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="hidden" id="h_speed" value="">
										<input type="text" name="k_speed" id="k_speed" class="form-control" placeholder="0" autocomplete="off">
									</td>
								</tr>
								<tr>
									<td style="padding:5px" colspan="2"></td>
									<td style="padding:5px 0">
										<button class="btn-edit-ll" style="font-weight:bold" onclick="simpanCartRpk()">EDIT</button>
									</td>
								<tr>
							</table>
							<table>
								<tr>
									<td style="padding:5px 0;font-weight:bold">ITEM</td>
									<td style="padding:5px;text-align:center">:</td>
									<td style="padding:5px 0">
										<table style="width:100%">
											<tr>
												<td colspan="5" style="padding:5px 0 5px 5px">
													<button class="pi plhitem1" onclick="plh_item(1)">1</button>
													<button class="pi plhitem2" onclick="plh_item(2)">2</button>
													<button class="pi plhitem3" onclick="plh_item(3)">3</button>
													<button class="pi plhitem4" onclick="plh_item(4)">4</button>
													<button class="pi plhitem5" onclick="plh_item(5)">5</button>
													<input type="hidden" id="xplh" value="">
												</td>
											</tr>
											<tr>
												<td style="padding:0 2px">
													<input type="text" name="item1" id="item1" class="ii item1 form-control" placeholder="1" maxlength="6" autocomplete="off">
												</td>
												<td style="padding:0 2px">
													<input type="text" name="item2" id="item2" class="ii item2 form-control" placeholder="2" maxlength="6" autocomplete="off">
												</td>
												<td style="padding:0 2px">
													<input type="text" name="item3" id="item3" class="ii item3 form-control" placeholder="3" maxlength="6" autocomplete="off">
												</td>
												<td style="padding:0 2px">
													<input type="text" name="item4" id="item4" class="ii item4 form-control" placeholder="4" maxlength="6" autocomplete="off">
												</td>
												<td style="padding:0 2px">
													<input type="text" name="item5" id="item5" class="ii item5 form-control" placeholder="5" maxlength="6" autocomplete="off">
												</td>
											</tr>
											<tr>
												<td colspan="5" style="color:#f00;font-size:11px;font-style:italic">* koma pakai titik ( . )</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">TRIM WIDTH</td>
									<td style="padding:5px;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="text" name="trimw" id="trimw" style="border:0;font-weight:bold" placeholder="0" disabled>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">TIMES</td>
									<td style="padding:5px;text-align:center">:</td>
									<td style="padding:5px 0">
										<input type="text" name="times" id="times" maxlength="3" class="times form-control" placeholder="x" autocomplete="off">
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">REFERENSI</td>
									<td style="padding:5px;text-align:center">:</td>
									<td style="padding:5px 0">
										<textarea name="ref" id="ref" class="ref form-control" style="resize:none;" placeholder="KET" autocomplete="off"></textarea>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0" colspan="2"></td>
									<td style="padding:5px 0">
										<button onclick="addCartRpk()" style="font-weight:bold">ADD ITEM</button>
									</td>
								</tr>
							</table>

							<!-- CART CART LIST RPK -->
							<div class="cart-list-rpk"></div>

							<!-- CART EDIT LIST RPK -->
							<div class="edit-list-rpk"></div>

							<!-- NOTE LIST -->
							<div class="box-note-list"></div>
						</div>
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

<div class="modal fade bd-example-modal-lg" id="modal-p-rpk" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" >
			<div class="modal-body" style="overflow:auto;white-space:nowrap;">
				<div class="isi-p-rpk"></div>
			</div>
		</div>
	</div>
</div>

<script>
	status = '';
	otorisasi = $("#otorisasi").val();

	$(document).ready(function() {
		kosong();
		$(".box-data").show();
		$(".box-close").hide();
		$(".box-form").hide();
	});

	function kosong() {
		status = 'insert';
		$("#tampung-id_rpk").val("");
		
		$("#pm").val("");
		$("#nm_ker").val("");
		$("#g_label").val("");
		$("#id_rpk").val("");
		$("#id_rpk_ref").val("");
		$("#item1").val("");
		$("#item2").val("");
		$("#item3").val("");
		$("#item4").val("");
		$("#item5").val("");
		$("#times").val("");
		$("#k_length").val("");
		$("#k_speed").val("");
		$("#trimw").val(0);
		$("#ref").val("");

		$(".form-control").prop("disabled", true).attr('style', 'background:#e9e9e9');
		$(".pm").prop("disabled", false).removeAttr('style');
		$(".tgl").prop("disabled", false).removeAttr('style');
		$(".note-list").prop("disabled", false).removeAttr('style');
		$(".id_rpk_ref").prop("disabled", false).removeAttr('style');
		$("#k_length").prop("disabled", false).removeAttr('style');
		$("#k_speed").prop("disabled", false).removeAttr('style');
		$(".btn-edit-ll").hide();

		$(".pi").prop("disabled", true).attr('style', 'background:#e9e9e9');
		$(".ii").val("").prop("disabled", true).attr('style', 'background:#e9e9e9;text-align:center');

		$(".cart-list-rpk").load("<?php echo base_url('Master/destroyCartRpk') ?>");
		$(".edit-list-rpk").html('');

		$(".box-data-list-pm").html('');
		$(".box-data-list-nmker").html('');
		$(".box-data-list").html('');
		$(".box-close-list-pm").html('');
		$(".box-close-list").html('');
	}

	// 

	function btnOpsi(opsi){
		kosong();
		// alert(status);
		$(".box-btn").show();
		if(opsi == 'data'){
			$(".box-data").show();
			$(".box-close").hide();
			$(".box-form").hide();
			loadPM('open');
		}else if(opsi == 'close'){
			$(".box-data").hide();
			$(".box-close").show();
			$(".box-form").hide();
			loadPM('close');
		}else if(opsi == 'kembali'){
			$(".box-data").show();
			$(".box-close").hide();
			$(".box-form").hide();
		}else{
			$(".box-btn").hide();
			$(".box-data").hide();
			$(".box-close").hide();
			$(".box-form").show();
			$(".box-form-kop").show();
		}
	}

	//

	function cekPRPK(idrpk){
		$(".isi-p-rpk").html('');
		$(".isi-p-rpk").html('Loading . . .');
		$("#modal-p-rpk").modal("show");
		$.ajax({
			url: '<?php echo base_url('Master/btnPCekRPK')?>',
			type: "POST",
			data: ({
				idrpk
			}),
			success: function(response){
				$(".isi-p-rpk").html(response);
			}
		});
	}

	// CLOSE

	function loadCloseTahunRpk(pm){
		$(".box-close-list").html('Loading...');
		$.ajax({
			url: '<?php echo base_url("Master/loadCloseTahunRpk")?>',
			type: "POST",
			data: ({
				pm
			}),
			success: function(res){
				$(".box-close-list").html(res);
			}
		});
	}

	function btnCloseBulanRpk(pm,tahun){
		$(".clr-bln").html('');
		$(".list-bulan-"+tahun).html('Loading...');
		$.ajax({
			url: '<?php echo base_url("Master/btnCloseBulanRpk")?>',
			type: "POST",
			data: ({
				pm,tahun
			}),
			success: function(res){
				$(".list-bulan-"+tahun).html(res);
			}
		});
	}

	// OPEN

	function loadPM(opsi){
		$(".box-data-list-pm").html('...');
		$(".box-data-list-nmker").html('');
		$(".box-data-list").html('');
		$.ajax({
			url: '<?php echo base_url("Master/loadPM")?>',
			type: "POST",
			data: ({
				opsi
			}),
			success: function(res){
				(opsi == 'open') ? $(".box-data-list-pm").html(res) : $(".box-close-list-pm").html(res);
			}
		});
	}

	function loadJnmKer(pm){
		// alert(pm);
		$(".box-data-list-nmker").html('...');
		$(".box-data-list").html('');
		$.ajax({
			url: '<?php echo base_url('Master/loadJnmKer')?>',
			type: "POST",
			data: ({
				pm
			}),
			success: function(res){
				$(".box-data-list-nmker").html(res);
			}
		})
	}
	
	function loadRollRpkBaru(pm,nmker = ''){
		// $(".box-data-list").html('');
		$("#box-data-id-rpk").val("");
		$("#box-data-nm-ker").val("");
		$("#box-data-idx").val("");
		$.ajax({
			url: '<?php echo base_url("Master/loadRollRpkBaru")?>',
			type: "POST",
			data: ({
				pm,nmker
			}),
			success: function(res){
				data = JSON.parse(res);
				$("#box-data-id-rpk").val(data.data);
				$("#box-data-nm-ker").val(data.nmker);
				$("#box-data-idx").val(data.ll);
				loadDataRpk(pm,nmker,'','','open');
			}
		});
	}

	function loadDataRpk(pm = '', nmker = '',tahun = '', bulan = '', stat = 'open'){
		if(tahun == '' && bulan == '' && stat == 'open'){
			id_rpk = $("#box-data-id-rpk").val();
			i = $("#box-data-idx").val();
			$(".box-data-list").html('Loading...');
		}else{
			$(".clr-cls-dtl").html('');
			$(".detail-list-close-"+tahun+'-'+bulan).html('Loading');
		}
		$.ajax({
			url: '<?php echo base_url("Master/loadDataRpk")?>',
			type: "POST",
			data: ({
				pm,nmker,tahun,bulan,stat
			}),
			success: function(res){
				if(stat == 'open'){
					$(".box-data-list").html(res);
					if(id_rpk != '' && i != ''){
						btnDetailRpk(i,id_rpk);
					}
				}else{
					$(".detail-list-close-"+tahun+'-'+bulan).html(res);
				}
			}
		});
	}

	function btnDetailRpk(i,id_rpk){
		// alert(i+' - '+id_rpk+' - '+tahun+' - '+sta
		$(".clr-dtl").html('');
		$(".clr-gdng").html('');
		$(".dtl-list-rpk-"+i).html('Loading...');
		$.ajax({
			url: '<?php echo base_url("Master/btnDetailRpk")?>',
			type: "POST",
			data: ({
				i,id_rpk
			}),
			success: function(res){
				$(".dtl-list-rpk-"+i).html(res);
			}
		});
	}

	function btnEditRpk(id_rpk){
		status = 'edit';
		$(".box-note-list").html('');
		$("#tampung-id_rpk").val(id_rpk);
		$(".cart-list-rpk").load("<?php echo base_url('Master/destroyCartRpk') ?>");
		$(".box-data").hide();
		$(".box-btn").hide();
		$(".btn-edit-ll").show();
		// $(".box-form-kop").hide();
		$(".box-from-loading").html('<div style="padding:5px 0">Loading...</div>');
		$.ajax({
			url: '<?php echo base_url("Master/btnEditRpk")?>',
			type: "POST",
			data: ({
				id_rpk
			}),
			success: function(res){
				$(".box-from-loading").html('');
				$(".box-form").show();
				data = JSON.parse(res);
				$("#tgl").val(data.tgl).prop("disabled", false).removeAttr('style');
				$("#pm").val(data.pm).prop("disabled", true).attr('style', 'background:#e9e9e9');
				$("#nm_ker").val(data.nm_ker).prop("disabled", true).attr('style', 'background:#e9e9e9');
				$("#g_label").val(data.g_label);
				$("#k_length").val(data.k_length);
				$("#k_speed").val(data.k_speed);

				sid_rpk = data.id_rpk.split("/");
				$("#id_rpk").val(sid_rpk[0]+'/'+sid_rpk[1]);
				$("#id_rpk_ref").val(data.id_rpk_ref).prop("disabled", false).removeAttr('style');
				$(".pi").prop("disabled", false).removeAttr('style');
				loadDataEditListRpk(id_rpk);
			}
		});
	}

	function loadDataEditListRpk(id_rpk){
		// edit-list-rpk
		$(".edit-list-rpk").html('<div style="padding:5px 0">Loading...</div>');
		$.ajax({
			url: '<?php echo base_url("Master/loadDataEditListRpk")?>',
			type: "POST",
			data: ({
				id_rpk
			}),
			success: function(res){
				$(".edit-list-rpk").html(res);
				loadDataNoteList(id_rpk);
			}
		});
	}
	
	function loadDataNoteList(id_rpk){
		// alert(id_rpk);
		$(".box-note-list").html('Loading');
		$.ajax({
			url: '<?php echo base_url("Master/loadDataNoteList")?>',
			type: "POST",
			data: ({
				id_rpk
			}),
			success: function(res){
				$(".box-note-list").html(res);
			}
		});
	}

	function noted(id_rpk,idx,stat){
		$(".btn-add-noted").prop("disabled", true);
		// alert(id_rpk+' - '+idx+' - '+stat);
		if(stat == 'insert'){
			note_list = $(".note-list").val();
		}else{
			note_list = $(".enote-list-"+idx).val();
		}
		$.ajax({
			url: '<?php echo base_url("Master/noted")?>',
			type: "POST",
			data: ({
				id_rpk,note_list,idx,stat
			}),
			success: function(res){
				data = JSON.parse(res);
				if(data.data == true){
					swal(data.msg, "", "success");
					loadDataNoteList(id_rpk);
				}else{
					swal(data.msg, "", "error");
				}
				$(".btn-add-noted").prop("disabled", false);
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
				i,idx,id_rpk,stat,width,timbangan: ''
			}),
			success: function(res){
				$(".list-gd-ng-"+i).html(res);
			}
		});
	}

	function xclgd(i){
		// $(".bg-iya").removeClass("btn-iya").addClass("btn-gg");
		$(".list-gd-ng-"+i).html("");
	}

	function plhCekUkuran(width){
		$(".bbb").removeClass("btn-gg-iya").addClass("btn-gg");
		$(".ggww-"+width).removeClass("btn-gg-iya").addClass("btn-gg-iya");

		$(".clk").removeClass("bg-iyh").addClass("bg-tdk");
		$(".uk-"+width).removeClass("bg-tdk").addClass("bg-iyh");
	}

	//

	function btnAksiListRpk(i,idx,id_rpk,stat){
		// alert(i+' - '+idx+' - '+id_rpk+' - '+stat);
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

	function btnCloseListRpk(i,idx,id_rpk){
		$.ajax({
			url: '<?php echo base_url("Master/btnCloseListRpk")?>',
			type: "POST",
			data: ({
				i,idx,id_rpk
			}),
			success: function(res){
				swal("BERHASIL CLOSE RPK", "", "success");
				btnDetailRpk(i,id_rpk);
			}
		})
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

	//

	function aksiEditRpk(idx,id_rpk,not){
		eitem1 = $("#erpk1-"+idx).val();
		eitem2 = $("#erpk2-"+idx).val();
		eitem3 = $("#erpk3-"+idx).val();
		eitem4 = $("#erpk4-"+idx).val();
		eitem5 = $("#erpk5-"+idx).val();
		ex = $("#ex-"+idx).val();
		eref = $("#eref-"+idx).val();
		
		if(eitem1 == ""){
			swal("ITEM 1 TIDAK BOLEH KOSONG", "", "error");
			return;
		}
		if(eitem2 == ""){
			swal("ITEM 2 TIDAK BOLEH KOSONG", "", "error");
			return;
		}
		if(eitem3 == ""){
			swal("ITEM 3 TIDAK BOLEH KOSONG", "", "error");
			return;
		}
		if(eitem4 == ""){
			swal("ITEM 4 TIDAK BOLEH KOSONG", "", "error");
			return;
		}
		if(eitem5 == ""){
			swal("ITEM 5 TIDAK BOLEH KOSONG", "", "error");
			return;
		}

		$.ajax({
			url: '<?php echo base_url("Master/aksiEditRpk")?>',
			type: "POST",
			data: ({
				eitem1,eitem2,eitem3,eitem4,eitem5,ex,eref,idx,id_rpk
			}),
			success: function(res){
				data = JSON.parse(res);
				if(data.data == true){
					showNotification("alert-success", data.msg, "top", "center", "", "");
					$("#erpk1-"+idx).val(data.item1).animateCss('fadeInRight');
					$("#erpk2-"+idx).val(data.item2).animateCss('fadeInRight');
					$("#erpk3-"+idx).val(data.item3).animateCss('fadeInRight');
					$("#erpk4-"+idx).val(data.item4).animateCss('fadeInRight');
					$("#erpk5-"+idx).val(data.item5).animateCss('fadeInRight');
					$("#etrimw-"+idx).val(data.trimw).animateCss('fadeInRight');
					$("#ex-"+idx).val(data.x).animateCss('fadeInRight');
					$("#eref-"+idx).val(data.ref).animateCss('fadeInRight');

					if(not != 'not'){
						($("#erpk1-"+idx).val() != 0) ? $("#erpk2-"+idx).prop("disabled", false).removeAttr('style') : $("#erpk2-"+idx).val(0).prop("disabled", true).attr('style', 'background:#e9e9e9');
						($("#erpk2-"+idx).val() != 0) ? $("#erpk3-"+idx).prop("disabled", false).removeAttr('style') : $("#erpk3-"+idx).val(0).prop("disabled", true).attr('style', 'background:#e9e9e9');
						($("#erpk3-"+idx).val() != 0) ? $("#erpk4-"+idx).prop("disabled", false).removeAttr('style') : $("#erpk4-"+idx).val(0).prop("disabled", true).attr('style', 'background:#e9e9e9');
						($("#erpk4-"+idx).val() != 0) ? $("#erpk5-"+idx).prop("disabled", false).removeAttr('style') : $("#erpk5-"+idx).val(0).prop("disabled", true).attr('style', 'background:#e9e9e9');
					}
				}else{
					swal(data.msg, "", "error");
					return;
				}
			}
		});
	}

	function aksiHapusRpk(idx,id_rpk){
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
			if(isConfirm) {
				$.ajax({
					url: '<?php echo base_url("Master/aksiHapusRpk")?>',
					type: "POST",
					data: ({
						idx,id_rpk
					}),
					success: function(res){
						data = JSON.parse(res);
						swal("TERHAPUS!!", "", "success");
						if(data.list == 'ada'){
							btnEditRpk(id_rpk);
						}else{
							btnOpsi('data');
						}
					}
				});
			}else{
				swal("BATAL DIHAPUS!", "", "error");
			}
		});
	}

	//

	$('#tgl').on('change', function() {
		(status == 'insert') ? kosong() : '';
		noRpk();
	});

	$('#pm').on('change', function() {
		$(".cart-list-rpk").load("<?php echo base_url('Master/destroyCartRpk') ?>");
		$(".ii").val("").prop("disabled", true).attr('style', 'background:#e9e9e9;text-align:center');
		$(".pi").prop("disabled", true).attr('style', 'background:#e9e9e9');
		$("#times").val("").prop("disabled", true).attr('style', 'background:#e9e9e9');
		$("#ref").val("").prop("disabled", true).attr('style', 'background:#e9e9e9');
		pm = $("#pm").val();
		if(pm == ""){
			(status == 'insert') ? kosong() : '';
			$("#nm_ker").val("");
			$("#g_label").val("");
			noRpk();
		}else{
			$("#nm_ker").val("");
			$("#g_label").val("");
			$(".nm_ker").prop("disabled", false).removeAttr('style');
			$(".g_label").prop("disabled", true).attr('style', 'background:#e9e9e9');
			noRpk();
		}
	});

	$('#nm_ker').on('change', function() {
		$(".cart-list-rpk").load("<?php echo base_url('Master/destroyCartRpk') ?>");
		$(".ii").val("").prop("disabled", true).attr('style', 'background:#e9e9e9;text-align:center');
		$(".pi").prop("disabled", true).attr('style', 'background:#e9e9e9');
		$("#times").val("").prop("disabled", true).attr('style', 'background:#e9e9e9');
		$("#ref").val("").prop("disabled", true).attr('style', 'background:#e9e9e9');
		nm_ker = $("#nm_ker").val();
		if(nm_ker == ""){
			(status == 'insert') ? kosong() : '';
			$("#g_label").val("");
			$(".g_label").prop("disabled", true).attr('style', 'background:#e9e9e9');
			noRpk();
		}else{
			$("#g_label").val("");
			$(".g_label").prop("disabled", false).removeAttr('style');
			noRpk();
		}
	});

	$('#g_label').on('change', function() {
		$(".cart-list-rpk").load("<?php echo base_url('Master/destroyCartRpk') ?>");
		$(".ii").val("").prop("disabled", true).attr('style', 'background:#e9e9e9;text-align:center');
		$("#times").val("").prop("disabled", true).attr('style', 'background:#e9e9e9');
		$("#ref").val("").prop("disabled", true).attr('style', 'background:#e9e9e9');
		g_label = $("#g_label").val();
		if(g_label == ""){
			(status == 'insert') ? kosong() : '';
			$(".pi").prop("disabled", true).attr('style', 'background:#e9e9e9');
			noRpk();
		}else{
			$(".pi").prop("disabled", false).removeAttr('style');
			noRpk();
		}
	});

	function noRpk(){
		tgl = $("#tgl").val();
		pm = $("#pm").val();
		nm_ker = $("#nm_ker").val();
		g_label = $("#g_label").val();
		id_rpk_ref = $("#id_rpk_ref").val();

		if(tgl == "" || pm == "" || nm_ker == "" || g_label == ""){
			$("#id_rpk").val("");
			$("#id_rpk_ref").val("");
		}else{
			$("#id_rpk").val("loading");
			$.ajax({
				url: '<?php echo base_url("Master/getNoRpk")?>',
				type: "POST",
				data: ({
					tgl,pm,nm_ker,g_label
				}),
				success: function(res){
					data = JSON.parse(res);
					$("#id_rpk").val(data.data);
					(status == 'insert') ? $("#tampung-id_rpk").val(data.data+'/'+id_rpk_ref) : $("#tampung-id_rpk").val(); //hidden
				}
			});
		}
	}

	// 

	function plh_item(plh) {
		$("#trimw").val(0);
		$("#xplh").val(plh);
		$(".pi").removeAttr('style');
		$(".plhitem"+plh).attr('style', 'background:#eee;border-bottom:3px solid #555;font-weight:bold');
		$(".ii").val("").prop("disabled", true).attr('style', 'background:#e9e9e9;text-align:center');

		$("#times").val("").prop("disabled", false).removeAttr('style');
		$("#ref").prop("disabled", false).removeAttr('style');

		if(plh == 1){
			$(".item1").val("").prop("disabled", false).removeAttr('style');
		}else if(plh == 2){
			$(".item1").val("").prop("disabled", false).removeAttr('style');
			$(".item2").val("").prop("disabled", false).removeAttr('style');
		}else if(plh == 3){
			$(".item1").val("").prop("disabled", false).removeAttr('style');
			$(".item2").val("").prop("disabled", false).removeAttr('style');
			$(".item3").val("").prop("disabled", false).removeAttr('style');
		}else if(plh == 4){
			$(".item1").val("").prop("disabled", false).removeAttr('style');
			$(".item2").val("").prop("disabled", false).removeAttr('style');
			$(".item3").val("").prop("disabled", false).removeAttr('style');
			$(".item4").val("").prop("disabled", false).removeAttr('style');
		}else if(plh == 5){
			$(".item1").val("").prop("disabled", false).removeAttr('style');
			$(".item2").val("").prop("disabled", false).removeAttr('style');
			$(".item3").val("").prop("disabled", false).removeAttr('style');
			$(".item4").val("").prop("disabled", false).removeAttr('style');
			$(".item5").val("").prop("disabled", false).removeAttr('style');
		}
	}

	//

	$(".item1").keyup(function(){
		item1 = $(".item1").val();

		jmlh = parseFloat(item1);
		if(isNaN(jmlh)){
			$("#trimw").val(0);
		}else{
			$("#trimw").val(jmlh);
		}
	});

	$(".item2").keyup(function(){
		item1 = $(".item1").val();
		item2 = $(".item2").val();

		jmlh = parseFloat(item1) + parseFloat(item2);
		if(isNaN(jmlh)){
			$("#trimw").val(0);
		}else{
			$("#trimw").val(jmlh);
		}
	});

	$(".item3").keyup(function(){
		item1 = $(".item1").val();
		item2 = $(".item2").val();
		item3 = $(".item3").val();

		jmlh = parseFloat(item1) + parseFloat(item2) + parseFloat(item3);
		if(isNaN(jmlh)){
			$("#trimw").val(0);
		}else{
			$("#trimw").val(jmlh);
		}
	});

	$(".item4").keyup(function(){
		item1 = $(".item1").val();
		item2 = $(".item2").val();
		item3 = $(".item3").val();
		item4 = $(".item4").val();

		jmlh = parseFloat(item1) + parseFloat(item2) + parseFloat(item3) + parseFloat(item4);
		if(isNaN(jmlh)){
			$("#trimw").val(0);
		}else{
			$("#trimw").val(jmlh);
		}
	});

	$(".item5").keyup(function(){
		item1 = $(".item1").val();
		item2 = $(".item2").val();
		item3 = $(".item3").val();
		item4 = $(".item4").val();
		item5 = $(".item5").val();

		jmlh = parseFloat(item1) + parseFloat(item2) + parseFloat(item3) + parseFloat(item4) + parseFloat(item5);
		if(isNaN(jmlh)){
			$("#trimw").val(0);
		}else{
			$("#trimw").val(jmlh);
		}
	});

	//

	function addCartRpk() {
		tgl = $("#tgl").val();
		pm = $("#pm").val();
		nm_ker = $("#nm_ker").val();
		g_label = $("#g_label").val();
		id_rpk = $("#id_rpk").val();
		id_rpk_ref = $("#id_rpk_ref").val();
		xplh = $("#xplh").val();
		item1 = $("#item1").val();
		item2 = $("#item2").val();
		item3 = $("#item3").val();
		item4 = $("#item4").val();
		item5 = $("#item5").val();
		times = $("#times").val();
		ref = $("#ref").val();
		trimw = $("#trimw").val();
		k_length = $("#k_length").val();
		k_speed = $("#k_speed").val();
		// alert(xid_rpk+' - '+xid_rpk_ref+' - '+id_rpk);

		if(xplh == 1){
			if(item1 == "" || item1 == 0){
				swal("ITEM 1 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}
		}
		if(xplh == 2){
			if(item1 == "" || item1 == 0){
				swal("ITEM 1 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}else if(item2 == "" || item2 == 0){
				swal("ITEM 2 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}
		}
		if(xplh == 3){
			if(item1 == "" || item1 == 0){
				swal("ITEM 1 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}else if(item2 == "" || item2 == 0){
				swal("ITEM 2 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}else if(item3 == "" || item3 == 0){
				swal("ITEM 3 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}
		}
		if(xplh == 4){
			if(item1 == "" || item1 == 0){
				swal("ITEM 1 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}else if(item2 == "" || item2 == 0){
				swal("ITEM 2 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}else if(item3 == "" || item3 == 0){
				swal("ITEM 3 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}else if(item4 == "" || item4 == 0){
				swal("ITEM 4 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}
		}
		if(xplh == 5){
			if(item1 == "" || item1 == 0){
				swal("ITEM 1 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}else if(item2 == "" || item2 == 0){
				swal("ITEM 2 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}else if(item3 == "" || item3 == 0){
				swal("ITEM 3 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}else if(item4 == "" || item4 == 0){
				swal("ITEM 4 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}else if(item5 == "" || item5 == 0){
				swal("ITEM 5 TIDAK BOLEH KOSONG!", "", "error");
				return;
			}
		}

		if(tgl == "" || pm == "" || nm_ker == "" || g_label == "" || id_rpk == "" || id_rpk_ref == "" || times == "" || k_length == "" ||k_speed == ""){
			swal("HARAP LENGKAPI FORM!", "", "error");
			return;
		}
		if(trimw == 0 || trimw == ""){
			swal("TRIM TIDAK BOLEH KOSONG!", "", "error");
			return;
		}

		$.ajax({
			url: '<?php echo base_url("Master/addCartRpk")?>',
			type: "POST",
			data: ({
				tgl,pm,nm_ker,g_label,id_rpk,id_rpk_ref,k_length,k_speed,xplh,item1,item2,item3,item4,item5,times,ref,opsi: status
			}),
			success: function(res){
				data = JSON.parse(res);
				if(data.res){
					$(".tgl").prop("disabled", true).attr('style', 'background:#e9e9e9');
					$(".pm").prop("disabled", true).attr('style', 'background:#e9e9e9');
					$('#nm_ker').prop("disabled", true).attr('style', 'background:#e9e9e9');
					$('#g_label').prop("disabled", true).attr('style', 'background:#e9e9e9');
					$(".id_rpk_ref").prop("disabled", true).attr('style', 'background:#e9e9e9');
					$(".cart-list-rpk").load("<?php echo base_url('Master/showCartRpk') ?>");
				}else{
					swal(data.msg, "", "error");
					return;
				}
			}
		});
	}

	function hapusCartRpk(rowid){
		$.ajax({
			url: '<?php echo base_url('Master/hapusCartRpk')?>',
			type: "POST",
			data: ({
				rowid: rowid
			}),
			success: function(response){
				$(".cart-list-rpk").load("<?php echo base_url('Master/showCartRpk') ?>");
			}
		});
	}

	//

	function simpanCartRpk(){
		tgl = $("#tgl").val();
		tId_rpk = $("#tampung-id_rpk").val();
		rpk_new = $("#id_rpk").val();
		rpkref_new = $("#id_rpk_ref").val();
		nRpkCuy = rpk_new+'/'+rpkref_new;
		k_length = $("#k_length").val();
		k_speed = $("#k_speed").val();
		// alert(tId_rpk+" - "+rpk_new+" - "+rpkref_new+" - "+status);
		$(".btn-s-rpk").prop("disabled", true);

		if(rpkref_new == ""){
			swal("NO. RPK TIDAK BOLEH KOSONG", "", "error");
			return;
		}
		$.ajax({
			url: '<?php echo base_url("Master/simpanCartRpk")?>',
			data: ({
				tId_rpk,status,rpk_new,rpkref_new,tgl,k_length,k_speed
			}),
			type: "POST",
			success: function(res){
				data = JSON.parse(res);
				$(".btn-s-rpk").prop("disabled", false);
				if(data.data == true){
					swal(data.msg, "", "success");
					(tId_rpk == nRpkCuy) ? btnEditRpk(tId_rpk) : btnEditRpk(nRpkCuy);
					$(".nm_ker").prop("disabled", true).attr('style', 'background:#e9e9e9');
					$(".g_label").prop("disabled", true).attr('style', 'background:#e9e9e9');
					$(".ii").val("").prop("disabled", true).attr('style', 'background:#e9e9e9;text-align:center');
					$("#trimw").val(0);
					$("#times").val("").prop("disabled", true).attr('style', 'background:#e9e9e9');
					$("#ref").val("").prop("disabled", true).attr('style', 'background:#e9e9e9');
				}else{
					swal(data.msg, "", "error");
					return;
				}
			}
		});
	}

</script>
