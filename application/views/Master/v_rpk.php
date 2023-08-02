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
	.box-data, .box-close,.box-form {
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

						<div class="box-btn" style="font-size:12px;color:#000">
							<button onclick="btnOpsi('data')">BERJALAN</button>
							<button onclick="btnOpsi('close')">CLOSE</button>
							<button onclick="btnOpsi('add')">ADD RPK BARU</button>
						</div>

						<div class="box-data" style="overflow:auto;white-space:nowrap;">
							DATA
						</div>

						<div class="box-close" style="overflow:auto;white-space:nowrap;">
							CLOSE
						</div>

						<div class="box-form" style="overflow:auto;white-space:nowrap;">
							<table>
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
											<option value="MH">MH</option>
											<option value="MN">MN</option>
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
											<option value="68">68</option>
											<option value="70">70</option>
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
										<input type="text" name="id_rpk" id="id_rpk" class="id_rpk form-control">
									</td>
								</tr>
								<tr>
									<td colspan="3" style="padding:15px 0"></td>
								</tr>
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
													<input type="text" name="item1" id="item1" class="ii item1 form-control" placeholder="1" maxlength="6">
												</td>
												<td style="padding:0 2px">
													<input type="text" name="item2" id="item2" class="ii item2 form-control" placeholder="2" maxlength="6">
												</td>
												<td style="padding:0 2px">
													<input type="text" name="item3" id="item3" class="ii item3 form-control" placeholder="3" maxlength="6">
												</td>
												<td style="padding:0 2px">
													<input type="text" name="item4" id="item4" class="ii item4 form-control" placeholder="4" maxlength="6">
												</td>
												<td style="padding:0 2px">
													<input type="text" name="item5" id="item5" class="ii item5 form-control" placeholder="5" maxlength="6">
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
										<input type="text" name="times" id="times" maxlength="3" class="times form-control" placeholder="x">
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">REFERENSI</td>
									<td style="padding:5px;text-align:center">:</td>
									<td style="padding:5px 0">
										<textarea name="ref" id="ref" class="ref form-control" style="resize:none;" placeholder="KET"></textarea>
									</td>
								</tr><tr>
									<td style="padding:5px 0" colspan="2"></td>
									<td style="padding:5px 0">
										<button onclick="addCartRpk()" style="font-weight:bold">ADD</button>
									</td>
								</tr>
							</table>

							<!-- CART LIST RPK -->
							<div class="cart-list-rpk"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	status = '';
	otorisasi = $("#otorisasi").val();

	$(document).ready(function() {
		kosong();
		$(".box-data").show();
		$(".box-close").hide();
		$(".box-form").hide();
	});

	function btnOpsi(opsi){
		if(opsi == 'data'){
			$(".box-data").show();
			$(".box-close").hide();
			$(".box-form").hide();
		}else if(opsi == 'close'){
			$(".box-data").hide();
			$(".box-close").show();
			$(".box-form").hide();
		}else{
			kosong();
			$(".box-data").hide();
			$(".box-close").hide();
			$(".box-form").show();
		}
	}

	function kosong() {
		// $("#tgl").val("");
		$("#pm").val("");
		$("#nm_ker").val("");
		$("#g_label").val("");
		$("#id_rpk").val("");
		$("#item1").val("");
		$("#item2").val("");
		$("#item3").val("");
		$("#item4").val("");
		$("#item5").val("");
		$("#times").val("");
		$("#ref").val("");

		$(".form-control").prop("disabled", true).attr('style', 'background:#e9e9e9');
		$(".pm").prop("disabled", false).removeAttr('style');
		$(".tgl").prop("disabled", false).removeAttr('style');

		$(".pi").prop("disabled", true).attr('style', 'background:#e9e9e9');
		$(".ii").val("").prop("disabled", true).attr('style', 'background:#e9e9e9;text-align:center');

		$(".cart-list-rpk").load("<?php echo base_url('Master/destroyCartRpk') ?>");
	}

	// 

	$('#tgl').on('change', function() {
		kosong();
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
			kosong();
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
			// kosong();
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

		if(tgl == "" || pm == "" || nm_ker == "" || g_label == ""){
			$("#id_rpk").val("");
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
		$("#ref").val("").prop("disabled", false).removeAttr('style');

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
		xplh = $("#xplh").val();
		item1 = $("#item1").val();
		item2 = $("#item2").val();
		item3 = $("#item3").val();
		item4 = $("#item4").val();
		item5 = $("#item5").val();
		times = $("#times").val();
		ref = $("#ref").val();
		trimw = $("#trimw").val();

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

		if(tgl == "" || pm == "" || nm_ker == "" || g_label == "" || id_rpk == "" || times == ""){
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
				tgl,pm,nm_ker,g_label,id_rpk,xplh,item1,item2,item3,item4,item5,times,ref,opsi: 'insert'
			}),
			success: function(res){
				data = JSON.parse(res);
				if(data.res){
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
		$(".btn-s-rpk").prop("disabled", true);
		$.ajax({
			url: '<?php echo base_url("Master/simpanCartRpk")?>',
			type: "POST",
			data:({
				opsi: 'insert'
			}),
			success: function(res){
				$(".btn-s-rpk").prop("disabled", false);
				kosong();
			}
		});
	}

</script>
