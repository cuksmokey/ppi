<section class="content">
        <div class="container-fluid">
            
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <ol class="breadcrumb">
                                    <li class="">Master Perusahaan </li>
                                </ol>
                            </h2>
                        </div>

                        <div class="body">
                            <div class="box-data">
                              <table width="100%">
                                <tr>
                                  <td align="left"> <button type="button" class="btn-add btn btn-default btn-sm waves-effect">
                                        <!-- <i class="material-icons">library_add</i> -->
                                        <b><span>N E W</span></b>
                                    </button>
                                  </td>
                                </tr>
                              </table>
                            
                            
                              <br><br>
                                <table id="datatable11" class="table table-bordered table-striped table-hover dataTable ">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Pimpinan</th>
                                            <th>Nama Perusahaan</th>
                                            <th>Alamat</th>
                                            <th>No Telepon</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>

                            <!-- box form -->
                            <div class="box-form">
                                <center><div id="judul"></div></center>
                                <table width="70%">
                                   
                                    <tr>
                                        <td>Pimpinan</td>
                                        <td>:</td>
                                        <td  colspan="2">
                                            <input type="text" id="pimpinan" value="" class="form-control" style="width: 40%">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama Perusahaan</td>
                                        <td>:</td>
                                        <td colspan="2">
                                          <input type="hidden" id="id" value="" class="form-control" style="width: 40%">
                                          <input type="text" id="nm_perusahaan" value="" class="form-control" style="width: 40%">
                                          <input type="hidden" id="nm_perusahaan_lama" value="" class="form-control" style="width: 40%">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td colspan="2">
                                          <textarea id="alamat" cols="30" rows="5" class="form-control"></textarea> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>No Telepon</td>
                                        <td>:</td>
                                        <td colspan="2">
                                            <input type="text" class="form-control" placeholder=""  id="no_telp"> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="right">
                                            <br>
                                            
                                        </td>
                                    </tr>
                                </table>
                               

                                <!-- <button type="button" class="btn-kembali btn btn-dark btn-sm waves-effect waves-circle waves-float"> -->
                                <button type="button" class="btn-kembali btn btn-dark btn-default btn-sm waves-effect">
                                    <!-- <i class="material-icons">arrow_back</i> -->
                                    <b><span>BACK</span></b>
                                </button> &nbsp;&nbsp;&nbsp;&nbsp;
                                <button onclick="simpan()" id="btn-simpan" type="button" class="btn bg-light-green btn-sm waves-effect">
                                    <!-- <i class="material-icons">save</i> -->
                                    <b><span id="txt-btn-simpan">SIMPAN</span></b>
                                </button> &nbsp;&nbsp;&nbsp;&nbsp;
                                <button onclick="kosong()" type="button" class="btn btn-default btn-sm waves-effect">
                                    <!-- <i class="material-icons">note_add</i> -->
                                    <b><span>TAMBAH DATA</span></b>
                                </button>
                            </div>

                           
                    </div>


                </div>
            </div>
            <!-- #END# Exportable Table -->
        </div>
    </section>

<script>
  status = '';
    $(document).ready(function(){
      $(".box-form").hide();
     load_data();

    $("input.angka").keypress(function(event) { //input text number only
            return /\d/.test(String.fromCharCode(event.keyCode));
      });

     
    });

    $(".btn-add").click(function(){
        status = 'insert';
        kosong();
        // getmax();
        $(".box-data").hide();
        $(".box-form").show();
        $("#judul").html('<h3> Form Tambah Data</h3>');
      $('.box-form').animateCss('fadeInDown');
    });

    $(".btn-kembali").click(function(){
        $(".box-form").hide();
        $(".box-data").show();
        $('.box-data').animateCss('fadeIn');
        load_data();
    });

    function reloadTable(){
      table = $('#datatable11').DataTable();
       tabel.ajax.reload(null,false);
   }

    function load_data(){
      var table = $('#datatable11').DataTable();

         table.destroy();

         tabel = $('#datatable11').DataTable({

               "processing": true,
               "pageLength":true,
               "paging": true,
               "ajax": {
                   "url" : '<?php echo base_url(); ?>Master/load_data' ,
                   "data" : ({jenis:"Perusahaan"}),
                   "type": "POST"
               },
               responsive: true,
               "pageLength": 10,
               "language": {
                       "emptyTable":     "Tidak ada data.."
                   },
               "order": [[ 0, "asc" ]]
               });

     /*var table = $('#datatable11').DataTable();

         table.destroy();

     tabel = $('#datatable11').DataTable({

                ordering: false,
                processing: true,
                serverSide: true,
                ajax: {
                  url: '<?php echo base_url(); ?>Master/load_data',
                  data : ({jenis:"Timbangan"}),
                  type:'POST',
                }
           });*/

    }


    function simpan(){
      roll = $("#id1").val()+"/"+$("#id2").val()+"/"+$("#id3").val()+"/"+$("#id4").val();
      
      pimpinan     = $("#pimpinan").val();
      nm_perusahaan  = $("#nm_perusahaan").val();
      nm_perusahaan_lama  = $("#nm_perusahaan_lama").val();
      no_telp    = $("#no_telp").val();
      alamat    = $("textarea#alamat").val();
      id    = $("#id").val();
        
        if (nm_perusahaan == "" || alamat == ""|| no_telp == ""|| pimpinan == "")  {
          showNotification("alert-info", "Harap Lengkapi Form", "bottom", "center", "", ""); return;
        }

        $("#btn-simpan").prop("disabled",true);
        

        $.ajax({
            type     : "POST",
            url      : '<?php echo base_url(); ?>Master/'+status,
            data     : ({id:id , pimpinan:pimpinan , nm_perusahaan:nm_perusahaan ,nm_perusahaan_lama:nm_perusahaan_lama , alamat:alamat , no_telp:no_telp ,jenis : "Perusahaan" }),
            dataType : "json",
            success  : function(data){
              $("#btn-simpan").prop("disabled",true);
              if (data.data == true) {
                
                reloadTable();
                showNotification("alert-success", "Berhasil", "bottom", "center", "", "");
                
               status = 'update';

              }else{
                showNotification("alert-danger", "Nama Perusahaan Sudah Ada", "bottom", "center", "", "");
              }
              
            }
        });
    }

    function tampil_edit(id){
    $(".box-data").hide();
    $(".box-form").show();
    $('.box-form').animateCss('fadeInDown');
    $("#judul").html('<h3> Form Edit Data</h3>');

    

    status = "update";

         $.ajax({
              url: '<?php echo base_url('Master/get_edit'); ?>',
              type: 'POST',
              data: {id: id,jenis:"Perusahaan"},
          })
          .done(function(data) {
               json = JSON.parse(data);

              $("#nm_perusahaan").val(json.nm_perusahaan);
              $("#nm_perusahaan_lama").val(json.nm_perusahaan);
              $("#no_telp").val(json.no_telp);
              $("#pimpinan").val(json.pimpinan);
              $("#id").val(json.id);
              $("textarea#alamat").val(json.alamat);

          }) 

    }
    function deleteData(id,nm){
        swal({
          title: "Apakah Anda Yakin ?",
          text: nm,
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
              url   : '<?php echo base_url(); ?>Master/hapus/',
              type  : "POST",
              data  : {id: id,jenis:"Perusahaan"},
              success : function(data){
                if (data == 1) {
                swal("Berhasil", "", "success");
                reloadTable();

                }else{
                  swal("Data Sudah dilakukan transaksi", "", "error");
                }
              }
            });
            
          } else {
            swal("", "Data Batal dihapus", "error");
          }
        });

    }

    function kosong(){
      $("#judul").html('<h3> Form Tambah Data</h3>');
      status = "insert";
      $("#id").val("");
      $("#nm_perusahaan").val("");
      $("#nm_perusahaan_lama").val("");
      $("textarea#alamat").val("");
      $("#pimpinan").val("");
      $("#no_telp").val("");

      $("#btn-simpan").prop("disabled",false);
      $("#txt-btn-simpan").html("Simpan");
    }
    
</script>