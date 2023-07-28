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
	.box-data, .box-form {
		padding-top:15px;
		color: #000
	}

	.list-table:hover {
		background: #eee;
	}

	.list-p-putih:hover {
		/* background: #eee */
		background: rgba(220, 220, 220, 0.5);
	}

	.inp-abs {
		position:absolute;top:0;right:0;left:0;bottom:0;border:0;margin:0;padding:5px;text-align:center;background:none;
	}

	.txt-area-new {
		position:absolute;top:0;right:0;left:0;bottom:0;width:100%;height:100%;resize:none;background:none;margin:0;padding:5px;border:0;
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
								<li style="font-weight:bold">RETUR PENGIRIMAN ROLL</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<input type="hidden" name="otorisasi" id="otorisasi" value="<?php echo $otorisasi; ?>">

						<div class="box-data" style="overflow:auto;white-space:nowrap;">
							DATA
						</div>

						<div class="box-form" style="overflow:auto;white-space:nowrap;">
							<table style="margin-bottom:10px">
								<tr>
									<td style="padding:5px 0;border:1px solid #000"></td>
									<td style="padding:5px;border:1px solid #000"></td>
									<td style="padding:5px 0;border:1px solid #000"></td>
									<td style="padding:5px 0;border:1px solid #000"></td>
								</tr>
								<!-- <tr>
									<td style="padding:5px 0;font-weight:bold">TANGGAL</td>
									<td style="padding:5px 0">:</td>
									<td style="padding:5px 0">
										<input type="date" name="tgl" id="tgl" class="form-control">
									</td>
								</tr> -->
								<tr>
									<td style="padding:5px 0;font-weight:bold">NO. SURAT JALAN</td>
									<td style="padding:5px">:</td>
									<td style="padding:5px 0">
										<input type="text" name="no-sj" id="no-sj" class="form-control" autocomplete="off">
									</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td style="font-size:10px;font-style:italic;color:#f00">* Tidak Harus Lengkap</td>
								</tr>
								<tr>
									<td style="padding:5px 0;font-weight:bold">JENIS</td>
									<td style="padding:5px">:</td>
									<td style="padding:5px 0">
										<select name="jenis-nmker" id="jenis-nmker" class="form-control">
											<option value="">-</option>
											<option value="BK">BK</option>
											<option value="MH">MH</option>
											<option value="MN">MN</option>
											<option value="WP">WP</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0"></td>
									<td style="padding:5px"></td>
									<td style="padding:5px 0">
										<button onclick="cari()">CARI</button>
									</td>
								</tr>
							</table>

							<div class="hasil-cari-reject"></div>
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
	});

	function kosong() {

	}

	//

	function cari() {
		noSj = $("#no-sj").val();
		jNmKer = $("#jenis-nmker").val();
		if(noSj == ''){
			swal("NO. SURAT JALAN HARAP DI ISILAH BRO", "", "error");
			return;
		}

		$(".hasil-cari-reject").html('MEMUAT');
		$.ajax({
			url: '<?php echo base_url('Master/cariSJReject')?>',
			type: "POST",
			data: ({
				noSj,jNmKer
			}),
			success: function(res){
				$(".hasil-cari-reject").html(res);
			}
		});
	}

	function detailList(i,no_surat,id_rk,nm_ker){
		// alert(i+' - '+no_surat+' - '+id_rk+' - '+nm_ker);
		$(".clr-list-reject").html('');
		$(".tmpl-list-reject-" + i).html('MEMUAT');
		$.ajax({
			url: '<?php echo base_url('Master/tmplDetailList')?>',
			type: "POST",
			data: ({
				i,no_surat,id_rk,nm_ker
			}),
			success: function(res){
				$(".tmpl-list-reject-" + i).html(res);
				$(".tmpl-sementara-lr-" + i).load("<?php echo base_url('Master/destroyListReject') ?>");
				hasilInputRollReject(i,no_surat,id_rk,nm_ker);
			}
		});
	}

	//

	function hasilInputRollReject(i,no_surat,id_rk,nm_ker){
		// alert(i);
		$(".tmpl-hasil-input-rjt-" + i).html(' - - - ');
		$.ajax({
			url: '<?php echo base_url('Master/hasilInputRollReject')?>',
			type: "POST",
			data: ({
				i,no_surat,id_rk,nm_ker
			}),
			success: function(res){
				$(".tmpl-hasil-input-rjt-" + i).html(res);
			}
		});
	}

	function editInputRollReject(i,no_surat,id_rk,nm_ker,id_rjt,roll){
		erjtDiameter = $("#erjt-diameter-"+id_rjt).val();
		erjtWeight = $("#erjt-weight-"+id_rjt).val();
		erjtJoint = $("#erjt-joint-"+id_rjt).val();
		erjtKet = $("#erjt-ket-"+id_rjt).val();
		erjtStatus = $("#erjt-status-"+id_rjt).val();
		// alert(erjtDiameter+' - '+erjtWeight+' - '+erjtJoint+' - '+erjtKet);

		if(erjtStatus == ""){
			swal("STATUS TIDAK BOLEH KOSONG", "", "error");
			return;
		}
		$.ajax({
			url: '<?php echo base_url('Master/editInputRollReject')?>',
			type: "POST",
			data: ({
				erjtDiameter,erjtWeight,erjtJoint,erjtKet,erjtStatus,id_rk,id_rjt,roll
			}),
			success: function(res){
				data = JSON.parse(res);
				if(data.res){
					swal(data.msg, "", data.info);
					hasilInputRollReject(i,no_surat,id_rk,nm_ker);
				}else{
					swal(data.msg, "", data.info);
				}
			}
		})
	}

	function hapusInputRollReject(i,no_surat,id_rk,nm_ker,id_rjt,roll){
		swal({
			title: "YAKIN HAPUS BRO?",
			text: "NO. ROLL : " + roll,
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
					url: '<?php echo base_url('Master/hapusInputRollReject')?>',
					type: "POST",
					data: ({
						id_rjt,id_rk,roll
					}),
					success: function(json){
						data = JSON.parse(json)
						if(data.res){
							swal(data.msg, "", "success");
							detailList(i,no_surat,id_rk,nm_ker);
						}
					}
				});
			}else{
				swal("LOHE LOHE!", "", "error");
			}
		});
	}

	//

	function addListReject(i,xid,roll,xidrk){
		// alert(i+' - '+xid+' - '+roll+' - '+xidrk);
		$.ajax({
			url: '<?php echo base_url('Master/pListReject')?>',
			type: "POST",
			data: ({
				i,xid,roll,xidrk
			}),
			success: function(response){
				data = JSON.parse(response);
				swal(data.isi.options.roll, "", "success");
				$(".tmpl-sementara-lr-" + i).load("<?php echo base_url('Master/showListReject') ?>");
			}
		})
	}

	function hapusListReject(rowid,i){
		$.ajax({
			url: '<?php echo base_url('Master/hapusListReject')?>',
			type: "POST",
			data: ({
				rowid: rowid
			}),
			success: function(response){
				$(".tmpl-sementara-lr-" + i).load("<?php echo base_url('Master/showListReject') ?>");
			}
		})
	}

	function simpanListReject(){
		// btn-simpan-sementara-rjt
		$('#btn-simpan-sementara-rjt').prop("disabled", true);
		rL = $("#r-l").val();
		rNoSurat = $("#r-no-surat").val();
		rIdRk = $("#r-id-rk").val();
		rNmKer = $("#r-nm-ker").val();
		// alert(rL+' - '+rNoSurat+' - '+rIdRk+' - '+rNmKer);
		$.ajax({
			url: '<?php echo base_url('Master/simpanListReject')?>',
			type: "POST",
			success: function(response){
				$('#btn-simpan-sementara-rjt').prop("disabled", false);
				detailList(rL,rNoSurat,rIdRk,rNmKer);
			}
		});
	}
</script>
