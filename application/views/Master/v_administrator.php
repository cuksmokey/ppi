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
	.box-data,.box-form {
		padding-top:15px
	}

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
								<li class="">ADMINISTRATOR</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<input type="hidden" name="otorisasi" id="otorisasi" value="<?php echo $otorisasi; ?>">
						<input type="hidden" name="iduser" id="iduser" value="">
						<input type="hidden" name="lusername" id="lusername" value="">

						<button onclick="btn_add()" style="font-weight:bold" class="btn btn-default btn-sm waves-effect">ADD</button>

						<div class="box-data"></div>

						<div class="box-form">
							<table style="width:100%" border="1">
								<tr>
									<td style="width:15%;padding:5px"></td>
									<td style="width:1%;padding:5px"></td>
									<td style="width:auto;padding:5px"></td>
									<td style="width:50%;padding:5px"></td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">USERNAME</td>
									<td style="padding:5px">:</td>
									<td style="padding:5px">
										<input type="text" name="username" id="username" class="form-control" autocomplete="off" placeholder="USERNAME">
									</td>
									<td style="padding:5px"></td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">NAMA USER</td>
									<td style="padding:5px">:</td>
									<td style="padding:5px">
										<input type="text" name="nama-user" id="nama-user" class="form-control" autocomplete="off" placeholder="NAMA USER"> 
									</td>
									<td style="padding:5px"></td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">PASSWORD</td>
									<td style="padding:5px">:</td>
									<td style="padding:5px">
										<input type="text" name="password" id="password" class="form-control" autocomplete="off" placeholder="PASSWORD">
									</td>
									<td style="padding:5px"></td>
								</tr>
								<tr>
									<td style="padding:5px;font-weight:bold">LEVEL</td>
									<td style="padding:5px">:</td>
									<td style="padding:5px">
										<select id="level" class="form-control"></select>
									</td>
									<td style="padding:5px"></td>
								</tr>
							</table>

							<div style="padding-top:15px">	
								<button onclick="back()" style="font-weight:bold" class="btn btn-default btn-sm waves-effect">BACK</button>
								&nbsp;&nbsp;
								<button onclick="simpan()" style="font-weight:bold" class="btn bg-green btn-sm waves-effect">
									<span id="btn-simpan-update">SIMPAN</span>
								</button>
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
		// alert(otorisasi);
		kosong();
		load_data(otorisasi);
		// load_data(otorisasi);
	});

	function kosong() {
		// alert(otorisasi);
		$("#iduser").val("");
		$("#username").val("");
		$("#lusername").val("");
		$("#nama-user").val("");
		$("#password").val("");
		$("#level").val("");
	}

	function back(){
		// alert(otorisasi);
		load_data(otorisasi);
		$(".box-form").hide();
		$(".box-data").show();
	}

	$("#username").on({
		keydown: function(e) {
			if (e.which === 32)
				return false;
		},
		keyup: function() {
			this.value = this.value.toLowerCase();
		},
	});
	$("#password").on({
		keydown: function(e) {
			if (e.which === 32)
				return false;
		},
	});
	$("#nama-user").on({
		keyup: function() {
			this.value = this.value.toUpperCase();
		},
	});

	function btn_add(){
		status = 'insert';
		// alert(status+' - '+otorisasi);
		kosong();
		load_level(otorisasi);
		$("#username").prop("disabled", false).attr('style', 'background:#fff');
		$(".box-data").hide();
		$(".box-form").show();
	}

	function load_level(otorisasi){
		// alert(level);
		$.ajax({
			url: '<?php echo base_url('Master/loadSelectLevelAdministrator')?>',
			type: "POST",
			data: ({
				otorisasi: otorisasi,
			}),
			success: function(response){
				$("#level").html(response)
			}
		});
	}

	function load_data(otorisasi){
		// alert(otorisasi);
		$(".box-data").html('MEMUAT DATA');
		$.ajax({
			url: '<?php echo base_url('Master/loadDataAdmin')?>',
			type: "POST",
			data: ({
				otorisasi: otorisasi,
			}),
			success: function(response){
				if(response){
					$(".box-data").html(response);
				}else{
					$(".box-data").html('DATA TIDAK DITEMUKAN');
				}
			}
		});
	}

	function simpan(){
		iduser = $("#iduser").val();
		username = $("#username").val().toLowerCase();
		lusername = $("#lusername").val();
		nama_user = $("#nama-user").val();
		password = $("#password").val();
		level = $("#level").val();

		if(username == '' || nama_user == '' || password == '' || level == ''){
			swal('HARAP LENGKAPI FORM!');
			return;
		}
		// alert(username+' - '+nama_user+' - '+password+' - '+level+' - '+status);
		$("#btn-simpan-update").html('SIMPAN');
		$.ajax({
			url: '<?php echo base_url('Master/simpanAdministrator')?>',
			type: "POST",
			data: ({
				id: iduser,
				lusername: lusername,
				username: username,
				nama_user: nama_user,
				password: password,
				level: level,
				status: status,
			}),
			success: function(data){
				json = JSON.parse(data);
				if(json.data){
					swal(json.msg);
					// editUser(json.user.id);
					$(".box-data").show();
					$(".box-form").hide();
					load_data(otorisasi);
				}else{
					swal(json.msg);
				}
			}
		})
	}

	function editUser(id){
		// alert(otorisasi);
		$("#btn-simpan-update").html('UPDATE');
		$(".box-data").hide();
		$(".box-form").show();
		$.ajax({
			url: '<?php echo base_url('Master/editAdministrator')?>',
			type: "POST",
			data: ({
				id: id,
			}),
			success: function(response){
				status = 'update';
				// alert(id+' - '+status);
				data = JSON.parse(response);
				$("#iduser").val(data.id);
				$("#username").val(data.username).prop("disabled", true).attr('style', 'background:#eee');
				$("#lusername").val(data.username);
				$("#nama-user").val(data.nm_user);
				$("#password").val("");
				// $("#level").html(data.level);
				load_level(otorisasi);
			}
		});
	}

	function hapusUser(id,username,nm_user){
		swal({
			title: "Apakah Anda Yakin ?",
			text: username+' - '+nm_user,
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Ya",
			cancelButtonText: "Batal",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if(isConfirm){
				$.ajax({
					url: '<?php echo base_url('Master/hapusAdminstrator')?>',
					type: "POST",
					data: ({
						id: id,
					}),
					success: function(data){
						if(data == 1){
							swal("DATA BERHASIL DIHAPUS", "", "error");
							// otorisasi = $("#otorisasi").val();
							load_data(otorisasi);
						}else{
							swal("DATA BATAL DIHAPUS", "", "error");
						}
					}
				});
			}else{
				swal("", "DATA BATAL DIHAPUS", "error");
			}
		});
	}
</script>
