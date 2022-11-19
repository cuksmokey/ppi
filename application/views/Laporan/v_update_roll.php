<section class="content">
        <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <ol class="breadcrumb">
                                    <li class="">UPDATE PENJUALAN ROLL</li>
                                </ol>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="box-data">
                              <table width="80%">
                                <tr>
                                  <td width="15%">
                                      Packing List
                                  </td>
                                  <td>:</td>
                                  <td colspan="3">
                                    <select name="" id="jenis" class="form-control" style="margin: 5px">
                                      <option value="0">Pilih Ukuran</option>
                                      <?php
                                        include 'connect.php';

                                        $sql = mysql_query("SELECT a.id,a.nm_perusahaan FROM m_perusahaan a
                                        INNER JOIN pl b ON a.id = b.id_perusahaan
                                        INNER JOIN m_timbangan c ON b.id = c.id_pl
                                        WHERE (c.nm_ker='MH' OR c.nm_ker='MI')
                                        GROUP BY a.id,a.nm_perusahaan
                                        ORDER BY a.nm_perusahaan ASC");
                                        
                                        while($data=mysql_fetch_array($sql)) {

                                        if($data['id'] == 9){
                                          $content = "TANGERANG";
                                        }else if($data['id'] == 10){
                                          $content = "KARAWANG";
                                        }else if($data['id'] == 11){
                                          $content = "CIBITUNG";
                                        }else if($data['id'] == 16){
                                          $content = "SADANG";
                                        }else if($data['id'] == 17){
                                          $content = "TANGERANG";
                                        }else{
                                          $content = "";
                                        }

                                      ?>

                                      <option value="<?=$data['id']?>"><?=$data['id']?> || <?=$data['nm_perusahaan']?> <?=$content?></option>
                                      
                                      <?php
                                        }
                                      ?>
                                    </select>

                                  </td>
                                  
                                </tr>
                               <!--  <tr>
                                  <td width="15%">
                                      Periode
                                  </td>
                                  <td>:</td>
                                  <td>
                                    <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" id="tgl1" style="margin: 5px">
                                  </td>
                                  <td align="center">S/d</td>
                                  <td>
                                    <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" id="tgl2" style="margin: 5px">
                                  </td>
                                </tr> -->
                                <tr>
                                  <td colspan="5">
                                    <br>
                                    
                                  </td>
                                </tr>
<!--                                 <tr>
                                  <td width="15%">
                                    <input name="group5" type="radio" id="radio_48" class="with-gap radio-col-black" />
                                      <label for="radio_48">Per Bulan</label>
                                  </td>
                                  <td>:</td>
                                  <td>
                                    <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" id="tgl1">
                                  </td>
                                  <td align="center">S/d</td>
                                  <td>
                                    <input type="date" class="form-control" value="<?= date('Y-m-d') ?>" id="tgl2">
                                  </td>
                                </tr> -->
                                <tr>
                                  <td colspan="5">
                                    <br>
                                    
                                  </td>
                                </tr>
                                <tr>
                                  <td align="center" colspan="5">
                                    <button type="button" onclick="cetak(0)" class="btn btn-default btn-sm waves-effect">
                                        <!-- <i class="material-icons">personal_video</i> -->
                                        CETAK LAYAR
                                    </button>
                                    <!-- <button type="button" onclick="cetak(1)" class="btn btn-default btn-sm waves-effect">
                                        <i class="material-icons">print </i>
                                        CETAK EXCEL
                                    </button> -->
                                    <!-- <button type="button" onclick="cetak(2)" class="btn btn-default btn-sm waves-effect">
                                        <i class="material-icons">Download</i>
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
    jenis = $("#jenis").val(); 
    // tgl1 = $("#tgl1").val();
    // tgl2 = $("#tgl2").val();

    if (jenis == 0){
      showNotification("alert-info", "PILIH PT DULU !!!", "top", "center", "", ""); return;
    }
    // else if(jenis == 'ALL' && ctk == 1){
    //   showNotification("alert-info", "TIDAK BISA CETAK EXCEL !!!", "top", "center", "", ""); return;
    // }
    
    // if(jenis == 'ALL_REKAP'){

    // }

    var url    = "<?php echo base_url('Laporan/print_penjualan_roll?'); ?>";
    window.open(url+'jenis='+jenis+'&ctk='+ctk, '_blank');  
    // window.open(url+'ctk='+ctk, '_blank');  

  }

    
</script>