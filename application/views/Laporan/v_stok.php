<section class="content">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							<ol class="breadcrumb">
								<li class="">STOK GUDANG</li>
							</ol>
						</h2>
					</div>

					<div class="body">
						<button onclick="load_data('all')">SEMUA</button>
						<button onclick="load_data('mh')">MEDIUM</button>
						<button onclick="load_data('bk')">B - KRAFT</button>
						<button onclick="load_data('mhbk')">MEDIUM - BK</button>
						<button onclick="load_data('nonspek')">MEDIUM NON SPEK</button>
						<button onclick="load_data('wp')">W R P</button>
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
		$(".loading").show().html(`Memuat data ${jenis}. Tunggu Sebentar...`);
		$(".box-data").html('');
		// tgl_ctk = $("#tgl_ctk").val();
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
