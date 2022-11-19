<?php
class M_master extends CI_Model{
 	
 	function __construct(){
        parent::__construct();
        
        date_default_timezone_set('Asia/Jakarta');
        $this->db = $this->load->database('default', TRUE);
        
    }

    public function upload($file,$nama,$lokasi){
        // $file = 'foto';
        // unlink('../assets/images/member/'.$nama);
        $config['upload_path'] = './assets/images/'.$lokasi.'/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '20480';
        $config['remove_space'] = TRUE;
        $config['file_name'] = $nama;
    
        $this->load->library('upload', $config); // Load konfigurasi uploadnya
        if($this->upload->do_upload($file)){ // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        }else{
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

    function insert_histori($buk,$nmf){
    $tgli = date('Y-m-d');
    $jmi = date('H:i:s');
    $user = $this->session->userdata('username');
    $nm_user = $this->session->userdata('nm_user');

    $data1 = array(
                'buk'      => $buk,
                'usr'      => $user,
                'usn'      => $nm_user,
                'ip'      => $this->get_client_ip(),
                'nmf'      => $nmf,
                'tgi'      => $tgli,
                'jmi'      => $jmi,
            );
      return $this->db->insert("mylog",$data1);
  }
  function get_client_ip() {
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
         $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';
      return $ipaddress;
  }
   
    function get_data($table){
        $query = "SELECT * FROM $table";
        return $this->db->query($query);
    }

    function get_data_order($table,$order,$by){
        $query = "SELECT * FROM $table ORDER BY $order $by";
        return $this->db->query($query);
    }

    function get_count($table){
        $query = "SELECT count(*) as jumlah FROM $table";
        return $this->db->query($query);
    }



    function get_data_one($table,$kolom,$id){
        
        $query = "SELECT * FROM $table WHERE $kolom='$id'";
        return $this->db->query($query);
    }


    function query($query1){
        
        $query = $query1;
        return $this->db->query($query);
    }


    function get_data_max($table,$kolom){
        $query = "SELECT IFNULL(LPAD(MAX(RIGHT($kolom,5))+1,5,0),'00001')AS nomor FROM $table";
        return $this->db->query($query);
    }

    function delete($tabel,$kolom,$id){
        
        $query = "DELETE FROM $tabel WHERE $kolom = '$id' ";
        $result =  $this->db->query($query);
        return $result;
    }

    function get_timbangan(){
        $query = "SELECT * FROM m_timbangan WHERE status = '0' ORDER BY id DESC ";
        return $this->db->query($query);
    }

    function get_view_timbangan($id){
        $query = "SELECT * FROM m_timbangan WHERE id_pl = '$id' ";
        return $this->db->query($query);
    }

    function get_PL(){
        $query = "SELECT a.*,(SELECT COUNT(id_pl) FROM m_timbangan WHERE id_pl = a.id) AS jml_timbang FROM pl a ";
        return $this->db->query($query);
    }
	

    function insert_timbangan(){
        
        $data = array(
                'roll'     	=> $_POST['id'],
                'tgl'      => $_POST['tgl'],
                'nm_ker'       => $_POST['nm_ker'],
                'g_ac'      => $_POST['g_ac'],
                'g_label'      => $_POST['g_label'],
                'width'       => $_POST['width'],
                'weight'       => $_POST['weight'],
                'diameter'      => $_POST['diameter'],
                'joint'      => $_POST['joint'],
                'rct'      => $_POST['rct'],
                'ket'      => $_POST['ket']
            );
        $result= $this->db->insert("m_timbangan",$data);

        return $result;
    }

    function insert_pl(){
        
        $data = array(
                'tgl'      => $_POST['tgl'],
                'no_surat'      => str_replace(" ", "", $_POST['no_surat']),
                'no_so'       => $_POST['no_so'],
                'no_pkb'      => $_POST['no_pkb'],
                'no_kendaraan'      => $_POST['no_kendaraan'],
                'nama'       => $_POST['nama'],
                'id_perusahaan'       => $_POST['id_perusahaan'],
                'nm_perusahaan'       => $_POST['nm_perusahaan'],
                'alamat_perusahaan'      => $_POST['alamat_perusahaan'],
                'no_telp'      => $_POST['no_telp'],
                'no_po'      => $_POST['no_po']
            );


        $result= $this->db->insert("pl",$data);

        $no_surat = $_POST['no_surat'];
        $id = $this->db->query("SELECT id FROM pl WHERE no_surat = '$no_surat'")->row('id');

        foreach ($this->cart->contents() as $items) {
            $this->db->set('status', "1");
            $this->db->set('id_pl', $id);

            $this->db->where('roll', str_replace("_", "/", $items['name']));
            $result= $this->db->update('m_timbangan');
        }

        return $result;
    }

    function update_timbangan(){
        
        $this->db->set('nm_ker', $_POST['nm_ker']);
        $this->db->set('g_ac', $_POST['g_ac']);
        $this->db->set('g_label', $_POST['g_label']);
        $this->db->set('width', $_POST['width']);
        $this->db->set('weight', $_POST['weight']);
        $this->db->set('diameter', $_POST['diameter']);
        $this->db->set('joint', $_POST['joint']);
        $this->db->set('ket', $_POST['ket']);
        $this->db->set('rct', $_POST['rct']);
        $this->db->where('roll', $_POST['id']);
        $result = $this->db->update('m_timbangan');



        return $result;
    }

    function update_pl(){
        $no_surat = $_POST['no_surat_lama'];
        $id = $this->db->query("SELECT id FROM pl WHERE no_surat = '$no_surat'")->row('id');
        

        $this->db->set('tgl', $_POST['tgl']);
        $this->db->set('no_surat', $_POST['no_surat']);
        $this->db->set('no_so', $_POST['no_so']);
        $this->db->set('no_pkb', $_POST['no_pkb']);
        $this->db->set('no_kendaraan', $_POST['no_kendaraan']);
        $this->db->set('nama', $_POST['nama']);
        $this->db->set('nm_perusahaan', $_POST['nm_perusahaan']);
        $this->db->set('alamat_perusahaan', $_POST['alamat_perusahaan']);
        $this->db->set('no_telp', $_POST['no_telp']);
        $this->db->set('no_po', $_POST['no_po']);

        $this->db->set('updated_at', date('Y-m-d H:i:s'));
        $this->db->set('updated_by', $this->session->userdata('username'));
        $this->db->where('id', $id);
        $result = $this->db->update('pl');

        $this->db->set('status', "0");
        $this->db->set('id_pl', "0");

        $this->db->where('id_pl', $id);
        $result= $this->db->update('m_timbangan');

        foreach ($this->cart->contents() as $items) {
            $this->db->set('status', "1");
            $this->db->set('id_pl', $id);

            $this->db->where('roll', str_replace("_", "/", $items['name']));
            $result= $this->db->update('m_timbangan');
        }

        return $result;
    }

    function get_lok($searchTerm=""){

     

     $users = $this->db->query("SELECT * FROM lok WHERE acc like '%$searchTerm%' or  ket like '%$searchTerm%' ORDER BY ket ")->result_array();

     // Initialize Array with fetched data
     $data = array();
     foreach($users as $user){
        $data[] = array(
            "id"=>$user['acc'], 
            "text"=>$user['acc']
        );
     }
     return $data;
  }

    function get_perusahaan(){
        $query = "SELECT * FROM m_perusahaan ORDER BY id DESC ";
        return $this->db->query($query);
    }

    function insert_perusahaan(){
        
        $data = array(
                'pimpinan'      => $_POST['pimpinan'],
                'nm_perusahaan'       => $_POST['nm_perusahaan'],
                'alamat'      => $_POST['alamat'],
                'no_telp'      => $_POST['no_telp'],
                'created_by'      => $this->session->userdata('username')
            );
        $result= $this->db->insert("m_perusahaan",$data);

        return $result;
    }

    function update_perusahaan(){
        
        $this->db->set('pimpinan', $_POST['pimpinan']);
        $this->db->set('nm_perusahaan', $_POST['nm_perusahaan']);
        $this->db->set('alamat', $_POST['alamat']);
        $this->db->set('no_telp', $_POST['no_telp']);
        $this->db->where('id', $_POST['id']);
        $result = $this->db->update('m_perusahaan');



        return $result;
    }

    function list_perusahaan($searchTerm=""){

     

     $users = $this->db->query("SELECT * FROM m_perusahaan WHERE pimpinan like '%$searchTerm%' or  nm_perusahaan like '%$searchTerm%' ORDER BY pimpinan ")->result_array();

     // Initialize Array with fetched data
     $data = array();
     foreach($users as $user){
        $data[] = array(
            "id"=>$user['id'], 
            "text"=>$user['pimpinan'], 
            "no_telp"=>$user['no_telp'], 
            "alamat"=>$user['alamat'], 
            "nm_perusahaan"=>$user['nm_perusahaan']
        );
     }
     return $data;
    }

    function list_sj($searchTerm=""){

     $users = $this->db->query("SELECT * FROM pl WHERE STATUS ='Open' and (no_surat like '%$searchTerm%' or  nm_perusahaan like '%$searchTerm%') ORDER BY no_surat ")->result_array();

     // Initialize Array with fetched data
     $data = array();
     foreach($users as $user){
        $data[] = array(
            "id"=>$user['no_surat'], 
            "text"=>$user['no_surat'], 
            "no_po"=>$user['no_po'], 
            "no_telp"=>$user['no_telp'], 
            "pimpinan"=>$user['nama'], 
            "id_perusahaan"=>$user['id_perusahaan'],
            "alamat"=>$user['alamat_perusahaan'], 
            "nm_perusahaan"=>$user['nm_perusahaan']
        );
     }
     return $data;
    }

    function get_invoice(){
        $query = "SELECT a.*,(SELECT SUM(harga) FROM tr_invoice WHERE no_invoice = a.no_invoice)AS total FROM th_invoice a ORDER BY jto DESC,no_invoice asc";
        return $this->db->query($query);
    }

    function get_barang(){
        $no_surat = $_POST['no_surat'];
        $query = "SELECT a.g_label AS g_label,CONCAT('LB ', a.width) AS lb,COUNT(a.roll) AS roll,b.no_po,SUM(weight) weight FROM m_timbangan a JOIN pl b
            ON a.`id_pl` = b.id
            WHERE no_surat = '$no_surat'
            GROUP BY a.width";
        return $this->db->query($query);
    }

    function insert_invoice(){
        $data = array(
                'no_invoice'    => $_POST['id'],
                'jto'           => $_POST['jto'],
                'no_surat'      => $_POST['no_surat'],
                'no_po'         => $_POST['no_po'],
                'id_perusahaan' => $_POST['id_perusahaan'],
                'kepada'        => $_POST['nama'],
                'nm_perusahaan' => $_POST['nm_perusahaan'],
                'alamat'        => $_POST['alamat_perusahaan']
            );

        $result= $this->db->insert("th_invoice",$data);

        $gsm = "";
        foreach ($this->cart->contents() as $items) {
            $this->db->set('no_invoice', $_POST['id']);
            $this->db->set('g_label', $items['options']['gsm']);
            $this->db->set('width_lb', $items['name']);
            $this->db->set('roll', str_replace("_", "/", $items['options']['roll']));
            $this->db->set('satuan', $items['options']['satuan']);
            $this->db->set('jumlah', $items['qty']);
            $this->db->set('harga', $items['price']);

            $result= $this->db->insert('tr_invoice');

            $gsm = $items['options']['gsm'];
        }

            $this->db->set('gsm', $gsm);
            $this->db->where('no_invoice', $_POST['id']);
            $result= $this->db->update('th_invoice');

            $this->db->set('status', "Closed");
            $this->db->where('no_surat', $_POST['no_surat']);
            $result= $this->db->update('pl');

        return $result;
    }

    function reject()
    {
        $id = $_POST['id'];

        $no_surat = $this->db->get_where('th_invoice', array('id' => $id))->row("no_surat");

        $this->db->set('status', "Open");
        $this->db->where('no_surat', $no_surat);
        $result= $this->db->update('pl');

        $this->db->set('status', "Reject");
        $this->db->where('id', $id);
        $result= $this->db->update('th_invoice');

        return $result;
    }

  
 
}

?>
