<section class="content">
        <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <ol class="breadcrumb">
                                    <li class="">Penjualan Tahunan</li>
                                </ol>
                            </h2>
                        </div>

                        <div class="body">
                            <div class="box-data">
                              <table width="80%">
                                <tr>
                                  <td width="15%">Tahun</td>
                                  <td>:</td>
                                  <td>
                                    <!-- <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" id="tgl1" style="margin: 5px"> -->
                                    <select name="" id="tahun" class="form-control" style="margin: 5px">
                                      <option value="">Pilih . . .</option>
                                      <option value="2020">2020</option>
                                      <option value="2021">2021</option>
                                    </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="5">
                                    <br>
                                    
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="5">
                                    <br>
                                    
                                  </td>
                                </tr>
                                <tr>
                                  <td align="center" colspan="5">
                                    <button type="button" onclick="cetak(0)" class="btn btn-default btn-sm waves-effect">
                                        Cetak Layar
                                    </button>
                                    <!-- <button type="button" onclick="cetak(1)" class="btn btn-default btn-sm waves-effect">
                                        <i class="material-icons">print </i>
                                        PDF
                                    </button> -->
                                    <!-- <button type="button" onclick="cetak(2)" class="btn btn-default btn-sm waves-effect">
                                        Download
                                    </button> -->
                                  </td>
                                </tr>
                              </table>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
        </div>
    </section>

<script>
  
   function cetak(ctk){
    tahun = $("#tahun").val();

    if(tahun == ""){
      showNotification("alert-info", "Pilih Tahun", "bottom", "right", "", ""); return;
    }

    var url    = "<?php echo base_url('Laporan/penjualanPerTahun?'); ?>";
    window.open(url+'tahun='+tahun, '_blank');  

   }

    
</script>