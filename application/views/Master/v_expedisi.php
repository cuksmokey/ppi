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
	.list-table:hover {
		background: #eee;
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
								<li style="font-weight:bold">EXPEDISI</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<input type="hidden" name="otorisasi" id="otorisasi" value="<?php echo $otorisasi; ?>">
						<input type="hidden" name="idex" id="idex" value="">

						<div class="btn-add" style="color:#000">
							<button onclick="btnAdd()">ADD</button>
						</div>

						<div class="pencarian" style="margin-top:15px;font-size:12px;color:#000;">
							<table style="width:100%">
								<tr>
									<td style="width:50%;">
										<input type="text" id="search" autocomplete="off" placeholder="CARI" class="form-control">
									</td>
									<td style="width:50%;">
										<button onclick="cari()">CARI</button>
									</td>
								</tr>
							</table>
						</div>

						<div class="box-data"></div>

						<div class="box-form" style="margin-top:15px;overflow:auto;white-space:nowrap;">
							<table style="width:100%;color:#000" border="1">
								<tr>
									<td style="padding:5px;width:20%"></td>
									<td style="padding:5px;width:1%"></td>
									<td style="padding:5px;width:39.5%"></td>
									<td style="padding:5px;width:39.5%"></td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">NO. POLISI</td>
									<td style="padding:5px;font-weight:bold">:</td>
									<td style="padding:5px">
										<table style="width:100%">
											<tr>
												<td><input type="text" id="no_polisi1" class="form-control" autocomplete="off" placeholder="AD" maxlength="2"></td>
												<td style="padding:5px">-</td>
												<td><input type="text" id="no_polisi2" class="form-control" autocomplete="off" placeholder="1234" maxlength="4" onkeypress="return hA(event)"></td>
												<td style="padding:5px">-</td>
												<td><input type="text" id="no_polisi3" class="form-control" autocomplete="off" placeholder="XXX" maxlength="3"></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">MERK / TYPE KENDARAAN</td>
									<td style="padding:5px;font-weight:bold">:</td>
									<td style="padding:5px">
										<input type="text" id="mert_type" class="form-control" autocomplete="off" placeholder="MERK / TYPE" maxlength="20">
									</td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">PT</td>
									<td style="padding:5px;font-weight:bold">:</td>
									<td style="padding:5px">
										<input type="text" id="pt" class="form-control" autocomplete="off" placeholder="P T" maxlength="20">
									</td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">NAMA SUPIR</td>
									<td style="padding:5px;font-weight:bold">:</td>
									<td style="padding:5px">
										<input type="text" id="nm_supir" class="form-control" autocomplete="off" placeholder="NAMA SUPIR" maxlength="20">
									</td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">NO. HP</td>
									<td style="padding:5px;font-weight:bold">:</td>
									<td style="padding:5px">
										<input type="text" id="no_hp" class="form-control" autocomplete="off" placeholder="NO. HP" maxlength="13" onkeypress="return hA(event)">
									</td>
								</tr>
							</table>

							<div style="margin-top:15px;color:#000">
								<button onclick="kembali()">BACK</button>
								<button onclick="simpan()">SIMPAN</button>
							</div>
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
		$(".box-form").hide();
		$(".pencarian").show();
		kosong();
		load_data('');
	});

	function kosong(){
		$(".box-form").hide();
		$(".pencarian").show();
		$(".box-data").show();

		$("#idex").val("");
		$("#no_polisi1").val("");
		$("#no_polisi2").val("");
		$("#no_polisi3").val("");
		$("#mert_type").val("");
		$("#pt").val("");
		$("#nm_supir").val("");
		$("#no_hp").val("");

		status = 'insert';
		$("#search").val("");
	}

	$("#search").on({keyup: function() {this.value = this.value.toUpperCase()}});
	$("#no_polisi1").on({keyup: function() {this.value = this.value.toUpperCase()}});
	$("#no_polisi3").on({keyup: function() {this.value = this.value.toUpperCase()}});
	$("#mert_type").on({keyup: function() {this.value = this.value.toUpperCase()}});
	$("#pt").on({keyup: function() {this.value = this.value.toUpperCase()}});
	$("#nm_supir").on({keyup: function() {this.value = this.value.toUpperCase()}});

	function btnAdd(){
		kosong();
		$(".pencarian").hide();
		$(".box-data").hide();
		$(".box-form").show();
	}

	function kembali(){
		load_data('');
		$("#search").val("");
		$(".box-form").hide();
		$(".pencarian").show();
		$(".box-data").show();
	}

	function cari(){
		ssss = $("#search").val();
		load_data(ssss);
	}

	function load_data(cari){
		$.ajax({
			url: '<?php echo base_url('Master/loadDataExpedisi')?>',
			type: "POST",
			data: ({
				cari
			}),
			success: function(res){
				$(".box-data").html(res);
			}
		})
	}

	function editExpedisi(id){
		// idex = $("#idex").val(id);
		// alert(id);
		$.ajax({
			url: '<?php echo base_url('Master/editExpedisi')?>',
			type: "POST",
			data: ({
				id
			}),
			success: function(json){
				data = JSON.parse(json);
				if(data.res){
					status = 'update';
					$("#idex").val(data.data.id);
					nopol = data.data.plat.split(" ");
					$("#no_polisi1").val(nopol[0]);
					$("#no_polisi2").val(nopol[1]);
					$("#no_polisi3").val(nopol[2]);

					$("#mert_type").val(data.data.merk_type);
					$("#pt").val(data.data.pt);
					$("#nm_supir").val(data.data.supir);
					$("#no_hp").val(data.data.no_telp);

					$(".box-data").hide();
					$(".pencarian").hide();
					$(".box-form").show();
				}
			}
		})
	}

	function hapusExpedisi(id){
		alert(id);
	}

	function simpan(){
		idex = $("#idex").val();;
		no_polisi1 = $("#no_polisi1").val();
		no_polisi2 = $("#no_polisi2").val();
		no_polisi3 = $("#no_polisi3").val();
		mert_type = $("#mert_type").val();
		pt = $("#pt").val();
		nm_supir = $("#nm_supir").val();
		no_hp = $("#no_hp").val();
		// alert(no_polisi1+' - '+no_polisi2+' - '+no_polisi3+' - '+mert_type+' - '+pt+' - '+nm_supir+' - '+no_hp+' - '+status+' - '+idex);
		if(no_polisi1 == "" || no_polisi2 == "" || no_polisi3 == "" || mert_type == "" || pt == "" || nm_supir == "" || no_hp == ""){
			swal("LENGKAPI FORM!", "", "error");
			return;
		}

		$.ajax({
			url : '<?php echo base_url('Master/simpanExpedisi')?>',
			type: "POST",
			data: ({
				no_polisi1,no_polisi2,no_polisi3,mert_type,pt,nm_supir,no_hp,status,idex
			}),
			success: function(json){
				data = JSON.parse(json);
				if(data.res){
					swal(data.msg, "", data.info);
					kembali();
				}else{
					swal(data.msg, "", data.info);
				}
			}
		});
	}

	//

	function hA(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}

</script>
