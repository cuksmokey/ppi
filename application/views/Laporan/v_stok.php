<style>
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
</style>

<section class="content">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							<ol class="breadcrumb">
								<li style="font-weight:bold">STOK GUDANG</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<!-- <button onclick="load_data('all')">SEMUA</button> -->
						<button class="tmbl-stok" onclick="load_data('mh')">MEDIUM</button>
						<button class="tmbl-stok" onclick="load_data('bk')">B - KRAFT</button>
						<button class="tmbl-stok" onclick="load_data('mhbk')">MEDIUM - B-KRAFT</button>
						<button class="tmbl-stok" onclick="load_data('nonspek')">MEDIUM NON SPEK</button>
						<button class="tmbl-stok" onclick="load_data('wp')">W R P</button>
						<br/><br/>
						
						<div class="loading"></div>
						<div class="box-data"></div>
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

<script>
	$(document).ready(function(){
		$(".box-data").hide();
		$(".loading").hide();
	});

	function NumberFormat(num) {
		return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
	}

	function load_data(jenis){
		// mh, bk, mhbk, nonspek, wp
		if(jenis == 'mh'){
			Njenis = 'MEDIUM';
		}else if(jenis == 'bk'){
			Njenis = 'B - KRAFT';
		}else if(jenis == 'mhbk'){
			Njenis = 'MEDIUM - B-KRAFT';
		}else if(jenis == 'nonspek'){
			Njenis = 'MEDIUM NON SPEK';
		}else if(jenis == 'wp'){
			Njenis = 'WP';
		}else{
			Njenis = '...';
		}
		$(".loading").show().html(`Memuat data ${Njenis}. Tunggu Sebentar . . .`);
		$(".box-data").html('');
		$.ajax({
			url: '<?php echo base_url('Laporan/NewStokGudang'); ?>',
			type: "POST",
			data: ({
				jenis: jenis,
			}),
			success: function(response){
				$(".loading").html('').hide();
				$(".box-data").show().html(response);
			}
		});
	}

	function cek_stok(nm_ker,g_label,width){
		$(".isi-stok-tuan").html('');
		$("#modal-stok-list").modal("show");
		$(".isi-stok-list").html('Tunggu Sebentar . . .');
		$(".modal-header").html(`<h3>CEK UKURAN ${nm_ker} ${g_label} - ${NumberFormat(width)}</h3>`);
		// alert(nm_ker+' '+g_label+' '+width)
		$.ajax({
			url: '<?php echo base_url('Laporan/StokCekPO'); ?>',
			type: "POST",
			data: ({
				nm_ker: nm_ker,
				g_label: g_label,
				width: width,
			}),
			// dataType: "json",
			success: function(response){
				// response = JSON.parse(data);
				$(".isi-stok-list").html('');
				$(".isi-stok-list").html(response);
				// stok_bertuan();
			}
		});
	}

	// function stok_bertuan(){
	// 	// $(".isi-stok-tuan").html('Bertuan');
	// }

</script>
