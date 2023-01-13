<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    function __construct(){
        parent::__construct();
        if($this->session->userdata('status') != "login"){
            redirect(base_url("Login"));
        }
        $this->load->model('m_master');
        $this->load->model('m_fungsi');

        $this->db = $this->load->database('default', TRUE);

    }

    function Timbangan(){
		$this->load->view('header');
        $this->load->view('Laporan/v_lap_timbangan');
        $this->load->view('footer');
    }

    function csv(){
        $this->load->view('header');
        $this->load->view('Laporan/v_lap_csv');
        $this->load->view('footer');
    }

    function print_label_pl(){
        $this->load->view('header');
        $this->load->view('Laporan/v_lap_p_label_pl');
        $this->load->view('footer');
    }

    function print_sj(){
        $this->load->view('header');
        $this->load->view('Laporan/v_surat_jalan');
        $this->load->view('footer');
    }

    function update_stok_gudang(){
        $this->load->view('header');
        $this->load->view('Laporan/v_stok_gudang');
        $this->load->view('footer');
    }

    function update_penjualan_roll(){
        $this->load->view('header');
        $this->load->view('Laporan/v_update_roll');
        $this->load->view('footer');
    }

    function update_po(){
        $this->load->view('header');
        $this->load->view('Laporan/v_update_po');
        $this->load->view('footer');
    }

    function PenjualanHarian(){
        $this->load->view('header');
        $this->load->view('Laporan/v_penjualanHarian');
        $this->load->view('footer');
    }

    function PenjualanRekap(){
        $this->load->view('header');
        $this->load->view('Laporan/v_penjualanRekap');
        $this->load->view('footer');
    }

    function PenjualanTahunan(){
        $this->load->view('header');
        $this->load->view('Laporan/v_penjualanTahunan');
        $this->load->view('footer');
    }

	function LaporanInvoice(){
        $this->load->view('header');
        $this->load->view('Laporan/v_lapinvoice');
        $this->load->view('footer');
    }

	function POCorrugated(){
        $this->load->view('header');
        $this->load->view('Laporan/v_pocorr');
        $this->load->view('footer');
    }

    function Penjualan_PO(){
        $this->load->view('header');
        $this->load->view('Laporan/v_penjualan_po');
        $this->load->view('footer');
    }

    function Pengiriman_Roll(){
        $this->load->view('header');
        $this->load->view('Laporan/v_pengiriman_roll');
        $this->load->view('footer');
    }

	function Stok_Gudang(){
        $this->load->view('header');
        $this->load->view('Laporan/v_stok');
        $this->load->view('footer');
    }

    function List_Roll(){
        $this->load->view('header');
        $this->load->view('Laporan/v_qc');
        $this->load->view('footer');
    }

    function Laporan(){
        $tgl1 = $_GET['tgl1'];
        $tgl2 = $_GET['tgl2'];
        $jenis = $_GET['jenis'];

        if ($jenis == "3") {
            // BELUM DIPACKING
            $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2'");
            // $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2' AND status ='0'");
            // $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2' AND nm_ker='WP' AND pm='2'");
        }else if ($jenis == "4") {
            // LAP CORR / LAMINASI
            $data_detail = $this->db->query("SELECT a.*,b.tgl as tgl_pl FROM m_timbangan a
			INNER JOIN pl b ON a.id_pl=b.id
			WHERE b.no_pkb='$tgl1'");
        }else if($jenis == "11"){
            $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2' AND pm='1'
            ORDER BY pm,id");
        }else if($jenis == "22"){
            $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2' AND (pm='2' OR pm IS NULL)
            ORDER BY pm,id");
        }else{
            // KESELURUHAN
            $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2'
            ORDER BY pm,id");
            // $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2' AND nm_ker='WP' AND pm='2'");
            // $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2' AND (ket LIKE '%COLOUR%' OR KET LIKE '%COLOR%' OR KET LIKE '%WHITE SPOT%')");
            // $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2' AND nm_ker LIKE '%TL%'");
            // $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2' AND roll BETWEEN '0000%' AND '00023%' AND id_pl='0'");
        }
        $html = '';

        $html .='<style>
            .str{
                mso-number-format:\@;
            }
        </style>';

		if($jenis == "4"){
			$tmplTgl = $tgl1.' - '.strtoupper($this->m_fungsi->tanggal_format_indonesia($data_detail->row()->tgl_pl));
			$titleLap = '';
			$fsz = '15px';
		}else{
			$tmplTgl = $this->m_fungsi->tanggal_format_indonesia($tgl1).' S/D '.$this->m_fungsi->tanggal_format_indonesia($tgl2);
			$titleLap = 'Laporan Timbangan';
			$fsz = '10px';
		}

        $html .= '<table width="100%" border="0" style="font-size:'.$fsz.'">
                    <tr>
                        <td colspan="13" align="center">
							<b><u><font style="font-size:18px">'.$titleLap.'</font></u> <br> 
							'.$tmplTgl.'</b>
                        </td>
                    </tr>
					</table>
					<br>
					<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size:'.$fsz.'">
                    <tr bgcolor="#CCCCCC">
                        <td align="center">No</td>
                        <td align="center">Roll Number</td>
                        <td align="center">Jenis Kertas</td>
                        <td align="center">Gramatur Label</td>
                        <td align="center">Gramatur Aktual</td>
                        <td align="center">Width</td>
                        <td align="center">Diameter</td>
                        <td align="center">Weight</td>
                        <td align="center">Joint</td>
                        <td align="center">Rct</td>
                        <td align="center">BI</td>
                        <td align="center">Status</td>
                        ';
                        // if ($jenis != "1") {
                        //     $html .= '<td align="center">Quality</td>';
                        // }
                        if ($jenis == "2") {
                            $html .= '
								<td align="center">Quality</td>
								<td align="center">Operator</td>';
                        }
                        $html .= '
							<td align="center">Keterangan</td>
						</tr>';
                    $no = 1;
                    $tot_weight = 0 ;

                    if($data_detail->num_rows() > 0) {
                        foreach ($data_detail->result() as $r ) {
                            if($r->status == 0){
								$stat = 'STOK';
							}else if($r->status == 2){
								$stat = 'PPI';
							}else if($r->status == 3){
								$stat = 'BUFFER';
							}else{
								$stat = '-';
							}
                            $html .= '<tr>
								<td align="center">'.$no.'</td>
								<td align="center">'.$r->roll.'</td>
								<td align="center">'.$r->nm_ker.'</td>
								<td align="center">'.$r->g_label.'</td>
								<td align="center">'.$r->g_ac.'</td>
								<td align="center">'.$r->width.'</td>
								<td align="center">'.$r->diameter.'</td>
								<td align="center">'.$r->weight.'</td>
								<td align="center">'.$r->joint.'</td>
								<td align="center">'.$r->rct.'</td>
								<td align="center">'.$r->bi.'</td>
								<td align="center">'.$stat.'</td>
								';
								// if ($jenis != "1") {
								//     $html .= '<td align="center"></td>';
								// }
								if ($jenis == "2") {
									$html .= '
										<td align="center"></td>
										<td align="center">'.$r->created_by.'</td>';
								}
								$html .= '
								<td align="center">'.$r->ket.'</td>
							</tr>';
						$no++;
						$tot_weight += $r->weight;
                        }
                    }

                    if ($jenis == "1" || $jenis == "4") {
						$html .= '<tr bgcolor="#CCCCCC">
							<td align="center" colspan="7">TOTAL BERAT</td>
							<td align="center">'.number_format($tot_weight).'</td>
							<td colspan="5"></td>
						</tr>';
                    }

                    $html .='</table>';

        $ctk = $_GET['ctk'];

		if($jenis == "4"){
			$judul = $tgl1;
		}else{
			$judul = "Laporan Timbangan Tanggal ".$tgl1 . " S/d ". $tgl2;
		}
        
        if ($ctk == '0') {
            echo $html;
        }else if ($ctk == '1') {
            // echo '<title>'.$judul. '</title>';
            $this->m_fungsi->_mpdf('',$html,10,10,10,'L');
        }else{
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=$judul.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $data2['prev']= $html;
            $this->load->view('view_excel', $data2);
        }
    }

    function lap_csv(){
        $tgl1 = $_GET['tgl1'];
        $tgl2 = $_GET['tgl2'];
        $jenis = $_GET['jenis'];
		//
        $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2' ORDER BY id ASC");        
        $html = '';

		if ($data_detail->num_rows() > 0) {
			foreach ($data_detail->result() as $r ) {
				$html .= '\N,"'.$r->roll.'","'.$r->tgl.'","'.$r->nm_ker.'","'.$r->g_ac.'","'.$r->g_label.'","'.$r->width.'","'.$r->diameter.'","'.$r->weight.'","'.$r->joint.'","'.$r->ket.'","'.$r->seset.'","'.$r->status.'","'.$r->id_pl.'",\N,\N,\N,\N,\N,\N,\N,\N,"'.$r->rct.'","'.$r->ctk.'","'.$r->bi.'","'.$r->pm.'"<br>';
			}
		}

        $ctk = $_GET['ctk'];

        $judul = "csv_".$tgl1."_".$tgl2;
        if ($ctk == '0') {
            echo $html;
        }else{
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=$judul.csv");
            header("Pragma: no-cache");
            header("Expires: 0");
            $data2['prev']= $html;
            $this->load->view('view_csv', $data2);
        }
    }

    function print_riject() {
        $jenis = $_GET['jenis'];
        $ctk = $_GET['ctk'];

        $html = '';

        // AMBIL DATA KOP
        $data_kop = $this->db->query("
        SELECT a.nm_ker AS ker,b.nama AS nama,b.nm_perusahaan AS pt,b.no_po AS popo FROM m_timbangan a
        INNER JOIN pl b ON a.id_pl=b.id
        WHERE b.no_pkb='$jenis'
        GROUP BY ker LIMIT 1;")->row();

        $html .= '<table cellspacing="0" style="font-size:11px !important;color:#000;border-collapse:collapse;text-align:center;width:100%;font-family:Arial !important">
        <tr>
            <th style="width:5% !important;height:15px"></th>
            <th style="width:15% !important;height:15px"></th>
            <th style="width:20% !important;height:15px"></th>
            <th style="width:40% !important;height:15px"></th>
            <th style="width:10% !important;height:15px"></th>
            <th style="width:10% !important;height:15px"></th>
        </tr>
        <tr>
            <td style="border:0;padding:0 0 5px;font-weight:bold" colspan="6">ROLL RIJECT - '.$data_kop->ker.'</td>
        </tr>
        <tr>
            <td style="border:1px solid #000;padding:5px 0">NO</td>
            <td style="border:1px solid #000;padding:5px 0" colspan="2">GSM</td>
            <td style="border:1px solid #000;padding:5px 0">ITEM DESCRIPTION</td>
            <td style="border:1px solid #000;padding:5px 0">QTY</td>
            <td style="border:1px solid #000;padding:5px 0">BERAT</td>
        </tr>';


        // AMBIL DATA
        $data_detail = $this->db->query("
        SELECT g_label,a.nm_ker AS ker,width,COUNT(*) AS qty,SUM(weight) AS berat,b.no_po as po FROM m_timbangan a
        INNER JOIN pl b ON a.id_pl=b.id
        WHERE b.no_pkb='$jenis'
        GROUP BY g_label,width,po
        ORDER BY po,g_label ASC,width ASC");

        $no = 1;
        $tot_qty= 0;
        $tot_berat= 0;

        $count = $data_detail->num_rows();
            
        foreach ($data_detail->result() as $data ) {

            $html .= '<tr>
                <td style="border:1px solid #000;padding:5px 0">'.$no.'</td>
                <td style="border:1px solid #000;padding:5px 0" colspan="2">'.$data->g_label.' GSM</td>';
            

            // PILIH JENIS KERTAS
            if($data->ker == 'MH' || $data->ker == 'MI'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">KERTAS MEDIUM ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'WP'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">KERTAS COKLAT ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'BK' || $data->ker == 'BL'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">KERTAS B-KRAFT ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'MEDIUM LINER'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">KERTAS MEDIUM LINER ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'MN'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">MEDIUM NON SPEK ROLL, LB '.round($data->width,2).'</td>';
            }else{
                $html .= '<td style="border:1px solid #000;padding:5px 0">LB '.round($data->width,2).'</td>';
            }
            

            $html .= '<td style="border:1px solid #000;padding:5px 0">'.$data->qty.' ROLL</td>
                <td style="border:1px solid #000;padding:5px 0">'.number_format($data->berat).' KG</td>';
        
            $no++;
            $tot_qty += $data->qty;
            $tot_berat += $data->berat;

        }
        
        // TOTAL
        $html .= '<tr>
            <td style="border:1px solid #000;padding:5px 0" colspan="4">TOTAL</td>
            <td style="border:1px solid #000;padding:5px 0">'.$tot_qty.' ROLL</td>
            <td style="border:1px solid #000;padding:5px 0">'.number_format($tot_berat).' KG</td>
        </tr>';

        $html .= '</table>';

        $this->m_fungsi->_mpdf2('',$html,10,10,10,'P','PL',999);
    }

    function print_surat_jalan(){ //
        $jenis = $_GET['jenis'];
        $ctk = $_GET['ctk'];
        $html = '';

		# # # # # # # # # K O P # # # # # # # # # #

        // AMBIL DATA KOP
        $data_kop = $this->db->query("SELECT b.tgl AS tgl_kop,a.nm_ker AS ker,b.nama AS nama,b.nm_perusahaan AS pt,b.no_po AS popo,b.no_pkb AS no_pkb,b.no_surat FROM m_timbangan a
        INNER JOIN pl b ON a.id_pl=b.id
        WHERE b.no_pkb='$jenis'
        GROUP BY ker LIMIT 1;")->row();

        // count data kop
        $count_kop = $this->db->query("SELECT a.g_label,a.nm_ker AS ker,width,COUNT(*) AS qty,SUM(weight) AS berat,b.no_po as po FROM m_timbangan a
        INNER JOIN pl b ON a.id_pl=b.id
        WHERE b.no_pkb='$jenis'
        GROUP BY a.g_label,width,b.no_po
        ORDER BY a.g_label,width,b.no_po ASC")->num_rows();

        // pengurangan jarak jika data terlalu banyak
        if($count_kop >= '10' || ($data_kop->pt == 'PT. DAYACIPTA KEMASINDO' || $data_kop->nama == 'PT. DAYACIPTA KEMASINDO' && $count_kop >= '7' )){
            $px = '0';
        }else if($data_kop->pt == 'PT. DAYACIPTA KEMASINDO' || $data_kop->nama == 'PT. DAYACIPTA KEMASINDO' && $count_kop >= '6' ){
            $px = '20px';
        }else if($count_kop >= '8' || ($data_kop->pt == 'PT. DAYACIPTA KEMASINDO' || $data_kop->nama == 'PT. DAYACIPTA KEMASINDO' && $count_kop >= '5' )){
            $px = '40px';
        }else if($data_kop->pt == 'PT. DAYACIPTA KEMASINDO' || $data_kop->nama == 'PT. DAYACIPTA KEMASINDO' && $count_kop >= '2' ){
            $px = '60px';
        }else{
            $px = '80px';
        }

        if($count_kop >= '16'){
            $pxsj = '3px';
            $pxlist = '6px';
        }else{
            $pxsj = '8px';
            $pxlist = '15px';
        }

        if($ctk == 99){ // printer epson
            $bKop = 'border-left:1px solid #f8f8f8;';
            $heh = '<th style="border-left:1px solid #f8f8f8;height:150px"></th>';
        }else{
            $bKop = '';
            $heh = '<th style="height:150px"></th>';
        }

        // http://localhost/SI_timbangan/assets/images/logo_ppi_1.png
        $kop_pakai = '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:Arial !important">
            <tr>
                <th style="width:25% !important;'.$bKop.'height:'.$px.'"></th>
                <th style="width:75% !important;height:'.$px.'"></th>
            </tr>
            <tr>
                <td style="border:0;background:url('.base_url().'assets/images/logo_ppi_inv.png)center no-repeat" rowspan="4"></td>
                <td style="border:0;font-size:32px;padding:20px 0 0">PT. PRIMA PAPER INDONESIA</td>
            </tr>
            <tr>
                <td style="border:0;font-size:14px">Dusun Timang Kulon, Desa Wonokerto, Kec.Wonogiri, Kab.Wonogiri</td>
            </tr>
            <tr>
                <td style="border:0;font-size:14px;padding:0">WONOGIRI - JAWA TENGAH - INDONESIA Kode Pos 57615</td>
            </tr>
            <tr>
                <td style="border:0;font-size:12px !important;padding:0 0 4px">http://primapaperindonesia.com</td>
            </tr>
        </table>

        <table cellspacing="0" style="font-size:18px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:Arial !important">
            <tr>
                <th style="width:15% !important;height:8px"></th>
            </tr>
            <tr>
                <td style="border-top:2px solid #000;padding:10px 0 5px;text-decoration:underline">SURAT JALAN</td>
            </tr>
        </table>';

        $kop_gak_pakai = '<table cellspacing="0" style="font-size:18px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:Arial !important">
            <tr>
                '.$heh.'
            </tr>
            <tr>
                <td style="border-top:2px solid #000;padding:10px 0 5px;text-decoration:underline">SURAT JALAN</td>
            </tr>
        </table>';

        // KONDISI KOP PADA SURAT JALAN > PPN ATAU NON-PPN
        // $nosj = '543/ROLL/XII/22/A/BK';
        $nosj = explode("/", trim($data_kop->no_surat));
        if($nosj[4] == 'A' || $nosj[4] == 'B'){
            if($nosj[4] == 'A'){
                $html .= $kop_pakai;
            }else{
                $html .= $kop_gak_pakai;
            }
        }else{
            if($data_kop->no_pkb == '160/21/WP' || $data_kop->no_pkb == '006/22/MH.' || $data_kop->nama == 'IBU. LANI' || $data_kop->pt == 'EDY NURWIDODO' || $data_kop->no_pkb == '001/22/SM' || $data_kop->nama == 'BP. IMAM'){
                $html .= $kop_gak_pakai;
            }else if($data_kop->ker == 'MH' || $data_kop->ker == 'BK' || $data_kop->ker == 'MEDIUM LINER' || $data_kop->popo == '013/KB/RSA-IX/22' || $data_kop->popo == '028/KB/RSA-IX/22' || $data_kop->popo == 'PO.SBB-AGJ/04-300922/2022' || $data_kop->popo == '0016/PHP/09/2022' || $data_kop->popo == '034/KB/RSA-X/22'){
                $html .= $kop_pakai;
            }else if($data_kop->ker == 'WP' && ($data_kop->popo == 'PO 03.2006.0004' || $data_kop->popo == 'PO 03.2007.0005' || $data_kop->popo == 'PO 03.2108.0005' || $data_kop->popo == 'PO 03.2109.0029' || $data_kop->popo == 'PO 03.2110.0001' || $data_kop->popo == 'PO 03.2110.0007' || $data_kop->popo == 'PO 03.2202.0003' || $data_kop->popo == 'PO-KP-2210-0007' || $data_kop->popo == 'PO-KP-2211-0004' || $data_kop->pt == 'PT. KEMILAU INDAH PERMANA' || $data_kop->pt == 'PT. QINGDA MASPION PAPER PRODUCTS' || $data_kop->pt == 'PT. WIRAPETRO PLASTINDO' || $data_kop->pt == 'PT. MITRA KEMAS' || $data_kop->pt == 'PT. ALPHA ALTITUDE PAPER' || $data_kop->pt == 'PT. DOMINO MAKMUR PLASTINDO' || $data_kop->pt == 'PT. DOMINO SUKSES BERSAMA' || $data_kop->pt == 'CV. DWI MITRA KEMASINDO')){
                $html .= $kop_pakai;
            }else if($data_kop->ker == 'WP' || $data_kop->nama == 'WILLIAM CMBP'){
                $html .= $kop_gak_pakai;
            }else{
                $html .= $kop_gak_pakai;
            }
        }

		# # # # # # # # # D E T A I L # # # # # # # # # #

        $data_pl = $this->db->query("SELECT DISTINCT * FROM pl WHERE no_pkb='$jenis'
        GROUP BY no_pkb")->row();

        $html .= '<table cellspacing="0" style="font-size:11px !important;color:#000;border-collapse:collapse;vertical-align:top;width:100%;font-family:Arial !important">
            <tr>
                <th style="width:15% !important;height:'.$pxsj.'"></th>
                <th style="width:1% !important;height:'.$pxsj.'"></th>
                <th style="width:28% !important;height:'.$pxsj.'"></th>
                <th style="width:15% !important;height:'.$pxsj.'"></th>
                <th style="width:1% !important;height:'.$pxsj.'"></th>
                <th style="width:40% !important;height:'.$pxsj.'"></th>
            </tr>';

        if($data_pl->no_po == "SAMPLE"){
            $kett = "SAMPLE";
        }else{
            $kett = "PACKING LIST TERLAMPIR";
        }

        if($data_pl->tgl == "0000-00-00" || $data_pl->tgl == "0001-00-00" || $data_pl->tgl == ""){
            $kett_tgll = "";
        }else{
            $kett_tgll = $this->m_fungsi->tanggal_format_indonesia($data_pl->tgl);
        }

        // NEW NOPOL
        if($data_pl->id_expedisi == null || $data_pl->id_expedisi == ''){
            if($data_pl->no_kendaraan == '' || $data_pl->no_kendaraan == '-'){
                $plat = "";
            }else{
                $plat = $data_pl->no_kendaraan;
            }
            $supir = '';
        }else{
            $nopol = $this->db->query("SELECT*FROM m_expedisi WHERE id='$data_pl->id_expedisi'")->row();
            $plat = $nopol->plat;
            $supir = $nopol->supir.'<br>'.$nopol->pt;
        }

        $html .= '<tr>
            <td style="padding:5px 0">TANGGAL</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$kett_tgll.'</td>
            <td style="padding:5px 0">KEPADA</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->nm_perusahaan.'</td>
        </tr>
        <tr>
            <td style="padding:5px 0">NO. SURAT JALAN</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.trim($data_pl->no_surat).'</td>
            <td style="padding:5px 0">ATTN</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->nama.'</td>
        </tr>
        <tr>
            <td style="padding:5px 0">NO. SO</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->no_so.'</td>
            <td style="padding:5px 0">ALAMAT</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->alamat_perusahaan.'</td>
        </tr>
        <tr>
            <td style="padding:5px 0">NO. PKB</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.substr($data_pl->no_pkb,0,9).'</td>
            <td style="padding:5px 0">NO. TELP / HP</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->no_telp.'</td>
        </tr>
        <tr>
            <td style="padding:5px 0">NO. KENDARAAN</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$plat.'</td>
            <td style="padding:5px 0">KETERANGAN</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$kett.'</td>
        </tr>';

        $html .= '</table>';

		# # # # # # # # # I S I # # # # # # # # # #

        $html .= '<table cellspacing="0" style="font-size:11px !important;color:#000;border-collapse:collapse;text-align:center;width:100%;font-family:Arial !important">
        <tr>
            <th style="width:5% !important;height:'.$pxlist.'"></th>
            <th style="width:30% !important;height:'.$pxlist.'"></th>
            <th style="width:15% !important;height:'.$pxlist.'"></th>
            <th style="width:30% !important;height:'.$pxlist.'"></th>
            <th style="width:10% !important;height:'.$pxlist.'"></th>
            <th style="width:10% !important;height:'.$pxlist.'"></th>
        </tr>
        <tr>
            <td style="border:1px solid #000;padding:5px 0">NO</td>
            <td style="border:1px solid #000;padding:5px 0">NO. PO</td>
            <td style="border:1px solid #000;padding:5px 0">SIZE</td>
            <td style="border:1px solid #000;padding:5px 0">ITEM DESCRIPTION</td>
            <td style="border:1px solid #000;padding:5px 0">QTY</td>
            <td style="border:1px solid #000;padding:5px 0">BERAT</td>
        </tr>';

        // AMBIL DATA
        $data_detail = $this->db->query("SELECT a.g_label,a.nm_ker AS ker,width,COUNT(*) AS qty,SUM(weight) AS berat,SUM(seset) AS seset,b.no_po as po,b.id_perusahaan,b.item_desc FROM m_timbangan a
        INNER JOIN pl b ON a.id_pl=b.id
        WHERE b.no_pkb='$jenis'
        -- GROUP BY g_label,width,po
        GROUP BY a.nm_ker,a.g_label,width,po
        -- ORDER BY po,g_label ASC,width ASC
        ORDER BY po,a.nm_ker DESC,a.g_label ASC,width ASC
        ");

        $no = 1;
        $tot_qty= 0;
        $tot_berat= 0;
        $count = $data_detail->num_rows();
        foreach ($data_detail->result() as $data ) {

            $html .= '<tr>
                <td style="border:1px solid #000;padding:5px 0">'.$no.'</td>
                <td style="border:1px solid #000;padding:5px 0">'.$data->po.'</td>
                <td style="border:1px solid #000;padding:5px 0">'.$data->g_label.' GSM</td>';
            
            // PILIH JENIS KERTAS
            if(($data->ker == 'MH' || $data->ker == 'MI') && $data->item_desc == 'MF'){ // MEDIUM FLUTING
                $html .= '<td style="border:1px solid #000;padding:5px 0">MEDIUM FLUTING ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'MH' || $data->ker == 'MI'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">KERTAS MEDIUM ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'WP'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">KERTAS COKLAT ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'BK' || $data->ker == 'BL'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">KERTAS B-KRAFT ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'MH COLOR'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">MEDIUM COLOR ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'MEDIUM LINER'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">MEDIUM LINER ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'MN' && $data->item_desc == 'ML'){ // RSA, AGJ-SURYA BUANA MEDIUM NON SPEK
                $html .= '<td style="border:1px solid #000;padding:5px 0">MEDIUM LINER ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'MN'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">MEDIUM NON SPEK ROLL, LB '.round($data->width,2).'</td>';
            }else{
                $html .= '<td style="border:1px solid #000;padding:5px 0">LB '.round($data->width,2).'</td>';
            }

            // SESET
            if($data->seset == 0 || $data->seset == null){
                $berat = $data->berat;
            }else{
                $berat = $data->berat - $data->seset;
            }
            $html .= '<td style="border:1px solid #000;padding:5px 0">'.number_format($data->qty).' ROLL</td>
                <td style="border:1px solid #000;padding:5px 0">'.number_format($berat).' KG</td>
            </tr>';
        
            $no++;
            $tot_qty += $data->qty;
            $tot_berat += $berat;
        }

        // TAMBAH KOTAK KOSONG
        if($count == 1) {
            $xx = 5;
        }else if($count == 2){
            $xx = 4;
        }else if($count == 3){
            $xx = 3;
        }else if($count == 4){
            $xx = 2;
        }else if($count == 5){
            $xx = 1;
        }
        
        if($count <= 5) {
            for($i = 0; $i < $xx; $i++){
                $html .= '<tr>
                    <td style="border:1px solid #000;padding:11px 0"></td>
                    <td style="border:1px solid #000;padding:11px 0"></td>
                    <td style="border:1px solid #000;padding:11px 0"></td>
                    <td style="border:1px solid #000;padding:11px 0"></td>
                    <td style="border:1px solid #000;padding:11px 0"></td>
                    <td style="border:1px solid #000;padding:11px 0"></td>
                </tr>';    
            }
        }
        
        // TOTAL
        $html .= '<tr>
            <td style="border:1px solid #000;padding:5px 0" colspan="4">TOTAL</td>
            <td style="border:1px solid #000;padding:5px 0">'.number_format($tot_qty).' ROLL</td>
            <td style="border:1px solid #000;padding:5px 0">'.number_format($tot_berat).' KG</td>
        </tr>';

        $html .= '</table>';

		# # # # # # # # # T T D # # # # # # # # # #      

        if($count_kop >= '16'){
            $px_ttd = '10px';
            $px_note = '5px';
            $akeh = 1;
        }else if($count_kop >= '13'){ // 13
            $px_ttd = '15px';
            $px_note = '20px';
            $akeh = 1;
        }else if($count_kop >= '12'){ // KHUSUS QINGDA
            $px_ttd = '20px';
            $px_note = '20px';
            $akeh = '';
        }else{
            $px_ttd = '35px';
            $px_note = '50px';
            $akeh = '';
        }

        if ($data_kop->no_pkb == 'RMH' || $data_kop->no_pkb == 'RBK' || $data_kop->no_pkb == 'RWP68' || $data_kop->no_pkb == 'RWP70' || $data_kop->no_pkb == 'RWPM' || $data_kop->no_pkb == 'RWPMC') {
            $html .= '';
        }else{
            $html .= '<table cellspacing="0" style="font-size:11px !important;color:#000;border-collapse:collapse;text-align:center;width:100%;font-family:Arial !important">
            <tr>
                <th style="width:14% !important;height:'.$px_ttd.'"></th>
                <th style="width:14% !important;height:'.$px_ttd.'"></th>
                <th style="width:14% !important;height:'.$px_ttd.'"></th>
                <th style="width:15% !important;height:'.$px_ttd.'"></th>
                <th style="width:15% !important;height:'.$px_ttd.'"></th>
                <th style="width:14% !important;height:'.$px_ttd.'"></th>
                <th style="width:14% !important;height:'.$px_ttd.'"></th>
            </tr>
            <tr>
                <td style="border:1px solid #000;padding:5px 0">DIBUAT</td>
                <td style="border:1px solid #000;padding:5px 0" colspan="2">DIKELUARKAN OLEH</td>
                <td style="border:1px solid #000;padding:5px 0">DI KETAHUI</td>
                <td style="border:1px solid #000;padding:5px 0">DI SETUJUI</td>
                <td style="border:1px solid #000;padding:5px 0">SOPIR</td>
                <td style="border:1px solid #000;padding:5px 0">DITERIMA</td>
            </tr>
            <tr>
                <td style="border:1px solid #000;height:80px"></td>
                <td style="border:1px solid #000;height:80px"></td>
                <td style="border:1px solid #000;height:80px"></td>
                <td style="border:1px solid #000;height:80px"></td>
                <td style="border:1px solid #000;height:80px"></td>
                <td style="border:1px solid #000;height:80px"></td>
                <td style="border:1px solid #000;height:80px"></td>
            </tr>
            <tr>
                <td style="border:1px solid #000;padding:5px 0">ARGA <br>ADMIN</td>
                <td style="border:1px solid #000;padding:5px 0">BP. DAMIRI <br>LAB./QC</td>
                <td style="border:1px solid #000;padding:5px 0">TITUT <br>SPV GUDANG</td>
                <td style="border:1px solid #000;padding:5px 0">BP. RIDWAN <br>MGR GUDANG</td>
                <td style="border:1px solid #000;padding:5px 0">BP. WEINARTO <br>GM</td>
                <td style="border:1px solid #000">'.$supir.'</td>
                <td style="border:1px solid #000"></td>
            </tr>
            <tr>
                <td style="height:'.$px_note.'" colspan="7"></td>
            </tr>
            <tr>
                <td style="font-weight:normal;text-align:left;padding:3px 0">NOTE :</td>
            </tr>
            <tr>
                <td style="font-weight:normal;text-align:left;padding:3px 0 3px 40px">WHITE</td>
                <td style="font-weight:normal;text-align:left;padding:3px 0" colspan="2" >: PEMBELI / CUSTOMER</td>
            </tr>
            <tr>
                <td style="font-weight:normal;text-align:left;padding:3px 0 3px 40px">PINK</td>
                <td style="font-weight:normal;text-align:left;padding:3px 0">: FINANCE</td>
            </tr>
            <tr>
                <td style="font-weight:normal;text-align:left;padding:3px 0 3px 40px">YELLOW</td>
                <td style="font-weight:normal;text-align:left;padding:3px 0">: ACC</td>
            </tr>
            <tr>
                <td style="font-weight:normal;text-align:left;padding:3px 0 3px 40px">GREEN</td>
                <td style="font-weight:normal;text-align:left;padding:3px 0">: ADMIN</td>
            </tr>
            <tr>
                <td style="font-weight:normal;text-align:left;padding:3px 0 3px 40px">BLUE</td>
                <td style="font-weight:normal;text-align:left;padding:3px 0">: EXPEDISI</td>
            </tr>
            ';
            $html .= '</table>';
        }

            ################## CETAK

        if ($ctk == '0' || $ctk == 99) {
            $this->m_fungsi->_mpdf('',$html,10,10,$akeh,'P');
        }else{
            ////////////////////////////////// CETAK PACKING LIST ////////////////////////////////////////////
            $html = '';

            $data_header = $this->db->query("SELECT DISTINCT a.*,b.nm_ker,COUNT(b.roll) AS roll FROM pl a
                INNER JOIN m_timbangan b ON a.id=b.id_pl
                WHERE a.no_pkb='$jenis'
                GROUP BY a.id
                ORDER BY no_po DESC,a.g_label DESC,width DESC");

            foreach ($data_header->result() as $data_pl) {
                if($data_pl->roll >= 38){
                    $e_width = '
                    <th style="border:0;padding:0;width:12%"></th>
                    <th style="border:0;padding:0;width:1%"></th>
                    <th style="border:0;padding:0;width:24%"></th>
                    <th style="border:0;padding:0;width:12%"></th>
                    <th style="border:0;padding:0;width:1%"></th>
                    <th style="border:0;padding:0;width:40%"></th>';
                }else{
                    $e_width = '
                    <th style="border:0;padding:0;width:16%"></th>
                    <th style="border:0;padding:0;width:1%"></th>
                    <th style="border:0;padding:0;width:30%"></th>
                    <th style="border:0;padding:0;width:16%"></th>
                    <th style="border:0;padding:0;width:1%"></th>
                    <th style="border:0;padding:0;width:30%"></th>';
                }
                
                $html .= '<table cellspacing="0" cellpadding="2" style="font-size:10px;width:100%;vertical-align:top;border-collapse:collapse;color:#000" >
                <tr>
                    '.$e_width.'
                </tr>';

                if($data_pl->tgl == "0000-00-00" || $data_pl->tgl == "0001-00-00"){
                    $p_tgl = "";
                }else{
                    $p_tgl = $this->m_fungsi->tanggal_format_indonesia($data_pl->tgl);
                }

                // NEW NOPOL
                if($data_pl->id_expedisi == null || $data_pl->id_expedisi == ''){
                    if($data_pl->no_kendaraan == '' || $data_pl->no_kendaraan == '-'){
                        $paltPl = "";
                    }else{
                        $paltPl = $data_pl->no_kendaraan;
                    }
                }else{
                    $nopolpl = $this->db->query("SELECT*FROM m_expedisi WHERE id='$data_pl->id_expedisi'")->row();
                    $paltPl = $nopolpl->plat;
                }

                $html .= '<tr>
                    <td style="padding:0 0 2px;text-align:center;font-weight:bold;text-decoration:underline" colspan="6">PACKING LIST</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>'.$p_tgl.'</td>
                    <td>Kepada</td>
                    <td>:</td>
                    <td>'.$data_pl->nm_perusahaan.'</td>
                </tr>
                <tr>
                    <td>No Surat Jalan</td>
                    <td>:</td>
                    <td>'.$data_pl->no_surat.'</td>
                    <td>Alamat</td>
                    <td>:</td>
                    <td style="overflow-wrap:break-word !important">'.$data_pl->alamat_perusahaan.'</td>
                </tr>
                <tr>
                    <td>No SO</td>
                    <td>:</td>
                    <td>'.$data_pl->no_so.'</td>
                    <td>ATTN</td>
                    <td>:</td>
                    <td>'.$data_pl->nama.'</td>
                </tr>
                <tr>
                    <td>No PKB</td>
                    <td>:</td>
                    <td>'.substr($data_pl->no_pkb,0,9).'</td>
                    <td>No Telp / No HP</td>
                    <td>:</td>
                    <td>'.$data_pl->no_telp.'</td>
                </tr>
                <tr>
                    <td>No Kendaraan</td>
                    <td>:</td>
                    <td>'.$paltPl.'</td>
                    <td>No PO</td>
                    <td>:</td>
                    <td>'.$data_pl->no_po.'</td>
                </tr>';

                $html .= '</table>';

                $html .= '<table cellspacing="0" cellpadding="5" style="font-size:11px;width:100%;text-align:center;border-collapse:collapse;color:#000" >';

                /////////////////// PILAH ISI CEK SAMA OK

                $id_pl = $data_pl->id;
                $qrTotPL = $this->db->query("SELECT nm_ker,g_label,width,COUNT(roll) AS roll FROM m_timbangan WHERE id_pl = '$id_pl' GROUP BY nm_ker,g_label,nm_ker,width ORDER BY nm_ker DESC,g_label ASC,width ASC");

                // CEK QC PACKING LIST
                if($ctk == 2){
                    $kop_detail = $this->db->query("SELECT id_pl,nm_ker,COUNT(*) AS jml_roll,SUM(weight) AS berat,SUM(seset) AS seset FROM m_timbangan WHERE id_pl='$id_pl' GROUP BY nm_ker ORDER BY nm_ker DESC");

                    // if($kop_detail->row()->nm_ker == 'WP' || $kop_detail->row()->nm_ker == 'MN'){
                    if($kop_detail->row()->nm_ker == 'WP'){
                        $html .= '<tr>
                            <th style="padding:2px 0;width:5%"></th>
                            <th style="padding:2px 0;width:9%"></th>
                            <th style="padding:2px 0;width:9%"></th>
                            <th style="padding:2px 0;width:10%"></th>
                            <th style="padding:2px 0;width:10%"></th>
                            <th style="padding:2px 0;width:10%"></th>
                            <th style="padding:2px 0;width:10%"></th>
                            <th style="padding:2px 0;width:10%"></th>
                            <th style="padding:2px 0;width:27%"></th>
                        </tr>';
                        $cs = '4';
                    }else{
                        $html .= '<tr>
                            <th style="padding:2px 0;width:5%"></th>
                            <th style="padding:2px 0;width:8%"></th>
                            <th style="padding:2px 0;width:8%"></th>
                            <th style="padding:2px 0;width:9%"></th>
                            <th style="padding:2px 0;width:9%"></th>
                            <th style="padding:2px 0;width:9%"></th>
                            <th style="padding:2px 0;width:9%"></th>
                            <th style="padding:2px 0;width:9%"></th>
                            <th style="padding:2px 0;width:6%"></th>
                            <th style="padding:2px 0;width:28%"></th>
                        </tr>';
                        $cs = '5';
                    }

                    $totalRoll = 0;
                    $totalBerat = 0;
                    foreach($kop_detail->result() as $kd){
                        if($kd->nm_ker == 'MH' || $kd->nm_ker == 'MI'){
                            $dkop = '<td style="border:1px solid #000;font-weight:bold">RCT</td>';
                            $joint = 'JNT';
                        }else if($kd->nm_ker == 'BK' || $kd->nm_ker == 'BL'){
                            $dkop = '<td style="border:1px solid #000;font-weight:bold">BI</td>';
                            $joint = 'JNT';
                        // }else if($kd->nm_ker == 'WP' || $kd->nm_ker == 'MN'){
                        }else if($kd->nm_ker == 'WP'){
                            $dkop = '';
                            $joint = 'JOINT';
                        }else{
                            // $dkop = '';
                            $dkop = '<td style="border:1px solid #000;font-weight:bold">-</td>';
                            $joint = 'JNT';
                        }

                        $html .= '<tr>
                            <td style="border:1px solid #000;font-weight:bold">NO</td>
                            <td style="border:1px solid #000;font-weight:bold" colspan="2">ROLL - '.$kd->nm_ker.'</td>
                            <td style="border:1px solid #000;font-weight:bold">BW</td>
                            '.$dkop.'
                            <td style="border:1px solid #000;font-weight:bold">GSM</td>
                            <td style="border:1px solid #000;font-weight:bold">WIDTH</td>
                            <td style="border:1px solid #000;font-weight:bold">BERAT</td>
                            <td style="border:1px solid #000;font-weight:bold">'.$joint.'</td>
                            <td style="border:1px solid #000;font-weight:bold">KETERANGAN</td>
                        </tr>';

                        // ISI
                        $isiDetail = $this->db->query("SELECT * FROM m_timbangan WHERE id_pl='$kd->id_pl' AND (nm_ker='$kd->nm_ker') ORDER BY nm_ker DESC,g_label ASC,width ASC,roll ASC");

                        $no = 1;
                        foreach($isiDetail->result() as $r){
                            if($r->g_ac == 0){
                                $c_g_ac = number_format($r->g_ac);
                            }else{
                                $c_g_ac = $r->g_ac;
                            }
                            
                            if($r->rct == 0){
                                $c_rct = number_format($r->rct);
                            }else{
                                $c_rct = $r->rct;
                            }

                            if($r->bi == 0){
                                $c_bi = number_format($r->bi);
                            }else{
                                $c_bi = $r->bi;
                            }

                            if($r->nm_ker == 'MH' || $r->nm_ker == 'MI'){
                                $cek = '<td style="border:1px solid #000">'.$c_rct.'</td>';
                            }else if($r->nm_ker == 'BK' || $r->nm_ker == 'BL'){
                                $cek = '<td style="border:1px solid #000">'.$c_bi.'</td>';
                            // }else if($r->nm_ker == 'WP' || $kd->nm_ker == 'MN'){
                            }else if($r->nm_ker == 'WP'){
                                $cek = '';
                            }else{
                                // $cek = '';
                                $cek = '<td style="border:1px solid #000">-</td>';
                            }

                            if($r->status == 2){
                                $pKet = '+PPI';
                            }else{
                                $pKet = '';
                            }

							if(($r->nm_ker == 'MH' || $r->nm_ker == 'MN') && ($r->g_label == 105 || $r->g_label == 110)){
								$bgCrGsm = '#eef';
							}else if($r->nm_ker == 'MH' && ($r->g_label == 120 || $r->g_label == 125)){
								$bgCrGsm = '#ffe';
							}else if(($r->nm_ker == 'MH' || $r->nm_ker == 'MN') && $r->g_label == 150){
								$bgCrGsm = '#fee';
							}else if($r->nm_ker == 'WP'){
								$bgCrGsm = '#efe';
							}else{
								$bgCrGsm = '#fff';
							}

                            // SESET ISI LIST
                            if($r->seset == 0 || $r->seset == null){
                                $tBerat = $r->weight;
                                $sesetKet = '';
                            }else{
                                $tBerat = $r->weight - $r->seset;
                                $sesetKet = '- '.$r->seset.'KG. '.$r->weight.'. ';
                            }

                            $html .= '<tr>
                                <td style="border:1px solid #000">'.$no.'</td>
                                <td style="border:1px solid #000;letter-spacing:0.5px" colspan="2">'.$r->roll.'</td>
                                <td style="border:1px solid #000">'.$c_g_ac.'</td>
                                '.$cek.'
                                <td style="border:1px solid #000;background-color:'.$bgCrGsm.'">'.$r->g_label.'</td>
                                <td style="border:1px solid #000">'.round($r->width,2).'</td>
                                <td style="border:1px solid #000">'.$tBerat.'</td>
                                <td style="border:1px solid #000">'.$r->joint.'</td>
                                <td style="border:1px solid #000;text-align:left;font-size:10px">'.$sesetKet.''.strtoupper($r->ket).''.$pKet.'</td>
                            </tr>';
                            $no++;
                        }

                        // SESET SATU PL
                        if($kd->seset == 0 || $kd->seset == null){
                            $sumBerat = $kd->berat;
                        }else{
                            $sumBerat = $kd->berat - $kd->seset;
                        }
                        $totalRoll += $kd->jml_roll;
                        $totalBerat += $sumBerat;
                    }

                    $html .='<tr>
                        <td style="padding:0;border:1px solid #000;font-weight:bold">'.$totalRoll.'</td>
                        <td style="border:1px solid #000;font-weight:bold" colspan="'.$cs.'">-</td>
                        <td style="border:1px solid #000;font-weight:bold">TOTAL</td>
                        <td style="border:1px solid #000;font-weight:bold">'.number_format($totalBerat).'</td>
                        <td style="border:1px solid #000" colspan="2"></td>
                    </tr>';

                    $html .='<tr>
                        <td style="padding:5px 0 0;border:0;font-weight:normal;text-align:left" colspan="10" >';
                            foreach($qrTotPL->result() as $abc){
								if(($abc->nm_ker == 'MH' || $abc->nm_ker == 'MN') && ($abc->g_label == 105 || $abc->g_label == 110)){
									$bcg2 = '#eef';
								}else if($abc->nm_ker == 'MH' && ($abc->g_label == 120 || $abc->g_label == 125)){
									$bcg2 = '#ffe';
								}else if(($abc->nm_ker == 'MH' || $abc->nm_ker == 'MN') && $abc->g_label == 150){
									$bcg2 = '#fee';
								}else if($abc->nm_ker == 'WP'){
									$bcg2 = '#efe';
								}else{
									$bcg2 = '#fff';
								}

                                $html .= '<span style="background-color:'.$bcg2.'">( '.$abc->roll.' - '.round($abc->width,2).' )</span> ';
                            }
                    $html .='</td></tr>';

                    // $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE id_pl = '$id_pl' ORDER BY nm_ker DESC,g_label ASC,width ASC,tgl ASC,roll ASC");

                }else{

                    // FIX PACKING LIST

                    // CORRUGATED
                    if($ctk == 3){
                        $kopKet = 'JENIS';
                    }else{
                        $kopKet = 'KETERANGAN';
                    }

                    $html .= '<tr>
                        <th style="padding:2px 0;width:8%"></th>
                        <th style="padding:2px 0;width:12%"></th>
                        <th style="padding:2px 0;width:12%"></th>
                        <th style="padding:2px 0;width:12%"></th>
                        <th style="padding:2px 0;width:13%"></th>
                        <th style="padding:2px 0;width:13%"></th>
                        <th style="padding:2px 0;width:10%"></th>
                        <th style="padding:2px 0;width:16%"></th>
                    </tr>
                    <tr>
                        <td style="border:1px solid #000">No</td>
                        <td style="border:1px solid #000" colspan="2">Nomer Roll</td>
                        <td style="border:1px solid #000">Gramage (GSM)</td>
                        <td style="border:1px solid #000">Lebar (CM)</td>
                        <td style="border:1px solid #000">Berat (KG)</td>
                        <td style="border:1px solid #000">JOINT</td>
                        <td style="border:1px solid #000">'.$kopKet.'</td>
                    </tr>';

                    $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE id_pl = '$id_pl' ORDER BY nm_ker ASC,g_label ASC,width ASC,roll ASC");

                    $no = 0;
					$fxSumBerat = 0;
                    foreach ($data_detail->result() as $r) {
                        $no++;
                        if($ctk == 3){
                            if($r->nm_ker == 'MH' || $r->nm_ker == 'MI'){
                                $ketKet = 'MH';
                            }else if($r->nm_ker == 'BK' || $r->nm_ker == 'BL'){
                                $ketKet = 'BK';
                            }else{
                                $ketKet = $r->nm_ker;
                            }
                        }else{
                            $ketKet = '';
                        }

                        $x_roll = explode("/",$r->roll);
						if($x_roll[0] == 1 || $x_roll[0] == 2){
							$uk1 = $x_roll[0]."/".$x_roll[1];
							$uk2 = $x_roll[2]."/".$x_roll[3];
						}else{
							$uk1 = substr($r->roll,0, 5);
							$uk2 = substr($r->roll,6, 15);
						}

                        // SESET
                        if($r->seset == 0 || $r->seset == null){
                            $bWeight = $r->weight;
                        }else{
                            $bWeight = $r->weight - $r->seset;
                        }
                        $html .= '<tr>
                            <td style="border:1px solid #000">'.$no.'</td>
                            <td style="border:1px solid #000">'.$uk1.'</td>
                            <td style="border:1px solid #000">'.$uk2.'</td>
                            <td style="border:1px solid #000">'.$r->g_label.'</td>
                            <td style="border:1px solid #000">'.round($r->width,2).'</td>
                            <td style="border:1px solid #000">'.$bWeight.'</td>
                            <td style="border:1px solid #000">'.$r->joint.'</td>
                            <td style="border:1px solid #000;text-align:left">'.$ketKet.'</td>
                        </tr>';

                        $fxSumBerat += $bWeight;
                    }

                    // $total_pl = $this->db->query("SELECT DISTINCT COUNT(*) AS totpl,width,SUM(weight) AS tot,SUM(seset) AS seset FROM m_timbangan WHERE id_pl = '$id_pl' ORDER BY roll")->row();
                    // atas 
                    $count_pl = $qrTotPL->num_rows();
                    $total_pl = $qrTotPL->row();
                    if($count_pl == '1'){
                        $html .='
                        <tr>
                            <td style="border:1px solid #000" colspan="4" ><b>'.($total_pl->roll).' ROLL (@ LB '.round( $total_pl->width,2).' )</b></td>';    
                    }else if($count_pl <> '1'){
                        $html .='<tr>
                            <td style="padding:0;border:1px solid #000;font-weight:bold" colspan="4" >-</td>';
                    }

                    $html .='<td style="border:1px solid #000"><b>Total</b></td>
                            <td style="border:1px solid #000"><b>'.number_format($fxSumBerat).'</b></td>
                            <td style="border:1px solid #000" colspan="2"></td>
                        </tr>';

                    if($ctk == 3){
                        $html .='<tr>
                            <td style="padding:5px 0 0;border:0;font-weight:normal;text-align:left" colspan="8" >';
                                foreach($qrTotPL->result() as $abc){
                                    $html .= '( '.$abc->roll.' - '.round($abc->width,2).' ) ';
                                }
                        $html .='</td></tr>';
                    }
                }

                $html .= '</table>';
                $html .= '<div style="page-break-after:always"></div>';
            }

            // TOTAL PL YANG BISA DI TAMPILANKAN DALAM SATU HALAMAN ANTARA 34 - 39
            $count_p_pl = $data_detail->num_rows();  

            if($count_p_pl >= 38){
                $this->m_fungsi->_mpdf2('',$html,10,10,10,'P','PL',3);
            }else if($count_p_pl >= 35){
                $this->m_fungsi->_mpdf2('',$html,10,10,10,'P','PL',2);
            }else if($count_p_pl >= 34){
                $this->m_fungsi->_mpdf2('',$html,10,10,10,'P','PL',1);
            }else if($count_p_pl < 34){
                $this->m_fungsi->_mpdf2('',$html,10,10,10,'P','PL',0);
            }
        }
    }

    function print_lbl_pl(){
        $jenis = $_GET['jenis'];
        $ctk = $_GET['ctk'];
        $all = $_GET['all'];
        $html = '';
        
        // LABEL CRR
        if($ctk == 3){
            $lmt = 'LIMIT 2';
        }else{
            $lmt = '';
        }

        // LABEL ROLL
        if($ctk == 'A4' || $ctk == 'a4' || $ctk == 'F4' || $ctk == 'f4'){
			if($all != 0){
				$data_detail = $this->db->query("SELECT * FROM m_timbangan a
				INNER JOIN pl b ON a.id_pl=b.id
				WHERE b.no_pkb='$all' AND (ket LIKE '-%' OR ket LIKE ' %' OR seset > '0')
				ORDER BY a.nm_ker DESC,a.g_label ASC,a.width ASC,a.roll ASC");
			}else{
				$data_detail = $this->db->query("SELECT * FROM m_timbangan a
				WHERE a.id_rk='$jenis' AND (ket LIKE '-%' OR ket LIKE ' %' OR seset > '0' OR lbl_rk='req')
				ORDER BY a.nm_ker DESC,a.g_label ASC,a.width ASC,a.roll ASC");
			}
        }else if($jenis != 0 && $all == 0){
            // $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE id_pl='$jenis' ORDER BY nm_ker ASC,g_label ASC,width ASC,roll ASC");
            $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE id_rk='$jenis' ORDER BY nm_ker ASC,g_label ASC,width ASC,roll ASC");
        }else{
            $data_detail = $this->db->query("SELECT * FROM m_timbangan a
            INNER JOIN pl b ON a.id_pl=b.id
            -- WHERE b.no_pkb='$all'
            WHERE b.id_rk='$jenis'
            ORDER BY a.nm_ker DESC,a.g_label ASC,a.width ASC,a.roll ASC $lmt");
            // ORDER BY a.nm_ker ASC,a.g_label ASC,a.width ASC,a.roll ASC
            // ORDER BY a.nm_ker DESC,a.g_label DESC,a.width DESC,a.roll DESC
        }
        
        $data_perusahaan = $this->db->query("SELECT * FROM perusahaan limit 1")->row();
        if($data_detail->num_rows() > 0) {
			foreach ($data_detail->result() as $data ) {
				if($data->seset == 0 || $data->seset == null){
                    $lWeight = $data->weight;
                }else{
                    $lWeight = $data->weight - $data->seset;
                }

                $ket = 0;
                $sty = '';

				if($ctk == 0 || $ctk == 2 || $ctk == 'A4' || $ctk == 'F4'){
                    // if($data->status == 0){
                    //     $ket = 0;
                    //     $sty = '';
                    // }else{
                    //     if($data->ket == ''){
                    //         $sty = '';
                    //         $ket = 'BUFFER';
                    //     }else{
                    //         $sty = ';font-weight:bold;font-size:18px';
                    //         $ket = $data->ket;
                    //     }
                    // }

                    $html .= '<h1 style="margin:0;padding:0">'.$data_perusahaan->nama.'</h1>
                        <div style="margin:8px 0">'.$data_perusahaan->daerah.' , Email : '.$data_perusahaan->email.'</div>
                        <table style="margin:0;font-size:52px;width:100%" cellspacing="0" border="1">
                            <tr>
                                <td style="width:50%">QUALITY</td>
                                <td style="text-align:center">'.$data->nm_ker.'</td>
                            </tr>
                            <tr>
                                <td>GRAMMAGE</td>
                                <td style="text-align:center">'.$data->g_label.' GSM</td>
                            </tr>
                            <tr>
                                <td>WIDTH</td>
                                <td style="text-align:center">'.round($data->width, 2).' CM</td>
                            </tr>
                            <tr>
                                <td>DIAMETER</td>
                                <td style="text-align:center">'.$data->diameter.' CM</td>
                            </tr>
                            <tr>
                                <td>WEIGHT</td>
                                <td style="text-align:center">'.($lWeight).' KG</td>
                            </tr>
                            <tr>
                                <td>JOINT</td>
                                <td style="text-align:center">'.$data->joint.'</td>
                            </tr>
                            <tr>
                                <td>ROLL NUMBER</td>
                                <td style="text-align:center">'.$data->roll.'</td>
                            </tr>
                            <tr>
                                <td>LOC</td>
                                <td style="text-align:center'.$sty.'">'.$ket.'</td>
                            </tr>
                        </table>';
						// $html .= '
						// <div style="margin:0;color:#000">
						// <center> 
						// 	<h1 style="color:#000"> '.$data_perusahaan->nama.' </h1>  '.$data_perusahaan->daerah.' , Email : '.$data_perusahaan->email.'
						// </center>
						// </div>
						// <hr>';

						// // 35PX
						// $html .= '<br><br><br>
						// 		<table width="100%" cellspacing="0" cellpadding="5" style="font-size:52px;color:#000;margin:0">
						// 			<tr>
						// 				<td style="border:1px solid #000" align="left" width="50%">QUALITY</td>
						// 				<td style="border:1px solid #000" align="center">'.$data->nm_ker.'</td>
						// 			</tr>
						// 			<tr>
						// 				<td style="border:1px solid #000" align="left">GRAMMAGE</td>
						// 				<td style="border:1px solid #000" align="center">'.$data->g_label.' GSM</td>
						// 			</tr>
						// 			<tr>
						// 				<td style="border:1px solid #000" align="left">WIDTH</b></td>
						// 				<td style="border:1px solid #000" align="center">'.round($data->width,2).' CM</td>
						// 			</tr>
						// 			<tr>
						// 				<td style="border:1px solid #000" align="left">DIAMETER</td>
						// 				<td style="border:1px solid #000" align="center">'.$data->diameter.' CM</td>
						// 			</tr>
						// 			<tr>
						// 				<td style="border:1px solid #000" align="left">WEIGHT</td>
						// 				<td style="border:1px solid #000" align="center">'.$lWeight.' KG</td>
						// 			</tr>
						// 			<tr>
						// 				<td style="border:1px solid #000" align="left">JOINT</td>
						// 				<td style="border:1px solid #000" align="center">'.$data->joint.' </td>
						// 			</tr>
						// 			<tr>
						// 				<td style="border:1px solid #000" align="left">ROLL NUMBER</td>
						// 				<td style="border:1px solid #000" align="center">'.$data->roll.' </td>
						// 			</tr>
						// 	</table>';
                    // }
				}else if($ctk == 1){
					// if($data->weight == 0){
					// 	$html .= '';
					// }else if($data->weight <> 0){
                    // <div style="padding-top:100px;display:block;">
                    // <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size:37px;margin-bottom:605px">
                    $html .= '
                        <div style="padding-top:30px;display:block;">
                            <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size:37px;margin-bottom:100px">
                                <tr>
                                    <td align="left">QUALITY</td>
                                    <td align="center">'.$data->nm_ker.'</td>
                                </tr>
                                <tr>
                                    <td align="left">GRAMMAGE</td>
                                    <td align="center">'.$data->g_label.' GSM</td>
                                </tr>
                                <tr>
                                    <td align="left">WIDTH</td>
                                    <td align="center">'.round($data->width,2).' CM</td>
                                </tr>
                                <tr>
                                    <td align="left">DIAMETER</td>
                                    <td align="center">'.$data->diameter.' CM</td>
                                </tr>
                                <tr>
                                    <td align="left">WEIGHT</td>
                                    <td align="center">'.$lWeight.' KG</td>
                                </tr>
                                <tr>
                                    <td align="left">JOINT</td>
                                    <td align="center">'.$data->joint.' </td>
                                </tr>
                                <tr>
                                    <td align="left">ROLL NUMBER</td>
                                    <td align="center">'.$data->roll.'</td>
                                </tr>
                                <tr>
                                    <td>LOC</td>
                                    <td style="text-align:center'.$sty.'">'.$ket.'</td>
                                </tr>
                            </table>
                        </div>';
					// }
				}else if($ctk == 3){
					// <table width="100%" border="1" cellspacing="0" cellpadding="8" style="font-size:37px;margin-bottom:190px">
						$html .= '
							<div style="padding-top:30px;display:block;">
								<table width="100%" border="1" cellspacing="0" cellpadding="8" style="font-size:37px;margin-bottom:165px">
									<tr>
										<th style="width:50%;border:0;height:0;padding:0"></th>
										<th style="width:50%;border:0;height:0;padding:0"></th>
									</tr>
									<tr>
										<td>TANGGAL</td>
										<td></td>
									</tr>
									<tr>
										<td>NAMA CUSTOMER</td>
										<td></td>
									</tr>
									<tr>
										<td>TYPE</td>
										<td></td>
									</tr>
									<tr>
										<td>FLUTE</td>
										<td></td>
									</tr>
									<tr>
										<td>JUMLAH</td>
										<td></td>
									</tr>
									<tr>
										<td>OPERATOR</td>
										<td></td>
									</tr>
								</table>
							</div>';
				}
			}

            if($ctk == 'A4') {
                // $this->m_fungsi->_mpdf('',$html,10,10,10,'L');
                $this->m_fungsi->newMpdf($html, 10, 10, 10, 10, 'L', 'A4');
            }else if($ctk == 'F4'){
                // $this->m_fungsi->_mpdfCustom('',$html,10,10,10,'L');
                $this->m_fungsi->newMpdf($html, 15, 15, 15, 15, 'L', 'F4');
            }else if($ctk == 1 || $ctk == 3){
                // $this->m_fungsi->_mpdf('',$html,10,10,10,'P');
                $this->m_fungsi->newMpdf($html, 5, 10, 5, 10, 'P', 'A4');
            }else if($ctk == 2){
                // $this->m_fungsi->_mpdfCustom('',$html,10,10,10,'L');
                $this->m_fungsi->newMpdf($html, 15, 15, 15, 15, 'L', 'F4');
            }else{
                // $this->m_fungsi->_mpdf('',$html,10,10,10,'L');
                $this->m_fungsi->newMpdf($html, 15, 15, 15, 15, 'L', 'F4');
            }
        }else{
			echo 'KOSONG . . .';
		}
    }

    function print_invoice_v2(){
        $no_invoice = $_GET['no_invoice'];
        $ctk = 0;
        $html = '';

		//////////////////////////////////////// K O P ////////////////////////////////////////

        $data_detail = $this->db->query("SELECT * FROM invoice_header WHERE no_invoice='$no_invoice'")->row();
		$ppnpph = $data_detail->ppn;

		$html .= '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:"Trebuchet MS", Helvetica, sans-serif">';

        if($ppnpph == 3){
            $html .= '<tr>
                <th style="border:0;height:92px"></th>
            </tr>
            <tr>
                <td style="background:#ddd;border:1px solid #000;padding:6px;font-size:14px !important">INVOICE</td>
            </tr>';
            $html .= '</table>';
        }else if($ppnpph == 1 || $ppnpph == 2){
            $html .= '<tr>
                <th style="border:0;width:15%;height:0"></th>
                <th style="border:0;width:55%;height:0"></th>
                <th style="border:0;width:25%;height:0"></th>
            </tr>

            <tr>
                <td style="background:url(http://localhost/SI_timbangan_v2/assets/images/logo_ppi_1.png)center no-repeat" rowspan="3"></td>
                <td style="font-size:25px;padding:10px 0 0">PT. PRIMA PAPER INDONESIA</td>
            </tr>
            <tr>
                <td style="font-size:11px">Dusun Timang Kulon, Desa Wonokerto, Kec.Wonogiri, Kab.Wonogiri</td>
                <td></td>
            </tr>
            <tr>
                <td style="font-size:11px;padding:0 0 20px">WONOGIRI - JAWA TENGAH - INDONESIA Kode Pos 57615</td>
                <td style="padding:0 0 20px"></td>
            </tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:"Trebuchet MS", Helvetica, sans-serif">
            <tr>
                <th style="height:0"></th>
            </tr>
            <tr>
                <td style="background:#ddd;border:1px solid #000;padding:6px;font-size:14px !important">INVOICE</td>
            </tr>';
            $html .= '</table>';
        }       

		//////////////////////////////////////// D E T A I L //////////////////////////////////////

        $html .= '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;font-family:"Trebuchet MS", Helvetica, sans-serif">
        <tr>
            <th style="border:0;padding:2px 0;height:0;width:14%"></th>
            <th style="border:0;padding:2px 0;height:0;width:1%"></th>
            <th style="border:0;padding:2px 0;height:0;width:40%"></th>
            <th style="border:0;padding:2px 0;height:0;width:12%"></th>
            <th style="border:0;padding:2px 0;height:0;width:1%"></th>
            <th style="border:0;padding:2px 0;height:0;width:32%"></th>
        </tr>';

        $html .= '
        <tr>
            <td colspan="3"></td>
            <td style="padding:3px 0 20px;font-weight:bold">NOMOR</td>
            <td style="padding:3px 0 20px;font-weight:bold">:</td>
            <td style="padding:3px 0 20px;font-weight:bold">'.$data_detail->no_invoice.'</td>
        </tr>
        <tr>
            <td style="padding:3px 0">Nama Perusahaan</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:0 3px 0 0;line-height:1.8">'.$data_detail->nm_perusahaan.'</td>
            <td style="padding:3px 0;font-weight:bold">Jatuh Tempo</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:3px 0;font-weight:bold;color:#f00">'.$this->m_fungsi->tanggal_format_indonesia($data_detail->jto).'</td>
        </tr>';

		$html .= '<tr>
			<td style="padding:3px 0">Alamat</td>
			<td style="padding:3px 0">:</td>
			<td style="padding:0 3px 0 0;line-height:1.8">'.$data_detail->alamat_perusahaan.'</td>
			<td style="padding:3px 0">No. PO</td>
			<td style="padding:3px 0">:</td>
			<td style="padding:0;line-height:1.8">';

			// KONDISI JIKA LEBIH DARI 1 PO
			$result_po = $this->db->query("SELECT * FROM invoice_list WHERE no_invoice='$no_invoice' GROUP BY no_po ORDER BY no_po");
			if($result_po->num_rows() == '1'){
				$html .= $result_po->row()->no_po;;
			}else{
				foreach($result_po->result() as $r){
					$html .= $r->no_po.'<br/>';
				}
			}
		$html .= '</td>
		</tr>';

        $html .= '<tr>
            <td style="padding:3px 0">Kepada</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:0 3px 0 0;line-height:1.8">'.$data_detail->kepada.'</td>
            <td style="padding:3px 0">No. Surat Jalan</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:0;line-height:1.8">';

			// KONDISI JIKA LEBIH DARI 1 SURAT JALAN
			$result_sj = $this->db->query("SELECT * FROM invoice_list WHERE no_invoice='$no_invoice' GROUP BY no_surat ORDER BY no_surat");
			if($result_sj->num_rows() == '1'){
				$html .= $result_sj->row()->no_surat;;
			}else{
				foreach($result_sj->result() as $r){
					$html .= $r->no_surat.'<br/>';
				}
			}
		$html .= '</td>
		</tr>';

        $html .= '</table>';

		/////////////////////////////////////////////// I S I ///////////////////////////////////////////////

        $html .= '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;font-family:"Trebuchet MS", Helvetica, sans-serif">
        <tr>
            <th style="border:0;height:15px;width:30%"></th>
            <th style="border:0;height:15px;width:10%"></th>
            <th style="border:0;height:15px;width:15%"></th>
            <th style="border:0;height:15px;width:5%"></th>
            <th style="border:0;height:15px;width:10%"></th>
            <th style="border:0;height:15px;width:5%"></th>
            <th style="border:0;height:15px;width:25%"></th>
        </tr>';

        $html .= '<tr>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold">NAMA BARANG</td>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold">SATUAN</td>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold">JUMLAH</td>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold" colspan="2">HARGA</td>
            <td style="border:1px solid #000;border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold" colspan="2">TOTAL</td>
        </tr>';
		$html .= '<tr>
			<td style="border:0;padding:20px 0 0" colspan="7"></td>
		</tr>';

        $sqlLabel = $this->db->query("SELECT*FROM invoice_list WHERE no_invoice='$no_invoice' GROUP BY nm_ker DESC,g_label ASC,no_po");
		
		// TAMPILKAN DULU LABEL
		$totalHarga = 0;
		foreach($sqlLabel->result() as $label){

			if($label->nm_ker == 'MH'){
                $jnsKertas = 'KERTAS MEDIUM';
            }else if($label->nm_ker == 'WP'){
                $jnsKertas = 'KERTAS COKLAT';
            }else if($label->nm_ker == 'BK'){
                $jnsKertas = 'KERTAS B-KRAFT';
            }else if($label->nm_ker == 'MEDIUM LINER'){
                $jnsKertas = 'KERTAS MEDIUM LINER';
            }else if($label->nm_ker == 'MH COLOR'){
                $jnsKertas = 'KERTAS MEDIUM COLOR';
            }else if($label->nm_ker == 'MN'){
                $jnsKertas = 'KERTAS MEDIUM NON SPEK';
            }else{
                $jnsKertas = '';
            }
			$html .= '<tr>
				<td style="border:0;padding:5px 0" colspan="7">'.$jnsKertas.' ROLL '.$label->g_label.' GSM</td>
			</tr>';

			// TAMPILKAN ITEMNYA
			$weightNmLbPo = 0;
			$sqlWidth = $this->db->query("SELECT*FROM invoice_list
			WHERE no_invoice='$label->no_invoice' AND nm_ker='$label->nm_ker' AND g_label='$label->g_label' AND no_po='$label->no_po'
			ORDER BY width ASC");
			foreach($sqlWidth->result() as $items){
                // BERAT SESETAN
                $fixBerat = $items->weight - $items->seset;
				$html .= '<tr>
					<td style="border:0;padding:5px 0">LB '.round($items->width,2).' = '.$items->qty.' ROLL</td>
					<td style="border:0;padding:5px 0;text-align:center">KG</td>
					<td style="border:0;padding:5px 0;text-align:right">'.number_format($fixBerat).'</td>
					<td style="border:0;padding:5px 0" colspan="4"></td>
				</tr>';

				// TOTAL BERAT PER GSM - LABEL - PO
				$weightNmLbPo += $fixBerat;
			}

			// CARI HARGANYA
			$sqlHargaPo = $this->db->query("SELECT*FROM invoice_harga
			WHERE no_invoice='$label->no_invoice' AND nm_ker='$label->nm_ker' AND g_label='$label->g_label' AND no_po='$label->no_po'")->row();
			// PERKALIAN ANTARA TOTAL BERAT DAN HARGA PO
			$weightXPo = round($weightNmLbPo * $sqlHargaPo->harga);
			$html .= '<tr>
				<td style="border:0;padding:5px 0" colspan="2"></td>
				<td style="border-top:1px solid #000;padding:5px 0;text-align:right">'.number_format($weightNmLbPo).'</td>
				<td style="border-top:1px solid #000;padding:5px 0 0 15px">Rp</td>
				<td style="border-top:1px solid #000;padding:5px 0;text-align:right">'.number_format($sqlHargaPo->harga).'</td>
				<td style="border:0;padding:5px 0 0 15px">Rp</td>
				<td style="border:0;padding:5px 0;text-align:right">'.number_format($weightXPo).'</td>
			</tr>';

			$totalHarga += $weightXPo;
		}
        
		
		//////////////////////////////////////////////// T O T A L ////////////////////////////////////////////////
		$html .= '<tr>
			<td style="border:0;padding:20px 0 0" colspan="7"></td>
		</tr>';

        // RUMUS
		if($ppnpph == 1){ // PPN 10 %
			$terbilang = round($totalHarga + (0.1 * $totalHarga));
			$rowspan = 3;
		}else if($ppnpph == 2){ // PPH22
			$terbilang = round($totalHarga + (0.1 * $totalHarga) + (0.01 * $totalHarga));
			$rowspan = 4;
		}else{ // NON
			$terbilang = $totalHarga;
			$rowspan = 2;
		}

		$html .= '<tr>
			<td style="border-width:2px 0;border:1px solid;font-weight:bold;padding:5px 0;line-height:1.8;text-transform:uppercase" colspan="3" rowspan="'.$rowspan.'">Terbilang :<br/><b><i>'.$this->m_fungsi->terbilang($terbilang).'</i></b></td>
			<td style="border-top:2px solid #000;font-weight:bold;padding:5px 0 0 15px" colspan="2">Sub Total</td>
			<td style="border-top:2px solid #000;font-weight:bold;padding:5px 0 0 15px">Rp</td>
			<td style="border-top:2px solid #000;font-weight:bold;padding:5px 0;text-align:right">'.number_format($totalHarga).'</td>
		</tr>';

		// PPN - PPH22
		$ppn10 = 0.1 * $totalHarga;
        $pph22 = 0.01 * $totalHarga;
		$txtppn10 = '<tr>
				<td style="border:0;font-weight:bold;padding:5px 0 0 15px" colspan="2">Ppn 10%</td>
				<td style="border:0;font-weight:bold;padding:5px 0 0 15px">Rp</td>
				<td style="border:0;font-weight:bold;padding:5px 0;text-align:right">'.number_format($ppn10).'</td>
			</tr>';

		if($ppnpph == 1){ // PPN 10 %
			$html .= $txtppn10;
		}else if($ppnpph == 2){ // PPH22
			// pph22
			$html .= $txtppn10.'<tr>
				<td style="border:0;font-weight:bold;padding:5px 0 0 15px" colspan="2">Pph 22</td>
				<td style="border:0;font-weight:bold;padding:5px 0 0 15px">Rp</td>
				<td style="border:0;font-weight:bold;padding:5px 0;text-align:right">'.number_format($pph22).'</td>
			</tr>';
		}else{
			$html .= '';
		}

		$html .= '<tr>
			<td style="border-bottom:2px solid #000;font-weight:bold;padding:5px 0 0 15px" colspan="2">Total</td>
			<td style="border-bottom:2px solid #000;font-weight:bold;padding:5px 0 0 15px">Rp</td>
			<td style="border-bottom:2px solid #000;font-weight:bold;padding:5px 0;text-align:right">'.number_format($terbilang).'</td>
		</tr>';

		//////////////////////////////////////////////// T T D ////////////////////////////////////////////////
		
		$html .= '<tr>
			<td style="border:0;padding:20px 0 0" colspan="7"></td>
		</tr>';

		$html .= '<tr>
			<td style="border:0;padding:5px" colspan="3"></td>
			<td style="border:0;padding:5px;text-align:center" colspan="4">Wonogiri, '.$this->m_fungsi->tanggal_format_indonesia(date('Y-m-d')).'</td>
		</tr>
		<tr>
			<td style="border:0;padding:0 0 15px;line-height:1.8" colspan="3">Pembayaran Full Amount ditransfer ke :<br/>BANK IBK INDONESIA 350 21 000 58 (CABANG SEMARANG)<br/>A.n PT. PRIMA PAPER INDONESIA</td>
			<td style="border:0;padding:0" colspan="4"></td>
		</tr>
		<tr>
			<td style="border:0;padding:0;line-height:1.8" colspan="3">* Harap bukti transfer di email ke</td>
			<td style="border-bottom:1px solid #000;padding:0" colspan="4"></td>
		</tr>
		<tr>
			<td style="border:0;padding:0;line-height:1.8" colspan="3">primapaperin@gmail.com / bethppi@yahoo.co.id</td>
			<td style="border:0;padding:0;line-height:1.8;text-align:center" colspan="4">Finance</td>
		</tr>
		';

        $html .= '</table>';

        $this->m_fungsi->newPDF($html,'P',77,0);

    }

    function print_update_po(){
        $jenis = $_GET['jenis'];
        $ctk = $_GET['ctk'];

        $html = '';

        $warna = 'hitam';

        if($warna == 'hitam'){
            $ink = '#000';
        }else{
            $ink = '#444';
        }

        // ambil kop
        $poMas_kop = $this->db->query("SELECT b.id,b.nm_perusahaan FROM po_master a 
            INNER JOIN m_perusahaan b ON a.id_perusahaan = b.id
            WHERE b.id='$jenis'
            GROUP BY b.id,b.nm_perusahaan")->row();

        $html .= '<table style="margin:0;padding:0;font-size:14px;font-weight:bold;color:'.$ink.';width:100%;border-collapse:collapse">
                    <tr>
                        <td colspan="0" style="border:0">OUTSTANDING PO '.$poMas_kop->nm_perusahaan.'</td>
                    </tr>
                </table>';

        // ambil no po
        // $q_no_po = $this->db->query("SELECT nm_ker,no_po,
        // SUM(a.tonase) AS tns,
        // (SELECT SUM(b.tonase) FROM po_history b WHERE a.nm_ker = b.nm_ker AND b.no_po = a.no_po) AS tot_t_uk,
        // (SUM(a.tonase) - (SELECT SUM(b.tonase) FROM po_history b WHERE a.nm_ker = b.nm_ker AND b.no_po = a.no_po)) AS sisa_t_all
        // FROM po_master a
        // WHERE id_perusahaan='$jenis'
        // GROUP BY no_po,nm_ker");
        $q_no_po = $this->db->query("SELECT nm_ker,g_label,no_po,
        SUM(a.tonase) AS tns,
        (SELECT SUM(b.tonase) FROM po_history b WHERE a.nm_ker = b.nm_ker AND a.g_label = b.g_label AND b.no_po = a.no_po) AS tot_t_uk,
        (SUM(a.tonase) - (SELECT SUM(b.tonase) FROM po_history b WHERE a.nm_ker = b.nm_ker AND b.no_po = a.no_po)) AS sisa_t_all
        FROM po_master a
        WHERE id_perusahaan='$jenis'
        GROUP BY no_po,nm_ker,g_label
        ORDER BY nm_ker ASC,g_label ASC,no_po ASC");

        foreach ($q_no_po->result() as $r) {
            $no_po = $r->no_po;
            $nm_ker = $r->nm_ker;
            $gg_llabel = $r->g_label;
            
            $all_tns = $r->tns;
            $all_tot_t_uk = $r->tot_t_uk;
            $all_sisa_t_all = $r->sisa_t_all;

            if($nm_ker == "MH"){
                $ket_nm_ker = "MEDIUM";
            }else if($nm_ker == "BK"){
                $ket_nm_ker = "B - KRAFT";
            }else if($nm_ker == "WP"){
                $ket_nm_ker = "W.R.P";
            }else{
                $ket_nm_ker = "-";
            }

            $html .= '<table cellspacing="0" cellpadding="5" style="font-size:11px;width:100%;color:'.$ink.';border-collapse:collapse">';

            $html .= '<tr>
                <th style="border:0;height:0px;width:5%"></th>
                <th style="border:0;height:0px;width:7%"></th>
                <th style="border:0;height:0px;width:8%"></th>
                <th style="border:0;height:0px;width:20%"></th>
                <th style="border:0;height:0px;width:10%"></th>
                <th style="border:0;height:0px;width:10%"></th>
                <th style="border:0;height:0px;width:10%"></th>
                <th style="border:0;height:0px;width:10%"></th>
                <th style="border:0;height:0px;width:20%"></th>
            </tr>';

            $html .= '<tr>
                <td colspan="4" style="font-weight:bold;border:1px solid #000;border-width:1px 0 1px 1px">PO NO : '.$no_po.'</td>
                <td style="font-weight:bold;border:1px solid #000;text-align:center">'.$gg_llabel.'</td>
                <td style="font-weight:bold;border:1px solid #000;text-align:center">'.$ket_nm_ker.'</td>
            </tr>';

            $html .= '<tr>
                <td style="border:1px solid #000;text-align:center;font-weight:bold">NO</td>
                <td style="border:1px solid #000;text-align:center;font-weight:bold">GSM</td>
                <td style="border:1px solid #000;text-align:center;font-weight:bold">WIDTH</td>
                <td style="border:1px solid #000;text-align:center;font-weight:bold">TONASE</td>
                <td style="border:1px solid #000;text-align:center;font-weight:bold" colspan="2">SISA TONASE</td>
            </tr>';

            $html .= '<tr>
                <td style="border-left:1px solid #000;text-align:center"></td>
                <td style="border:1px solid #000;text-align:center;font-weight:bold" colspan="2">TANGGAL</td>
                <td style="border:1px solid #000;text-align:center;font-weight:bold">NO SJ</td>
                <td style="border:1px solid #000;text-align:center;font-weight:bold">JML ROLL</td>
                <td style="border:1px solid #000;text-align:center;font-weight:bold">TONASE</td>
            </tr>';

            // ambil no po per ukuran
            $q_no_po_uk = $this->db->query("SELECT a.*,
            (SELECT SUM(tonase) FROM po_history b WHERE nm_ker = a.nm_ker AND g_label = a.g_label AND width = a.width AND no_po = a.no_po) AS h_tonase,
            (a.tonase - (SELECT SUM(tonase) FROM po_history b WHERE nm_ker = a.nm_ker AND g_label = a.g_label AND width = a.width AND no_po = a.no_po)) AS sisa_t_po
            FROM po_master a
            WHERE nm_ker='$nm_ker' AND g_label='$gg_llabel' AND no_po='$no_po'
            ORDER BY g_label,width ASC");

            $i = 1;
            foreach ($q_no_po_uk->result() as $r) {

                if($r->tonase > $r->h_tonase){
                    $txt = '#070'; 
                }else if($r->tonase < $r->h_tonase){
                    $txt = '#700'; 
                }else{
                    $txt = '#000'; 
                }

                $sisaPoPo = $r->tonase - $r->h_tonase;

                $html .= '<tr>
                    <td style="border:1px solid #000;text-align:center">'.$i.'</td>
                    <td style="border:1px solid #000;text-align:center">'.$r->g_label.'</td>
                    <td style="border:1px solid #000;text-align:center">'.round($r->width,2).'</td>
                    <td style="border:1px solid #000;text-align:center;font-weight:bold">'.number_format($r->tonase).'</td>
                    <td colspan="2" style="border:1px solid #000;text-align:center;color:'.$txt.';font-weight:bold">'.number_format($sisaPoPo).'</td>
                </tr>';

                // ambil data po history per ukuran
                $q_no_po_uk_poh = $this->db->query("SELECT a.tgl AS tgl,a.no_surat AS no_surat,a.no_pkb AS no_pkb,a.jml_roll AS jml_roll,a.tonase AS tonase FROM po_history a
                INNER JOIN po_master b ON a.no_po = b.no_po AND a.nm_ker = b.nm_ker AND a.g_label = b.g_label AND a.width = b.width
                WHERE a.nm_ker='$r->nm_ker' AND a.g_label='$r->g_label' AND a.width='$r->width' AND a.no_po='$r->no_po'
                ORDER BY a.tgl,a.no_pkb ASC");

                // if($q_no_po_uk_poh->num_rows() > 0){
                //     $html .= '<tr>
                //         <td style="border-left:1px solid #000;text-align:center"></td>
                //         <td style="border:1px solid #000;text-align:center;font-weight:bold" colspan="2">TANGGAL</td>
                //         <td style="border:1px solid #000;text-align:center;font-weight:bold">NO SJ</td>
                //         <td style="border:1px solid #000;text-align:center;font-weight:bold">JML ROLL</td>
                //         <td style="border:1px solid #000;text-align:center;font-weight:bold">TONASE</td>
                //     </tr>';
                // }

                $tot_ton = 0;
                $tot_roll = 0;
                foreach ($q_no_po_uk_poh->result() as $r) {
                    $html .= '<tr>
                        <td style="border-left:1px solid #000"></td>
                        <td colspan="2" style="border:1px solid #000;text-align:center">'.$this->m_fungsi->tanggal_format_indonesia($r->tgl).'</td>
                        <td style="border:1px solid #000;text-align:center">'.$r->no_surat.'</td>
                        <td style="border:1px solid #000;text-align:center">'.$r->jml_roll.'</td>
                        <td style="border:1px solid #000;text-align:center">'.number_format($r->tonase).'</td>
                    </tr>';

                    $tot_ton += $r->tonase;
                    $tot_roll += $r->jml_roll;
                }

                if($q_no_po_uk_poh->num_rows() > 0){
                    $html .= '<tr>
                        <td style="border-left:1px solid #000;border-bottom:1px solid #000"></td>
                        <td colspan="3" style="border:1px solid #000;text-align:center;font-weight:bold">TOTAL</td>
                        <td style="border:1px solid #000;text-align:center;font-weight:bold">'.number_format($tot_roll).'</td>
                        <td style="border:1px solid #000;text-align:center;font-weight:bold">'.number_format($tot_ton).'</td>
                    </tr>';
                }
                
                
                // $html .= '<tr>
                //         <td colspan="5" style="padding:2px 0;border:1px solid #000"></td>
                //     </tr>';

                $i++;
            }

            // $q_tot_no_po = $q_no_po->row();

            if($all_tns > $all_tot_t_uk){
                $txt = '#070';
            }else if($all_tns < $all_tot_t_uk){
                $txt = '#700';
            }else{
                $txt = '#000';
            }

            $html .= '<tr>
                <td colspan="4" style="border:1px solid #000">TOTAL KESELURUHAN TONASE PO</td>
                <td colspan="2" style="border:1px solid #000;text-align:right;font-weight:bold">'.number_format($all_tns).'</td>
            </tr>';

            $html .= '<tr>
                <td colspan="4" style="border:1px solid #000">TOTAL KESELURUHAN TONASE PER UKURAN</td>
                <td colspan="2" style="border:1px solid #000;text-align:right;color:'.$txt.';font-weight:bold">'.number_format($all_tot_t_uk).'</td>
            </tr>';

            $html .= '<tr>
                <td colspan="4" style="border:1px solid #000">TOTAL KESELURUHAN SISA TONASE</td>
                <td colspan="2" style="border:1px solid #000;text-align:right;color:'.$txt.';font-weight:bold">'.number_format($all_sisa_t_all).'</td>
            </tr>';

            $html .= '</table>';
            $html .= '<div style="page-break-after:always"></div>';
        }

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // opsi cetak
        if ($ctk == '0') {
            // pdf
            $this->m_fungsi->_mpdf('',$html,10,10,10,'P');
        }else{
            // excel
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=name.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $data2['prev']= $html;
            $this->load->view('view_excel', $data2);
        }
    }

    function print_penjualan_roll(){
        $jenis = $_GET['jenis'];
        $ctk = $_GET['ctk'];

        $html = '';

        // KOP
        $html .= '<table style="margin:0;padding:0;font-size:14px;font-weight:bold;color:#000;width:100%;border-collapse:collapse">
            <tr>
                <td colspan="7" style="border:0">UPDATE PENJUALAN ROLL</td>
            </tr>
        </table>';

        $date = date('Y-m-d');
        // ambil no po
        $sql_po = $this->db->query("
            SELECT COUNT(*),b.no_po FROM m_timbangan a
            INNER JOIN pl b ON a.id_pl = b.id
            WHERE b.id_perusahaan='6'
            AND b.tgl BETWEEN '2020-04-01' AND '$date'
            GROUP BY b.no_po ASC");

        foreach($sql_po->result() as $r){
            $html .= '<table cellspacing="0" cellpadding="5" style="font-size:11px;width:100%;color:#000;text-align:center;border-collapse:collapse" >
                <tr>
                    <th style="border:1px solid #000;padding:5px;width:50%"></th>
                    <th style="border:1px solid #000;padding:5px;width:50%"></th>
                </tr>
            </table>';            
        }



        // opsi cetak
        if ($ctk == '0') {
            // pdf
            $this->m_fungsi->_mpdf('',$html,10,10,10,'P');
        }else{
            // excel
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=name.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $data2['prev']= $html;
            $this->load->view('view_excel', $data2);
        }
    }

    function print_stok_gudang() {
        $jenis = $_GET['jenis'];
        $jenis_ker = $_GET['jenis_ker'];
        $ctk = $_GET['ctk'];

        $html = '';

        $html .= '<style>
            .str {
                mso-number-format:\@;
            }
        </style>';

        $warna = 'hitam';

        if($warna == 'hitam'){
            $ink = '#000';
        }else{
            $ink = '#444';
        }

        if($jenis == 'ALL' && $ctk == 0){

            if($jenis_ker == 'MH'){
                $where = "(nm_ker='MH' OR nm_ker='MI')";
            }else if($jenis_ker == 'BK'){
                $where = "(nm_ker='BK' OR nm_ker='BL')";
            }

            // cetak semuanya pdf
            $q_uk = $this->db->query("SELECT width FROM m_timbangan WHERE $where AND status='0'
                GROUP BY width
                ORDER BY width ASC");

            foreach ($q_uk->result() as $r ) {
                
                $dw = $r->width;

                $html .= '<table style="margin:0;padding:0;font-size:14px;font-weight:bold;color:'.$ink.';width:100%;border-collapse:collapse">
                    <tr>
                        <td colspan="7" style="border:0">UPDATE SPESIFIKASI FINISH GOOD - UPDATE TERBARU ( '.round($dw).' )</td>
                    </tr>
                </table>';

                $html .= '<table cellspacing="0" cellpadding="5" style="font-size:11px;width:100%;color:'.$ink.';text-align:center;border-collapse:collapse" >
                        <tr>
                            <th style="padding:5px 0;width:6%"></th>
                            <th style="padding:5px 0;width:16%"></th>
                            <th style="padding:5px 0;width:13%"></th>
                            <th style="padding:5px 0;width:15%"></th>
                            <th style="padding:5px 0;width:15%"></th>
                            <th style="padding:5px 0;width:14%"></th>
                            <th style="padding:5px 0;width:14%"></th>
                            <th style="padding:5px 0;width:7%"></th>
                        </tr>';

                $html .= '<tr>
                        <td style="border:1px solid '.$ink.'">No</td>
                        <td style="border:1px solid '.$ink.'">ROLL NUMBER</td>
                        <td style="border:1px solid '.$ink.'">JENIS KERTAS</td>
                        <td style="border:1px solid '.$ink.'">GRAMAGE (GSM)</td>
                        <td style="border:1px solid '.$ink.'">LEBAR (CM)</td>
                        <td style="border:1px solid '.$ink.'">DIAMETER</td>
                        <td style="border:1px solid '.$ink.'">BERAT (KG)</td>
                        <td style="border:1px solid '.$ink.'">JOINT</td>
                    </tr>';

                // ambil data
                $data_detail_all = $this->db->query("SELECT*FROM m_timbangan WHERE width='$dw' AND $where AND status='0' ORDER BY g_label ASC, roll ASC");

                $no = 1;
                foreach ($data_detail_all->result() as $r ) {
                    $html .= '<tr>
                                <td style="border:1px solid '.$ink.'">'.$no.'</td>
                                <td style="border:1px solid '.$ink.'">'.$r->roll.'</td>
                                <td style="border:1px solid '.$ink.'">'.$r->nm_ker.'</td>
                                <td class="str" style="border:1px solid '.$ink.'">'.$r->g_label.'</td>
                                <td class="str" style="border:1px solid '.$ink.'">'.round($r->width,2).'</td>
                                <td class="str" style="border:1px solid '.$ink.'">'.$r->diameter.'</td>
                                <td style="border:1px solid '.$ink.'">'.$r->weight.'</td>
                                <td class="str" style="border:1px solid '.$ink.'">'.$r->joint.'</td>
                            </tr>';
                    $no++;
                }

                $html .= '</table>';
                $html .= '<div style="page-break-after:always"></div>';
            }

        }else if($jenis == 'ALL' && $ctk == 1){

            // cetak semuanya excel

                $html .= '<table style="margin:0;padding:0;font-size:14px;font-weight:bold;color:'.$ink.';width:100%;border-collapse:collapse">
                    <tr>
                        <td colspan="7" style="border:0">UPDATE SPESIFIKASI FINISH GOOD - UPDATE TERBARU ALL</td>
                    </tr>
                </table>';

                $html .= '<table cellspacing="0" cellpadding="5" style="font-size:11px;width:100%;color:'.$ink.';text-align:center;border-collapse:collapse" >
                        <tr>
                            <th style="padding:5px 0;width:6%"></th>
                            <th style="padding:5px 0;width:16%"></th>
                            <th style="padding:5px 0;width:13%"></th>
                            <th style="padding:5px 0;width:15%"></th>
                            <th style="padding:5px 0;width:15%"></th>
                            <th style="padding:5px 0;width:14%"></th>
                            <th style="padding:5px 0;width:14%"></th>
                            <th style="padding:5px 0;width:7%"></th>
                        </tr>';

                $html .= '<tr>
                        <td style="border:1px solid '.$ink.'">No</td>
                        <td style="border:1px solid '.$ink.'">ROLL NUMBER</td>
                        <td style="border:1px solid '.$ink.'">JENIS KERTAS</td>
                        <td style="border:1px solid '.$ink.'">GRAMAGE (GSM)</td>
                        <td style="border:1px solid '.$ink.'">LEBAR (CM)</td>
                        <td style="border:1px solid '.$ink.'">DIAMETER</td>
                        <td style="border:1px solid '.$ink.'">BERAT (KG)</td>
                        <td style="border:1px solid '.$ink.'">JOINT</td>
                    </tr>';
                // PILIH JENIS KERTAS
                if($jenis_ker == 'MH'){
                    $where = "(nm_ker='MH' OR nm_ker='MI')";
                }else if($jenis_ker == 'BK'){
                    $where = "(nm_ker='BK' OR nm_ker='BL')";
                }

                // ambil data
                $data_detail_all = $this->db->query("SELECT*FROM m_timbangan WHERE $where AND status='0' ORDER BY roll ASC");

                $no = 1;
                $sum_weight = 0;
                foreach ($data_detail_all->result() as $r ) {
                    $html .= '<tr>
                                <td style="border:1px solid '.$ink.'">'.$no.'</td>
                                <td style="border:1px solid '.$ink.'">'.$r->roll.'</td>
                                <td style="border:1px solid '.$ink.'">'.$r->nm_ker.'</td>
                                <td class="str" style="border:1px solid '.$ink.'">'.$r->g_label.'</td>
                                <td class="str" style="border:1px solid '.$ink.'">'.round($r->width,2).'</td>
                                <td class="str" style="border:1px solid '.$ink.'">'.$r->diameter.'</td>
                                <td style="border:1px solid '.$ink.'">'.$r->weight.'</td>
                                <td class="str" style="border:1px solid '.$ink.'">'.$r->joint.'</td>
                            </tr>';
                    $no++;
                    $sum_weight += $r->weight;
                }

                $html .= '<tr>
                    <td style="border:1px solid #000" colspan="6" >TOTAL</td>
                    <td style="border:1px solid #000">'.$sum_weight.'</td>
                    <td style="border:1px solid #000"></td>
                </tr>';

                $html .= '</table>';

        }else if($jenis == 'ALL_REKAP'){
            // SEMUA GSM
            $html = '';

            $html .= '<table style="margin:0;padding:0;font-size:14px;font-weight:bold;color:'.$ink.';width:100%;border-collapse:collapse">
                <tr>
                    <td colspan="3" style="border:0">REKAP UPDATE SPESIFIKASI FINISH GOOD - UPDATE TERBARU ALL</td>
                </tr>
            </table>';
            
            $html .= '<table cellspacing="0" cellpadding="5" style="font-size:11px;width:100%;color:'.$ink.';text-align:center;border-collapse:collapse" >';

            $html .= '<tr>
                <th style="border:0;padding:5px 0;width:4%"></th>
                <th style="border:0;padding:5px 0;width:12%"></th>
                <th style="border:0;padding:5px 0;width:12%"></th>
                <th style="border:0;padding:5px 0;width:14%"></th>
                <th style="border:0;padding:5px 0;width:12%"></th>
                <th style="border:0;padding:5px 0;width:14%"></th>
                <th style="border:0;padding:5px 0;width:12%"></th>
                <th style="border:0;padding:5px 0;width:16%"></th>
            </tr>';

            // PILIH JENIS KERTAS
            if($jenis_ker == 'MH'){
                $title1 = "MH";
                $title2 = "MI";
                $nm_ker1 = "nm_ker='MH'";
                $nm_ker2 = "nm_ker='MI'";
                $where = "(nm_ker='MH' OR nm_ker='MI')";
            }else if($jenis_ker == 'BK'){
                $title1 = "BK";
                $title2 = "BL";
                $nm_ker1 = "nm_ker='BK'";
                $nm_ker2 = "nm_ker='BL'";
                $where = "(nm_ker='BK' OR nm_ker='BL')";
            }

            $html .= '<tr>
                <td style="font-weight:bold;border:1px solid #000">NO</td>
                <td style="font-weight:bold;border:1px solid #000">WIDTH</td>
                <td style="font-weight:bold;border:1px solid #000">'.$title1.'</td>
                <td style="font-weight:bold;border:1px solid #000">TOTAL '.$title1.'</td>
                <td style="font-weight:bold;border:1px solid #000">'.$title2.'</td>
                <td style="font-weight:bold;border:1px solid #000">TOTAL '.$title2.'</td>
                <td style="font-weight:bold;border:1px solid #000">TOTAL ROLL</td>
                <td style="font-weight:bold;border:1px solid #000">TOTAL BERAT</td>
            </tr>';

            // ambil data
            $sql_rekap = $this->db->query("SELECT width,
                g_label AS gsm,
                (SELECT COUNT(*) FROM m_timbangan WHERE width = a.width  AND $nm_ker1 AND status='0') AS mh_jml,
                (SELECT SUM(weight) FROM m_timbangan WHERE width = a.width  AND $nm_ker1 AND status='0') AS mh_tot,
                (SELECT COUNT(*) FROM m_timbangan WHERE width = a.width  AND $nm_ker2 AND status='0') AS mi_jml,
                (SELECT SUM(weight) FROM m_timbangan WHERE width = a.width  AND $nm_ker2 AND status='0') AS mi_tot,
                COUNT(*) AS all_jml,
                SUM(weight) AS all_total
                FROM m_timbangan a WHERE $where AND status='0'
                GROUP BY width");

            $no = 1;
            $ton_mh_jml = 0;
            $ton_mh_tot = 0;
            $ton_mi_jml = 0;
            $ton_mi_tot = 0;
            $ton_jml = 0;
            $ton_tot = 0;
            foreach ($sql_rekap->result() as $r ) {
                $html .= '<tr>
                            <td style="border:1px solid '.$ink.'">'.$no.'</td>
                            <td style="border:1px solid '.$ink.'">'.round($r->width).'</td>
                            <td style="border:1px solid '.$ink.'">'.$r->mh_jml.'</td>
                            <td style="border:1px solid '.$ink.';text-align:right">'.number_format($r->mh_tot).'</td>
                            <td style="border:1px solid '.$ink.'">'.$r->mi_jml.'</td>
                            <td style="border:1px solid '.$ink.';text-align:right">'.number_format($r->mi_tot).'</td>
                            <td style="border:1px solid '.$ink.'">'.$r->all_jml.'</td>
                            <td style="border:1px solid '.$ink.';text-align:right">'.number_format($r->all_total).'</td>
                        </tr>';
                $no++;
                $ton_mh_jml += $r->mh_jml;
                $ton_mh_tot += $r->mh_tot;
                $ton_mi_jml += $r->mi_jml;
                $ton_mi_tot += $r->mi_tot;
                $ton_jml    += $r->all_jml;
                $ton_tot    += $r->all_total;
            }

            $html .= '<tr>
                <td style="font-weight:bold;border:1px solid #000" colspan="2">TOTAL</td>
                <td style="font-weight:bold;border:1px solid #000">'.number_format($ton_mh_jml).'</td>
                <td style="font-weight:bold;border:1px solid #000">'.number_format($ton_mh_tot).'</td>
                <td style="font-weight:bold;border:1px solid #000">'.number_format($ton_mi_jml).'</td>
                <td style="font-weight:bold;border:1px solid #000">'.number_format($ton_mi_tot).'</td>
                <td style="font-weight:bold;border:1px solid #000">'.number_format($ton_jml).'</td>
                <td style="font-weight:bold;border:1px solid #000">'.number_format($ton_tot).'</td>
            </tr>';

            $html .= '</table>';

        }else if($jenis == 'ALL_REKAP_GSM'){
            // PER GSM
            $html = '';

            // PILIH JENIS KERTAS
            if($jenis_ker == 'MH'){
                $title1 = "MH";
                $title2 = "MI";
                $nm_ker1 = "nm_ker='MH'";
                $nm_ker2 = "nm_ker='MI'";
                $where = "(nm_ker='MH' OR nm_ker='MI')";
                $texte = "";
            }else if($jenis_ker == 'BK'){
                $title1 = "BK";
                $title2 = "BL";
                $nm_ker1 = "nm_ker='BK'";
                $nm_ker2 = "nm_ker='BL'";
                $where = "(nm_ker='BK' OR nm_ker='BL')";
                $texte = "";
            }else if($jenis_ker == 'WP'){
                $title1 = "WP";
                $where = "(nm_ker='WP' OR nm_ker='wp')";
                $texte = '<br/>PER TANGGAL 1 NOVEMBER 2020 - '.strtoupper($this->m_fungsi->tanggal_format_indonesia(date('Y-m-d')));
            }

            // ambil data per gsm
            $sql_rekap_gsm = $this->db->query("SELECT g_label FROM m_timbangan WHERE $where GROUP BY g_label ORDER BY g_label ASC")->result();

            foreach ($sql_rekap_gsm as $r) {
                $gsm = $r->g_label;

                $html .= '<table style="margin:0;padding:0;font-size:14px;font-weight:bold;color:'.$ink.';width:100%;border-collapse:collapse">
                    <tr>
                        <td colspan="3" style="border:0">REKAP UPDATE SPESIFIKASI FINISH GOOD '.$title1.' - UPDATE TERBARU PER GSM ( '.$gsm.' ) '.$texte.'</td>
                    </tr>
                </table>';
                
                $html .= '<table cellspacing="0" cellpadding="5" style="font-size:11px;width:100%;color:'.$ink.';text-align:center;border-collapse:collapse" >';

                $html .= '<tr>
                    <th style="border:0;padding:5px 0;width:7%"></th>
                    <th style="border:0;padding:5px 0;width:10%"></th>
                    <th style="border:0;padding:5px 0;width:10%"></th>
                    <th style="border:0;padding:5px 0;width:10%"></th>
                    <th style="border:0;padding:5px 0;width:13%"></th>
                    <th style="border:0;padding:5px 0;width:10%"></th>
                    <th style="border:0;padding:5px 0;width:13%"></th>
                    <th style="border:0;padding:5px 0;width:11%"></th>
                    <th style="border:0;padding:5px 0;width:15%"></th>
                </tr>';

                $html .= '<tr>
                    <td style="font-weight:bold;border:1px solid #000">NO</td>
                    <td style="font-weight:bold;border:1px solid #000">WIDTH</td>
                    <td style="font-weight:bold;border:1px solid #000">GSM</td>';

                if($jenis_ker == 'MH' || $jenis_ker == 'BK'){
                    $html .='
                        <td style="font-weight:bold;border:1px solid #000">'.$title1.'</td>
                        <td style="font-weight:bold;border:1px solid #000">TOTAL '.$title1.'</td>
                        <td style="font-weight:bold;border:1px solid #000">'.$title2.'</td>
                        <td style="font-weight:bold;border:1px solid #000">TOTAL '.$title2.'</td>
                        <td style="font-weight:bold;border:1px solid #000">TOTAL ROLL</td>
                        <td style="font-weight:bold;border:1px solid #000">TOTAL BERAT</td>';
                }else if($jenis_ker == 'WP'){
                    $html .='
                        <td style="font-weight:bold;border:1px solid #000" colspan="2">'.$title1.'</td>
                        <td style="font-weight:bold;border:1px solid #000" colspan="4">TOTAL BERAT</td>';
                }
                $html .='</tr>';

                // AMBIL DATA
                if($jenis_ker == 'MH' || $jenis_ker == 'BK'){
                    $isi_query = "SELECT width,
                    g_label AS gsm,
                    (SELECT COUNT(*) FROM m_timbangan WHERE width = a.width AND g_label = a.g_label AND $nm_ker1 AND status='0') AS mh_jml,
                    (SELECT SUM(weight) FROM m_timbangan WHERE width = a.width AND g_label = a.g_label AND $nm_ker1 AND status='0') AS mh_tot,
                    (SELECT COUNT(*) FROM m_timbangan WHERE width = a.width AND g_label = a.g_label AND $nm_ker2 AND status='0') AS mi_jml,
                    (SELECT SUM(weight) FROM m_timbangan WHERE width = a.width AND g_label = a.g_label AND $nm_ker2 AND status='0') AS mi_tot,
                    COUNT(*) AS all_jml,
                    SUM(weight) AS all_total
                    FROM m_timbangan a WHERE $where AND status='0' AND g_label='$gsm'
                    GROUP BY width";
                }else if($jenis_ker == 'WP'){
                    $datewp = date('Y-m-d');

                    $isi_query = "SELECT width,g_label AS gsm,
                    (SELECT COUNT(*) FROM m_timbangan WHERE width = a.width AND g_label = a.g_label AND nm_ker='WP' AND status='0' AND tgl BETWEEN '2020-11-01' AND '$datewp') AS jml,
                    SUM(weight) AS all_total
                    FROM m_timbangan a WHERE (nm_ker='WP' OR nm_ker='wp') AND status='0' AND tgl BETWEEN '2020-11-01' AND '$datewp' AND g_label='$gsm'
                    GROUP BY width";
                }
                $sql_rekap = $this->db->query($isi_query);

                // ISI
                $no = 1;
                $ton_mh_jml = 0;
                $ton_mh_tot = 0;
                $ton_mi_jml = 0;
                $ton_mi_tot = 0;
                $ton_jml = 0;
                $ton_tot = 0;
                foreach ($sql_rekap->result() as $r ) {
                    if($jenis_ker == 'MH' || $jenis_ker == 'BK'){
                        $html .= '<tr>
                                <td style="border:1px solid '.$ink.'">'.$no.'</td>
                                <td style="border:1px solid '.$ink.'">'.round($r->width).'</td>
                                <td style="border:1px solid '.$ink.'">'.$gsm.'</td>
                                <td style="border:1px solid '.$ink.'">'.$r->mh_jml.'</td>
                                <td style="border:1px solid '.$ink.';text-align:right">'.number_format($r->mh_tot).'</td>
                                <td style="border:1px solid '.$ink.'">'.$r->mi_jml.'</td>
                                <td style="border:1px solid '.$ink.';text-align:right">'.number_format($r->mi_tot).'</td>
                                <td style="border:1px solid '.$ink.'">'.$r->all_jml.'</td>
                                <td style="border:1px solid '.$ink.';text-align:right">'.number_format($r->all_total).'</td>
                            </tr>';

                        $ton_mh_jml += $r->mh_jml;
                        $ton_mh_tot += $r->mh_tot;
                        $ton_mi_jml += $r->mi_jml;
                        $ton_mi_tot += $r->mi_tot;
                        $ton_jml    += $r->all_jml;

                    }else if($jenis_ker == 'WP'){
                        $html .= '<tr>
                                <td style="border:1px solid '.$ink.'">'.$no.'</td>
                                <td style="border:1px solid '.$ink.'">'.round($r->width).'</td>
                                <td style="border:1px solid '.$ink.'">'.$gsm.'</td>
                                <td style="border:1px solid '.$ink.'" colspan="2">'.$r->jml.'</td>
                                <td style="border:1px solid '.$ink.';text-align:right" colspan="4">'.number_format($r->all_total).'</td>
                            </tr>';

                        $ton_jml    += $r->jml;
                    }
                    
                    $no++;
                    
                    $ton_tot    += $r->all_total;
                }

                // TOTAL
                if($jenis_ker == 'MH' || $jenis_ker == 'BK'){
                    $html .= '<tr>
                        <td style="font-weight:bold;border:1px solid #000" colspan="3">TOTAL</td>
                        <td style="font-weight:bold;border:1px solid #000">'.number_format($ton_mh_jml).'</td>
                        <td style="font-weight:bold;border:1px solid #000">'.number_format($ton_mh_tot).'</td>
                        <td style="font-weight:bold;border:1px solid #000">'.number_format($ton_mi_jml).'</td>
                        <td style="font-weight:bold;border:1px solid #000">'.number_format($ton_mi_tot).'</td>
                        <td style="font-weight:bold;border:1px solid #000">'.number_format($ton_jml).'</td>
                        <td style="font-weight:bold;border:1px solid #000">'.number_format($ton_tot).'</td>
                    </tr>';
                }else if($jenis_ker == 'WP'){
                    $html .= '<tr>
                        <td style="font-weight:bold;border:1px solid #000" colspan="3">TOTAL</td>
                        <td style="font-weight:bold;border:1px solid #000" colspan="2">'.number_format($ton_jml).'</td>
                        <td style="font-weight:bold;border:1px solid #000" colspan="4">'.number_format($ton_tot).'</td>
                    </tr>';
                }

                

                $html .= '</table>';

                $html .= '<div style="page-break-after:always"></div>';

            // pertama
            }

        }else{

            // cetak per ukuran pdf

            $sql_uk_all = $this->db->query("SELECT COUNT(*) AS totalluk FROM m_timbangan WHERE (nm_ker='MH' OR nm_ker='MI') AND status='0' AND width='$jenis'")->row();

            $html .= '<table style="margin:0;padding:0;text-align:center;font-size:14px;color:'.$ink.';font-weight:bold;width:100%;border-collapse:collapse">
                <tr>
                    <td colspan="8" style="border:0">UPDATE SPESIFIKASI FINISH GOOD - UPDATE TERBARU UK '.round($jenis).' ( '.$sql_uk_all->totalluk.' )</td>
                </tr>
            </table>';

            // PILIH JENIS KERTAS
            if($jenis_ker == 'MH'){
                $title1 = "MH";
                $title2 = "MI";
                $nm_ker1 = "nm_ker='MH'";
                $nm_ker2 = "nm_ker='MI'";
                $where = "(nm_ker='MH' OR nm_ker='MI')";
            }else if($jenis_ker == 'BK'){
                $title1 = "BK";
                $title2 = "BL";
                $nm_ker1 = "nm_ker='BK'";
                $nm_ker2 = "nm_ker='BL'";
                $where = "(nm_ker='BK' OR nm_ker='BL')";
            }

            // query gsm
            $sql_gsm =  $this->db->query("SELECT g_label, COUNT(g_label) AS totgsm FROM m_timbangan WHERE width='$jenis' AND status='0' AND $where GROUP BY g_label ORDER BY g_label ASC")->result();

            foreach($sql_gsm as $data){

                $html .= '<table cellpadding="5" style="margin:10px 0;padding:0;font-size:11px;color:'.$ink.';text-align:center;width:100%;border-collapse:collapse">
                <tr>
                    <th style="padding:0;width:6%"></th>
                    <th style="padding:0;width:16%"></th>
                    <th style="padding:0;width:13%"></th>
                    <th style="padding:0;width:15%"></th>
                    <th style="padding:0;width:15%"></th>
                    <th style="padding:0;width:14%"></th>
                    <th style="padding:0;width:14%"></th>
                    <th style="padding:0;width:7%"></th>
                </tr>';

                // tampil gsm
                $html .= '<tr>
                    <td colspan="8" style="border:0;font-weight:bold">GSM '.$data->g_label.' ( '.$data->totgsm.' )</td>
                </tr>';

                $gsm_glabel = $data->g_label;
                
                // MH
                $sql_ker_mh = $this->db->query("SELECT nm_ker, COUNT(nm_ker) AS totker FROM m_timbangan WHERE width='$jenis' AND g_label='$gsm_glabel' AND status='0' AND nm_ker='$title1' GROUP BY nm_ker ORDER BY nm_ker ASC")->result();

                foreach($sql_ker_mh as $data){
                    $html .= '<tr>
                        <td colspan="8" style="border:0;font-weight:bold">GSM '.$gsm_glabel.' - '.$data->nm_ker.' ( '.$data->totker.' )</td>
                    </tr>';

                    // kop
                    $html .= '<tr>
                            <td style="border:1px solid '.$ink.'">No</td>
                            <td style="border:1px solid '.$ink.'">ROLL NUMBER</td>
                            <td style="border:1px solid '.$ink.'">JENIS KERTAS</td>
                            <td style="border:1px solid '.$ink.'">GRAMAGE (GSM)</td>
                            <td style="border:1px solid '.$ink.'">LEBAR (CM)</td>
                            <td style="border:1px solid '.$ink.'">DIAMETER</td>
                            <td style="border:1px solid '.$ink.'">BERAT (KG)</td>
                            <td style="border:1px solid '.$ink.'">JOINT</td>
                        </tr>';

                    $mh = $data->nm_ker;
                    $sql_roll_mh = $this->db->query("SELECT*FROM m_timbangan WHERE width='$jenis' AND g_label='$gsm_glabel' AND status='0' AND nm_ker='$mh' ORDER BY roll ASC")->result();

                    $no = 1;
                    foreach ($sql_roll_mh as $r ) {
                        $html .= '<tr>
                                    <td style="border:1px solid '.$ink.'">'.$no.'</td>
                                    <td style="border:1px solid '.$ink.'">'.$r->roll.'</td>
                                    <td style="border:1px solid '.$ink.'">'.$r->nm_ker.'</td>
                                    <td class="str" style="border:1px solid '.$ink.'">'.$r->g_label.'</td>
                                    <td class="str" style="border:1px solid '.$ink.'">'.round($r->width,2).'</td>
                                    <td class="str" style="border:1px solid '.$ink.'">'.$r->diameter.'</td>
                                    <td style="border:1px solid '.$ink.'">'.$r->weight.'</td>
                                    <td class="str" style="border:1px solid '.$ink.'">'.$r->joint.'</td>
                                </tr>';
                        $no++;
                    }
                }

                // MI
                $sql_ker_mi = $this->db->query("SELECT nm_ker, COUNT(nm_ker) AS totker FROM m_timbangan WHERE width='$jenis' AND g_label='$gsm_glabel' AND status='0' AND nm_ker='$title2' GROUP BY nm_ker ORDER BY nm_ker ASC")->result();

                foreach($sql_ker_mi as $data){
                    $html .= '<tr>
                        <td colspan="8" style="border:0;font-weight:bold">GSM '.$gsm_glabel.' - '.$data->nm_ker.' ( '.$data->totker.' )</td>
                    </tr>';

                    // kop
                    $html .= '<tr>
                            <td style="border:1px solid '.$ink.'">No</td>
                            <td style="border:1px solid '.$ink.'">ROLL NUMBER</td>
                            <td style="border:1px solid '.$ink.'">JENIS KERTAS</td>
                            <td style="border:1px solid '.$ink.'">GRAMAGE (GSM)</td>
                            <td style="border:1px solid '.$ink.'">LEBAR (CM)</td>
                            <td style="border:1px solid '.$ink.'">DIAMETER</td>
                            <td style="border:1px solid '.$ink.'">BERAT (KG)</td>
                            <td style="border:1px solid '.$ink.'">JOINT</td>
                        </tr>';

                    $mi = $data->nm_ker;
                    $sql_roll_mi = $this->db->query("SELECT*FROM m_timbangan WHERE width='$jenis' AND g_label='$gsm_glabel' AND status='0' AND nm_ker='$mi' ORDER BY roll ASC")->result();

                    $no = 1;
                    foreach ($sql_roll_mi as $r ) {
                        $html .= '<tr>
                                    <td style="border:1px solid '.$ink.'">'.$no.'</td>
                                    <td style="border:1px solid '.$ink.'">'.$r->roll.'</td>
                                    <td style="border:1px solid '.$ink.'">'.$r->nm_ker.'</td>
                                    <td class="str" style="border:1px solid '.$ink.'">'.$r->g_label.'</td>
                                    <td class="str" style="border:1px solid '.$ink.'">'.round($r->width,2).'</td>
                                    <td class="str" style="border:1px solid '.$ink.'">'.$r->diameter.'</td>
                                    <td style="border:1px solid '.$ink.'">'.$r->weight.'</td>
                                    <td class="str" style="border:1px solid '.$ink.'">'.$r->joint.'</td>
                                </tr>';
                        $no++;
                    }
                }

            $html .= '</table>';

            }


        }

        // judul
        if($jenis == 'ALL'){
            $jdl = 'UPDATE SPESIFIKASI FINISH GOOD - UPDATE TERBARU SEMUA UKURAN';
        }else if($jenis <> 'ALL'){
            $jdl = 'UPDATE SPESIFIKASI FINISH GOOD - UPDATE TERBARU ( '.round($jenis,2).' )';
        }

        // opsi cetak
        if ($ctk == '0') {
            // pdf
            $this->m_fungsi->_mpdf('',$html,10,10,10,'P');
        }else{
            // excel
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=$jdl.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $data2['prev']= $html;
            $this->load->view('view_excel', $data2);
        }

    }

    function penjualanDetail() {
		// $tahun = $_GET['tahun'];
        // $bulan = $_GET['bulan'];
        $tgl1 = $_GET['tgl1'];
        $tgl2 = $_GET['tgl2'];
        $jenis = $_GET['jenis'];
        $ctk = $_GET['ctk'];

        $html = '';
		$html .= '<style>.str{mso-number-format:\@}</style>';

        $html .= '<table cellspacing="0" style="font-size:12px;color:#000;border-collapse:collapse;vertical-align:top;width:100%">
            <tr>
                <th style="padding:0;width:3%"></th>
                <th style="padding:0;width:6%"></th>
                <th style="padding:0;width:4%"></th>
                <th style="padding:0;width:25%"></th>
                <th style="padding:0;width:7%"></th>
                <th style="padding:0;width:17%"></th>
                <th style="padding:0;width:25%"></th>
                <th style="padding:0;width:5%"></th>
                <th style="padding:0;width:8%"></th>
            </tr>';
        // $html .= '<tr>
        //     <td style="padding:0 0 5px;text-align:center;font-weight:bold" colspan="10">PENJUALAN HARIAN</td>
        // </tr>
        // <tr>
        //     <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">NO</td>
        //     <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">HARI</td>
        //     <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">TGL</td>
        //     <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">PELANGGAN</td>
        //     <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">NO SJ</td>
        //     <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">JML</td>
        //     <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">BERAT</td>
        //     <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold"><u>GSM</u> / UKURAN</td>
        //     <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">HARGA</td> 10%
        //     <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">TOTAL</td> 11%
        // </tr>';
		if($ctk != 1 ){ // KOP HILANG DI PDF
			$html .= '<tr>
				<td style="padding:0 0 5px;text-align:center;font-weight:bold" colspan="9">REKAP KIRIMAN ROLL PAPER</td>
			</tr>
			<tr>
				<td style="padding:0 0 5px;text-align:center;font-weight:bold;text-transform:uppercase" colspan="9">'.$this->m_fungsi->tanggal_format_indonesia($tgl1).' - '.$this->m_fungsi->tanggal_format_indonesia($tgl2).'</td>
			</tr>
			<tr>
				<td style="padding:5px" colspan="8"></td>
			</tr>
			<tr>
				<td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">NO</td>
				<td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">HARI</td>
				<td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">TGL</td>
				<td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">PELANGGAN</td>
				<td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">NO SJ</td>
				<td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">NO PO</td>
				<td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold"><u>GSM</u> / UKURAN(JML ROLL)</td>
				<td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">JML</td>
				<td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">BERAT</td>
			</tr>';
		}

        // AMBIL BULAN
        // $getBulanKop = $this->db->query("SELECT DISTINCT SUBSTRING(b.tgl, 1, 7) AS ambil_bulan FROM m_timbangan a
        // INNER JOIN pl b ON a.id_pl=b.id
        // WHERE b.tgl LIKE '%$tahun-$bulan%'
        // GROUP BY b.tgl
        // ORDER BY b.tgl");

        // TAMPIL DATA BULAN
        // foreach($getBulanKop->result() as $r){
            // $html .= '<tr>
            //     <td style="border:1px solid #000;background:#ddd;padding:5px;text-transform:uppercase;font-weight:bold" colspan="8">'.$this->m_fungsi->fgGetBulan($r->ambil_bulan).'</td>
            // </tr>';

            // JENIS
            if($jenis == 'ALL'){
                $where = "";
            }else if($jenis == 'MH'){
                $where = "AND (a.nm_ker = 'MH' OR a.nm_ker = 'MN')";
            }else if($jenis == 'WP'){
                $where = "AND a.nm_ker = 'WP'";
            }else if($jenis == 'BK'){
                $where = "AND a.nm_ker = 'BK'";
            }else if($jenis == 'MHBK'){
                $where = "AND (a.nm_ker = 'MH' OR a.nm_ker = 'MN' OR a.nm_ker = 'BK')";
            }else{
                $where = "";
            }

            // AMBIL DATA PER BULAN
            // $getIsiPerBulan = $this->db->query("SELECT DISTINCT b.tgl,a.nm_ker,b.nama,b.id_perusahaan AS id_pt,b.nm_perusahaan,COUNT(*) AS jumlah,SUM(a.weight) AS berat,b.no_pkb,b.no_po FROM m_timbangan a
            // INNER JOIN pl b ON a.id_pl=b.id
            // WHERE b.tgl LIKE '%$r->ambil_bulan%'
            // AND b.nm_perusahaan!='LAMINASI PPI' AND b.nm_perusahaan!='CORRUGATED PPI'
            // $where
            // GROUP BY b.tgl,b.no_pkb
            // ORDER BY b.tgl ASC,a.nm_ker ASC,b.no_pkb ASC");
            $getIsiPerBulan = $this->db->query("SELECT DISTINCT b.tgl,a.nm_ker,b.nama,b.id_perusahaan AS id_pt,b.nm_perusahaan,COUNT(*) AS jumlah,SUM(a.weight) AS berat,SUM(a.seset) AS seset,b.no_pkb,b.no_po FROM m_timbangan a
			INNER JOIN pl b ON a.id_pl=b.id
			WHERE b.tgl BETWEEN '$tgl1' AND '$tgl2'
			AND b.nm_perusahaan!='LAMINASI PPI' AND b.nm_perusahaan!='CORRUGATED PPI' $where     
			GROUP BY b.tgl,b.no_pkb,b.no_po
			ORDER BY b.tgl ASC,a.nm_ker DESC,b.no_pkb ASC,b.no_po");

            // TAMPIL DATA
            $i = 0;
            $totJml = 0;
            $totBerat = 0;
            foreach ($getIsiPerBulan->result() as $isi) {
                $i++;

                if($isi->nm_perusahaan == "-"){
                    $isiNama = $isi->nama;
                }else if($isi->id_pt == 31){ // DCK TGR
                    $isiNama = $isi->nm_perusahaan. " (TGR)";
                }else if($isi->id_pt == 32){ // DCK KRW
                    $isiNama = $isi->nm_perusahaan. " (KRW)";
                }else if($isi->id_pt == 33){ // DCK CBT
                    $isiNama = $isi->nm_perusahaan. " (CBT)";
                }else if($isi->id_pt == 57){ // STG 1 GRESIK
                    $isiNama = "PT. SURINDO TEGUH GEMILANG 1";
                }else if($isi->id_pt == 56){ // STG 2 GRESIK
                    $isiNama = "PT. SURINDO TEGUH GEMILANG 2";
                }else if($isi->id_pt == 63){ // STG 1 BKS
                    $isiNama = "PT. SENTRALINDO TEGUH GEMILANG 1";
                }else if($isi->id_pt == 64){ // STG 2 BKS
                    $isiNama = "PT. SENTRALINDO TEGUH GEMILANG 2";
                }else if($isi->id_pt == 58){ // UJK 1
                    $isiNama = "PT. UNIVERSAL JASA KEMAS 1";
                }else if($isi->id_pt == 62){ // UJK 2
                    $isiNama = "PT. UNIVERSAL JASA KEMAS 2";
                }else{
                    $isiNama = $isi->nm_perusahaan;
                }

                $html .= '<tr>
                    <td style="border:1px solid #000;vertical-align:middle;padding:5px 0;text-align:center">'.$i.'</td>
                    <td style="border:1px solid #000;vertical-align:middle;padding:5px 0;text-align:center;text-transform:uppercase">'.$this->m_fungsi->getHariIni($isi->tgl).'</td>
                    <td class="str" style="border:1px solid #000;vertical-align:middle;padding:5px 0;text-align:center">'.number_format($this->m_fungsi->fgGetTglIni($isi->tgl)).'</td>
                    <td style="border:1px solid #000;vertical-align:middle;padding:5px 3px">'.$isiNama.'</td>
                    <td class="str" style="border:1px solid #000;vertical-align:middle;padding:5px 3px;text-align:center">'.$isi->no_pkb.'</td>
                    <td class="str" style="border:1px solid #000;vertical-align:middle;padding:5px 3px;text-align:center">'.$isi->no_po.'</td>
					';

					// GSM
					$getIsiGsm = $this->db->query("SELECT a.nm_ker,a.g_label FROM m_timbangan a
					INNER JOIN pl b ON a.id_pl=b.id
					WHERE b.no_pkb='$isi->no_pkb'
					GROUP BY g_label
					ORDER BY g_label");
	
					$html .= '<td style="border:1px solid #000;vertical-align:middle;padding:5px 3px">';
	
					foreach($getIsiGsm->result() as $iGsm){
						if(($iGsm->nm_ker == 'MH' || $iGsm->nm_ker == 'MN') && ($iGsm->g_label == 105 || $iGsm->g_label == 110)){
							$wGsm = '#ccf';
						}else if($iGsm->nm_ker == 'MH' && $iGsm->g_label == 125){
							$wGsm = '#ffc';
						}else if(($iGsm->nm_ker == 'MH' || $iGsm->nm_ker == 'MN') && $iGsm->g_label == 150){
							$wGsm = '#fcc';
						}else if($iGsm->nm_ker == 'WP'){
							$wGsm = '#cfc';
						}else{
							$wGsm = '#fff';
						}

						$html .= ' <span style="background:'.$wGsm.'"><u>'.$iGsm->g_label.'</u></span>';
	
						// AMBIL UKURAN
						$getIsiGsmUk = $this->db->query("SELECT width,COUNT(roll) AS jml FROM m_timbangan a
						INNER JOIN pl b ON a.id_pl=b.id
						WHERE b.no_pkb='$isi->no_pkb' AND a.g_label='$iGsm->g_label'
						GROUP BY width
						ORDER BY width");
	
						foreach($getIsiGsmUk->result() as $iGsmUk){
							$html .= '<span style="background:'.$wGsm.'">/'.round($iGsmUk->width, 2).'('.$iGsmUk->jml.')</span>';
						}
					}
					$html .= '</td>';
				
					// seset
					if($isi->seset == 0 || $isi->seset == null){
						$ttBerat = $isi->berat;
					}else{
						$ttBerat = $isi->berat - $isi->seset;
					}
					$html .='
						<td class="str" style="border:1px solid #000;vertical-align:middle;padding:5px 0;text-align:center">'.number_format($isi->jumlah).'</td>
						<td class="str" style="border:1px solid #000;vertical-align:middle;padding:5px 0;text-align:center">'.number_format($ttBerat).'</td>
					</tr>';
					
                // $html .= '</td>
                //     <td style="border:1px solid #000;padding:5px 0"></td>
                //     <td style="border:1px solid #000;padding:5px 0"></td>
                // </tr>';

                $totJml += $isi->jumlah;
                $totBerat += $isi->berat;
            }

            $html .= '<tr>
                <td style="border:1px solid #000;background:#ddd;padding:5px;font-weight:bold;text-align:center" colspan="7">TOTAL</td>
                <td class="str" style="border:1px solid #000;background:#ddd;padding:5px;font-weight:bold;text-align:center">'.number_format($totJml).'</td>
                <td class="str" style="border:1px solid #000;background:#ddd;padding:5px 0;font-weight:bold;text-align:center">'.number_format($totBerat).'</td>
            </tr>';

        // }

		if($ctk != 1 ){ // NOTE HILANG DI PDF
			$html .= '<tr>
				<td style="padding:3px" colspan="9"></td>
			</tr>
			<tr>
				<td style="font-size:10px" colspan="9">NOTE:</td>
			</tr>
			<tr>
				<td></td>
				<td style="font-size:10px">HIJAU</td>
				<td style="font-size:10px" colspan="2">: WRP 70</td>
			</tr>
			<tr>
				<td></td>
				<td style="font-size:10px">BIRU</td>
				<td style="font-size:10px" colspan="2">: MEDIUM (MH) 105/110</td>
			</tr>
			<tr>
				<td></td>
				<td style="font-size:10px">KUNING</td>
				<td style="font-size:10px" colspan="2">: MEDIUM (MH) 125</td>
			</tr>
			<tr>
				<td></td>
				<td style="font-size:10px">MERAH</td>
				<td style="font-size:10px" colspan="2">: MEDIUM (MH) 150</td>
			</tr>
			<tr>
				<td></td>
				<td style="font-size:10px">PUTIH</td>
				<td style="font-size:10px" colspan="2">: B-KRAFT (BK) 110/125/150</td>
			</tr>';
		}

        $html .= '</table>';
		// $judul = "BULAN ".strtoupper($this->m_fungsi->fgGetBulan($r->ambil_bulan));
		$judul = "PENJUALAN HARIAN";
        if ($ctk == '0') {
			echo $html;
        }else if($ctk == '1') {
			// $this->m_fungsi->_mpdf2('',$html,10,10,10,'L','FG',2);
			$this->m_fungsi->newPDFopsi($html,'L',5,5,28.5,20,'lapHarian',$tgl1,$tgl2,'','','');
        }else{
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=$judul.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $data2['prev']= $html;
            $this->load->view('view_excel', $data2);
        }

    }

    function penjualanRekapTotal() {
        $tgl1 = $_GET['tgl1'];
        $tgl2 = $_GET['tgl2'];
        
        $html = '';

        $html .= '<table cellspacing="0" style="font-size:12px;color:#00;border-collapse:collapse;vertical-align:top;width:100%">
            <tr>
                <th style="padding:0;width:6%"></th>
                <th style="padding:0;width:18%"></th>
                <th style="padding:0;width:18%"></th>
                <th style="padding:0;width:18%"></th>
                <th style="padding:0;width:18%"></th>
                <th style="padding:0;width:18%"></th>
            </tr>';

        $html .= '<tr>
            <td style="padding:0 0 5px;text-align:center;font-weight:bold" colspan="6">PENJUALAN REKAP HARIAN</td>
        </tr>
        <tr>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">NO</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">TANGGAL</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">MEDIUM</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">W R P</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">B-KRAFT</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">TOTAL</td>
        </tr>';

        // ISI
        $getIsiRekap = $this->db->query("SELECT b.tgl,
        (SELECT SUM(c.weight) FROM m_timbangan c
        INNER JOIN pl d ON c.id_pl=d.id
        WHERE d.tgl=b.tgl AND c.nm_ker LIKE '%M%') AS jmlMH,
        (SELECT SUM(c.weight) FROM m_timbangan c
        INNER JOIN pl d ON c.id_pl=d.id
        WHERE d.tgl=b.tgl AND c.nm_ker='BK') AS jmlBK,
        (SELECT SUM(c.weight) FROM m_timbangan c
        INNER JOIN pl d ON c.id_pl=d.id
        WHERE d.tgl=b.tgl AND c.nm_ker='WP') AS jmlWP,
        (SELECT SUM(c.seset) FROM m_timbangan c
        INNER JOIN pl d ON c.id_pl=d.id
        WHERE d.tgl=b.tgl AND c.nm_ker LIKE '%M%') AS sesetMH,
        (SELECT SUM(c.seset) FROM m_timbangan c
        INNER JOIN pl d ON c.id_pl=d.id
        WHERE d.tgl=b.tgl AND c.nm_ker='BK') AS sesetBK,
        (SELECT SUM(c.seset) FROM m_timbangan c
        INNER JOIN pl d ON c.id_pl=d.id
        WHERE d.tgl=b.tgl AND c.nm_ker='WP') AS sesetWP
        -- (SELECT SUM(c.weight) FROM m_timbangan c
        -- INNER JOIN pl d ON c.id_pl=d.id
        -- WHERE d.tgl=b.tgl) AS jmlTOT
        FROM m_timbangan a
        INNER JOIN pl b ON a.id_pl=b.id
        -- WHERE b.tgl LIKE '%2021-03%'
        WHERE b.tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY b.tgl
        ORDER BY b.tgl ASC");

        $i = 0;
        $m = 0;
        $totJmlMH = 0;
        $totJmlWP = 0;
        $totJmlBK = 0;
        $totJmlTot = 0;
        foreach($getIsiRekap->result() as $r){
            $i++;

            if($r->sesetMH == 0 || $r->sesetMH == null){
                $jmlSetMH = 0;
            }else{
                $jmlSetMH = $r->sesetMH;
            }
            if($r->sesetBK == 0 || $r->sesetBK == null){
                $jmlSetBK = 0;
            }else{
                $jmlSetBK = $r->sesetBK;
            }
            if($r->sesetWP == 0 || $r->sesetWP == null){
                $jmlSetWP = 0;
            }else{
                $jmlSetWP = $r->sesetWP;
            }
            $totot = ($r->jmlMH - $jmlSetMH) + ($r->jmlBK - $jmlSetBK) + ($r->jmlWP - $jmlSetWP);

            // TOTAL
            $totJmlMH += $r->jmlMH - $jmlSetMH;
            $totJmlWP += $r->jmlWP - $jmlSetWP;
            $totJmlBK += $r->jmlBK - $jmlSetBK;
            $totJmlTot += $totot;

            // MINGGU
            // $getHariMinggu = date('l', strtotime($r->tgl));
            // if($getHariMinggu == 'Sunday'){
            //     $m++;
            //     $hariMinggu = '<tr>
            //         <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold" colspan="2">MINGGU KE-'.$m.'</td>
            //         <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($totJmlMH).'</td>
            //         <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($totJmlWP).'</td>
            //         <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($totJmlBK).'</td>
            //         <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($totJmlTot).'</td>
            //     </tr>';
            // }else{
            //     $hariMinggu = '';
            // }

            $html .= '<tr>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.$i.'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.$this->m_fungsi->tanggal_format_indonesia($r->tgl).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($r->jmlMH - $jmlSetMH).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($r->jmlWP - $jmlSetWP).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($r->jmlBK - $jmlSetBK).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($totot).'</td>
            </tr>';
            // </tr>'.$hariMinggu;
        }

        // if($hariMinggu == ''){
            $html .= '<tr>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold" colspan="2">TOTAL</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($totJmlMH).'</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($totJmlWP).'</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($totJmlBK).'</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($totJmlTot).'</td>
            </tr>';
        // }

        $html .= '</table>';

        $this->m_fungsi->_mpdf('',$html,10,10,10,'P');
    }

    function penjualanPerTahun(){
        $tahun = $_GET['tahun'];

        $html = '';

        $html .= '<table cellspacing="0" style="font-size:12px;color:#00;border-collapse:collapse;vertical-align:top;width:100%">
            <tr>
                <th style="border:0;padding:0;width:6%"></th>
                <th style="border:0;padding:0;width:7%"></th>
                <th style="border:0;padding:0;width:7%"></th>
                <th style="border:0;padding:0;width:7%"></th>
                <th style="border:0;padding:0;width:7%"></th>
                <th style="border:0;padding:0;width:7%"></th>
                <th style="border:0;padding:0;width:7%"></th>
                <th style="border:0;padding:0;width:7%"></th>
                <th style="border:0;padding:0;width:7%"></th>
                <th style="border:0;padding:0;width:7%"></th>
                <th style="border:0;padding:0;width:7%"></th>
                <th style="border:0;padding:0;width:8%"></th>
                <th style="border:0;padding:0;width:8%"></th>
                <th style="border:0;padding:0;width:8%"></th>
            </tr>';

        $html .= '<tr>
            <td style="padding:0 0 5px;text-align:center;font-weight:bold" colspan="14">PENJUALAN TAHUNAN</td>
        </tr>
        <tr>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center;vertical-align:middle" rowspan="2">TAHUN</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center;vertical-align:middle" rowspan="2">BULAN</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center" colspan="3">MEDIUM</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center" colspan="3">W R P</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center" colspan="3">B KRAFT</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center" colspan="3">MEDIUM - W R P - BK</td>
        </tr>
        <tr>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">RITASE</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">JML ROLL</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">TONASE</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">RITASE</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">JML ROLL</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">TONASE</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">RITASE</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">JML ROLL</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">TONASE</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">RITASE</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">JML ROLL</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px;font-weight:bold;text-align:center">TONASE</td>
        </tr>';

        // AMBIL BULAN
        $getBulanKop = $this->db->query("SELECT DISTINCT SUBSTRING(b.tgl, 1, 7) AS ambil_bulan,YEAR(b.tgl) AS tahun FROM m_timbangan a
        INNER JOIN pl b ON a.id_pl=b.id
        WHERE b.tgl LIKE '%$tahun%'
        GROUP BY b.tgl
        ORDER BY b.tgl");
        
        $getRows = $getBulanKop->num_rows();
        $numRows = $getRows + 1;
        $html .= '<tr>
            <td style="border:1px solid #000;padding:5px;font-weight:bold;text-align:center;vertical-align:middle" rowspan="'.$numRows.'">'.$getBulanKop->row()->tahun.'</td>
            <td style="border:0;padding:0" colspan="9"></td>
        </tr>
            ';

        $allIsiRitaseMH = 0;
        $allIsiRitaseWP = 0;
        $allIsiRitaseBK = 0;
        $allIsiThnrollMH = 0;
        $allIsiThnrollWP = 0;
        $allIsiThnrollBK = 0;
        $allIsiThnjmlMH = 0;
        $allIsiThnjmlWP = 0;
        $allIsiThnjmlBK = 0;
        $totAllRitase = 0;
        $totAllRoll = 0;
        $totAllTonase = 0;
        foreach($getBulanKop->result() as $r){
            // AMBIL ISI PER BULAN
            // TOTAL RITASE PER BULAN
            // MH
            $getIsiRitaseMH = $this->db->query("SELECT b.tgl,b.no_pkb FROM m_timbangan a
            INNER JOIN pl b ON a.id_pl=b.id
            WHERE b.tgl LIKE '%$r->ambil_bulan%' AND a.nm_ker LIKE '%M%'
            GROUP BY b.tgl,b.no_pkb")->num_rows();
            // W R P
            $getIsiRitaseWP = $this->db->query("SELECT b.tgl,b.no_pkb FROM m_timbangan a
            INNER JOIN pl b ON a.id_pl=b.id
            WHERE b.tgl LIKE '%$r->ambil_bulan%' AND a.nm_ker='WP'
            GROUP BY b.tgl,b.no_pkb")->num_rows();
            // B K
            $getIsiRitaseBK = $this->db->query("SELECT b.tgl,b.no_pkb FROM m_timbangan a
            INNER JOIN pl b ON a.id_pl=b.id
            WHERE b.tgl LIKE '%$r->ambil_bulan%' AND a.nm_ker='BK'
            GROUP BY b.tgl,b.no_pkb")->num_rows();
            // TOTAL RITASE PERBULAN
            $totBlnRitase = $getIsiRitaseMH + $getIsiRitaseWP + $getIsiRitaseBK;

            // CARI JUMLAH ROLL DAN BERAT
            // MH
            $getIsiCountBeratMH = $this->db->query("SELECT COUNT(*) AS countt,SUM(a.weight) AS beratt,SUM(a.seset) AS sesett FROM m_timbangan a
            INNER JOIN pl b ON a.id_pl=b.id
            WHERE b.tgl LIKE '%$r->ambil_bulan%' AND a.nm_ker LIKE '%M%'")->row();
            // WRP
            $getIsiCountBeratWP = $this->db->query("SELECT COUNT(*) AS countt,SUM(a.weight) AS beratt,SUM(a.seset) AS sesett FROM m_timbangan a
            INNER JOIN pl b ON a.id_pl=b.id
            WHERE b.tgl LIKE '%$r->ambil_bulan%' AND a.nm_ker='WP'")->row();
            // BK
            $getIsiCountBeratBK = $this->db->query("SELECT COUNT(*) AS countt,SUM(a.weight) AS beratt,SUM(a.seset) AS sesett FROM m_timbangan a
            INNER JOIN pl b ON a.id_pl=b.id
            WHERE b.tgl LIKE '%$r->ambil_bulan%' AND a.nm_ker='BK'")->row();
            // TOTAL JML ROLL, TONASE PER BULAN
            // SESET
            if($getIsiCountBeratMH->sesett == 0 || $getIsiCountBeratMH->sesett == null){
				$jmlSetMH = 0;
            }else{
				$jmlSetMH = $getIsiCountBeratMH->sesett;
			}
			if($getIsiCountBeratWP->sesett == 0 || $getIsiCountBeratWP->sesett == null){
				$jmlSetWP = 0;
            }else{
				$jmlSetWP = $getIsiCountBeratWP->sesett;
			}
			if($getIsiCountBeratBK->sesett == 0 || $getIsiCountBeratBK->sesett == null){
				$jmlSetBK = 0;
            }else{
				$jmlSetBK = $getIsiCountBeratBK->sesett;
			}
            $totBlnRoll = $getIsiCountBeratMH->countt + $getIsiCountBeratWP->countt + $getIsiCountBeratBK->countt;
            $totBlnTonase = ($getIsiCountBeratMH->beratt - $jmlSetMH) + ($getIsiCountBeratWP->beratt - $jmlSetWP) + ($getIsiCountBeratBK->beratt - $jmlSetBK);

            $html .= '<tr>
                <td style="border:1px solid #000;padding:5px 0;text-align:center;text-transform:uppercase">'.substr($this->m_fungsi->fgGetBulan($r->ambil_bulan),0, 3).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiRitaseMH).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiCountBeratMH->countt).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiCountBeratMH->beratt - $jmlSetMH).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiRitaseWP).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiCountBeratWP->countt).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiCountBeratWP->beratt - $jmlSetWP).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiRitaseBK).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiCountBeratBK->countt).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiCountBeratBK->beratt - $jmlSetBK).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($totBlnRitase).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($totBlnRoll).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($totBlnTonase).'</td>
            </tr>';

            // PERHITUNGAN TOTAL DARI SEMUA BULAN
            $allIsiRitaseMH += $getIsiRitaseMH;
            $allIsiRitaseWP += $getIsiRitaseWP;
            $allIsiRitaseBK += $getIsiRitaseBK;
            $allIsiThnrollMH += $getIsiCountBeratMH->countt;
            $allIsiThnrollWP += $getIsiCountBeratWP->countt;
            $allIsiThnrollBK += $getIsiCountBeratBK->countt;
            $allIsiThnjmlMH += $getIsiCountBeratMH->beratt - $jmlSetMH;
            $allIsiThnjmlWP += $getIsiCountBeratWP->beratt - $jmlSetWP;
            $allIsiThnjmlBK += $getIsiCountBeratBK->beratt - $jmlSetBK;

            // PER HITUNGAN TOTAL KESELURAN PER TAHUN
            $totAllRitase += $getIsiRitaseMH + $getIsiRitaseWP + $getIsiRitaseBK;
            $totAllRoll += $totBlnRoll;
            $totAllTonase += $totBlnTonase;
        }

        // T O T A L S E M U A
        $html .= '<tr>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold" colspan="2">T O T A L</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($allIsiRitaseMH).'</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($allIsiThnrollMH).'</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($allIsiThnjmlMH).'</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($allIsiRitaseWP).'</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($allIsiThnrollWP).'</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($allIsiThnjmlWP).'</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($allIsiRitaseBK).'</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($allIsiThnrollBK).'</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($allIsiThnjmlBK).'</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($totAllRitase).'</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($totAllRoll).'</td>
                <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">'.number_format($totAllTonase).'</td>
            </tr>';

        $html .= '</table>';

        // $this->m_fungsi->_mpdf('',$html,10,10,10,'P');
        $this->m_fungsi->_mpdf2('',$html,10,10,10,'L','FG',2);
    }

	function printSJBOX(){
        $jenis = $_GET['jenis'];
        $ctk = $_GET['ctk'];

        $html = '';

        $data_pl = $this->db->query("SELECT DISTINCT a.*, b.nm_perusahaan,b.pimpinan AS nama,b.alamat,b.no_telp FROM pl_box a
        INNER JOIN m_perusahaan b ON a.id_perusahaan = b.id
        WHERE a.no_pkb='$jenis'
        GROUP BY a.no_pkb")->row();

        // AMBIL DATA
        $data_detail = $this->db->query("SELECT a.*,b.no_po,b.id_perusahaan FROM m_box a
        INNER JOIN pl_box b ON a.id_pl=b.id
        WHERE b.no_pkb='$jenis'
        ORDER BY b.no_po,a.flute DESC,a.ukuran ASC");
        // ORDER BY a.ukuran ASC");
        
        $count = $data_detail->num_rows();

        // id_perusahaan = 80 > PT. ANUGRAH JAYA PACKINDO
        // jarak 0 > 20 > 40 > 60 > 80
        if($count >= 7 && $data_pl->id_perusahaan == '80'){
            $px = '0';
        }else if($count >= 6 && $data_pl->id_perusahaan == '80'){
            $px = '0';
        }else if($count >= 5 && $data_pl->id_perusahaan == '80'){
            $px = '20';
        }else if($count >= 4 && $data_pl->id_perusahaan == '80'){
            $px = '60';
        }else if($count >= 9){
            $px = '20';
        }else{
            $px = '80';
        }

                                # # # # # # # # # K O P # # # # # # # # # #

        //  http://localhost/SI_timbangan/assets/images/logo_ppi_1.png
        $kop = '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:Arial !important">
            <tr>
                <th style="width:25% !important;height:'.$px.'"></th>
                <th style="width:75% !important;height:'.$px.'"></th>
            </tr>

            <tr>
                <td style="border:0;background:url(http://localhost/SI_timbangan_v2/assets/images/logo_ppi_inv.png)center no-repeat" rowspan="4"></td>
                <td style="border:0;font-size:32px;padding:20px 0 0">PT. PRIMA PAPER INDONESIA</td>
            </tr>
            <tr>
                <td style="border:0;font-size:14px">Dusun Timang Kulon, Desa Wonokerto, Kec.Wonogiri, Kab.Wonogiri</td>
            </tr>
            <tr>
                <td style="border:0;font-size:14px;padding:0">WONOGIRI - JAWA TENGAH - INDONESIA Kode Pos 57615</td>
            </tr>
            <tr>
                <td style="border:0;font-size:12px !important;padding:0 0 4px">http://primapaperindonesia.com</td>
            </tr>
        </table>

        <table cellspacing="0" style="font-size:18px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:Arial !important">
            <tr>
                <th style="width:15% !important;height:8px"></th>
            </tr>

            <tr>
                <td style="border-top:2px solid #000;padding:10px 0 5px;text-decoration:underline">SURAT JALAN</td>
            </tr>
        </table>';

        $gak_kop = '<table cellspacing="0" style="font-size:18px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:Arial !important">
            <tr>
                <th style="width:15% !important;height:150px"></th>
            </tr>

            <tr>
                <td style="border-top:2px solid #000;padding:10px 0 5px;text-decoration:underline">SURAT JALAN</td>
            </tr>
        </table>';

        if($data_pl->pajak == 'non'){
            $html .= $gak_kop;
        }else{
            $html .= $kop;
        }
        
                        # # # # # # # # # D E T A I L # # # # # # # # # #


        $html .= '<table cellspacing="0" style="font-size:11px !important;color:#000;border-collapse:collapse;vertical-align:top;width:100%;font-family:Arial !important">
            <tr>
                <th style="width:15% !important;height:8px"></th>
                <th style="width:1% !important;height:8px"></th>
                <th style="width:28% !important;height:8px"></th>
                <th style="width:15% !important;height:8px"></th>
                <th style="width:1% !important;height:8px"></th>
                <th style="width:40% !important;height:8px"></th>
            </tr>';


        if($data_pl->tgl == "0000-00-00" || $data_pl->tgl == "0001-00-00" || $data_pl->tgl == ""){
            $kett_tgll = "";
        }else{
            $kett_tgll = $this->m_fungsi->tanggal_format_indonesia($data_pl->tgl);
        }

        $html .= '<tr>
            <td style="padding:5px 0">TANGGAL</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$kett_tgll.'</td>
            <td style="padding:5px 0">KEPADA</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->nm_perusahaan.'</td>
        </tr>
        <tr>
            <td style="padding:5px 0">NO. SURAT JALAN</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->no_surat.'</td>
            <td style="padding:5px 0">ATTN</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->nama.'</td>
        </tr>
        <tr>
            <td style="padding:5px 0">NO. SO</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->no_so.'</td>
            <td style="padding:5px 0">ALAMAT</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->alamat.'</td>
        </tr>
        <tr>
            <td style="padding:5px 0">NO. PKB</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->no_pkb.'</td>
            <td style="padding:5px 0">NO. TELP / HP</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->no_telp.'</td>
        </tr>
        <tr>
            <td style="padding:5px 0">NO. KENDARAAN</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->no_kendaraan.'</td>
            <td style="padding:5px 0"></td>
            <td style="text-align:center;padding:5px 0"></td>
            <td style="padding:5px 0"></td>
        </tr>';
        $html .= '</table>';

                                # # # # # # # # # I S I # # # # # # # # # #

        $html .= '<table cellspacing="0" style="font-size:11px !important;color:#000;border-collapse:collapse;text-align:center;width:100%;font-family:Arial !important">
        <tr>
            <th style="width:5% !important;height:15px"></th>
            <th style="width:25% !important;height:15px"></th>
            <th style="width:30% !important;height:15px"></th>
            <th style="width:8% !important;height:15px"></th>
            <th style="width:13% !important;height:15px"></th>
            <th style="width:19% !important;height:15px"></th>
        </tr>
        <tr>
            <td style="border:1px solid #000;padding:5px 0">NO</td>
            <td style="border:1px solid #000;padding:5px 0">NO. PO</td>
            <td style="border:1px solid #000;padding:5px 0">ITEM DESCRIPTION</td>
            <td style="border:1px solid #000;padding:5px 0">FLUTE</td>
            <td style="border:1px solid #000;padding:5px 0">QTY</td>
            <td style="border:1px solid #000;padding:5px 0">KETERANGAN</td>
        </tr>';

        // TAMBAH KOTAK KOSONG
        $colKosong = '<tr>
            <td style="border:1px solid #000;padding:23px 0 0"></td>
            <td style="border:1px solid #000;padding:23px 0 0"></td>
            <td style="border:1px solid #000;padding:23px 0 0"></td>
            <td style="border:1px solid #000;padding:23px 0 0"></td>
            <td style="border:1px solid #000;padding:23px 0 0"></td>
            <td style="border:1px solid #000;padding:23px 0 0"></td>
        </tr>';

        $no = 1;
		$tot_qty = 0;
        foreach ($data_detail->result() as $data ) {

            // 80 > ANUGRAH JAYA PACKINDO
            if($data->id_perusahaan == '80'){
                $plusColms = $colKosong;
            }else{
                $plusColms = '';
            }

            $html .= '<tr>
                <td style="border:1px solid #000;padding:5px 0">'.$no.'</td>
                <td style="border:1px solid #000;padding:5px 0">'.$data->no_po.'</td>
                <td style="border:1px solid #000;padding:5px">'.$data->ukuran.'</td>
                <td style="border:1px solid #000;padding:5px 0">'.$data->flute.'</td>
                <td style="border:1px solid #000;padding:5px 0">'.number_format($data->qty).' '.$data->qty_ket.'</td>
                <td style="border:1px solid #000;padding:5px 0"></td>
            </tr>'.$plusColms;
            $no++;
			$tot_qty+=$data->qty;

        }

        // TAMBAH KOTAK KOSONG
        if($data_pl->id_perusahaan == '80'){
            if($count == 1) {
                $xx = 4;
            }else if($count == 2){
                $xx = 3;
            }else if($count == 3){
                $xx = 1;
            }else if($count == 4){
                $xx = 0;
            }else if($count == 5){  
                $xx = 0;
            }
        }else{
            if($count == 1) {
                $xx = 5;
            }else if($count == 2){
                $xx = 4;
            }else if($count == 3){
                $xx = 3;
            }else if($count == 4){
                $xx = 2;
            }else if($count == 5){  
                $xx = 1;
            }
        }
        
        if($count <= 5) {
            for($i = 0; $i < $xx; $i++){
                $html .= $colKosong;
            }
        }
        
        // TOTAL
        // <td style="border:1px solid #000;padding:5px 0">'.number_format($tot_qty).' '.$data->qty_ket.'</td>
        $html .= '<tr>
            <td style="border:1px solid #000;padding:5px 0" colspan="4">TOTAL</td>
            <td style="border:1px solid #000;padding:5px 0">'.number_format($tot_qty).' '.$data->qty_ket.'</td>
            <td style="border:1px solid #000;padding:5px 0"></td>
        </tr>';

        $html .= '</table>';


                                # # # # # # # # # T T D # # # # # # # # # #      


        $html .= '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;text-align:center;width:100%;font-family:Arial !important">
        <tr>
            <th style="width:14% !important;height:35px"></th>
            <th style="width:14% !important;height:35px"></th>
            <th style="width:14% !important;height:35px"></th>
            <th style="width:15% !important;height:35px"></th>
            <th style="width:15% !important;height:35px"></th>
            <th style="width:14% !important;height:35px"></th>
            <th style="width:14% !important;height:35px"></th>
        </tr>

        <tr>
            <td style="border:1px solid #000;padding:5px 0">DIBUAT</td>
            <td style="border:1px solid #000;padding:5px 0" colspan="2">DIKELUARKAN OLEH</td>
            <td style="border:1px solid #000;padding:5px 0">DI KETAHUI</td>
            <td style="border:1px solid #000;padding:5px 0">DI SETUJUI</td>
            <td style="border:1px solid #000;padding:5px 0">SOPIR</td>
            <td style="border:1px solid #000;padding:5px 0">DITERIMA</td>
        </tr>

        <tr>
            <td style="border:1px solid #000;height:80px"></td>
            <td style="border:1px solid #000;height:80px"></td>
            <td style="border:1px solid #000;height:80px"></td>
            <td style="border:1px solid #000;height:80px"></td>
            <td style="border:1px solid #000;height:80px"></td>
            <td style="border:1px solid #000;height:80px"></td>
            <td style="border:1px solid #000;height:80px"></td>
        </tr>
        
        <tr>
            <td style="border:1px solid #000;padding:5px 0">ARGA <br>ADMIN</td>
            <td style="border:1px solid #000;padding:5px 0">DION<br>PPIC</td>
            <td style="border:1px solid #000;padding:5px 0">BP. SUMARTO<br>SPV GUDANG</td>
            <td style="border:1px solid #000;padding:5px 0"></td>
            <td style="border:1px solid #000;padding:5px 0">BP. WEINARTO <br>GM</td>
            <td style="border:1px solid #000"></td>
            <td style="border:1px solid #000"></td>
        </tr>

        <tr>
            <td style="height:30px" colspan="7"></td>
        </tr>

        <tr>
            <td style="font-weight:normal;text-align:left;padding:3px 0" colspan="4">NOTE :</td>
            <td style="border:1px solid #000;padding:5px 0;font-weight:bold;font-size:12" colspan="3">PERHATIAN</td>
        </tr>

        <tr>
            <td style="font-weight:normal;text-align:left;padding:3px 0 3px 40px">WHITE</td>
            <td style="font-weight:normal;text-align:left;padding:3px 0" colspan="3" >: PEMBELI / CUSTOMER</td>
            <td style="border:1px solid #000;font-size:13px;line-height:2;font-weight:bold" colspan="3" rowspan="5">KLAIM BARANG KURANG / RUSAK<br/>TIDAK DI TERIMA SETELAH TRUK / SOPIR<br/>KELUAR LOKASI BONGKAR</td>
        </tr>

        <tr>
            <td style="font-weight:normal;text-align:left;padding:3px 0 3px 40px">PINK</td>
            <td style="font-weight:normal;text-align:left;padding:3px 0">: FINANCE</td>
        </tr>

        <tr>
            <td style="font-weight:normal;text-align:left;padding:3px 0 3px 40px">YELLOW</td>
            <td style="font-weight:normal;text-align:left;padding:3px 0">: ACC</td>
        </tr>

        <tr>
            <td style="font-weight:normal;text-align:left;padding:3px 0 3px 40px">GREEN</td>
            <td style="font-weight:normal;text-align:left;padding:3px 0">: ADMIN</td>
        </tr>

        <tr>
            <td style="font-weight:normal;text-align:left;padding:3px 0 3px 40px">BLUE</td>
            <td style="font-weight:normal;text-align:left;padding:3px 0">: EXPEDISI</td>
        </tr>
        ';
        $html .= '</table>';

            ################## CETAK

        if($ctk == '0') {
            if($count >= 7 && $data_pl->id_perusahaan == '80'){
                $this->m_fungsi->_mpdf('',$html,10,10,1,'P');
            }else{
                $this->m_fungsi->_mpdf('',$html,10,10,10,'P');
            }
        }else{
            echo $html;
        }
    }

    function lapSHEET() {
        $tgl1 = $_GET['tgl1'];
        $tgl2 = $_GET['tgl2'];
        $ctk = $_GET['ctk'];

        $html = '';

        // CARI ANTARA TGL
        $getAntaraTgl = $this->db->query("SELECT a.tgl FROM pl_box a
        INNER JOIN m_box b ON a.id=b.id_pl
        WHERE a.no_pkb LIKE '%SHEET%' AND a.tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY a.tgl
        ORDER BY a.tgl ASC");

        $html .= '<table>';

        foreach($getAntaraTgl->result() as $r){
            $html .= '<tr>
                <td>'.$r->tgl.'</td>
            </tr>';

            // CARI PLAT KENDARAAN
            $getTglnIDpt = $this->db->query("SELECT a.tgl,a.id_perusahaan,a.no_kendaraan FROM pl_box a
            INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
            INNER JOIN m_box b ON a.id=b.id_pl
            WHERE a.no_pkb LIKE '%SHEET%' AND a.tgl='$r->tgl'
            GROUP BY a.no_kendaraan
            ORDER BY a.no_pkb ASC");

            $ii = 0;
            foreach($getTglnIDpt->result() as $rr){
                $ii++;
                if($ctk == 1 || $ctk == 3){
                    $platt = ' - ( '.$rr->no_kendaraan.' )';
                }else{
                    $platt = '';
                }
                
                $html .= '<tr>
                    <td>RIT '.$ii.', PENGIRIMAN SHEET KE '.$platt.'</td>
                </tr>';

                // GET ID DARI PLAT
                $getIsiPlat = $this->db->query("SELECT a.tgl,a.id_perusahaan,a.no_pkb,c.nm_perusahaan,a.no_kendaraan,SUM(b.qty) AS qty FROM pl_box a
                INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
                INNER JOIN m_box b ON a.id=b.id_pl
                WHERE a.no_pkb LIKE '%SHEET%' AND a.tgl='$rr->tgl' AND a.no_kendaraan='$rr->no_kendaraan'
                GROUP BY a.id_perusahaan
                ORDER BY a.no_pkb ASC");

                $totIsi = 0;
                $sumtonase = 0;
                $i = 0;
                foreach($getIsiPlat->result() as $rrr){
                    $i++;

                    $html .= '<tr>
                        <td>'.$i.'. '.$rrr->nm_perusahaan.'</td>
                    </tr>';

                    // SENGGOL ISI NYA DONG
                    $getSenggolIsi = $this->db->query("SELECT a.tgl,a.id_perusahaan,a.no_pkb,a.no_po,b.ukuran,b.flute,b.qty,b.qty_ket,c.nm_perusahaan,a.no_kendaraan FROM pl_box a
                    INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
                    INNER JOIN m_box b ON a.id=b.id_pl
                    WHERE a.no_pkb LIKE '%SHEET%' AND a.tgl='$rrr->tgl' AND a.no_kendaraan='$rrr->no_kendaraan' AND a.id_perusahaan='$rrr->id_perusahaan'
                    ORDER BY a.no_pkb ASC,a.no_po,b.flute DESC,b.ukuran ASC");
                    // ORDER BY a.no_pkb ASC,b.ukuran ASC");

                    $tonase = 0;
                    foreach($getSenggolIsi->result() as $isi){

                        $getFlute = $this->db->query("SELECT * FROM po_box_master a
                        WHERE a.no_po='$isi->no_po' AND a.ukuran='$isi->ukuran' AND a.flute='$isi->flute'");
                        $ff = $getFlute->row();
                        // f_k     f_b    f_cl     f_c    f_bl  flute

                        $exUk1 = explode(".", $isi->ukuran);
                        $exUk = explode("X", trim($exUk1[0]));

                        if($getFlute->num_rows() > 0){
							if($ff->f_k == "" && $ff->f_b == "" && $ff->f_cl == "" && $ff->f_c == "" && $ff->f_bl == ""){
								$bb = 0;
                                $x_b = 0;
                                $x_c = 0;
                                $fl = 0;
							}else{
								$x_b = round($ff->f_b * 1.36, 2);
								$x_c = round($ff->f_c * 1.46, 2);
								if($ff->flute == "CB" || $ff->flute == "BC"){
									$fl = round(($ff->f_k + $x_b + $ff->f_cl + $x_c + $ff->f_bl) / 1000, 2);
								}else if($ff->flute == "CF" || $ff->flute == "C"){
									$fl = round(($ff->f_k + $x_c + $ff->f_bl) / 1000, 2);
								}else if($ff->flute == "BF" || $ff->flute == "B"){
									$fl = round(($ff->f_k + $x_b + $ff->f_bl) / 1000, 2);
								}else{
									$fl = 0;
								}

                                $bb = round($fl * ($exUk[0] / 1000) * ($exUk[1] / 1000), 2);
							}
                        }else{
                            $bb = 0;
                            $x_b = 0;
                            $x_c = 0;
                            $fl = 0;
                        }

                        if($ctk == 0){
                            $html .= '<tr><td>- '.$isi->no_po.' - '.$isi->ukuran.' - '.$isi->flute.' - '.number_format($isi->qty).' '.$isi->qty_ket.'</td></tr>';
                        }else{
                            $html .= '<tr><td>- (po: <b>'.$isi->no_po.'</b>) - (uk: <b>'.$isi->ukuran.'</b>) - (f: <b>'.$isi->flute.'</b>) - (qty: <b>'.number_format($isi->qty).'</b> x bb: <b>'.round($bb,2).'</b>) > <b>'.number_format(round($bb * $isi->qty)).'</b></td></tr>';
                        }

                        $tonase += round($bb * $isi->qty);
                    }

                    $totIsi += $rrr->qty;
                    $sumtonase += $tonase;
                // end
                }

                // TOTAL ISINYA
                if($ctk == 0){
                    $html .= '<tr><td>TOTAL '.number_format($totIsi).' '.$isi->qty_ket.' /  KG</td></tr>';
                }else{
                    $html .= '<tr><td>TOTAL '.number_format($totIsi).' '.$isi->qty_ket.' / (tonase: <b>'.number_format($sumtonase).' KG</b>. min: <b>'.number_format(round($sumtonase - ($sumtonase * 4 / 100))).'</b>. max: <b>'.number_format(round($sumtonase + ($sumtonase * 4 / 100))).'</b> )</td></tr>';
                }

                $html .= '<tr>
                    <td>&nbsp;</td>
                </tr>';
            }

            $html .= '<tr>
                <td>&nbsp;</td>
            </tr>';
        }
        $html .= '</table>';

        echo $html;
    }

    function lapBOXnSHEET() {
        $tgl1 = $_GET['tgl1'];
        $tgl2 = $_GET['tgl2'];
        $ctk = $_GET['ctk'];

        $html = '';
        $html .= '<table>';

        // CARI ANTARA TGL
        $getQTgl = $this->db->query("SELECT tgl FROM pl_box
        WHERE tgl BETWEEN '$tgl1' AND '$tgl2'
        GROUP BY tgl");
        foreach($getQTgl->result() as $rTgl){
            $html .= '<tr>
                <td style="font-weight:bold">'.$rTgl->tgl.'</td>
            </tr>';

            $getQPlat = $this->db->query("SELECT a.tgl,no_kendaraan,a.* FROM pl_box a
            WHERE tgl='$rTgl->tgl'
            GROUP BY no_kendaraan
            ORDER BY no_pkb");

            $i = 0;
            foreach($getQPlat->result() as $rPlat){
                $i++;
                // <td>RIT '.$i.'. PENGIRIMAN KE - '.$rPlat->no_kendaraan.'</td>
                $html .= '<tr>
                    <td>RIT '.$i.', PENGIRIMAN BOX KE</td>
                </tr>';

                $getQCust = $this->db->query("SELECT a.tgl,a.id_perusahaan,b.nm_perusahaan,SUBSTRING_INDEX(SUBSTRING_INDEX(a.no_surat, '/', 2), '/', -1) AS sstr,a.no_kendaraan FROM pl_box a
                INNER JOIN m_perusahaan b ON a.id_perusahaan=b.id
                WHERE tgl='$rPlat->tgl' AND no_kendaraan='$rPlat->no_kendaraan'
                GROUP BY a.id_perusahaan
                ORDER BY sstr,a.no_pkb");
                
                $ii = 0;
                foreach($getQCust->result() as $rCust){
                    $ii++;
                    // PT. DELTA MERLIN SANDANG TEKSTIL III               68
					// PT. DELTA DUNIA TEKSTIL I                          69
					// PT. DELTA DUNIA TEKSTIL IV                         70
					// PT. DELTA MERLIN SANDANG TEKSTIL I                 71
					// PT. DELTA DUNIA SANDANG TEKSTIL                    73
					// PT. DELTA DUNIA TEKSTIL II                        132
					// PT. DELTA MERLIN SANDANG TEKSTIL V                135
					// PT. DELTA MERLIN SANDANG TEKSTIL IV               148
					if($rCust->id_perusahaan == 68){
						$rNmPt = 'PT. DMST III';
					}else if($rCust->id_perusahaan == 69){
						$rNmPt = 'PT. DDT I';
					}else if($rCust->id_perusahaan == 70){
						$rNmPt = 'PT. DDT IV';
					}else if($rCust->id_perusahaan == 71){
						$rNmPt = 'PT. DMST I';
					}else if($rCust->id_perusahaan == 73){
						$rNmPt = 'PT. DDST';
					}else if($rCust->id_perusahaan == 132){
						$rNmPt = 'PT. DDT II';
					}else if($rCust->id_perusahaan == 135){
						$rNmPt = 'PT. DMST V';
					}else if($rCust->id_perusahaan == 148){
						$rNmPt = 'PT. DMST IV';
					}else{
						$rNmPt = $rCust->nm_perusahaan;
					}
                    $html .= '<tr>
                        <td>'.$ii.'. '.$rNmPt.'</td>
                    </tr>';

                    if($rCust->sstr == 'BOX'){
                        $wHere = "AND b.ukuran LIKE '%BOX%'";
                    }else{
                        $wHere = "";
                    }

                    $getQisi = $this->db->query("SELECT a.tgl,a.id_perusahaan,a.no_pkb,a.no_po,b.ukuran,b.flute,b.qty,b.qty_ket,c.nm_perusahaan,a.no_kendaraan FROM pl_box a
                    INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
                    INNER JOIN m_box b ON a.id=b.id_pl
                    WHERE a.no_pkb LIKE '%$rCust->sstr%' $wHere AND a.tgl='$rCust->tgl' AND a.no_kendaraan='$rCust->no_kendaraan' AND a.id_perusahaan='$rCust->id_perusahaan'");

                    if($rCust->sstr == 'BOX'){
                        foreach($getQisi->result() as $rFBox){
                            // 68 69 70 71 73 132 135 148 153
                            if($rFBox->id_perusahaan == 68 || $rFBox->id_perusahaan == 69 || $rFBox->id_perusahaan == 70 || $rFBox->id_perusahaan == 71 || $rFBox->id_perusahaan == 73 || $rFBox->id_perusahaan == 132 || $rFBox->id_perusahaan == 135 || $rFBox->id_perusahaan == 148 || $rFBox->id_perusahaan == 153){
                                if($rFBox->flute == 'CB' || $rFBox->flute == 'BC'){
                                    $ukFl = 'DOUBLE WALL + LAYER';
                                }else{
                                    $ukFl = 'SINGLE WALL + LAYER';
                                }

                                $exUk = explode(' ',$rFBox->ukuran);
                                $kUk = $exUk[2].' '.$ukFl;
                            }else{
                                $kUk = $rFBox->ukuran;
                            }
                            $html .= '<tr>
                                <td>- '.$kUk.'. TOTAL '.number_format($rFBox->qty).' '.$rFBox->qty_ket.'</td>
                            </tr>';
                        }
                    }else{
                        $sumQtySheet = 0;
                        foreach($getQisi->result() as $rFSheet){
                            $html .= '<tr>
                            <td>- '.$rFSheet->no_po.' - '.$rFSheet->ukuran.' - '.$rFSheet->flute.' - '.number_format($rFSheet->qty).' '.$rFSheet->qty_ket.'</td>
                            </tr>';
                        }
                    }
                }

                $html .= '<tr>
                    <td>&nbsp;</td>
                </tr>';
            }

            // $html .= '<tr>
            //     <td>&nbsp;</td>
            // </tr>';
        }

        $html .= '</table>';

        echo $html;
    }

	function lapPenjualan() {
		$jenis = $_GET['jenis'];
        $tgl1 = $_GET['tgl1'];
        $tgl2 = $_GET['tgl2'];
        $ctk = $_GET['ctk'];
        $opsi = $_GET['opsi'];
        $pt = $_GET['pt'];

        $html = '';
		$html .= '<style>.str{mso-number-format:\@}</style>';
		$html .= '<table style="font-size:11px;width:100%;text-align:center;border-collapse:collapse;color:#000;margin:0;padding:0">';

        if($pt == 0){
            $tttt = '';
        }else{
            $tttt = $pt;
        }

		// S H E E T
		if($jenis == 'SHEET'){
            if($opsi == 1){
                $wdth = '19%';
                $kopWidth = '
                    <td style="border:0;padding:0;width:12%"></td>
                    <td style="border:0;padding:0;width:12%"></td>';
                $kopDetail = '
                    <td style="font-weight:bold;border:1px solid #000;padding:5px">TIMBANGAN</td>
                    <td style="font-weight:bold;border:1px solid #000;padding:5px">HARGA PO</td>';
                $sheetIsi = '
                    <td style="border:1px solid #000;padding:5px"></td>
                    <td style="border:1px solid #000;padding:5px"></td>';
                $where = '';
            }else if($opsi == 2){
                $wdth = '31%';
                $kopWidth = '
                    <td style="border:0;padding:0;width:6%"></td>
                    <td style="border:0;padding:0;width:6%"></td>';
                $kopDetail = '
                    <td style="font-weight:bold;border:1px solid #000;padding:5px">PLAT</td>
                    <td style="font-weight:bold;border:1px solid #000;padding:5px">CEK SJ</td>';
                $sheetIsi = '';
                $where = ',a.no_kendaraan';
            }else if($opsi == 3){
                $wdth = '31%';
                $kopWidth = '
                    <td style="border:0;padding:0;width:6%"></td>
                    <td style="border:0;padding:0;width:6%"></td>';
                $kopDetail = '
                    <td style="font-weight:bold;border:1px solid #000;padding:5px">BB</td>
                    <td style="font-weight:bold;border:1px solid #000;padding:5px">TOTAL BERAT</td>';
                $sheetIsi = '';
                $where = '';
            }else{
                $wdth = '43%';
                $kopWidth = '';
                $kopDetail = '';
                $sheetIsi = '';
                $where = '';
            }
			
			if($ctk != '2'){ // ctk excel
				$html .= '<tr>
					<td style="border:0;padding:0;width:8%"></td>
					<td style="border:0;padding:0;width:11%"></td>
					<td style="border:0;padding:0;width:19%"></td>
					<td style="border:0;padding:0;width:14%"></td>
					<td style="border:0;padding:0;width:'.$wdth.'%"></td>
					<td style="border:0;padding:0;width:5%"></td>
                    '.$kopWidth.'
				</tr>';
			}
            
			if($ctk != '1'){
				$html .= '
				<tr>
					<td style="font-weight:bold;border:1px solid #000;padding:5px">TANGGAL</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px">NO SJ</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px">CUSTOMER</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px">NO PO</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px">UKURAN</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px">QTY</td>
                    '.$kopDetail.'
				</tr>';
			}

			$getQIsi = $this->db->query("SELECT a.tgl,a.no_surat,a.id_perusahaan,c.nm_perusahaan,a.no_po,b.ukuran,b.qty,b.flute,a.no_kendaraan,a.sj,a.sj_blk FROM pl_box a
			INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
			INNER JOIN m_box b ON a.id=b.id_pl
			-- WHERE a.no_pkb LIKE '%$jenis%' AND a.tgl BETWEEN '$tgl1' AND '$tgl2' -- SHEET DOANG
			-- WHERE a.no_pkb LIKE '%BOX%' AND b.ukuran LIKE '%BOX%' AND a.tgl BETWEEN '$tgl1' AND '$tgl2' -- BOX DOANG
			WHERE (a.no_pkb LIKE '%SHEET%' OR a.no_pkb LIKE '%BOX%') AND a.tgl BETWEEN '$tgl1' AND '$tgl2' -- SHEET BOX JADI SATU
            AND a.id_perusahaan LIKE '%$tttt%'
            -- AND (a.id_perusahaan = '99' OR a.id_perusahaan = '77')
            -- AND a.no_kendaraan LIKE '%%'
			GROUP BY a.tgl,b.ukuran,b.flute,c.pimpinan,a.no_pkb
			ORDER BY a.tgl ASC $where ,a.no_pkb ASC,b.flute DESC,b.ukuran ASC");

            $sumTotBB = 0;
			foreach($getQIsi->result() as $isi){
                if($isi->sj == 'ok' && ($opsi == 0 || $opsi == 2)){
                    $clr = '#74C69D';
                }else if($opsi == 9){
                    $clr = '#FFF';
                }else{
                    $clr = '#FFF';
                }

                if($opsi == 2){
					if($isi->sj != 'open' && $isi->sj_blk != ''){
						if($isi->sj_blk == '' || $isi->sj_blk == null || $isi->sj_blk == 0000-00-00){
							$cekSJ = '-';
						}else{
							$cekSJ = $this->m_fungsi->tglInd_skt($isi->sj_blk);
						}
					}else{
						$cekSJ = '-';
					}
                    
                    $noPlat = '
						<td style="background:'.$clr.';border:1px solid #000;padding:5px">'.$isi->no_kendaraan.'</td>
						<td style="background:'.$clr.';border:1px solid #000;padding:5px">'.$cekSJ.'</td>';
                }else{
                    $noPlat = '';
                }

                if($opsi == 3){
                    $getqPO = $this->db->query("SELECT*FROM po_box_master
                    WHERE no_po='$isi->no_po' AND ukuran='$isi->ukuran' AND flute='$isi->flute'");
                    
                    $exUkuran = explode('.',$isi->ukuran);
                    $exUk = explode("X", trim($exUkuran[0]));

                    $bb = 0;
                    foreach($getqPO->result() as $ppoo){
                        if($ppoo->f_k == "" && $ppoo->f_b == "" && $ppoo->f_cl == "" && $ppoo->f_c == "" && $ppoo->f_bl == ""){
                            $bb = 0;
                        }else{
                            $x_b = round($ppoo->f_b * 1.36, 2);
                            $x_c = round($ppoo->f_c * 1.46, 2);
                            if($ppoo->flute == "CB" || $ppoo->flute == "BC"){
                                $fl = round(($ppoo->f_k + $x_b + $ppoo->f_cl + $x_c + $ppoo->f_bl) / 1000, 2);
                            }else if($ppoo->flute == "CF" || $ppoo->flute == "FC" || $ppoo->flute == "C"){
                                $fl = round(($ppoo->f_k + $x_c + $ppoo->f_bl) / 1000, 2);
                            }else if($ppoo->flute == "BF" || $ppoo->flute == "FB" || $ppoo->flute == "B"){
                                $fl = round(($ppoo->f_k + $x_b + $ppoo->f_bl) / 1000, 2);
                            }else{
                                $fl = 0;
                            }
                            $bb = round($fl * ($exUk[0] / 1000) * ($exUk[1] / 1000), 2);
                        }
                    }
                    
                    $bbxQty = round($bb * $isi->qty);

                    $kolBB = '
                        <td class="str" style="background:'.$clr.';border:1px solid #000;padding:5px;text-align:right">'.round($bb,2).'</td>
                        <td class="str" style="background:'.$clr.';border:1px solid #000;padding:5px;text-align:right">'.number_format($bbxQty).'</td>';

                    $sumTotBB += $bbxQty;
                    
                }else{
                    $kolBB = '';
                }

				$html .= '<tr>
					<td style="background:'.$clr.';border:1px solid #000;padding:5px">'.$this->m_fungsi->tglInd_skt($isi->tgl).'</td>
					<td style="background:'.$clr.';border:1px solid #000;padding:5px">'.$isi->no_surat.'</td>
					<td style="background:'.$clr.';border:1px solid #000;padding:5px;text-align:left">'.$isi->nm_perusahaan.'</td>
					<td class="str" style="background:'.$clr.';border:1px solid #000;padding:5px;text-align:left">'.$isi->no_po.'</td>
					<td class="str" style="background:'.$clr.';border:1px solid #000;padding:5px;text-align:left">'.$isi->ukuran.'</td>
					<td class="str" style="background:'.$clr.';border:1px solid #000;padding:5px;text-align:right">'.number_format($isi->qty).'</td>
                    '.$noPlat.'
                    '.$kolBB.'
                    '.$sheetIsi.'
				</tr>';
			}

            if($opsi == 3){
                $html .= '<tr>
                    <td style="border:1px solid #000;padding:5px" colspan="7"></td>
                    <td style="border:1px solid #000;padding:5px;text-align:right">'.number_format($sumTotBB).'</td>
                </tr>';
            }else{
                $html .= '';
            }

		// B O X
		}else if($jenis == 'BOX'){
			
            if($ctk != '2'){
    			$html .= '<tr>
    				<td style="border:0;padding:0;width:5%"></td>
    				<td style="border:0;padding:0;width:8%"></td>
    				<td style="border:0;padding:0;width:10%"></td>
    				<td style="border:0;padding:0;width:18.5%"></td>
    				<td style="border:0;padding:0;width:14.5%"></td>
    				<td style="border:0;padding:0;width:6%"></td>
    				<td style="border:0;padding:0;width:10%"></td>
    				<td style="border:0;padding:0;width:10%"></td>
    				<td style="border:0;padding:0;width:10%"></td>
    				<td style="border:0;padding:0;width:8%"></td>
    			</tr>';
            }

            if($ctk != '1'){
    			$html .= '<tr>
    				<td style="font-weight:bold;border:1px solid #000;padding:5px">NO</td>
    				<td style="font-weight:bold;border:1px solid #000;padding:5px">TANGGAL</td>
    				<td style="font-weight:bold;border:1px solid #000;padding:5px">NO SJ</td>
    				<td style="font-weight:bold;border:1px solid #000;padding:5px">CUSTOMER</td>
    				<td style="font-weight:bold;border:1px solid #000;padding:5px">UKURAN</td>
    				<td style="font-weight:bold;border:1px solid #000;padding:5px">PCS</td>
    				<td style="font-weight:bold;border:1px solid #000;padding:5px">TONASE</td>
    				<td style="font-weight:bold;border:1px solid #000;padding:5px">HARGA</td>
    				<td style="font-weight:bold;border:1px solid #000;padding:5px">SALES</td>
    				<td style="font-weight:bold;border:1px solid #000;padding:5px">NO PLAT</td>
    			</tr>';
            }

			$getQIsi = $this->db->query("SELECT a.tgl,a.no_surat,c.id AS id_pt,c.nm_perusahaan,c.pimpinan,b.ukuran,b.qty,a.no_kendaraan FROM pl_box a
			INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
			INNER JOIN m_box b ON a.id=b.id_pl
			WHERE a.no_pkb LIKE '%$jenis%' AND b.ukuran LIKE '%BOX%'
			AND a.tgl BETWEEN '$tgl1' AND '$tgl2'
            AND (a.id_perusahaan LIKE '%$tttt%')
			-- AND a.id_perusahaan != '67' AND a.id_perusahaan != '68' AND a.id_perusahaan != '69' AND a.id_perusahaan != '70' AND a.id_perusahaan != '71' AND a.id_perusahaan != '73'
			GROUP BY no_pkb,b.ukuran,no_po
			ORDER BY a.tgl ASC,a.no_pkb ASC");

			$i = 0;
			foreach($getQIsi->result() as $r){
				$i++;

				// 67  PT. DELTA DUNIA TEKSTILE 2            IBU STEFFY  
				// 68  PT. DELTA MERLIN SANDANG TEKSTIL III  IBU. OLA    
				// 69  PT. DELTA DUNIA TEKSTIL I             IBU. IRMA   
				// 70  PT. DELTA DUNIA TEKSTIL IV            BP. HENDRA  
				// 71  PT. DELTA MERLIN SANDANG TEKSTIL I    BP. ADIT    
				// 135 PT. DELTA MERLIN SANDANG TEKSTIL V    BP. ADIT    
				// 73  PT. DELTA DUNIA SANDANG TEKSTIL       BP. BENNY   
				if($r->id_pt == 67){
					$nmCus = 'PT. DDT 2';
				}else if($r->id_pt == 68){
					$nmCus = 'PT. DMST 3';
				}else if($r->id_pt == 69){
					$nmCus = 'PT. DDT 1';
				}else if($r->id_pt == 70){
					$nmCus = 'PT. DDT 4';
				}else if($r->id_pt == 71){
					$nmCus = 'PT. DMST 1';
				}else if($r->id_pt == 73){
					$nmCus = 'PT. DDST';
				}else if($r->id_pt == 135){
					$nmCus = 'PT. DMST 5';
				}else{
                    $nmCus = $r->nm_perusahaan;
                }

				if($r->no_kendaraan == '-' || $r->no_kendaraan == ''){
					$plat = '';
				}else{
					$plat = $r->no_kendaraan;
				}

                // ISI DI UKURAN
                if($r->id_pt == 82 || $r->id_pt == 98 || $r->id_pt == 101 || $r->id_pt == 108 || $r->id_pt == 110 || $r->id_pt == 114 || $r->id_pt == 116 || $r->id_pt == 118 || $r->id_pt == 120 || $r->id_pt == 122 || $r->id_pt == 125 || $r->id_pt == 126 || $r->id_pt == 127 || $r->id_pt == 134 || $r->id_pt == 136 || $r->id_pt == 137 || $r->id_pt == 139 || $r->id_pt == 140 || $r->id_pt == 142 || $r->id_pt == 143){
                    $uk = $r->ukuran;
                }else{
                    $uk = strtoupper(substr($r->ukuran, 11, 11));
                }

				$html .= '<tr>
					<td style="border:1px solid #000;padding:5px">'.$i.'</td>
					<td style="border:1px solid #000;padding:5px">'.$this->m_fungsi->tglInd_skt($r->tgl).'</td>
					<td style="border:1px solid #000;padding:5px">'.$r->no_surat.'</td>
					<td style="border:1px solid #000;padding:5px 2px">'.$nmCus.'</td>
					<td style="border:1px solid #000;padding:5px">'.$uk.'</td>
					<td class="str" style="border:1px solid #000;padding:5px">'.number_format($r->qty).'</td>
					<td style="border:1px solid #000;padding:5px"></td>
					<td style="border:1px solid #000;padding:5px"></td>
					<td style="border:1px solid #000;padding:5px"></td>
					<td style="border:1px solid #000;padding:5px">'.$plat.'</td>
				</tr>';
			}
			
		}else{
			$html .= '';
		}

		$html .= '</table>';

		$xlxs = $jenis.' - '.$tgl1.' SD '.$tgl2;

		if ($ctk == '0') {
            echo $html;
        }else if ($ctk == '1') {
			if($jenis == 'BOX'){
				// $this->m_fungsi->_mpdf2('',$html,10,10,10,'L','PENJUALAN',6);
                $this->m_fungsi->_mpdf2('',$html,10,10,10,'L','PENJUALAN',6);
			}if($jenis == 'SHEET'){
                $this->m_fungsi->newPDF($html,'L',1,$opsi);
            }else{
				echo $html;
			}
        }else{
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=$xlxs.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $data2['prev']= $html;
            $this->load->view('view_excel', $data2);
        }
	}

    function lapPenjPerPORoll() {
        $ctk = $_GET['ctk'];
        $opsi = $_GET['opsi'];

        $html = '';
        $html .= '<style>.str{mso-number-format:\@}</style>';
		$html .= '<table border="1" cellpadding="5" style="border-collapse:collapse;color:#000;margin:0;padding:0">';

		$getBulan = $this->db->query("SELECT SUBSTRING(a.tgl, 1, 7) AS bln FROM pl a
		INNER JOIN m_timbangan b ON a.id=b.id_pl
		WHERE a.tgl LIKE '%2022%'
        AND a.nm_perusahaan!='LAMINASI PPI' AND a.nm_perusahaan!='CORRUGATED PPI'
        AND a.nm_perusahaan LIKE '%RUKUN SE%'
        -- AND a.nama LIKE '% IMA%'
        -- AND a.alamat_perusahaan LIKE '% 2%'
        -- AND a.no_po LIKE '%H22E00473/STG2%'
		GROUP BY MONTH(a.tgl)");
		
		foreach($getBulan->result() as $bln){
			$html .= '<tr>
				<td colspan="4" style="background:#ffb703;text-align:center;font-weight:bold">'.strtoupper($this->m_fungsi->fgGetBulan($bln->bln)).'</td>
			</tr>';

			$getCust = $this->db->query("SELECT a.nama,a.nm_perusahaan as pt,a.no_po FROM pl a
			INNER JOIN m_timbangan b ON a.id=b.id_pl
			WHERE a.tgl LIKE '%$bln->bln%'
            AND a.nm_perusahaan!='LAMINASI PPI' AND a.nm_perusahaan!='CORRUGATED PPI'
            AND a.nm_perusahaan LIKE '%RUKUN SE%'
            -- AND a.nama LIKE '% IMA%'
            -- AND a.alamat_perusahaan LIKE '% 2%'
            -- AND a.no_po LIKE '%H22E00473/STG2%'
			GROUP BY a.nama,a.nm_perusahaan,a.no_po
			ORDER BY a.nama,a.nm_perusahaan,a.no_po");
			$sum_tot = 0;
			foreach($getCust->result() as $cust){
                if($cust->pt == "-" || $cust->pt == ""){
                    $ptTitle = $cust->nama;
                }else{
                    $ptTitle = $cust->pt;
                }
				$html .= '<tr>
					<td colspan="4" style="background:#495057;color:#fff;font-weight:bold">'.$ptTitle.'</td>
				</tr>
				<tr>
					<td style="text-align:center">No</td>
					<td style="text-align:center">Tanggal</td>
					<td style="text-align:center">Surat Jalan</td>
					<td style="text-align:center">Tonase</td>
				</tr>';

				$getPo = $this->db->query("SELECT a.nm_perusahaan,a.no_po FROM pl a
				INNER JOIN m_timbangan b ON a.id=b.id_pl
				WHERE a.tgl LIKE '%$bln->bln%' AND a.nm_perusahaan='$cust->pt' AND a.nama='$cust->nama' AND a.no_po='$cust->no_po'
				GROUP BY a.no_po ASC");
				$sum_po = 0;
				foreach($getPo->result() as $po){
					$html .= '<tr>
						<td colspan="4" style="background:#adb5bd;font-weight:bold">'.$po->no_po.'</td>
					</tr>';

					$getList = $this->db->query("SELECT a.tgl,a.no_surat,a.no_pkb,SUM(b.weight) AS berat FROM pl a
					INNER JOIN m_timbangan b ON a.id=b.id_pl
					WHERE a.tgl LIKE '%$bln->bln%' AND a.nm_perusahaan='$cust->pt' AND a.nama='$cust->nama' AND a.no_po='$po->no_po'
					GROUP BY a.tgl,a.no_pkb,a.no_po ASC");
					$l = 0;
					$sumBerat = 0;
					foreach($getList->result() as $list){
						$l++;

                        if($opsi != ''){
                            $tmpBerat = "";
                        }else{
                            $tmpBerat = number_format($list->berat);
                        }

						$html .= '<tr>
							<td style="text-align:center">'.$l.'</td>
							<td style="text-align:center">'.$this->m_fungsi->tglInd_skt($list->tgl).'</td>
							<td style="text-align:center">'.trim($list->no_surat).'</td>
							<td class="str" style="text-align:right">'.$tmpBerat.'</td>
						</tr>';
						$sumBerat += $list->berat;

                        if($opsi != ''){
                            $getRin = $this->db->query("SELECT a.tgl,a.no_pkb,a.no_po,b.nm_ker,b.g_label,b.width,COUNT(b.roll) AS jml_roll,SUM(b.weight) AS l_berat FROM pl a
                            INNER JOIN m_timbangan b ON a.id=b.id_pl
                            WHERE a.tgl='$list->tgl' AND a.no_pkb='$list->no_pkb' AND a.no_po='$po->no_po'
                            GROUP BY a.tgl,a.no_pkb,a.no_po,b.nm_ker,b.g_label,b.width");
                            $sum_list = 0;
                            foreach($getRin->result() as $rinc){
                                $html .= '<tr>
                                    <td style="border:0;text-align:center">-</td>
                                    <td style="border:0" colspan="2">'.$rinc->g_label.' GSM - '.$rinc->nm_ker.' - LB '.round($rinc->width,2).' - '.$rinc->jml_roll.' ROLL</td>
                                    <td class="str" style="border:0;text-align:right">'.number_format($rinc->l_berat).'</td>
                                </tr>';
                                $sum_list += $rinc->l_berat;
                            }
                            $html .= '<tr>
                                <td colspan="4" class="str" style="border:0;text-align:right;font-weight:bold">'.number_format($sum_list).'</td>
                            </tr>';
                        }else{
                            $html .= '';
                        }
					}

					if($getList->num_rows() == 1){
						$html .= '';
					}else if($getList->num_rows() > 1 && $getPo->num_rows() == 1){
						$html .= '';
					}else{
						$html .= '<tr>
							<td colspan="3" style="text-align:center">Total</td>
							<td class="str" style="text-align:right;font-weight:bold">'.number_format($sumBerat).'</td>
						</tr>';
					}
					$sum_po += $sumBerat;
				}

                $sum_tot += $sum_po;

                if($getCust->num_rows() == 1){
                    $html .= '';
                }else{
                    $html .= '<tr>
                        <td colspan="3" style="text-align:center">Total Keseluruhan PO</td>
                        <td class="str" style="text-align:right;font-weight:bold">'.number_format($sum_po).'</td>
                    </tr>';
                }
			}
			$html .= '<tr>
				<td colspan="3" style="text-align:center;font-weight:bold">KESELURUHAN BULAN '.strtoupper($this->m_fungsi->fgGetBulan($bln->bln)).'</td>
				<td class="str" style="text-align:right;font-weight:bold">'.number_format($sum_tot).'</td>
			</tr>';
            // $html .= '<tr>
            //     <td colspan="4"></td>
            // </tr>';
		}

        $html .= '</table>';

        if ($ctk == '0') {
            echo $html;
        }else{
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=PerPO.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $data2['prev']= $html;
            $this->load->view('view_excel', $data2);
        }
    }

	function lapPiutangInvoice() {
		$tgl = $_GET['tgl'];
		$kepada = $_GET['kepada'];
        $ctk = $_GET['ctk'];

        $date = date('Y-m-d');

        $html = '';

		// AMBIL KEPADA / PT.
		$sqlGetKepada = $this->db->query("SELECT tgl,id_pt,kepada,nm_perusahaan FROM invoice_header
		WHERE id_pt LIKE '%$kepada%' AND tgl LIKE '%$tgl%'
		GROUP BY id_pt ORDER BY kepada,nm_perusahaan");

		foreach($sqlGetKepada->result() as $getKpd){
			$html .= '<style>.str{mso-number-format:\@}</style>';
			$html .= '<table style="font-size:11px;width:100%;border-collapse:collapse;color:#000;text-align:center;margin:0;padding:0;vertical-align:middle">';

			// KOP
			$html .= '<tr>
				<td style="border:0;padding:0;width:10%"></td>
				<td style="border:0;padding:0;width:18%"></td>
				<td style="border:0;padding:0;width:8%"></td>
				<td style="border:0;padding:0;width:8%"></td>
				<td style="border:0;padding:0;width:12%"></td>
				<td style="border:0;padding:0;width:10%"></td>
				<td style="border:0;padding:0;width:10%"></td>
				<td style="border:0;padding:0;width:12%"></td>
				<td style="border:0;padding:0;width:12%"></td>
			</tr>';

            // NON PPN - PPN - PPH22
            $sqlGetNPH = $this->db->query("SELECT id_pt,ppn,kepada,nm_perusahaan FROM invoice_header WHERE id_pt='$getKpd->id_pt' AND tgl LIKE '%$tgl%'GROUP BY ppn");
            foreach($sqlGetNPH->result() as $nph){
                if($nph->kepada != '-' && $nph->nm_perusahaan != '-'){
                    $ptpt = $nph->kepada.' - '.$nph->nm_perusahaan;
                }else if($nph->kepada == '-' && $nph->nm_perusahaan != '-'){
                    $ptpt = $nph->nm_perusahaan;
                }else if($nph->kepada != '-' && $nph->nm_perusahaan == '-'){
                    $ptpt = $nph->kepada;
                }else{
                    $ptpt = $nph->nm_perusahaan;
                }

                if($nph->ppn == 1){
                    $notppn = 'PPN';
                }else if($nph->ppn == 2){
                    $notppn = 'PPH22';
                }else{
                    $notppn = 'NON PPN';
                }

                $html .= '<tr>
                    <td style="border:0;padding:0 0 10px;font-weight:bold;text-align:left" colspan="9">'.$ptpt.' - '.$notppn.'</td>
                </tr>';

                // GET BULAN
                $sqlGetBulan = $this->db->query("SELECT SUBSTRING(tgl, 1, 7) AS get_bulan,id_pt,ppn FROM invoice_header
                WHERE id_pt='$nph->id_pt' AND ppn='$nph->ppn' AND tgl LIKE '%$tgl%'
                GROUP BY MONTH(tgl)");
                foreach($sqlGetBulan->result() as $getBln){
                    // $html .= '<tr>
                    //     <td style="border:0;padding:0 0 10px;font-weight:bold;text-align:left" colspan="9">'.$getBln->get_bulan.'</td>
                    // </tr>';

                	$html .= '<tr style="background:#e76f51">
                		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">TGL</td>
                		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">NO INVOICE</td>
                		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">BERAT</td>
                		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">HARGA</td>
                		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">TOTAL</td>
                		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">J.TEMPO</td>
                		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px 0">TGL BAYAR</td>
                		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">PAID</td>
                		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px 0">KOM.PIUTANG</td>
                	</tr>';

                	// GET NO INVOICE DULU
                	$sqlGetNoInv = $this->db->query("SELECT head.id,head.tgl,head.jto,head.no_invoice,
                	(SELECT COUNT(*) FROM invoice_harga li
                	WHERE head.no_invoice=li.no_invoice) AS cnt,head.id_pt,head.ppn
                	FROM invoice_header head
                	WHERE head.id_pt='$getBln->id_pt' AND head.ppn='$getBln->ppn' AND head.tgl LIKE '%$getBln->get_bulan%'
                	GROUP BY head.no_invoice");
                    
                    $tottot = 0;
                    $totKomPiutang = 0;
                    $totAllBerat = 0;
                    $totAllPaid = 0;
                	foreach($sqlGetNoInv->result() as $getInv){
                		if($getInv->cnt == 1){
                			$rs = 'rowspan="2"';
                		}else{
                			$ss = $getInv->cnt + 1;
                			$rs = 'rowspan="'.$ss.'"';
                		}

                        if($date == $getInv->jto){
                            $bgjtinv = '';
                        }else if($date <= $getInv->jto){
							$bgjtinv = '';
                        }else if($date >= $getInv->jto){
                            $bgjtinv = 'background:#ffb703;';
                        }

                		$html .= '<tr>
                			<td style="border:1px solid #000;padding:5px 0" '.$rs.'>'.$this->m_fungsi->tglInd_skt($getInv->tgl).'</td>
                			<td style="border:1px solid #000;padding:5px 1px" '.$rs.'>'.$getInv->no_invoice.'</td>
                			<td style="border:1px solid #000;border-width:0 1px;padding:0"></td>
                			<td style="border:1px solid #000;border-width:0 1px;padding:0"></td>
                			<td style="border:1px solid #000;border-width:0 1px;padding:0"></td>
                			<td style="'.$bgjtinv.'border:1px solid #000;padding:5px" '.$rs.'>'.$this->m_fungsi->tglInd_skt($getInv->jto).'</td>';
                        
                            $getBayar = $this->db->query("SELECT*FROM invoice_pay WHERE no_invoice='$getInv->no_invoice' ORDER BY id");
                            $html .='<td style="border:1px solid #000;padding:2px 0;line-height:1.8" '.$rs.'>';
                                foreach($getBayar->result() as $tglpay){
                                    $html .= $this->m_fungsi->tglInd_skt($tglpay->tgl_bayar).'<br/>';
                                }
                            $html .='</td>';

                            $html .='<td style="border:1px solid #000;padding:2px 0;line-height:1.8" '.$rs.'>';
                                $totpay = 0;
                                $subpay = 0;
                                foreach($getBayar->result() as $jmlPay){
                                    $html .= number_format($jmlPay->jumlah).'<br/>';
                                    $totpay += $jmlPay->jumlah;
                                }
                                $subpay += $totpay;
                            $html .='</td>';

                            $getKomPiu = $this->db->query("SELECT SUM(li.weight) AS berat,SUM(li.seset) AS seset,p.harga, h.* FROM invoice_header h
                            INNER JOIN invoice_list li ON h.no_invoice = li.no_invoice
                            INNER JOIN invoice_harga p ON li.no_invoice = p.no_invoice AND li.no_po=p.no_po AND li.nm_ker=p.nm_ker AND li.g_label=p.g_label
                            WHERE h.no_invoice='$getInv->no_invoice'
                            GROUP BY h.no_invoice,li.no_po,li.nm_ker DESC,li.g_label");
                            $html .='<td style="border:1px solid #000;padding:0;line-height:1.8" '.$rs.'>';
                                $totTerbilang2 = 0;
                                foreach($getKomPiu->result() as $jmlPay){
                                    $beratMinSst2 = $jmlPay->berat - $jmlPay->seset;
                                    $totBeratXHarga2 = $beratMinSst2 * $jmlPay->harga;
                                    if ($jmlPay->ppn == 1) { // PPN 10%
                                        $terbilang2 = $totBeratXHarga2 + (0.1 * $totBeratXHarga2);
                                    } else if ($jmlPay->ppn == 2) { // PPH22
                                        $terbilang2 = $totBeratXHarga2 + (0.1 * $totBeratXHarga2) + (0.01 * $totBeratXHarga2);
                                    } else { // NON PPN
                                        $terbilang2 = $totBeratXHarga2;
                                    }
                                    $totTerbilang2 += $terbilang2;
                                }

                                $i_komPiutang = $totTerbilang2 - $totpay;
                                $html .= number_format($i_komPiutang).'<br/>';
                            $html .='</td>';
                        $html .='</tr>';
                        
                		// GET ISI
                		$sqlIsi = $this->db->query("SELECT SUM(li.weight) AS berat,SUM(li.seset) AS seset,p.harga, h.* FROM invoice_header h
                		INNER JOIN invoice_list li ON h.no_invoice = li.no_invoice
                		INNER JOIN invoice_harga p ON li.no_invoice = p.no_invoice AND li.no_po=p.no_po AND li.nm_ker=p.nm_ker AND li.g_label=p.g_label
                		WHERE h.id='$getInv->id' AND h.id_pt='$getInv->id_pt' AND h.ppn='$getInv->ppn' AND h.tgl LIKE '%$getInv->tgl%'
                		GROUP BY h.no_invoice,li.no_po,li.nm_ker DESC,li.g_label");
                		$totTerbilang = 0;
                        $subBerat = 0;
                		foreach($sqlIsi->result() as $isi){
                			$beratMinSst = $isi->berat - $isi->seset;
                			$html .= '<tr>
                				<td style="border:1px solid #000;border-width:0 1px 1px;padding:5px 3px">'.number_format($beratMinSst).'</td>
                				<td style="border:1px solid #000;border-width:0 1px 1px;padding:5px 3px">'.number_format($isi->harga).'</td>';
                            
                			// TENTUKAN TOTAL
                			$totBeratXHarga = $beratMinSst * $isi->harga;
                			if ($isi->ppn == 1) { // PPN 10%
                				$terbilang = $totBeratXHarga + (0.1 * $totBeratXHarga);
                			}else if ($isi->ppn == 2) { // PPH22
                				$terbilang = $totBeratXHarga + (0.1 * $totBeratXHarga) + (0.01 * $totBeratXHarga);
                			}else { // NON PPN
                				$terbilang = $totBeratXHarga;
                			}
        
                			$html .='<td style="border:1px solid #000;border-width:0 1px 1px;padding:5px 3px">'.number_format($terbilang).'</td>
                			</tr>';
                			// $html .='</tr>';
                            
                            $subBerat += $beratMinSst;
                			$totTerbilang += $terbilang;
                		}

                        $totAllBerat += $subBerat;
                        $tottot += $totTerbilang;
                        $totKomPiutang += $i_komPiutang;
                        $totKomPiutang += 0;
                        $totAllPaid += $subpay;
                	}

                    $html .= '<tr style="background:#e76f51">
                		<td style="border:1px solid #000;font-weight:bold;border-width:1px 0 1px 1px;padding:5px" colspan="2"></td>
                		<td style="border:1px solid #000;font-weight:bold;border-width:1px 0;padding:5px 0">'.number_format($totAllBerat).'</td>
                		<td style="border:1px solid #000;font-weight:bold;border-width:1px 0;padding:5px"></td>
                		<td style="border:1px solid #000;font-weight:bold;border-width:1px 0;padding:5px 0">'.number_format($tottot).'</td>
                		<td style="border:1px solid #000;font-weight:bold;border-width:1px 0;padding:5px" colspan="2"></td>
                		<td style="border:1px solid #000;font-weight:bold;border-width:1px 0;padding:5px 0">'.number_format($totAllPaid).'</td>
                		<td style="border:1px solid #000;font-weight:bold;border-width:1px 1px 1px 0;padding:5px 0">'.number_format($totKomPiutang).'</td>
                	</tr>';

                	$html .= '<tr>
                		<td style="padding:10px" colspan="9"></td>
                	</tr>';
                }
            }

			$html .= '</table>';
			$html .= '<div style="page-break-after:always"></div>';
		}

        if ($ctk == '0') {
            echo $html;
        }else if ($ctk == '1') {
			// $this->m_fungsi->_mpdf2('',$html,10,10,10,'L','PENJUALAN','');
			$this->m_fungsi->newPDF($html,'P',88,0);
        }else{
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=judul.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $data2['prev']= $html;
            $this->load->view('view_excel', $data2);
        }
	}

	function CariPoCorr(){
		$plh_corr = $_POST['plh_corr'];
		$cari = $_POST['cari'];

		$html = '';
		$html .= '<table style="width:100%;color:#000">
			<tr>
				<td style="width:5%;"></td>
				<td style="width:55%;"></td>
				<td style="width:14%;"></td>
				<td style="width:5%;"></td>
				<td style="width:8%;"></td>
				<td style="width:8%;"></td>
				<td style="width:5%;"></td>
			</tr>';

		if($plh_corr && $cari){
			if($plh_corr == 'box'){
				$n1 = "AND a.po='box'";
			}else if($plh_corr == 'sheet'){
				$n1 = "AND (a.po IS NULL OR a.po='sheet')";
			}else{
				$n1 = "";
			}
			$data = $this->db->query("SELECT a.*,b.nm_perusahaan,b.pimpinan FROM po_box_master a
			INNER JOIN m_perusahaan b ON a.id_perusahaan=b.id
			WHERE (b.nm_perusahaan LIKE '%$cari%' OR b.pimpinan LIKE '%$cari%' OR a.no_po LIKE '%$cari%') $n1
			GROUP BY b.nm_perusahaan ASC");
			foreach($data->result() as $d){
				if($d->pimpinan == '-'){
					$dNmpt = $d->nm_perusahaan.' - '.$d->id_perusahaan;
				}else{
					$dNmpt = $d->nm_perusahaan.' - '.$d->pimpinan.' - '.$d->id_perusahaan;
				}
				$html .= '<tr>
					<td colspan="7" style="background:#333;border:1px solid #333;color:#fff;font-weight:bold;padding:5px">'.$dNmpt.'</td>
				</tr>';

				$getPO = $this->db->query("SELECT*FROM po_box_master
				WHERE id_perusahaan='$d->id_perusahaan' AND status='open'
				GROUP BY id_po,no_po ASC,status");
				// foreach($getPO->result() as $po){
				// 	$html .= '<tr>
				// 		<td colspan="7" style="border:1px solid #ccc;background:#ccc;font-weight:bold;padding:5px">'.$po->no_po.'</td>
				// 	</tr>';

				// 	$getUk = $this->db->query("SELECT*FROM po_box_master
                //     WHERE id_perusahaan='$po->id_perusahaan' AND id_po='$po->id_po' AND status='open'
                //     GROUP BY no_po, id ASC");
				// 	$i = 0;
				// 	foreach($getUk->result() as $uk){
				// 		$i++;
				// 		if($plh_corr == 'box'){
				// 			$html .= '<tr>
				// 				<td style="border:1px solid #ccc;padding:5px;text-align:center">'.$i.'</td>
				// 				<td style="border:1px solid #ccc;padding:5px">'.$uk->ukuran.'</td>
				// 				<td style="border:1px solid #ccc;padding:5px">'.$uk->f_k.'/'.$uk->f_b.'/'.$uk->f_cl.'/'.$uk->f_c.'/'.$uk->f_bl.'</td>
				// 				<td style="border:1px solid #ccc;padding:5px 0;text-align:center">'.$uk->flute.'</td>
				// 				<td style="border:1px solid #ccc;padding:5px;text-align:right">'.number_format($uk->qty).'</td>
				// 				<td style="border:1px solid #ccc;padding:5px;text-align:right">'.number_format($uk->harga).'</td>
				// 				<td style="border:1px solid #ccc;padding:5px"></td>
				// 			</tr>';
				// 		}else if($plh_corr == 'sheet'){
				// 			$exUkuran = explode('.',$uk->ukuran);
				// 			$exUk = explode("X", trim($exUkuran[0]));

				// 			if($getUk->num_rows() > 0){
				// 				if($uk->f_k == "" && $uk->f_b == "" && $uk->f_cl == "" && $uk->f_c == "" && $uk->f_bl == ""){
				// 					$bb = "-";
				// 				}else{
				// 					$x_b = round($uk->f_b * 1.36, 2);
				// 					$x_c = round($uk->f_c * 1.46, 2);
				// 					if($uk->flute == "CB" || $uk->flute == "BC"){
				// 						$fl = round(($uk->f_k + $x_b + $uk->f_cl + $x_c + $uk->f_bl) / 1000, 2);
				// 					}else if($uk->flute == "CF" || $uk->flute == "FC" || $uk->flute == "C"){
				// 						$fl = round(($uk->f_k + $x_c + $uk->f_bl) / 1000, 2);
				// 					}else if($uk->flute == "BF" || $uk->flute == "FB" || $uk->flute == "B"){
				// 						$fl = round(($uk->f_k + $x_b + $uk->f_bl) / 1000, 2);
				// 					}else{
				// 						$fl = 0;
				// 					}
				// 					$bb = round($fl * ($exUk[0] / 1000) * ($exUk[1] / 1000), 2);
				// 				}
				// 			}else{
				// 				$bb = "-";
				// 			}
				// 			$html .= '<tr>
				// 				<td style="border:1px solid #ccc;padding:5px;text-align:center">'.$i.'</td>
				// 				<td style="border:1px solid #ccc;padding:5px">'.$exUkuran[0].'</td>
				// 				<td style="border:1px solid #ccc;padding:5px">'.$uk->f_k.'/'.$uk->f_b.'/'.$uk->f_cl.'/'.$uk->f_c.'/'.$uk->f_bl.'</td>
				// 				<td style="border:1px solid #ccc;padding:5px 0;text-align:center">'.$uk->flute.'</td>
				// 				<td style="border:1px solid #ccc;padding:5px;text-align:right">'.number_format($uk->qty).'</td>
				// 				<td style="border:1px solid #ccc;padding:5px;text-align:right">'.number_format($uk->harga).'</td>
				// 				<td style="border:1px solid #ccc;padding:5px 0;text-align:center">'.number_format($bb, 2).'</td>
				// 			</tr>';
				// 		}else{
				// 			$html .= "";
				// 		}
						
				// 		$getUkItem = $this->db->query("SELECT a.tgl,a.no_surat,a.no_po,a.no_kendaraan,a.sj AS cek_sj,a.sj_blk,b.ukuran,b.flute,b.qty,b.ket FROM pl_box a
                //         INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
                //         INNER JOIN m_box b ON a.id=b.id_pl
                //         INNER JOIN po_box_master d ON a.no_po=d.no_po
                //         WHERE a.id_perusahaan='$uk->id_perusahaan' AND a.no_po='$uk->no_po' AND b.ukuran='$uk->ukuran' AND b.flute='$uk->flute'
                //         GROUP BY a.no_po,a.no_surat,b.ukuran,b.flute
                //         ORDER BY a.tgl");

				// 		if($getUkItem->num_rows() == 0){
				// 			$html .= '';
				// 		}else{
				// 			$sumQty = 0;
				// 			foreach($getUkItem->result() as $ukitem){
				// 				$exUkItem = explode("/",$ukitem->no_surat);
				// 				$html .= '<tr>
				// 					<td style="border-left:1px solid #ccc;text-align:center">-</td>
				// 					<td style="padding:5px" colspan="3">'.strtoupper($this->m_fungsi->tglInd_skt($ukitem->tgl)).' - SJ:'.$exUkItem[0].' - '.$ukitem->no_kendaraan.'</td>
				// 					<td style="padding:5px;text-align:right">'.number_format($ukitem->qty).'</td>
				// 					<td style="border-right:1px solid #ccc;text-align:center" colspan="2">'.$ukitem->ket.'</td>
				// 				</tr>';
				// 				$sumQty += $ukitem->qty;
				// 				$sumQtyPO = $sumQty - $uk->qty;
				// 			}

				// 			if($uk->qty >= $sumQty){
				// 				if($uk->status == "close"){
				// 					$kqp = '';
				// 					$bgc = 'background:#F87115;';
				// 				}else{
				// 					$kqp = '';
				// 					$bgc = 'background:#74c69d;';
				// 				}
				// 			}else{
				// 				$kqp = '+';
				// 				$bgc = 'background:#ff758f;';
				// 			}
				// 			$html .= '<tr>
				// 				<td style="border:1px solid #ccc;border-width:0 0 1px 1px;padding:5px;text-align:right" colspan="5">total: '.number_format($sumQty).'</td>
				// 				<td style="border:1px solid #ccc;border-width:0 1px 1px 0;'.$bgc.'text-align:center" colspan="2">'.$kqp.''.number_format($sumQtyPO).'</td>
				// 			</tr>';
				// 		}
				// 	}
				// }
			}
		}else{
			$html .= '<tr>
					<td colspan="7" style="border:1px solid #ccc;background:#ccc;font-weight:bold;padding:5px">Tidak Ada Data...</td>
				</tr>';
		}

		$html .= '</table>';

		echo $html;
	}

    function lapPenjualanPO() {
        $po = $_GET['po'];
		$pt = $_GET['pt'];
        $ctk = $_GET['ctk'];
        $opsi = $_GET['opsi'];

        $html = '';
		$html .= '<style>.str{mso-number-format:\@}</style>';

        // BOX
        if($opsi == 3 || $opsi == 4){
            $html .= '<table style="border-collapse:collapse" border="1" cellpadding="5">';
            $sqlBOX = $this->db->query("SELECT a.id_perusahaan,c.nm_perusahaan,c.pimpinan FROM po_box_master a
            INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
            WHERE a.po='box'
            GROUP BY a.id_perusahaan
            ORDER BY c.nm_perusahaan");
            foreach($sqlBOX->result() as $gpt){
                $html .= '<tr>
                    <td style="background:#495057;color:#fff;font-weight:bold" colspan="4">'.$gpt->nm_perusahaan.' - '.$gpt->pimpinan.' - '.$gpt->id_perusahaan.'</td>
                </tr>
                <tr>
                    <td style="text-align:center;font-weight:bold">NO</td>
                    <td style="text-align:center;font-weight:bold">UKURAN</td>
                    <td style="text-align:center;font-weight:bold">QTY</td>
                    <td style="text-align:center;font-weight:bold">HARGA</td>
                </tr>';

                $sqlBP = $this->db->query("SELECT * FROM po_box_master a
                WHERE a.id_perusahaan='$gpt->id_perusahaan' AND a.po='box'
                GROUP BY a.id_po,a.no_po");
                foreach($sqlBP->result() as $poo){
                    $html .= '<tr>
                        <td style="background:#ADB5BD;font-weight:bold" colspan="4">'.$poo->no_po.'</td>
                    </tr>';

                    $getBuk = $this->db->query("SELECT * FROM po_box_master a
                    WHERE a.id_perusahaan='$poo->id_perusahaan' AND a.no_po='$poo->no_po'
                    ORDER BY id");
                    $i = 0;
                    foreach($getBuk->result() as $ukkk){
                        $i++;
                        $html .= '<tr>
                            <td style="text-align:center">'.$i.'</td> 
                            <td>'.$ukkk->ukuran.'</td>
                            <td style="text-align:right">'.number_format($ukkk->qty,0,",",".").'</td> 
                            <td style="text-align:right">'.number_format($ukkk->harga,2,",",".").'</td> 
                        </tr>';

                        $getBii = $this->db->query("SELECT a.tgl,a.no_surat,a.no_po,a.no_kendaraan,a.sj AS cek_sj,a.sj_blk,b.ukuran,b.flute,b.qty,b.ket FROM pl_box a
                        INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
                        INNER JOIN m_box b ON a.id=b.id_pl
                        INNER JOIN po_box_master d ON a.no_po=d.no_po
                        WHERE a.id_perusahaan='$ukkk->id_perusahaan' AND a.no_po='$ukkk->no_po' AND b.ukuran='$ukkk->ukuran'
                        GROUP BY a.no_po,a.no_surat,b.ukuran,b.flute
                        ORDER BY a.tgl");
                        $sum_qty = 0;

                        if($getBii->num_rows() == 0){
                            $html .= '';
                        }else{
                            foreach($getBii->result() as $sii){
                                $exUkItem = explode("/",$sii->no_surat);
                                $html .= '<tr>
                                    <td style="text-align:center;border:0" >-</td> 
                                    <td style="border:0">'.strtoupper($this->m_fungsi->tglInd_skt($sii->tgl)).' - SJ:'.$exUkItem[0].' - '.$sii->no_kendaraan.'</td>
                                    <td style="text-align:right;border:0">'.number_format($sii->qty,0,",",".").'</td> 
                                    <td style="text-align:center;border:0">'.$sii->ket.'</td> 
                                </tr>';
                                $sum_qty += $sii->qty;
                                $sum_qtyPO = $sum_qty - $ukkk->qty;
                            }
                            if($ukkk->qty >= $sum_qty){
                                $kqp = '';
                                $bgc = 'background:#74c69d;';
                            }else{
                                $kqp = '+';
                                $bgc = 'background:#ff758f;';
                            }
                            $html .= '<tr>
                                <td style="text-align:right;border:0" colspan="2">total</td>
                                <td style="text-align:right;border:0">'.number_format($sum_qty,0,",",".").'</td>
                                <td style="'.$bgc.'border:0">'.$kqp.''.number_format($sum_qtyPO,0,",",".").'</td>
                            </tr>';
                        }
                    }
                }
            }
        }else{ // SHEET
            $html .= '<table style="border-collapse:collapse" border="1">';
            if($po == '' && $pt == ''){
                $where = "a.id_perusahaan LIKE '%%' AND a.id_po LIKE '%%'";
            }else if($po != '' && $pt == ''){
                $where = "a.id_perusahaan LIKE '%%' AND a.id_po='$po'";
            }else if($po == '' && $pt != ''){
                $where = "a.id_perusahaan='$pt' AND a.id_po LIKE '%%'";
            }else{
                $where = "a.id_perusahaan='$pt' AND a.id_po='$po'";
            }

            $getPT = $this->db->query("SELECT a.*,b.nm_perusahaan FROM po_box_master a
            INNER JOIN m_perusahaan b ON a.id_perusahaan=b.id
            WHERE $where AND (po IS NULL OR po='sheet')
            GROUP BY b.nm_perusahaan ASC");
            foreach($getPT->result() as $prepet){
                if($opsi == 2){
                    $colspan = 8;
                    $tsk = '<td style="padding:5px;font-weight:bold;text-align:center">TOTAL KIRIM</td>';
                }else{
                    $colspan = 7;
                    $tsk = '';
                }

                // - '.$prepet->id_perusahaan.'
                $html .= '<tr>
                    <td style="background:#495057;color:#fff;padding:5px;font-weight:bold" colspan="'.$colspan.'">'.$prepet->nm_perusahaan.' - '.$prepet->id_perusahaan.'</td>
                </tr>';

                $html .= '<tr>
                    <td style="padding:5px;font-weight:bold;text-align:center">NO</td>
                    <td style="padding:5px;font-weight:bold;text-align:center">UKURAN</td>
                    <td style="padding:5px;font-weight:bold;text-align:center">SUBSTANCE</td>
                    <td style="padding:5px;font-weight:bold;text-align:center">FLUTE</td>
                    <td style="padding:5px;font-weight:bold;text-align:center">QTY</td>
                    '.$tsk.'
                    <td style="padding:5px;font-weight:bold;text-align:center">HARGA (Rp.)</td>
                    <td style="padding:5px;font-weight:bold;text-align:center">BB</td>
                </tr>';

                if($po == ''){
                    $getIDPO = "id_po LIKE '%%'";
                }else{
                    $getIDPO = "id_po='$prepet->id_po'";
                }
                $getPO = $this->db->query("SELECT*FROM po_box_master
                -- WHERE id_perusahaan='$prepet->id_perusahaan' AND $getIDPO
                WHERE id_perusahaan='$prepet->id_perusahaan' AND id_po LIKE '%%'
                GROUP BY id_po,no_po ASC");
                foreach($getPO->result() as $po){
                    $html .= '<tr>
                        <td style="background:#adb5bd;padding:5px;font-weight:bold" colspan="'.$colspan.'">'.$po->no_po.'</td>
                    </tr>';

                    $getUkuran = $this->db->query("SELECT*FROM po_box_master
                    WHERE id_perusahaan='$po->id_perusahaan' AND id_po='$po->id_po'
                    GROUP BY no_po, id ASC");
                    $i = 0;
                    foreach($getUkuran->result() as $uk){
                        $i++;

                        $exUkuran = explode('.',$uk->ukuran);
                        $exUk = explode("X", trim($exUkuran[0]));

                        if($getUkuran->num_rows() > 0){
                            if($uk->f_k == "" && $uk->f_b == "" && $uk->f_cl == "" && $uk->f_c == "" && $uk->f_bl == ""){
                                $bb = "-";
                            }else{
                                $x_b = round($uk->f_b * 1.36, 2);
                                $x_c = round($uk->f_c * 1.46, 2);
                                if($uk->flute == "CB" || $uk->flute == "BC"){
                                    $fl = round(($uk->f_k + $x_b + $uk->f_cl + $x_c + $uk->f_bl) / 1000, 2);
                                }else if($uk->flute == "CF" || $uk->flute == "FC" || $uk->flute == "C"){
                                    $fl = round(($uk->f_k + $x_c + $uk->f_bl) / 1000, 2);
                                }else if($uk->flute == "BF" || $uk->flute == "FB" || $uk->flute == "B"){
                                    $fl = round(($uk->f_k + $x_b + $uk->f_bl) / 1000, 2);
                                }else{
                                    $fl = 0;
                                }
                                $bb = round($fl * ($exUk[0] / 1000) * ($exUk[1] / 1000), 2);
                            }
                        }else{
                            $bb = "-";
                        }

                        if($opsi == 1){
                            $ketF = '<td class="str" style="padding:5px;text-align:center">'.$uk->f_k.'/'.$uk->f_b.'/'.$uk->f_cl.'/'.$uk->f_c.'/'.$uk->f_bl.'</td>';
                        }else{
                            $ketF = '';
                        }

                        $getUkItem = $this->db->query("SELECT a.tgl,a.no_surat,a.no_po,a.no_kendaraan,a.sj AS cek_sj,a.sj_blk,b.ukuran,b.flute,b.qty,b.ket FROM pl_box a
                        INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
                        INNER JOIN m_box b ON a.id=b.id_pl
                        INNER JOIN po_box_master d ON a.no_po=d.no_po
                        WHERE a.id_perusahaan='$uk->id_perusahaan' AND a.no_po='$uk->no_po' AND b.ukuran='$uk->ukuran' AND b.flute='$uk->flute'
                        GROUP BY a.no_po,a.no_surat,b.ukuran,b.flute
                        ORDER BY a.tgl");
                        $sum_qty = 0;
                        foreach($getUkItem->result() as $sumW){
                            $sum_qty += $sumW->qty;
                            $sum_qtyPO = $sum_qty - $uk->qty;
                        }
                        if($opsi == 2){
                            if($getUkItem->num_rows() == 0){
                                $bgc2 = '';
                                $dtlKet = 0;
                            }else{
                                if($uk->qty >= $sum_qty){
									if($uk->status == "close"){
										$kqp2 = '';
										$bgc2 = 'background:#F87115;';
									}else{
										$kqp2 = '';
										$bgc2 = 'background:#74c69d;';
									}
                                }else{
                                    $kqp2 = '+';
                                    $bgc2 = 'background:#ff758f;';
                                }

                                if($sum_qtyPO == 0){
                                    $dtlKet = number_format($sum_qty);
                                }else{
                                    $dtlKet = '<span style="float:left">'.number_format($sum_qty).'</span> '.$kqp2.''.$sum_qtyPO;
                                }
                            }
                            $tqty = '<td class="str" style="'.$bgc2.'padding:5px;text-align:right">'.$dtlKet.'</td>';
                        }else{
                            $tqty = '';
                        }

                        $html .= '<tr>
                            <td style="padding:5px;text-align:center">'.$i.'</td>
                            <td style="padding:5px">'.$exUkuran[0].'</td>
                            <td style="padding:5px">'.$exUkuran[1].'</td>
                            <td style="padding:5px;text-align:center">'.$uk->flute.'</td>
                            <td class="str" style="padding:5px;text-align:right">'.number_format($uk->qty).'</td>
                            '.$tqty.'
                            <td class="str" style="padding:5px;text-align:right">'.number_format($uk->harga).'</td>
                            <td class="str" style="padding:5px;text-align:center">'.number_format($bb, 2).'</td>
                            '.$ketF.'
                        </tr>';

                        if($getUkItem->num_rows() == 0){
                            $html .= '';
                        }else{
                            if($opsi == 2){
                                $html .= '';
                            }else{
                                $sumQty = 0;
                                foreach($getUkItem->result() as $ukitem){
                                    $exUkItem = explode("/",$ukitem->no_surat);
                                    // if($ukitem->cek_sj == 'ok' && $ukitem->sj_blk != ''){
                                    //     $sjBlk = 'border:0;border-left:3px solid #74c69d !important;';
                                    // }else{
                                    //     $sjBlk = 'border:0;';
                                    // }
                                    $html .= '<tr>
                                    <td style="border:0;text-align:center">-</td>
                                    <td style="border:0;padding:5px" colspan="3">'.strtoupper($this->m_fungsi->tglInd_skt($ukitem->tgl)).' - SJ:'.$exUkItem[0].' - '.$ukitem->no_kendaraan.'</td>
                                    <td class="str" style="border:0;padding:5px;text-align:right">'.number_format($ukitem->qty).'</td>
                                    <td style="border:0;text-align:center" colspan="2">'.$ukitem->ket.'</td>
                                    </tr>';
                                    $sumQty += $ukitem->qty;
                                    $sumQtyPO = $sumQty - $uk->qty;
                                }

                                if($uk->qty >= $sumQty){
									if($uk->status == "close"){
										$kqp = '';
										$bgc = 'background:#F87115;';
									}else{
										$kqp = '';
										$bgc = 'background:#74c69d;';
									}
                                }else{
                                    $kqp = '+';
                                    $bgc = 'background:#ff758f;';
                                }
                                $html .= '<tr>
                                    <td class="str" style="border:0;;padding:5px;text-align:right" colspan="5">total: '.number_format($sumQty).'</td>
                                    <td class="str" style="'.$bgc.'border:0;text-align:center" colspan="2">'.$kqp.''.number_format($sumQtyPO).'</td>
                                </tr>';
                            }
                        }
                    }
                }
            }
        }
		$html .= '</table>';

        if ($ctk == '0') {
            echo $html;
        }else{
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=judul.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $data2['prev']= $html;
            $this->load->view('view_excel', $data2);
        }
    }

	function lapPenjualanPOv2() {
        $ctk = $_GET['ctk'];
        $opsi = $_GET['opsi'];

		$html = '';
		$html .= '<style>.str{mso-number-format:\@}</style>';
		$html .= '<table style="border-collapse:collapse" border="1" cellpadding="5">';

        if($opsi == 2){
            $html .= '<tr>
                <td style="font-weight:bold;text-align:center">NO</td>
                <td style="font-weight:bold;text-align:center">CUSTOMER</td>
                <td style="font-weight:bold;text-align:center" colspan="3">OUTSTANDING</td>
            </tr>';
        }else{
            $html .= '<tr>
                <td style="font-weight:bold;text-align:center">CUSTOMER</td>
                <td style="font-weight:bold;text-align:center">NO PO</td>
                <td style="font-weight:bold;text-align:center">UKURAN</td>
                <td style="font-weight:bold;text-align:center">SUBSTENCE</td>
                <td style="font-weight:bold;text-align:center">FLUTE</td>
                <td style="font-weight:bold;text-align:center">QTY</td>
                <td style="font-weight:bold;text-align:center">SISA OS</td>
                <td style="font-weight:bold;text-align:center">TOTAL</td>
                <td style="font-weight:bold;text-align:center">RM</td>
            </tr>';
        }

        $getCust = $this->db->query("SELECT a.id_perusahaan,b.nm_perusahaan FROM po_box_master a
        INNER JOIN m_perusahaan b ON a.id_perusahaan=b.id
		WHERE a.po<>'box' OR a.po IS NULL OR a.po=''
        GROUP BY b.nm_perusahaan ASC");

        $i = 0;
        foreach($getCust->result() as $cust){
            $i++;

            $getPT = $this->db->query("SELECT a.*,b.nm_perusahaan FROM po_box_master a
            INNER JOIN m_perusahaan b ON a.id_perusahaan=b.id
            WHERE a.id_perusahaan='$cust->id_perusahaan'
            GROUP BY a.id_perusahaan,a.id_po,a.no_po,a.ukuran,a.flute
            ORDER BY b.nm_perusahaan,a.id_po,a.no_po,a.id");

            $sumOS = 0;
            $totTot = 0;
            $sumRM = 0;
            foreach($getPT->result() as $pt){

                $getKiriman = $this->db->query("SELECT a.tgl,a.no_surat,a.no_po,a.no_kendaraan,a.sj AS cek_sj,a.sj_blk,b.ukuran,b.flute,b.qty,b.ket,d.nm_perusahaan FROM pl_box a
                INNER JOIN m_box b ON a.id=b.id_pl
                INNER JOIN po_box_master c ON a.no_po=c.no_po
                INNER JOIN m_perusahaan d ON a.id_perusahaan=d.id
                WHERE a.id_perusahaan='$pt->id_perusahaan' AND a.no_po='$pt->no_po' AND b.ukuran='$pt->ukuran' AND b.flute='$pt->flute'
                GROUP BY a.tgl,a.no_po,a.no_surat,b.ukuran,b.flute");

                $sumTot = 0;
                foreach($getKiriman->result() as $sumKir){
                    $sumTot += $sumKir->qty;
                }
                
                // RM
                $x_uk = explode(".",$pt->ukuran);
                $x_uk_pl = explode("X",$x_uk[0]);
                $outXqty = (floor(1775 / $x_uk_pl[1])) * $pt->qty;
                $getRM = round(($x_uk_pl[0] / 1000) * $outXqty);
                
                // OS - TOTAL
                $getOS = $pt->qty - $sumTot;
                $duaPers = round(($pt->qty * 2) / 100);
                $qtyDuaPersen = $pt->qty - $duaPers;

                // if($pt->qty > $sumTot){
                if($qtyDuaPersen > $sumTot){
                    $sisaOS = $getOS;
                    $totQty = $pt->qty;
                    $rm = $getRM;
                }else{
                    $sisaOS = 0;
                    $totQty = 0;
                    $rm = 0;
                }

                if($sisaOS == 0){
                    $llsisaOS = '-';
                }else{
                    $llsisaOS = number_format($sisaOS);
                }
                if($totQty == 0){
                    $lltotQty = '-';
                }else{
                    $lltotQty = number_format($totQty);
                }
                if($rm == 0){
                    $llrm = '-';
                }else{
                    $llrm = number_format($rm);
                }

                if($opsi == 2){
                    $html .= '';
                }else{
                    $html .= '<tr>
                        <td>'.$pt->nm_perusahaan.'</td>
                        <td>'.$pt->no_po.'</td>
                        <td>'.$x_uk[0].'</td>
                        <td>'.$x_uk[1].'</td>
                        <td style="text-align:center">'.$pt->flute.'</td>
                        <td class="str" style="text-align:right">'.number_format($pt->qty).'</td>
                        <td class="str" style="text-align:right">'.$llsisaOS.'</td>
                        <td class="str" style="text-align:right">'.$lltotQty.'</td>
                        <td class="str" style="text-align:right">'.$llrm.'</td>
                    </tr>';
                }

                
                if($opsi == 1 || $opsi == 2){
                    $html .= '';
                }else{
                    foreach($getKiriman->result() as $list){
                        $x_sj = explode("/",$list->no_surat);
                        $html .= '<tr>
                            <td>'.$list->nm_perusahaan.'</td>
                            <td class="str">'.$list->no_po.'</td>
                            <td colspan="3" style="border:0">- '.strtoupper($this->m_fungsi->tglInd_skt($list->tgl)).' - SJ:'.$x_sj[0].' - '.$list->no_kendaraan.'</td>
                            <td class="str" style="border:0;text-align:right">'.number_format($list->qty).'</td>
                        </tr>';
                    }
                }

                $sumOS += $sisaOS;
                $totTot += $totQty;
                $sumRM += $rm;
            }

            if($sumOS == 0){
                $tsumOS = '-';
            }else{
                $tsumOS = number_format($sumOS);
            }
            if($totTot == 0){
                $ttotTot = '-';
            }else{
                $ttotTot = number_format($totTot);
            }
            if($sumRM == 0){
                $tsumRM = '-';
            }else{
                $tsumRM = number_format($sumRM);
            }
            if($opsi == 2){
                $html .= '<tr>
                    <td style="text-align:center">'.$i.'</td>
                    <td>'.$cust->nm_perusahaan.'</td>
                    <td class="str" style="text-align:right">'.$tsumOS.'</td>
                    <td class="str" style="text-align:right">'.$ttotTot.'</td>
                    <td class="str" style="text-align:right">'.$tsumRM.'</td>
                </tr>';
            }else{
                $html .= '<tr>
                    <td>'.$cust->nm_perusahaan.'</td>
                    <td colspan="5"></td>
                    <td class="str" style="text-align:right">'.$tsumOS.'</td>
                    <td class="str" style="text-align:right">'.$ttotTot.'</td>
                    <td class="str" style="text-align:right">'.$tsumRM.'</td>
                </tr>';
            }
        }

        $html .= '</table>';

		if ($ctk == '0') {
            echo $html;
        }else if ($ctk == '1') {
            echo $html;
			// $this->m_fungsi->_mpdf2('',$html,10,10,10,'L','PENJUALAN','');
        }else{
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=judul.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $data2['prev']= $html;
            $this->load->view('view_excel', $data2);
        }
	}

    function newPenPO() {
		$pt = $_POST['id'];
		$id_po = $_POST['id_po'];
		$no_po = $_POST['no_po'];
		$opsi = $_POST['opsi'];
		$ctk = $_POST['ctk'];
		$html = '';

        $getPT = $this->db->query("SELECT * FROM po_master a
        INNER JOIN m_perusahaan b ON a.id_perusahaan=b.id
        WHERE a.id_perusahaan='$pt' AND a.id_po='$id_po' AND a.no_po='$no_po' AND status='$opsi'
        -- AND a.tgl LIKE '%2022-11%'
        GROUP BY a.id_perusahaan,a.tgl,a.no_po");
        if($getPT->num_rows() == 0){
            $html .='<div style="padding:5px">Data Tidak Ditemukan!.</div>';
        }else{
            foreach($getPT->result() as $pt){
                $html .= '<style>#i{mso-number-format:\@}</style>';
                $html .= '<div class="scroll-horizontal">
                    <table style="font-size:12px;color:#000;vertical-align:middle;border-collapse:collapse;border-color:#555" border="1">';

                // $html .= '<tr><td style="font-weight:bold;border:0" colspan="5">'.$pt->no_po.'</td></tr>';

                $getTgl = $this->db->query("SELECT b.tgl FROM m_timbangan a
                INNER JOIN pl b ON a.id_pl=b.id
                WHERE b.no_po='$pt->no_po'
                -- AND b.tgl LIKE '%2022-11%'
				AND b.qc='ok'
                GROUP BY b.tgl");

                $html .= '<tr>
                    <td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold" rowspan="3">No.</td>
                    <td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold" rowspan="3">GSM</td>
                    <td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold" rowspan="3">UK</td>
                    <td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold" colspan="2" rowspan="2">ORDER</td>';
                foreach($getTgl->result() as $tTgl){
                    $html .= '<td style="padding:5px;background:#B9E9FB;font-weight:bold;text-align:center" colspan="2">'.strtoupper($this->m_fungsi->getHariIni($tTgl->tgl)).'</td>';
                }
                $html .= '<td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold" colspan="2" rowspan="2">TOTAL</td>
                    <td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold" colspan="2" rowspan="2">( + / - )</td>
                </tr>'; // TOTAL

                $html .= '<tr>';
                foreach($getTgl->result() as $tTgl){
                    $html .= '<td style="padding:5px;background:#B9E9FB;font-weight:bold;text-align:center" colspan="2">'.strtoupper($this->m_fungsi->tglInd_skt($tTgl->tgl)).'</td>';
                }
                $html .= '</tr>';
                
                // ROLL, TON
                $html .= '<tr>
                    <td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold">ROLL</td>
                    <td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold">TON</td>';
                foreach($getTgl->result() as $tTgl){ // ISI PER UKURAN
                    $html .= '<td style="padding:5px;background:#B9E9FB;text-align:center;font-weight:bold">ROLL</td>
                    <td style="padding:5px;background:#B9E9FB;text-align:center;font-weight:bold">TON</td>';
                }
                // TOTAL, + -
                $html .= '<td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold">ROLL</td>
                    <td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold">TON</td>
                    <td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold">ROLL</td>
                    <td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold">TON</td>
                </tr>';
                
                // KOTAK KOSONG
                $html .= '<tr><td style="padding:5px;padding:0" colspan="5"></td>';
                $ik = 0;
                foreach($getTgl->result() as $tTgl){
                    $ik++;
                    $html .= '<td style="padding:5px;padding:0;text-align:center" colspan="2" id="i">'.$ik.'</td>';
                }
                $html .= '</tr>';

                // TAMPIL GSM
                $getGsm = $this->db->query("SELECT a.*,SUM(jml_roll) AS jmll,SUM(tonase) AS tonn,COUNT(a.nm_ker) AS ttl FROM po_master a
                WHERE a.no_po='$pt->no_po'
                GROUP BY a.nm_ker,a.g_label");
                $ii = 0;
                $allTotRoll = 0;
                $allTotTonn = 0;
                $allSumPlusMinRoll = 0;
                $allSumPlusMinBerat = 0;
                foreach($getGsm->result() as $rGsm){
                    $ii++;
                    if(($rGsm->nm_ker == 'MH' || $rGsm->nm_ker == 'MN') && ($rGsm->g_label == 105 || $rGsm->g_label == 110)){
                        $bgNk = '#ddf';
                    }else if(($rGsm->nm_ker == 'MH' || $rGsm->nm_ker == 'MN') && ($rGsm->g_label == 120 || $rGsm->g_label == 125)){
                        $bgNk = '#ffd';
                    }else if(($rGsm->nm_ker == 'MH' || $rGsm->nm_ker == 'MN') && $rGsm->g_label == 150){
                        $bgNk = '#fdd';
                    }else if($rGsm->nm_ker == 'WP'){
                        $bgNk = '#dfd';
                    }else{ // BK
                        $bgNk = '#fff';
                    }

                    $html .= '<tr>
                        <td style="padding:5px;text-align:center;font-weight:bold" rowspan="'.$rGsm->ttl.'" id="i">'.$ii.'</td>
                        <td style="padding:5px;text-align:center;font-weight:bold;background:'.$bgNk.'" rowspan="'.$rGsm->ttl.'" id="i">'.$rGsm->nm_ker.' '.$rGsm->g_label.'</td>';

                    // GET WIDTH
                    $getUkPO = $this->db->query("SELECT*FROM po_master
                    WHERE no_po='$rGsm->no_po' AND nm_ker='$rGsm->nm_ker' AND g_label='$rGsm->g_label'
                    ORDER BY width");
                    $sumPlusMinRoll = 0;
                    $sumPlusMinBerat = 0;
                    foreach($getUkPO->result() as $ukPO){
                        $html .= '<td style="padding:5px;text-align:center;font-weight:bold" id="i">'.round($ukPO->width,2).'</td>
                            <td style="padding:5px;text-align:center;font-weight:bold" id="i">'.number_format($ukPO->jml_roll).'</td>
                            <td style="padding:5px;text-align:right;font-weight:bold" id="i">'.number_format($ukPO->tonase).'</td>';

                        // ISI PENGIRIMAN PER UKURAN
                        foreach($getTgl->result() as $tTgl){
                            $getIsiUk = $this->db->query("SELECT b.tgl,a.nm_ker,a.g_label,a.width,COUNT(*) AS jumlah,SUM(a.weight) AS berat,SUM(a.seset) AS seset FROM m_timbangan a
                            INNER JOIN pl b ON a.id_pl=b.id
                            AND b.no_po='$ukPO->no_po' AND b.tgl='$tTgl->tgl' AND a.nm_ker='$ukPO->nm_ker' AND a.g_label='$ukPO->g_label' AND a.width='$ukPO->width' AND b.qc='ok'
                            GROUP BY b.tgl,a.g_label,a.nm_ker,a.width");
                            if($getIsiUk->num_rows() == 0){
                                $html .= '<td></td><td></td>';
                            }else{
                                $ukFixBerat = $getIsiUk->row()->berat - $getIsiUk->row()->seset; // jika ada seset
                                $html .= '<td style="padding:5px;text-align:center;background:'.$bgNk.'" id="i">'.number_format($getIsiUk->row()->jumlah).'</td>
                                <td style="padding:5px;text-align:right;background:'.$bgNk.'" id="i">'.number_format($ukFixBerat).'</td>';
                            }
                        }

                        // TOTAL PER UKURAN PER GSM
                        $getUkpGsm = $this->db->query("SELECT b.tgl,a.nm_ker,a.g_label,a.width,COUNT(*) AS jumlah,SUM(a.weight) AS berat,SUM(a.seset) AS seset FROM m_timbangan a
                        INNER JOIN pl b ON a.id_pl=b.id
                        AND b.no_po='$ukPO->no_po' AND a.nm_ker='$ukPO->nm_ker' AND a.g_label='$ukPO->g_label' AND a.width='$ukPO->width' AND b.qc='ok'
                        GROUP BY a.nm_ker,a.g_label,a.width");
                        if($getUkpGsm->num_rows() == 0){
							$plusMinRoll = 0 - $ukPO->jml_roll;
                            $plusMinBerat = 0 - $ukPO->tonase;
                            $html .= '<td style="padding:5px;text-align:center">-</td>
								<td style="padding:5px;text-align:center">-</td>
                                <td style="padding:5px;font-weight:bold;text-align:center">'.number_format($plusMinRoll).'</td>
								<td style="padding:5px;font-weight:bold;text-align:center">'.number_format($plusMinBerat).'</td>';
                        }else{
                            $ukGsmFixBerat = $getUkpGsm->row()->berat - $getUkpGsm->row()->seset;
                            $html .= '<td style="padding:5px;font-weight:bold;text-align:center" id="i">'.number_format($getUkpGsm->row()->jumlah).'</td>
                            <td style="padding:5px;font-weight:bold;text-align:center" id="i">'.number_format($ukGsmFixBerat).'</td>';
                            
                            // + -
                            // JIKA JUMLAH ROLL LEBIH DARI PO DI NOL KAN!
                            if($getUkpGsm->row()->jumlah >= $ukPO->jml_roll){
                                $plusMinRoll = 0;
                            }else{
                                $plusMinRoll = $getUkpGsm->row()->jumlah - $ukPO->jml_roll;
                            }
                            // JIKA QTY BERAT LEBIH DARI PO DI NOL KAN!
                            if($ukGsmFixBerat >= $ukPO->tonase){
                                $plusMinBerat = 0;
                            }else{
                                $plusMinBerat = $ukGsmFixBerat - $ukPO->tonase;
                            }
                            // $plusMinRoll = $getUkpGsm->row()->jumlah - $ukPO->jml_roll;
                            // $plusMinBerat = $ukGsmFixBerat - $ukPO->tonase;
                            $html .= '<td style="padding:5px;text-align:center;font-weight:bold" id="i">'.number_format($plusMinRoll).'</td>
                                <td style="padding:5px;text-align:center;font-weight:bold" id="i">'.number_format($plusMinBerat).'</td>';
                        }
                        $html .= '</tr>';

                        $sumPlusMinRoll += $plusMinRoll;
                        $sumPlusMinBerat += $plusMinBerat;
                    }

                    // JIKA CUMA SATU GSM YANG ADA DI PO
                    if($getGsm->num_rows() == 1){
                        $html .= '';
                    }else{
                        // TOTAL PER GSM ORDER ROLL , TON
                        $html .= '<tr>
                            <td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold" colspan="3"></td>
                            <td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold" id="i">'.number_format($rGsm->jmll).'</td>
                            <td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold" id="i">'.number_format($rGsm->tonn).'</td>';

                        // TOTAL PER GSM
                        foreach($getTgl->result() as $tTgl){
                            $getTotpGsm = $this->db->query("SELECT b.tgl,a.nm_ker,a.g_label,a.width,COUNT(*) AS jumlah,SUM(a.weight) AS berat,SUM(a.seset) AS seset FROM m_timbangan a
                            INNER JOIN pl b ON a.id_pl=b.id
                            AND b.no_po='$rGsm->no_po' AND b.tgl='$tTgl->tgl' AND a.nm_ker='$rGsm->nm_ker' AND a.g_label='$rGsm->g_label' AND b.qc='ok'
                            GROUP BY b.tgl,a.g_label,a.nm_ker");
                            if($getTotpGsm->num_rows() == 0){
                                $html .= '<td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold">-</td>
                                    <td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold">-</td>';
                            }else{
                                $totGsmFixBerat = $getTotpGsm->row()->berat - $getTotpGsm->row()->seset;
                                $html .= '<td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold" id="i">'.number_format($getTotpGsm->row()->jumlah).'</td>
                                <td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold" id="i">'.number_format($totGsmFixBerat).'</td>';
                            }
                        }

                        // JUMLAH TOTAL PER GSM
                        $getJmlTotpGsm = $this->db->query("SELECT b.tgl,a.nm_ker,a.g_label,a.width,COUNT(*) AS jumlah,SUM(a.weight) AS berat,SUM(a.seset) AS seset FROM m_timbangan a
                        INNER JOIN pl b ON a.id_pl=b.id
                        AND b.no_po='$rGsm->no_po' AND a.nm_ker='$rGsm->nm_ker' AND a.g_label='$rGsm->g_label' AND b.qc='ok'
                        GROUP BY a.g_label,a.nm_ker");
                        if($getJmlTotpGsm->num_rows() == 0){
                            $html .= '<td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold">-</td>
                                <td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold">-</td>
                                <td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold">'.number_format($sumPlusMinRoll).'</td>
                                <td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold">'.number_format($sumPlusMinBerat).'</td>';
                        }else{
                            $jmlTotGsmFixBerat = $getJmlTotpGsm->row()->berat - $getJmlTotpGsm->row()->seset;
                            $html .= '<td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold" id="i">'.number_format($getJmlTotpGsm->row()->jumlah).'</td>
                            <td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold" id="i">'.number_format($jmlTotGsmFixBerat).'</td>';

                            // + -
                            // $plusMinSumRoll = $getJmlTotpGsm->row()->jumlah - $rGsm->jmll;
                            // $plusMinSumBerat = $jmlTotGsmFixBerat - $rGsm->tonn;
                            $html .= '<td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold" id="i">'.number_format($sumPlusMinRoll).'</td>
                            <td style="padding:5px;background:#99DDCC;text-align:center;font-weight:bold" id="i">'.number_format($sumPlusMinBerat).'</td>';
                        }
                        $html .= '</tr>';
                    }

                    $allTotRoll += $rGsm->jmll;
                    $allTotTonn += $rGsm->tonn;
                    $allSumPlusMinRoll += $sumPlusMinRoll;
                    $allSumPlusMinBerat += $sumPlusMinBerat;
                }

                // ===========================================================================================================================================

                // TOTAL KESELURAHAN PO
                $html .= '<tr>
                    <td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold" colspan="3">TOTAL</td>
                    <td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold" id="i">'.number_format($allTotRoll).'</td>
                    <td style="padding:5px;background:#87B7C9;text-align:center;font-weight:bold" id="i">'.number_format($allTotTonn).'</td>';
                    $sumRoll = 0;
                    $sumTon = 0;
                    foreach($getTgl->result() as $tTgl){
                        $getKir = $this->db->query("SELECT b.tgl,a.nm_ker,a.g_label,a.width,COUNT(*) AS jumlah,SUM(a.weight) AS berat,SUM(a.seset) AS seset FROM m_timbangan a
                        INNER JOIN pl b ON a.id_pl=b.id
                        AND b.no_po='$ukPO->no_po' AND b.tgl='$tTgl->tgl' AND b.qc='ok'
                        GROUP BY b.tgl");
                        if($getKir->num_rows() == 0){
                            $html .= '<td></td><td></td>';
                        }else{
                            $fixTotBerat = $getKir->row()->berat - $getKir->row()->seset;
                            $html .= '<td style="padding:5px;font-weight:bold;text-align:center;background:#B9E9FB" id="i">'.number_format($getKir->row()->jumlah).'</td>
                            <td style="padding:5px;font-weight:bold;text-align:center;background:#B9E9FB" id="i">'.number_format($fixTotBerat).'</td>';
                        }

                        $sumRoll += $getKir->row()->jumlah;
                        $sumTon += $fixTotBerat;
                    }
                
                // $plusMinTottSumRoll = $sumRoll - $allTotRoll;
                // $plusMinTottSumBerat = $sumTon - $allTotTonn;
                $html .= '<td style="padding:5px;font-weight:bold;text-align:center;background:#87B7C9" id="i">'.number_format($sumRoll).'</td>
                <td style="padding:5px;font-weight:bold;text-align:center;background:#87B7C9" id="i">'.number_format($sumTon).'</td>
                <td style="padding:5px;font-weight:bold;text-align:center;background:#87B7C9" id="i">'.number_format($allSumPlusMinRoll).'</td>
                <td style="padding:5px;font-weight:bold;text-align:center;background:#87B7C9" id="i">'.number_format($allSumPlusMinBerat).'</td>';
                $html .= '</tr>';

                $html .= '</table></div>';
            }
        }

        // CETAK
        // $judul = $getPT->row()->nm_perusahaan;
        if ($ctk == '0') {
            echo $html;
        }
        // else if ($ctk == '1') {
		// 	$this->m_fungsi->newPDFopsi($html,'L',5,5,5,5,'','','','','','');
        // }
        else{
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=excel.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $data2['prev']= $html;
            $this->load->view('view_excel', $data2);
        }
    }

	function NewStokGudang() {
		$jenis = $_POST['jenis'];
		$otorisasi = $_POST['otorisasi'];
		$stat = $_POST['stat'];
		$tgl = $_POST['tgl'];
		$tgl2 = $_POST['tgl2'];
		$vpm = $_POST['pm'];
		$vjenis = $_POST['vjenis'];

		$html = "";
		$html .='<style>#i{mso-number-format:\@}</style>';
		$html .='<div style="overflow:auto;white-space:nowrap;">
			<table style="margin:0;padding:0;font-size:12px;color:#000;text-align:center;vertical-align:middle;border-collapse:collapse" border="1">';

        if($stat == 'produksi'){
            if($vpm == 1){
                $pm = "AND pm='1'";
            }else if($vpm == 2){
                $pm = "AND (pm='2' OR pm IS NULL)";
            }else{
                $pm = "";
            }
        }else{
            $pm = "";
        }
        
        if($jenis == 'mh' || $jenis == 'rmh' || $vjenis == 'mh'){
            $where = "AND (nm_ker='mh' OR nm_ker='mi') $pm";
        }else if($jenis == 'bk' || $jenis == 'rbk' || $vjenis == 'bk'){
            $where = "AND (nm_ker='bk' OR nm_ker='bl') $pm";
        }else if($jenis == 'mhbk' || $jenis == 'rmhbk' || $vjenis == 'mhbk'){
            $where = "AND nm_ker!='wp' AND nm_ker!='mn' AND nm_ker!='mh color' $pm";
        }else if($jenis == 'nonspek' || $jenis == 'rnonspek' || $vjenis == 'nonspek'){
            $where = "AND nm_ker='mn' $pm";
        }else if($jenis == 'wp' || $jenis == 'rwp' || $vjenis == 'wp'){
            $where = "AND nm_ker='wp' $pm";
        }else if($jenis == 'rmhc'){
            $where = "AND nm_ker='mh color' $pm";
        }else{
            $where = "AND (nm_ker='mh' OR nm_ker='mi' OR nm_ker='bk' OR nm_ker='bl' OR nm_ker='mn' OR nm_ker='wp' OR nm_ker='mh color') $pm";
        }
        
		if($stat == 'buffer'){
			$statusIdPl = "AND status='3' AND id_pl='0'";
		}else if($stat == 'stok'){
			$statusIdPl = "AND status='0' AND id_pl='0'";
		}else{
			$statusIdPl = "";
		}

        if($tgl == $tgl2){
            $tTgl = "tgl='$tgl'";
        }else{
            $tTgl = "tgl BETWEEN '$tgl' AND '$tgl2'";
        }

        // GET PRODUKSI
        $getProduksi = $this->db->query("SELECT nm_ker,g_label,width FROM m_timbangan
        WHERE $tTgl $where $statusIdPl
        GROUP BY nm_ker,g_label,width");
        
        if($getProduksi->num_rows() == 0 && $stat == 'produksi'){
            $html .='<div style="font-weight:bold">TIDAK ADA PRODUKSI</div>';
        }else{
            if($stat == 'produksi'){
                $Btgl = $tTgl;
            }else{
                $Btgl = "tgl BETWEEN '2020-04-01' AND '9999-01-01'";
            }

			// DATA INTI DARI SEGALA INTI
            $getLabel = $this->db->query("SELECT nm_ker FROM m_timbangan
            WHERE $Btgl $statusIdPl $where
            GROUP BY nm_ker");

			// GET SEMUA KOP JENIS
            $html .='<tr style="background:#e9e9e9">
            <td style="padding:5px;font-weight:bold" rowspan="2">NO.</td>
            <td style="padding:5px;font-weight:bold" rowspan="2">UKURAN</td>';
            foreach($getLabel->result() as $lbl){
                $getGsm = $this->db->query("SELECT nm_ker,g_label FROM m_timbangan
                WHERE $Btgl AND nm_ker='$lbl->nm_ker' $statusIdPl
                GROUP BY nm_ker,g_label");
                $html .='<td style="padding:5px;font-weight:bold" colspan="'.$getGsm->num_rows().'">'.$lbl->nm_ker.'</td>';
            }
            $html .='</tr>';
            
			// GET SEMUA KOP GRAMATURE
            $html .='<tr>';
            foreach($getLabel->result() as $lbl){
                $getGsm = $this->db->query("SELECT nm_ker,g_label FROM m_timbangan
                WHERE $Btgl AND nm_ker='$lbl->nm_ker' $statusIdPl
                GROUP BY nm_ker,g_label");
                foreach($getGsm->result() as $gsm){
                    $html .='<td style="padding:5px;background:#e9e9e9;font-weight:bold">'.$gsm->g_label.'</td>';
                }
            }
            $html .='</tr>';

			// TAMPIL SEMUA DATA UKURAN
            $getWidth = $this->db->query("SELECT width FROM m_timbangan
            WHERE $Btgl $statusIdPl $where
            -- AND width BETWEEN '110' AND '130' # TESTING
            GROUP BY width");
            $i = 0;
            foreach($getWidth->result() as $width){
                $i++;
                $html .='<tr class="new-stok-gg"><td style="font-weight:bold">'.$i.'</td><td style="font-weight:bold">'.round($width->width,2).'</td>';

                $getLabel = $this->db->query("SELECT nm_ker FROM m_timbangan
                WHERE $Btgl $statusIdPl $where
                GROUP BY nm_ker");
                foreach($getLabel->result() as $lbl){
                    $getGsm = $this->db->query("SELECT nm_ker,g_label FROM m_timbangan
                    WHERE $Btgl AND nm_ker='$lbl->nm_ker' $statusIdPl
                    GROUP BY nm_ker,g_label");
                    foreach($getGsm->result() as $gsm){
                        $getWidth = $this->db->query("SELECT nm_ker,g_label,width,COUNT(width) as jml FROM m_timbangan
                        WHERE $Btgl AND nm_ker='$gsm->nm_ker' AND g_label='$gsm->g_label' AND width='$width->width' $statusIdPl
                        GROUP BY nm_ker,g_label,width");
                        if($gsm->nm_ker == 'MH' || $gsm->nm_ker == 'MI' || $gsm->nm_ker == 'ML'){
                            $gbGsm = '#ffc';
                        }else if($gsm->nm_ker == 'MN'){
                            $gbGsm = '#fcc';
                        }else if($gsm->nm_ker == 'BK' || $gsm->nm_ker == 'BL'){
                            $gbGsm = '#ccc';
                        }else if($gsm->nm_ker == 'WP'){
                            $gbGsm = '#cfc';
                        }else if($gsm->nm_ker == 'MH COLOR'){
                            $gbGsm = '#ccf';
                        }else{
                            $gbGsm = '#fff';
                        }
                        if($getWidth->num_rows() == 0){
                            $html .='<td style="padding:5px;background:'.$gbGsm.'">
                                <button style="background:transparent;font-weight:bold;margin:0;padding:0;border:0" onclick="cek('."'".$gsm->nm_ker."'".','."'".$gsm->g_label."'".','."'".$width->width."'".','."'".$otorisasi."'".')">0</button>
                            </td>';
                        }else{
                            $html .='<td style="padding:5px">
                                <button style="background:transparent;font-weight:bold;margin:0;padding:0;border:0" onclick="cek('."'".$gsm->nm_ker."'".','."'".$gsm->g_label."'".','."'".$width->width."'".','."'".$otorisasi."'".')">'.$getWidth->row()->jml.'</button>
                            </td>';
                        }
                    }
                }
            }
            $html .='</tr>';
			// TOTAL SEMUANYA PER GRAMATURE
			$html .='<tr style="background:#e9e9e9">
				<td style="padding:5px;font-weight:bold" colspan="2">TOTAL</td>';
				foreach($getLabel->result() as $lbl){
					$getGsm = $this->db->query("SELECT nm_ker,g_label,COUNT(width) AS totjmlroll FROM m_timbangan
					WHERE $Btgl AND nm_ker='$lbl->nm_ker' $statusIdPl
					GROUP BY nm_ker,g_label");
					foreach($getGsm->result() as $s){
						if($s->totjmlroll == 0){
							$totot = 0;
						}else{
							$totot = $s->totjmlroll;
						}
						$html .='<td style="padding:5px;font-weight:bold">'.number_format($totot).'</td>';
					}
				}
			$html .='</tr>';
        }
		$html .='</table></div>';

		echo $html;
	}

	function StokCekPO(){
		$nm_ker = $_POST['nm_ker'];
		$g_label = $_POST['g_label'];
		$width = $_POST['width'];

		$html = '';
        $html .= '<div style="overflow:auto;white-space:nowrap;">';
		$html .= '<div style="color:#000;font-weight:bold">CEK PENJUALAN BERDASARKAN PO</div><br/>';
		$html .='<table style="margin:0;padding:0;font-size:12px;color:#000;vertical-align:middle;border-collapse:collapse">';

		$getMasPO = $this->db->query("SELECT a.*,b.nm_perusahaan FROM po_master a
		INNER JOIN m_perusahaan b ON a.id_perusahaan=b.id
		WHERE nm_ker='$nm_ker' AND g_label='$g_label' AND width='$width' AND status='open'
		GROUP BY nm_ker,g_label,width,b.nm_perusahaan,tgl,no_po,a.status");		
		if($getMasPO->num_rows() == 0){
			$html .='<tr>
					<td style="padding:5px 0;font-weight:bold">TIDAK ADA DATA</td>
				</tr>';
		}else{
			$i = 0;
			$html .='<tr>
				<td style="padding:5px;font-weight:bold">NO.</td>
				<td style="padding:5px;font-weight:bold">CUSTOMER</td>
				<td style="padding:5px;font-weight:bold">NO. PO</td>
				<td style="padding:5px;font-weight:bold">ROLL</td>
			</tr>'; // kop
			$sumRollPO = 0;
			foreach($getMasPO->result() as $masPO){
				$i++;
				$html .='
				<tr>
					<td style="padding:5px;font-weight:bold;text-align:center">'.$i.'</td>
					<td style="padding:5px;font-weight:bold">'.$masPO->nm_perusahaan.'</td>
					<td style="padding:5px;font-weight:bold">'.$masPO->no_po.'</td>
					<td style="padding:5px;font-weight:bold;text-align:right">'.number_format($masPO->jml_roll).'</td>
				</tr>';

                $getKirim = $this->db->query("SELECT pl.tgl,pl.no_surat,COUNT(r.roll) AS jml_roll,SUM(r.weight) AS jml_berat FROM m_timbangan r
                INNER JOIN pl pl ON r.id_pl=pl.id
                WHERE r.nm_ker='$masPO->nm_ker' AND r.g_label='$masPO->g_label' AND width='$masPO->width' AND pl.no_po='$masPO->no_po'
                GROUP BY pl.tgl,r.nm_ker,r.g_label,width,pl.no_po");
				$sumRollKiriman = 0;
                foreach($getKirim->result() as $kirim){
					$html .='<tr>
					<td style="padding:5px;font-weight:bold;text-align:center">-</td>
					<td style="padding:5px" colspan="2">'.$this->m_fungsi->tglInd_skt($kirim->tgl).' - '.trim($kirim->no_surat).'</td>
					<td style="padding:5px;text-align:right">'.number_format($kirim->jml_roll).'</td>
                    </tr>';
					$sumRollKiriman += $kirim->jml_roll;
                }
				$html .='<tr><td style="padding:5px" coslpan="4"></td></tr>';
				
				// PERHITUHANG STOK PO
				$penguruangan = $masPO->jml_roll - $sumRollKiriman;
				if($masPO->jml_roll == 0 || $masPO->jml_roll == null || $masPO->jml_roll == ''){
					$jml_roll = 0;
				}else if($penguruangan >= 0){
					$jml_roll = $penguruangan;
				}else if($penguruangan <= 0){
					$jml_roll = 0;
				}else{
					$jml_roll = $masPO->jml_roll;
				}
				$sumRollPO += $jml_roll;
			}

			$getStokGudang = $this->db->query("SELECT COUNT(roll) AS jml_roll FROM m_timbangan
			WHERE nm_ker='$nm_ker' AND g_label='$g_label' AND width='$width'
			AND status='0' AND id_pl='0'
			GROUP BY nm_ker,g_label,width");
			// STOK BERTUAN = STOK GUDANG - STOK ROLL PO
			if($getStokGudang->num_rows() == 0){
				$nsJmlRoll = 0;
			}else{
				$nsJmlRoll = $getStokGudang->row()->jml_roll;
			}
			$stokRollTuan = $nsJmlRoll - $sumRollPO;

			// tototot
			$html .='<tr>
				<td style="padding:10px 5px 5px;font-weight:bold;text-align:right;border-top:3px solid #333" colspan="3">JUMLAH ROLL PO - PENJUALAN</td>
				<td style="padding:10px 5px 5px;font-weight:bold;text-align:right;border-top:3px solid #333" colspan="3">'.number_format($sumRollPO).'</td>
			</tr>
			<tr>
				<td style="padding:5px;font-weight:bold;text-align:right" colspan="3">STOK ROLL GUDANG</td>
				<td style="padding:5px;font-weight:bold;text-align:right" colspan="3">'.number_format($nsJmlRoll).'</td>
			</tr>
			<tr>
				<td style="padding:5px;font-weight:bold;text-align:right" colspan="3">SISA STOK ROLL GUDANG</td>
				<td style="padding:5px;font-weight:bold;text-align:right" colspan="3">'.number_format($stokRollTuan).'</td>
			</tr>';
		}
		$html .='</table></div>';
		
        echo $html;
	}

    function QCCariRoll(){
        $jnsroll = $_POST['jnsroll'];
        $gsmroll = $_POST['gsmroll'];
        $ukroll = $_POST['ukroll'];
        $roll = $_POST['roll'];
        $tgl1 = $_POST['tgl1'];
        $tgl2 = $_POST['tgl2'];
        $opsi = $_POST['opsi'];
        $otori = $_POST['otori'];
        $stat = $_POST['stat'];
        $vtgl = $_POST['vtgl'];
        $vtgl2 = $_POST['vtgl2'];
        $pm = $_POST['pm'];
        $html ='';

		if($opsi == 'cekRollStok'){
			if($stat == 'stok'){
				$where = "nm_ker='$jnsroll' AND g_label='$gsmroll' AND width='$ukroll' AND status='0' AND id_pl='0'";
			}else if($stat == 'buffer'){
				$where = "nm_ker='$jnsroll' AND g_label='$gsmroll' AND width='$ukroll' AND status='3' AND id_pl='0'";
			}else{ // PRODUKSI
                if($pm == 1){
                    $tpm = "AND pm='1' AND tgl BETWEEN '$vtgl' AND '$vtgl2'";
                }else if($pm == 2){
                    $tpm = "AND (pm='2' OR pm IS NULL) AND tgl BETWEEN '$vtgl' AND '$vtgl2'";
                }else{
                    $tpm = "AND tgl BETWEEN '$vtgl' AND '$vtgl2'";
                }
				$where = "nm_ker='$jnsroll' AND g_label='$gsmroll' AND width='$ukroll' $tpm";
			}
		}else{ // STOK GUDANG
			if($opsi == 'rroll'){
				$where = "nm_ker LIKE '%$jnsroll%' AND g_label LIKE '%$gsmroll%' AND width LIKE '%$ukroll%' AND roll LIKE '%$roll%'";
			}else{
				$where = "tgl BETWEEN '$tgl1' AND '$tgl2'";
			}
		}

		$html .='<div style="overflow:auto;white-space:nowrap;">';
        $html .='<table style="margin:0;padding:0;font-size:12px;color:#000;vertical-align:center;border-collapse:collapse">';
		$getRoll = $this->db->query("SELECT*FROM m_timbangan
		WHERE $where
		ORDER BY pm,id");
		if($opsi == 'rroll' && ($jnsroll == '' || $gsmroll == '' || $ukroll == '') && $roll == ''){
            $html .='<tr><td style="font-weight:bold;text-align:center">LENGKAPI DATA JENIS, GSM, UKURAN...</td></tr>';
		}else if($opsi == 'ttgl' && ($tgl1 == '' || $tgl2 == '')){
            $html .='<tr><td style="font-weight:bold;text-align:center">MASUKKAN TANGGAL...</td></tr>';
		}else if($getRoll->num_rows() == 0){
            $html .='<tr><td style="font-weight:bold;text-align:center">DATA TIDAK DITEMUKAN...</td></tr>';
		}else{
			$html .='<tr style="background:#e9e9e9">
				<th style="padding:6px;border:1px solid #999;font-weight:bold;text-align:center">TANGGAL</th>
				<th style="padding:6px;border:1px solid #999;font-weight:bold;text-align:center">ROLL</th>
				<th style="padding:6px;border:1px solid #999;font-weight:bold;text-align:center">BW</th>
				<th style="padding:6px;border:1px solid #999;font-weight:bold;text-align:center">RCT</th>
				<th style="padding:6px;border:1px solid #999;font-weight:bold;text-align:center">BI</th>
				<th style="padding:6px;border:1px solid #999;font-weight:bold;text-align:center">JENIS</th>
				<th style="padding:6px;border:1px solid #999;font-weight:bold;text-align:center">GSM</th>
				<th style="padding:6px;border:1px solid #999;font-weight:bold;text-align:center">UK</th>
				<th style="padding:6px;border:1px solid #999;font-weight:bold;text-align:center">CM</th>
				<th style="padding:6px;border:1px solid #999;font-weight:bold;text-align:center">BERAT</th>
				<th style="padding:6px;border:1px solid #999;font-weight:bold;text-align:center">J</th>
				<th style="padding:6px;border:1px solid #999;font-weight:bold;text-align:center">KETERANGAN</th>
				<th style="padding:6px;border:1px solid #999;font-weight:bold;text-align:center">STATUS</th>
			</tr>';
			foreach($getRoll->result() as $roll){
                // TAMPILKAN EDIT
                $getRollEdit = $this->db->query("SELECT*FROM m_roll_edit e
                WHERE e.roll='$roll->roll'");
                if($getRollEdit->num_rows() == 0){
					if($otori == 'all' || $otori == 'admin' || $otori == 'qc'){
						$oBre = '<button class="tmbl-cek-roll" onclick="cekRollEdit('."'".$roll->id."'".','."'".$roll->roll."'".')">';
                        $cBre = '</button>';
					}else{
						$oBre = '';
						$cBre = '';
					}
                }else{
                    if(($roll->status == 1 || $roll->status == 2 || $roll->status == 3) && $roll->id_pl != 0){
                        $oBre = '';
                        $cBre = '';
                    }else{
                        $oBre = '<button class="tmbl-cek-roll" style="color:#00f" onclick="cekRollEdit('."'".$roll->id."'".','."'".$roll->roll."'".')">';
                        $cBre = '</button>';
                    }
                }

				if(($roll->status == 0 && $roll->id_pl == 0) || ($roll->status == 2 && $roll->id_pl == 0)){ // STOK + PPI
                    $bgStt = 'cek-status-stok';
					if($opsi == 'cekRollStok' || $otori == 'all' || $otori == 'admin' || $otori == 'qc'){
						$diss = '';
					}else{
						$diss = 'disabled';
					}
					$oBtn = '';
					$cBtn = '';
				}else if($roll->status == 3 && $roll->id_pl == 0){ // BUFFER
                    $bgStt = 'cek-status-buffer';
					if($opsi == 'cekRollStok' || $otori == 'all' || $otori == 'admin' || $otori == 'qc'){
						$diss = '';
					}else{
						$diss = 'disabled';
					}
					$oBtn = '';
					$cBtn = '';
				}else if(($roll->status == 1 || $roll->status == 2 || $roll->status == 3) && $roll->id_pl != 0){ // PENJUALAN
                    $bgStt = 'cek-status-terjual';
					$diss = 'disabled';
					$oBtn = '<button class="tmbl-cek-roll" onclick="cek_roll('."'".$roll->id."'".')">';
					$cBtn = '</button>';
				}else{ // TIDAK TERDETEKSI
                    $bgStt = 'cek-status-stok';
					if($opsi == 'cekRollStok' || $otori == 'all' || $otori == 'admin' || $otori == 'qc'){
						$diss = '';
					}else{
						$diss = 'disabled';
					}
					$oBtn = '';
					$cBtn = '';
				}

                $i = $roll->id;
                // MENAMPUNG DATA LAMA
                $html .='
                <input type="hidden" id="lroll-'.$i.'" value="'.$roll->roll.'">
                <input type="hidden" id="lnm_ker-'.$i.'" value="'.$roll->nm_ker.'">
                <input type="hidden" id="lg_label-'.$i.'" value="'.$roll->g_label.'">
                <input type="hidden" id="lwidth-'.$i.'" value="'.$roll->width.'">
                <input type="hidden" id="lweight-'.$i.'" value="'.$roll->weight.'">
                <input type="hidden" id="ldiameter-'.$i.'" value="'.$roll->diameter.'">
                <input type="hidden" id="ljoint-'.$i.'" value="'.$roll->joint.'">
                <input type="hidden" id="lket-'.$i.'" value="'.$roll->ket.'">
                <input type="hidden" id="lstatus-'.$i.'" value="'.$roll->status.'">
                ';
				$html .='<tr class="'.$bgStt.'">
					<td style="padding:0 3px;border:1px solid #999">'.$oBtn.'<input class="ttggll" type="date" id="etgl-'.$i.'" value="'.$roll->tgl.'" '.$diss.' style="width:85px">'.$cBtn.'</td>
					<td style="padding:0 3px;border:1px solid #999">'.$oBre.''.$oBtn.'<input class="ipt-txt" type="text" id="eroll-'.$i.'" value="'.$roll->roll.'" disabled style="width:100px" maxlength="14">'.$cBtn.''.$cBre.'</td>
					<td style="border:1px solid #999">'.$oBtn.'<input class="ipt-txt" type="text" id="eg_ac-'.$i.'" value="'.$roll->g_ac.'" '.$diss.' onkeypress="return aK(event)" maxlength="6" style="width:50px;text-align:center">'.$cBtn.'</td>
					<td style="border:1px solid #999">'.$oBtn.'<input class="ipt-txt" type="text" id="erct-'.$i.'" value="'.$roll->rct.'" '.$diss.' onkeypress="return aK(event)" maxlength="6" style="width:50px;text-align:center">'.$cBtn.'</td>
					<td style="border:1px solid #999">'.$oBtn.'<input class="ipt-txt" type="text" id="ebi-'.$i.'" value="'.$roll->bi.'" '.$diss.' onkeypress="return aK(event)" maxlength="6" style="width:50px;text-align:center">'.$cBtn.'</td>';
                
                // PLH JENIS KERTAS
                if(($roll->status == 1 || $roll->status == 2 || $roll->status == 3) && $roll->id_pl != 0){
                    // $optKer = '<input class="ipt-txt" type="text" id="enm_ker-'.$i.'" value="'.$roll->nm_ker.'" '.$diss.' style="width:50px;text-align:center">';
                    $optKer = $oBtn.''.$roll->nm_ker.''.$cBtn;
                }else{
                    $optKer = '<select name="" id="enm_ker-'.$i.'" class="opt_status" '.$diss.'>
                        <option value="'.$roll->nm_ker.'">'.$roll->nm_ker.'</option>
                        <option value="">-</option>
                        <option value="MH">MH</option>
                        <option value="MN">MN</option>
                        <option value="BK">BK</option>
                        <option value="WP">WP</option>
                        <option value="MH COLOR">MH COLOR</option>
                    </select>';
                }
                $html .= '<td style="border:1px solid #999;text-align:center">'.$oBtn.''.$optKer.''.$cBtn.'</td>';
                
                // khusus ket dan status
                // if($otori == 'user' || ($roll->status == 1 || $roll->status == 2 || $roll->status == 3) && $roll->id_pl != 0){
                //     $fgdiss = 'disabled';
                // }else{
                //     $fgdiss = '';
                // }
                $html .='<td style="border:1px solid #999">'.$oBtn.'<input class="ipt-txt" type="text" id="eg_label-'.$i.'" value="'.$roll->g_label.'" '.$diss.' onkeypress="return aK(event)" maxlength="3" style="width:50px;text-align:center">'.$cBtn.'</td>
					<td style="border:1px solid #999">'.$oBtn.'<input class="ipt-txt" type="text" id="ewidth-'.$i.'" value="'.round($roll->width,2).'" '.$diss.' onkeypress="return aK(event)" maxlength="6" style="width:50px;text-align:center">'.$cBtn.'</td>
					<td style="border:1px solid #999">'.$oBtn.'<input class="ipt-txt" type="text" id="ediameter-'.$i.'" value="'.$roll->diameter.'" '.$diss.' onkeypress="return aK(event)" maxlength="3" maxlength="3" style="width:50px;text-align:center">'.$cBtn.'</td>
					<td style="border:1px solid #999">'.$oBtn.'<input class="ipt-txt" type="text" id="eweight-'.$i.'" value="'.$roll->weight.'" '.$diss.' onkeypress="return aK(event)" maxlength="4" onkeypress="return hanyaAngka(event)" maxlength="5" style="width:50px;text-align:center">'.$cBtn.'</td>
					<td style="border:1px solid #999">'.$oBtn.'<input class="ipt-txt" type="text" id="ejoint-'.$i.'" value="'.$roll->joint.'" '.$diss.' onkeypress="return aK(event)" maxlength="2" onkeypress="return hanyaAngka(event)" maxlength="3" style="width:30px;text-align:center">'.$cBtn.'</td>
					<td style="padding:0 3px;border:1px solid #999">'.$oBtn.'<textarea class="ipt-txt" id="eket-'.$i.'" style="resize:none;width:180px;height:30px" '.$diss.'>'.$roll->ket.'</textarea>'.$cBtn.'</td>';

                    // PILIH STATUS
                    if(($roll->status == 1 || $roll->status == 2 || $roll->status == 3) && $roll->id_pl != 0){
                        $html .='<td style="border:1px solid #999;text-align:center">'.$oBtn.'TERJUAL'.$cBtn.'</td>';
                    }else{
                        if($roll->status == 0 && $roll->id_pl == 0){
                            $oStt = 0;
                            $pStt = 'STOK';
                        }else if($roll->status == 2 && $roll->id_pl == 0){
                            $oStt = 2;
                            $pStt = 'PPI';
                        }else if($roll->status == 3 && $roll->id_pl == 0){
                            $oStt = 3;
                            $pStt = 'BUFFER';
                        }else{
                            $oStt = 1;
                            $pStt = '-';
                        }
                        $opt = '<select name="" id="opt_status-'.$i.'" class="opt_status" '.$diss.'>
                            <option value="'.$oStt.'">'.$pStt.'</option>
                            <option value="1">-</option>
                            <option value="0">STOK</option>
                            <option value="2">PPI</option>
                            <option value="3">BUFFER</option>
                        </select>';
                        $html .='<td style="border:1px solid #999;text-align:center">'.$opt.'</td>';
                        
                        // TOMBOL EDIT
                        if($otori == 'all' || $otori == 'admin' || $otori == 'qc'){
                            $print = base_url("Master/print_timbangan?id=").$roll->roll;
                            // $print2 = base_url("Master/print_timbangan2?id=").$roll->roll;
                            $plabel = '<a type="button" href="'.$print.'" target="_blank" style="padding:3px 5px;background:#fff">LABEL</a>';
                            if($roll->status == 1){
                                $aksii = '';
                            }else{
                                $aksii = $plabel;
                            }
                            $html .='<td class="edit-roll" style="padding:3px"><button id="btnn-edit-roll-'.$i.'" style="background:#fff;border:0;padding:3px 5px" onclick="editRoll('."'".$i."'".')">EDIT</button> '.$aksii.'</td>';
						}else{
                            $html .='';
                        }
                    }
                $html .='</tr>';
			}
		}
		$html .='</table>';
		$html .='</div>';

        echo $html;
    }

    function QCRollTerjual(){
        $id = $_POST['id'];
        $html='';
        
        $getId = $this->db->query("SELECT p.tgl AS tgl_pl,p.no_surat,p.no_po,p.nama,p.nm_perusahaan,p.alamat_perusahaan,r.* FROM m_timbangan r
        INNER JOIN pl p ON r.id_pl=p.id
        WHERE r.id='$id'");
        $roll = $getId->row();
        $html.='<table style="margin:0;font-size:12px;color:#000;text-align:center;border-color:#ccc;border-collapse:collapse">
            <tr>
                <td style="padding:5px 10px;font-weight:bold">TANGGAL</td>
                <td style="padding:5px 10px;font-weight:bold">ROLL</td>
                <td style="padding:5px 10px;font-weight:bold">BW</td>
                <td style="padding:5px 10px;font-weight:bold">RCT</td>
                <td style="padding:5px 10px;font-weight:bold">BI</td>
                <td style="padding:5px 10px;font-weight:bold">JENIS</td>
                <td style="padding:5px 10px;font-weight:bold">GSM</td>
                <td style="padding:5px 10px;font-weight:bold">UKURAN</td>
                <td style="padding:5px 10px;font-weight:bold">DIAMETER</td>
                <td style="padding:5px 10px;font-weight:bold">BERAT</td>
                <td style="padding:5px 10px;font-weight:bold">JOINT</td>
                <td style="padding:5px 10px;font-weight:bold">KETERANGAN</td>
            </tr>
            <tr>
                <td style="padding:5px 10px">'.$roll->tgl.'</td>
                <td style="padding:5px 10px">'.$roll->roll.'</td>
                <td style="padding:5px 10px">'.$roll->g_ac.'</td>
                <td style="padding:5px 10px">'.$roll->rct.'</td>
                <td style="padding:5px 10px">'.$roll->bi.'</td>
                <td style="padding:5px 10px">'.$roll->nm_ker.'</td>
                <td style="padding:5px 10px">'.$roll->g_label.'</td>
                <td style="padding:5px 10px">'.$roll->width.'</td>
                <td style="padding:5px 10px">'.$roll->diameter.'</td>
                <td style="padding:5px 10px">'.$roll->weight.'</td>
                <td style="padding:5px 10px">'.$roll->joint.'</td>
                <td style="padding:5px 10px;text-align:left">'.$roll->ket.'</td>
            </tr>
        </table><br/>';
        $html.='<table style="margin:0;font-size:12px;color:#000;border-collapse:collapse">
            <tr>
                <td style="padding:8px 5px;font-weight:bold">TANGGAL KIRIM</td>
                <td>:</td>
                <td style="padding:8px 5px">'.$this->m_fungsi->tanggal_format_indonesia($roll->tgl_pl).'</td>
            </tr>
            <tr>
                <td style="padding:8px 5px;font-weight:bold">NO. SURAT JALAN</td>
                <td>:</td>
                <td style="padding:8px 5px">'.trim($roll->no_surat).'</td>
            </tr>
            <tr>
                <td style="padding:8px 5px;font-weight:bold">NO. PO</td>
                <td>:</td>
                <td style="padding:8px 5px">'.$roll->no_po.'</td>
            </tr>
            <tr>
                <td style="padding:8px 5px;font-weight:bold">NAMA</td>
                <td>:</td>
                <td style="padding:8px 5px">'.$roll->nama.'</td>
            </tr>
            <tr>
                <td style="padding:8px 5px;font-weight:bold">NAMA PERUSAHAAN</td>
                <td>:</td>
                <td style="padding:8px 5px">'.$roll->nm_perusahaan.'</td>
            </tr>
            <tr>
                <td style="padding:8px 5px;font-weight:bold">ALAMAT PERUSAHAAN</td>
                <td>:</td>
                <td style="padding:8px 5px">'.$roll->alamat_perusahaan.'</td>
            </tr>
        </table>';

        echo $html;
    }

    function QCShowEditRoll(){
        $id = $_POST['idroll'];
        $roll = $_POST['roll'];
        $html ='';

		$html .='<div style="overflow:auto;white-space:nowrap">';
        $html .='<table style="margin:0 0 20px;padding:0;font-size:12px;color:#000;border-collapse:collapse">';
		$getRoll = $this->db->query("SELECT*FROM m_timbangan WHERE id='$id' AND roll='$roll'")->row();
		$html .='<tr>
				<td style="font-weight:bold" colspan="12">DATA :</td>
			</tr>
			<tr>
				<td style="padding:5px">no</td>
				<td style="padding:5px">roll</td>
				<td style="padding:5px">jenis</td>
				<td style="padding:5px">gramature</td>
				<td style="padding:5px">ukuran</td>
				<td style="padding:5px">diameter</td>
				<td style="padding:5px">berat</td>
				<td style="padding:5px">joint</td>
				<td style="padding:5px">keterangan</td>
				<td style="padding:5px">seset</td>
				<td style="padding:5px">status</td>
				<td style="padding:5px">created_at</td>
				<td style="padding:5px">created_by</td>
			</tr>';
		if($getRoll->status == 0 && $getRoll->id_pl == 0){
			$stt = 'STOK';
		}else if($getRoll->status == 2){
			$stt = 'PPI';
		}else if($getRoll->status == 3){
			$stt = 'BUFFER';
		}else if($getRoll->status == 1 && $getRoll->id_pl != 0){
			$stt = 'TERJUAL';
		}else{
			$stt = '-';
		}
		$html .='<tr>
			<td style="padding:5px">-</td>
			<td style="padding:5px">'.$getRoll->roll.'</td>
			<td style="padding:5px">'.$getRoll->nm_ker.'</td>
			<td style="padding:5px">'.$getRoll->g_label.'</td>
			<td style="padding:5px">'.round($getRoll->width,2).'</td>
			<td style="padding:5px">'.$getRoll->diameter.'</td>
			<td style="padding:5px">'.$getRoll->weight.'</td>
			<td style="padding:5px">'.$getRoll->joint.'</td>
			<td style="padding:5px">'.$getRoll->ket.'</td>
			<td style="padding:5px">'.$getRoll->seset.'</td>
			<td style="padding:5px">'.$stt.'</td>
			<td style="padding:5px">'.$getRoll->created_at.'</td>
			<td style="padding:5px">'.$getRoll->created_by.'</td>
		</tr>';
		$html .='</table>';

        $getData = $this->db->query("SELECT*FROM m_roll_edit WHERE roll='$roll'");
		if($getData->num_rows() == 0){
			$html .='';
		}else{
			$html .='<table style="margin:0;padding:0;font-size:12px;color:#000;border-collapse:collapse">';
			$i = 0;
			$html .='<tr>
					<td style="font-weight:bold" colspan="12">HISTORY EDIT :</td>
				</tr>
				<tr>
				<td style="padding:5px">no</td>
				<td style="padding:5px">roll</td>
				<td style="padding:5px">jenis</td>
				<td style="padding:5px">gramature</td>
				<td style="padding:5px">ukuran</td>
				<td style="padding:5px">diameter</td>
				<td style="padding:5px">berat</td>
				<td style="padding:5px">joint</td>
				<td style="padding:5px">keterangan</td>
				<td style="padding:5px">seset</td>
				<td style="padding:5px">status</td>
				<td style="padding:5px">edited_at</td>
				<td style="padding:5px">edited_by</td>
			</tr>';
			foreach($getData->result() as $ser){
				$i++;
				if($ser->status == 0){
					$stt = 'STOK';
				}else if($ser->status == 2){
					$stt = 'PPI';
				}else if($ser->status == 3){
					$stt = 'BUFFER';
				}else{
					$stt = 'STOK';
				}
				$html .='<tr>
					<td style="padding:5px">'.$i.'</td>
					<td style="padding:5px">'.$ser->roll.'</td>
					<td style="padding:5px">'.$ser->nm_ker.'</td>
					<td style="padding:5px">'.$ser->g_label.'</td>
					<td style="padding:5px">'.round($ser->width,2).'</td>
					<td style="padding:5px">'.$ser->diameter.'</td>
					<td style="padding:5px">'.$ser->weight.'</td>
					<td style="padding:5px">'.$ser->joint.'</td>
					<td style="padding:5px">'.$ser->ket.'</td>
					<td style="padding:5px">'.$ser->seset.'</td>
					<td style="padding:5px">'.$stt.'</td>
					<td style="padding:5px">'.$ser->edited_at.'</td>
					<td style="padding:5px">'.$ser->edited_by.'</td>
				</tr>';
			}
			$html .='</table>';
		}
		$html .='</div>';

		if($this->session->userdata('level') == "SuperAdmin" || $this->session->userdata('level') == "Admin" || $this->session->userdata('level') == "QC"){
			$print = base_url("Master/print_timbangan?id=").$roll;
			$print2 = base_url("Master/print_timbangan2?id=").$roll;
			$html .='<div style="margin-top:15px;color:#000;font-size:12px">
				PRINT LABEL :
				<a type="button" href="'.$print.'" target="_blank" class="lbl-besar">LABEL BESAR</a> - 
				<a type="button" href="'.$print2.'" target="_blank" class="lbl-besar">LABEL KECIL</a>
			</div>';
		}

        echo $html;
    }
}
