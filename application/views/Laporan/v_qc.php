<section class="content">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							<ol class="breadcrumb">
								<li class="">Q C</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<button onclick="opsi('roll')">PER ROLL</button>
						<button onclick="opsi('tgl')">PER TANGGAL</button><br/><br/>

						<div class="per_roll">
							<input type="text" name="proll" id="proll" style="border:1px solid #ccc;padding:5px;border-radius:5px">
						</div>
						<div class="per_tgl">
							<input type="date" name="tgl1" id="tgl1" value="<?=date('Y-m-d')?>" style="padding:3px;border:1px solid #ccc;border-radius:5px">
							s/d
							<input type="date" name="tgl2" id="tgl2" value="<?=date('Y-m-d')?>" style="padding:3px;border:1px solid #ccc;border-radius:5px">
							<button style="background:#f44336;color:#fff;padding:4px 6px;border:0;border-radius:3px">CARI</button>
						</div>

						<div class="isi"></div>
					</div>
				</div>
			</div>
</section>

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
		$(".per_roll").hide();
		$(".per_tgl").hide();
		// load_data();
	});

	function opsi(opsi){
		if(opsi == 'roll'){
			$(".per_roll").show();
			$(".per_tgl").hide();
		}else{
			$(".per_roll").hide();
			$(".per_tgl").show();
		}
	}

	// $(".per_tgl").keydown

	// function NumberFormat(num) {
	// 	return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
	// }

	// function load_data(jenis){
	// 	$(".loading").show().html(`Memuat data ${jenis}. Tunggu Sebentar...`);
	// 	$(".box-data").html('');
	// 	// tgl_ctk = $("#tgl_ctk").val();
	// 	$.ajax({
	// 		url: '<?php echo base_url('Laporan/NewStokGudang'); ?>',
	// 		type: "POST",
	// 		data: ({
	// 			jenis: jenis,
	// 		}),
	// 		success: function(response){
	// 			$(".loading").html('').hide();
	// 			$(".box-data").show().html(response);
	// 		}
	// 	});
	// }

</script>
