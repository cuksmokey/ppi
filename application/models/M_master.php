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

    function get_data_po_master($table,$kolom,$id_perusahaan,$nm_ker,$kolom2,$g_label,$kolom3,$width,$kolom4,$no_po){
        
        $query = "SELECT * FROM $table WHERE $kolom='$id_perusahaan' AND nm_ker='$nm_ker' AND $kolom2='$g_label' AND $kolom3='$width' AND $kolom4='$no_po'";
        return $this->db->query($query);
    }

    function get_plpl($no_pkb){
        
        // $query = "SELECT a.id_perusahaan AS id_perusahaan,a.tgl AS tgl,b.g_label AS g_label,b.width AS width,COUNT(b.roll) AS jml_roll,SUM(b.weight) AS tonase,a.no_surat,a.no_po AS no_po,a.id AS id_pl,a.no_pkb AS no_pkb FROM pl a
        // INNER JOIN m_timbangan b ON a.id = b.id_pl
        // WHERE a.id='$id_pl'
        // GROUP BY a.id_perusahaan,a.tgl,b.g_label,b.width,a.no_surat,a.no_po,a.id,a.no_pkb";
        
        $query = "SELECT a.id_perusahaan AS id_perusahaan,a.tgl AS tgl,b.nm_ker AS nm_ker,b.g_label AS g_label,b.width AS width,COUNT(b.roll) AS jml_roll,SUM(b.weight) AS tonase,a.no_surat,a.no_po AS no_po,a.id AS id_pl,a.no_pkb AS no_pkb FROM pl a
        INNER JOIN m_timbangan b ON a.id = b.id_pl
        WHERE a.no_pkb='$no_pkb'
        GROUP BY a.id_perusahaan,a.tgl,b.nm_ker,b.g_label,b.width,a.no_surat,a.no_po,a.id,a.no_pkb";
        
        return $this->db->query($query);
    }

    // function cek_po_master($g_label,$width,$no_po){
    function cek_po_master($nm_ker,$no_po){
        
        $query = "SELECT * FROM po_master WHERE nm_ker='$nm_ker' AND no_po='$no_po'";
        return $this->db->query($query);
    }

    function cek_uk_po_sblm_ins($gsm,$width,$no_po){
        
        $query = "SELECT a.g_label,a.width FROM po_master a
        INNER JOIN pl b ON a.no_po = b.no_po
        INNER JOIN m_timbangan c ON b.id = c.id_pl
        WHERE a.no_po='$no_po' AND a.g_label='$gsm' AND a.width='$width'
        GROUP BY a.g_label,a.width";
        return $this->db->query($query);
    }

    function get_cek_po_pl($id_pl,$no_pkb){
        $query = "SELECT nm_ker AS nm_ker_po,g_label AS g_label_po,width AS width_po FROM m_timbangan a
        INNER JOIN pl b ON a.id_pl = b.id
        WHERE a.id_pl='$id_pl' AND b.no_pkb='$no_pkb'
        GROUP BY nm_ker,g_label,width";
        return $this->db->query($query)->num_rows();
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

    function delete_master_po($table,$kolom,$kolom2,$kolom3,$g_label,$id_perusahaan,$width){
        
        $query = "DELETE FROM $table WHERE $kolom='$id_perusahaan' AND $kolom2='$g_label' AND $kolom3='$width'";
        $result =  $this->db->query($query);
        return $result;
    }

	function getMasterRoll(){
		$tgl = date('Y-m-d');
		if($this->session->userdata('level') == "Rewind1"){
			$pm = "AND pm='1'";
		}else if($this->session->userdata('level') == "Rewind2"){
			$pm = "AND pm='2'";
		}else{
			$pm = '';
		}
		$query = "SELECT * FROM m_timbangan WHERE (status = '0' OR status = '2' OR status = '3') AND id_pl='0' $pm
		AND tgl='$tgl' 
		-- AND tgl BETWEEN '2022-11-25' AND '2022-11-28' 
        -- LIMIT 5
		";
        return $this->db->query($query);
	}

    function get_timbangan(){
        $tgl = date('Y-m-d');

        // $query = "SELECT * FROM m_timbangan WHERE status = '0' ORDER BY id DESC";
		// $query = "SELECT * FROM m_timbangan WHERE (status = '0' OR status = '2' OR status = '3') AND id_pl='0'  ORDER BY id DESC LIMIT 100";
		$query = "SELECT * FROM m_timbangan WHERE (status = '0' OR status = '2' OR status = '3') AND id_pl='0' AND tgl='$tgl' ORDER BY id DESC";
        return $this->db->query($query);
    }

    function get_view_timbangan($id){
        $query = "SELECT * FROM m_timbangan WHERE id_pl = '$id' ";
        return $this->db->query($query);
    }

    function get_PL(){
        $tgl = date('Y-m-d');

        $tgl_k = date('Y-m-d', strtotime('-1 days', strtotime($tgl)));
        $tgl_t = date('Y-m-d', strtotime('+1 days', strtotime($tgl)));

        $query = "SELECT a.*,(SELECT COUNT(id_pl) FROM m_timbangan WHERE id_pl = a.id) AS jml_timbang
        FROM pl a
        WHERE tgl BETWEEN '$tgl_k' AND '$tgl_t'
        ORDER BY id DESC";
        return $this->db->query($query);
    }

    function getRollStlhEdit(){
        return $this->db->query("");
    }

    function insert_timbangan(){
        $data = array(
			'roll' => $_POST['id'],
			'tgl' => $_POST['tgl'],
			'nm_ker' => $_POST['nm_ker'],
			'g_ac' => $_POST['g_ac'],
			'g_label' => $_POST['g_label'],
			'width' => $_POST['width'],
			'weight' => $_POST['weight'],
			'diameter' => $_POST['diameter'],
			'joint' => $_POST['joint'],
			'rct' => $_POST['rct'],
			'bi' => $_POST['bi'],
			'status' => $_POST['cstatus'],
			'ket' => $_POST['ket'],
			'created_at' => date("Y-m-d H:i:s"),
			'created_by' => $this->session->userdata('username'),
			'pm' => $_POST['kodepm']
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

        foreach ($this->cart->contents() as $items) { //
            $this->db->set('status', "1");
            $this->db->set('id_pl', $id);

            $this->db->where('roll', str_replace("_", "/", $items['name']));
            $result= $this->db->update('m_timbangan');
        }

        return $result;
    }

    function update_timbangan(){
        $this->db->set('nm_ker', $_POST['nm_ker']);
        // $this->db->set('g_ac', $_POST['g_ac']);
        $this->db->set('g_label', $_POST['g_label']);
        $this->db->set('width', $_POST['width']);
        $this->db->set('weight', $_POST['weight']);
        $this->db->set('diameter', $_POST['diameter']);
        $this->db->set('joint', $_POST['joint']);
        $this->db->set('ket', $_POST['ket']);
        // $this->db->set('rct', $_POST['rct']);
        // $this->db->set('bi', $_POST['bi']);
        $this->db->set('status', $_POST['cstatus']);
        // $this->db->set('packing_at', date("Y-m-d H:i:s"));
        // $this->db->set('packing_by', $this->session->userdata('username'));
        $this->db->set('edited_at', date("Y-m-d H:i:s"));
        $this->db->set('edited_by', $this->session->userdata('username'));
        $this->db->where('roll', $_POST['id']);
        // $result = $this->db->update('m_timbangan');

        if(($_POST['lnm_ker'] == $_POST['nm_ker']) && ($_POST['lg_label'] == $_POST['g_label']) && ($_POST['lwidth'] == $_POST['width']) && ($_POST['lweight'] == $_POST['weight']) && ($_POST['ldiameter'] == $_POST['diameter']) && ($_POST['ljoint'] == $_POST['joint']) && ($_POST['lket'] == $_POST['ket']) && ($_POST['lstatus'] == $_POST['cstatus'])){
            $result = $this->db->update('m_timbangan');
		}else{
            $result = $this->db->update('m_timbangan');

            $data = array(
                'roll' => $_POST['id'],
                'nm_ker' => $_POST['lnm_ker'],
                'g_label' => $_POST['lg_label'],
                'width' => $_POST['lwidth'],
                'diameter' => $_POST['ldiameter'],
                'weight' => $_POST['lweight'],
                'joint' => $_POST['ljoint'],
                'status' => $_POST['lstatus'],
                'ket' => $_POST['lket'],
                'edited_at' => date("Y-m-d H:i:s"),
                'edited_by' => $this->session->userdata('username'),
            );

            $result= $this->db->insert("m_roll_edit",$data);
        }
		
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
        $this->db->set('id_perusahaan', $_POST['id_perusahaan']);
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

    function get_po_master(){
        // $query = "SELECT * FROM po_master";
        $query = "SELECT b.nm_perusahaan,a.* FROM po_master a
        INNER JOIN m_perusahaan b ON a.id_perusahaan = b.id";
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

    function insert_po_master(){
        
        $data = array(
                'id_perusahaan'  => $_POST['id_perusahaan'],
                'tgl' => $_POST['tgl'],
                'nm_ker' => $_POST['nm_ker'],
                'g_label' => $_POST['g_label'],
                'width' => $_POST['width'],
                'tonase' => $_POST['tonase'],
                'no_po'      => $_POST['no_po']
            );
        $result= $this->db->insert("po_master",$data);

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

    function update_master_po(){
            
        // $this->db->set('id_perusahaan', $_POST['id_perusahaan']);
        $this->db->set('tgl', $_POST['tgl']);
        // $this->db->set('g_label', $_POST['g_label']);
        // $this->db->set('width', $_POST['width']);
        $this->db->set('tonase', $_POST['tonase']);
        $this->db->set('no_po', $_POST['no_po']);
        $this->db->where('id_perusahaan', $_POST['id_perusahaan']);
        $this->db->where('g_label', $_POST['g_label']);
        $this->db->where('width', $_POST['width']);
        $result = $this->db->update('po_master');
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

	function list_no_invoice($searchTerm=""){
		// ASLI
		$users = $this->db->query("")->result_array();

		$data = array();
		foreach($users as $user){
			$data[] = array(
				"id"=>$user['no_surat'], 
				"text"=>$user['notice'], 
				"tgl"=>$user['tgl'], 
				"no_telp"=>$user['no_telp'], 
				"pimpinan"=>$user['nama'], 
				"id_perusahaan"=>$user['id_perusahaan'],
				"alamat"=>$user['alamat_perusahaan'], 
				"nm_perusahaan"=>$user['nm_perusahaan'],
				"id_pt"=>$user['id_perusahaan'],
				"id_pl_inv"=>$user['no_pl_inv'],
			);
		}
		return $data;
    }

    function list_sj($searchTerm=""){
		// ASLI
		$users = $this->db->query("SELECT CONCAT(a.tgl, ' - ',
			CASE WHEN a.nm_perusahaan != '-' AND a.nama != '-' THEN CONCAT(a.nama, ' - ', a.nm_perusahaan)
			WHEN a.nm_perusahaan != '-' AND a.nama = '-' THEN a.nm_perusahaan
			WHEN a.nm_perusahaan = '-' AND a.nama != '-' THEN a.nama ELSE a.nm_perusahaan END, ' - ',SUM(b.weight)) AS notice,a.* FROM pl a
		INNER JOIN m_timbangan b ON a.id = b.id_pl
		WHERE a.status = 'Open' AND a.no_pl_inv != '0' AND (a.nm_perusahaan LIKE '%$searchTerm%' OR a.nama LIKE '%$searchTerm%' OR a.tgl LIKE '%$searchTerm%')
		GROUP BY a.tgl,a.no_pl_inv
		ORDER BY a.tgl,a.nm_perusahaan,a.no_pl_inv")->result_array();

		$data = array();
		foreach($users as $user){
			$data[] = array(
				"id"=>$user['no_surat'], 
				"text"=>$user['notice'], 
				"tgl"=>$user['tgl'], 
				"no_telp"=>$user['no_telp'], 
				"pimpinan"=>$user['nama'], 
				"id_perusahaan"=>$user['id_perusahaan'],
				"alamat"=>$user['alamat_perusahaan'], 
				"nm_perusahaan"=>$user['nm_perusahaan'],
				"id_pt"=>$user['id_perusahaan'],
				"id_pl_inv"=>$user['no_pl_inv'],
			);
		}
		return $data;
    }

	function loadRkPl($searh = "", $rktgl = ""){ //
		$users = $this->db->query("SELECT*FROM pl
		WHERE tgl_pl='$rktgl' AND (nama LIKE '%$searh%' OR nm_perusahaan LIKE '%$searh%') AND (id_rk='' OR id_rk IS NULL)
		GROUP BY tgl_pl,opl")->result_array();

        $data = array();
        foreach($users as $user){
            if($user['nama'] == '-'){
                $nama = '';
            }else{
                $nama = $user['nama'].' - ';
            }
            if($user['nm_perusahaan'] == '-'){
                $nmpt = '';
            }else{
                $nmpt = $user['nm_perusahaan'];
            }
            $text = $nama.$nmpt;
            $data[] = array(
                "id" => $user['opl'].'_ex_'.$user['tgl_pl'],
                "text" => $text,
            );
        }
        return $data;
    }

    function loadRkPo($search = "", $opl = "", $tgl_pl = ""){
        $users = $this->db->query("SELECT*FROM pl
        WHERE tgl_pl='$tgl_pl' AND opl='$opl' AND no_po LIKE '%$search%'
        GROUP BY tgl_pl,opl,no_po")->result_array();

        $data = array();
        foreach($users as $user){
            $data[] = array(
                "id" => $user['opl'].'_ex_'.$user['tgl_pl'].'_ex_'.$user['no_po'],
                "text" => $user['no_po'],
            );
        }
        return $data;
    }

    function loadRkJns($search = "", $opl = "", $tglpl = "", $no_po = ""){
        $users = $this->db->query("SELECT*FROM pl
        WHERE tgl_pl='$tglpl' AND opl='$opl' AND no_po='$no_po' AND nm_ker LIKE '%$search%'
        GROUP BY tgl_pl,opl,no_po,nm_ker")->result_array();

        $data = array();
        foreach($users as $user){
            $data[] = array(
                "id" => $user['opl'].'_ex_'.$user['tgl_pl'].'_ex_'.$user['no_po'].'_ex_'.$user['nm_ker'],
                "text" => $user['nm_ker'],
            );
        }
        return $data;
    }

    function loadRkGsm($search = "", $opl = "", $tglpl = "", $no_po = "", $nmker = ""){
        $users = $this->db->query("SELECT*FROM pl
        WHERE tgl_pl='$tglpl' AND opl='$opl' AND no_po='$no_po' AND nm_ker='$nmker' AND g_label LIKE '%$search%'
        GROUP BY tgl_pl,opl,no_po,nm_ker,g_label")->result_array();

        $data = array();
        foreach($users as $user){
            $data[] = array(
                "id" => $user['opl'].'_ex_'.$user['tgl_pl'].'_ex_'.$user['no_po'].'_ex_'.$user['nm_ker'].'_ex_'.$user['g_label'],
                "text" => $user['g_label'],
            );
        }
        return $data;
    }

    function loadRkUkuran($search = "", $opl = "", $tglpl = "", $no_po = "", $nmker = "", $g_label =""){
        $users = $this->db->query("SELECT tgl_pl,opl,p.no_po,p.nm_ker,p.g_label,m.width FROM pl p
        INNER JOIN po_master m ON p.no_po=m.no_po AND p.id_perusahaan=m.id_perusahaan AND p.nm_ker=m.nm_ker AND p.g_label=m.g_label
        WHERE tgl_pl='$tglpl' AND opl='$opl' AND p.no_po='$no_po' AND p.nm_ker='$nmker' AND p.g_label='$g_label' AND m.width LIKE '%$search%'
        GROUP BY tgl_pl,opl,p.no_po,p.nm_ker,p.g_label,m.width")->result_array();

        $data = array();
        foreach($users as $user){
            $data[] = array(
                "id" => $user['opl'].'_ex_'.$user['tgl_pl'].'_ex_'.$user['no_po'].'_ex_'.$user['nm_ker'].'_ex_'.$user['g_label'].'_ex_'.$user['width'],
                "text" => round($user['width'],2),
            );
        }
        return $data;
    }

    //

    function loadPtPO($searchTerm="", $opsi=""){
        if($opsi == 'pl'){
            $users = $this->db->query("SELECT p.* FROM m_perusahaan p
            INNER JOIN po_master m ON p.id=m.id_perusahaan
            WHERE (p.pimpinan LIKE '%$searchTerm%' OR p.nm_perusahaan LIKE '%$searchTerm%' OR p.alamat LIKE '%$searchTerm%') AND m.status='open'
            GROUP BY p.pimpinan,p.nm_perusahaan,m.id_perusahaan,m.status")->result_array();
        }else{ // PO
            $users = $this->db->query("SELECT*FROM m_perusahaan pt WHERE NOT EXISTS (SELECT*FROM pl_box bx WHERE bx.id_perusahaan=pt.id)
            AND (pt.pimpinan LIKE '%$searchTerm%' OR pt.nm_perusahaan LIKE '%$searchTerm%' OR pt.alamat LIKE '%$searchTerm%')")->result_array();
        }        

        $data = array();
        foreach($users as $user){
            if($user['pimpinan'] == '' || $user['pimpinan'] == '-'){
                $nama = '';
            }else{
                $nama = $user['pimpinan'].' - ';
            }
            if($user['nm_perusahaan'] == '' || $user['nm_perusahaan'] == '-'){
                $pt = '';
            }else{
                $pt = $user['nm_perusahaan'].' - ';
            }
            // id pimpinan nm_perusahaan alamat no_telp
            $txt = $nama.$pt.$user['alamat'];
            $data[] = array(
                "id"=>$user['id'],
                "text"=>$txt, 
                "pimpinan"=>$user['pimpinan'],
                "nm_perusahaan"=>$user['nm_perusahaan'],
                "alamat"=>$user['alamat'],
                "no_telp"=>$user['no_telp'],
            );
        }
        return $data;
    }

	function loadPlPO($searchTerm="", $fid=""){
		$users = $this->db->query("SELECT*FROM po_master
		WHERE STATUS='open' AND id_perusahaan='$fid' AND no_po LIKE '%$searchTerm%'
		GROUP BY id_po,no_po,id_perusahaan,status")->result_array();

        $data = array();
        foreach($users as $user){
            $data[] = array(
                "id" => $user['id_po'].'_ex_'.$user['no_po'].'_ex_'.$user['pajak'],
                "text" => $user['no_po'],
            );
        }
        return $data;
    }

	function loadPlJns($search="", $id_po="", $no_po=""){
		$users = $this->db->query("SELECT * FROM po_master
		WHERE id_po='$id_po' AND no_po='$no_po' AND nm_ker LIKE '%$search%' AND status='open'
		GROUP BY id_po,no_po,nm_ker")->result_array();

        $data = array();
        foreach($users as $user){
            $data[] = array(
                "id" => $user['id_po'].'_ex_'.$user['no_po'].'_ex_'.$user['nm_ker'].'_ex_'.$user['pajak'],
                "text" => $user['nm_ker'],
            );
        }
        return $data;
    }

	function loadPlPlhGsm($search="", $id_po="", $no_po="", $nm_ker=""){
		$users = $this->db->query("SELECT * FROM po_master
		WHERE id_po='$id_po' AND no_po='$no_po' AND nm_ker='$nm_ker' AND g_label LIKE '%$search%' AND status='open'
		GROUP BY nm_ker,g_label")->result_array();

        $data = array();
        foreach($users as $user){
            $data[] = array(
                "id" => $user['g_label'],
                "text" => $user['g_label'],
            );
        }
		return $data;
	}

    function get_invoice(){
        $query = "SELECT * FROM invoice_header ORDER BY tgl,no_invoice";
        return $this->db->query($query);
    }

	// GET EDIT LIST DATA INVOICE
	function get_list_inv($no_inv){
        $query = "SELECT * FROM invoice_list
		WHERE no_invoice='$no_inv'
		ORDER BY no_po,nm_ker DESC,g_label,width";
        return $this->db->query($query);
    }

	// GET EDIT LIST DATA INVOICE
	function get_harga_inv($no_inv){
        $query = "SELECT * FROM invoice_harga
		WHERE no_invoice='$no_inv'
		ORDER BY no_po,nm_ker DESC,g_label";
        return $this->db->query($query);
    }

	function getItungInv($no_inv){
        $query = "SELECT a.*,
		(SELECT SUM(b.weight) FROM invoice_list b WHERE a.no_invoice=b.no_invoice AND a.nm_ker=b.nm_ker AND a.g_label=b.g_label AND a.no_po=b.no_po) AS jml_weight,
		(SELECT SUM(b.seset) FROM invoice_list b WHERE a.no_invoice=b.no_invoice AND a.nm_ker=b.nm_ker AND a.g_label=b.g_label AND a.no_po=b.no_po) AS jml_seset
		FROM invoice_harga a
		WHERE a.no_invoice='$no_inv'
		GROUP BY a.no_invoice,a.no_po,a.nm_ker,a.g_label
		ORDER BY a.no_invoice,a.no_po,a.nm_ker DESC,a.g_label";
        return $this->db->query($query);
    }

	function getRincPay($no_inv){
        $query = "SELECT * FROM invoice_pay
		WHERE no_invoice='$no_inv'
		ORDER BY id";
        return $this->db->query($query);
    }

    function get_jatuh_tempo(){
        $query = "SELECT*FROM invoice_header WHERE status ='Closed' ORDER BY jto,no_invoice";
        // $query = "SELECT a.*,(SELECT SUM(harga) FROM tr_invoice WHERE no_invoice = a.no_invoice)AS total FROM th_invoice a where status ='Closed' ORDER BY jto DESC,no_invoice asc";
        return $this->db->query($query);
    }

    function get_barang(){
        // $no_surat = $_POST['no_surat'];
        $id_tgl = $_POST['id_tgl'];
        $id_pt = $_POST['id_pt'];
        $id_pl_inv = $_POST['id_pl_inv'];
        $group = $_POST['group'];

		if($group == 1){
			$goby = 'GROUP BY b.no_po,a.nm_ker,a.g_label,a.width
			ORDER BY b.no_po,a.nm_ker DESC,a.g_label,a.width';
		}else{
			$goby = 'GROUP BY b.no_po,a.nm_ker,a.g_label
			ORDER BY b.no_po,a.nm_ker DESC,a.g_label';
		}

        $query = "SELECT a.nm_ker,a.g_label,a.width,COUNT(a.roll) AS qty,SUM(weight) AS weight,b.no_po,b.no_surat,b.no_pkb FROM m_timbangan a
		INNER JOIN pl b ON a.id_pl = b.id
		WHERE b.tgl='$id_tgl' AND b.id_perusahaan='$id_pt' AND b.no_pl_inv='$id_pl_inv'
		$goby";

        return $this->db->query($query);
    }

    function insert_invoice(){
        $data = array(
                'no_invoice' => $_POST['no_invoice'],
                'jto' => $_POST['jto'],
                'tgl' => $_POST['tgl_b_inv'],
                'kepada' => $_POST['kepada'],
                'id_pt' => $_POST['id_perusahaan'],
                'nm_perusahaan' => $_POST['nm_perusahaan'],
                'alamat_perusahaan' => $_POST['alamat_perusahaan'],
                'ppn' => $_POST['plh_pajak'],
                // 'status' => 'Closed',
            );
        $result= $this->db->insert("invoice_header",$data);

        foreach ($this->cart->contents() as $items) {
			// id no_invoice no_surat nm_ker g_label width qty weight no_po
			if($items['options']['opsi'] == 1){
				$this->db->set('no_invoice', $_POST['no_invoice']);
				$this->db->set('no_surat', $items['options']['no_surat']);
				$this->db->set('no_pkb', $items['options']['no_pkb']);
				$this->db->set('nm_ker', $items['options']['nm_ker']);
				$this->db->set('g_label', $items['options']['g_label']);
				$this->db->set('width', $items['options']['width']);
				$this->db->set('qty', $items['options']['qty']);
				$this->db->set('weight', $items['options']['weight']);
				$this->db->set('seset', $items['price']);
				$this->db->set('no_po', $items['options']['no_po']);

				$result= $this->db->insert('invoice_list');
			}

			// no_invoice no_po nm_ker g_label no_surat harga
			if($items['options']['opsi'] == 2){
				$this->db->set('no_invoice', $_POST['no_invoice']);
				$this->db->set('no_po', $items['options']['no_po']);
				$this->db->set('nm_ker', $items['options']['nm_ker']);
				$this->db->set('g_label', $items['options']['g_label']);
				$this->db->set('no_surat', $items['options']['no_surat']);
				$this->db->set('harga', $items['price']);

				$result= $this->db->insert('invoice_harga');
			}
        }

		// UPDATE STATUS DI PACKING LIST
		$no_inv = $_POST['no_invoice'];
		$get_sj = $this->db->query("SELECT * FROM invoice_list WHERE no_invoice='$no_inv' GROUP BY no_pkb");
		foreach($get_sj->result() as $r){
			$this->db->set('status', 'Closed');
			$this->db->where('no_pkb', $r->no_pkb);
			$result = $this->db->update('pl');
		}

        return $result;
    }

	function updateHeaderInv() {
        // UPDATE HEADER INVOICE
        $this->db->set('no_invoice', $_POST['no_invoice']);
        $this->db->set('jto', $_POST['jto']);
        $this->db->set('tgl', $_POST['tgl_b_inv']);
        $this->db->set('tgl_ctk', $_POST['tgl_ctk']);
        $this->db->set('ppn', $_POST['plh_pajak']);
        $this->db->set('kepada', $_POST['kepada']);
        $this->db->set('nm_perusahaan', $_POST['nm_perusahaan']);
        $this->db->set('alamat_perusahaan', $_POST['alamat_perusahaan']);
        $this->db->where('id', $_POST['id_edit']);
        $result = $this->db->update('invoice_header');

		// UPDATE NO INVOICE DI INVOICE LIST
        $this->db->set('no_invoice', $_POST['no_invoice']);
        $this->db->where('no_invoice', $_POST['no_invoice_lama']);
        $result = $this->db->update('invoice_list');

		// UPDATE NO INVOICE DI INVOICE HARGA
        $this->db->set('no_invoice', $_POST['no_invoice']);
        $this->db->where('no_invoice', $_POST['no_invoice_lama']);
        $result = $this->db->update('invoice_harga');

        return $result;
    }

	function updateInvListBarang() {
		$opsi = $_POST['opsi'];

		if($opsi == 'list'){
			// UPDATE SESET INVOICE
			$this->db->set('seset', $_POST['i_seset']);
			$this->db->where('id', $_POST['id']);
			$result = $this->db->update('invoice_list');
		}else if($opsi == 'harga'){
			// UPDATE HARGA PO
			$this->db->set('harga', $_POST['i_harga']);
			$this->db->where('id', $_POST['id']);
			$result = $this->db->update('invoice_harga');
		}else{
			// UPDATE HARGA INVOICE
			$this->db->set('tgl_bayar', $_POST['i_tgl_bayar']);
			$this->db->set('jumlah', $_POST['i_payinv']);
			$this->db->where('id', $_POST['id']);
			$result = $this->db->update('invoice_pay');
		}

        return $result;
    }

	// no_invoice tgl_bayar jumlah
	function payInvoice() {
		$this->db->set('no_invoice', $_POST['no_inv']);
		$this->db->set('tgl_bayar', $_POST['tgl_bayar']);
		$this->db->set('jumlah', $_POST['jml_bayar']);
		$result= $this->db->insert('invoice_pay');

        return $result;
    }

    function confirm(){
        $id = $_POST['id'];

        // $no_surat = $this->db->get_where('th_invoice', array('id' => $id))->row("no_surat");

        $this->db->set('status', "Verified");
        $this->db->where('id', $id);
        $result= $this->db->update('invoice_header');

        return $result;
    }

    function confirm_cek_po() {
        $id = $_POST['id'];

        // ambil po
        $q_pl_no_po = $this->m_master->get_plpl($id)->row();
        // $g_label = $q_pl_no_po->g_label;
        // $width   = $q_pl_no_po->width;
        // $no_po   = $q_pl_no_po->no_po;
        
        $result = $q_pl_no_po;        

        return $result;
    }

	function updateQCRoll(){
        if($_POST['edit'] == 'ListStokGudang'){
            $this->db->set('ket', $_POST['ket']);
            $this->db->set('status', $_POST['status']);
        }else{
            $this->db->set('tgl', $_POST['tgl']);
            $this->db->set('g_ac', $_POST['g_ac']);
            $this->db->set('rct', $_POST['rct']);
            $this->db->set('bi', $_POST['bi']);
            $this->db->set('nm_ker', $_POST['nm_ker']);
            $this->db->set('g_label', $_POST['g_label']);
            $this->db->set('width', $_POST['width']);
            $this->db->set('diameter', $_POST['diameter']);
            $this->db->set('weight', $_POST['weight']);
            $this->db->set('joint', $_POST['joint']);
            $this->db->set('ket', $_POST['ket']);
            $this->db->set('status', $_POST['status']);
        }
        
        // $this->db->set('packing_at', date("Y-m-d H:i:s"));
        // $this->db->set('packing_by', $this->session->userdata('username'));
        $this->db->where('id', $_POST['id']);
        $result = $this->db->update('m_timbangan');

        if(($_POST['lnm_ker'] == $_POST['nm_ker']) && ($_POST['lg_label'] == $_POST['g_label']) && ($_POST['lwidth'] == $_POST['width']) && ($_POST['lweight'] == $_POST['weight']) && ($_POST['ldiameter'] == $_POST['diameter']) && ($_POST['ljoint'] == $_POST['joint']) && ($_POST['lket'] == $_POST['ket']) && ($_POST['lstatus'] == $_POST['status'])){
            $result = true;
        }else{
            $data = array(
                'roll' => $_POST['lroll'],
                'nm_ker' => $_POST['lnm_ker'],
                'g_label' => $_POST['lg_label'],
                'width' => $_POST['lwidth'],
                'diameter' => $_POST['ldiameter'],
                'weight' => $_POST['lweight'],
                'joint' => $_POST['ljoint'],
                'status' => $_POST['lstatus'],
                'ket' => $_POST['lket'],
                'edited_at' => date("Y-m-d H:i:s"),
                'edited_by' => $this->session->userdata('username'),
            );
            $result= $this->db->insert("m_roll_edit",$data);
        }
		
		return $result;
	}

    function simpanInputRoll(){
        foreach($this->cart->contents() as $data){
            // if($data['options']['status'] == 0){ // jika stok update
            //     $this->db->set('status', '1');
            // }
            // $this->db->set('id_pl', $data['options']['id_pl']);
            $this->db->set('id_rk', $data['options']['id_rk']);
            $this->db->set('packing_at', date("Y-m-d H:i:s"));
            $this->db->set('packing_by', $this->session->userdata('username'));
            $this->db->where('id', $data['id']);
            
            $result = $this->db->update('m_timbangan');
        }
        return $result;
    }

	function editRollRk(){
		// edited_at  edited_by
		$id = $_POST['id'];
		$seset = $_POST['seset'];

		$cek = $this->db->query("SELECT*FROM m_timbangan WHERE id='$id'")->row();
		if($cek->seset == $seset){
            $result = true;
        }else{
            $data = array(
                'roll' => $cek->roll,
                'nm_ker' => $cek->nm_ker,
                'g_label' => $cek->g_label,
                'width' => $cek->width,
                'diameter' => $cek->diameter,
                'weight' => $cek->weight,
                'joint' => $cek->joint,
                'seset' => $cek->seset,
                'status' => $cek->status,
                'ket' => $cek->ket,
                'edited_at' => date("Y-m-d H:i:s"),
                'edited_by' => $this->session->userdata('username'),
            );
            $result= $this->db->insert("m_roll_edit",$data);

			$this->db->set('seset', $seset);
			$this->db->set('edited_at', date("Y-m-d H:i:s"));
			$this->db->set('edited_by', $this->session->userdata('username'));
			$this->db->where('id', $id);
			$result = $this->db->update('m_timbangan');
        }
		
		return $result;
	}

	function batalRollRk(){
		$id = $_POST['id'];
		$this->db->set('id_rk', '');
		$this->db->where('id', $id);
		return $this->db->update('m_timbangan');
	}

    function simpanCartRk(){
        foreach($this->cart->contents() as $data){
			$exp = explode("-", $data['options']['tgl']);
			$idrk = 'RK-'.$exp[0].$exp[1].$exp[2].'-'.$data['options']['order_pl'];

			// JIKA ADA JENIS, GSM, UKURAN YANG SAMA = QTY DITAMBAHKAN SAJA
			$nm_ker = $data['options']['nm_ker'];
			$g_label = $data['options']['g_label'];
			$width = $data['options']['width'];
			$cek = $this->db->query("SELECT*FROM m_rencana_kirim WHERE nm_ker='$nm_ker' AND g_label='$g_label' AND width='$width'");
			if($cek->num_rows() == 0){
				$jmlroll = $data['options']['jml_roll'];
				$data = array(
					'id_rk' => $idrk,
					'tgl' => $data['options']['tgl'],
					'nm_ker' => $data['options']['nm_ker'],
					'g_label' => $data['options']['g_label'],
					'width' => $data['options']['width'],
					'jml_roll' => $jmlroll,
					'order_pl' => $data['options']['order_pl'],
				);
				$result = $this->db->insert('m_rencana_kirim', $data);
			}else{
				$jmlroll = $cek->row()->jml_roll + $data['options']['jml_roll'];
				$this->db->set('jml_roll', $jmlroll);
				$this->db->where('id', $cek->row()->id);
				$result = $this->db->update('m_rencana_kirim');
			}
        }

        // UPDATE PL
        // 5_ex_2022-12-08_ex_TESET/RENCANA/KIRIM_ex_MH_ex_150_ex_190.00
        // 1_ex_2022-12-11_ex_TEST/PO/AP_ex_MH_ex_125_ex_150.00
        $exp = explode("_ex_", $_POST['rkukuran']);
		$tgl = $exp[1];
		$order_pl = $exp[0];
        $updidrkPl = $this->db->query("SELECT*FROM m_rencana_kirim WHERE tgl='$tgl' AND order_pl='$order_pl'");
        $getpl = $this->db->query("SELECT*FROM pl WHERE tgl_pl='$tgl' AND opl='$order_pl'");
        foreach($getpl->result() as $r){
            $this->db->set('id_rk', $updidrkPl->row()->id_rk);
            $this->db->where('id', $r->id);
            $result = $this->db->update('pl');
        }

        return $result;
    }    

	function simpanCartPl(){
        // CEK OPL RENCANA KIRIM
        $tgl_pl = $_POST['ftglrk'];
        $vopl = $_POST['opl'];
        if($_POST['pl'] == 'edit'){
            $eCekOpl = $this->db->query("SELECT*FROM pl WHERE tgl_pl='$tgl_pl' AND opl='$vopl' GROUP BY opl");
            $opl = $eCekOpl->row()->opl;
        }else{
            $cekOpls = $this->db->query("SELECT*FROM pl WHERE tgl_pl='$tgl_pl' GROUP BY opl");
            if($cekOpls->num_rows() == 0){
                $opl = 1;
            }else{
                $opl = $cekOpls->num_rows() + 1;
            }
        }

        foreach($this->cart->contents() as $data){
			// CEK SJ JIKA ADA LEBIH DARI SATU
			$noSj = $data['options']['no_surat'];
			$cekSj = $this->db->query("SELECT*FROM pl WHERE no_surat LIKE '%$noSj%' ORDER BY id DESC");
			if($cekSj->num_rows() == 0){
				$nosj = $data['options']['no_surat'];
			}else{
				$nosj = ' '.$cekSj->row()->no_surat;
			}

            if($_POST['pl'] == 'edit'){
                $idpt = $eCekOpl->row()->id_perusahaan;
            }else{
                $idpt = $data['options']['id_perusahaan'];
            }

			$data = array(
				'tgl_pl' => $data['options']['tgl_pl'],
				'tgl' => $data['options']['tgl'],
				'no_surat' => $nosj,
				'no_so' => $data['options']['no_so'],
				'no_pkb' => $data['options']['no_pkb'],
				'no_kendaraan' => '-',
				'nm_perusahaan' => $data['options']['nm_perusahaan'],
				'id_perusahaan' => $idpt,
				'alamat_perusahaan' => $data['options']['alamat_perusahaan'],
				'nama' => $data['options']['nama'],
				'no_telp' => $data['options']['no_telp'],
                'qc' => 'proses',
                'opl' => $opl,
				'no_po' => $data['options']['no_po'],
				'nm_ker' => $data['options']['nm_ker'],
				'g_label' => $data['options']['g_label'],
				'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $this->session->userdata('username'),
			);
			$result = $this->db->insert('pl', $data);
        }

        // UPDATE JIKA SUDAH ADA RENCANA KIRIM
        $idrk = $this->db->query("SELECT*FROM m_rencana_kirim WHERE tgl='$tgl_pl' AND order_pl='$vopl' GROUP BY tgl,order_pl");
        $urk = $this->db->query("SELECT*FROM pl WHERE tgl_pl='$tgl_pl' AND opl='$vopl' AND (id_rk='' OR id_rk IS NULL)");
        if($idrk->num_rows() > 0){
            foreach($urk->result() as $r){
                $this->db->set('id_rk', $idrk->row()->id_rk);
                $this->db->where('id', $r->id);
                $result = $this->db->update('pl');
            }
        }
        

        return $result;
    }

    function simpanCartPO($cekIdPo){
        // $id = $_POST['id'];

        foreach($this->cart->contents() as $data){
            // id_po id_perusahaan tgl nm_ker g_label width tonase jml_roll no_po harga pajak
            $data = array(
                'id_po' => $cekIdPo,
                'id_perusahaan' => $_POST['fid'],
                'tgl' => $_POST['ftgl'],
                'nm_ker' => $data['options']['fjenis'],
                'g_label' => $data['options']['fgsm'],
                'width' => $data['options']['fukuran'],
                'tonase' => $data['options']['ftonase'],
                'jml_roll' => $data['options']['fjmlroll'],
                'no_po' => $_POST['fno_po'],
                'harga' => $data['options']['fharga'],
                'pajak' => $_POST['fpajak'],
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $this->session->userdata('username'),
            );
            $result = $this->db->insert('po_master',$data);
        }

		// JIKA UPDATE PO DIUBAH
		if($_POST['option'] == 'update' && ($_POST['fno_po'] != $_POST['lno_po'])){
			$poLama = $_POST['lno_po'];
			$getPo = $this->db->query("SELECT*FROM po_master WHERE no_po='$poLama'");
			foreach($getPo->result() as $po){
				$this->db->set('no_po', $_POST['fno_po']);
				$this->db->where('id_po', $_POST['update_idpo']);
				$this->db->where('no_po', $_POST['lno_po']);
				$result = $this->db->update('po_master');
			}
		}

        return $result;
    }

	function editItemPO(){
		// id_po id_perusahaan tgl nm_ker g_label width tonase jml_roll no_po harga pajak status ket created_at created_by edited_at edited_by
		$this->db->set('nm_ker', $_POST['wnmker']);
		$this->db->set('g_label', $_POST['wglabel']);
		$this->db->set('width', $_POST['wwidth']);
		$this->db->set('tonase', $_POST['etonase']);
		$this->db->set('jml_roll', $_POST['ejmlroll']);
		$this->db->set('harga', $_POST['eharga']);
		$this->db->set('edited_at', date("Y-m-d H:i:s"));
		$this->db->set('edited_by', $this->session->userdata('username'));
		$this->db->where('id', $_POST['id']);
		$this->db->update('po_master');
	}

    function simpanAdministrator(){
        $status = $_POST['status'];

        if($status == 'insert'){ // insert
            $data = array(
                'username' => $_POST['username'],
                'nm_user' => $_POST['nama_user'],
                'password' => md5(trim($_POST['password'])),
                'level' => $_POST['level'],
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $this->session->userdata('username'),
            );
            $this->db->insert('user', $data);
        }else{ // update
            // $this->db->set('username', $_POST['username']);
            $this->db->set('nm_user', $_POST['nama_user']);
            $this->db->set('password', md5(trim($_POST['password'])));
            $this->db->set('level', $_POST['level']);
            $this->db->set('edited_at', date("Y-m-d H:i:s"));
            $this->db->set('edited_by', $this->session->userdata('username'));
            $this->db->where('id', $_POST['id']);
            $this->db->update('user');
        }
    }
}
