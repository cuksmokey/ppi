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

    function Laporan(){
        $tgl1 = $_GET['tgl1'];
        $tgl2 = $_GET['tgl2'];
        $jenis = $_GET['jenis'];

        if ($jenis == "3") {
            // BELUM DIPACKING

            $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2' AND status ='0'");
            // $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2' AND status ='0' AND (nm_ker='MH' OR nm_ker='MI')");
        }else{
            // KESELURUHAN
            
            $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2'");
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

        $html .= '<table width="100%" border="0" style="font-size:10px">
                    <tr>
                        <td colspan="12" align="center"><b><u><font style="font-size:18px">Laporan Timbangan</font></u> <br> 
                             '.$this->m_fungsi->tanggal_format_indonesia($tgl1).' S/D '.$this->m_fungsi->tanggal_format_indonesia($tgl2).'</b>
                        </td>
                    </tr>
                 </table>
                 <br>
                 <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size:10px">
                    <tr bgcolor="#CCCCCC">
                        <td width="" align="center">No</td>
                        <td width="" align="center">Roll Number</td>
                        <td width="" align="center">Jenis Kertas</td>
                        <td width="" align="center">Gramatur Label</td>
                        <td width="" align="center">Gramatur Aktual</td>
                        <td width="" align="center">Width</td>
                        <td width="" align="center">Diameter</td>
                        <td width="" align="center">Weight</td>
                        <td width="" align="center">Join</td>
                        <td width="" align="center">Rct</td>
                        <td width="" align="center">BI</td>
                        ';
                        if ($jenis != "1") {
                            $html .= '<td width="" align="center">Quality</td>';
                        }
                        if ($jenis == "2") {
                            $html .= '<td width="" align="center">Operator</td>';
                        }
                        $html .= '
                        <td width="" align="center">Keterangan</td>
                    </tr>';
                    $no = 1;
                    $tot_weight = 0 ;

                    if ($data_detail->num_rows() > 0) {
                        # code...
                        foreach ($data_detail->result() as $r ) {
                            
                            $html .= '<tr>
                                        <td width="" align="center">'.$no.'</td>
                                        <td width="" align="center">'.$r->roll.'</td>
                                        <td width="" align="center">'.$r->nm_ker.'</td>
                                        <td width="" align="center">'.$r->g_label.'</td>
                                        <td width="" align="center">'.$r->g_ac.'</td>
                                        <td width="" align="center">'.$r->width.'</td>
                                        <td width="" align="center">'.$r->diameter.'</td>
                                        <td width="" align="center">'.$r->weight.'</td>
                                        <td width="" align="center">'.$r->joint.'</td>
                                        <td width="" align="center">'.$r->rct.'</td>
                                        <td width="" align="center">'.$r->bi.'</td>
                                        ';
                                        if ($jenis != "1") {
                                            $html .= '<td width="" align="center"></td>';
                                        }
                                        if ($jenis == "2") {
                                            $html .= '<td width="" align="center">'.$r->created_by.'</td>';
                                        }
                                        $html .= '
                                        <td width="" align="center">'.$r->ket.'</td>
                                    </tr>';
                         $no++;
                         $tot_weight += $r->weight;
                        }
                    }

                    if ($jenis == "1") {
                            $html .= '<tr bgcolor="#CCCCCC">
                                    <td width="" align="center" colspan="7">TOTAL BERAT</td>
                                    <td width="" align="center">'.number_format($tot_weight).'</td>
                                    <td width="" align="center"></td>
                                    <td width="" align="center"></td>
                                    <td width="" align="center"></td>
                                    <td width="" align="center"></td>
                                </tr>';
                    }

                    $html .='
                </table>
                 
                 ';

        $ctk = $_GET['ctk'];

        $judul = "Laporan Timbangan Tanggal ".$tgl1 . " S/d ". $tgl2;
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

        $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE tgl BETWEEN '$tgl1' AND '$tgl2' ORDER BY id ASC");        
        $html = '';

                    if ($data_detail->num_rows() > 0) {
                        foreach ($data_detail->result() as $r ) {
                            $html .= '\N,"'.$r->roll.'","'.$r->tgl.'","'.$r->nm_ker.'","'.$r->g_ac.'","'.$r->g_label.'","'.$r->width.'","'.$r->diameter.'","'.$r->weight.'","'.$r->joint.'","'.$r->ket.'","'.$r->status.'","'.$r->id_pl.'",\N,\N,\N,\N,"'.$r->rct.'","0","'.$r->bi.'"<br>';
                        }
                    }

        $ctk = $_GET['ctk'];

        $judul = "csv_".$tgl1."_".$tgl2;
        if ($ctk == '0') {
            echo $html;
        }        else{
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

    function print_surat_jalan(){
        $jenis = $_GET['jenis'];
        $ctk = $_GET['ctk'];

        $html = '';

                        # # # # # # # # # K O P # # # # # # # # # #


        // AMBIL DATA KOP
        $data_kop = $this->db->query("
        SELECT b.tgl AS tgl_kop,a.nm_ker AS ker,b.nama AS nama,b.nm_perusahaan AS pt,b.no_po AS popo,b.no_pkb AS no_pkb FROM m_timbangan a
        INNER JOIN pl b ON a.id_pl=b.id
        WHERE b.no_pkb='$jenis'
        GROUP BY ker LIMIT 1;")->row();

        // count data kop
        $count_kop = $this->db->query("
        SELECT g_label,a.nm_ker AS ker,width,COUNT(*) AS qty,SUM(weight) AS berat,b.no_po as po FROM m_timbangan a
        INNER JOIN pl b ON a.id_pl=b.id
        WHERE b.no_pkb='$jenis'
        GROUP BY g_label,width,b.no_po
        ORDER BY g_label,width,b.no_po ASC")->num_rows();

        // pengurangan jarak jika data terlalu banyak
        if($count_kop >= '10' || ($data_kop->pt == 'PT. DAYACIPTA KEMASINDO' || $data_kop->nama == 'PT. DAYACIPTA KEMASINDO' && $count_kop >= '7' )){
            $px = '0';
        }else if($data_kop->pt == 'PT. DAYACIPTA KEMASINDO' || $data_kop->nama == 'PT. DAYACIPTA KEMASINDO'&& $count_kop >= '6' ){
            $px = '20px';
        }else if($count_kop >= '8' || ($data_kop->pt == 'PT. DAYACIPTA KEMASINDO' || $data_kop->nama == 'PT. DAYACIPTA KEMASINDO' && $count_kop >= '5' )){
            $px = '40px';
        }else if($data_kop->pt == 'PT. DAYACIPTA KEMASINDO' || $data_kop->nama == 'PT. DAYACIPTA KEMASINDO' && $count_kop >= '2' ){
            $px = '60px';
        }else{
            $px = '80px';
        }

        $kop_pakai = '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:Arial !important">
            <tr>
                <th style="width:25% !important;height:'.$px.'"></th>
                <th style="width:75% !important;height:'.$px.'"></th>
            </tr>

            <tr>
                <td style="border:0;background:url(http://localhost/SI_timbangan/assets/images/logo_ppi_1.png)center no-repeat" rowspan="4"></td>
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
                    <th style="width:15% !important;height:150px"></th>
                </tr>

                <tr>
                    <td style="border-top:2px solid #000;padding:10px 0 5px;text-decoration:underline">SURAT JALAN</td>
                </tr>
            </table>
            ';


        // KONDISI KOP PADA SURAT JALAN > PPN ATAU NON-PPN
        if($data_kop->no_pkb == '160/21/WP' || $data_kop->nama == 'IBU. LANI' || $data_kop->pt == 'EDY NURWIDODO'){
            $html .= $kop_gak_pakai;
        }else if($data_kop->ker == 'MH' || $data_kop->ker == 'BK' || $data_kop->ker == 'MEDIUM LINER'){
            $html .= $kop_pakai;
        }else if($data_kop->ker == 'WP' && ($data_kop->popo == 'PO 03.2006.0004' || $data_kop->popo == 'PO 03.2007.0005' || $data_kop->popo == 'PO 03.2108.0005' || $data_kop->popo == 'PO 03.2109.0029' || $data_kop->popo == 'PO 03.2110.0001' || $data_kop->popo == 'PO 03.2110.0007' || $data_kop->pt == 'PT. KEMILAU INDAH PERMANA' || $data_kop->pt == 'PT. QINGDA MASPION PAPER PRODUCTS' || $data_kop->pt == 'PT. WIRAPETRO PLASTINDO' || $data_kop->pt == 'PT. MITRA KEMAS' || $data_kop->pt == 'PT. ALPHA ALTITUDE PAPER' || $data_kop->pt == 'PT. DOMINO MAKMUR PLASTINDO' || $data_kop->pt == 'PT. DOMINO SUKSES BERSAMA')){
            $html .= $kop_pakai;
        }else if($data_kop->ker == 'WP' || $data_kop->nama == 'WILLIAM CMBP'){
            $html .= $kop_gak_pakai;
        }else{
            $html .= $kop_gak_pakai;
        }


                        # # # # # # # # # D E T A I L # # # # # # # # # #


        $data_pl = $this->db->query("
        SELECT DISTINCT * FROM pl WHERE no_pkb='$jenis'
        GROUP BY no_pkb")->row();

        $html .= '<table cellspacing="0" style="font-size:11px !important;color:#000;border-collapse:collapse;vertical-align:top;width:100%;font-family:Arial !important">
            <tr>
                <th style="width:15% !important;height:8px"></th>
                <th style="width:1% !important;height:8px"></th>
                <th style="width:28% !important;height:8px"></th>
                <th style="width:15% !important;height:8px"></th>
                <th style="width:1% !important;height:8px"></th>
                <th style="width:40% !important;height:8px"></th>
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

        if($data_pl->no_kendaraan == '' || $data_pl->no_kendaraan == '-'){
            $plat = "";
        }else{
            $plat = $data_pl->no_kendaraan;
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
            <th style="width:5% !important;height:15px"></th>
            <th style="width:30% !important;height:15px"></th>
            <th style="width:15% !important;height:15px"></th>
            <th style="width:30% !important;height:15px"></th>
            <th style="width:10% !important;height:15px"></th>
            <th style="width:10% !important;height:15px"></th>
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
        $data_detail = $this->db->query("
        SELECT g_label,a.nm_ker AS ker,width,COUNT(*) AS qty,SUM(weight) AS berat,b.no_po as po FROM m_timbangan a
        INNER JOIN pl b ON a.id_pl=b.id
        WHERE b.no_pkb='$jenis'
        GROUP BY g_label,width,po
        ORDER BY po,g_label ASC,width ASC");
        // GROUP BY a.nm_ker,g_label,width,po
        // ORDER BY po,g_label ASC,width ASC
        // ORDER BY po,a.nm_ker DESC,g_label ASC,width ASC;

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
            if($data->ker == 'MH' || $data->ker == 'MI'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">KERTAS MEDIUM ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'WP'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">KERTAS COKLAT ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'BK' || $data->ker == 'BL'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">KERTAS B-KRAFT ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'MEDIUM LINER'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">KERTAS MEDIUM LINER ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'MH COLOR'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">KERTAS MEDIUM COLOR ROLL, LB '.round($data->width,2).'</td>';
            }else if($data->ker == 'MN'){
                $html .= '<td style="border:1px solid #000;padding:5px 0">MEDIUM NON SPEK ROLL, LB '.round($data->width,2).'</td>';
            }else{
                $html .= '<td style="border:1px solid #000;padding:5px 0">LB '.round($data->width,2).'</td>';
            }

            $html .= '<td style="border:1px solid #000;padding:5px 0">'.number_format($data->qty).' ROLL</td>
                <td style="border:1px solid #000;padding:5px 0">'.number_format($data->berat).' KG</td>
            </tr>';
        
            $no++;
            $tot_qty += $data->qty;
            $tot_berat += $data->berat;

        }

        // TAMBAH KOTAK KOSONG
        if($count == 1) {
            $cc = 1;
            $xx = 5;
        }else if($count == 2){
            $cc = 2;
            $xx = 4;
        }else if($count == 3){
            $cc = 3;
            $xx = 3;
        }else if($count == 4){
            $cc = 4;
            $xx = 2;
        }else if($count == 5){  
            $cc = 5;
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


        if($count_kop >= '13'){
            $px_ttd = '15px';
            $px_note = '20px';
            $akeh = 1;
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
                <td style="border:1px solid #000"></td>
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

        if ($ctk == '0') {
            $this->m_fungsi->_mpdf('',$html,10,10,$akeh,'P');
        }else{


            ////////////////////////////////// CETAK PACKING LIST ////////////////////////////////////////////

            
            $html = '';

            $data_header = $this->db->query("SELECT DISTINCT a.*,b.nm_ker,COUNT(b.roll) AS roll FROM pl a
                INNER JOIN m_timbangan b ON a.id=b.id_pl
                WHERE a.no_pkb='$jenis'
                GROUP BY a.id
                ORDER BY no_po DESC,g_label DESC,width DESC");

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

                if($data_pl->no_kendaraan == '' || $data_pl->no_kendaraan == '-'){
                    $paltPl = "";
                }else{
                    $paltPl = $data_pl->no_kendaraan;
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
                $qrTotPL = $this->db->query("SELECT width,COUNT(roll) AS roll FROM m_timbangan WHERE id_pl = '$id_pl' GROUP BY g_label,nm_ker,width ORDER BY nm_ker DESC,g_label ASC,width ASC");

                // CEK QC PACKING LIST
                if($ctk == 2){
                    $kop_detail = $this->db->query("SELECT id_pl,nm_ker,COUNT(*) AS jml_roll,SUM(weight) AS berat FROM m_timbangan WHERE id_pl='$id_pl' GROUP BY nm_ker ORDER BY nm_ker DESC");

                    if($kop_detail->row()->nm_ker == 'WP' || $kop_detail->row()->nm_ker == 'MN'){
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
                            <th style="padding:2px 0;width:10%"></th>
                            <th style="padding:2px 0;width:10%"></th>
                            <th style="padding:2px 0;width:10%"></th>
                            <th style="padding:2px 0;width:10%"></th>
                            <th style="padding:2px 0;width:10%"></th>
                            <th style="padding:2px 0;width:6%"></th>
                            <th style="padding:2px 0;width:23%"></th>
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
                        }else if($kd->nm_ker == 'WP' || $kd->nm_ker == 'MN'){
                            $dkop = '';
                            $joint = 'JOINT';
                        }else{
                            $dkop = '';
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
                            if($r->nm_ker == 'MH' || $r->nm_ker == 'MI'){
                                $cek = '<td style="border:1px solid #000">'.$r->rct.'</td>';
                            }else if($r->nm_ker == 'BK' || $r->nm_ker == 'BL'){
                                $cek = '<td style="border:1px solid #000">'.$r->bi.'</td>';
                            }else if($r->nm_ker == 'WP' || $kd->nm_ker == 'MN'){
                                $cek = '';
                            }else{
                                $cek = '';
                            }

                            $html .= '<tr>
                            <td style="border:1px solid #000">'.$no.'</td>
                            <td style="border:1px solid #000;letter-spacing:0.5px" colspan="2">'.$r->roll.'</td>
                            <td style="border:1px solid #000">'.$r->g_ac.'</td>
                            '.$cek.'
                            <td style="border:1px solid #000">'.$r->g_label.'</td>
                            <td style="border:1px solid #000">'.round($r->width,2).'</td>
                            <td style="border:1px solid #000">'.$r->weight.'</td>
                            <td style="border:1px solid #000">'.$r->joint.'</td>
                            <td style="border:1px solid #000;text-align:left;font-size:10px">'.strtoupper($r->ket).'</td>
                            </tr>';
                            $no++;
                        }

                        $totalRoll += $kd->jml_roll;
                        $totalBerat += $kd->berat;
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
                                $html .= '( '.$abc->roll.' - '.round($abc->width,2).' ) ';
                            }
                    $html .='</td></tr>';

                    $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE id_pl = '$id_pl' ORDER BY nm_ker DESC,g_label ASC,width ASC,tgl ASC,roll ASC");

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

                    $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE id_pl = '$id_pl' ORDER BY nm_ker DESC,g_label ASC,width ASC,tgl ASC,roll ASC");

                    $no = 1;
                    foreach ($data_detail->result() as $r) {

                        // if($ctk == 3){
                        //     $exp = explode(' ',$r->ket);
                        //     if($exp[0] == "-"){
                        //         $kkeett = $exp[0].' '.$exp[1].' '.$exp[2];
                        //     }else{
                        //         $kkeett = "";
                        //     }
                        // }else{
                        //     $kkeett = "";
                        // }

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

                        $html .= '<tr>
                            <td style="border:1px solid #000">'.$no.'</td>
                            <td style="border:1px solid #000">'.substr($r->roll,0, 5).'</td>
                            <td style="border:1px solid #000">'.substr($r->roll,6, 15).'</td>
                            <td style="border:1px solid #000">'.$r->g_label.'</td>
                            <td style="border:1px solid #000">'.round($r->width,2).'</td>
                            <td style="border:1px solid #000">'.$r->weight.'</td>
                            <td style="border:1px solid #000">'.$r->joint.'</td>
                            <td style="border:1px solid #000;text-align:left">'.$ketKet.'</td>
                        </tr>';
                        $no++;
                    }

                    $total_pl = $this->db->query("SELECT DISTINCT COUNT(*) AS totpl,width,SUM(weight) AS tot FROM m_timbangan WHERE id_pl = '$id_pl' ORDER BY roll")->row();
                    // atas 
                    $count_pl = $qrTotPL->num_rows();

                    if($count_pl == '1'){
                        $html .='
                        <tr>
                            <td style="border:1px solid #000" colspan="4" ><b>'.($total_pl->totpl).' ROLL (@ LB '.round( $total_pl->width,2).' )</b></td>';    
                    }else if($count_pl <> '1'){
                        $html .='<tr>
                            <td style="padding:0;border:1px solid #000;font-weight:bold" colspan="4" >-</td>';
                    }

                    $html .='<td style="border:1px solid #000"><b>Total</b></td>
                            <td style="border:1px solid #000"><b>'.number_format($total_pl->tot).'</b></td>
                            <td style="border:1px solid #000" colspan="2"></td>
                        </tr>';

                    // if($ctk == 3){
                    //     $html .='<tr>
                    //         <td style="padding:5px 0 0;border:0;font-weight:normal;text-align:left" colspan="8" >';
                    //             foreach($qrTotPL->result() as $abc){
                    //                 $html .= '( '.$abc->roll.' - '.round($abc->width,2).' ) ';
                    //             }
                    //     $html .='</td></tr>';
                    // }else{
                    //     $html .= '';
                    // }
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

        // LABEL CRR
        if($ctk == 3){
            $lmt = 'LIMIT 2';
        }else{
            $lmt = '';
        }

        // LABEL ROLL
        if($ctk == 'A4' || $ctk == 'a4' || $ctk == 'F4' || $ctk == 'f4'){
            $data_detail = $this->db->query("SELECT * FROM m_timbangan a
            INNER JOIN pl b ON a.id_pl=b.id
            WHERE b.no_pkb='$all' AND (ket LIKE '-%' OR ket LIKE ' %')
            ORDER BY a.nm_ker ASC,a.g_label ASC,a.width ASC,a.roll ASC");
        }else if($jenis != 0 && $all == 0){
            $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE id_pl='$jenis' ORDER BY nm_ker ASC,g_label ASC,width ASC,roll ASC");
        }else{
            $data_detail = $this->db->query("SELECT * FROM m_timbangan a
            INNER JOIN pl b ON a.id_pl=b.id
            WHERE b.no_pkb='$all'
            ORDER BY a.nm_ker ASC,a.g_label ASC,a.width ASC,a.roll ASC $lmt");
            // ORDER BY a.nm_ker ASC,a.g_label ASC,a.width ASC,a.roll ASC
            // ORDER BY a.nm_ker DESC,a.g_label DESC,a.width DESC,a.roll DESC
        }
        
        $data_perusahaan = $this->db->query("SELECT * FROM perusahaan limit 1")->row();

        $html = '';

        if ($data_detail->num_rows() > 0) {
        foreach ($data_detail->result() as $data ) {

            if($ctk == 0 || $ctk == 2 || $ctk == 'A4' || $ctk == 'F4'){

                $pp = "Epson";

                if($pp == "Epson"){
                    // $ppx = "0 0 0 5px";
                    $ppx = "0";
                }else{
                    $ppx = "0 0 0 35px";
                }

                if($data->weight == 0){
                    $html .= '';
                }else if($data->weight <> 0){
                    // 35PX
                    $html .= '
                    <div style="margin:'.$ppx.';color:#000">
                    <center> 
                        <h1 style="color:#000"> '.$data_perusahaan->nama.' </h1>  '.$data_perusahaan->daerah.' , Email : '.$data_perusahaan->email.'
                    </center>
                    </div>
                    <hr>';

                    // 35PX
                    $html .= '<br><br><br>
                             <table width="100%" cellspacing="0" cellpadding="5" style="font-size:52px;color:#000;margin:'.$ppx.'">
                                <tr>
                                    <td style="border:1px solid #000" align="left" width="50%">QUALITY</td>
                                    <td style="border:1px solid #000" align="center">'.$data->nm_ker.'</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #000" align="left">GRAMMAGE</td>
                                    <td style="border:1px solid #000" align="center">'.$data->g_label.' GSM</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #000" align="left">WIDTH</b></td>
                                    <td style="border:1px solid #000" align="center">'.round($data->width,2).' CM</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #000" align="left">DIAMETER</td>
                                    <td style="border:1px solid #000" align="center">'.$data->diameter.' CM</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #000" align="left">WEIGHT</td>
                                    <td style="border:1px solid #000" align="center">'.$data->weight.' KG</td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #000" align="left">JOINT</td>
                                    <td style="border:1px solid #000" align="center">'.$data->joint.' </td>
                                </tr>
                                <tr>
                                    <td style="border:1px solid #000" align="left">ROLL NUMBER</td>
                                    <td style="border:1px solid #000" align="center">'.$data->roll.' </td>
                                </tr>
                        </table>';
                    }
            }else if($ctk == 1){
                if($data->weight == 0){
                    $html .= '';
                }else if($data->weight <> 0){
                    $html .= '
                        <div style="padding-top:100px;display:block;">
                            <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size:37px;margin-bottom:605px">
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
                                    <td align="center">'.$data->weight.' KG</td>
                                </tr>
                                <tr>
                                    <td align="left">JOINT</td>
                                    <td align="center">'.$data->joint.' </td>
                                </tr>
                                <tr>
                                    <td align="left">ROLL NUMBER</td>
                                    <td align="center">'.$data->roll.'</td>
                                </tr>
                            </table>
                        </div>';
                }
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
                $this->m_fungsi->_mpdf('',$html,10,10,10,'L');
            }else if($ctk == 'F4'){
                $this->m_fungsi->_mpdfCustom('',$html,10,10,10,'L');
            }else if($ctk == 1 || $ctk == 3){
                $this->m_fungsi->_mpdf('',$html,10,10,10,'P');
            }else if($ctk == 2){
                $this->m_fungsi->_mpdfCustom('',$html,10,10,10,'L');
            }else{
                $this->m_fungsi->_mpdf('',$html,10,10,10,'L');
            }
            
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
            $sql_rekap = $this->db->query("
                SELECT width,
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
                    $isi_query = "
                    SELECT width,
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

                    $isi_query = "
                    SELECT width,g_label AS gsm,
                    (SELECT COUNT(*) FROM m_timbangan WHERE width = a.width AND g_label = a.g_label AND nm_ker='WP' AND STATUS='0' AND tgl BETWEEN '2020-11-01' AND '$datewp') AS jml,
                    SUM(weight) AS all_total
                    FROM m_timbangan a WHERE (nm_ker='WP' OR nm_ker='wp') AND STATUS='0' AND tgl BETWEEN '2020-11-01' AND '$datewp' AND g_label='$gsm'
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

            $sql_uk_all = $this->db->query("SELECT COUNT(*) AS totalluk FROM m_timbangan WHERE (nm_ker='MH' OR nm_ker='MI') AND STATUS='0' AND width='$jenis'")->row();

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
            $sql_gsm =  $this->db->query("SELECT g_label, COUNT(g_label) AS totgsm FROM m_timbangan WHERE width='$jenis' AND STATUS='0' AND $where GROUP BY g_label ORDER BY g_label ASC")->result();

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
                $sql_ker_mh = $this->db->query("SELECT nm_ker, COUNT(nm_ker) AS totker FROM m_timbangan WHERE width='$jenis' AND g_label='$gsm_glabel' AND STATUS='0' AND nm_ker='$title1' GROUP BY nm_ker ORDER BY nm_ker ASC")->result();

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
                    $sql_roll_mh = $this->db->query("SELECT*FROM m_timbangan WHERE width='$jenis' AND g_label='$gsm_glabel' AND STATUS='0' AND nm_ker='$mh' ORDER BY roll ASC")->result();

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
                $sql_ker_mi = $this->db->query("SELECT nm_ker, COUNT(nm_ker) AS totker FROM m_timbangan WHERE width='$jenis' AND g_label='$gsm_glabel' AND STATUS='0' AND nm_ker='$title2' GROUP BY nm_ker ORDER BY nm_ker ASC")->result();

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
                    $sql_roll_mi = $this->db->query("SELECT*FROM m_timbangan WHERE width='$jenis' AND g_label='$gsm_glabel' AND STATUS='0' AND nm_ker='$mi' ORDER BY roll ASC")->result();

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
        $tahun = $_GET['tahun'];
        $bulan = $_GET['bulan'];
        $jenis = $_GET['jenis'];

        $html = '';

        $html .= '<table cellspacing="0" style="font-size:12px;color:#00;border-collapse:collapse;vertical-align:top;width:100%">
            <tr>
                <th style="padding:0;width:3%"></th>
                <th style="padding:0;width:6%"></th>
                <th style="padding:0;width:4%"></th>
                <th style="padding:0;width:22%"></th>
                <th style="padding:0;width:7%"></th>
                <th style="padding:0;width:5%"></th>
                <th style="padding:0;width:8%"></th>
                <th style="padding:0;width:25%"></th>
                <th style="padding:0;width:10%"></th>
                <th style="padding:0;width:11%"></th>
            </tr>';
        $html .= '<tr>
            <td style="padding:0 0 5px;text-align:center;font-weight:bold" colspan="10">PENJUALAN HARIAN</td>
        </tr>
        <tr>
            <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">NO</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">HARI</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">TGL</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">PELANGGAN</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">NO SJ</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">JML</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">BERAT</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold"><u>GSM</u> / UKURAN</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">HARGA</td>
            <td style="background:#ddd;border:1px solid #000;padding:5px 0;text-align:center;font-weight:bold">TOTAL</td>
        </tr>';

        // AMBIL BULAN
        $getBulanKop = $this->db->query("SELECT DISTINCT SUBSTRING(b.tgl, 1, 7) AS ambil_bulan FROM m_timbangan a
        INNER JOIN pl b ON a.id_pl=b.id
        WHERE b.tgl LIKE '%$tahun-$bulan%'
        GROUP BY b.tgl
        ORDER BY b.tgl");

        // TAMPIL DATA BULAN
        foreach($getBulanKop->result() as $r){
            $html .= '<tr>
                <td style="border:1px solid #000;background:#ddd;padding:5px;text-transform:uppercase;font-weight:bold" colspan="10">'.$this->m_fungsi->fgGetBulan($r->ambil_bulan).'</td>
            </tr>';

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
            $getIsiPerBulan = $this->db->query("
            SELECT DISTINCT b.tgl,a.nm_ker,b.nama,b.nm_perusahaan,COUNT(*) AS jumlah,SUM(a.weight) AS berat,b.no_pkb,b.no_po FROM m_timbangan a
            INNER JOIN pl b ON a.id_pl=b.id
            WHERE b.tgl LIKE '%$r->ambil_bulan%' $where
            GROUP BY b.tgl,b.no_pkb
            ORDER BY b.tgl ASC,a.nm_ker ASC,b.no_pkb ASC");

            // TAMPIL DATA
            $i = 0;
            $totJml = 0;
            $totBerat = 0;
            foreach ($getIsiPerBulan->result() as $isi) {
                $i++;

                if($isi->nm_perusahaan == "-"){
                    $isiNama = $isi->nama;
                }else{
                    $isiNama = $isi->nm_perusahaan;
                }

                $html .= '<tr>
                    <td style="border:1px solid #000;vertical-align:middle;padding:5px 0;text-align:center">'.$i.'</td>
                    <td style="border:1px solid #000;vertical-align:middle;padding:5px 0;text-align:center;text-transform:uppercase">'.$this->m_fungsi->getHariIni($isi->tgl).'</td>
                    <td style="border:1px solid #000;vertical-align:middle;padding:5px 0;text-align:center">'.number_format($this->m_fungsi->fgGetTglIni($isi->tgl)).'</td>
                    <td style="border:1px solid #000;vertical-align:middle;padding:5px 3px">'.$isiNama.'</td>
                    <td style="border:1px solid #000;vertical-align:middle;padding:5px 3px;text-align:center">'.$isi->no_pkb.'</td>
                    <td style="border:1px solid #000;vertical-align:middle;padding:5px 0;text-align:center">'.number_format($isi->jumlah).'</td>
                    <td style="border:1px solid #000;vertical-align:middle;padding:5px 0;text-align:center">'.number_format($isi->berat).'</td>';
                
                // GSM
                $getIsiGsm = $this->db->query("SELECT a.g_label FROM m_timbangan a
                INNER JOIN pl b ON a.id_pl=b.id
                WHERE b.no_pkb='$isi->no_pkb'
                GROUP BY g_label
                ORDER BY g_label");

                $html .= '<td style="border:1px solid #000;vertical-align:middle;padding:5px 3px">';

                foreach($getIsiGsm->result() as $iGsm){
                    $html .= ' <u>'.$iGsm->g_label.'</u>';

                    // AMBIL UKURAN
                    $getIsiGsmUk = $this->db->query("SELECT width,COUNT(roll) AS jml FROM m_timbangan a
                    INNER JOIN pl b ON a.id_pl=b.id
                    WHERE b.no_pkb='$isi->no_pkb' AND a.g_label='$iGsm->g_label'
                    GROUP BY width
                    ORDER BY width");

                    foreach($getIsiGsmUk->result() as $iGsmUk){
                        $html .= '/'.round($iGsmUk->width, 2);
                    }

                    // $html .= '';
                }

                $html .= '</td>
                    <td style="border:1px solid #000;padding:5px 0"></td>
                    <td style="border:1px solid #000;padding:5px 0"></td>
                </tr>';

                $totJml += $isi->jumlah;
                $totBerat += $isi->berat;
            }

            $html .= '<tr>
                <td style="border:1px solid #000;background:#ddd;padding:5px;font-weight:bold" colspan="5"></td>
                <td style="border:1px solid #000;background:#ddd;padding:5px;font-weight:bold;text-align:center">'.number_format($totJml).'</td>
                <td style="border:1px solid #000;background:#ddd;padding:5px;font-weight:bold;text-align:center">'.number_format($totBerat).'</td>
                <td style="border:1px solid #000;background:#ddd;padding:5px;font-weight:bold" colspan="3"></td>
            </tr>';

        }

        $html .= '</table>';

        $this->m_fungsi->_mpdf2('',$html,10,10,10,'L','FG',2);

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
        WHERE d.tgl=b.tgl AND c.nm_ker='WP') AS jmlWP
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
            $totot = $r->jmlMH+$r->jmlBK+$r->jmlWP;

            // TOTAL
            $totJmlMH += $r->jmlMH;
            $totJmlWP += $r->jmlWP;
            $totJmlBK += $r->jmlBK;
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
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($r->jmlMH).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($r->jmlWP).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($r->jmlBK).'</td>
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
            $getIsiCountBeratMH = $this->db->query("SELECT COUNT(*) AS countt,SUM(a.weight) AS beratt FROM m_timbangan a
            INNER JOIN pl b ON a.id_pl=b.id
            WHERE b.tgl LIKE '%$r->ambil_bulan%' AND a.nm_ker LIKE '%M%'")->row();
            // WRP
            $getIsiCountBeratWP = $this->db->query("SELECT COUNT(*) AS countt,SUM(a.weight) AS beratt FROM m_timbangan a
            INNER JOIN pl b ON a.id_pl=b.id
            WHERE b.tgl LIKE '%$r->ambil_bulan%' AND a.nm_ker='WP'")->row();
            // BK
            $getIsiCountBeratBK = $this->db->query("SELECT COUNT(*) AS countt,SUM(a.weight) AS beratt FROM m_timbangan a
            INNER JOIN pl b ON a.id_pl=b.id
            WHERE b.tgl LIKE '%$r->ambil_bulan%' AND a.nm_ker='BK'")->row();
            // TOTAL JML ROLL, TONASE PER BULAN
            $totBlnRoll = $getIsiCountBeratMH->countt + $getIsiCountBeratWP->countt + $getIsiCountBeratBK->countt;
            $totBlnTonase = $getIsiCountBeratMH->beratt + $getIsiCountBeratWP->beratt + $getIsiCountBeratBK->beratt;

            $html .= '<tr>
                <td style="border:1px solid #000;padding:5px 0;text-align:center;text-transform:uppercase">'.substr($this->m_fungsi->fgGetBulan($r->ambil_bulan),0, 3).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiRitaseMH).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiCountBeratMH->countt).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiCountBeratMH->beratt).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiRitaseWP).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiCountBeratWP->countt).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiCountBeratWP->beratt).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiRitaseBK).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiCountBeratBK->countt).'</td>
                <td style="border:1px solid #000;padding:5px 0;text-align:center">'.number_format($getIsiCountBeratBK->beratt).'</td>
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
            $allIsiThnjmlMH += $getIsiCountBeratMH->beratt;
            $allIsiThnjmlWP += $getIsiCountBeratWP->beratt;
            $allIsiThnjmlBK += $getIsiCountBeratBK->beratt;

            // PER HITUNGAN TOTAL KESELURAN PER TAHUN
            $totAllRitase += $getIsiRitaseMH + $getIsiRitaseWP + $getIsiRitaseBK;
            $totAllRoll += $getIsiCountBeratMH->countt + $getIsiCountBeratWP->countt + $getIsiCountBeratBK->countt;
            $totAllTonase += $getIsiCountBeratMH->beratt + $getIsiCountBeratWP->beratt + $getIsiCountBeratBK->beratt;
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
        ORDER BY a.flute DESC,a.ukuran ASC");
        // ORDER BY a.ukuran ASC");
        
        $count = $data_detail->num_rows();

        // id_perusahaan = 80 > PT. ANUGRAH JAYA PACKINDO
        // jarak 0 > 20 > 40 > 60 > 80
        if($count >= 7 && $data_pl->id_perusahaan == '80'){
            $px = '0';
        }else if($count >= 6 && $data_pl->id_perusahaan == '80'){
            $px = '10';
        }else if($count >= 5 && $data_pl->id_perusahaan == '80'){
            $px = '20';
        }else if($count >= 4 && $data_pl->id_perusahaan == '80'){
            $px = '60';
        }else{
            $px = '80';
        }

                             # # # # # # # # # K O P # # # # # # # # # #


        $kop = '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:Arial !important">
            <tr>
                <th style="width:25% !important;height:'.$px.'"></th>
                <th style="width:75% !important;height:'.$px.'"></th>
            </tr>

            <tr>
                <td style="border:0;background:url(http://localhost/SI_timbangan/assets/images/logo_ppi_1.png)center no-repeat" rowspan="4"></td>
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

        if($data_pl->nm_perusahaan == 'MARDALENA' || $data_pl->no_po == '03/GANDUNG/IX/2021' || $data_pl->no_po == '8-10-21' || $data_pl->no_po == '16-11-21' || $data_pl->nm_perusahaan == 'ATIK ( SURYA JAYA SEJATI )' || $data_pl->nm_perusahaan == 'YOTA LAREDO' || $data_pl->nm_perusahaan == 'BP. AJI' || $data_pl->nm_perusahaan == 'SUPRIYANTO' || $data_pl->nm_perusahaan == 'RADI') {
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
                <td style="border:1px solid #000;padding:5px 0">'.$data->ukuran.'</td>
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


        $html .= '<table cellspacing="0" style="font-size:11px !important;color:#000;border-collapse:collapse;text-align:center;width:100%;font-family:Arial !important">
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
            <td style="border:1px solid #000;padding:5px 0">IBU. SILVI<br>PPIC</td>
            <td style="border:1px solid #000;padding:5px 0">BP. SUMARTO<br>SPV GUDANG</td>
            <td style="border:1px solid #000;padding:5px 0">BP. SUPRI<br>KA. PRODUKSI</td>
            <td style="border:1px solid #000;padding:5px 0">BP. WEINARTO <br>GM</td>
            <td style="border:1px solid #000"></td>
            <td style="border:1px solid #000"></td>
        </tr>

        <tr>
            <td style="height:50px" colspan="7"></td>
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

        
            ################## CETAK


        if($ctk == '0') {
            $this->m_fungsi->_mpdf('',$html,10,10,10,'P');
        }else{
            echo $html;
        }
    }

    function lapSHEET() {
        $tgl1 = $_GET['tgl1'];
        $tgl2 = $_GET['tgl2'];

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

            // CARA DI TGL DAN GET ID PERUSAHAAN
            // $getTglnIDpt = $this->db->query("SELECT a.tgl,a.id_perusahaan,a.no_pkb,c.nm_perusahaan FROM pl_box a
            // INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
            // INNER JOIN m_box b ON a.id=b.id_pl
            // WHERE a.no_pkb LIKE '%SHEET%' AND a.tgl='$r->tgl'
            // GROUP BY a.id_perusahaan
            // ORDER BY a.no_pkb ASC");

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

                $html .= '<tr>
                    <td>RIT '.$ii.', PENGIRIMAN SHEET KE</td>
                </tr>';

                // // GET ISINYA
                // $getIsiDong = $this->db->query("SELECT a.tgl,a.id_perusahaan,a.no_pkb,a.no_po,b.ukuran,b.flute,b.qty,b.qty_ket,c.nm_perusahaan FROM pl_box a
                // INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
                // INNER JOIN m_box b ON a.id=b.id_pl
                // WHERE a.no_pkb LIKE '%SHEET%' AND a.tgl='$rr->tgl' AND a.id_perusahaan='$rr->id_perusahaan'
                // ORDER BY a.no_pkb ASC,b.ukuran ASC");

                // GET ID DARI PLAT
                $getIsiPlat = $this->db->query("SELECT a.tgl,a.id_perusahaan,a.no_pkb,c.nm_perusahaan,a.no_kendaraan,SUM(b.qty) AS qty FROM pl_box a
                INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
                INNER JOIN m_box b ON a.id=b.id_pl
                WHERE a.no_pkb LIKE '%SHEET%' AND a.tgl='$rr->tgl' AND a.no_kendaraan='$rr->no_kendaraan'
                GROUP BY a.id_perusahaan
                ORDER BY a.no_pkb ASC");

                $totIsi = 0;
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
                    ORDER BY a.no_pkb ASC,b.flute DESC,b.ukuran ASC");
                    // ORDER BY a.no_pkb ASC,b.ukuran ASC");

                    foreach($getSenggolIsi->result() as $isi){
                        $html .= '<tr>
                            <td>- '.$isi->no_po.' - '.$isi->ukuran.' - '.$isi->flute.' - '.number_format($isi->qty).' '.$isi->qty_ket.'</td>
                        </tr>';
                    }

                    $totIsi += $rrr->qty;
                }

                // TOTAL ISINYA
                $html .= '<tr>
                    <td>TOTAL '.number_format($totIsi).' '.$isi->qty_ket.'</td>
                </tr>';

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
            }else{
                $wdth = '43%';
                $kopWidth = '';
                $kopDetail = '';
                $sheetIsi = '';
            }
			
			if($ctk != '2'){
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
				$html .= '<tr>
					<td style="font-weight:bold;border:1px solid #000;padding:5px">TANGGAL</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px">NO SJ</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px">CUSTOMER</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px">NO PO</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px">UKURAN</td>
					<td style="font-weight:bold;border:1px solid #000;padding:5px">QTY</td>
                    '.$kopDetail.'
				</tr>';
			}

			$getQIsi = $this->db->query("SELECT a.tgl,a.no_surat,a.id_perusahaan,c.nm_perusahaan,a.no_po,b.ukuran,b.qty FROM pl_box a
			INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
			INNER JOIN m_box b ON a.id=b.id_pl 
			WHERE a.no_pkb LIKE '%$jenis%' AND a.tgl BETWEEN '$tgl1' AND '$tgl2'
            AND (a.id_perusahaan LIKE '%$tttt%')
			GROUP BY a.tgl,b.ukuran,c.pimpinan,a.no_pkb
			ORDER BY a.tgl ASC,a.no_pkb ASC,b.flute DESC,b.ukuran ASC");

			foreach($getQIsi->result() as $isi){
				$html .= '<tr>
					<td style="border:1px solid #000;padding:5px">'.$this->m_fungsi->tglInd_skt($isi->tgl).'</td>
					<td style="border:1px solid #000;padding:5px">'.$isi->no_surat.'</td>
					<td style="border:1px solid #000;padding:5px;text-align:left">'.$isi->nm_perusahaan.'</td>
					<td class="str" style="border:1px solid #000;padding:5px;text-align:left">'.$isi->no_po.'</td>
					<td class="str" style="border:1px solid #000;padding:5px;text-align:left">'.$isi->ukuran.'</td>
					<td class="str" style="border:1px solid #000;padding:5px;text-align:right">'.number_format($isi->qty).'</td>
                    '.$sheetIsi.'
				</tr>';
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
				// 73  PT. DELTA DUNIA SANDANG TEKSTIL       BP. BENNY   
				if($r->id_pt == 67){
					$nmCus = 'DDT 2';
				}else if($r->id_pt == 68){
					$nmCus = 'DMST 3';
				}else if($r->id_pt == 69){
					$nmCus = 'DDT 1';
				}else if($r->id_pt == 70){
					$nmCus = 'DDT 4';
				}else if($r->id_pt == 71){
					$nmCus = 'DMST 1';
				}else if($r->id_pt == 73){
					$nmCus = 'DDST';
				}else{
                    $nmCus = $r->nm_perusahaan;
                }

				if($r->no_kendaraan == '-' || $r->no_kendaraan == ''){
					$plat = '';
				}else{
					$plat = $r->no_kendaraan;
				}

                // ISI DI UKURAN
                if($r->id_pt == 82 || $r->id_pt == 98 || $r->id_pt == 101 || $r->id_pt == 108 || $r->id_pt == 110){
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

    function lapPenjperPO() {
        $jenis = $_GET['jenis'];
        $pt = $_GET['pt'];
        $ukuran = $_GET['ukuran'];
        $ctk = $_GET['ctk'];

        $html = '';
        $html .= '<style>.str{mso-number-format:\@}</style>';
		$html .= '<table style="font-size:11px;width:100%;border-collapse:collapse;color:#000;margin:0;padding:0">';

        if($pt != 0){
            $t = $pt;
        }else{
            $t = '';
        }

        if($ukuran != 0 || $ukuran == 'BOX'){
            $uk = $ukuran;
        }else{
            $uk = '';
        }

        // GET DATA CUSTOMER
        $qGetPt = $this->db->query("SELECT a.id_perusahaan,c.pimpinan,c.nm_perusahaan FROM pl_box a
        INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
        INNER JOIN m_box b ON a.id=b.id_pl
        WHERE a.no_pkb LIKE '%$jenis%' AND a.id_perusahaan LIKE '%$t%' AND b.ukuran LIKE '%$uk%'
        GROUP BY a.id_perusahaan
        ORDER BY c.nm_perusahaan");

        $html .= '<tr>
            <td style="border:1px solid #000;padding:5px;font-weight:bold;width:5%;text-align:center">NO</td>
            <td style="border:1px solid #000;padding:5px;font-weight:bold;width:55%">CUSTOMER</td>
            <td style="border:1px solid #000;padding:5px;font-weight:bold;width:40%">TOTAL</td>
        </tr>';

        $i = 0;
        foreach($qGetPt->result() as $r){
            $i++;
            $html .= '<tr>
                <td style="border:1px solid #000;padding:5px;font-weight:bold;text-align:center">'.$i.'</td>
                <td style="border:1px solid #000;padding:5px;font-weight:bold">'.$r->nm_perusahaan.'</td>
                <td style="border:1px solid #000;padding:5px;font-weight:bold"></td>
            </tr>';

            // GET MASING - MASING PO
            $qGetPO = $this->db->query("SELECT a.id_perusahaan,c.pimpinan,c.nm_perusahaan,a.no_po FROM pl_box a
            INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
            INNER JOIN m_box b ON a.id=b.id_pl
            WHERE a.no_pkb LIKE '%$jenis%' AND a.id_perusahaan LIKE '%$r->id_perusahaan%' AND b.ukuran LIKE '%$uk%'
            GROUP BY a.id_perusahaan,a.no_po
            ORDER BY c.nm_perusahaan ASC,a.no_po ASC");

            $ii = 0;
            foreach($qGetPO->result() as $po){
                $ii++;
                $html .= '<tr>
                    <td style="border:1px solid #000;padding:5px;text-align:center">'.$ii.'</td>
                    <td class="str" style="border:1px solid #000;padding:5px;font-weight:bold">'.$po->no_po.'</td>
                    <td style="border:1px solid #000;padding:5px;font-weight:bold"></td>
                <tr>';

                // GET ISINYA
				// LIST TAMPIL SEMUA UKURAN
                // $qGetIsi = $this->db->query("SELECT a.id_perusahaan,c.nm_perusahaan,a.no_po,b.ukuran,b.qty,a.tgl,a.no_surat FROM pl_box a
                // INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
                // INNER JOIN m_box b ON a.id=b.id_pl
                // WHERE a.no_pkb LIKE '%$jenis%' AND a.id_perusahaan LIKE '%$po->id_perusahaan%' AND a.no_po LIKE '%$po->no_po%' AND b.ukuran LIKE '%$uk%'
                // ORDER BY b.ukuran,a.tgl,a.no_pkb");

				// GROUP PER UKURAN
				$qGetIsi = $this->db->query("SELECT a.id_perusahaan,c.nm_perusahaan,a.no_po,b.ukuran,SUM(b.qty) AS qty,a.tgl,a.no_surat FROM pl_box a
                INNER JOIN m_perusahaan c ON a.id_perusahaan=c.id
                INNER JOIN m_box b ON a.id=b.id_pl
                WHERE a.no_pkb LIKE '%$jenis%' AND a.id_perusahaan LIKE '%$po->id_perusahaan%' AND a.no_po LIKE '%$po->no_po%' AND b.ukuran LIKE '%$uk%'
				GROUP BY b.ukuran
                ORDER BY b.ukuran,a.tgl,a.no_pkb");

                foreach($qGetIsi->result() as $isi){
                    $html .= '<tr>
                        <td style="border:1px solid #000;padding:5px"></td>
                        <td style="border:1px solid #000;padding:5px">'.$isi->ukuran.'</td>
                        <td class="str" style="border:1px solid #000;padding:5px">'.number_format($isi->qty).'</td>
                    <tr>';
                }
            }
        }

        $html .= '</table>';

        if ($ctk == '0') {
            echo $html;
        }else if ($ctk == '1') {
			$this->m_fungsi->_mpdf2('',$html,10,10,10,'L','PENJUALAN','');
        }else{
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=judul.xls");
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
				<td style="border:0;padding:0;width:9%"></td>
				<td style="border:0;padding:0;width:15%"></td>
				<td style="border:0;padding:0;width:11%"></td>
				<td style="border:0;padding:0;width:11%"></td>
				<td style="border:0;padding:0;width:11%"></td>
				<td style="border:0;padding:0;width:9%"></td>
				<td style="border:0;padding:0;width:11%"></td>
				<td style="border:0;padding:0;width:11%"></td>
				<td style="border:0;padding:0;width:12%"></td>
			</tr>';

			// if($getKpd->kepada != '-' && $getKpd->nm_perusahaan != '-'){
			// 	$ptpt = $getKpd->kepada.' - '.$getKpd->nm_perusahaan;
			// }else if($getKpd->kepada == '-' && $getKpd->nm_perusahaan != '-'){
			// 	$ptpt = $getKpd->nm_perusahaan;
			// }else if($getKpd->kepada != '-' && $getKpd->nm_perusahaan == '-'){
			// 	$ptpt = $getKpd->kepada;
			// }else{
			// 	$ptpt = $getKpd->nm_perusahaan;
			// }
			// $html .= '<tr>
			// 	<td style="border:0;padding:0 0 10px;font-weight:bold;text-align:left" colspan="9">'.$ptpt.'</td>
			// </tr>';

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
            }

			// // GET BULAN
			// $sqlGetBulan = $this->db->query("SELECT SUBSTRING(tgl, 1, 7) AS get_bulan,id_pt FROM invoice_header
			// WHERE id_pt='$getKpd->id_pt' AND tgl LIKE '%$tgl%'
			// GROUP BY MONTH(tgl)");
			// foreach($sqlGetBulan->result() as $getBln){

			// 	$html .= '<tr>
			// 		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">TGL</td>
			// 		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">NO INV</td>
			// 		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">BERAT</td>
			// 		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">HARGA</td>
			// 		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">TOTAL</td>
			// 		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">TGL J.TEMPO</td>
			// 		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">TGL BAYAR</td>
			// 		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">PAID</td>
			// 		<td style="border:1px solid #000;text-align:center;font-weight:bold;padding:5px">KOM. PIUTANG</td>
			// 	</tr>';

			// 	// GET NO INVOICE DULU
			// 	$sqlGetNoInv = $this->db->query("SELECT head.id,head.tgl,head.jto,head.no_invoice,
			// 	(SELECT COUNT(*) FROM invoice_harga li
			// 	WHERE head.no_invoice=li.no_invoice) AS cnt,head.id_pt
			// 	FROM invoice_header head
			// 	WHERE head.id_pt='$getBln->id_pt' AND head.tgl LIKE '%$getBln->get_bulan%'
			// 	GROUP BY head.no_invoice");
				
            //     $tottot = 0;
            //     $totKomPiutang = 0;
            //     $totAllBerat = 0;
            //     $totAllPaid = 0;
			// 	foreach($sqlGetNoInv->result() as $getInv){
			// 		if($getInv->cnt == 1){
			// 			$rs = 'rowspan="2"';
			// 		}else{
			// 			$ss = $getInv->cnt + 1;
			// 			$rs = 'rowspan="'.$ss.'"';
			// 		}

			// 		$html .= '<tr>
			// 			<td style="border:1px solid #000;padding:5px" '.$rs.'>'.$this->m_fungsi->tglInd_skt($getInv->tgl).'</td>
			// 			<td style="border:1px solid #000;padding:5px 3px" '.$rs.'>'.$getInv->no_invoice.'</td>
			// 			<td style="border:0;padding:0" colspan="3"></td>
			// 			<td style="border:1px solid #000;padding:5px" '.$rs.'>'.$this->m_fungsi->tglInd_skt($getInv->jto).'</td>';
                    
            //             $getBayar = $this->db->query("SELECT*FROM invoice_pay WHERE no_invoice='$getInv->no_invoice' ORDER BY id");
            //             $html .='<td style="border:1px solid #000;padding:2px 3px;line-height:1.8" '.$rs.'>';
            //                 foreach($getBayar->result() as $tglpay){
            //                     $html .= $this->m_fungsi->tglInd_skt($tglpay->tgl_bayar).'<br/>';
            //                 }
            //             $html .='</td>';

            //             $html .='<td style="border:1px solid #000;padding:2px 3px;line-height:1.8" '.$rs.'>';
            //                 $totpay = 0;
            //                 $subpay = 0;
            //                 foreach($getBayar->result() as $jmlPay){
            //                     $html .= number_format($jmlPay->jumlah).'<br/>';
            //                     $totpay += $jmlPay->jumlah;
            //                 }
            //                 $subpay += $totpay;
            //             $html .='</td>';

            //             $getKomPiu = $this->db->query("SELECT SUM(li.weight) AS berat,SUM(li.seset) AS seset,p.harga, h.* FROM invoice_header h
            //             INNER JOIN invoice_list li ON h.no_invoice = li.no_invoice
            //             INNER JOIN invoice_harga p ON li.no_invoice = p.no_invoice AND li.no_po=p.no_po AND li.nm_ker=p.nm_ker AND li.g_label=p.g_label
            //             WHERE h.no_invoice='$getInv->no_invoice'
            //             GROUP BY h.no_invoice,li.no_po,li.nm_ker DESC,li.g_label");
            //             $html .='<td style="border:1px solid #000;padding:0 5px;line-height:1.8" '.$rs.'>';
            //                 $totTerbilang2 = 0;
            //                 foreach($getKomPiu->result() as $jmlPay){
            //                     $beratMinSst2 = $jmlPay->berat - $jmlPay->seset;
            //                     $totBeratXHarga2 = $beratMinSst2 * $jmlPay->harga;
            //                     if ($jmlPay->ppn == 1) { // PPN 10%
            //                         $terbilang2 = $totBeratXHarga2 + (0.1 * $totBeratXHarga2);
            //                     } else if ($jmlPay->ppn == 2) { // PPH22
            //                         $terbilang2 = $totBeratXHarga2 + (0.1 * $totBeratXHarga2) + (0.01 * $totBeratXHarga2);
            //                     } else { // NON PPN
            //                         $terbilang2 = $totBeratXHarga2;
            //                     }
            //                     $totTerbilang2 += $terbilang2;
            //                 }

            //                 $i_komPiutang = $totTerbilang2 - $totpay;
            //                 $html .= number_format($i_komPiutang).'<br/>';
            //             $html .='</td>';
            //         $html .='</tr>';
					
			// 		// GET ISI
			// 		$sqlIsi = $this->db->query("SELECT SUM(li.weight) AS berat,SUM(li.seset) AS seset,p.harga, h.* FROM invoice_header h
			// 		INNER JOIN invoice_list li ON h.no_invoice = li.no_invoice
			// 		INNER JOIN invoice_harga p ON li.no_invoice = p.no_invoice AND li.no_po=p.no_po AND li.nm_ker=p.nm_ker AND li.g_label=p.g_label
			// 		WHERE h.id='$getInv->id' AND h.id_pt='$getInv->id_pt' AND h.tgl LIKE '%$getInv->tgl%'
			// 		GROUP BY h.no_invoice,li.no_po,li.nm_ker DESC,li.g_label");
			// 		$totTerbilang = 0;
            //         $subBerat = 0;
			// 		foreach($sqlIsi->result() as $isi){
			// 			$beratMinSst = $isi->berat - $isi->seset;
			// 			$html .= '<tr>
			// 				<td style="border:1px solid #000;border-width:0 1px 1px;padding:5px 3px">'.number_format($beratMinSst).'</td>
			// 				<td style="border:1px solid #000;border-width:0 1px 1px;padding:5px 3px">'.number_format($isi->harga).'</td>';
						
			// 			// TENTUKAN TOTAL
			// 			$totBeratXHarga = $beratMinSst * $isi->harga;
			// 			if ($isi->ppn == 1) { // PPN 10%
			// 				$terbilang = $totBeratXHarga + (0.1 * $totBeratXHarga);
			// 			}else if ($isi->ppn == 2) { // PPH22
			// 				$terbilang = $totBeratXHarga + (0.1 * $totBeratXHarga) + (0.01 * $totBeratXHarga);
			// 			}else { // NON PPN
			// 				$terbilang = $totBeratXHarga;
			// 			}
	
			// 			$html .='<td style="border:1px solid #000;border-width:0 1px 1px;padding:5px 3px">'.number_format($terbilang).'</td>
			// 			</tr>';
			// 			// $html .='</tr>';
                        
            //             $subBerat += $beratMinSst;
			// 			$totTerbilang += $terbilang;
			// 		}

            //         $totAllBerat += $subBerat;
            //         $tottot += $totTerbilang;
            //         $totKomPiutang += $i_komPiutang;
            //         $totKomPiutang += 0;
            //         $totAllPaid += $subpay;
			// 	}

            //     $html .= '<tr>
			// 		<td style="border:1px solid #000;font-weight:bold;border-width:1px 0 1px 1px;padding:5px" colspan="2"></td>
			// 		<td style="border:1px solid #000;font-weight:bold;border-width:1px 0;padding:5px 3px">'.number_format($totAllBerat).'</td>
			// 		<td style="border:1px solid #000;font-weight:bold;border-width:1px 0;padding:5px"></td>
			// 		<td style="border:1px solid #000;font-weight:bold;border-width:1px 0;padding:5px 3px">'.number_format($tottot).'</td>
			// 		<td style="border:1px solid #000;font-weight:bold;border-width:1px 0;padding:5px" colspan="2"></td>
			// 		<td style="border:1px solid #000;font-weight:bold;border-width:1px 0;padding:5px 3px">'.number_format($totAllPaid).'</td>
			// 		<td style="border:1px solid #000;font-weight:bold;border-width:1px 1px 1px 0;padding:5px 3px">'.number_format($totKomPiutang).'</td>
			// 	</tr>';

			// 	$html .= '<tr>
			// 		<td style="padding:10px" colspan="9"></td>
			// 	</tr>';
			// }

			$html .= '</table>';
			$html .= '<div style="page-break-after:always"></div>';
		}

        if ($ctk == '0') {
            echo $html;
        }else if ($ctk == '1') {
			// $this->m_fungsi->_mpdf2('',$html,10,10,10,'L','PENJUALAN','');
			$this->m_fungsi->newPDF($html,'L',88,0);
        }else{
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=judul.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $data2['prev']= $html;
            $this->load->view('view_excel', $data2);
        }
	}

 }
