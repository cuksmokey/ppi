<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan2 extends CI_Controller {

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

        if($data_kop->no_pkb == '160/21/WP'){
            $html .= $kop_gak_pakai;
        }else if(($data_kop->ker == 'MH' || $data_kop->ker == 'BK' || $data_kop->ker == 'MEDIUM LINER') && $data_kop->nama <> 'IBU IMA' ){
            $html .= $kop_pakai;
        }else if($data_kop->ker == 'WP' && ($data_kop->popo == 'PO 03.2006.0004' || $data_kop->popo == 'PO 03.2007.0005' || $data_kop->pt == 'PT. KEMILAU INDAH PERMANA' || $data_kop->pt == 'PT. QINGDA MASPION PAPER PRODUCTS' || $data_kop->pt == 'PT. WIRAPETRO PLASTINDO' || $data_kop->pt == 'PT. MITRA KEMAS' || $data_kop->pt == 'PT. ALPHA ALTITUDE PAPER' || $data_kop->pt == 'PT. DOMINO MAKMUR PLASTINDO')){
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
            <td style="padding:5px 0">'.$data_pl->no_pkb.'</td>
            <td style="padding:5px 0">NO. TELP / HP</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->no_telp.'</td>
        </tr>
        <tr>
            <td style="padding:5px 0">NO. KENDARAAN</td>
            <td style="text-align:center;padding:5px 0">:</td>
            <td style="padding:5px 0">'.$data_pl->no_kendaraan.'</td>
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

        // TAMBAH KOTAK KOSONG
        if($count == 1) {
            for($i = 0; $i < 5; $i++){ 
                $cc = 1;
                $xx = 5;
            }
        }else if($count == 2){
            for($i = 0; $i < 4; $i++){
                $cc = 2;
                $xx = 4;
            }
        }else if($count == 3){
            for($i = 0; $i < 3; $i++){
                $cc = 3;
                $xx = 3;
            }
        }else if($count == 4){
            for($i = 0; $i < 2; $i++){ 
                $cc = 4;
                $xx = 2;
            }
        }else if($count == 5){  
                $cc = 5;
                $xx = 1;
        }
        

        if($count == $cc) {
            for($i = 0; $i < $xx; $i++){
                $html .= '<tr>
                <td style="border:1px solid #000;padding:11px 0"></td>
                <td style="border:1px solid #000;padding:11px 0"></td>
                <td style="border:1px solid #000;padding:11px 0"></td>
                <td style="border:1px solid #000;padding:11px 0"></td>
                <td style="border:1px solid #000;padding:11px 0"></td>
                <td style="border:1px solid #000;padding:11px 0"></td>';    
            }
        }
        
        // TOTAL
        $html .= '<tr>
            <td style="border:1px solid #000;padding:5px 0" colspan="4">TOTAL</td>
            <td style="border:1px solid #000;padding:5px 0">'.$tot_qty.' ROLL</td>
            <td style="border:1px solid #000;padding:5px 0">'.number_format($tot_berat).' KG</td>
        </tr>';

        $html .= '</table>';


                             # # # # # # # # # T T D # # # # # # # # # #      


        if($count_kop >= '12'){
            $px_ttd = '15px';
            $px_note = '25px';
        }else{
            $px_ttd = '35px';
            $px_note = '50px';
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
            $this->m_fungsi->_mpdf('',$html,10,10,10,'P');
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
                    <td>'.$data_pl->no_pkb.'</td>
                    <td>No Telp / No HP</td>
                    <td>:</td>
                    <td>'.$data_pl->no_telp.'</td>
                </tr>
                <tr>
                    <td>No Kendaraan</td>
                    <td>:</td>
                    <td>'.$data_pl->no_kendaraan.'</td>
                    <td>No PO</td>
                    <td>:</td>
                    <td>'.$data_pl->no_po.'</td>
                </tr>
                ';

                $html .= '</table>';

                $html .= '<table cellspacing="0" cellpadding="5" style="font-size:11px;width:100%;text-align:center;border-collapse:collapse;color:#000" >
                <tr>
                    <th style="padding:2px 0;width:8%"></th>
                    <th style="padding:2px 0;width:12%"></th>
                    <th style="padding:2px 0;width:12%"></th>
                    <th style="padding:2px 0;width:12%"></th>
                    <th style="padding:2px 0;width:13%"></th>
                    <th style="padding:2px 0;width:13%"></th>
                    <th style="padding:2px 0;width:10%"></th>
                    <th style="padding:2px 0;width:16%"></th>
                </tr>';

                $html .= '<tr>
                    <td style="border:1px solid #000">No</td>
                    <td style="border:1px solid #000" colspan="2">Nomer Roll</td>
                    <td style="border:1px solid #000">Gramage (GSM)</td>
                    <td style="border:1px solid #000">Lebar (CM)</td>
                    <td style="border:1px solid #000">Berat (KG)</td>
                    <td style="border:1px solid #000">JOINT</td>
                    <td style="border:1px solid #000">KETERANGAN</td>
                </tr>';

                $id_pl = $data_pl->id;
                $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE id_pl = '$id_pl' ORDER BY nm_ker DESC,g_label ASC,width ASC,tgl ASC,roll ASC");

                $count_p_pl = $data_detail->num_rows();

                $no = 1;
                foreach ($data_detail->result() as $r) {

                    // menghilangkan 0 di weight dan joint
                    if($r->weight == 0){
                        $weight = "";
                    }else{
                        $weight = $r->weight;
                    }

                    if($r->weight == 0 && $r->joint == 0){
                        $joint = "";
                    }else{
                        $joint = $r->joint;
                    }

                    if($ctk == 3){
                        $exp = explode(' ',$r->ket);
                        if($exp[0] == "-"){
                            $kkeett = $exp[0].' '.$exp[1].' '.$exp[2];
                        }else{
                            $kkeett = "";
                        }
                    }else{
                        $kkeett = "";
                    }

                    $html .= '<tr>
                        <td style="border:1px solid #000">'.$no.'</td>
                        <td style="border:1px solid #000">'.substr($r->roll,0, 5).'</td>
                        <td style="border:1px solid #000">'.substr($r->roll,6, 15).'</td>
                        <td style="border:1px solid #000">'.$r->g_label.'</td>
                        <td style="border:1px solid #000">'.round($r->width,2).'</td>
                        <td style="border:1px solid #000">'.$weight.'</td>
                        <td style="border:1px solid #000">'.$joint.'</td>
                        <td style="border:1px solid #000;text-align:left">'.$kkeett.'</td>
                    </tr>';

                    $no++;
                }

                $total_pl = $this->db->query("SELECT DISTINCT COUNT(*) AS totpl,width,SUM(weight) AS tot FROM m_timbangan WHERE id_pl = '$id_pl' ORDER BY roll")->row();
                $qrTotPL = $this->db->query("SELECT width,COUNT(roll) AS roll FROM m_timbangan WHERE id_pl = '$id_pl' GROUP BY g_label,nm_ker,width ORDER BY nm_ker DESC,g_label ASC,width ASC");
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

                if($ctk == 3){
                    $html .='<tr>
                        <td style="padding:5px 0 0;border:0;font-weight:normal;text-align:left" colspan="8" >';
                            foreach($qrTotPL->result() as $abc){
                                $html .= '( '.$abc->roll.' - '.round($abc->width,2).' ) ';
                            }
                    $html .='</td></tr>';
                }else{
                    $html .= '';
                }

                $html .= '</table>';
                $html .= '<div style="page-break-after:always"></div>';                 

            }

            // TOTAL PL YANG BISA DI TAMPILANKAN DALAM SATU HALAMAN ANTARA 34 - 35
            if($count_p_pl >= 38){
                $this->m_fungsi->_mpdf2('',$html,10,10,10,'P','PL',3);
            }else if($count_p_pl >= 36){
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
                    $html .= '
                        <div style="padding-top:60px;display:block;">
                            <table width="100%" border="1" cellspacing="0" cellpadding="8" style="font-size:37px;margin-bottom:190px">
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

        $warna = 'hitam';

        if($warna == 'hitam'){
            $ink = '#000';
        }else{
            $ink = '#444';
        }

//////////////////////////////////////// K O P ////////////////////////////////////////

        $data_detail = $this->db->query("
        SELECT DISTINCT a.no_invoice,c.tgl,a.jto,a.nm_perusahaan,a.alamat,a.kepada,a.no_surat,c.no_pkb,c.no_po FROM th_invoice a
        INNER JOIN tr_invoice b ON a.no_invoice = b.no_invoice
        INNER JOIN pl c ON a.no_pkb = c.no_pkb
        WHERE a.no_invoice = '$no_invoice'
        GROUP BY a.no_invoice,a.jto,a.nm_perusahaan,a.alamat,a.kepada,a.no_surat,c.no_pkb,c.no_po
        LIMIT 1")->row();

        if($data_detail->kepada == 'BP. ZAENUROCHMAN'){

            $html .= '<table cellspacing="0" style="font-size:11px;color:'.$ink.';border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:"Trebuchet MS", Helvetica, sans-serif">
            <tr>
                <th style="border:0;height:136px"></th>
            </tr>
            <tr>
                <td style="background:#ddd;border:1px solid '.$ink.';padding:6px;font-size:14px !important">INVOICE</td>
            </tr>';
            $html .= '</table>';
        
        }else if($data_detail->kepada <> 'BP. ZAENUROCHMAN'){
            
            $html .= '<table cellspacing="0" style="font-size:11px;color:'.$ink.';border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:"Trebuchet MS", Helvetica, sans-serif">
            <tr>
                <th style="border:0;width:15% !important;height:0"></th>
                <th style="border:0;width:55% !important;height:0"></th>
                <th style="border:0;width:25% !important;height:0"></th>
            </tr>

            <tr>
                <td style="background:url(http://localhost/SI_timbangan_v2/assets/images/logo_ppi_1.png)center no-repeat" rowspan="3"></td>
                <td style="font-size:25px;padding:20px 0 0">PT. PRIMA PAPER INDONESIA</td>
            </tr>
            <tr>
                <td style="font-size:11px">Dusun Timang Kulon, Desa Wonokerto, Kec.Wonogiri, Kab.Wonogiri</td>
                <td style="font-size:11px"></td>
            </tr>
            <tr>
                <td style="font-size:11px;padding:0 0 20px">WONOGIRI - JAWA TENGAH - INDONESIA Kode Pos 57615</td>
                <td style="font-size:11px;padding:0 0 20px"></td>
            </tr>';
            $html .= '</table>';

            $html .= '<table cellspacing="0" style="font-size:11px;color:'.$ink.';border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:"Trebuchet MS", Helvetica, sans-serif">
            <tr>
                <th style="height:0"></th>
            </tr>
            <tr>
                <td style="background:#ddd;border:1px solid '.$ink.';padding:6px;font-size:14px !important">INVOICE</td>
            </tr>';
            $html .= '</table>';
        }       

////////////////////////////////////// D E T A I L //////////////////////////////////////

        $html .= '<table cellspacing="0" style="font-size:11px;color:'.$ink.';border-collapse:collapse;vertical-align:top;width:100%;font-family:"Trebuchet MS", Helvetica, sans-serif">
        <tr>
            <th style="padding:2px 0;height:0;width:16%"></th>
            <th style="padding:2px 0;height:0;width:1%"></th>
            <th style="padding:2px 0;height:0;width:33%"></th>
            <th style="padding:2px 0;height:0;width:16%"></th>
            <th style="padding:2px 0;height:0;width:1%"></th>
            <th style="padding:2px 0;height:0;width:33%"></th>
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
            <td style="padding:3px 0">'.$data_detail->nm_perusahaan.'</td>
            <td style="padding:3px 0;font-weight:bold">Jatuh Tempo</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:3px 0;font-weight:bold;color:#f00">'.$this->m_fungsi->tanggal_format_indonesia($data_detail->jto).'</td>
        </tr>';

        $sql_po = "
        SELECT DISTINCT a.no_invoice,a.jto,a.nm_perusahaan,a.alamat,a.kepada,a.no_surat,c.no_pkb,c.no_po FROM th_invoice a
        INNER JOIN tr_invoice b ON a.no_invoice = b.no_invoice
        INNER JOIN pl c ON a.no_pkb = c.no_pkb
        WHERE a.no_invoice = '$no_invoice'
        GROUP BY a.no_invoice,a.jto,a.nm_perusahaan,a.alamat,a.kepada,a.no_surat,c.no_pkb,c.no_po";

        $count_po = $this->db->query($sql_po)->num_rows();
        $result_po = $this->db->query($sql_po);

        if($count_po == '1'){
            // PO SATU
            $html .= '
            <tr>
                <td style="padding:3px 0">Alamat</td>
                <td style="padding:3px 0">:</td>
                <td style="padding:3px 0">'.$data_detail->alamat.'</td>
                <td style="padding:3px 0">No. PO</td>
                <td style="padding:3px 0">:</td>
                <td style="padding:3px 0">'.$data_detail->no_po.'</td>
            </tr>';
        }else if($count_po <> '1'){
            // PO LEBIH DARI SATU
            $html .= '
            <tr>
                <td style="padding:3px 0">Alamat</td>
                <td style="padding:3px 0">:</td>
                <td style="padding:3px 0">'.$data_detail->alamat.'</td>
                <td style="padding:3px 0"></td>
                <td style="padding:3px 0"></td>
                <td style="padding:3px 0"></td>
            </tr>';
            foreach ($result_po->result() as $r) {
                $html .= '
                <tr>
                    <td style="padding:3px 0"></td>
                    <td style="padding:3px 0"></td>
                    <td style="padding:3px 0"></td>
                    <td style="padding:3px 0">No. PO</td>
                    <td style="padding:3px 0">:</td>
                    <td style="padding:3px 0">'.$r->no_po.'</td>
                </tr>';
            }
        }

        $html .= '<tr>
            <td style="padding:3px 0">Kepada</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:3px 0">'.$data_detail->kepada.'</td>
            <td style="padding:3px 0">No. Surat Jalan</td>
            <td style="padding:3px 0">:</td>
            <td style="padding:3px 0">'.$data_detail->no_surat.'</td>
        </tr>';

        $html .= '</table>';

/////////////////////////////////////////////// I S I ///////////////////////////////////////////////

        $html .= '<table cellspacing="0" style="font-size:11px;color:'.$ink.';border-collapse:collapse;vertical-align:top;width:100%;font-family:"Trebuchet MS", Helvetica, sans-serif">
        <tr>
            <th style="height:15px;width:30%"></th>
            <th style="height:15px;width:10%"></th>
            <th style="height:15px;width:20%"></th>
            <th style="height:15px;width:20%"></th>
            <th style="height:15px;width:20%"></th>
        </tr>';

        $html .= '<tr>
            <td style="border:1px solid '.$ink.';border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold">NAMA BARANG</td>
            <td style="border:1px solid '.$ink.';border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold">SATUAN</td>
            <td style="border:1px solid '.$ink.';border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold">JUMLAH</td>
            <td style="border:1px solid '.$ink.';border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold">HARGA</td>
            <td style="border:1px solid '.$ink.';border-width:2px 0;padding:5px 0;text-align:center;font-weight:bold">TOTAL</td>
        </tr>';

        $sql_label = "
        SELECT DISTINCT c.no_invoice AS inv,d.g_label,b.nm_ker FROM pl a
        INNER JOIN m_timbangan b ON a.id = b.id_pl
        INNER JOIN th_invoice c ON a.no_pkb = c.no_pkb
        INNER JOIN tr_invoice d ON c.no_invoice = d.no_invoice
        WHERE c.no_invoice = '$no_invoice'
        GROUP BY c.no_invoice,d.g_label,b.nm_ker";

        $sql_label2 = "
        SELECT DISTINCT d.g_label AS lbl,b.nm_ker AS ker FROM pl a
        INNER JOIN m_timbangan b ON a.id = b.id_pl
        INNER JOIN th_invoice c ON a.no_pkb = c.no_pkb
        INNER JOIN tr_invoice d ON c.no_invoice = d.no_invoice
        WHERE c.no_invoice = '$no_invoice'
        GROUP BY c.no_invoice,d.g_label,b.nm_ker LIMIT 1";

        $count_label   = $this->db->query($sql_label)->num_rows();
        $result_label2  = $this->db->query($sql_label2)->row();

        ////

        $sql_isi = "SELECT DISTINCT d.no_invoice,d.g_label,d.width_lb AS wlb,d.roll AS roll,d.satuan,d.jumlah,d.harga FROM pl a
        INNER JOIN m_timbangan b ON a.id = b.id_pl
        INNER JOIN th_invoice c ON a.no_pkb = c.no_pkb
        INNER JOIN tr_invoice d ON c.no_invoice = d.no_invoice
        WHERE c.no_invoice = '$no_invoice'
        GROUP BY d.no_invoice,d.g_label,d.width_lb,d.roll,d.satuan,d.jumlah,d.harga
        ORDER BY d.width_lb ASC";
        $result_isi  = $this->db->query($sql_isi);

        if($count_label == '1'){
            // label
            if($result_label2->ker == "MH"){
                $ket = 'KERTAS MEDIUM ROLL';
            }else if($result_label2->ker == "WP"){
                $ket = 'KERTAS COKLAT ROLL';
            }

            $html .= '<tr>
                <td style="padding:8px 0 4px" colspan="4">'.$ket.' '.$result_label2->lbl.' GSM</td>
                <td style="padding:8px 0 4px"></td>
            </tr>';

            // detail isi
            $tot_isi = 0;
            $tot_tot = 0;
            foreach($result_isi->result() as $r){
                $html .= '<tr>
                    <td style="padding:3px 0">'.$r->wlb.' = '.$r->roll.' ROLL</td>
                    <td style="padding:3px 0;text-align:center">'.$r->satuan.'</td>
                    <td style="padding:3px 0;text-align:center">'.number_format($r->jumlah).'</td>
                    <td style="padding:3px 0;text-align:right">Rp. '.number_format($r->harga).'</td>
                    <td style="padding:3px 0;text-align:right">Rp. '.number_format($r->jumlah * $r->harga).'</td>
                </tr>
                ';

                $tot_isi += $r->jumlah * $r->harga;
                $tot_tot += $r->jumlah;
            }
            
            // total
            $html .= '<tr>
                <td style="padding:15px 0;text-align:center" colspan="2">TOTAL</td>
                <td style="padding:15px 0;text-align:center">'.number_format($tot_tot).'</td>
                <td style="padding:15px 0;text-align:right" colspan="2">Rp. '.number_format($tot_isi).'</td>
            </tr>';

        // gsm lebih dari 1
        }else if($count_label <> '1'){

            $rslt_lbh_2 = $this->db->query($sql_label);

            foreach($rslt_lbh_2->result() as $r) {

                $inv_2 = $r->inv;
                $label_2 = $r->g_label;
                // label
                $html .= '<tr>
                    <td style="padding:8px 0 4px" colspan="4">KERTAS MEDIUM '.$label_2.' GSM</td>
                    <td style="padding:8px 0 4px"></td>
                </tr>';

                $sql_isi_lbh2 = "SELECT DISTINCT d.no_invoice,d.g_label,d.width_lb AS wlb,d.roll AS roll,d.satuan,d.jumlah,d.harga FROM pl a
                INNER JOIN m_timbangan b ON a.id = b.id_pl
                INNER JOIN th_invoice c ON a.no_pkb = c.no_pkb
                INNER JOIN tr_invoice d ON c.no_invoice = d.no_invoice
                WHERE c.no_invoice = '$inv_2' AND d.g_label='$label_2'
                GROUP BY d.no_invoice,d.g_label,d.width_lb,d.roll,d.satuan,d.jumlah,d.harga
                ORDER BY d.width_lb ASC";
                $isi_lbh_2 = $this->db->query($sql_isi_lbh2);

                // isi
                // $tot_isi = 0;
                foreach($isi_lbh_2->result() as $r2){
                    $html .= '<tr>
                        <td style="padding:3px 0">'.$r2->wlb.' = '.$r2->roll.' ROLL</td>
                        <td style="padding:3px 0;text-align:center">'.$r2->satuan.'</td>
                        <td style="padding:3px 0;text-align:center">'.number_format($r2->jumlah).'</td>
                        <td style="padding:3px 0;text-align:right">Rp. '.number_format($r2->harga).'</td>
                        <td style="padding:3px 0;text-align:right">Rp. '.number_format($r2->jumlah * $r2->harga).'</td>
                    </tr>
                    ';
                }

                $sql_tot_isi2 = $this->db->query("
                SELECT SUM(jumlah*harga) AS jml FROM tr_invoice
                WHERE no_invoice = '$inv_2'")->row();
                
                $tot_isi = $sql_tot_isi2->jml;

            }

            // sub total
            $html .= '<tr>
                <td style="padding:15px 0" colspan="4"></td>
                <td style="padding:15px 0;text-align:right">Rp. '.number_format($tot_isi).'</td>
            </tr>';

        }


        ///
        

//////////////////////////////////////////////// T O T A L ////////////////////////////////////////////////

        // RUMUS
        $ppn10         = 0.1 * $tot_isi;
        $pph22         = 0.01 * $tot_isi;
        $ter_tot_ppn10 = round($tot_isi + (0.1 * $tot_isi));
        $ter_tot_pph22 = round($tot_isi + (0.1 * $tot_isi) + (0.01 * $tot_isi));

        if($data_detail->kepada == 'BP. ZAENUROCHMAN'){

            $tot_isi = round($tot_isi);

            $html .= '<tr>
            <td style="border:2px solid '.$ink.';border-width:2px 0;padding:6px 0 3px" colspan="3" rowspan="3">Terbilang : <br/>
            <b><i>'.ucwords($this->m_fungsi->terbilang($tot_isi)).'</i></b></td>
            <td style="border-top:2px solid '.$ink.';padding:6px 0 3px">Sub Total</td>
            <td style="border-top:2px solid '.$ink.';padding:6px 0 3px;text-align:right">Rp. '.number_format($tot_isi).'</td>
            </tr>';

            $html .= '<tr>
                <td style="border:0;padding:10px 0"></td>
                <td style="border:0;padding:10px 0"></td>
            </tr>';

            $html .='<tr>
                <td style="border-bottom:2px solid '.$ink.';padding:3px 0 6px">Total</td>
                <td style="border-bottom:2px solid '.$ink.';padding:3px 0 6px;text-align:right">Rp. '.number_format($tot_isi).'</td>
            </tr>';
        }else if($data_detail->nm_perusahaan == 'PT. MADISON INTIPRATAMA'){
            $html .= '<tr>
            <td style="border:2px solid '.$ink.';border-width:2px 0;padding:6px 0 3px" colspan="3" rowspan="4">Terbilang : <br/>
            <b><i>'.ucwords($this->m_fungsi->terbilang($ter_tot_pph22)).'</i></b></td>
            <td style="border-top:2px solid '.$ink.';padding:6px 0 3px">Sub Total</td>
            <td style="border-top:2px solid '.$ink.';padding:6px 0 3px;text-align:right">Rp. '.number_format($tot_isi).'</td>
            </tr>';

            $html .= '<tr>
                <td style="padding:3px 0">Ppn 10%</td>
                <td style="padding:3px 0;text-align:right">Rp. '.number_format($ppn10).'</td>
            </tr>';

            $html .= '<tr>
                <td style="padding:3px 0">Pph 22</td>
                <td style="padding:3px 0;text-align:right">Rp. '.number_format($pph22).'</td>
            </tr>';

            $html .='<tr>
                <td style="border-bottom:2px solid '.$ink.';padding:3px 0 6px">Total</td>
                <td style="border-bottom:2px solid '.$ink.';padding:3px 0 6px;text-align:right">Rp. '.number_format($ter_tot_pph22).'</td>
            </tr>';
        }else if($data_detail->kepada <> 'BP. ZAENUROCHMAN'){
            $html .= '<tr>
            <td style="border:2px solid '.$ink.';border-width:2px 0;padding:6px 0 3px" colspan="3" rowspan="3">Terbilang : <br/>
            <b><i>'.ucwords($this->m_fungsi->terbilang($ter_tot_ppn10)).'</i></b></td>
            <td style="border-top:2px solid '.$ink.';padding:6px 0 3px">Sub Total</td>
            <td style="border-top:2px solid '.$ink.';padding:6px 0 3px;text-align:right">Rp. '.number_format($tot_isi).'</td>
            </tr>';

            $html .= '<tr>
                <td style="padding:3px 0">Ppn 10%</td>
                <td style="padding:3px 0;text-align:right">Rp. '.number_format($ppn10).'</td>
            </tr>';

            $html .='<tr>
                <td style="border-bottom:2px solid '.$ink.';padding:3px 0 6px">Total</td>
                <td style="border-bottom:2px solid '.$ink.';padding:3px 0 6px;text-align:right">Rp. '.number_format($ter_tot_ppn10).'</td>
            </tr>';
        }
                

//////////////////////////////////////////////// T T D ////////////////////////////////////////////////


        $html .= '<tr>
            <td style="padding:10px 0" colspan="4"></td>
            <td style="padding:10px 0"></td>
        </tr>
        <tr>
            <td style="padding:3px 0" colspan="3"></td>
            <td style="padding:3px 0;text-align:center" colspan="2">Wonogiri, '.$this->m_fungsi->tanggal_format_indonesia($data_detail->tgl).'</td>
        </tr>
        <tr>
            <td style="padding:10px 0" colspan="3"></td>
            <td style="padding:10px 0" colspan="2"></td>
        </tr>
        <tr>
            <td style="font-size:10px" colspan="3">Pembayaran Full Amount Di Transfer Ke :</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td style="font-size:10px" colspan="3">BANK IBK INDONESIA 350 21 000 58</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td style="font-size:10px" colspan="3">A.n PT. PRIMA PAPER INDONESIA</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td style="padding:5px 0" colspan="3"></td>
            <td style="padding:5px 0" colspan="2"></td>
        </tr>
        <tr>
            <td style="font-size:10px" colspan="3">* di email ke</td>
            <td style="text-align:center" colspan="2">Elyzabeth S.A.</td>
        </tr>
        <tr>
            <td style="font-size:10px" colspan="3">primapaperin@gmail.com / bethppi@yahoo.co.id</td>
            <td style="text-align:center" colspan="2">Finance</td>
        </tr>
        ';

        $html .= '</table>';

        $this->m_fungsi->_mpdf('',$html,10,10,10,'P');

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
            header("Content-Disposition: attachment; filename=$jdl.xls");
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
            header("Content-Disposition: attachment; filename=$jdl.xls");
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


                             # # # # # # # # # K O P # # # # # # # # # #


        $kop = '<table cellspacing="0" style="font-size:11px;color:#000;border-collapse:collapse;vertical-align:top;width:100%;text-align:center;font-weight:bold;font-family:Arial !important">
            <tr>
                <th style="width:25% !important;height:80px"></th>
                <th style="width:75% !important;height:80px"></th>
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


        if($data_pl->nm_perusahaan == 'MARDALENA'){
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
            <th style="width:12% !important;height:15px"></th>
            <th style="width:20% !important;height:15px"></th>
        </tr>
        <tr>
            <td style="border:1px solid #000;padding:5px 0">NO</td>
            <td style="border:1px solid #000;padding:5px 0">NO. PO</td>
            <td style="border:1px solid #000;padding:5px 0">ITEM DESCRIPTION</td>
            <td style="border:1px solid #000;padding:5px 0">FLUTE</td>
            <td style="border:1px solid #000;padding:5px 0">QTY</td>
            <td style="border:1px solid #000;padding:5px 0">KETERANGAN</td>
        </tr>';


        // AMBIL DATA
        $data_detail = $this->db->query("SELECT a.*,b.no_po FROM m_box a
		INNER JOIN pl_box b ON a.id_pl=b.id
		WHERE b.no_pkb='$jenis'
		ORDER BY a.ukuran ASC");
		    // id  ukuran          qty   id_pl

        $no = 1;
		$tot_qty = 0;
        $count = $data_detail->num_rows();            
            
        foreach ($data_detail->result() as $data ) {

            $html .= '<tr>
                <td style="border:1px solid #000;padding:5px 0">'.$no.'</td>
                <td style="border:1px solid #000;padding:5px 0">'.$data->no_po.'</td>
                <td style="border:1px solid #000;padding:5px 0">'.$data->ukuran.'</td>
                <td style="border:1px solid #000;padding:5px 0">'.$data->flute.'</td>
                <td style="border:1px solid #000;padding:5px 0">'.number_format($data->qty).' '.$data->qty_ket.'</td>
                <td style="border:1px solid #000;padding:5px 0"></td>
			';
            $no++;
			$tot_qty+=$data->qty;

        }

        // TAMBAH KOTAK KOSONG
        if($count == 1) {
            for($i = 0; $i < 5; $i++){ 
                $cc = 1;
                $xx = 5;
            }
        }else if($count == 2){
            for($i = 0; $i < 4; $i++){
                $cc = 2;
                $xx = 4;
            }
        }else if($count == 3){
            for($i = 0; $i < 3; $i++){
                $cc = 3;
                $xx = 3;
            }
        }else if($count == 4){
            for($i = 0; $i < 2; $i++){ 
                $cc = 4;
                $xx = 2;
            }
        }else if($count == 5){  
                $cc = 5;
                $xx = 1;
        }
        

        if($count == $cc) {
            for($i = 0; $i < $xx; $i++){
                $html .= '<tr>
                <td style="border:1px solid #000;padding:11px 0"></td>
                <td style="border:1px solid #000;padding:11px 0"></td>
                <td style="border:1px solid #000;padding:11px 0"></td>
                <td style="border:1px solid #000;padding:11px 0"></td>
                <td style="border:1px solid #000;padding:11px 0"></td>
                <td style="border:1px solid #000;padding:11px 0"></td>';    
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


        if ($ctk == '0') {
            $this->m_fungsi->_mpdf('',$html,10,10,10,'P');
        }else{

            ////////////////////////////////// CETAK PACKING LIST ////////////////////////////////////////////

            $printpl = "EPSON";

            if($printpl == "EPSON"){
                $adcd = "DESC";
            }else{
                $adcd = "ASC";
            }
            
            $html = '';

            $data_header = $this->db->query("SELECT DISTINCT a.*,b.nm_ker,COUNT(b.roll) AS roll FROM pl a
                INNER JOIN m_timbangan b ON a.id=b.id_pl
                WHERE a.no_pkb='$jenis'
                GROUP BY a.id
                ORDER BY no_po $adcd,g_label $adcd,width $adcd");

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
                    <td>'.$data_pl->no_pkb.'</td>
                    <td>No Telp / No HP</td>
                    <td>:</td>
                    <td>'.$data_pl->no_telp.'</td>
                </tr>
                <tr>
                    <td>No Kendaraan</td>
                    <td>:</td>
                    <td>'.$data_pl->no_kendaraan.'</td>
                    <td>No PO</td>
                    <td>:</td>
                    <td>'.$data_pl->no_po.'</td>
                </tr>
                ';

                $html .= '</table>';

                $html .= '<table cellspacing="0" cellpadding="5" style="font-size:11px;width:100%;text-align:center;border-collapse:collapse;color:#000" >
                <tr>
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
                    <td style="border:1px solid #000">KETERANGAN</td>
                </tr>';

                $id_pl = $data_pl->id;
                $data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE id_pl = '$id_pl' ORDER BY nm_ker DESC,g_label ASC,width ASC,tgl ASC,roll ASC");

                $count_p_pl = $data_detail->num_rows();

                $no = 1;
                foreach ($data_detail->result() as $r) {
                    // JIKA MASIH ADA ROLL ??
                    if($r->roll == "X" || $r->roll == "x"){
                        $sty = ";border-width:1px 0";
                        $c_roll = "";
                    }else{
                        $sty = "";
                        $c_roll = substr($r->roll,0, 5);
                    }

                    // menghilangkan 0 di weight dan joint
                    if($r->weight == 0){
                        $weight = "";
                    }else{
                        $weight = $r->weight;
                    }

                    if($r->weight == 0 && $r->joint == 0){
                        $joint = "";
                    }else{
                        $joint = $r->joint;
                    }

                    if($ctk == 2){
                        $kkeett = $r->ket;
                    }else if($ctk == 3){
                        $exp = explode(' ',$r->ket);
                        if($exp[0] == "-"){
                            // $kkeett = $r->ket;
                            $kkeett = $exp[0].' '.$exp[1].' '.$exp[2];
                        }else{
                            $kkeett = "";
                        }
                    }else{
                        $kkeett = "";
                    }

                    $cs = '4';
                    $html .= '<tr>
                        <td style="border:1px solid #000">'.$no.'</td>
                        <td style="border:1px solid #000'.$sty.'">'.$c_roll.'</td>
                        <td style="border:1px solid #000'.$sty.'">'.substr($r->roll,6, 15).'</td>
                        <td style="border:1px solid #000">'.$r->g_label.'</td>
                        <td style="border:1px solid #000">'.round($r->width,2).'</td>
                        <td style="border:1px solid #000">'.$weight.'</td>
                        <td style="border:1px solid #000">'.$joint.'</td>
                        <td style="border:1px solid #000;text-align:left">'.$kkeett.'</td>
                    </tr>';

                    $no++;
                }

                $total_pl = $this->db->query("SELECT DISTINCT COUNT(*) AS totpl,width,SUM(weight) AS tot FROM m_timbangan WHERE id_pl = '$id_pl' ORDER BY roll")->row();
                // $count_pl = $this->db->query("SELECT DISTINCT width FROM m_timbangan WHERE id_pl = '$id_pl' GROUP BY width")->num_rows();
                $qrTotPL = $this->db->query("SELECT width,COUNT(roll) AS roll FROM m_timbangan WHERE id_pl = '$id_pl' GROUP BY g_label,nm_ker,width ORDER BY nm_ker DESC,g_label ASC,width ASC");
                $count_pl = $qrTotPL->num_rows();

                if($count_pl == '1'){
                    $html .='
                    <tr>
                        <td style="border:1px solid #000" colspan="'.$cs.'" ><b>'.($total_pl->totpl).' ROLL (@ LB '.round( $total_pl->width,2).' )</b></td>';    
                }else if($count_pl <> '1'){
                    $html .='<tr>
                        <td style="padding:0;border:1px solid #000;font-weight:bold" colspan="'.$cs.'" >-</td>';
                }

                // masih ada roll ?? bobot 0
                if($r->roll == "X" || $r->roll == "x"){
                    $nol = "-";
                }else{
                    $nol = number_format($total_pl->tot);
                }

                $html .='<td style="border:1px solid #000"><b>Total</b></td>
                        <td style="border:1px solid #000"><b>'.$nol.'</b></td>
                        <td style="border:1px solid #000" colspan="2"></td>
                    </tr>';

                if($ctk <> 1){
                    $html .='<tr>
                        <td style="padding:5px 0 0;border:0;font-weight:normal;text-align:left" colspan="8" >';
                            foreach($qrTotPL->result() as $abc){
                                $html .= '( '.$abc->roll.' - '.round($abc->width,2).' ) ';
                            }
                    $html .='</td></tr>';
                }else{
                    $html .= '';
                }

                $html .= '</table>';
                $html .= '<div style="page-break-after:always"></div>';                 

            }

            // TOTAL PL YANG BISA DI TAMPILANKAN DALAM SATU HALAMAN ANTARA 34 - 35
            if($count_p_pl >= 38){
                $this->m_fungsi->_mpdf2('',$html,10,10,10,'P','PL',3);
            }else if($count_p_pl >= 36){
                $this->m_fungsi->_mpdf2('',$html,10,10,10,'P','PL',2);
            }else if($count_p_pl >= 34){
                $this->m_fungsi->_mpdf2('',$html,10,10,10,'P','PL',1);
            }else if($count_p_pl < 34){
                $this->m_fungsi->_mpdf2('',$html,10,10,10,'P','PL',0);
            }
        }
    }

 }
