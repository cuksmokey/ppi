<style>
	.tmbl-opsi {
		background: #f44336;
		padding: 5px 7px;
		color: #fff;
		font-weight: bold;
		border: 0;
		border-radius: 5px;
		cursor: pointer;
	}

	.tmbl-opsi:hover, .tmbl-cari:hover {
		background: #c40316;
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

	.ttggll, .ipt-txt {
		background:transparent;margin:0;padding:0;border:0
	}
	
	.cek-status-stok {
		background-color: #fff;
	}
	.cek-status-stok:hover {
		background-color: #eee;
	}
	.cek-status-stok:hover .edit-roll {
		background-color: #eee;
	}

	.cek-status-buffer {
		background-color: #fee;
	}
	.cek-status-buffer:hover {
		background-color: #edd;
	}
	.cek-status-buffer:hover .edit-roll {
		background:#edd;
	}

	.cek-status-terjual {
		background-color: #dfd;
	}
	.cek-status-terjual:hover {
		background-color: #cec;
	}

	.opt_status {
		background:none;border:0;
	}

	.edit-roll {
		background:#fff
	}
	
	textarea {
		outline: none;
	}

	.tmbl-stok {
		background: #f44336;
		padding: 5px 7px;
		color: #fff;
		font-weight: bold;
		border: 0;
		border-radius: 5px;
		cursor: pointer;
	}

	.tmbl-stok:hover {
		background: #c40316;
	}

	.tmbl-buffer {
		background: #555;
		padding: 5px 7px;
		color: #fff;
		font-weight: bold;
		border: 0;
		border-radius: 5px;
		cursor: pointer;
	}

	.tmbl-buffer:hover {
		background: #000;
	}

	.inpt-txt-kosong {
		background:none;margin:0 0 0 10px;padding:0;border:0;font-weight:bold
	}

	.clear{
		display:block;padding:2px
	}

	.new-stok-gg:hover {
		background: rgba(238, 238, 238, 0.5);
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
								<li style="font-weight:bold">STOK GUDANG + PRODUKSI</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<input type="hidden" id="otorisasi" value="<?= $otorisasi ?>">
						<input type="hidden" id="stat" value="">

						<button class="tmbl-plh" style="font-size:12px;color:#000" onclick="plh_menu('stok')">STOK GUDANG</button>
						<button class="tmbl-plh" style="font-size:12px;color:#000" onclick="plh_menu('produksi')">PRODUKSI</button>

						<div class="menu-stok" style="padding-top:10px;font-size:12px">
							<button disabled>STOK : </button>
							<button class="tmbl-stok" onclick="load_data('mh','stok')">MEDIUM</button>
							<button class="tmbl-stok" onclick="load_data('bk','stok')">B - KRAFT</button>
							<button class="tmbl-stok" onclick="load_data('mhbk','stok')">MEDIUM - B-KRAFT</button>
							<button class="tmbl-stok" onclick="load_data('nonspek','stok')">MEDIUM NON SPEK</button>
							<button class="tmbl-stok" onclick="load_data('wp','stok')">W P</button>
							<button class="tmbl-stok" onclick="load_data('all','stok')">SEMUA</button>
							<div class="clear"></div>

							<button disabled>BUFFER : </button>
							<button class="tmbl-buffer" onclick="load_data('rmh','buffer')">MEDIUM</button>
							<button class="tmbl-buffer" onclick="load_data('rbk','buffer')">B - KRAFT</button>
							<button class="tmbl-buffer" onclick="load_data('rmhbk','buffer')">MEDIUM - B-KRAFT</button>
							<button class="tmbl-buffer" onclick="load_data('rnonspek','buffer')">MEDIUM NON SPEK</button>
							<button class="tmbl-buffer" onclick="load_data('rwp','buffer')">W P</button>
							<button class="tmbl-buffer" onclick="load_data('rmhc','buffer')">MH COLOR</button>
							<button class="tmbl-buffer" onclick="load_data('rall','buffer')">SEMUA</button>
						</div>
						
						<div class="menu-produksi" style="padding-top:10px;font-size:12px">
							<button disabled>PILIH : </button>
							<button class="tmbl-stok" onclick="p_pm(1)">PM 1</button>
							<button class="tmbl-stok" onclick="p_pm(2)">PM 2</button>
							<button class="tmbl-stok" onclick="p_pm(12)">PM 1-2</button>
							<input type="text" name="p-pm" id="p-pm" class="inpt-txt-kosong" disabled>
							<input type="hidden" id="p-pm-v" value="">
							<div class="clear"></div>

							<button disabled>PILIH : </button>
							<button class="tmbl-stok" onclick="p_jenis('mh')">MEDIUM</button>
							<button class="tmbl-stok" onclick="p_jenis('bk')">B - KRAFT</button>
							<button class="tmbl-stok" onclick="p_jenis('mhbk')">MEDIUM - B-KRAFT</button>
							<button class="tmbl-stok" onclick="p_jenis('nonspek')">MEDIUM NON SPEK</button>
							<button class="tmbl-stok" onclick="p_jenis('wp')">W P</button>
							<button class="tmbl-stok" onclick="p_jenis('all')">SEMUA</button>
							<input type="text" name="p-jenis" id="p-jenis" class="inpt-txt-kosong" disabled>
							<input type="hidden" id="p-jenis-v" value="">
							<div class="clear"></div>

							<button disabled>PILIH : </button>
							<input type="date" name="tgl" id="tgl" style="padding:3px 5px;border:1px solid #ccc;border-radius:5px">
							s/d
							<input type="date" name="tgl2" id="tgl2" style="padding:3px 5px;border:1px solid #ccc;border-radius:5px">
							<button class="tmbl-stok" onclick="load_data('tgl','produksi')">CARI</button>
						</div>

						<div class="box-data" style="padding-top:10px"></div>

						<div class="tmpl-roll" style="padding-top:10px"></div>
					</div>
				</div>
			</div>
</section>

<!-- DETAIL LIST PO -->
<div class="modal fade bd-example-modal-lg" id="modal-stok-list" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <h6>CEK STATUS</h6> -->
			</div>
			<div class="modal-body">
				<div class="isi-stok-list"></div>
				<div class="isi-stok-tuan"></div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-lg" id="modal-qc-list" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">
				<div class="isi-qc-terjual"></div>
				<div class="isi-qc-edit"></div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(".box-data").html('').hide();
		$(".tmpl-roll").html('').hide();
		$(".menu-stok").hide();
		$(".menu-produksi").hide();
		kosong();
	});

	function kosong(){
		$("#p-pm").val('');
		$("#p-pm-v").val('');
		$("#p-jenis").val('');
		$("#p-jenis-v").val('');
		$("#tgl").val('');
		$("#tgl2").val('');
	}

	function plh_menu(plh){
		$(".tmbl-stok").prop("disabled", false).removeAttr( "style");
		$(".tmbl-buffer").prop("disabled", false).removeAttr( "style");
		$(".box-data").html('').hide();
		$(".tmpl-roll").html('').hide();
		if(plh == 'stok'){
			$(".menu-stok").show();
			$(".menu-produksi").hide();
		}else{
			$(".menu-stok").hide();
			$(".menu-produksi").show();
		}
	}

	function p_pm(pm){
		if(pm == 12){
			tpm = '1-2';
		}else{
			tpm = pm;
		}
		$("#p-pm").val('PM '+tpm);
		$("#p-pm-v").val(pm);
	}

	function p_jenis(jenis){
		if(jenis == 'mh'){
			tjns = 'MEDIUM';
		}else if(jenis == 'bk'){
			tjns = 'B - KRAFT';
		}else if(jenis == 'mhbk'){
			tjns = 'MEDIUM - B-KRAFT';
		}else if(jenis == 'nonspek'){
			tjns = 'MEDIUM NON SPEK';
		}else if(jenis == 'wp'){
			tjns = 'WP';
		}else{
			tjns = 'SEMUA';
		}
		$("#p-jenis").val(tjns);
		$("#p-jenis-v").val(jenis);
	}

	function load_data(jenis,stat){
		$(".box-data").html('');
		$(".tmpl-roll").html('');
		otorisasi = $("#otorisasi").val();
		tgl = $("#tgl").val();
		tgl2 = $("#tgl2").val();
		vpm = $("#p-pm-v").val();
		vjenis = $("#p-jenis-v").val();

		if(stat == 'produksi'){
			if (vpm == '') {
				showNotification("alert-danger", "PILIH PM", "bottom", "center", "", "");
				return;
			}
			if (vjenis == '') {
				showNotification("alert-danger", "PILIH JENIS", "bottom", "center", "", "");
				return;
			}
			if (tgl == '') {
				showNotification("alert-danger", "PILIH TANGGAL AWAL", "bottom", "center", "", "");
				return;
			}
			if (tgl2 == '') {
				showNotification("alert-danger", "PILIH TANGGAL AKHIR", "bottom", "center", "", "");
				return;
			}
		}
		
		if(jenis == 'mh' || vjenis == 'mh'){
			Njenis = 'MEDIUM';
		}else if(jenis == 'bk' || vjenis == 'bk'){
			Njenis = 'B - KRAFT';
		}else if(jenis == 'mhbk' || vjenis == 'mhbk'){
			Njenis = 'MEDIUM - B-KRAFT';
		}else if(jenis == 'nonspek' || vjenis == 'nonspek'){
			Njenis = 'MEDIUM NON SPEK';
		}else if(jenis == 'wp' || vjenis == 'wp'){
			Njenis = 'WP';
		}else if(jenis == 'all' || vjenis == 'all'){
			Njenis = 'SEMUA';
		}else if(jenis == 'rmh'){
			Njenis = 'BUFFER MEDIUM';
		}else if(jenis == 'rbk'){
			Njenis = 'BUFFER B - KRAFT';
		}else if(jenis == 'rmhbk'){
			Njenis = 'BUFFER  MEDIUM - B-KRAFT';
		}else if(jenis == 'rnonspek'){
			Njenis = 'BUFFER MEDIUM NON SPEK';
		}else if(jenis == 'rwp'){
			Njenis = 'BUFFER WP';
		}else if(jenis == 'rmhc'){
			Njenis = 'MH COLOR';
		}else if(jenis == 'rall'){
			Njenis = 'SEMUA BUFFER';
		}else{
			Njenis = '';
		}

		if(stat == 'produksi'){
			if(vpm == 12){
				xpm = '1-2';
			}else{
				xpm = vpm;
			}
			if(tgl == tgl2){
				tmplTgl = tgl;
			}else{
				tmplTgl = tgl+' s/d '+tgl2;
			}
			tJns = `PRODUKSI <b>${Njenis}</b>. DARI PM <b>${xpm}</b>. TANGGAL <b>${tmplTgl}</b>`;
		}else{
			tJns = `<b>${Njenis}</b>`;
		}

		$(".tmbl-plh").prop("disabled", true);
		$(".tmbl-stok").prop("disabled", true).attr('style', 'background:#ccc');
		$(".tmbl-buffer").prop("disabled", true).attr('style', 'background:#ccc');
		$(".box-data").show().html(`Memuat data ROLL ${tJns}. Tunggu Sebentar . . .`);
		$.ajax({
			url: '<?php echo base_url('Laporan/NewStokGudang'); ?>',
			type: "POST",
			data: ({
				jenis: jenis,
				otorisasi: otorisasi,
				stat: stat,
				tgl: tgl,
				tgl2: tgl2,
				pm: vpm,
				vjenis: vjenis,
			}),
			success: function(response){
				$(".tmbl-plh").prop("disabled", false);
				$(".tmbl-stok").prop("disabled", false).removeAttr( "style");
				$(".tmbl-buffer").prop("disabled", false).removeAttr( "style");
				$(".box-data").show().html(response);
				$("#stat").val(stat);
			}
		});
	}

	function cek(nm_ker,g_label,width,otori){
		// stat = $("#stat").val();
		// alert(nm_ker+' '+g_label+' '+width+' '+otori,' '+stat)
		if(otori == "all" || otori == "admin" || otori == "office" || otori == "finance"){
			cekPenjualan(nm_ker,g_label,width);
			cekRoll(nm_ker,g_label,width,otori);
		}else if(otori == "qc" || otori == "fg"){
			cekRoll(nm_ker,g_label,width,otori);
		}else{
			'';
		}
	}

	function cekPenjualan(nm_ker,g_label,width){
		$(".isi-stok-tuan").html('');
		$("#modal-stok-list").modal("show");
		$(".isi-stok-list").html('Tunggu Sebentar . . .');
		$(".modal-header").html(`<h3>CEK UKURAN ${nm_ker} ${g_label} - ${width}</h3>`);
		$.ajax({
			url: '<?php echo base_url('Laporan/StokCekPO'); ?>',
			type: "POST",
			data: ({
				nm_ker: nm_ker,
				g_label: g_label,
				width: width,
			}),
			success: function(response){
				$(".isi-stok-list").html('');
				$(".isi-stok-list").html(response);
			}
		});
	}

	function cekRoll(nm_ker,g_label,width,otori){
		stat = $("#stat").val();
		tgl = $("#tgl").val();
		vtgl2 = $("#tgl2").val();
		pm = $("#p-pm-v").val();
		$(".tmpl-roll").show().html('Mencari Data . . .');
		$.ajax({
			url: '<?php echo base_url('Laporan/QCCariRoll'); ?>',
			type: "POST",
			data: ({
				jnsroll: nm_ker,
				gsmroll: g_label,
				ukroll: width,
				roll: '',
				tgl1: '',
				tgl2: '',
				opsi: 'cekRollStok',
				otori: otori,
				stat: stat,
				vtgl: tgl,
				vtgl2: tgl2,
				pm: pm,
			}),
			success: function(response){
				if(response){
					$(".tmpl-roll").show().html('TAMPIL DATA <b>'+nm_ker+' '+g_label+'</b> - <b>'+width+'</b> :<div class="clear"></div>'+response);
				}else{
					$(".tmpl-roll").html('Data Tidak ditemukan...');
				}
			}
		});
	}

	function cekRollEdit(roll){
		$(".isi-qc-terjual").html('');
		$(".isi-qc-edit").html('Tunggu Sebentar . . .');
		$("#modal-qc-list").modal("show");
		$.ajax({
			url: '<?php echo base_url('Laporan/QCShowEditRoll')?>',
			type: "POST",
			data: ({
				roll: roll,
			}),
			success: function(response){
				$(".isi-qc-edit").html(response);
			}
		});
	}

	function editRoll(i){ //
		otorisasi = $("#otorisasi").val();
		ket = $("#eket-"+i).val().toUpperCase();
		status = $("#opt_status-"+i).val();
		// alert(tgl+' - '+g_ac+' - '+rct+' - '+bi+' - '+nm_ker+' - '+g_label+' - '+width+' - '+diameter+' - '+weight+' - '+joint+' - '+ket+' - '+status+' - '+pilihan);

		// MENAMPUNG DATA LAMA
		lroll = $("#lroll-"+i).val();
		lnm_ker = $("#lnm_ker-"+i).val();
		lg_label = $("#lg_label-"+i).val();
		lwidth = $("#lwidth-"+i).val();
		lweight = $("#lweight-"+i).val();
		ldiameter = $("#ldiameter-"+i).val();
		ljoint = $("#ljoint-"+i).val();
		lket = $("#lket-"+i).val();
		lstatus = $("#lstatus-"+i).val();
		// console.log(lroll,lnm_ker,lg_label,lwidth,lweight,ldiameter,ljoint,lket,lstatus);

		$.ajax({
			url: '<?php echo base_url('Master/editQCRoll') ?>',
			type: "POST",
			data: ({
				id : i,
				nm_ker: lnm_ker,
				g_label: lg_label,
				width: lwidth,
				weight: lweight,
				diameter: ldiameter,
				joint: ljoint,
				ket : ket,
				status : status,
				lroll: lroll,
				lnm_ker: lnm_ker,
				lg_label: lg_label,
				lwidth: lwidth,
				lweight: lweight,
				ldiameter: ldiameter,
				ljoint: ljoint,
				lket: lket,
				lstatus: lstatus,
				edit: 'ListStokGudang',
			}),
			success: function(data) {
				json = JSON.parse(data);
				showNotification("alert-success", "BERHASIL!!!", "top", "center", "", "");
				$("#etgl-"+i).val(json.tgl).animateCss('fadeInRight');
				$("#eg_ac-"+i).val(json.g_ac).animateCss('fadeInRight');
				$("#erct-"+i).val(json.rct).animateCss('fadeInRight');
				$("#ebi-"+i).val(json.bi).animateCss('fadeInRight');
				$("#enm_ker-"+i).val(json.nm_ker).animateCss('fadeInRight');
				$("#eg_label-"+i).val(json.g_label).animateCss('fadeInRight');
				$("#ewidth-"+i).val(json.width).animateCss('fadeInRight');
				$("#ediameter-"+i).val(json.diameter).animateCss('fadeInRight');
				$("#eweight-"+i).val(json.weight).animateCss('fadeInRight');
				$("#ejoint-"+i).val(json.joint).animateCss('fadeInRight');
				$("#eket-"+i).val(json.ket).animateCss('fadeInRight');
				$("#opt_status-"+i).val(json.status).animateCss('fadeInRight');
		
				// MENAMPUNG DATA LAMA
				$("#lroll-"+i).val(json.roll);
				$("#lnm_ker-"+i).val(json.nm_ker);
				$("#lg_label-"+i).val(json.g_label);
				$("#lwidth-"+i).val(json.width);
				$("#lweight-"+i).val(json.weight);
				$("#ldiameter-"+i).val(json.diameter);
				$("#ljoint-"+i).val(json.joint);
				$("#lket-"+i).val(json.ket);
				$("#lstatus-"+i).val(json.status);
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

</script>
