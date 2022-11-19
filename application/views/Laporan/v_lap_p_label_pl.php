<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <ol class="breadcrumb">
                                    <li class="">PRINT LABEL PACKING LIST</li>
                                </ol>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="box-data">
                              <table width="80%">
                                <tr>
                                  <td width="15%">
                                      Per Packing List
                                  </td>
                                  <td>:</td>
                                  <td colspan="3">
                                    <select name="" id="jenis" class="form-control" style="margin: 5px">
                                      <option value="0">Per PL</option>
                                      <?php
                                          include 'connect.php';

                                          $sql = mysql_query("SELECT DISTINCT b.id as id,b.tgl as tgl,b.no_pkb as no,b.nama,b.nm_perusahaan as np,a.width AS uk,COUNT(*) as tot FROM m_timbangan a
                                                INNER JOIN pl b ON a.id_pl=b.id
												WHERE b.nm_perusahaan!='LAMINASI PPI' AND b.nm_perusahaan!='CORRUGATED PPI' AND b.tgl!='0000-00-00'
                                                GROUP BY id,no,np,uk
                                                ORDER BY tgl DESC,no DESC,np,uk DESC");
                                          while($data=mysql_fetch_array($sql)) {
											if($data['np'] == '-'){
												$nmPt = $data['nama'];
											}else{
												$nmPt = $data['np'];
											}
                                      ?>
                                      <option value="<?=$data['id']?>"><?=$data['id']?> || <?=$data['tgl']?> || <?=$data['no']?> || <?=$nmPt?> || <?=round($data['uk'],2)?> || ( <?=$data['tot']?> )</option>
                                      <?php } ?>
                                    </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="15%">
                                      Packing List ALL
                                  </td>
                                  <td>:</td>
                                  <td colspan="3">
                                    <select name="" id="all_pl" class="form-control" style="margin: 5px">
                                      <option value="0">ALL</option>
                                      <?php
                                          include 'connect.php';

                                          $sql = mysql_query("SELECT b.tgl,b.no_pkb,b.nama,b.nm_perusahaan,COUNT(*) AS tot FROM m_timbangan a
                                          INNER JOIN pl b ON a.id_pl=b.id
										  WHERE b.nm_perusahaan!='LAMINASI PPI' AND b.nm_perusahaan!='CORRUGATED PPI' AND b.tgl!='0000-00-00'
                                          GROUP BY b.no_pkb,b.nm_perusahaan
                                          ORDER BY tgl DESC,b.no_pkb DESC");
                                          while($data=mysql_fetch_array($sql)) {
											if($data['nm_perusahaan'] == '-'){
												$namapete = $data['nama'];
											}else{
												$namapete = $data['nm_perusahaan'];
											}
                                      ?>
                                      <option value="<?=$data['no_pkb']?>"><?=$data['tgl']?> || <?=$data['no_pkb']?> || <?=$namapete?>  || ( <?=$data['tot']?> )</option>
                                      <?php } ?>
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
                                        <!-- <i class="material-icons">personal_video</i> -->
                                        CETAK LABEL BESAR
                                    </button>
                                    <button type="button" onclick="cetak(1)" class="btn btn-default btn-sm waves-effect">
                                        <!-- <i class="material-icons">print </i> -->
                                        cetak label kecil
                                    </button>
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
    all = $("#all_pl").val(); 


    if (jenis == 0 && all == 0){
      showNotification("alert-info", "PILIH PACKING LIST DAHULU !!!", "top", "center", "", ""); return;
    }else if (jenis != 0 && all != 0){
      showNotification("alert-info", "PILIH SALAH SATU PL !!", "top", "center", "", ""); return;
    }else{
      var url    = "<?php echo base_url('Laporan/print_lbl_pl?'); ?>";
      window.open(url+'jenis='+jenis+'&all='+all+'&ctk='+ctk, '_blank');
    }
    
    
  }

    
</script>
