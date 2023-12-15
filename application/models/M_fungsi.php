<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fungsi Model
 */

class M_fungsi extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	// Tampilkan semua master data fungsi
	//function getAll($limit, $offset)
    function getAll($tabel,$field1,$limit, $offset)
	{
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->order_by($field1, 'asc');
		$this->db->limit($limit,$offset);
		return $this->db->get();
	}
    function getcari($tabel,$field,$field1,$limit, $offset,$lccari)
	{
		$this->db->select('*');
		$this->db->from($tabel);
        $this->db->or_like($field, $lccari);  
        $this->db->or_like($field1, $lccari);      
		$this->db->order_by($field, 'asc');
        $this->db->limit($limit,$offset);
		return $this->db->get();
	}
    
    function getAllc($tabel,$field1)
	{
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->order_by($field1, 'asc');
		//$this->db->limit($limit,$offset);
		return $this->db->get();
	}
	
	// Total jumlah data
	function get_count($tabel)
	{
		return $this->db->get($tabel)->num_rows();
	}
    
	function get_count_cari($tabel,$field1,$field2,$data)
	{
        $this->db->select('*');
		$this->db->from($tabel);
        $this->db->or_like($field1, $data);  
        $this->db->or_like($field2, $data);      
		$this->db->order_by($field1, 'asc');
		return $this->db->get()->num_rows();
		//return $this->db->get('ms_fungsi')->num_rows();
	}
    function get_count_teang($tabel,$field,$field1,$lccari)
	{
        $this->db->select('*');
		$this->db->from($tabel);
        $this->db->or_like($field, $lccari);  
        $this->db->or_like($field1, $lccari);      
		$this->db->order_by($field, 'asc');
		return $this->db->get()->num_rows();
		//return $this->db->get('ms_fungsi')->num_rows();
	}
	// Ambil by ID
	function get_by_id($tabel,$field1,$id)
	{
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where($field1, $id);
		return $this->db->get();
	}
	//cari
    function cari($tabel,$field1,$field2,$limit, $offset,$data)
	{
		$this->db->select('*');
		$this->db->from($tabel);
        $this->db->or_like($field2, $data);  
        $this->db->or_like($field1, $data);      
		$this->db->order_by($field1, 'asc');
		return $this->db->get();
	}
	// Simpan data
	function save($tabel,$data)
	{
		$this->db->insert($tabel, $data);
	}
	
	// Update data
	function update($tabel,$field1,$id, $data)
	{
		$this->db->where($field1, $id);
		$this->db->update($tabel, $data); 	
	}
	
	// Hapus data
	function delete($tabel,$field1,$id)
	{
		$this->db->where($field1, $id);
		$this->db->delete($tabel);
	}
    
  	function depan($number)
	{
		$number = abs($number);
		$nomor_depan = array("","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan","sepuluh","sebelas");
		$depans = "";
		
		if($number<12){
			$depans = " ".$nomor_depan[$number];
		}
		else if($number<20){
			$depans = $this->depan($number-10)." belas";
		}
		else if($number<100){
			$depans = $this->depan($number/10)." puluh ".$this->depan(fmod($number,10));
		}
		else if($number<200){
			$depans = "seratus ".$this->depan($number-100);
		}
		else if($number<1000){
			$depans = $this->depan($number/100)." ratus ".$this->depan(fmod($number,100));
		//$depans = $this->depan($number/100)." Ratus ".$this->depan($number%100);
		}
		else if($number<2000){
			$depans = "seribu ".$this->depan($number-1000);
		}
		else if($number<1000000){
			$depans = $this->depan($number/1000)." ribu ".$this->depan(fmod($number,1000));
		}
		else if($number<1000000000){
			$depans = $this->depan($number/1000000)." juta ".$this->depan(fmod($number,1000000));
		}
		else if($number<1000000000000){
			$depans = $this->depan($number/1000000000)." milyar ".$this->depan(fmod($number,1000000000));
			//$depans = ($number/1000000000)." Milyar ".(fmod($number,1000000000))."------".$number;
		}
		else if($number<1000000000000000){
			$depans = $this->depan($number/1000000000000)." triliun ".$this->depan(fmod($number,1000000000000));
			//$depans = ($number/1000000000)." Milyar ".(fmod($number,1000000000))."------".$number;
		}				
		else{
			$depans = "Undefined";
		}
		return $depans;
	}

	function belakang($number)
	{
		$number = abs($number);
		$number = stristr($number,".");
		$nomor_belakang = array("nol","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan");

		$belakangs = "";
		$length = strlen($number);
		$i = 1;
		while($i<$length)
		{
			$get = substr($number,$i,1);
			$i++;
			$belakangs .= " ".$nomor_belakang[$get];
		}
		return $belakangs;
	}

	function terbilang($number)
	{
		if (!is_numeric($number))
		{
			return false;
		}
		
		if($number<0)
		{
			$hasil = "Minus ".trim($this->depan($number));
			// $poin = trim($this->belakang($number));

		}
		else{
			// $poin = trim($this->belakang($number));
			$hasil = trim($this->depan($number));
		}
   
		// if($poin)
		// {
		// 	$hasil = $hasil." koma ".$poin." Rupiah";
		// }
		// else{
			$hasil = $hasil." Rupiah";
		// }

		return $hasil;  
		
	}
	
 
	function terbilang_angka($number)
	{
		if (!is_numeric($number))
		{
			return false;
		}
		
		if($number<0)
		{
			$hasil = "Minus ".trim($this->depan($number));
			$poin = trim($this->belakang($number));

		}
		else{
			$poin = trim($this->belakang($number));
			$hasil = trim($this->depan($number));
		}
   
		if($poin)
		{
			$hasil = $hasil." koma ".$poin;
		}
		else{
			$hasil = $hasil;
		}
		return $hasil;  
	} 
    
    
    function _mpdf($judul='',$isi='',$lMargin='',$rMargin='',$font=0,$orientasi='') {
        
        ini_set("memory_limit","512M");
        $this->load->library('mpdf');
        
        $this->mpdf->defaultheaderfontsize = 6;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 6;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 
        $this->mpdf->SetLeftMargin = $lMargin;
        $this->mpdf->SetRightMargin = $rMargin;

		if($font == 1){
			$this->mpdf->AddPage($orientasi,'','','','',$lMargin,$rMargin,4,2);
        }else if($font == 2){
			$this->mpdf->AddPage($orientasi,'','','','',$lMargin,$rMargin,1,1);
        }else if($font == 999){
			$this->mpdf->AddPage($orientasi,'','','','',5,5,10,10);
        }else{
			$this->mpdf->AddPage($orientasi,'','','','',$lMargin,$rMargin);
        }
        
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output();
    }

    function _mpdfCustom($judul='',$isi='',$lMargin='',$rMargin='',$font=0,$orientasi='') {
        
        ini_set("memory_limit","512M");
        $this->load->library('mpdf');
        
        $this->mpdf->defaultheaderfontsize = 6;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 6;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 
        $this->mpdf->SetLeftMargin = $lMargin;
        $this->mpdf->SetRightMargin = $rMargin;
        $jam = date("H:i:s");
        // $this->mpdf->AddPage($orientasi,'','','','',$lMargin,$rMargin);
        $this->mpdf->AddPageByArray(array(
			'orientation' => 'L',
			// 'sheet-size' => 'Legal',
			'sheet-size' =>array(210, 330),
		));
        
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output();   
    }

	function newMpdf($html,$top,$right,$bottom,$left,$orientasi,$kertas){
		// ini_set("memory_limit","512M");
		$this->load->library('mpdf');

		if($kertas == 'F4'){
			$orr = array(210, 330);
		}else{ // A4
			$orr = array(210, 297);
		}
		$this->mpdf->AddPageByArray(array(
			'orientation' => $orientasi,
			'margin-top' => $top,
			'margin-right' => $right,
			'margin-bottom' => $bottom,
			'margin-left' => $left,
			'sheet-size' => $orr,
		));
		$this->mpdf->writeHTML($html);         
        $this->mpdf->Output();
	}

	function _mpdf2($judul='',$isi='',$lMargin='',$rMargin='',$font=0,$orientasi='',$title='PL',$print=0) {
        
        ini_set("memory_limit","512M");
        $this->load->library('mpdf');

        $this->mpdf->defaultheaderfontsize = 6;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 6;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 

        $this->mpdf->SetTitle = $title;

        $this->mpdf->SetLeftMargin = $lMargin;
        $this->mpdf->SetRightMargin = $rMargin;
        
        $jam = date("H:i:s");

        if($print == 999 ){ // surat jalan riject
		    // $this->mpdf->AddPage($orientasi,'','','','',10,10,10,5);
			$this->mpdf->AddPage($orientasi,'','','','',$lMargin,$rMargin,3,2);
        }else if($print == 3 ){
		    // $this->mpdf->AddPage($orientasi,'','','','',10,10,10,5);
			$this->mpdf->AddPage($orientasi,'','','','',$lMargin,$rMargin,3,2);
        }else if($print == 2 ){
		    // $this->mpdf->AddPage($orientasi,'','','','',10,10,10,5);
			$this->mpdf->AddPage($orientasi,'','','','',$lMargin,$rMargin,5,5);
        }else if($print == 1 ){
		    // $this->mpdf->AddPage($orientasi,'','','','',10,10,10,5);
			$this->mpdf->AddPage($orientasi,'','','','',$lMargin,$rMargin,10,5);
        }else if($print == 6 ){
			$this->mpdf->SetHTMLHeader('<table style="font-size:11px;width:100%;text-align:center;border-collapse:collapse;color:#000;margin:0;padding:0">
				<tr>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:5%">NO</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:8%">TANGGAL</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:10%">NO SJ</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:18.5%">CUSTOMER</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:14.5%">UKURAN</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:6%">PCS</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:10%">TONASE</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:10%">HARGA</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:10%">SALES</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:8%">NO PLAT</td>
				</tr>
			</table>');
			$this->mpdf->SetHTMLFooter('<div style="text-align:center;font-size:10px;font-style:italic">Page : {PAGENO} / {nb}</div>');

			$this->mpdf->AddPage($orientasi,'','','','',5,5,11.5,5,5,2);
        }else{
        	$this->mpdf->AddPage($orientasi,'','','','',$lMargin,$rMargin,15,5);
        }
        
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output();
               
    }

    function _mpdf_margin($judul='',$isi='',$lMargin='',$rMargin='',$tMargin='',$bMargin='',$font=0,$orientasi='',$jdlsave='') {
        
        ini_set("memory_limit","512M");
        $this->load->library('mpdf');
    
        $this->mpdf->defaultheaderfontsize = 6;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = BI;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 6;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = BI;
        $this->mpdf->defaultfooterline = 1; 
        $this->mpdf->SetLeftMargin = $lMargin;
        $this->mpdf->SetRightMargin = $rMargin;
        //$this->mpdf->SetHeader('SIMAKDA||');
        $jam = date("H:i:s");
        //$this->mpdf->SetFooter('Printed on @ {DATE j-m-Y H:i:s} |Simakda| Page {PAGENO} of {nb}');
       // $this->mpdf->SetFooter('Printed on @ {DATE j-m-Y H:i:s} |Halaman {PAGENO} / {nb}| ');
        $this->mpdf->SetFooter('|Halaman {PAGENO} / {nb}| ');
        $this->mpdf->AddPage($orientasi,'','','','',$lMargin,$rMargin,$tMargin,$bMargin);
        
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output($jdlsave,'I');
        
    }

    function newPDF($isi='',$orientasi='',$print=0,$opsi=0) {
        
        ini_set("memory_limit","512M");
        $this->load->library('mpdf');

        $this->mpdf->defaultheaderfontsize = 6;
        $this->mpdf->defaultheaderfontstyle = BI;
        $this->mpdf->defaultheaderline = 1;
        $this->mpdf->defaultfooterfontsize = 6;
        $this->mpdf->defaultfooterfontstyle = BI;
        $this->mpdf->defaultfooterline = 1; 
        $this->mpdf->SetTitle = 'PDF';
        $this->mpdf->SetLeftMargin = 10;
        $this->mpdf->SetRightMargin = 10;
        
        // $jam = date("H:i:s");

        if($print == 6 ){
			$this->mpdf->SetHTMLHeader('<table style="font-size:11px;width:100%;text-align:center;border-collapse:collapse;color:#000;margin:0;padding:0">
				<tr>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:5%">NO</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:8%">TANGGAL</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:10%">NO SJ</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:18.5%">CUSTOMER</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:14.5%">UKURAN</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:6%">PCS</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:10%">TONASE</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:10%">HARGA</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:10%">SALES</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:8%">NO PLAT</td>
				</tr>
			</table>');
			$this->mpdf->SetHTMLFooter('<div style="text-align:center;font-size:10px;font-style:italic">Page : {PAGENO} / {nb}</div>');

			$this->mpdf->AddPage($orientasi,'','','','',5,5,11.5,5,5,2);
        }else if($print == 1 ){
	        // SHEET
			if($opsi == 1){
                $wdth = '19%';
                $kopDetail = '
                    <td style="font-weight:bold;border:1px solid #000;padding:5px;width:12%">TIMBANGAN</td>
                    <td style="font-weight:bold;border:1px solid #000;padding:5px;width:12%">HARGA PO</td>';
            }else if($opsi == 2){
                $wdth = '31%';
                $kopDetail = '
					<td style="font-weight:bold;border:1px solid #000;padding:5px">PLAT</td>';
            }else{
                $wdth = '43%';
                $kopDetail = '';
            }

			$this->mpdf->SetHTMLHeader('<table style="font-size:11px;width:100%;text-align:center;border-collapse:collapse;color:#000;margin:0;padding:0">
				<tr>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:8%">TANGGAL</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:11%">NO SJ</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:19%">CUSTOMER</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:14%">NO PO</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:'.$wdth.'%">UKURAN</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px;width:5%">QTY</td>
					'.$kopDetail.'
				</tr>
			</table>');
			$this->mpdf->SetHTMLFooter('<div style="text-align:center;font-size:10px;font-style:italic">Page : {PAGENO} / {nb}</div>');

			$this->mpdf->AddPage($orientasi,'','','','',5,5,11.5,5,5,2);
        }else if($print == 77 ){
			$this->mpdf->AddPage($orientasi,'','','','',5,5,5,5);
        }else if($print == 88 ){
			// $this->mpdf->SetHTMLHeader(''.$opsi.'');
			$this->mpdf->AddPage($orientasi,'','','','',5,5,5,5);
        }else{
			$this->mpdf->AddPage($orientasi,'','','','',10,10,15,5);
        }
        
        if (!empty($judul)) $this->mpdf->writeHTML($judul);
        $this->mpdf->writeHTML($isi);         
        $this->mpdf->Output();
    }

	function newPDFopsi($isi='',$orientasi='P',$mL=5,$mR=5,$mT=5,$mB=5,$op='',$op1='',$op2='',$op3='',$op4='',$op5=''){
		ini_set("memory_limit","512M");
        $this->load->library('mpdf');

		if($op == 'lapHarian'){
			$this->mpdf->SetHTMLHeader('<table style="margin:0;padding:0;font-size:12px;color:#000;border-collapse:collapse;vertical-align:top;width:100%">
				<tr>
					<td style="padding:0;width:3%"></td>
					<td style="padding:0;width:6%"></td>
					<td style="padding:0;width:4%"></td>
					<td style="padding:0;width:25%"></td>
					<td style="padding:0;width:7%"></td>
					<td style="padding:0;width:17%"></td>
					<td style="padding:0;width:25%"></td>
					<td style="padding:0;width:5%"></td>
					<td style="padding:0;width:8%"></td>
				</tr>
				<tr>
					<td style="padding:0 0 5px;text-align:center;font-weight:bold" colspan="8">REKAP KIRIMAN ROLL PAPER</td>
				</tr>
				<tr>
					<td style="padding:0 0 5px;text-align:center;font-weight:bold;text-transform:uppercase" colspan="8">'.$this->m_fungsi->tanggal_format_indonesia($op1).' - '.$this->m_fungsi->tanggal_format_indonesia($op2).'</td>
				</tr>
				<tr>
					<td style="padding:5px" colspan="8"></td>
				</tr>
				<tr>
					<td style="background:#ddd;border:1px solid #000;border-width:1px 0 0 1px;padding:5px 0;text-align:center;font-weight:bold">NO</td>
					<td style="background:#ddd;border:1px solid #000;border-width:1px 0 0;padding:5px 0;text-align:center;font-weight:bold">HARI</td>
					<td style="background:#ddd;border:1px solid #000;border-width:1px 0 0;padding:5px 0;text-align:center;font-weight:bold">TGL</td>
					<td style="background:#ddd;border:1px solid #000;border-width:1px 0 0;padding:5px 0;text-align:center;font-weight:bold">PELANGGAN</td>
					<td style="background:#ddd;border:1px solid #000;border-width:1px 0 0;padding:5px 0;text-align:center;font-weight:bold">NO SJ</td>
					<td style="background:#ddd;border:1px solid #000;border-width:1px 0 0;padding:5px 0;text-align:center;font-weight:bold">NO PO</td>
					<td style="background:#ddd;border:1px solid #000;border-width:1px 0 0;padding:5px 0;text-align:center;font-weight:bold"><u>GSM</u> / UKURAN(JML ROLL)</td>
					<td style="background:#ddd;border:1px solid #000;border-width:1px 0 0;padding:5px 0;text-align:center;font-weight:bold">JML</td>
					<td style="background:#ddd;border:1px solid #000;border-width:1px 1px 0 0;padding:5px 0;text-align:center;font-weight:bold">BERAT</td>
				</tr>
			</table>');

			$this->mpdf->SetHTMLFooter('<table style="margin:0;padding:0;font-size:10px;color:#000;text-align:center;border-collapse:collapse;vertical-align:top;width:100%">
				<tr>
					<td style="width:15%"></td>
					<td style="border-right:1px solid #000;width:12%"><span style="padding:3px;background:#cfc">HIJAU</span> : WRP 70</td>
					<td style="border-right:1px solid #000;width:14%"><span style="padding:3px;background:#ccf">BIRU</span> : MEDIUM (MH) 105/110</td>
					<td style="border-right:1px solid #000;width:14%"><span style="padding:3px;background:#ffc">KUNING</span> : MEDIUM (MH) 125</td>
					<td style="border-right:1px solid #000;width:14%"><span style="padding:3px;background:#fcc">MERAH</span> : MEDIUM (MH) 150</td>
					<td style="width:16%">PUTIH : B-KRAFT (BK) 110/125/150</td>
					<td style="width:15%"></td>
				</tr>
				<tr>
					<td colspan="7" style="font-style:italic">Page : {PAGENO} / {nbpg}</td>
				</tr>
			</table>');
		}
		
		$this->mpdf->AddPage($orientasi,'','','','',$mL,$mR,$mT,$mB);
		$this->mpdf->writeHTML($isi);
        $this->mpdf->Output();
	}

    function tanggal_format_indonesia($tgl){
        $tanggal = explode('-',$tgl); 
        $bulan  = $this-> getBulan($tanggal[1]);
        $tahun  =  $tanggal[0];
        return  $tanggal[2].' '.$bulan.' '.$tahun;
	}

	function tglInd_skt($tgl){
        $tanggal = explode('-',$tgl); 
        $bulan  = $this-> getBlnSkt($tanggal[1]);
        $tahun  =  $tanggal[0];
        return  $tanggal[2].'-'.$bulan.'-'.$tahun;

    }
	
	function tanggal_format_indonesia_sebelum($tgl){
        $tanggal  = explode('-',$tgl);
		$tanggal1 = $tanggal[2]-1;
        $bulan  = $this-> getBulan($tanggal[1]);
        $tahun  =  $tanggal[0];
        return  $tanggal1.' '.$bulan.' '.$tahun;
    }
    
    function tanggal_ind($tgl){
        $tanggal  = explode('-',$tgl); 
        $bulan  = $tanggal[1];
        $tahun  =  $tanggal[0];
        return  $tanggal[2].'-'.$bulan.'-'.$tahun;
    }

    function fgGetBulan($tgl){
        $tanggal = explode('-',$tgl); 
        $bulan  = $this->getBulan($tanggal[1]);
        return $bulan;
    }

    function fgGetTglIni($tgl){
        $tanggal = explode('-',$tgl); 
        // $tglHariIni = $tanggal[2];
        return $tanggal[2];
    }

    function getHariIni($tgl){
	$namaHari = date('l', strtotime($tgl));

	// $daftar_hari = array(
	//  'Sunday' => 'Minggu',
	//  'Monday' => 'Senin',
	//  'Tuesday' => 'Selasa',
	//  'Wednesday' => 'Rabu',
	//  'Thursday' => 'Kamis',
	//  'Friday' => 'Jumat',
	//  'Saturday' => 'Sabtu'
	// );

	switch($namaHari){
		case 'Sunday':
			$hari_ini = "Minggu";
		break;

		case 'Monday':			
			$hari_ini = "Senin";
		break;

		case 'Tuesday':
			$hari_ini = "Selasa";
		break;

		case 'Wednesday':
			$hari_ini = "Rabu";
		break;

		case 'Thursday':
			$hari_ini = "Kamis";
		break;

		case 'Friday':
			$hari_ini = "Jumat";
		break;

		case 'Saturday':
			$hari_ini = "Sabtu";
		break;

		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}

	return $hari_ini;

}
        
    function  getBulan($bln) {
        switch  ($bln) {
	        case  1:
	        return  "Januari";
	        break;
	        case  2:
	        return  "Februari";
	        break;
	        case  3:
	        return  "Maret";
	        break;
	        case  4:
	        return  "April";
	        break;
	        case  5:
	        return  "Mei";
	        break;
	        case  6:
	        return  "Juni";
	        break;
	        case  7:
	        return  "Juli";
	        break;
	        case  8:
	        return  "Agustus";
	        break;
	        case  9:
	        return  "September";
	        break;
	        case  10:
	        return  "Oktober";
	        break;
	        case  11:
	        return  "November";
	        break;
	        case  12:
	        return  "Desember";
	        break;
	    }
    }

	function  getBlnSkt($bln) {
        switch  ($bln) {
	        case  1:
	        return  "Jan";
	        break;
	        case  2:
	        return  "Feb";
	        break;
	        case  3:
	        return  "Mar";
	        break;
	        case  4:
	        return  "Apr";
	        break;
	        case  5:
	        return  "Mei";
	        break;
	        case  6:
	        return  "Jun";
	        break;
	        case  7:
	        return  "Jul";
	        break;
	        case  8:
	        return  "Agt";
	        break;
	        case  9:
	        return  "Sep";
	        break;
	        case  10:
	        return  "Okt";
	        break;
	        case  11:
	        return  "Nov";
	        break;
	        case  12:
	        return  "Des";
	        break;
	    }
    }
    
    function right($value, $count){
    return substr($value, ($count*-1));
    }

    function left($string, $count){
    return substr($string, 0, $count);
    }    
    
    function  dotrek($rek){
				$nrek=strlen($rek);
				switch ($nrek) {
                case 1:
				$rek = $this->left($rek,1);								
       			 break;
    			case 2:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1);								
       			 break;
    			case 3:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1);								
       			 break;
    			case 5:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2);								
        		break;
    			case 7:
					$rek = $this->left($rek,1).'.'.substr($rek,1,1).'.'.substr($rek,2,1).'.'.substr($rek,3,2).'.'.substr($rek,5,2);								
        		break;
                case 29:
					$rek = $this->left($rek,21).'.'.substr($rek,23,1).'.'.substr($rek,24,1).'.'.substr($rek,25,1).'.'.substr($rek,26,2).'.'.substr($rek,28,2);								
        		break;
    			default:
				$rek = "";	
				}
				return $rek;
    }
    
    
  //wahyu tambah ----------------------------------------	
        function  rev_date($tgl){
			$t=explode("-",$tgl);
			$tanggal  =  $t[2];
			$bulan    =  $t[1];
			$tahun    =  $t[0];
			return  $tanggal.'-'.$bulan.'-'.$tahun;

        }
        
        function  rev_date1($tgl){
			$t=explode("-",$tgl);
			$tanggal  =  $t[0];
			$bulan    =  $t[1];
			$tahun    =  $t[2];
			return  $tahun.'-'.$bulan.'-'.$tanggal;

        }
        
        

		function get_sclient($hasil,$tabel)
		{
			$this->db->select($hasil);
			$q = $this->db->get($tabel);
			$data  = $q->result_array();
			$baris = $q->num_rows();
			return $data[0][$hasil];
		}

		function get_nama($kode,$hasil,$tabel,$field)
		{
			$this->db->select($hasil);
			$this->db->where($field, $kode);
			$q = $this->db->get($tabel);
			$data  = $q->result_array();
			$baris = $q->num_rows();
			return $data[0][$hasil];
		}
// -----------------------------------------------------
    function rp_minus($nilai){
        if($nilai<0){
            $nilai = $nilai * (-1);
            $nilai = '('.number_format($nilai,"2",",",".").')';    
        }else{
            $nilai = number_format($nilai,"2",",","."); 
        }
        
        return $nilai;
    }  	        

    function persen($nilai,$nilai2){
            if($nilai != 0){
                $persen = $this->rp_minus((($nilai2 - $nilai)/$nilai)*100);
            }else{
                if($nilai2 == 0){
                    $persen = $this->rp_minus(0);
                }else{
                    $persen = $this->rp_minus(100);
                }
            } 
          return $persen;  
	 }

    function persen_real($ang,$real){
            if($ang != 0){
                $persen = $this->rp_minus(($real * 100)/$ang);
            }else{
                if($real == 0){
                    $persen = $this->rp_minus(0);
                }else{
                    $persen = '~';
                }
            } 
          return $persen;  
	}
	 
        function combo_beban($id='',$script=''){
        $cRet    = '';                        
        $cRet    = "<select name=\"$id\" id=\"$id\" $script >";
        $cRet   .= "<option value=''>Pilih Beban</option>";                 
        $cRet   .= "<option value='1'>UP/GU</option>";                
        $cRet   .= "<option value='3'>TU</option>";                        
        $cRet   .= "</select>";        
        return $cRet;
    }

    function qsisa_bankkasda($tgl,$nomor=''){
        $hasil  = 0;
        $csql ="select *,sisa=terima-keluar from(
        		select a.kode,a.nama,isnull(nilai,0) [terima],
					(
						select sum(nilai) from(
							select isnull(sum(f.nilai),0) [nilai] from trhsp2d e join trdspp f on e.no_spp=f.no_spp  
							where status_bud='1' and e.tgl_kas_bud<='$tgl' and e.bank_bud=a.kode and f.no_spp<>'$nomor'
							union all 
							select isnull(sum(nilai),0) [nilai] from transfer_bank_kasda where kd_bank_bud1=a.kode and tgl_kas<='$tgl' and no_kas<>'$nomor'
						)as g
					) [keluar] 
					from ms_bank a left join 
					(
						select kd_bank_bud,sum(nilai) [nilai] from(
							select b.kd_bank_bud,sum(c.rupiah) [nilai] from trhkasin_ppkd b join trdkasin_ppkd c 
							on b.no_sts=c.no_sts and b.kd_skpd=c.kd_skpd where b.tgl_kas<='$tgl' group by b.kd_bank_bud
							union all 
							select kd_bank_bud2 as kd_bank_bud,isnull(sum(nilai),0) [nilai] from transfer_bank_kasda where tgl_kas<='$tgl' and no_kas<>'$nomor'
							group by kd_bank_bud2
						)as h group by kd_bank_bud
					) d 
					on a.kode=d.kd_bank_bud where a.rekening<>''
				)as g order by kode  ";
        $hasil = $this->db->query($csql);
        return $hasil;
    }    


    function qsisa_bankkasda_bln($blnawal,$blnakhir){
        $hasil  = 0;
        /*
        $csql ="select *,sisa=terima-keluar from(
					select a.kode,a.nama,isnull(nilai,0) [terima],(select isnull(sum(f.nilai),0) [nilai] from trhsp2d e join trdspp f on e.no_spp=f.no_spp  where status_bud='1' 
					and month(e.tgl_kas_bud)>='$blnawal' and month(e.tgl_kas_bud)<='$blnakhir' and e.bank_bud=a.kode) [keluar] 
					from ms_bank a left join 
					(select b.kd_bank_bud,sum(c.rupiah) [nilai] from trhkasin_ppkd b join trdkasin_ppkd c 
					on b.no_sts=c.no_sts and b.kd_skpd=c.kd_skpd where month(b.tgl_kas)>='$blnawal' and month(b.tgl_kas)<='$blnakhir' group by b.kd_bank_bud) d 
					on a.kode=d.kd_bank_bud where a.rekening<>''
				)as g order by kode ";
		*/
        $csql ="select *,sisa=terima-keluar from(
        		select a.kode,a.nama,isnull(nilai,0) [terima],
					(
						select sum(nilai) from(
							select isnull(sum(f.nilai),0) [nilai] from trhsp2d e join trdspp f on e.no_spp=f.no_spp  
							where status_bud='1' and month(e.tgl_kas_bud)<='$blnakhir' and e.bank_bud=a.kode
							union all 
							select isnull(sum(nilai),0) [nilai] from transfer_bank_kasda where kd_bank_bud1=a.kode and month(tgl_kas)<='$blnakhir'
						)as g
					) [keluar] 
					from ms_bank a left join 
					(
						select kd_bank_bud,sum(nilai) [nilai] from(
							select b.kd_bank_bud,sum(c.rupiah) [nilai] from trhkasin_ppkd b join trdkasin_ppkd c 
							on b.no_sts=c.no_sts and b.kd_skpd=c.kd_skpd where month(b.tgl_kas)<='$blnakhir' group by b.kd_bank_bud
							union all 
							select kd_bank_bud2 as kd_bank_bud,isnull(sum(nilai),0) [nilai] from transfer_bank_kasda where month(tgl_kas)<='$blnakhir'
							group by kd_bank_bud2
						)as h group by kd_bank_bud
					) d 
					on a.kode=d.kd_bank_bud where a.rekening<>''
				)as g order by kode ";

        $hasil = $this->db->query($csql);
        return $hasil;
    }   



    function q_ttd($ttd,$kode){
        $hasil = 0;
        $csql ="select nip,nama,jabatan,pangkat from ms_ttd where nip='$ttd' and kode='$kode'";
        $hasil = $this->db->query($csql);
        return $hasil;
    } 	


    function cek_menu_user($user,$menuid){
        $hasil = 0;
        $csql ="select dbo.cek_menu_user('$user','$menuid') as jumlah";
        $hasil = $this->db->query($csql);
        $hasil = $hasil->row('jumlah');
        return $hasil;        
    }

    function rekapt_puskesmas_bln($kdrek5,$kd_skpd,$bln,$thn){
        $hasil = array();
        $this->db->trans_start();
        $asg = $this->db->query("rekap_terima_puskesmas_bln '$kdrek5','$kd_skpd','$bln','$thn'");
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
               $hasil = array('pesan' =>0,'query' => '');
        } else{
               $hasil = array('pesan' =>1,'query' => $asg);
        }
        return $hasil;
    } 

    
// -----------------------------------------------------	

}

/* End of file fungsi_model.php */
/* Location: ./application/models/fungsi_model.php */
