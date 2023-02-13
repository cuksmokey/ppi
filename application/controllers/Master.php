<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') != "login") {
			redirect(base_url("Login"));
		}
		$this->load->model('m_master');
		$this->load->model('m_fungsi');

		$this->db = $this->load->database('default', TRUE);
	}

	public function index()
	{
		$this->load->view('header');
		if($this->session->userdata('level') == "SuperAdmin"){
			// $this->load->view('home');
			$this->load->view('Laporan/v_stok');
		}else if($this->session->userdata('level') == "Admin" || $this->session->userdata('level') == "QC" || $this->session->userdata('level') == "FG" || $this->session->userdata('level') == "Office" || $this->session->userdata('level') == "Finance" || $this->session->userdata('level') == "Corrugated"){
			$this->load->view('Laporan/v_stok');
		}else{
			$this->load->view('Master/v_timbangan');
		}
		$this->load->view('footer');
	}

	public function Timbangan()
	{
		$this->load->view('header');
		$this->load->view('Master/v_timbangan');
		$this->load->view('footer');
	}

	public function NewTimbangan()
	{
		$this->load->view('header');
		$this->load->view('Master/v_timbanganNew');
		$this->load->view('footer');
	}

	public function Perusahaan()
	{
		$this->load->view('header');
		$this->load->view('Master/v_perusahaan');
		$this->load->view('footer');
	}

	public function PO()
	{
		$this->load->view('header');
		$this->load->view('Master/v_po');
		$this->load->view('footer');
	}

	public function Packing_list()
	{
		$this->load->view('header');
		$this->load->view('Master/v_pl');
		$this->load->view('footer');
	}

	public function Invoice()
	{
		$this->load->view('header');
		$this->load->view('Master/v_invoice');
		$this->load->view('footer');
	}

	public function Expedisi(){
		$this->load->view('header');
		$this->load->view('Master/v_expedisi');
		$this->load->view('footer');
	}

	public function Administrator()
	{
		$this->load->view('header');
		$this->load->view('Master/v_administrator');
		$this->load->view('footer');
	}

	public function RPK()
	{
		$this->load->view('header');
		$this->load->view('Master/v_rpk');
		$this->load->view('footer');
	}

	function Insert()
	{
		$jenis      = $_POST['jenis'];

		if ($jenis == "Timbangan") {
			$id = $this->input->post('id');
			$kodepm = $this->input->post('kodepm');
			$xroll = $this->input->post('xroll');
			$xth = $this->input->post('xth');
			$xno = $this->input->post('xno');
			$xkode = $this->input->post('xkode');

			// $cek = $this->m_master->get_data_one("m_timbangan","roll",$id)->num_rows();
			// CEK ROLL -  HILANGKAN BULAN
			$r1 = $kodepm.'/'.$xroll.'/'.$xth;
			$r2 = $xno.$xkode;
			$cek = $this->db->query("SELECT*FROM m_timbangan WHERE roll LIKE '$r1%' AND roll LIKE '%$r2'");
			if ($cek->num_rows() > 0 ) {
				echo json_encode(array('data' => FALSE,'msg' => 'ROLL NUMBER SUDAH TERPAKAI!. '.$cek->row()->roll));
			}else{
				$this->m_master->insert_timbangan();
				$getId = $this->m_master->get_data_one("m_timbangan","roll",$id)->row();
				echo json_encode(array('data' => TRUE, 'getid' => $getId->id));

				// echo json_encode(array('data' => TRUE,));
			}
		} else if ($jenis == "Perusahaan") {
			$id      = $this->input->post('id');
			$cek = $this->m_master->get_data_one("m_perusahaan", "nm_perusahaan", $id)->num_rows();
			if ($cek > 0) {
				echo json_encode(array('data' =>  FALSE));
			} else {
				$result     = $this->m_master->insert_perusahaan();
				echo json_encode(array('data' =>  TRUE));
			}
		} else if ($jenis == "PoMaster") {
			$id_perusahaan = $this->input->post('id_perusahaan');
			$nm_ker        = $this->input->post('nm_ker');
			$g_label       = $this->input->post('g_label');
			$width         = $this->input->post('width');
			$no_po         = $this->input->post('no_po');

			$cek = $this->m_master->get_data_po_master("po_master", "id_perusahaan", $id_perusahaan, $nm_ker, "g_label", $g_label, "width", $width, "no_po", $no_po)->num_rows();
			if ($cek > 0) {
				echo json_encode(array('data' =>  FALSE));
			} else {
				$result     = $this->m_master->insert_po_master();
				echo json_encode(array('data' =>  TRUE));
			}
		} elseif ($jenis == "PL") {
			$no_surat      = $this->input->post('no_surat');
			$no_so      = $this->input->post('no_so');

			$cek = $this->m_master->get_data_one("pl", "no_surat", $no_surat)->num_rows();

			$cek2 = $this->m_master->get_data_one("pl", "no_so", $no_so)->num_rows();
			// $cek = $this->m_master->get_data_one("admin", "username", $username)->num_rows();
			if ($cek > 0) {
				echo json_encode(array('data' =>  FALSE, 'msg' => 'No Surat Jalan Sudah Ada'));
			} else if ($cek2 > 0) {
				echo json_encode(array('data' =>  FALSE, 'msg' => 'No SO Sudah Ada'));
			} else {
				$result     = $this->m_master->insert_pl();
				echo json_encode(array('data' =>  TRUE));
			}
		} elseif ($jenis == "Invoice") {
			$no_invoice = $this->input->post('no_invoice');

			$cek = $this->m_master->get_data_one("invoice_header", "no_invoice", $no_invoice)->num_rows();
			if ($cek > 0) {
				echo json_encode(array('data' =>  FALSE, 'msg' => 'NO INVOICE SUDAH ADA ! ! !'));
			} else {
				$result = $this->m_master->insert_invoice();
				$dd = $this->m_master->get_data_one("invoice_header", "no_invoice", $no_invoice)->row();
				echo json_encode(array(
					'data' => TRUE,
					'id' => $dd->id,
					'invv' => $dd->no_invoice,
				));
			}
		}
	}

	function insert_file()
	{
		$jenis      = $this->uri->segment(3);

		if ($jenis == "Barang") {
			$id      = $this->input->post('id');
			$cek = $this->m_master->get_data_one("inv", "acc", $id)->num_rows();
			// $cek = $this->m_master->get_data_one("admin", "username", $username)->num_rows();
			if ($cek > 0) {
				echo json_encode(array('data' =>  FALSE, "msg" => "Acc Sudah Ada"));
			} else {
				$upload = $this->m_master->upload('foto', $id, 'inv');

				if ($upload['result'] == "success") {
					$result     = $this->m_master->insert_barang($upload, '1');
					echo json_encode(array('data' =>  TRUE, "msg" => "Berhasil"));
				} else {
					$result     = $this->m_master->insert_barang($upload, '0');
					echo json_encode(array('data' =>  TRUE, "msg" => "Berhasil, Gambar tidak tersimpan ke database"));
				}
			}
		}
	}

	function update_file()
	{
		$jenis      = $this->uri->segment(3);

		if ($jenis == "Barang") {
			$id      = $this->input->post('id');

			$upload = $this->m_master->upload('foto', $id, 'inv');

			if ($upload['result'] == "success") {
				$result     = $this->m_master->update_barang($upload, '1');
				echo json_encode(array('data' =>  TRUE, "msg" => "Berhasil"));
			} else {
				$result     = $this->m_master->update_barang($upload, '0');
				echo json_encode(array('data' =>  TRUE, "msg" => "Berhasil, Gambar tidak tersimpan ke database"));
			}
		}
	}

	function load_data()
	{
		$jenis = $this->input->post('jenis');
		$group = $this->input->post('group'); //buat invoice

		if ($jenis == "Timbangan") {
			// $query = $this->m_master->get_timbangan()->result();
			$query = $this->m_master->getMasterRoll();
			$i = 1;
			if($query->num_rows() == 0){
				$data[] =  ["","","","","","","","","",""];
			}else{
				foreach ($query->result() as $r) {
					$id = "'$r->id'";

					$print = base_url("Master/print_timbangan?id=").$r->roll;
					$print2 = base_url("Master/print_timbangan2?id=").$r->roll;

					$row = array();
					$row[] = $r->roll;
					$row[] = $r->tgl;
					$row[] = $r->nm_ker;
					$row[] = $r->g_label;
					// $row[] = $r->g_ac;
					$row[] = round($r->width,2);
					$row[] = $r->diameter;
					$row[] = $r->weight;
					$row[] = $r->joint;
					$row[] = $r->ket;
					$aksi ="";
					// #FF9800 - #fff edit
					// #FB483A - #fff hapus
					// #fff - #333333 kcl
					// #4CAF50 - besar
					if($r->ctk == 1){
						$aksi .='SUDAH CETAK LABEL!';
					}else if($r->ctk == 0){
						// CEK OLEH QC DULU
						$edit = '<button type="button" onclick="tampil_edit('.$id.')" class="btn bg-orange">EDIT</button>';
						$hapus = '<button type="button" onclick="deleteData('.$id.','."'".$r->roll."'".')" class="btn btn-danger">HAPUS</button>';
						if($r->status == 1){
							$aksi .='STATUS CEK QC! '.$edit.' '.$hapus;
						}else{
							$aksi = '
							<a type="button" href="'.$print.'" target="_blank" class="btn btn-default">
								L BESAR
							</a>
							<a type="button" href="'.$print2.'" target="_blank" class="btn bg-green">
								L KECIL
							</a>';
						}
					}

                    $row[] = $aksi;
                    $data[] = $row;
				}
			}

			$output = array(
				"data" => $data,
			);
		} else if ($jenis == "list_timbangan") {
			$query = $this->m_master->get_timbangan();
			$i = 1;

			if ($query->num_rows() == 0) {
				$data[] =  ["", "", "", "", "", "", "", "", "", ""];
			} else {

				foreach ($query->result() as $r) {
					$id = "$r->id";
					// $print = base_url("Master/print_timbangan?id=").$r->roll;

					$row = array();
					$row[] = '<div style="color:#000;font-weight:bold">' . $r->roll . '</div>';
					$row[] = $r->tgl;
					$row[] = $r->nm_ker;
					$row[] = $r->g_label;
					$row[] = $r->g_ac;
					$row[] = '<div style="color:#000;font-weight:bold">' . $r->width . '</div>';
					$row[] = $r->diameter;
					$row[] = $r->weight;
					$row[] = $r->joint;


					$aksi = '   
                           
                            <a type="button" onclick="addToCart(' . "'" . $r->roll . "'" . ')" class="btn bg-brown btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">check</i>
                            </a>
                                            ';


					$row[] = $aksi;
					$data[] = $row;

					// $i++;
				}
			}

			$output = array(
				"data" => $data,
			);
		} else if ($jenis == "view_timbang") {
			$id = $_POST['id'];
			$query = $this->m_master->get_view_timbangan($id);

			if ($query->num_rows() == 0) {
				$data[] =  ["", "", "", "", "", "", "", "", ""];
			} else {
				$i = 1;
				foreach ($query->result() as $r) {
					$id = "$r->id";
					// $print = base_url("Master/print_timbangan?id=").$r->roll;

					$row = array();
					$row[] = $r->roll;
					$row[] = $r->tgl;
					$row[] = $r->nm_ker;
					$row[] = $r->g_label;
					$row[] = $r->g_ac;
					$row[] = $r->width;
					$row[] = $r->diameter;
					$row[] = $r->weight;
					$row[] = $r->joint;


					$data[] = $row;

					// $i++;
				}
			}

			$output = array(
				"data" => $data,
			);
		} else if ($jenis == "PL") {
			// $i=1;
			$query = $this->m_master->get_PL();

			if ($query->num_rows() == 0) {
				$data[] =  ["", "", "", "", "", "", "", ""];
			} else {

				foreach ($query->result() as $r) {
					// $i++;
					$id = "'$r->id'";
					$nno_pkb = "'$r->no_pkb'";
					$print = base_url("Master/print_pl?id=") . $r->id;

					$row = array();
					// $row[] = $i;
					$row[] = $r->id;
					$row[] = $r->tgl;
					$row[] = $r->no_surat;
					$row[] = $r->no_so;
					$row[] = $r->no_pkb;
					$row[] = $r->nm_perusahaan;
					// $row[] = $r->no_telp;
					$row[] =
						'<a type="button" onclick=view_timbang(' . $r->id . ') class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                                ' . $r->jml_timbang . '
                            </a>';

					$aksi = "";

					// print tunggal di pl
					// <a type="button" href="'.$print.'" target="blank" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
					//     <i class="material-icons">print</i>
					// </a>

					$superbtn = '<button type="button" onclick="view_detail(' . $id . ')" class="btn btn-info btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">remove_red_eye</i>
                            </button> 
                            <button type="button" onclick="tampil_edit(' . $id . ')" class="btn bg-orange btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">edit</i>
                            </button>
                          <button type="button" onclick="deleteData(' . $id . ',' . "" . ')" class="btn btn-danger btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">delete</i>
                            </button>';

					$superbtn2 = '<button type="button" onclick="view_detail(' . $id . ')" class="btn btn-info btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">remove_red_eye</i>
                            </button>';


					// CEK PO PL SATU UKURAN FIX
					$uk_fix = $this->m_master->get_cek_po_pl($r->id, $r->no_pkb);

					// if ($this->session->userdata('level') == "SuperAdmin" && $r->cek_po == 0 && $uk_fix == 1) {
					if ($this->session->userdata('level') == "SuperAdmin" && $r->cek_po == 0) {
						$aksi = '' . $superbtn . '
                            <a type="button" onclick="confirmCekPo(' . $id . ',' . $nno_pkb . ',' . "" . ')" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">check</i>
                            </a>';
					} else if ($this->session->userdata('level') == "SuperAdmin" && $r->cek_po == 0 && $uk_fix <> 1) {
						$aksi = '' . $superbtn . '
                            <a type="button" onclick="zonk" class="btn bg-black btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">check</i>
                            </a>';
					} else if ($this->session->userdata('level') == "SuperAdmin" && $r->cek_po == 1) {
						$aksi = '' . $superbtn2 . '
                            <a type="button" onclick="vvvv" class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">check</i>
                            </a>';
					} else {
						// <a type="button" href="'.$print.'" target="blank" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
						//     <i class="material-icons">print</i>
						// </a>

						$aksi = '
                            <button type="button" onclick="view_detail(' . $id . ')" class="btn btn-info btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">remove_red_eye</i>
                            </button>';
					}


					$row[] = $aksi;
					$data[] = $row;
				}
			}

			$output = array("data" => $data);
		} else if ($jenis == "Perusahaan") {

			$query = $this->m_master->get_perusahaan();

			if ($query->num_rows() == 0) {
				$data[] =  ["", "", "", "", "", ""];
			} else {
				$i = 1;

				foreach ($query->result() as $r) {
					$id = "'$r->id'";

					$row = array();
					$row[] = $r->id;
					$row[] = $r->pimpinan;
					$row[] = $r->nm_perusahaan;
					$row[] = $r->alamat;
					$row[] = $r->no_telp;

					$aksi = "";

					if ($this->session->userdata('level') == "SuperAdmin") {


						$aksi = '   
                            
                            <button type="button" onclick="tampil_edit(' . $id . ')" class="btn bg-orange btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">edit</i>
                            </button>
                          <button type="button" onclick="deleteData(' . $id . ',' . "" . ')" class="btn btn-danger btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">delete</i>
                            </button>';

						$row[] = $aksi;
						$data[] = $row;
					} else {
						$aksi .= '-';
						$row[] = $aksi;
						$data[] = $row;
					}

					// $i++;
				}
			}
			$output = array("data" => $data);
		} else if ($jenis == "PoMaster") {

			$query = $this->m_master->get_po_master();

			if ($query->num_rows() == 0) {
				$data[] =  ["", "", "", "", "", "", "", ""];
			} else {
				$i = 1;

				foreach ($query->result() as $r) {
					$id = "'$r->id'";

					$row = array();
					$row[] = $r->id_perusahaan;
					$row[] = $r->nm_perusahaan;
					$row[] = $r->tgl;
					$row[] = $r->no_po;
					$row[] = $r->nm_ker;
					$row[] = $r->g_label;
					$row[] = $r->width;
					$row[] = $r->tonase;

					$aksi = "";

					if ($this->session->userdata('level') == "SuperAdmin") {


						$aksi = '   
                            
                            <button type="button" onclick="tampil_edit(' . $id . ')" class="btn bg-orange btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">edit</i>
                            </button>
                          <button type="button" onclick="deleteData(' . $id . ',' . "" . ')" class="btn btn-danger btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">delete</i>
                            </button>';

						$row[] = $aksi;
						$data[] = $row;
					} else {
						$aksi .= '-';
						$row[] = $aksi;
						$data[] = $row;
					}

					// $i++;
				}
			}
			$output = array("data" => $data);
		} else if ($jenis == "Invoice") {
			$query = $this->m_master->get_invoice();

			if ($query->num_rows() == 0) {
				$data[] =  ["", "", "", "", "", ""];
			} else {
				$i = 1;
				foreach ($query->result() as $r) {
					$id = "'$r->id'";
					$nm = "'$r->no_invoice'";
					$opsi = "'opsi'";
					$print = base_url("laporan/print_invoice_v2?no_invoice=") . $r->no_invoice;

					$row = array();
					$row[] = $i;
					$row[] = $r->tgl;
					$row[] = $r->no_invoice;
					$row[] = $r->kepada;
					$row[] = $r->nm_perusahaan;
					$aksi = "";

					if ($this->session->userdata('level') == "SuperAdmin") {
						if ($r->status == "Closed") {
							$aksi = '<a type="button" onclick="editDataInv(' . $id . ',' . $nm . ')" class="btn bg-orange btn-circle waves-effect waves-circle waves-float">
									<i class="material-icons">edit</i>
								</a>
								<button type="button" onclick="deleteData(' . $id . ',' . $nm . ',' . $opsi . ')" class="btn btn-danger btn-circle waves-effect waves-circle waves-float" title="Reject">
									<i class="material-icons">delete</i>
								</button>
								<a type="button" onclick="confirmData(' . $id . ',' . $nm . ')" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
									<i class="material-icons">check</i>
								</a>';
						} else if ($r->status == "Verified") {
							$aksi = '<a type="button" onclick="editDataInv(' . $id . ',' . $nm . ')" class="btn bg-orange btn-circle waves-effect waves-circle waves-float">
									<i class="material-icons">edit</i>
								</a>
								<a type="button" href="' . $print . '" target="blank" class="btn btn-default btn-circle waves-effect waves-circle waves-float" title="Print Invoice">
							        <i class="material-icons">print</i>
							    </a>';
						}
					} else {
						$aksi = '';
					}
					$row[] = $aksi;
					$data[] = $row;

					$i++;
				}
			}

			$output = array("data" => $data);
		} else if ($jenis == "Home") {

			$query = $this->m_master->get_jatuh_tempo();

			if ($query->num_rows() == 0) {
				$data[] =  ["", "", "", "", "", "", ""];
			} else {
				$i = 1;
				foreach ($query->result() as $r) {
					$row = array();
					$row[] = $i;
					$row[] = $this->m_fungsi->tglInd_skt($r->tgl);
					$row[] = $r->no_invoice;
					$row[] = $r->kepada;
					$row[] = $r->nm_perusahaan;

					$getKomPiu = $this->db->query("SELECT SUM(li.weight) AS berat,SUM(li.seset) AS seset,p.harga, h.* FROM invoice_header h
                        INNER JOIN invoice_list li ON h.no_invoice = li.no_invoice
                        INNER JOIN invoice_harga p ON li.no_invoice = p.no_invoice AND li.no_po=p.no_po AND li.nm_ker=p.nm_ker AND li.g_label=p.g_label
                        WHERE h.no_invoice='$r->no_invoice'
                        GROUP BY h.no_invoice,li.no_po,li.nm_ker DESC,li.g_label");
					$totTerbilang2 = 0;
					foreach ($getKomPiu->result() as $jmlPay) {
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
					$row[] = 'Rp. ' . number_format($totTerbilang2);

					$date_now = date('Y-m-d');
					if ($date_now == $r->jto) {
						$row[] = '<div style="color:#ff8c00;font-weight:bold">' . $r->jto . '</div>';
					} else if ($date_now <= $r->jto) {
						$row[] = '<div style="color:#0a0;font-weight:bold">' . $r->jto . '</div>';
					} else if ($date_now >= $r->jto) {
						$row[] = '<div style="color:#f00;font-weight:bold">' . $r->jto . '</div>';
					}

					$data[] = $row;
					$i++;
				}
			}

			$output = array("data" => $data);
		} else if ($jenis == "list_barang") {
			$query = $this->m_master->get_barang();

			if ($query->num_rows() == 0) {
				if ($group == 1) {
					$data[] =  ["", "", "", "", "", "", "", ""];
				} else {
					$data[] =  ["", "", "", "", ""];
				}
			} else {
				$i = 1;
				$ii = 100;
				foreach ($query->result() as $r) {
					$row = array();

					if ($group == 1) {
						$dd = $i;
						$i_berat = $r->weight;
						$i_width = $r->width;
						$i_qty = $r->qty;

						$row[] = trim($r->no_surat);
						$row[] = '<div style="width:20%">' . $r->no_po . '</div>';
						$row[] = $r->g_label;
						$row[] = round($i_width, 2);
						$row[] = $i_qty;
						$row[] = '<input style="text-align:right" type="text" class="form-control" id="berat' . $i . '" value="' . number_format($i_berat) . '" disabled> KG';
						$row[] = '<input style="text-align:right" type="text" class="angka form-control" id="seset' . $i . '" placeholder="0" autocomplete="off" onkeypress="return hanyaAngka(event)"> KG';
						$i++;
					} else {
						$dd = $ii;
						$i_berat = 0;
						$i_width = 1;
						$i_qty = 1;

						$row[] = $r->no_po;
						$row[] = $r->g_label;
						$row[] = $r->nm_ker;
						$row[] = '<input style="text-align:right" type="text" class="angka form-control" id="harga_inv' . $ii . '" placeholder="0" autocomplete="off" onkeypress="return hanyaAngka(event)"> ';
						$ii++;
					}

					$aksi = '<a type="button" onclick="addToCart(' . "'" . $r->no_po . "'" . ',' . "'" . $r->no_surat . "'" . ',' . "'" . $r->no_pkb . "'" . ',' . "'" . $r->nm_ker . "'" . ',' . "'" . $r->g_label . "'" . ',' . "'" . round($i_width, 2) . "'" . ',' . "'" . $i_qty . "'" . ',' . "'" . $i_berat . "'" . ',' . "'" . $group . "'" . ',' . "'" . $dd . "'" . ')" class="addinv btn bg-brown btn-circle waves-effect waves-circle waves-float">
							<i class="material-icons">check</i>
						</a>';

					$row[] = $aksi;
					$data[] = $row;
				}
			}

			$output = array("data" => $data,);
		}

		echo json_encode($output);
	}

	// ADD CART INVOICE
	function addCartInvoice()
	{
		if ($_POST['seset'] == 0 || $_POST['seset'] == '0') {
			$i_harga = $_POST['harga_inv'];
		} else {
			$i_harga = $_POST['seset'];
		}

		$data = array(
			'id' => $_POST['i'],
			'name' => $_POST['i'],
			'price' => $i_harga,
			'qty' => $_POST['i'],
			'options' => array(
				'no_po' => $_POST['no_po'],
				'no_surat' => trim($_POST['no_surat']),
				'no_pkb' => $_POST['no_pkb'],
				'g_label' => $_POST['g_label'],
				'width' => $_POST['width'],
				'weight' => $_POST['weight'],
				'qty' => $_POST['qty'],
				'opsi' => $_POST['opsi'],
				'nm_ker' => $_POST['nm_ker'],
			)
		);

		$this->cart->insert($data);
		echo $this->show_cart_inv($_POST['opsi']);
	}

	function show_cart_inv($opsi = '')
	{
		$output_list_inv = '';
		$output_harga_po = '';

		$i = 0;
		$ii = 0;
		foreach ($this->cart->contents() as $items) {

			if ($items['price'] == 0 || $items['price'] == '0' || $items['price'] == '') {
				$i_input = 0;
			} else {
				$i_input = $items['price'];
			}

			$hasilSssst = $items['options']['weight'] - $i_input;

			if ($items['options']['opsi'] == 1) {
				$i++;
				$output_list_inv .= '
				<tr>
					<td style="text-align:center">' . $i . '</td>
					<td>' . $items['options']['no_po'] . '</td>
					<td>' . $items['options']['g_label'] . '</td>
					<td>' . $items['options']['width'] . '</td>
					<td>' . $items['options']['qty'] . '</td>
					<td style="text-align:center">' . $items['options']['weight'] . '</td>
					<td style="text-align:center">' . $i_input . '</td>
					<td style="text-align:center">' . $hasilSssst . '</td>
					<td></td>
				</tr>';
			} else {
				$ii++;
				$output_harga_po .= '
				<tr>
					<td style="text-align:center">' . $ii . '</td>
					<td>' . $items['options']['no_po'] . '</td>
					<td>' . $items['options']['g_label'] . '</td>
					<td>' . $items['options']['nm_ker'] . '</td>
					<td style="text-align:center">' . $i_input . '</td>
					<td></td>
				</tr>';
			}
		}

		if ($opsi == 1) {
			return $output_list_inv;
		} else {
			return $output_harga_po;
		}
	}

	function hapus_cart_barang()
	{
		$data = array(
			'rowid' => $this->input->post('row_id'),
			'qty' => 0,
		);
		$this->cart->update($data);
		echo $this->show_cart_inv();
	}

	function destroy_cart_inv()
	{
		$this->cart->destroy();
		echo $this->show_cart_inv();
	}

	function get_akb()
	{
		$searchTerm = $_GET['search'];
		// Get users
		$response = $this->m_master->get_akb($searchTerm);

		echo json_encode($response);
	}

	function load_sj()
	{
		$searchTerm = $_GET['search'];

		// Get users
		$response = $this->m_master->list_sj($searchTerm);

		echo json_encode($response);
	}

	function loadPlNopol(){
		$search = $_GET['search'];
		$response = $this->m_master->loadPlNopol($search);
		echo json_encode($response);
	}

	function loadRkPl(){
		$search = $_GET['search'];
		$rktgl = $_GET['rktgl'];
		$response = $this->m_master->loadRkPl($search, $rktgl);
		echo json_encode($response);
	}

	function loadRkPo(){
		$search = $_GET['search'];
		$exp = explode("_ex_", $_GET['opl_tglpl']);
		$opl = $exp[0];
		$tglpl = $exp[1];
		$response = $this->m_master->loadRkPo($search, $opl, $tglpl);
		echo json_encode($response);
	}

	function loadRkJns(){
		$search = $_GET['search'];
		$exp = explode("_ex_", $_GET['opl_tglpl_nopo']);
		$opl = $exp[0];
		$tglpl = $exp[1];
		$nopo = $exp[2];
		$response = $this->m_master->loadRkJns($search, $opl, $tglpl, $nopo);
		echo json_encode($response);
	}

	function loadRkGsm(){
		$search = $_GET['search'];
		$exp = explode("_ex_", $_GET['opl_tglpl_nopo_nmker']);
		$opl = $exp[0];
		$tglpl = $exp[1];
		$nopo = $exp[2];
		$nmker = $exp[3];
		$response = $this->m_master->loadRkGsm($search, $opl, $tglpl, $nopo, $nmker);
		echo json_encode($response);
	}

	function loadRkUkuran(){
		$search = $_GET['search'];
		$exp = explode("_ex_", $_GET['opl_tglpl_nopo_nmker_glabel']);
		$opl = $exp[0];
		$tglpl = $exp[1];
		$nopo = $exp[2];
		$nmker = $exp[3];
		$glabel = $exp[4];
		$response = $this->m_master->loadRkUkuran($search, $opl, $tglpl, $nopo, $nmker, $glabel);
		echo json_encode($response);
	}

	function loadPtPO(){ 
		$searchTerm = $_GET['search'];
		$opsi = $_GET['opsi'];
		$response = $this->m_master->loadPtPO($searchTerm,$opsi);
		echo json_encode($response);
	}

	function loadPlPO(){ 
		$searchTerm = $_GET['search'];
		$fid = $_GET['fid'];
		$response = $this->m_master->loadPlPO($searchTerm,$fid);
		echo json_encode($response);
	}

	function opsiPajak(){
		$pajak = explode("_ex_", $_POST['id']);
		echo json_encode(array('pajak' => $pajak[2]));
	}

	function loadPlJns(){ 
		$search = $_GET['search'];
		$idpo_nopo = $_GET['idpo_nopo'];
		$exp = explode("_ex_", $idpo_nopo);
		$id_po = $exp[0];
		$no_po = $exp[1];
		$response = $this->m_master->loadPlJns($search,$id_po,$no_po);
		echo json_encode($response);
	}

	function loadPlPlhGsm(){ //
		$search = $_GET['search'];
		$idpo_nopo_nmker = $_GET['idpo_nopo_nmker'];
		$exp = explode("_ex_", $idpo_nopo_nmker);
		$id_po = $exp[0];
		$no_po = $exp[1];
		$nm_ker = $exp[2];

		$response = $this->m_master->loadPlPlhGsm($search,$id_po,$no_po,$nm_ker);
		echo json_encode($response);
	}

	function load_perusahaan()
	{
		$searchTerm = $_GET['search'];

		// Get users
		$response = $this->m_master->list_perusahaan($searchTerm);

		echo json_encode($response);
	}

	function update()
	{
		$jenis = $_POST['jenis'];

		if ($jenis == "Timbangan") {
			$id = $this->input->post('getid');
			$getid = $this->m_master->get_data_one("m_timbangan", "id" ,$id)->row();
			if(($getid->status == 0 || $getid->status == 2 || $getid->status == 3) && $getid->id_pl == 0){
				echo json_encode(array('data' => false, 'msg' => 'DATA ROLL SUDAH DICEK QC! TIDAK BISA EDIT!'));
			}else if($getid->status == 1 && $getid->id_pl == 0){
				$this->m_master->update_timbangan();
				echo json_encode(array('data' => TRUE, 'getid' => $getid->id));
			}else{
				echo json_encode(array('data' => false, 'msg' => 'DATA ROLL SUDAH TERJUAL'));
			}
		} else if ($jenis == "Perusahaan") {
			$id      = $this->input->post('nm_perusahaan');
			$id_lama      = $this->input->post('nm_perusahaan_lama');
			$cek = $this->m_master->get_data_one("m_perusahaan", "nm_perusahaan", $id)->num_rows();

			if ($cek > 0 && $id != $id_lama) {
				echo json_encode(array('data' =>  FALSE));
			} else {
				$result = $this->m_master->update_perusahaan();
				echo json_encode(array('data' =>  TRUE));
			}
		} else if ($jenis == "PoMaster") {

			// $id_perusahaan = $this->input->post('id_perusahaan');
			// $g_label       = $this->input->post('g_label');
			// $width         = $this->input->post('width');
			// $no_po         = $this->input->post('no_po');

			// $cek = $this->m_master->get_data_po_master("po_master","id_perusahaan",$id_perusahaan,"g_label",$g_label,"width",$width,"no_po",$no_po)->num_rows();

			// $id      = $this->input->post('id_perusahaan');
			// $id_lama      = $this->input->post('nm_perusahaan_lama');

			// $cek = $this->m_master->get_data_one("po_master","id",$id)->num_rows();

			// if ($cek > 0) {
			//     echo json_encode(array('data' =>  FALSE));
			// }else{
			$result = $this->m_master->update_master_po();
			echo json_encode(array('data' =>  TRUE));
			// }

		} else if ($jenis == "PL") {
			$no_surat      = $this->input->post('no_surat');
			$no_so      = $this->input->post('no_so');
			$no_surat_lama      = $this->input->post('no_surat_lama');
			$no_so_lama      = $this->input->post('no_so_lama');

			$cek = $this->m_master->get_data_one("pl", "no_surat", $no_surat)->num_rows();

			$cek2 = $this->m_master->get_data_one("pl", "no_so", $no_so)->num_rows();
			// $cek = $this->m_master->get_data_one("admin", "username", $username)->num_rows();
			if ($no_surat != $no_surat_lama && $cek > 0) {
				echo json_encode(array('data' =>  FALSE, 'msg' => 'No Surat Jalan Sudah Ada'));
			} else if ($no_so != $no_so_lama && $cek2 > 0) {
				echo json_encode(array('data' =>  FALSE, 'msg' => 'No SO Sudah Ada'));
			} else {
				$result = $this->m_master->update_pl();
				echo json_encode(array('data' =>  TRUE));
			}
		}
	}

	function destroy_cart()
	{
		$this->cart->destroy();
		echo $this->show_cart();
	}

	function show_cart()
	{ //Fungsi untuk menampilkan Cart

		$output = '';
		$no = 0;

		foreach ($this->cart->contents() as $items) {
			$no++;
			$output .= '
                <tr>
                    <td>' . $no . '</td>
                    <td>' . str_replace("_", "/", $items['name']) . '</td>
                    <td><button type="button" id="' . $items['rowid'] . '" class="hapus_cart btn btn-danger btn-xs">Batal</button></td>
                </tr>
            ';
		}


		return $output;
	}

	function add_to_cart()
	{ //fungsi Add To Cart

		$data = array(
			'id' => str_replace("/", "_", $_POST['roll']),
			'name' => str_replace("/", "_", $_POST['roll']),
			'price' => 0,
			'qty' => 1
		);
		$this->cart->insert($data);
		echo $this->show_cart(); //tampilkan cart setelah added
	}

	function hapus_cart()
	{ //fungsi untuk menghapus item cart
		$data = array(
			'rowid' => $this->input->post('row_id'),
			'qty' => 0,
		);
		$this->cart->update($data);
		echo $this->show_cart();
	}

	// function reject(){
	//     $result = $this->m_master->reject();
	//     echo "1";
	// }

	function confirm()
	{
		$result = $this->m_master->confirm();
		echo "1";
	}

	function confirm_cek_po()
	{
		// $id_pl = $_POST['id'];
		$no_pkb = $_POST['no_pkb'];

		// ambil po
		// $q_pl_no_po = $this->m_master->get_plpl($id_pl);
		$q_pl_no_po = $this->m_master->get_plpl($no_pkb);

		// cek po master
		$cekk_po = $q_pl_no_po->row();
		// $pl_no_po_master = $this->m_master->cek_po_master($cekk_po->g_label,$cekk_po->width,$cekk_po->no_po)->num_rows();
		$pl_no_po_master = $this->m_master->cek_po_master($cekk_po->nm_ker, $cekk_po->no_po)->num_rows();

		if ($pl_no_po_master == 0) {
			// jika tidak ada po master
			echo json_encode(array('msg' => false, 'g' => 'Master PO Tidak Ada!!'));
		} else if ($pl_no_po_master <> 0) {

			// insert po history
			$data = array();
			foreach ($q_pl_no_po->result() as $r) {
				// $data = array(
				$data[] = array(
					'id_perusahaan' => $r->id_perusahaan,
					'tgl'           => $r->tgl,
					'nm_ker'        => $r->nm_ker,
					'g_label'       => $r->g_label,
					'width'         => $r->width,
					'jml_roll'      => $r->jml_roll,
					'tonase'        => $r->tonase,
					'no_surat'      => trim($r->no_surat),
					'no_po'         => $r->no_po,
					'id_pl'         => $r->id_pl,
					'no_pkb'        => $r->no_pkb
				);

				// $this->db->insert("po_history",$data);
			}

			$this->db->insert_batch('po_history', $data);

			// update cek po PL
			$this->db->set("cek_po", 1);
			// $this->db->where('id_pl', $id_pl);
			$this->db->where('no_pkb', $no_pkb);
			$this->db->update('pl');

			// echo json_encode(array('msg' => true,'g' => $pl_no_po_master));
			echo json_encode(array('msg' => true));
		}
	}

	function hapus()
	{
		$jenis   = $_POST['jenis'];
		$id      = $_POST['id'];

		if ($jenis == "Timbangan") {
			$getId = $this->db->query("SELECT * FROM m_timbangan WHERE id='$id' AND (status='0' OR ctk='1')");
			if($getId->num_rows() == 0){
				$this->m_master->delete("m_timbangan", "id", $id);
				echo "1";
			}else{
				echo "gagal";
			}
		} else if ($jenis == "Perusahaan") {
			$return = $this->m_master->delete("m_perusahaan", "id", $id);
			echo "1";
		} else if ($jenis == "PoMaster") {
			$return = $this->m_master->delete("po_master", "id", $id);
			echo "1";
		} else if ($jenis == "PL") {
			$return = $this->m_master->delete("pl", "id", $id);

			$this->db->set("status", 0);
			$this->db->set("id_pl", "");
			$this->db->where('id_pl', $id);
			$this->db->update('m_timbangan');
			echo "1";
		} else if ($jenis == "hapus_inv") {
			$opsi = $_POST['opsi'];
			$noo_invv = $_POST['no_invoice'];

			if ($opsi == 'opsi') {
				// UPDATE STATUS DI PACKING LIST
				$get_sj = $this->db->query("SELECT * FROM invoice_list WHERE no_invoice='$noo_invv' GROUP BY no_pkb");
				foreach ($get_sj->result() as $r) {
					$this->db->set('status', 'Open');
					$this->db->where('no_pkb', $r->no_pkb);
					$this->db->update('pl');
				}

				$this->m_master->delete("invoice_header", "no_invoice", $_POST['no_invoice']);
				$this->m_master->delete("invoice_harga", "no_invoice", $_POST['no_invoice']);
				$this->m_master->delete("invoice_list", "no_invoice", $_POST['no_invoice']);
				$this->m_master->delete("invoice_pay", "no_invoice", $_POST['no_invoice']);
				echo json_encode(array(
					'data' => 1,
				));
			} else {
				$this->m_master->delete("invoice_pay", "id", $_POST['id']);
				$dd = $this->m_master->get_data_one("invoice_header", "no_invoice", $_POST['no_invoice'])->row();
				echo json_encode(array(
					'data' => TRUE,
					'id' => $dd->id,
					'invv' => $dd->no_invoice,
				));
				// echo "1";
			}
		}
	}

	function get_edit()
	{
		$id    = $_POST['id'];
		$jenis    = $_POST['jenis'];

		if ($jenis == "Timbangan") {
			$data =  $this->m_master->get_data_one("m_timbangan", "id", $id)->row();
			echo json_encode($data);
		} else if ($jenis == "Perusahaan") {
			$data =  $this->m_master->get_data_one("m_perusahaan", "id", $id)->row();
			echo json_encode($data);
		} else if ($jenis == "PoMaster") {
			$data =  $this->m_master->get_data_one("po_master", "id", $id)->row();
			echo json_encode($data);
		} else if ($jenis == "PL") {
			$data =  $this->m_master->get_data_one("pl", "id", $id)->row();
			$detail = $this->m_master->get_data_one("m_timbangan", "id_pl", $data->id)->result();
			echo json_encode(array('header' => $data, 'detail' => $detail));
		} else if ($jenis == "editInv") {
			$no_inv = $_POST['no_inv'];

			$header =  $this->m_master->get_data_one("invoice_header", "no_invoice", $no_inv)->row();
			$list = $this->m_master->get_list_inv($no_inv)->result();
			$harga = $this->m_master->get_harga_inv($no_inv)->result();
			$rincian =  $this->m_master->getItungInv($no_inv)->result();
			$rinc_pay =  $this->m_master->getRincPay($no_inv)->result();

			echo json_encode(array(
				'header' => $header,
				'list' => $list,
				'harga' => $harga,
				'rincian' => $rincian,
				'rincpay' => $rinc_pay,
			));
		}
	}

	function update_inv()
	{
		$jenis = $_POST['jenis'];

		if ($jenis == "Invoice") {
			$no_invoice = $this->input->post('no_invoice');
			$inv_lama = $this->input->post('no_invoice_lama');
			$cek = $this->m_master->get_data_one("invoice_header", "no_invoice", $no_invoice)->num_rows();

			if ($no_invoice != $inv_lama && $cek > 0) {
				echo json_encode(array('data' =>  FALSE, 'msg' => 'NO INVOICE SUDAH ADA ! ! !'));
			} else {
				$this->m_master->updateHeaderInv();
				$dd = $this->m_master->get_data_one("invoice_header", "no_invoice", $no_invoice)->row();
				echo json_encode(array(
					'data' => TRUE,
					'id' => $dd->id,
					'invv' => $dd->no_invoice,
				));
			}
		} else if ($jenis == "editInvListBarang") {
			$no_invoice = $this->input->post('no_inv');

			$this->m_master->updateInvListBarang();
			$editInv =  $this->m_master->get_data_one("invoice_header", "no_invoice", $no_invoice)->row();
			echo json_encode(array(
				'data' => TRUE,
				'id' => $editInv->id,
				'invvv' => $editInv->no_invoice,
			));
		} else if ($jenis == "payInv") {
			$no_invoice = $this->input->post('no_inv');

			$this->m_master->payInvoice();
			$payInvoice =  $this->m_master->get_data_one("invoice_header", "no_invoice", $no_invoice)->row();
			echo json_encode(array(
				'data' => TRUE,
				'id' => $payInvoice->id,
				'invvv' => $payInvoice->no_invoice,
			));
		} else {
			echo json_encode(array('data' =>  false));
		}
	}

	function loadAllOutstandingPO(){
		$html = '';
		$html .= '<style>.str {mso-number-format:\@;}</style>';

		$getData = $this->db->query("SELECT pt.pimpinan,pt.nm_perusahaan,m.* FROM po_master m INNER JOIN m_perusahaan pt ON m.id_perusahaan=pt.id
		WHERE m.status='open'
		-- AND m.id_perusahaan='169'
		GROUP BY id_perusahaan,status ORDER BY pt.pimpinan,pt.nm_perusahaan");
		$html .='<div style="overflow:auto;white-space:nowrap;"><table style="font-size:12px;color:#000" border="1">';
		$html .='<tr style="background:#e9e9e9;text-align:center">
			<td style="padding:5px;font-weight:bold">NO</td>
			<td style="padding:5px;font-weight:bold">CUSTOMER</td>
			<td style="padding:5px;font-weight:bold">SISA PO</td>
			<td style="padding:5px;font-weight:bold">KIRIMAN</td>
			<td style="padding:5px;font-weight:bold">- / +</td>
		</tr>';
		$i = 0;
		$totPoBerat = 0;
		$totSKirBerat = 0;
		$totSPminBerat = 0;
		foreach($getData->result() as $r){
			$i++;
			if($r->pimpinan == '-' || $r->pimpinan == ''){
				$nama = '';
			}else{
				$nama = $r->pimpinan.' - ';
			}
			if($r->nm_perusahaan == '-' || $r->nm_perusahaan == ''){
				$nmpt = '';
			}else{
				$nmpt = $r->nm_perusahaan;
			}
			$html .='<tr>
				<td style="padding:5px;text-align:center">'.$i.'</td>
				<td style="padding:5px">'.$nama.$nmpt.'</td>';

			$getDatar = $this->db->query("SELECT id_po,no_po,status,SUM(jml_roll) AS jml_roll,SUM(tonase) AS tonase FROM po_master
			WHERE id_perusahaan='$r->id_perusahaan' AND status='open'
			GROUP BY id_po,no_po,status");
			$totBerat = 0;
			$totKirBerat = 0;
			$totPminBerat = 0;
			foreach($getDatar->result() as $rdua){
				$getKiriman = $this->db->query("SELECT po.id_po,po.no_po,po.id_perusahaan,po.nm_ker,po.g_label,po.width,po.tonase,po.jml_roll,COUNT(t.roll) AS pjmlroll,SUM(t.weight - t.seset) AS totkirpseset FROM po_master po
				LEFT JOIN pl p ON po.no_po=p.no_po AND po.id_perusahaan=p.id_perusahaan
				LEFT JOIN m_timbangan t ON p.id=t.id_pl AND po.nm_ker=t.nm_ker AND po.g_label=t.g_label AND po.width=t.width
				WHERE po.id_perusahaan='$r->id_perusahaan' AND po.no_po='$rdua->no_po' AND po.status='open'
				GROUP BY po.id_po,po.no_po,po.id_perusahaan,po.nm_ker,po.g_label,po.width");
				$kirBerat = 0;
				$pminBerat = 0;
				foreach($getKiriman->result() as $kir){
					if($kir->totkirpseset == null){
						$totkirpseset = 0;
					}else{
						$totkirpseset = $kir->totkirpseset;
					}
					$kurangBerat = $totkirpseset - $kir->tonase;
					// JIKA LEBIH DARI PO HILANGKAN
					if($totkirpseset >= $kir->tonase){
						$fxBerat = 0;
					}else{
						$fxBerat = $kurangBerat;
					}
					$kirBerat += $totkirpseset;
					$pminBerat += $fxBerat;
				}
				// JIKA BELUM ADA KIRIMAN
				if($getKiriman->num_rows() == 0){
					$kTonn = $rdua->tonase;
				}else{	
					$kTonn = 0;
				}
				$totBerat += $rdua->tonase;
				$totKirBerat += $kirBerat;
				$totPminBerat += $pminBerat - $kTonn;
			}

			$totPoBerat += $totBerat;
			$totSKirBerat += $totKirBerat;
			$totSPminBerat += $totPminBerat;
			$html .='
				<td class="str" style="padding:5px;text-align:right">'.number_format($totBerat).'</td>
				<td class="str" style="padding:5px;text-align:right">'.number_format($totKirBerat).'</td>
				<td class="str" style="padding:5px;text-align:right">'.number_format($totPminBerat).'</td>
			</tr>';
		}
		// TOTAL KIRIMAN
		$html .='<tr style="background:#e9e9e9;font-weight:bold;text-align:center">
			<td style="padding:5px" colspan="2">TOTAL</td>
			<td class="str" style="padding:5px">'.number_format($totPoBerat).'</td>
			<td class="str" style="padding:5px">'.number_format($totSKirBerat).'</td>
			<td class="str" style="padding:5px">'.number_format($totSPminBerat).'</td>
		</tr>';
		$html .='</tr></table></div>';

		echo $html;
	}

	function editQCRoll(){
		$id = $_POST['id'];

		$idOldRoll = $this->m_master->get_data_one("m_timbangan", "id", $id)->row();
		$data = array(
			'data' => false,
			'msg' => 'DATA SUDAH MASUK RENCANA KIRIM!',
			'id_roll' => $idOldRoll->id,
			'roll' => $idOldRoll->roll,
			'tgl' => $idOldRoll->tgl,
			'g_ac' => $idOldRoll->g_ac,
			'rct' => $idOldRoll->rct,
			'bi' => $idOldRoll->bi,
			'nm_ker' => $idOldRoll->nm_ker,
			'g_label' => $idOldRoll->g_label,
			'width' => $idOldRoll->width,
			'diameter' => $idOldRoll->diameter,
			'weight' => $idOldRoll->weight,
			'joint' => $idOldRoll->joint,
			'ket' => $idOldRoll->ket,
			'status' => $idOldRoll->status,
		);

		// CEK JIKA SUDAH MASUK RENCANA KIRIM
		$cek_rk = $this->db->query("SELECT*FROM m_timbangan WHERE id='$id' AND (id_rk='' OR id_rk IS NULL)");
		if($_POST['edit'] == 'ListStokGudang' && $cek_rk->num_rows() == 0){
			echo json_encode($data);
		}else if((($_POST['lnm_ker'] != $_POST['nm_ker']) || ($_POST['lg_label'] != $_POST['g_label']) || ($_POST['lwidth'] != $_POST['width']) || ($_POST['lweight'] != $_POST['weight']) || ($_POST['ldiameter'] != $_POST['diameter']) || ($_POST['ljoint'] != $_POST['joint']) || ($_POST['lket'] != $_POST['ket']) || ($_POST['lstatus'] != $_POST['status'])) && $_POST['edit'] == 'LapQC' && $cek_rk->num_rows() == 0){
			echo json_encode($data);
		}else{
			$this->m_master->updateQCRoll();
			$idNewRoll = $this->m_master->get_data_one("m_timbangan", "id", $id)->row();
			echo json_encode(
				array(
					'data' => true,
					'id_roll' => $idNewRoll->id,
					'roll' => $idNewRoll->roll,
					'tgl' => $idNewRoll->tgl,
					'g_ac' => $idNewRoll->g_ac,
					'rct' => $idNewRoll->rct,
					'bi' => $idNewRoll->bi,
					'nm_ker' => $idNewRoll->nm_ker,
					'g_label' => $idNewRoll->g_label,
					'width' => $idNewRoll->width,
					'diameter' => $idNewRoll->diameter,
					'weight' => $idNewRoll->weight,
					'joint' => $idNewRoll->joint,
					'ket' => $idNewRoll->ket,
					'status' => $idNewRoll->status,
					'msg' => 'BERHASIL!!!',
				)
			);
		}
	}

	function print_timbangan() { //
		$id = $_GET['id'];
		$data = $this->db->query("SELECT * FROM m_timbangan WHERE roll = '$id'")->row();
		if($data->status == 0){
			$ket = 0;
			$sty = '';
		}else if($data->status == 2){
			$ket = 'PPI';
			$sty = '';
		}else{
			if($data->ket == ''){
				$sty = '';
				$ket = 'BUFFER';
			}else{
				if(strlen($data->ket) <= 50){
					$sz = 30;
				}else{
					$sz = 18;
				}
				$sty = ';font-weight:bold;font-size:'.$sz.'';
				$ket = $data->ket;
			}
		}

		$data_perusahaan = $this->db->query("SELECT * FROM perusahaan limit 1")->row();
		$html = '';
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
					<td style="text-align:center">'.($data->weight - $data->seset).' KG</td>
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
		
		$this->db->query("UPDATE m_timbangan SET ctk='1' WHERE roll='$id'");
		if($data->ctk == 0){
			$this->m_fungsi->newMpdf($html, 15, 15, 5, 15, 'L', 'F4');
		}else if($this->session->userdata('level') == "SuperAdmin" || $this->session->userdata('level') == "Admin" || $this->session->userdata('level') == "QC"){
			$this->m_fungsi->newMpdf($html, 15, 15, 5, 15, 'L', 'F4');
		}else{
			redirect(base_url("Master"));
		}
	}

	function print_timbangan2() {
		$id = $_GET['id'];
		$data = $this->db->query("SELECT * FROM m_timbangan WHERE roll = '$id'")->row();
		if($data->status == 0){
			$ket = 0;
			$sty = '';
		}else if($data->status == 2){
			$ket = 'PPI';
			$sty = '';
		}else{
			if($data->ket == ''){
				$sty = '';
				$ket = 'BUFFER';
			}else{
				$sty = ';font-weight:bold;font-size:12px';
				$ket = $data->ket;
			}
		}

		$html = '';
		$html .= '<br><br>
			<table cellspacing="0" cellpadding="5" style="font-size:37px;width:100%" border="1">
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
					<td style="text-align:center">'.round($data->width,2).' CM</td>
				</tr>
				<tr>
					<td>DIAMETER</td>
					<td style="text-align:center">'.$data->diameter.' CM</td>
				</tr>
				<tr>
					<td>WEIGHT</td>
					<td style="text-align:center">'.($data->weight - $data->seset).' KG</td>
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
		
		$this->db->query("UPDATE m_timbangan SET ctk='1' WHERE roll='$id'");
		if($data->ctk == 0){
			$this->m_fungsi->newMpdf($html, 10, 10, 10, 10, 'P', 'F4');
		}else if($this->session->userdata('level') == "SuperAdmin" || $this->session->userdata('level') == "Admin" || $this->session->userdata('level') == "QC"){
			$this->m_fungsi->newMpdf($html, 10, 10, 10, 10, 'P', 'F4');
		}else{
			redirect(base_url("Master"));
		}
	}

	function print_pl()
	{
		$id = $_GET['id'];

		$data_header = $this->db->query("SELECT * FROM pl WHERE id = '$id'")->row();
		$data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE id_pl = '$id' ORDER BY roll");

		$html = '';

		$html .= '
                 <table width="100%" border="0" cellspacing="0" cellpadding="2" style="font-size:10px;">
                    <tr>
                        <td align="center" colspan="7"><b><u>PACKING LIST</u></b> <br> &nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" width="8%">Tanggal</td>
                        <td align="" width="1%">:</td>
                        <td align="left" width="10%">' . $this->m_fungsi->tanggal_format_indonesia($data_header->tgl) . '</td>
                        <td align="center" width="10%"></td>
                        <td align="left" width="8%">Kepada</td>
                        <td align="" width="1%">:</td>
                        <td align="left" width="20%">' . $data_header->nm_perusahaan . '</td>
                    </tr>
                    <tr>
                        <td align="left" width="8%">No Surat Jalan</td>
                        <td align="" width="1%">:</td>
                        <td align="left" width="10%">' . $data_header->no_surat . '</td>
                        <td align="center" width="10%"></td>
                        <td align="left" width="8%">Alamat</td>
                        <td align="" width="1%">:</td>
                        <td align="left" width="20%">' . $data_header->alamat_perusahaan . '</td>
                    </tr>
                    <tr>
                        <td align="left" width="8%">No SO</td>
                        <td align="" width="1%">:</td>
                        <td align="left" width="10%">' . $data_header->no_so . '</td>
                        <td align="center" width="10%"></td>
                        <td align="left" width="8%">ATTN</td>
                        <td align="" width="1%">:</td>
                        <td align="left" width="20%">' . $data_header->nama . '</td>
                    </tr>
                    <tr>
                        <td align="left" width="8%">No PKB</td>
                        <td align="" width="1%">:</td>
                        <td align="left" width="10%">' . $data_header->no_pkb . '</td>
                        <td align="center" width="10%"></td>
                        <td align="left" width="8%">No Telp / No HP</td>
                        <td align="" width="1%">:</td>
                        <td align="left" width="20%">' . $data_header->no_telp . '</td>
                    </tr>
                    <tr>
                        <td align="left" width="8%">No Kendaraan</td>
                        <td align="" width="1%">:</td>
                        <td align="left" width="10%">' . $data_header->no_kendaraan . '</td>
                        <td align="center" width="10%"></td>
                        <td align="left" width="8%">No PO</td>
                        <td align="" width="1%">:</td>
                        <td align="left" width="20%">' . $data_header->no_po . '</td>
                    </tr>
                    
                    <tr>
                  </table>
                  <br>
                <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size:11px;" >
                    <tr>
                        <td width="" align="center">No</td>
                        <td width="" align="center" colspan="2">Nomer Roll</td>
                        <td width="17%" align="center">Gramage (GSM)</td>
                        <td width="" align="center">Lebar (CM)</td>
                        <td width="" align="center">Berat (KG)</td>
                        <td width="" align="center">JOINT</td>
                        <td width="" align="center">KETERANGAN</td>
                    </tr>';
		$no = 1;
		$tot_weigth = 0;
		foreach ($data_detail->result() as $r) {
			$html .= '<tr>
                                    <td width="" align="center">' . $no . '</td>
                                    <td width="" align="center">' . substr($r->roll, 0, 5) . '</td>
                                    <td width="" align="center">' . substr($r->roll, 6, 15) . '</td>
                                    <td width="" align="center">' . $r->g_label . '</td>
                                    <td width="" align="center">' . round($r->width, 2) . '</td>
                                    <td width="" align="center">' . $r->weight . '</td>
                                    <td width="" align="center">' . $r->joint . '</td>
                                    <td width="" align="center"></td>
                                </tr>';
			$no++;
			$tot_weigth += $r->weight;
		}

		$tmpl = strlen($data_detail->row('width'));
		// <td width="" colspan="4" align="center"><b>'.($no-1).' ROLL (@ LB '.number_format( $data_detail->row('width')).' )</b></td>
		$html .= '
                    <tr>
                        <td width="" colspan="4" align="center"><b>' . ($no - 1) . ' ROLL (@ LB ' . round($data_detail->row('width'), 2) . ' )</b></td>
                        <td width=""  align="center"><b>Total</b></td>
                        <td width=""  align="center"><b>' . number_format($tot_weigth) . '</b></td>
                        <td width=""  align="center"><b></b></td>
                        <td width=""  align="center"><b></b></td>
                    </tr>
                </table>
                  ';


		$this->m_fungsi->_mpdf('', $html, 10, 10, 10, 'P');
	}

	function print_pl_cb()
	{
		$id = $_GET['id'];

		// $data_header = $this->db->query("SELECT * FROM pl WHERE id = '$id'")->row();
		$data_detail = $this->db->query("SELECT * FROM m_timbangan WHERE id_pl = '$id' ORDER BY roll");

		$width_pl = $this->db->query("SELECT DISTINCT width FROM m_timbangan WHERE id_pl = '$id'")->row();

		$html = '<table cellspacing="0" cellpadding="0" style="font-size:14px;width:100%;font-weight:bold;text-align:center;border-collapse:collapse" >
				<tr>
					<tr>
						<td style="border:0">DATA ROLL WP ' . round($width_pl->width) . '</td>
					</tr>
				</tr>
			</table>';

		$html .= '<table cellspacing="0" cellpadding="5" style="font-size:11px;width:100%;text-align:center;border-collapse:collapse" >
						<tr>
							<th style="padding:5px 0;width:6%"></th>
							<th style="padding:5px 0;width:10%"></th>
							<th style="padding:5px 0;width:10%"></th>
							<th style="padding:5px 0;width:15%"></th>
							<th style="padding:5px 0;width:10%"></th>
							<th style="padding:5px 0;width:10%"></th>
							<th style="padding:5px 0;width:10%"></th>
							<th style="padding:5px 0;width:6%"></th>
							<th style="padding:5px 0;width:29%"></th>
						</tr>';

		$html .= '<tr>
					<td style="border:1px solid #000">No</td>
					<td style="border:1px solid #000" colspan="2">Nomer Roll</td>
					<td style="border:1px solid #000">Gramage (GSM)</td>
					<td style="border:1px solid #000">Lebar (CM)</td>
					<td style="border:1px solid #000">Diameter</td>
					<td style="border:1px solid #000">Berat (KG)</td>
					<td style="border:1px solid #000">JOINT</td>
					<td style="border:1px solid #000">KETERANGAN</td>
				</tr>';


		$no = 1;
		$tot_weigth = 0;
		foreach ($data_detail->result() as $r) {
			$html .= '<tr>
								<td style="border:1px solid #000">' . $no . '</td>
								<td style="border:1px solid #000">' . substr($r->roll, 0, 5) . '</td>
								<td style="border:1px solid #000">' . substr($r->roll, 6, 15) . '</td>
								<td style="border:1px solid #000">' . $r->g_label . '</td>
								<td style="border:1px solid #000">' . round($r->width) . '</td>
								<td style="border:1px solid #000">' . $r->diameter . '</td>
								<td style="border:1px solid #000">' . $r->weight . '</td>
								<td style="border:1px solid #000">' . $r->joint . '</td>
								<td style="border:1px solid #000">' . $r->ket . '</td>
							</tr>';
			$no++;
			$tot_weigth += $r->weight;
		}

		//                     $tmpl = strlen($data_detail->row('width'));
		// // <td width="" colspan="4" align="center"><b>'.($no-1).' ROLL (@ LB '.number_format( $data_detail->row('width')).' )</b></td>
		//                     $html .='
		//                     <tr>
		//                         <td width="" colspan="4" align="center"><b>'.($no-1).' ROLL</b></td>
		//                         <td width=""  align="center"><b>Total</b></td>
		//                         <td width=""  align="center"><b>'.number_format($tot_weigth).'</b></td>
		//                         <td width=""  align="center"><b></b></td>
		//                         <td width=""  align="center"><b></b></td>
		//                     </tr>
		//                 </table>
		//                   ';
		$html .= '</table>';


		$this->m_fungsi->_mpdf('', $html, 10, 10, 10, 'P');
	}

	function load_pl(){
		$tglpl = $_POST['tglpl'];
		$pbtnrencana = $_POST['pilihbtnrencana'];
		$otorisasi = $_POST['otorisasi'];
		$html = '';

		$getData = $this->db->query("SELECT * FROM pl
		WHERE (qc='ok' OR qc='proses') AND tgl_pl='$tglpl'
		-- GROUP BY id_perusahaan,tgl_pl,opl,id_rk
		GROUP BY opl
		");
		
		if($getData->num_rows() == 0){
			$html .='<div style="color:#000;padding-top:10px">DATA TIDAK DITEMUKAN</div>';
		}else{
			$i = 0;
			foreach($getData->result() as $r){
				$i++;
				if($r->nama != '-' && $r->nm_perusahaan == '-'){
					$nama = $r->nama;
				}else if($r->nama == '-' && $r->nm_perusahaan != '-'){
					$nama = $r->nm_perusahaan;
				}else if($r->nama != '-' && $r->nm_perusahaan != '-'){
					$nama = $r->nama.' - '.$r->nm_perusahaan;
				}else{
					$nama = '';
				}

				// KALAU RENCANA KIRIM BELUM OK MASIH BISA DIHAPUS
				$edit = '<button onclick="editPL('."'".$r->id_perusahaan."'".','."'".$r->tgl_pl."'".','."'".$r->opl."'".','."'".$i."'".')">EDIT</button>';
				$hapus = '<button onclick="hapusPL('."'".$r->id_perusahaan."'".','."'".$r->id_rk."'".','."'".$r->tgl_pl."'".','."'".$r->opl."'".','."'".$i."'".')">HAPUS</button>';
				if($otorisasi == 'all' || $otorisasi == 'admin'){
					$getrk = $this->db->query("SELECT*FROM m_rencana_kirim WHERE qc_rk='ok' AND id_rk='$r->id_rk' AND tgl='$r->tgl_pl' AND order_pl='$r->opl'");
					if($getrk->num_rows() == 0){
						$aksi = $edit.' '.$hapus;
					}else{
						$aksi = $edit;
					}
				}else{
					$aksi = '';
				}

				$html .='<table style="font-size:12px;color:#000">';
				$html .='<tr>
					<td style="padding:5px 0">
						<button onclick="btnRencana('."'".$r->id_rk."'".','."'".$r->opl."'".','."'".$r->tgl_pl."'".','."'".$pbtnrencana."'".','."'".$i."'".')">'.strtoupper($r->qc).'</button>
						'.$aksi.'
					</td>
					<td style="padding:5px">'.$i.'</td>
					<td style="padding:5px">'.$nama.'</td>
				</tr>';
				$html .='</table>'; //

				$html .='<div class="id-cek t-plist-proses-pl-'.$i.'"></div>';
				$html .='<div class="id-cek t-plist-rencana-'.$i.'"></div>';
				$html .='<div class="id-cek t-plist-input-sementara-'.$i.'"></div>';
				$html .='<div class="id-cek t-plist-hasil-input-'.$i.'"></div>';
				$html .='<div class="id-cek t-plist-input-'.$i.'"></div>';
			}
		}

		echo $html;
	}

	function hapusPL(){
		$result = $this->m_master->hapusPL();
		echo json_encode(array(
			'res' => $result,
			'msg' => 'BERHASIL HAPUS PACKING LIST!'
		));
	}

	function editPL(){
		$idpt = $_POST['idpt'];
		$tglpl = $_POST['tglpl'];
		$opl = $_POST['opl'];
		$i = $_POST['i'];
		
		$getIdCust = $this->db->query("SELECT * FROM pl
		-- WHERE qc='proses' AND tgl_pl='$tglpl' AND id_perusahaan='$idpt' AND opl='$opl'
		WHERE (qc='proses' OR qc='ok') AND tgl_pl='$tglpl' AND id_perusahaan='$idpt' AND opl='$opl'
		GROUP BY id_perusahaan,tgl_pl,id_rk,opl")->row();
		if($getIdCust->id_rk == null){
			$idrk = '';
		}else{
			$idrk = $getIdCust->id_rk;
		}
		
		// NOPOL
		$getNopol = $this->db->query("SELECT ex.plat,ex.supir,p.* FROM pl p
		INNER JOIN m_expedisi ex ON p.id_expedisi=ex.id
		WHERE (qc='proses' OR qc='ok') AND tgl_pl='$tglpl' AND id_perusahaan='$idpt' AND opl='$opl'
		GROUP BY id_perusahaan,tgl_pl,id_rk,opl");
		if($getNopol->num_rows() == 0){
			$nopol = '';
		}else{
			$nopol = $getNopol->row()->plat.' - '.$getNopol->row()->supir;
		}

		echo json_encode(array(
			'cust' => $getIdCust->id_perusahaan,
			'fnmpt' => $getIdCust->nm_perusahaan,
			'fnama' => $getIdCust->nama,
			'falamat' => $getIdCust->alamat_perusahaan,
			'ftelp' => $getIdCust->no_telp,
			'ftglrk' => $getIdCust->tgl_pl,
			'ftgl' => $getIdCust->tgl,
			'opl' => $getIdCust->opl,
			'fidrk' => $idrk,
			'fidexpd' => $nopol,
		));
	}

	function showEditPl(){
		$idpt = $_POST['idpt'];
		$tglpl = $_POST['tglpl'];
		$opl = $_POST['opl'];
		$i = $_POST['i'];
		$html = '';

		$getData = $this->db->query("SELECT*FROM pl
		-- WHERE qc='proses' AND tgl_pl='$tglpl' AND id_perusahaan='$idpt' AND opl='$opl'
		WHERE (qc='proses' OR qc='ok') AND tgl_pl='$tglpl' AND id_perusahaan='$idpt' AND opl='$opl'
		ORDER BY id_rk,opl,nm_ker,no_po,g_label");
		if($getData->row()->nama == '-' || $getData->row()->nama == ''){
			$nama = '';
		}else{
			$nama = $getData->row()->nama.' - ';
		}
		if($getData->row()->nm_perusahaan == '-' || $getData->row()->nm_perusahaan == ''){
			$pt = '';
		}else{
			$pt = $getData->row()->nm_perusahaan;
		}
		$html .='<div style="margin-top:15px;font-weight:bold;color:#000">'.$nama.$pt.'</div>';
		$html .='<table style="font-size:12px;color:#000;text-align:center;margin-top:15px" border="1">';
		$html .='<tr>
			<td style="padding:5px;font-weight:bold;background:#e9e9e9">NO.</td>
			<td style="padding:5px;font-weight:bold;background:#e9e9e9">TANGGAL</td>
			<td style="padding:5px;font-weight:bold;background:#e9e9e9">NO. SURAT</td>
			<td style="padding:5px;font-weight:bold;background:#e9e9e9">NO. SO</td>
			<td style="padding:5px;font-weight:bold;background:#e9e9e9">NO. PKB</td>
			<td style="padding:5px;font-weight:bold;background:#e9e9e9">NO. PO</td>
			<td style="padding:5px;font-weight:bold;background:#e9e9e9">JENIS</td>
			<td style="padding:5px;font-weight:bold;background:#e9e9e9">GSM</td>
			<td style="padding:5px;font-weight:bold;background:#e9e9e9">AKSI</td>
		</tr>';
		$ii = 0;
		foreach($getData->result() as $r){
			$ii++;
			$html .='<tr>
				<td style="padding:5px">'.$ii.'</td>
				<td style="padding:5px">'.$r->tgl.'</td>
				<td style="padding:5px">'.trim($r->no_surat).'</td>
				<td style="padding:5px">'.$r->no_so.'</td>
				<td style="padding:5px">'.$r->no_pkb.'</td>
				<td style="padding:5px">'.$r->no_po.'</td>
				<td style="padding:5px">'.$r->nm_ker.'</td>
				<td style="padding:5px">'.$r->g_label.'</td>';
			// JIKA CUMA ADA 1 PL GAK BISA HAPUS
			if($getData->num_rows() == 1){
				$aksi = '-';
			}else{
				// JIKA SUDAH OK TIDAK BISA HAPUS PL
				if($r->qc == 'ok'){
					$aksi = '-';
				}else{
					$aksi = '<button onclick="showEditPlHapus('."'".$idpt."'".','."'".$tglpl."'".','."'".$opl."'".','."'".$i."'".','."'".$r->id_rk."'".','."'".$r->nm_ker."'".','."'".$r->g_label."'".','."'".$r->id."'".')">Hapus</button>';
				}
			}
			$html .='<td style="padding:5px">'.$aksi.'</td></tr>';
		}
		$html .='</table>';

		echo $html;
	}

	function showEditPlHapus(){
		$idpt = $_POST['idpt'];
		$id_rk = $_POST['id_rk'];
		$tglpl = $_POST['tglpl'];
		$opl = $_POST['opl'];
		// CEK JIKA SUDAH OK
		$getData = $this->db->query("SELECT*FROM pl WHERE qc='ok' AND id_rk='$id_rk' AND tgl_pl='$tglpl' AND id_perusahaan='$idpt' AND opl='$opl' GROUP BY id_rk");
		if($getData->num_rows() > 0){
			echo json_encode(array('res' => true, 'msg' => 'BATALKAN PACKING LIST! SUDAH OK!', 'info' => 'error'));
		}else{
			// BATAL KAN CEK OK DI RENCANA KIRIM KEMBALIKAN KE PROSES
			$getRk = $this->db->query("SELECT*FROM m_rencana_kirim WHERE qc_rk='ok' AND id_rk='$id_rk' GROUP BY id_rk");
			if($getRk->num_rows() > 0){
				echo json_encode(array('res' => true, 'msg' => 'BATALKAN RENCANA KIRIM! SUDAH OK!', 'info' => 'error'));
			}else{
				$result = $this->m_master->showEditPlHapus();
				echo json_encode(array('res' => true, 'msg' => 'BERHASIL!', 'info' => 'success'));
			}
		}
	}

	function addPlNopol(){
		$result = $this->m_master->addPlNopol();
		echo json_encode(array(
			'res' => $result,
			'msg' => 'BERHASIL TAMBAH NOPOL!',
			'info' => 'success',
		));
	}

	function cek_no_sj(){
		$html = '';
		if($_POST['tgl'] == '' || $_POST['id'] == '' || $_POST['pjk'] == ''){
			$jenis = '';
			$fyear = '';
			$syear = '';
			$kpjk = '';
		}else{
			$jns = explode("_ex_", $_POST['id']);
			$jenis = $jns[2];
			$fyear = substr($_POST['tgl'], 0, 4);
			$syear = substr($_POST['tgl'], 2, 2);
			$pjk = $_POST['pjk'];
			if($pjk == 'ppn'){
				$kpjk = 'A';
			}else if($pjk == 'non'){
				$kpjk = 'B';
			}else{
				$kpjk = '';
			}
		}

		if($jenis == 'MH COLOR'){
			$tJenis = 'MC';
		}else if($jenis == 'MN'){
			$tJenis = 'MH';
		}else{
			$tJenis = $jenis;
		}

		// COR
		// 86_ex_PPI/FG/01/02/23_ex_MH_ex_ppn_ex_210
		$jnsCor = explode("_ex_", $_POST['id']);
		if($jnsCor[4] == 210){
			$whereNoSj = $syear."/".$kpjk."/C".$tJenis;
			$whereCor = "AND id_perusahaan='210'";
		}else{
			$whereNoSj = $syear."/".$kpjk."/".$tJenis;
			$whereCor = "AND id_perusahaan!='210'";
		}
		
		// PACKING LIST OK
		$getData = $this->db->query("SELECT p.tgl,no_surat,nama,nm_perusahaan,qc FROM pl p
		INNER JOIN m_timbangan t ON p.id=t.id_pl
		WHERE p.tgl LIKE '%$fyear%' AND no_surat LIKE '%$whereNoSj%' AND qc='ok' $whereCor
		GROUP BY p.tgl DESC,no_pkb DESC,qc LIMIT 10");
		if($_POST['tgl'] == '' || $_POST['id'] == '' || $_POST['pjk'] == '' || $getData->num_rows() == 0){
			$html .= '';
		}else{
			$html .='<table style="color:#000;font-size:12px;text-align:center;margin-top:15px" border="1">';
			$html .='<tr>
				<td style="padding:5px;font-weight:bold;background:#e9e9e9" colspan="4">10 KIRIMAN TERAKHIR</td>
			</tr>';
			$i = 0;
			foreach($getData->result() as $r){
				$i++;
				if($r->nama == '-' || $r->nama == ''){
					$nama = '';
				}else{
					$nama = $r->nama.' - ';
				}
				if($r->nm_perusahaan == '-' || $r->nm_perusahaan == ''){
					$nmpt = '';
				}else{
					$nmpt = $r->nm_perusahaan;
				}

				$html .= '<tr>
					<td style="padding:5px">'.$i.'</td>
					<td style="padding:5px">'.$r->tgl.'</td>
					<td style="padding:5px">'.trim($r->no_surat).'</td>
					<td style="padding:5px;text-align:left">'.$nama.$nmpt.'</td>
				</tr>';
			}
			$html .='</table>';
		}

		// PACKING LIST PROSES
		$getData = $this->db->query("SELECT tgl,no_surat,nama,nm_perusahaan,qc FROM pl
		WHERE tgl LIKE '%$fyear%' AND no_surat LIKE '%$whereNoSj%' AND qc='proses' $whereCor
		GROUP BY tgl DESC,no_pkb DESC,qc");
		if($_POST['tgl'] == '' || $_POST['id'] == '' || $_POST['pjk'] == '' || $getData->num_rows() == 0){
			$html .= '';
		}else{
			$html .='<table style="color:#000;font-size:12px;text-align:center;margin-top:15px" border="1">';
			$html .='<tr>
				<td style="padding:5px;font-weight:bold;background:#e9e9e9" colspan="4">PACKING LIST PROSES</td>
			</tr>';
			$i = 0;
			foreach($getData->result() as $r){
				$i++;
				if($r->nama == '-' || $r->nama == ''){
					$nama = '';
				}else{
					$nama = $r->nama.' - ';
				}
				if($r->nm_perusahaan == '-' || $r->nm_perusahaan == ''){
					$nmpt = '';
				}else{
					$nmpt = $r->nm_perusahaan;
				}

				$html .= '<tr>
					<td style="padding:5px">'.$i.'</td>
					<td style="padding:5px">'.$r->tgl.'</td>
					<td style="padding:5px">'.trim($r->no_surat).'</td>
					<td style="padding:5px;text-align:left">'.$nama.$nmpt.'</td>
				</tr>';
			}
			$html .='</table>';
		}

		echo $html;
	}

	function loadNmKerSj(){
		// 16_ex_001/PPI/XII/2022_ex_MN_ex_non_ex_38
		$id = explode("_ex_", $_POST['id']);
		if($id[2] == 'MH COLOR'){
			$tKer = 'MC';
		}else if($id[2] == 'MN'){
			$tKer = 'MH';
		}else{
			$tKer = $id[2];
		}
		
		// COR
		if($id[4] == 210){
			$nmKer = 'C'.$tKer;
		}else{
			$nmKer = $tKer;
		}
		echo json_encode(array('nm_ker' => $nmKer));
	}

	function addCartPl(){
		$year = substr($_POST['ftgl'], 0, 4);
		$noSJ = explode("/", trim($_POST['noSJ']));
		$no = $noSJ[0];
		$thn = $noSJ[3];
		$pjk = $noSJ[4];
		$jns = $noSJ[5];
		$expfnopo = explode("_ex_", $_POST['fnopo']);
		$expfjenis = explode("_ex_", $_POST['fjenis']);
		$data = array(
			'id' => $_POST['fnopkb'].'_'.$_POST['ftahunpkb'].''.$_POST['fjnspkb'],
			'name' => $_POST['fnopkb'].'_'.$_POST['ftahunpkb'].''.$_POST['fjnspkb'],
			'price' => 0,
			'qty' => 1,
			'options' => array(
				'tgl_pl' => $_POST['ftglrk'],
				'tgl' => $_POST['ftgl'],
				'no_surat' => $_POST['noSJ'],
				'no_so' => $_POST['noSOSJ'],
				'no_pkb' => $_POST['noPKB'],
				'no_kendaraan' => '-',
				'nm_perusahaan' => $_POST['fnmpt'],
				'id_perusahaan' => $_POST['fkepada'],
				'alamat_perusahaan' => $_POST['falamat'],
				'nama' => $_POST['fnama'],
				'no_telp' => $_POST['ftelp'],
				'no_po' => $expfnopo[1],
				'nm_ker' => $expfjenis[2],
				'g_label' => $_POST['fplhplgsm'],
			),
		);

		$getnoSJ = $this->db->query("SELECT p.tgl,no_surat,no_so,no_pkb,qc FROM pl p
		INNER JOIN m_timbangan t ON p.id=t.id_pl
		WHERE p.tgl LIKE '%$year%' AND no_surat LIKE '%$no%' AND no_surat LIKE '%$thn/$pjk/$jns%' AND qc='ok'
		GROUP BY p.tgl,no_surat,no_so,no_pkb");
		$getnoSJproses = $this->db->query("SELECT tgl,no_surat,no_so,no_pkb,qc FROM pl
		WHERE tgl LIKE '%$year%' AND no_surat LIKE '%$no%' AND no_surat LIKE '%$thn/$pjk/$jns%' AND qc='proses'
		GROUP BY tgl,no_surat,no_so,no_pkb");

		if($_POST['fnopo'] == '' || $_POST['fjenis'] == '' || $_POST['fplhplgsm'] == '' || $_POST['fnopo'] == null || $_POST['fjenis'] == null || $_POST['fplhplgsm'] == null){
			echo json_encode(array('data' => 'cart', 'opsi' => false, 'msg' => 'LENGKAPI NO PO / JENIS / GRAMATURE!'));
		}else{
			if($_POST['pilihan'] == 'cart' && $_POST['pl'] == 'simpan'){
				// CEK NOMER SURAT JALAN SUDAH TERPAKAI ATAU BELUM = PACKING LIST OK
				if($getnoSJ->num_rows() == 0){
					// CEK NOMER SURAT JALAN SUDAH TERPAKAI ATAU BELUM = PACKING LIST PROSES
					if($getnoSJproses->num_rows() == 0){
						$this->cart->insert($data);
						echo json_encode(array('data' => 'cart', 'opsi' => true, 'msg' => 'BERHASIL DITAMBAHKAN!'));
					}else{
						echo json_encode(array('data' => 'cart', 'opsi' => false, 'msg' => 'NOMER SURAT JALAN SUDAH TERPAKAI!'));
					}
				}else{
					echo json_encode(array('data' => 'cart', 'opsi' => false, 'msg' => 'NOMER SURAT JALAN SUDAH TERPAKAI!'));
				}
			}else if($_POST['pilihan'] == 'cart' && $_POST['pl'] == 'edit'){
				// CEK PACKING LIST EDIT JIKA NO.SJ - JENIS - GSM SAMA GAGAL
				$no_po = $expfnopo[1];
				$nmker = $expfjenis[2];
				$gsm = $_POST['fplhplgsm'];
				$cekpllain = $this->db->query("SELECT * FROM pl WHERE no_surat LIKE '%$no%' AND no_surat LIKE '%$thn/$pjk/$jns%' AND qc='proses'
				GROUP BY id_perusahaan");
				$cekplini = $this->db->query("SELECT * FROM pl WHERE no_surat LIKE '%$no%' AND no_surat LIKE '%$thn/$pjk/$jns%' AND qc='proses'
				AND no_po='$no_po' AND nm_ker='$nmker' AND g_label='$gsm'
				GROUP BY id_perusahaan");
				if($cekpllain->num_rows() == 0){
					if($getnoSJ->num_rows() == 0){ // CEK SJ OK
						$this->cart->insert($data);
						echo json_encode(array('data' => 'cart', 'opsi' => true, 'msg' => 'BERHASIL DITAMBAHKAN!'));
					}else{
						echo json_encode(array('data' => 'cart', 'opsi' => false, 'msg' => 'NOMER SURAT JALAN SUDAH TERPAKAI!'));
					}
				}else{
					// CEK JIKA CUST SAMA DAN OPL SAMA
					if($_POST['fnmpt'] == $cekpllain->row()->nm_perusahaan && $_POST['fnama'] == $cekpllain->row()->nama && $_POST['opl'] == $cekpllain->row()->opl){
						if($cekplini->num_rows() == 0){
							if($getnoSJ->num_rows() == 0){ // CEK SJ OK
								$this->cart->insert($data);
								echo json_encode(array('data' => 'cart', 'opsi' => true, 'msg' => 'BERHASIL DITAMBAHKAN!'));
							}else{
								echo json_encode(array('data' => 'cart', 'opsi' => false, 'msg' => 'NOMER SURAT JALAN SUDAH TERPAKAI!'));
							}
						}else{
							echo json_encode(array('data' => 'cart', 'opsi' => false, 'msg' => 'PACKING LIST SUDAH ADA!'));
						}
					}else{
						echo json_encode(array('data' => 'cart', 'opsi' => false, 'msg' => 'NOMER SURAT JALAN SUDAH TERPAKAI!'));
					}
				}
			}else{ // simpan
				if($getnoSJ->num_rows() == 0){
					$this->m_master->simpanCartPl();
					echo json_encode(array('data' => 'simpan', 'opsi' => true, 'msg' => 'BERHASIL SIMPAN PL!'));
				}else{
					echo json_encode(array('data' => 'simpan', 'opsi' => false, 'msg' => 'NOMER SURAT JALAN SUDAH TERPAKAI!'));
				}
			}
		}		
	}

	function showCartPl(){
		$html ='';
		if($this->cart->total_items() != 0){
			$html .='<table style="margin-top:15px;color:#000;font-size:12px;text-align:center;border-color:#aaa" border="1">';
			$html .='<tr>
				<td style="padding:5px;font-weight:bold;background:#e9e9e9">NO.</td>
				<td style="padding:5px;font-weight:bold;background:#e9e9e9">TANGGAL</td>
				<td style="padding:5px;font-weight:bold;background:#e9e9e9">NO. SJ</td>
				<td style="padding:5px;font-weight:bold;background:#e9e9e9">NO. SO</td>
				<td style="padding:5px;font-weight:bold;background:#e9e9e9">NO. PO</td>
				<td style="padding:5px;font-weight:bold;background:#e9e9e9">JENIS</td>
				<td style="padding:5px;font-weight:bold;background:#e9e9e9">GRAMATURE</td>
				<td style="padding:5px;font-weight:bold;background:#e9e9e9">AKSI</td>
			</tr>';
		}

		$i = 0;
		foreach($this->cart->contents() as $items){
			$i++;
			$html .='<tr>
				<td style="padding:5px">'.$i.'</td>
				<td style="padding:5px">'.$items['options']['tgl'].'</td>
				<td style="padding:5px">'.$items['options']['no_surat'].'</td>
				<td style="padding:5px">'.$items['options']['no_so'].'</td>
				<td style="padding:5px">'.$items['options']['no_po'].'</td>
				<td style="padding:5px">'.$items['options']['nm_ker'].'</td>
				<td style="padding:5px">'.$items['options']['g_label'].'</td>
				<td style="padding:5px"><button onclick="hapusCartPl('."'".$items['rowid']."'".')">Batal</button></td>
			</tr>';
		}

		if($this->cart->total_items() != 0){
			$html .='<tr>
				<td style="padding:5px;text-align:right" colspan="8"><button onclick="addCartPl('."'simpan'".')">SIMPAN</button></td>
			</tr>';
			$html .='</table>';
		}

		echo $html;
	}

	function hapusCartPl(){
		$data = array(
			'rowid' => $_POST['rowid'], 
			'qty' => 0,
		);
		$this->cart->update($data);
	}

	function dessCartPl() {
		$this->cart->destroy();
	}

	function addCartRk(){
		// 7_ex_2023-02-04_ex_PPI/FG/01/02/23_ex_MH+COLOR_ex_125_ex_110.00_ex_210
		$exp = explode("_ex_", $_POST['rkukuran']);
		if($exp[3] == 'MH COLOR'){
			$tnmKer = 'MHC';
		}else{
			$tnmKer = $exp[3];
		}
		$tgl = $exp[1];
		$nm_ker = $exp[3];
		$g_label = $exp[4];
		$width = $exp[5];
		$jml_roll = $_POST['rkjmlroll'];
		$order_pl = $exp[0];

		$data = array(
			'id' => $tnmKer.$g_label.'_'.$width.$order_pl,
			'name' => $tnmKer.$g_label.'_'.$width.$order_pl,
			'price' => 0,
			'qty' => 1,
			'options' => array(
				'tgl' => $tgl,
				'nm_ker' => $nm_ker,
				'g_label' => $g_label,
				'width' => $width,
				'jml_roll' => $jml_roll,
				'order_pl' => $order_pl,
			),
		);

		$this->cart->insert($data);		
	}

	function showCartRk(){
		$html ='';

		if($this->cart->total_items() != 0){
			$html .='<table style="margin-top:15px;color:#000;font-size:12px;text-align:center;border-color:#aaa" border="1">';
			$html .='<tr style="background:#e9e9e9">
				<td style="padding:5px;font-weight:bold">TANGGAL</td>
				<td style="padding:5px;font-weight:bold">JENIS</td>
				<td style="padding:5px;font-weight:bold">GRAMATURE</td>
				<td style="padding:5px;font-weight:bold">UKURAN</td>
				<td style="padding:5px;font-weight:bold">JUMLAH</td>
				<td style="padding:5px;font-weight:bold">AKSI</td>
			</tr>';
		}

		foreach($this->cart->contents() as $items){
			$html .='<tr>
				<td style="padding:5px">'.$items['options']['tgl'].'</td>
				<td style="padding:5px">'.$items['options']['nm_ker'].'</td>
				<td style="padding:5px">'.$items['options']['g_label'].'</td>
				<td style="padding:5px">'.round($items['options']['width'], 2).'</td>
				<td style="padding:5px">'.$items['options']['jml_roll'].'</td>
				<td style="padding:5px"><button onclick="hapusCartRk('."'".$items['rowid']."'".')">Batal</button></td>
			</tr>';
		}

		if($this->cart->total_items() != 0){
			$html .='<tr>
					<td style="padding:5px;text-align:right" colspan="6"><button onclick="simpanCartRk()">SIMPAN</button></td>
				</tr>
			</table>';
		}

		echo $html;
	}

	function simpanCartRk(){
		$this->m_master->simpanCartRk();
		echo json_encode(array('data' => true, 'msg' => 'BERHASIL SIMPAN RENCANA KIRIM!'));
	}

	function hapusCartRk(){
		$data = array(
			'rowid' => $_POST['rowid'], 
			'qty' => 0,
		);
		$this->cart->update($data);
	}

	function dessCartRk() {
		$this->cart->destroy();
	}

	function pList(){
		$tgl = $_POST['tgl'];
		$pbtnrencana = $_POST['pilihbtnrencana'];
		$otorisasi = $_POST['otorisasi'];
		$html ='';

		if($otorisasi == 'cor'){
			$whereCor = "AND p.id_perusahaan='210'";
		}else{
			$whereCor = "";
		}

		$getCust = $this->db->query("SELECT r.id_rk AS idrk,r.qc_rk,p.* FROM pl p
		INNER JOIN m_rencana_kirim r ON p.tgl_pl=r.tgl AND p.opl=r.order_pl $whereCor
		WHERE (qc='proses' OR qc='ok') AND tgl_pl='$tgl'
		GROUP BY opl");
		if($getCust->num_rows() == 0){
			$html .='<div class="notfon">DATA TIDAK DITEMUKAN</div>';
		}else{
			$i = 0;
			foreach($getCust->result() as $cust){
				$i++;
				if($cust->nama != '-' && $cust->nm_perusahaan == '-'){
					$nama = $cust->nama;
				}else if($cust->nama == '-' && $cust->nm_perusahaan != '-'){
					$nama = $cust->nm_perusahaan;
				}else if($cust->nama != '-' && $cust->nm_perusahaan != '-'){
					$nama = $cust->nama.' - '.$cust->nm_perusahaan;
				}else{
					$nama = '';
				}

				// JIKA MASIH RENCANA KIRIM MASIH BISA DIHAPUS TAPI ROLL YANG ADA DI RENCANA KIRIM JUGA HILANG
				$edit = '<button onclick="btnRencanaEdit('."'".$cust->idrk."'".','."'".$cust->opl."'".','."'".$cust->tgl_pl."'".','."'".$i."'".')">EDIT</button>';
				$hapus = '<button onclick="btnRencanaHapus('."'".$cust->idrk."'".','."'".$cust->opl."'".','."'".$cust->tgl_pl."'".','."'".$i."'".')">HAPUS</button>';
				if($cust->qc_rk == 'proses' && $otorisasi == 'fg'){
					$aksi = $edit;
				}else if($cust->qc_rk == 'proses' && ($otorisasi == 'all' || $otorisasi == 'admin')){
					$aksi = $edit.' '.$hapus;
				}else if($cust->qc_rk == 'ok' && ($otorisasi == 'all' || $otorisasi == 'admin')){
					$aksi = $edit;
				}else{
					$aksi = '';
				}

				if($cust->qc == 'ok'){
					$btnRenc = 'VIEW';
				}else{
					$btnRenc = 'PROSES';
				}
				$html .='<table class="list-table">
					<tr>
						<td style="padding:5px 0;text-align:center">
							<button onclick="btnRencana('."'".$cust->idrk."'".','."'".$cust->opl."'".','."'".$cust->tgl_pl."'".','."'".$pbtnrencana."'".','."'".$i."'".')">'.$btnRenc.'</button>
							'.$aksi.'
						</td>
						<td style="padding:5px;text-align:center">'.$i.'</td>
						<td style="padding:5px">'.$nama.'</td>
					</tr>
				</table>';

				// SEMUA TAMPIL DISINII
				$html .='<div class="id-cek t-plist-rencana-'.$i.'"></div>';
				$html .='<div class="id-cek t-plist-input-sementara-'.$i.'"></div>';
				$html .='<div class="id-cek t-plist-hasil-input-'.$i.'"></div>';
				$html .='<div class="id-cek t-plist-input-'.$i.'"></div>';
			}
		}
		echo $html;
	}

	function btnRencanaEdit(){
		$id_rk = $_POST['id_rk'];
		$opl = $_POST['opl'];
		$tgl_pl = $_POST['tgl_pl'];

		$data = $this->db->query("SELECT*FROM m_rencana_kirim
		WHERE tgl='$tgl_pl' AND id_rk='$id_rk' AND order_pl='$opl'
		GROUP BY tgl,id_rk,order_pl")->row();
		echo json_encode(array(
			'id' => $data->order_pl.'_ex_'.$data->tgl,
			'tgl' => $data->tgl,
		));
	}

	function btnRencanaHapus(){
		$result = $this->m_master->btnRencanaHapus();
		echo json_encode(array(
			'res' => $result,
			'msg' => 'RENCANA KIRIM BERHASIL DIHAPUS!',
		));
	}

	function pListInputSementara(){
		$id_rk = $_POST['id_rk'];
		$l = $_POST['i'];
		$plh = $_POST['plh'];
		$otorisasi = $_POST['otorisasi'];
		$html ='';

		$getKer = $this->db->query("SELECT id_rk,nm_ker,g_label,width,COUNT(width) AS jml FROM m_timbangan
		WHERE id_rk='$id_rk'
		GROUP BY nm_ker,g_label,width");

		if($getKer->num_rows() == 0){
			$html .='';
		}else{
			$html .='<div style="overflow:auto;white-space:nowrap;"><table class="list-table" style="width:100%;text-align:center;margin:15px 0" border="1">';
			// PL
			if($plh == 'pl'){
				$wket = '25%';
				$waksi = '10%';
				$cols = '13';
				$ktd = '<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:10%">ID PL</td>';
			}else{
				$wket = '25%';
				$waksi = '20%';
				$cols = '12';
				$ktd = '';
			}
			$html .='<tr>
				<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:4%">NO.</td>
				<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:11%">NO. ROLL</td>
				<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">BW</td>
				<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">RCT</td>
				<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">BI</td>
				<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">D(CM)</td>
				<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">BERAT</td>
				<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">JNT</td>
				<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:'.$wket.'">KET</td>
				<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">SESET</td>
				<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">LABEL</td>
				<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:'.$waksi.'">AKSI</td>
				'.$ktd.'
			</tr>';
			$totRoll = 0;
			$totBerat = 0;
			foreach($getKer->result() as $ker){
				if($ker->nm_ker == 'MH' && $ker->g_label == 110){
					$bgtrt = 'list-p-biru';
				}else if(($ker->nm_ker == 'MH') && ($ker->g_label == 120 || $ker->g_label == 125)){
					$bgtrt = 'list-p-kuning';
				}else if(($ker->nm_ker == 'MH' || $ker->nm_ker == 'MN') && $ker->g_label == 150){
					$bgtrt = 'list-p-merah';
				}else if($ker->nm_ker == 'WP'){
					$bgtrt = 'list-p-hijau';
				}else{
					$bgtrt = 'list-p-putih';
				}

				// GET UKURAN
				$getWidth = $this->db->query("SELECT * FROM m_timbangan
				WHERE id_rk='$ker->id_rk' AND nm_ker='$ker->nm_ker' AND g_label='$ker->g_label' AND width='$ker->width'
				ORDER BY roll");
				$html .='<tr class="'.$bgtrt.'">
					<td style="padding:5px;font-weight:bold;text-align:left" colspan="'.$cols.'">'.$ker->nm_ker.''.$ker->g_label.' - '.round($ker->width,2).'</td>
				</tr>';

				$i = 0;
				foreach($getWidth->result() as $w){
					$i++;
					if($w->status == '3'){
						$bgtr = 'status-buffer';
					}else{
						$bgtr = 'status-stok';
					}

					if($w->nm_ker == 'MH' || $w->nm_ker == 'MN'){
						$bgbw = '';
						$bgrct = '';
						$bgbi = 'background:#eee';
					}else if($w->nm_ker == 'BK'){
						$bgbw = '';
						$bgrct = 'background:#eee';
						$bgbi = '';
					}else if($w->nm_ker == 'WP'){
						$bgbw = '';
						$bgrct = 'background:#eee';
						$bgbi = 'background:#eee';
					}else{
						$bgbw = '';
						$bgrct = 'background:#eee';
						$bgbi = 'background:#eee';
					}

					if($w->seset > 0){
						$ketSeset = '- '.$w->seset.'KG. '.$w->weight.'. '.$w->ket;
					}else{
						$ketSeset = $w->ket;
					}

					// CEK JIKA SUDAH OK
					$cekOk = $this->db->query("SELECT*FROM m_rencana_kirim WHERE id_rk='$id_rk' AND qc_rk='proses' GROUP BY id_rk");

					// REQ PRINT LABEL
					if($w->lbl_rk == 'req'){
						$lds = 'disabled class="btn-req-lbl"';
					}else{
						$lds = '';
					}
					$lblReq = '<button '.$lds.' onclick="reqLabelRk('."'".$w->id."'".','."'".$w->id_rk."'".','."'".$l."'".')">req</button>';
					if($otorisasi == 'all' || $otorisasi == 'admin'){
						$btnLabel = $lblReq;
					}else if($otorisasi == 'fg'){
						if($cekOk->num_rows() > 0){
							$btnLabel = $lblReq;
						}else{
							$btnLabel = '-';
						}
					}else{
						$btnLabel = '-';
					}

					// PILIH OPSI
					$btnEditBatalListRk = '<button onclick="editRollRk('."'".$w->id."'".','."'".$w->diameter."'".','."'".$w->seset."'".','."'".$w->weight."'".','."'".$l."'".')">EDIT</button> <button onclick="batalRollRk('."'".$w->id."'".','."'".$l."'".')">BATAL</button>';
					// CEK JIKA SUDAH DIKONFIRMASI CORRUGATED
					$cekCor = $this->db->query("SELECT*FROM m_timbangan WHERE id='$w->id' AND id_pl='0' AND id_rk='$id_rk' AND cor_at IS NULL AND cor_by IS NULL");
					// JIKA SUDAH MASUK PACKING LIST TIDAK BISA DI EDIT / BATAL
					if($w->status != 0 && $w->id_pl != 0){
						$aksi = '-';
					}else{
						if($otorisasi == 'all' || $otorisasi == 'admin' || $otorisasi == 'fg'){
							if($cekCor->num_rows() == 0){
								$aksi = 'TERKONFIRMASI COR!';
							}else{
								if($plh == 'pl'){
									$aksi = $btnEditBatalListRk;
								}else{
									if($cekOk->num_rows() > 0){
										$aksi = $btnEditBatalListRk;
									}else{
										$aksi = '-';
									}
								}
							}
						}else if($otorisasi == 'cor'){
							// CORRUGATED
							if($cekCor->num_rows() == 0){
								$aksi = '<button onclick="konfirmasiBatalCor('."'".$w->id."'".','."'batal'".','."'".$l."'".')">BATAL KONFIRMASI</button>';
							}else{
								$aksi = '<button onclick="konfirmasiBatalCor('."'".$w->id."'".','."'konfirmasi'".','."'".$l."'".')">KONFIRMASI</button>';
							}
						}else{
							$aksi = '-';
						}
					}

					// JIKA ROLL PERNAH DI EDIT
					$getRollEdit = $this->db->query("SELECT*FROM m_roll_edit WHERE roll='$w->roll'");
					if($getRollEdit->num_rows() == 0){
						$btnEdit = $w->roll;
					}else{
						$btnEdit = '<button class="tmbl-cek-roll" style="color:#00f" onclick="cekRollEdit('."'".$w->id."'".','."'".$w->roll."'".')">'.$w->roll.'</button>';
					}

					// G AC
					if($w->g_ac == 0 || $w->g_ac == ''){
						$txtGac = 0;
					}else{
						$txtGac = $w->g_ac;
					}

					// RCT
					if($w->rct == 0 || $w->rct == ''){
						$txtRct = 0;
					}else{
						$txtRct = $w->rct;
					}

					// BI
					if($w->bi == 0 || $w->bi == ''){
						$txtBi = 0;
					}else{
						$txtBi = $w->bi;
					}

					$html .='<tr class="'.$bgtr.'">
						<td style="padding:5px">'.$i.'</td>
						<td style="padding:5px">'.$btnEdit.'</td>
						<td style="padding:5px;'.$bgbw.'">'.$txtGac.'</td>
						<td style="padding:5px;'.$bgrct.'">'.$txtRct.'</td>
						<td style="padding:5px;'.$bgbi.'">'.$txtBi.'</td>
						<td style="position:relative">
							<input type="text" id="his-diameter-'.$w->id.'" value="'.$w->diameter.'" class="inp-abs" maxlength="3" onkeypress="return hanyaAngka(event)">
						</td>
						<td style="padding:5px">'.number_format($w->weight - $w->seset).'</td>
						<td style="padding:5px">'.$w->joint.'</td>
						<td style="position:relative">
							<textarea disabled class="txt-area-new">'.$ketSeset.'</textarea>
						</td>
						<td style="position:relative">
							<input type="text" id="his-seset-'.$w->id.'" value="'.number_format($w->seset).'" class="inp-abs" maxlength="4" onkeypress="return hanyaAngka(event)">
						</td>
						<td style="padding:5px">'.$btnLabel.'</td>
						<td style="padding:5px">'.$aksi.'</td>';

					// PL
					if($plh == 'pl'){
						$html .='<td style="padding:5px">';
						// ID PL MASIH KOSONG
						if($w->id_pl == 0){
							// CEK RENCANA KIRIM BELUM OK
							$getRk = $this->db->query("SELECT*FROM m_rencana_kirim WHERE id_rk='$id_rk' AND qc_rk='ok' GROUP BY id_rk");
							if($getRk->num_rows() == 0){
								$html .= 'CEK DULU!';
							}else{
								$getPl = $this->db->query("SELECT pl.* FROM pl pl
								INNER JOIN po_master po ON pl.no_po=po.no_po AND pl.nm_ker=po.nm_ker AND pl.g_label=po.g_label
								WHERE id_rk='$w->id_rk' AND pl.nm_ker='$w->nm_ker' AND pl.g_label='$w->g_label' AND po.width='$w->width'
								GROUP BY pl.id,pl.no_po,pl.nm_ker,pl.g_label");
								foreach($getPl->result() as $pl){
									$btnSatuPl = '<div style="display:block">
									<button class="tmbl-cek-roll" onclick="entryPL('."'".$w->id_rk."'".','."'".$pl->opl."'".','."'".$pl->tgl_pl."'".','."'".$plh."'".','."'".$l."'".','."'".$pl->id."'".','."'".$w->id."'".','."'".$w->status."'".')">'.$pl->id.'</button>
									</div>';
									if($pl->id_perusahaan == 210){
										if($cekCor->num_rows() == 0){
											$html .= $btnSatuPl;
										}else{
											$html .= 'KONFIRMASI DULU!';
										}
									}else{
										$html .= $btnSatuPl;
									}
								}
							}
						}else{
							$html .= '-';
						}
						$html .='</td>';
					}else{ // RENCANA KIRIM
						$html .='';
					}
					$html .='</tr>';
					
					$totBerat += $w->weight - $w->seset;
				}

				// TOMBOL ALL IN
				if($plh == 'pl'){
					$getRkA = $this->db->query("SELECT*FROM m_rencana_kirim WHERE id_rk='$id_rk' AND qc_rk='ok' GROUP BY id_rk");
					if($getRkA->num_rows() == 0){
						$html .='';
					}else{
						$getPl = $this->db->query("SELECT pl.* FROM pl pl
						INNER JOIN po_master po ON pl.no_po=po.no_po AND pl.nm_ker=po.nm_ker AND pl.g_label=po.g_label
						WHERE id_rk='$ker->id_rk' AND pl.nm_ker='$ker->nm_ker' AND pl.g_label='$ker->g_label' AND po.width='$ker->width'
						GROUP BY pl.id,pl.no_po,pl.nm_ker,pl.g_label");
						// CEK JIKA SUDAH MASUK DI PACKING LIST
						$getrolldpl = $this->db->query("SELECT id_rk,nm_ker,g_label,width FROM m_timbangan
						WHERE id_rk='$id_rk' AND id_pl='0' AND nm_ker='$ker->nm_ker' AND g_label='$ker->g_label' AND width='$ker->width'
						GROUP BY nm_ker,g_label,width");
						if($getrolldpl->num_rows() == 0){
							$html .='';
						}else{
							// CUMA SATU PL
							// $getPl->row()->id_perusahaan
							if($getPl->num_rows() == 1){
								$html .='<tr>
									<td style="padding:5px;font-weight:bold;text-align:right" colspan="13"><button onclick="entryPlAllIn('."'".$id_rk."'".','."'".$ker->nm_ker."'".','."'".$ker->g_label."'".','."'".$ker->width."'".','."'".$getPl->row()->id."'".','."'".$plh."'".','."'".$getPl->row()->id_perusahaan."'".')">'.$getPl->row()->id.'</button></td>
								</tr>';
							}else{
								// ALL IN ID PL TERTENTU
								$html .='<tr><td style="padding:5px;font-weight:bold;text-align:right" colspan="13">';
								foreach($getPl->result() as $idpl){
									$html .='<button style="margin-left:5px" onclick="entryPlAllIn('."'".$id_rk."'".','."'".$ker->nm_ker."'".','."'".$ker->g_label."'".','."'".$ker->width."'".','."'".$idpl->id."'".','."'".$plh."'".','."'".$idpl->id_perusahaan."'".')">'.$idpl->id.'</button>';
								}
								$html .='</td></tr>';
							}
						}
					}
				}else{
					$html .='';
				}

				$totRoll += $ker->jml;
			}

			// TOMBOL SAKTI
			if($plh == 'pl'){
				if($otorisasi == 'all' || $otorisasi == 'admin'){
					$getRkSakti = $this->db->query("SELECT*FROM m_rencana_kirim WHERE id_rk='$id_rk' AND qc_rk='ok' GROUP BY id_rk");
					if($getRkSakti->num_rows() == 0){
						$html .= '';
					}else{
						// CEK JIKA SUDAH MASUK DI PACKING LIST
						$getSaktis = $this->db->query("SELECT id_rk,nm_ker,g_label,width FROM m_timbangan
						WHERE id_rk='$id_rk' AND id_pl='0' GROUP BY nm_ker,g_label,width");
						if($getSaktis->num_rows() == 0){
							$html .= '';
						}else{
							$idPlSakti = $this->db->query("SELECT pl.* FROM pl pl
							INNER JOIN po_master po ON pl.no_po=po.no_po AND pl.nm_ker=po.nm_ker AND pl.g_label=po.g_label
							WHERE pl.id_rk='$id_rk'
							GROUP BY pl.id,pl.no_po,pl.nm_ker,pl.g_label");
							$html .='<tr style="background:#144272"><td style="padding:5px;font-weight:bold;text-align:right" colspan="13">';
							foreach($idPlSakti->result() as $idpls){
								$html .='<button style="margin-left:5px" onclick="entryPlAllIn('."'".$id_rk."'".','."'".$idpls->nm_ker."'".','."'".$idpls->g_label."'".',0,'."'".$idpls->id."'".','."'".$plh."'".','."'".$idpls->id_perusahaan."'".')">'.$idpls->nm_ker.''.$idpls->g_label.' - '.$idpls->id.'</button>';
							}
							$html .='</td></tr>';
						}
					}
				}
			}

			// TOMBAL CEK OK
			// LABEL
			$lbl = '<div style="display:inline-block;margin:0">
				<a href="'.base_url('Laporan/print_lbl_pl').'?jenis='.$id_rk.'&all=0&ctk=F4" target="_blank" rel="plcek">PRINT LABEL</a>
			</div>';
			// PACKING LIST CEK
			$listPlCek = '<div style="display:inline-block;margin:0 20px">
				<a href="'.base_url('Master/packingListCek').'?idrk='.$id_rk.'" target="_blank" rel="plcek">PACKING LIST CEK</a>
			</div>';
			if($cekOk->num_rows() > 0){
				if($plh == 'pl'){
					$btnCekOk = $listPlCek.' '.'BELUM DICEK OLEH QC!';
					$pLabelReq = $lbl;
				}else{
					if($otorisasi == 'all' || $otorisasi == 'admin' || $otorisasi == 'qc'){
						$btnCekOk = $listPlCek.' '.'<button onclick="cekOkRk('."'".$id_rk."'".','."'".$plh."'".','."'".$l."'".','."'ok'".')">CEK OK</button>';
					}else if($otorisasi == 'cor'){
						$btnCekOk = $listPlCek.' '.'SEDANG DIPROSES';
					}else{
						$btnCekOk = 'SEDANG DALAM PENGECEKAN!';
					}
					$pLabelReq = '';
				}
			}else{
				$cSj = $this->db->query("SELECT*FROM pl WHERE id_rk='$id_rk' AND qc='ok' GROUP BY id_rk");
				if($plh == 'pl'){
					if($otorisasi == 'all' || $otorisasi == 'admin'){
						if($cSj->num_rows() == 0){
							$btnCekOk = $listPlCek.' '.'<button onclick="cekOkRk('."'".$id_rk."'".','."'".$plh."'".','."'".$l."'".','."'batal'".')">BATAL OK</button>';
						}else{
							$btnCekOk = 'SURAT JALAN SUDAH OK!';
						}
					}else if($otorisasi == 'cor'){
						$btnCekOk = $listPlCek.' '.'SEDANG DIPROSES';
					}else{
						if($cSj->num_rows() == 0){
							$btnCekOk = 'SURAT JALAN SEDANG DIPROSES';
						}else{
							$btnCekOk = 'SURAT JALAN SUDAH OK!';
						}
					}
					$pLabelReq = $lbl;
				}else{
					if($otorisasi == 'all' || $otorisasi == 'admin' || $otorisasi == 'qc'){
						if($cSj->num_rows() == 0){
							$btnCekOk = $listPlCek.' '.'SURAT JALAN SEDANG DIPROSES';
						}else{
							$btnCekOk = 'SURAT JALAN SUDAH OK!';
						}
					}else if($otorisasi == 'cor'){
						$btnCekOk = $listPlCek.' '.'SEDANG DIPROSES';
					}else{
						if($cSj->num_rows() == 0){
							$btnCekOk = 'SURAT JALAN SEDANG DIPROSES';
						}else{
							$btnCekOk = 'SURAT JALAN SUDAH OK!';
						}
					}
					$pLabelReq = '';
				}
			}
			
			if($plh == 'pl'){
				$cls = 6;
			}else{
				$cls = 5;
			}
			$html .='<tr style="background:#e9e9e9">
				<td style="padding:5px;font-weight:bold">'.number_format($totRoll).'</td>
				<td style="padding:5px;font-weight:bold" colspan="5">TOTAL</td>
				<td style="padding:5px;font-weight:bold">'.number_format($totBerat).'</td>
				<td style="padding:5px;font-weight:bold" colspan="'.$cls.'">'.$pLabelReq.' '.$btnCekOk.'</td>
			</tr>';
			$html .='</table></div>';
		}
		echo $html;
	}
	
	function cekOkRk(){
		if($_POST['cek'] == 'ok'){
			$msg = 'CEK OK! SURAT JALAN SEGERA DIPROSES!';
		}else{
			$msg = 'BERHASIL BATAL! MASUK KE RENCANA KIRIM KEMBALI!';
		}
		$result = $this->m_master->cekOkRk();
		echo json_encode(array(
			'res' => $result,
			'msg' => $msg,
		));
	}

	function editRollRk(){
		$idrk = $_POST['id_rk'];
		$plh = $_POST['pilihbtnrencana'];

		// CEK JIKA ADA DIAMETER, SESET MASIH SAMA ATAU ISI KOSONG
		if($_POST['seset'] == $_POST['vseset'] && $_POST['diameter'] == $_POST['vdiameter']){
			echo json_encode(array('res' => true, 'msg' => 'ISI MASIH SAMA!', 'info' => 'error'));
		}else if($_POST['seset'] == '' || $_POST['diameter'] == 0 || $_POST['diameter'] == ''){
			echo json_encode(array('res' => true, 'msg' => 'SESET / DIAMETER HARUS DI ISI!', 'info' => 'error'));
		}else if($_POST['seset'] >= $_POST['vberat']){
			echo json_encode(array('res' => true, 'msg' => 'SESET TIDAK BOLEH LEBIH BESAR DARI BERAT ASLI!', 'info' => 'error'));
		}else{
			// JIKA DI PACKING LIST MASIH BISA BATAL
			if($plh == 'pl'){
				$this->m_master->editRollRk();
				echo json_encode(array('res' => true, 'msg' => 'BERHASIL EDIT!', 'info' => 'success'));
			}else{
				$cek = $this->db->query("SELECT*FROM m_rencana_kirim WHERE id_rk='$idrk' AND qc_rk='proses' GROUP BY id_rk");
				if($cek->num_rows() == 0){
					echo json_encode(array('res' => true, 'msg' => 'SUDAH DICEK OK! TIDAK BISA EDIT!', 'info' => 'error'));
				}else{
					$this->m_master->editRollRk();
					echo json_encode(array('res' => true, 'msg' => 'BERHASIL EDIT!', 'info' => 'success'));
				}
			}
		}
	}

	function reqLabelRk(){
		$retrun = $this->m_master->reqLabelRk();
		echo json_encode(array('res' => $retrun, 'msg' => 'REQUEST LABEL BERHASIL!'));
	}

	function batalRollRk(){
		// CEK JIKA SUDAH OK!
		$id = $_POST['id'];
		$idrk = $_POST['id_rk'];
		$plh = $_POST['pilihbtnrencana'];

		// JIKA DI PACKING LIST MASIH BISA BATAL
		if($plh == 'pl'){
			$cekPlCor = $this->db->query("SELECT*FROM m_timbangan WHERE id='$id' AND id_pl='0' AND cor_at IS NOT NULL AND cor_by IS NOT NULL");
			if($cekPlCor->num_rows() > 0){
				$return = true;
				$msg = 'SUDAH TERKONFIRMASI COR!';
				$info = 'error';
			}else{
				$return = $this->m_master->batalRollRk();
				$msg = 'BERHASIL BATAL!';
				$info = 'success';
			}
		}else{
			$cek = $this->db->query("SELECT*FROM m_rencana_kirim WHERE id_rk='$idrk' AND qc_rk='proses' GROUP BY id_rk");
			if($cek->num_rows() == 0){
				$return = true;
				$msg = 'SUDAH DICEK OK! TIDAK BISA BATAL';
				$info = 'error';
			}else{
				$return = $this->m_master->batalRollRk();
				$msg = 'BERHASIL BATAL!';
				$info = 'success';
			}
		}
		echo json_encode(array('res' => $return, 'msg' => $msg, 'info' => $info));
	}

	function editListRk(){
		if($_POST['ljmlroll'] == $_POST['ejmlroll']){
			echo json_encode(array(
				'response' => false,
				'msg' => 'JUMLAH SAMA!',
			));
		}else if($_POST['ejmlroll'] == '' || $_POST['ejmlroll'] == 0){
			echo json_encode(array(
				'response' => false,
				'msg' => 'JUMLAH ROLL TIDAK BOLEH KOSONG!',
			));
		}else{
			$this->m_master->editListRk();
			echo json_encode(array(
				'response' => true,
				'msg' => 'BERHASIL EDIT!',
			));
		}
	}

	function hapusListRk(){
		$this->m_master->delete("m_rencana_kirim", "id", $_POST['id']);
		echo json_encode(array(
			'response' => true,
			'msg' => 'BERHASIL DIHAPUS!',
		));
	}

	function showListEditRk(){
		$idrk = $_POST['id_rk'];
		$opl = $_POST['opl'];
		$tgl_pl = $_POST['tgl_pl'];
		$li = $_POST['i'];
		$html ='';

		$pl = $this->db->query("SELECT*FROM pl WHERE id_rk='$idrk' GROUP BY id_rk")->row();
		if($pl->nama == '-'){
			$nama = '';
		}else{
			$nama = $pl->nama.' - ';
		}
		if($pl->nm_perusahaan == '-'){
			$pt = '';
		}else{
			$pt = $pl->nm_perusahaan;
		}
		$html .='<div style="padding:5px;color:#000;font-weight:bold" colspan="6">'.$nama.$pt.'</div>';

		$getData = $this->db->query("SELECT*FROM m_rencana_kirim
		WHERE id_rk='$idrk'
		ORDER BY nm_ker,g_label,width");
		$html .='<table style="font-size:12px;color:#000;text-align:center" border="1">';
		$html .='<tr>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold">NO</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold">JENIS</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold">GSM</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold">UKURAN</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold">JML ROLL</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold">AKSI</td>
		</tr>';
		$i = 0;
		$sumJmlRoll = 0;
		foreach($getData->result() as $r){
			$i++;

			// CEJ JIKA RENCANA KIRIM SUDAH ADA ROLL TIDAK BISA HAPUS
			$iRoll = $this->db->query("SELECT*FROM m_timbangan WHERE id_rk='$idrk' AND nm_ker='$r->nm_ker' AND g_label='$r->g_label' AND width='$r->width' GROUP BY id_rk");
			if($iRoll->num_rows() == 0){
				$aksi = ' - <button onclick="hapusListRk('."'".$r->id."'".','."'".$r->nm_ker."'".','."'".$r->g_label."'".','."'".$r->width."'".','."'".$idrk."'".','."'".$opl."'".','."'".$tgl_pl."'".','."'".$li."'".')">hapus</button>';
			}else{
				$aksi = '';
			}

			$html.='<tr>
				<td style="padding:5px">'.$i.'</td>
				<td style="padding:5px">'.$r->nm_ker.'</td>
				<td style="padding:5px">'.$r->g_label.'</td>
				<td style="padding:5px">'.round($r->width, 2).'</td>
				<td style="position:relative">
					<input class="inp-abs" type="text" value="'.$r->jml_roll.'" id="elrkroll-'.$i.'" maxlength="3" onkeypress="return hanyaAngka(event)">
				</td>
				<td style="padding:5px">
					<button onclick="editListRk('."'".$r->id."'".','."'".$r->nm_ker."'".','."'".$r->g_label."'".','."'".$r->width."'".','."'".$idrk."'".','."'".$opl."'".','."'".$tgl_pl."'".','."'".$li."'".','."'".$i."'".','."'".$r->jml_roll."'".')">edit</button>'.$aksi.'
				</td>
			</tr>';
			$sumJmlRoll += $r->jml_roll;
		}
		$html .='<tr>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold" colspan="4">TOTAL</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold">'.number_format($sumJmlRoll).'</td>
			<td style="background:#e9e9e9"></td>
		</tr>';
		$html .='</table>';

		echo $html;
	}

	function konfirmasiBatalCor(){
		$id = $_POST['id'];
		$id_rk = $_POST['id_rk'];

		if($_POST['pilihan'] == 'konfirmasi'){
			$return = $this->m_master->konfirmasiBatalCor();
			echo json_encode(array('res' => $return, 'msg' => 'TERKONFIRMASI!', 'info' => 'success'));
		}else{
			$cek = $this->db->query("SELECT*FROM m_timbangan WHERE id='$id' AND id_pl!='0'");
			if($cek->num_rows() == 0){
				$return = $this->m_master->konfirmasiBatalCor();
				echo json_encode(array('res' => $return, 'msg' => 'BATAL KONFIRMASI!', 'info' => 'success'));
			}else{
				echo json_encode(array('res' => true, 'msg' => 'ROLL SUDAH MASUK DI PACKING LIST!', 'info' => 'error'));
			}
		}
	}

	function prosesPL(){
		$idrk = $_POST['id_rk'];
		$opl = $_POST['opl'];
		$tglpl = $_POST['tgl_pl'];
		$brencana = $_POST['brencana'];
		$otorisasi = $_POST['otorisasi'];
		$i = $_POST['i'];
		$html = '';

		// CUMA TAMPIL PACKING LISTNYA
		$qgetPL = $this->db->query("SELECT*FROM pl
		WHERE id_rk='$idrk' AND tgl_pl='$tglpl' AND opl='$opl'
		GROUP BY id_rk,tgl_pl,opl,id,nm_ker,no_po,no_pkb,g_label");
		if($qgetPL->num_rows() == 0){
			$html .= '';
		}else{
			$html .='<div style="overflow:auto;white-space:nowrap;">';
			$html .='<table style="margin:15px 0;font-size:12px;color:#000" border="1">';
			$html .='<tr style="background:#e9e9e9;text-align:center">
				<td style="padding:5px;font-weight:bold">ID PL</td>
				<td style="padding:5px;font-weight:bold">NO. SURAT</td>
				<td style="padding:5px;font-weight:bold">NO. SO</td>
				<td style="padding:5px;font-weight:bold">NO. PKB</td>
				<td style="padding:5px;font-weight:bold">NO. PO</td>
				<td style="padding:5px;font-weight:bold">JENIS</td>
				<td style="padding:5px;font-weight:bold">GSM</td>
			</tr>';

			foreach($qgetPL->result() as $qpl){
				$html .='<tr class="list-p-putih">
					<td style="padding:5px;font-weight:bold;text-align:center">'.$qpl->id.'</td>
					<td style="padding:5px">'.$qpl->no_surat.'</td>
					<td style="padding:5px">'.$qpl->no_so.'</td>
					<td style="padding:5px">'.$qpl->no_pkb.'</td>
					<td style="padding:5px">'.$qpl->no_po.'</td>
					<td style="padding:5px">'.$qpl->nm_ker.'</td>
					<td style="padding:5px">'.$qpl->g_label.'</td>
				</tr>';
			}
			$html .='</table>';
			$html .='</div>';
		}

		// TAMPIL ROLL KE PACKING LIST
		// GET NO SURAT JALAN
		$getSj = $this->db->query("SELECT COUNT(m.roll) AS croll,SUM(m.weight) AS zberat,SUM(m.seset) AS zseset,p.* FROM pl p
		INNER JOIN m_timbangan m ON p.id=m.id_pl WHERE p.id_rk='$idrk' AND p.tgl_pl='$tglpl' AND opl='$opl' GROUP BY p.id_rk,p.nm_ker,p.no_pkb");
		if($getSj->num_rows() == 0){
			$html .='';
		}else{
			$html .='<div style="overflow:auto;white-space:nowrap;">';
			$html .='<table style="margin:15px 0;font-size:12px;color:#000;text-align:center" border="1">';
			$html .='<tr style="background:#e9e9e9">
				<td style="padding:5px;font-weight:bold">NO. SURAT JALAN</td>
				<td style="padding:5px;font-weight:bold">NO. PO</td>
				<td style="padding:5px;font-weight:bold" colspan="2">JENIS KERTAS</td>
				<td style="padding:5px;font-weight:bold">NO. ROLL</td>
				<td style="padding:5px;font-weight:bold">D(CM)</td>
				<td style="padding:5px;font-weight:bold">BERAT</td>
				<td style="padding:5px;font-weight:bold">JNT</td>
				<td style="padding:5px 35px;font-weight:bold">KETERANGAN</td>
				<td style="padding:5px;font-weight:bold">SESET</td>
				<td style="padding:5px;font-weight:bold">AKSI</td>
			</tr>';
			foreach($getSj->result() as $sj){
				$html .='<tr>
					<td style="padding:5px;font-weight:bold" class="list-p-putih" rowspan="'.$sj->croll.'">'.trim($sj->no_surat).'</td>';
				// GET NO PO
				$getNoPO = $this->db->query("SELECT COUNT(m.roll) AS jnopo,p.* FROM pl p
				INNER JOIN m_timbangan m ON p.id=m.id_pl
				WHERE p.id_rk='$sj->id_rk' AND p.nm_ker='$sj->nm_ker' AND p.no_pkb='$sj->no_pkb'
				GROUP BY p.id_rk,p.nm_ker,p.no_po");
				foreach($getNoPO->result() as $nopo){
					$html .='<td style="padding:5px;font-weight:bold" class="list-p-putih" rowspan="'.$nopo->jnopo.'">'.$nopo->no_po.'</td>';
					// GET JENIS KERTAS DAN GSM
					$getJKnGSM = $this->db->query("SELECT COUNT(m.roll) AS jkroll,p.* FROM pl p INNER JOIN m_timbangan m ON p.id=m.id_pl
					WHERE p.id_rk='$nopo->id_rk' AND p.nm_ker='$nopo->nm_ker' AND p.no_pkb='$nopo->no_pkb' AND p.no_po='$nopo->no_po'
					GROUP BY p.id_rk,p.nm_ker,p.g_label");
					foreach($getJKnGSM->result() as $jkGsm){
						if(($jkGsm->nm_ker == 'MH' || $jkGsm->nm_ker == 'MN') && ($jkGsm->g_label == 105 || $jkGsm->g_label == 110)){
							$bgkk = 'list-p-biru';
						}else if($jkGsm->nm_ker == 'MH' && ($jkGsm->g_label == 120 || $jkGsm->g_label == 125)){
							$bgkk = 'list-p-kuning';
						}else if(($jkGsm->nm_ker == 'MH' || $jkGsm->nm_ker == 'MN') && $jkGsm->g_label == 150){
							$bgkk = 'list-p-merah';
						}else if($jkGsm->nm_ker == 'WP'){
							$bgkk = 'list-p-hijau';
						}else{
							$bgkk = 'list-p-putih';
						}
						$html .='<td style="padding:5px;font-weight:bold" class="'.$bgkk.'" rowspan="'.$jkGsm->jkroll.'">'.$jkGsm->nm_ker.''.$jkGsm->g_label.'<br/>('.$jkGsm->id.')</td>';
						// GET UKURAN
						$getWidth = $this->db->query("SELECT COUNT(m.roll) AS ukroll,m.width,p.* FROM pl p INNER JOIN m_timbangan m ON p.id=m.id_pl
						WHERE p.id_rk='$jkGsm->id_rk' AND p.nm_ker='$jkGsm->nm_ker' AND p.g_label='$jkGsm->g_label' AND p.no_po='$jkGsm->no_po'
						GROUP BY p.id_rk,p.nm_ker,p.g_label,m.width");
						foreach($getWidth->result() as $uk){
							$html .='<td style="padding:5px;font-weight:bold" class="'.$bgkk.'" rowspan="'.$uk->ukroll.'">'.round($uk->width,2).' ('.$uk->ukroll.')</td>';
							// GET NOMER ROLLNYA
							$getRoll = $this->db->query("SELECT m.id AS idroll,m.roll AS roll,m.diameter,m.weight,m.joint,m.ket,m.seset,m.status AS statusroll,p.* FROM pl p
							INNER JOIN m_timbangan m ON p.id=m.id_pl
							WHERE p.id_rk='$uk->id_rk' AND p.nm_ker='$uk->nm_ker' AND p.g_label='$uk->g_label' AND p.no_po='$uk->no_po' AND m.width='$uk->width'
							GROUP BY p.id_rk,p.nm_ker,p.g_label,m.width,m.roll");
							foreach($getRoll->result() as $roll){
								// JIKA ADA SESET, BERAT DIKURANGI DAN TAMPIL DI KETERANGAN
								if($roll->seset == 0){
									$berat = $roll->weight;
									$ket = $roll->ket;
								}else{
									$berat = $roll->weight - $roll->seset;
									$ket = '- '.$roll->seset.'KG. '.$roll->weight.'. '.$roll->ket;
								}

								if($roll->statusroll == '3'){
									$bg = 'status-buffer';
								}else{
									$bg = 'status-stok';
								}
								
								// BATAL
								$batal = '<button onclick="entryBatalPL('."'".$roll->idroll."'".','."'".$roll->roll."'".','."'".$roll->statusroll."'".','."'".$roll->id_rk."'".','."'".$brencana."'".')">Batal</button>';
								if($otorisasi == 'all' || $otorisasi == 'admin'){
									// JIKA SUDAH OK TIDAK BISA BATAL
									$cekpLoK = $this->db->query("SELECT*FROM pl WHERE id_rk='$roll->id_rk' AND qc='proses' GROUP BY id_rk");
									if($cekpLoK->num_rows() == 0){
										$aksi = '-';
									}else{
										$aksi = $batal;
									}
								}else{
									$aksi = '-';
								}
								$html .='<td style="padding:5px;text-align:left" class="'.$bg.'">'.$roll->roll.'</td>
									<td style="padding:5px" class="'.$bg.'">'.$roll->diameter.'</td>
									<td style="padding:5px" class="'.$bg.'">'.number_format($berat).'</td>
									<td style="padding:5px" class="'.$bg.'">'.$roll->joint.'</td>
									<td style="position:relative" class="'.$bg.'">
										<textarea disabled class="txt-area-new">'.$ket.'</textarea>
									</td>
									<td style="padding:5px" class="'.$bg.'">'.$roll->seset.'</td>
									<td style="padding:5px" class="'.$bg.'">'.$aksi.'</td>';
								$html .='</tr>';
							}
							$html .='</tr>';
						}
						$html .='</tr>';
					}
					$html .='</tr>';
				}
				// TOMBOL PRINT SJ - PACKING LIST MUNCUL JIKA SUDAH OK
				if($sj->qc == 'ok'){
					// TAMBAHKAN NOPOL DULU BARU BISA PRINT SURAT JALAN + PACKING LIST	
					if($sj->id_expedisi == null || $sj->id_expedisi == ''){
						$btnSJ = 'TAMBAHKAN NOPOL!';
					}else{
						$btnSJ = '<div style="display:inline-block;font-weight:bold;margin:0 5px">
							<a href="'.base_url('Laporan/print_surat_jalan').'?jenis='.$sj->no_pkb.'&ctk=0" target="_blank" rel="plcek">SURAT JALAN</a>
						</div>
						<div style="display:inline-block;font-weight:bold;margin:0 5px">
							<a href="'.base_url('Laporan/print_surat_jalan').'?jenis='.$sj->no_pkb.'&ctk=1" target="_blank" rel="plcek">PACKING LIST</a>
						</div>';
					}
				}else{
					$btnSJ = 'CEK YANG BENER! BELUM OK!';
				}

				// TAMPIL NOPOL + SUPIR
				if($sj->id_expedisi == null || $sj->id_expedisi == ''){
					$tmplNopolSiu = '-';
				}else{
					$getNopol = $this->db->query("SELECT*FROM m_expedisi WHERE id='$sj->id_expedisi'")->row();
					$tmplNopolSiu = $getNopol->plat.' - '.$getNopol->supir;
				}

				// FIX BERAT DIKURANGI SESET
				$totBerat = $sj->zberat - $sj->zseset;
				$html .='<tr style="background:#e9e9e9;font-weight:bold">
					<td style="padding:5px;text-align:center" colspan="3">'.$tmplNopolSiu.'</td>
					<td style="padding:5px">'.number_format($sj->croll).'</td>
					<td style="padding:5px" colspan="2">TOTAL</td>
					<td style="padding:5px">'.number_format($totBerat).'</td>
					<td style="padding:5px" colspan="4">'.$btnSJ.'</td>
				</tr>';
				
				// KOTAK KOSONG
				$html .='<tr>
					<td style="padding:10px;border:0" colspan="11"></td>
				</tr>';
			}
			// TOMBOL CEK / BATAL PACKING LIST
			if($getSj->row()->qc == 'ok'){
				$btnSJok = '<button onclick="pLsJokeY('."'".$idrk."'".','."'".$tglpl."'".','."'".$opl."'".','."'".$brencana."'".','."'proses'".')">BATAL BRO?</button>';
			}else{
				$btnSJok = '<button onclick="pLsJokeY('."'".$idrk."'".','."'".$tglpl."'".','."'".$opl."'".','."'".$brencana."'".','."'ok'".')">OK BRO?</button>';
			}
			$html .='<tr style="font-weight:bold;text-align:center">
				<td style="padding:5px;border:0" colspan="11">'.$btnSJok.'</td>
			</tr>';
			$html .='</table>';
			$html .='</div>';
		}

		echo $html;
	}

	function entryPL(){
		$id = $_POST['idroll'];
		$kodeIdRk = substr($_POST['id_rk'], 0, 7);
		if($kodeIdRk == 'RK.210.'){
			$cekPl = $this->db->query("SELECT*FROM m_timbangan WHERE id='$id' AND id_rk LIKE '$kodeIdRk%' AND id_pl='0' AND cor_at IS NULL AND cor_by IS NULL");
			if($cekPl->num_rows() > 0){
				$result = true;
				echo json_encode(array('res' => $result, 'msg' => 'GAGAL BELUM TERKOMFIRMASI COR!', 'info' => 'error'));
			}else{
				$result = $this->m_master->entryPL();
				echo json_encode(array('res' => $result, 'msg' => 'BERHASIL DITAMBAHKAN KE PL!', 'info' => 'success'));
			}
		}else{
			$result = $this->m_master->entryPL();
			echo json_encode(array('res' => $result, 'msg' => 'BERHASIL DITAMBAHKAN KE PL!', 'info' => 'success'));
		}
		

	}

	function entryPlAllIn(){
		$result = $this->m_master->entryPlAllIn();
		echo json_encode(array(
			'res' => $result,
			'msg' => 'BERHASIL DITAMBAHKAN KE PL!',
		));
	}

	function entryBatalPL(){
		$result = $this->m_master->entryBatalPL();
		echo json_encode(array(
			'res' => $result,
			'msg' => 'ROLL DIBATALKAN!'
		));
	}

	function pLsJokeY(){
		if($_POST['cek'] == 'ok'){
			$msg = 'BERHASIL OK BEROW!';
		}else{
			$msg = 'BERHASIL BATAL BEROW!';
		}
		$result = $this->m_master->pLsJokeY();
		echo json_encode(array(
			'res' => $result,
			'msg' => $msg,
		));
	}

	function pListRencana(){
		$opl = $_POST['opl'];		
		$tgl_pl = $_POST['tgl_pl'];
		$i = $_POST['i'];
		$idrk = $_POST['id_rk'];
		$otorisasi = $_POST['otorisasi'];
		$html = '';

		$getUkRencKirim = $this->db->query("SELECT p.id,p.id_rk,p.tgl_pl,p.opl,p.nm_ker,p.g_label,width,jml_roll FROM pl p
		-- INNER JOIN m_rencana_kirim r ON p.tgl_pl=r.tgl AND p.opl=r.order_pl
		INNER JOIN m_rencana_kirim r ON p.tgl_pl=r.tgl AND p.opl=r.order_pl AND p.id_rk=r.id_rk
		WHERE p.tgl_pl='$tgl_pl' AND p.opl='$opl' AND p.id_rk='$idrk'
		GROUP BY p.tgl_pl,p.opl,p.nm_ker,p.g_label");
		if($getUkRencKirim->num_rows() == 0){
			$html .= '<div style="notfon">BELUM ADA RENCANA KIRIMAN</div>';
		}else{
			$html .='<table class="list-table" style="font-weight:bold;text-align:center" border="1">
				<tr style="background:#e9e9e9">
					<td style="padding:5px">JENIS</td>
					<td style="padding:5px">UKURAN</td>
					<td style="padding:5px">JUMLAH</td>
					<td style="padding:5px">INPUT</td>
				</tr>';
			$sumjrll = 0;
			$sumjIrll = 0;
			foreach($getUkRencKirim->result() as $ukRenc){
				if(($ukRenc->nm_ker == 'MH' || $ukRenc->nm_ker == 'MN') && ($ukRenc->g_label == 105 || $ukRenc->g_label == 110)){
					$bgtr = 'list-p-biru';
				}else if($ukRenc->nm_ker == 'MH' && ($ukRenc->g_label == 120 || $ukRenc->g_label == 125)){
					$bgtr = 'list-p-kuning';
				}else if(($ukRenc->nm_ker == 'MH' || $ukRenc->nm_ker == 'MN') && $ukRenc->g_label == 150){
					$bgtr = 'list-p-merah';
				}else if($ukRenc->nm_ker == 'WP'){
					$bgtr = 'list-p-hijau';
				}else{
					$bgtr = 'list-p-putih';
				}
				$getUk = $this->db->query("SELECT*FROM m_rencana_kirim
				WHERE nm_ker='$ukRenc->nm_ker' AND g_label='$ukRenc->g_label' AND order_pl='$ukRenc->opl' AND id_rk='$ukRenc->id_rk'
				GROUP BY nm_ker,g_label,width,order_pl");
				$rowsp = $getUk->num_rows() + 1;
				$html .='<tr class="'.$bgtr.'">
					<td style="padding:5px" rowspan="'.$rowsp.'">'.$ukRenc->nm_ker.' '.$ukRenc->g_label.'</td></tr>';

				$totjmlroll = 0;
				$totIjmlroll = 0;
				foreach($getUk->result() as $uk){
					// JIKA SUDAH CEK OK TIDAK BISA DITAMBAHKAN
					$btnInputRoll = '<button onclick="btnInputRoll('."'".$i."'".','."'".$uk->nm_ker."'".','."'".$uk->g_label."'".','."'".$uk->width."'".')" style="background:0;border:0;padding:5px 15px">'.$uk->jml_roll.'</button>';
					if($otorisasi == 'all' || $otorisasi == 'admin'){ // dev / admin masih bisa edit walaupun cek ok
						$aksi = $btnInputRoll;
					}else if(($otorisasi == 'all' || $otorisasi == 'admin' || $otorisasi == 'fg') && $uk->qc_rk == 'proses'){
						$aksi = $btnInputRoll;
					}else{
						$aksi = $uk->jml_roll;
					}
					// GET ROLL
					$getRoll = $this->db->query("SELECT COUNT(roll) AS jmlRoll FROM m_timbangan WHERE id_rk='$uk->id_rk' AND nm_ker='$uk->nm_ker' AND g_label='$uk->g_label' AND width='$uk->width'");
					if($getRoll->row()->jmlRoll == '' || $getRoll->row()->jmlRoll == 0){
						$jmlRoll = 0;
					}else{
						$jmlRoll = $getRoll->row()->jmlRoll;
					}
					$html .='<tr class="'.$bgtr.'">
						<td style="padding:5px">'.round($uk->width,2).'</td>
						<td >'.$aksi.'</td>
						<td style="background:#fff;padding:5px">'.$jmlRoll.'</td>
					</tr>';

					$totjmlroll += $uk->jml_roll;
					$totIjmlroll += $jmlRoll;
				}

				$sumjrll += $totjmlroll;
				$sumjIrll += $totIjmlroll;
			}
			$html .='<tr style="background:#e9e9e9">
				<td style="padding:5px;font-weight:bold" colspan="2">TOTAL</td>
				<td style="padding:5px;font-weight:bold">'.number_format($sumjrll).'</td>
				<td style="padding:5px;font-weight:bold">'.number_format($sumjIrll).'</td>
			</tr>';
			$html .='</table>';
		}
		echo $html;
	}

	function pListInputRoll(){
		$i = $_POST['i'];
		$nm_ker = $_POST['nm_ker'];
		$g_label = $_POST['g_label'];
		$width = $_POST['width'];
		$roll = $_POST['roll'];
		$html='';

		$key = 'cari';
		$html .='<div class="plistinputroll">
		<div style="padding:10px 0 0">
			<button style="padding:5px;font-weight:bold" disabled>'.$nm_ker.''.$g_label.' - '.round($width,2).' :</button>
			<input type="text" name="roll" id="vcariroll-'.$i.'" value="'.$roll.'" maxlength="14" style="border:1px solid #ccc;padding:7px;border-radius:5px" autocomplete="off" placeholder="ROLL">
			<button class="btn-cari-inp-roll" onclick="cariRoll('."'".$i."'".','."'".$nm_ker."'".','."'".$g_label."'".','."'".$width."'".','."'".$roll."'".','."'".$key."'".')">CARI</button>
		</div>';
		
		$getRoll = $this->db->query("SELECT*FROM m_timbangan
		WHERE nm_ker='$nm_ker' AND g_label='$g_label' AND width='$width' AND roll LIKE '%$roll%'
		AND tgl BETWEEN '2020-04-01' AND '9999-01-01'
		AND (status='0' OR status='3') AND id_pl='0' AND (id_rk IS NULL OR id_rk = '')
		ORDER BY YEAR(tgl),pm,roll");
		if($getRoll->num_rows() == 0){
			$html .='<div class="notfon">DATA TIDAK DITEMUKAN</div>';
		}else{
			$ii = 0;
			$html .='<div style="padding-top:10px"><table class="list-table" style="text-align:center;width:100%" border="1">
			<tr style="background:#e9e9e9">
				<td style="padding:5px;font-weight:bold;width:5%">NO.</td>
				<td style="padding:5px;font-weight:bold;width:18%">ROLL</td>
				<td style="padding:5px;font-weight:bold;width:5%">BW</td>
				<td style="padding:5px;font-weight:bold;width:5%">RCT</td>
				<td style="padding:5px;font-weight:bold;width:5%">BI</td>
				<td style="padding:5px;font-weight:bold;width:5%">JENIS</td>
				<td style="padding:5px;font-weight:bold;width:5%">GSM</td>
				<td style="padding:5px;font-weight:bold;width:5%">D(CM)</td>
				<td style="padding:5px;font-weight:bold;width:5%">WIDTH</td>
				<td style="padding:5px;font-weight:bold;width:5%">BERAT</td>
				<td style="padding:5px;font-weight:bold;width:5%">JNT</td>
				<td style="padding:5px;font-weight:bold;width:27%">KETERANGAN</td>
				<td style="padding:5px;font-weight:bold;width:5%">AKSI</td>
			</tr>';
			foreach($getRoll->result() as $r){
				$ii++;
				if($r->status == 3){
					$bgtr = 'status-buffer';
				}else{
					$bgtr = 'status-stok';
				}
				// JIKA ROLL PERNAH DI EDIT
				$getRollEdit = $this->db->query("SELECT*FROM m_roll_edit WHERE roll='$r->roll'");
				if($getRollEdit->num_rows() == 0){
					$btnEdit = $r->roll;
				}else{
					$btnEdit = '<button class="tmbl-cek-roll" style="color:#00f" onclick="cekRollEdit('."'".$r->id."'".','."'".$r->roll."'".')">'.$r->roll.'</button>';
				}
				$html .='<tr class="'.$bgtr.'">
					<td style="padding:5px;font-weight:bold">'.$ii.'</td>
					<td style="padding:5px;text-align:left">'.$btnEdit.'</td>
					<td style="padding:5px">'.$r->g_ac.'</td>
					<td style="padding:5px">'.$r->rct.'</td>
					<td style="padding:5px">'.$r->bi.'</td>
					<td style="padding:5px">'.$r->nm_ker.'</td>
					<td style="padding:5px">'.$r->g_label.'</td>
					<td style="padding:5px">'.$r->diameter.'</td>
					<td style="padding:5px">'.round($r->width,2).'</td>
					<td style="padding:5px">'.$r->weight.'</td>
					<td style="padding:5px">'.$r->joint.'</td>
					<td style="padding:5px"><textarea class="txt-area-i" disabled>'.$r->ket.'</textarea></td>
					<td style="padding:5px"><button onclick="cartInputRoll('."'".$r->id."'".','."'".$r->roll."'".','."'".$r->status."'".','."'".$i."'".')">ADD</button></td>
				</tr>';
				// <td style="padding:5px"><button onclick="cartInputRoll('."'".$r->id."'".','."'".$r->roll."'".','."'".$r->nm_ker."'".','."'".$r->g_label."'".','."'".$r->diameter."'".','."'".$r->width."'".','."'".$r->weight."'".','."'".$r->joint."'".','."'".$r->ket."'".','."'".$i."'".')">ADD</button></td>
			}
		}
		$html .='</table></div></div>';
		echo $html;
	}

	function pListCartInputRoll(){
		$data = array(
			'id' => $_POST['id'],
			'name' => $_POST['id'],
			'price' => 0,
			'qty' => $_POST['id'],
			'options' => array(
				'roll' => $_POST['roll'],
				// 'nm_ker' => $_POST['nm_ker'],
				// 'g_label' => $_POST['g_label'],
				// 'diameter' => $_POST['diameter'],
				// 'width' => $_POST['width'],
				// 'weight' => $_POST['weight'],
				// 'joint' => $_POST['joint'],
				// 'ket' => $_POST['ket'],
				'status' => $_POST['status'],
				'id_rk' => $_POST['id_rk'],
				'i' => $_POST['i'],
			),
		);
		$this->cart->insert($data);
		echo json_encode(array('data' => true, 'isi' => $data));
		// echo $this->showCartInputRoll();
	}

	function showCartInputRoll() { //Fungsi untuk menampilkan Cart
		$html = '';

		if($this->cart->total_items() != 0){
			$html .='<table class="list-table" style="text-align:center;margin:15px 0 5px" border="1">
			<tr style="background:#e9e9e9">
				<td style="font-weight:bold;padding:5px">NO.</td>
				<td style="font-weight:bold;padding:5px">ROLL</td>
				<td style="font-weight:bold;padding:5px">AKSI</td>
			</tr>';
		}

		$i = 0;
		foreach($this->cart->contents() as $items){
			$i++;
			$html .='<tr>
				<td style="font-weight:bold;padding:5px">'.$i.'</td>
				<td style="font-weight:bold;padding:5px">'.$items['options']['roll'].'</td>
				<td style="padding:5px"><button onclick="hapusCartInputRoll('."'".$items['rowid']."'".','."'".$items['options']['i']."'".')">Batal</button></td>
			</tr>';
		}
		$html .='</table>';

		if($this->cart->total_items() != 0){
			$html .='<div style="font-size:12px;font-weight:bold;color:#000"><button onclick="simpanInputRoll()">SIMPAN</button></div>';
		}
		// return $html;
		echo $html;
	}

	function simpanInputRoll(){
		$this->m_master->simpanInputRoll();
		echo json_encode(array('data' => true));
	}

	function hapusCartInputRoll() {
		$data = array(
			'rowid' => $_POST['rowid'],
			'qty' => 0,
		);
		$this->cart->update($data);
	}

	function destroyCartInputRoll() {
		$this->cart->destroy();
	}

	function addCartPO(){
		$id = $_POST['fjenis'].'_'.$_POST['fgsm'].'_'.$_POST['fukuran'];
		$nama = $_POST['fjenis'].'-'.$_POST['fgsm'].'-'.$_POST['fukuran'];
		if($_POST['status_roll'] == 0){
			$txtStat = 'STOK';
		}else{
			$txtStat = 'BUFFER';
		}
		$data = array(
			'id' => $id,
			'name' => $nama,
			'price' => 0,
			'qty' => 1,
			'options' => array(
				'fjenis' => $_POST['fjenis'],
				'fgsm' => $_POST['fgsm'],
				'fukuran' => $_POST['fukuran'],
				'ftonase' => $_POST['ftonase'],
				'fjmlroll' => $_POST['fjmlroll'],
				'fharga' => $_POST['fharga'],
				'txt_status_roll' => $txtStat,
				'status_roll' => $_POST['status_roll'],
			),
		);
		$uidpt = $_POST['update_idpt'];
		$uidpo = $_POST['update_idpo'];
		$unopo = $_POST['update_nopo'];
		// $nmker = $_POST['fjenis'];
		if($_POST['fjenis'] == 'MHC'){
			$nmker = 'MH COLOR';
		}else{
			$nmker = $_POST['fjenis'];
		}
		$glabel = $_POST['fgsm'];
		$width = $_POST['fukuran'];

		// UPDATE CEK JIKA ADA JENIS, GSM, UKURAN YANG SAMA
		$cek1 = $this->db->query("SELECT*FROM po_master
		WHERE id_perusahaan='$uidpt' AND id_po='$uidpo' AND no_po='$unopo' AND nm_ker='$nmker' AND g_label='$glabel' AND width='$width'
		GROUP BY id_perusahaan,id_po,nm_ker,g_label,width");
		if($_POST['option'] == 'update'){
			if($cek1->num_rows() == 0){
				$this->cart->insert($data);
				echo json_encode(array('response' => true, 'msg' => 'BERHASIL!'));
			}else{
				echo json_encode(array('response' => false, 'msg' => 'JENIS / GSM / UKURAN SUDAH ADA!'));
			}
		}else{
			$this->cart->insert($data);
			echo json_encode(array('response' => true, 'msg' => 'BERHASIL!'));
		}
	}

	function simpanCartPO(){
		$cekIdPo = $this->db->query("SELECT*FROM po_master GROUP BY id_po,id_perusahaan,no_po")->num_rows();
		if($_POST['option'] == 'update'){
			$idpo = $_POST['update_idpo'];
		}else{
			if($cekIdPo == 0){
				$idpo = 1;
			}else{
				$idpo = $cekIdPo + 1;
			}
		}

		// CEK PO APA MASIH ADA YANG PAKAI CUSTOMER LAIN
		$fnopo = $_POST['fno_po'];
		$cek = $this->db->query("SELECT*FROM po_master WHERE no_po='$fnopo' GROUP BY no_po");
		if($_POST['option'] == 'update'){ // UPDATE
			if(($_POST['fno_po'] != $_POST['lno_po']) && $cek->num_rows() > 0){
				echo json_encode(array('response' => false, 'msg' => 'NO. PO SUDAH TERPAKAI CUSTOMER LAIN!'));
			}else{
				$this->m_master->simpanCartPO($idpo);
				echo json_encode(array('response' => true, 'msg' => 'BERHASIL EDIT PO!'));
			}
		}else{ // SIMPAN
			if($cek->num_rows() > 0){
				echo json_encode(array('response' => false, 'msg' => 'NO. PO SUDAH TERPAKAI CUSTOMER LAIN!'));
			}else{
				$this->m_master->simpanCartPO($idpo);
				echo json_encode(array('response' => true, 'msg' => 'BERHASIL SIMPAN PO!'));
			}
		}
	}

	function hapusCartPO(){
		$data = array(
			'rowid' => $_POST['rowid'], 
			'qty' => 0,
		);
		$this->cart->update($data);
	}

	function dessCartPO() {
		$this->cart->destroy();
	}

	function showCartPO(){
		$html = '';
		if($this->cart->total_items() != 0){
			$html .= '<table style="width:100%;text-align:center;font-size:12px;color:#000;margin-top:15px">';
			$html .='<tr><td style="text-align:left;font-weight:bold" colspan="8">ADD ITEMS :</td></tr>
			<tr style="background:#e9e9e9">
				<td style="border:1px solid #888;width:5%;padding:5px;font-weight:bold">NO</td>
				<td style="border:1px solid #888;width:10%;padding:5px;font-weight:bold">AMBIL</td>
				<td style="border:1px solid #888;width:10%;padding:5px;font-weight:bold">JENIS</td>
				<td style="border:1px solid #888;width:10%;padding:5px;font-weight:bold">GSM</td>
				<td style="border:1px solid #888;width:10%;padding:5px;font-weight:bold">UKURAN</td>
				<td style="border:1px solid #888;width:10%;padding:5px;font-weight:bold">TONASE</td>
				<td style="border:1px solid #888;width:10%;padding:5px;font-weight:bold">JML ROLL</td>
				<td style="border:1px solid #888;width:10%;padding:5px;font-weight:bold">HARGA</td>
				<td style="border:1px solid #888;width:25%;padding:5px;font-weight:bold">AKSI</td>
			</tr>';
		}

		$i = 0;
		foreach($this->cart->contents() as $r){
			$i++;
			$html .='<tr>
				<td style="border:1px solid #888;padding:5px;text-align:center">'.$i.'</td>
				<td style="border:1px solid #888;padding:5px">'.$r['options']['txt_status_roll'].'</td>
				<td style="border:1px solid #888;padding:5px">'.$r['options']['fjenis'].'</td>
				<td style="border:1px solid #888;padding:5px">'.$r['options']['fgsm'].'</td>
				<td style="border:1px solid #888;padding:5px">'.round($r['options']['fukuran'], 2).'</td>
				<td style="border:1px solid #888;padding:5px">'.number_format($r['options']['ftonase']).'</td>
				<td style="border:1px solid #888;padding:5px">'.$r['options']['fjmlroll'].'</td>
				<td style="border:1px solid #888;padding:5px">Rp. '.number_format($r['options']['fharga']).'</td>
				<td style="border:1px solid #888;padding:5px"><button onclick="hapusCartPO('."'".$r['rowid']."'".')">Batal</button></td>
			</tr>';
		}
		
		if($this->cart->total_items() != 0){
			$html .= '</table>';
		}

		echo $html;
	}

	function editPO(){
		$id = $_POST['id'];
		$id_po = $_POST['id_po'];
		$no_po = $_POST['no_po'];
		$cek = $this->db->query("SELECT * FROM m_perusahaan p INNER JOIN po_master m ON p.id=m.id_perusahaan
		WHERE p.id='$id' AND m.id_po='$id_po' AND m.no_po='$no_po' AND m.status='open'
		GROUP BY p.id,m.id_po,m.no_po")->row();
		echo json_encode(array(
			'id' => $cek->id,
			'tgl' => $cek->tgl,
			'pajak' => $cek->pajak,
			'pimpinan' => $cek->pimpinan,
			'nm_perusahaan' => $cek->nm_perusahaan,
			'alamat' => $cek->alamat,
			'no_telp' =>$cek->no_telp,
			'id_po' => $cek->id_po,
			'no_po' => $cek->no_po,
		));
	}

	function cekEditPO(){
		$id = $_POST['id'];
		$id_po = $_POST['id_po'];
		$no_po = $_POST['no_po'];
		$cek = $this->db->query("SELECT*FROM pl p INNER JOIN m_timbangan m ON p.id=m.id_pl WHERE p.id_perusahaan='$id' AND p.no_po='$no_po'
		GROUP BY p.id_perusahaan,p.no_po");
		if($cek->num_rows() == 0){
			$edit = false;
			$background = '#fff';
			$no_po = $no_po;
		}else{
			$edit = true;
			$background = '#e9e9e9';
			$no_po = $cek->row()->no_po;
		}
		echo json_encode(array(
			'dd' => $edit,
			'bg' => $background,
			'no_po' => $no_po,
		));
	}

	function loadItemPO(){
		$id = $_POST['id'];
		$id_po = $_POST['id_po'];
		$no_po = $_POST['no_po'];
		$i = $_POST['i'];
		$html = '';

		$getData = $this->db->query("SELECT*FROM po_master
		WHERE id_perusahaan='$id' AND id_po='$id_po' AND no_po='$no_po'
		ORDER BY nm_ker,g_label,width");
		$html .= '<table style="width:100%;font-size:12px;color:#000;text-align:center;margin-top:15px">';
		$html .='<tr><td style="text-align:left;font-weight:bold" colspan="8">LIST ITEMS :</td></tr>
		<tr style="background:#e9e9e9">
			<td style="border:1px solid #888;width:5%;padding:5px;font-weight:bold">NO</td>
			<td style="border:1px solid #888;width:10%;padding:5px;font-weight:bold">AMBIL</td>
			<td style="border:1px solid #888;width:10%;padding:5px;font-weight:bold">JENIS</td>
			<td style="border:1px solid #888;width:10%;padding:5px;font-weight:bold">GSM</td>
			<td style="border:1px solid #888;width:10%;padding:5px;font-weight:bold">WIDTH</td>
			<td style="border:1px solid #888;width:10%;padding:5px;font-weight:bold">TON</td>
			<td style="border:1px solid #888;width:10%;padding:5px;font-weight:bold">ROLL</td>
			<td style="border:1px solid #888;width:10%;padding:5px;font-weight:bold">HARGA</td>
			<td style="border:1px solid #888;width:25%;padding:5px;font-weight:bold">AKSI</td>
		</tr>';
		$i = 0;
		foreach($getData->result() as $r){
			$i++;
			// CEK JIKA UKURAN SUDAH TERJUAL TIDAK BISA DIEDIT / HAPUS
			$cek = $this->db->query("SELECT*FROM pl p
			INNER JOIN m_timbangan m ON p.id=m.id_pl
			WHERE p.id_perusahaan='$id' AND p.no_po='$no_po' AND m.nm_ker='$r->nm_ker' AND m.g_label='$r->g_label' AND m.width='$r->width' AND p.qc='ok'
			GROUP BY p.id_perusahaan,p.no_po,p.qc,m.nm_ker,m.g_label,width");
			$edit = '<button class="btn-item-po-'.$i.'" onclick="editItemPO('."'".$r->id."'".','."'".$id."'".','."'".$id_po."'".','."'".$no_po."'".','."'".$r->nm_ker."'".','."'".$r->g_label."'".','."'".$r->width."'".','."'".$i."'".')">EDIT</button>';
			if($cek->num_rows() == 0){
				if($r->id_perusahaan == 210){
					$disA = '';
				}else{
					$disA = 'disabled';
				}
				$dis = '';
				$btn ='<td style="border:1px solid #888;padding:5px">
					'.$edit.'
					<button onclick="hapusItemPO('."'".$r->id."'".','."'".$id."'".','."'".$id_po."'".','."'".$no_po."'".','."'".$r->nm_ker."'".','."'".$r->g_label."'".','."'".$r->width."'".','."'".$i."'".')">HAPUS</button>
				</td>';
			}else{
				$disA = 'disabled';
				$dis ='disabled';
				$btn ='<td style="border:1px solid #888;padding:5px">'.$edit.'</td>';
			}

			if($r->status_roll == 0){
				$statusRoll = 'STOK';
			}else{
				$statusRoll = 'BUFFER';
			}
			$html .='<tr class="itr">
				<td style="border:1px solid #888;padding:5px">'.$i.'</td>
				<td style="border:1px solid #888;position:relative">
					<input type="text" id="wambil-'.$i.'" value="'.$statusRoll.'" class="inp-abs" onkeypress="return hHuruf(event)" maxlength="6" '.$disA.'>
				</td>
				<td style="border:1px solid #888;position:relative">
					<input type="text" id="wnmker-'.$i.'" value="'.$r->nm_ker.'" class="inp-abs" onkeypress="return hHuruf(event)" maxlength="2" '.$dis.'>
				</td>
				<td style="border:1px solid #888;position:relative">
					<input type="text" id="wglabel-'.$i.'" value="'.$r->g_label.'" class="inp-abs" onkeypress="return hAngka(event)" maxlength="3" '.$dis.'>
				</td>
				<td style="border:1px solid #888;position:relative">
					<input type="text" id="wwidth-'.$i.'" value="'.round($r->width, 2).'" class="inp-abs" onkeypress="return aKt(event)" maxlength="6" '.$dis.'>
				</td>
				<td style="border:1px solid #888;position:relative">
					<input type="text" id="etonase-'.$i.'" value="'.$r->tonase.'" class="inp-abs" onkeypress="return hAngka(event)" maxlength="8">
				</td>
				<td style="border:1px solid #888;position:relative">
					<input type="text" id="ejmlroll-'.$i.'" value="'.$r->jml_roll.'" class="inp-abs" onkeypress="return hAngka(event)" maxlength="3">
				</td>
				<td style="border:1px solid #888;position:relative">
					<input type="text" id="eharga-'.$i.'" value="'.$r->harga.'" class="inp-abs" onkeypress="return hAngka(event)" maxlength="8">
				</td>
				'.$btn.'';
			$html .='</tr>';
		}
		$html .='</table>';

		echo $html;
	}

	function editItemPO(){
		$id = $_POST['id'];
		$id_pt = $_POST['id_pt'];
		$id_po = $_POST['id_po'];
		$no_po = $_POST['no_po'];
		$nm_ker = $_POST['nm_ker'];
		$g_label = $_POST['g_label'];
		$width = $_POST['width'];
		$i = $_POST['i'];
		$wambil = $_POST['wambil'];
		$wnmker = $_POST['wnmker'];
		$wglabel = $_POST['wglabel'];
		$wwidth = $_POST['wwidth'];
		$etonase = $_POST['etonase'];
		$ejmlroll = $_POST['ejmlroll'];
		$eharga = $_POST['eharga'];
		// 521 - 8 - CMBP4 - 76A/PURC.CMBP/11/22 - MH - 110 - 170.00
		$cek1 = $this->db->query("SELECT*FROM po_master
		WHERE id_perusahaan='$id_pt' AND id_po='$id_po' AND no_po='$no_po' AND nm_ker='$wnmker' AND g_label='$wglabel' AND width='$wwidth'
		GROUP BY id_perusahaan,id_po,nm_ker,g_label,width");
		if(($nm_ker != $wnmker || $g_label != $wglabel || $width != $wwidth) && $cek1->num_rows() > 0){
				echo json_encode(array('response' => true, 'msg' => 'JENIS / GSM / UKURAN SUDAH ADA!', 'info' => 'error',));
		}else if($wambil == '' || $wnmker == '' || $wglabel == '' || $wwidth == '' || $etonase == '' || $ejmlroll == '' || $eharga == ''){
			echo json_encode(array('response' => true, 'msg' => 'TIDAK BOLEH ADA YANG KOSONG!', 'info' => 'error',));
		}else{
			$this->m_master->editItemPO();
			echo json_encode(array(
				'response' => true,
				'msg' => 'BERHASIL EDIT!',
				'info' => 'success',
			));
		}
	}

	function hapusItemPO(){
		$this->m_master->delete("po_master", "id", $_POST['id']);
		echo json_encode(array(
			'response' => true,
			'msg' => 'BERHASIL DIHAPUS!',
		));
	}

	function loadDataAdmin(){
		$otorisasi = $_POST['otorisasi'];
		$html ='';

		$html .='<table style="width:100%;border-color:#ccc" border="1">
		<tr>
			<td style="width:5%;padding:5px;font-weight:bold;text-align:center;background:#eee">NO</td>
			<td style="width:auto;padding:5px;font-weight:bold;background:#eee">USERNAME</td>
			<td style="width:auto;padding:5px;font-weight:bold;background:#eee">NAMA USER</td>
			<td style="width:auto;padding:5px;font-weight:bold;background:#eee">LEVEL</td>
			<td style="width:auto;padding:5px;font-weight:bold;background:#eee">LOGIN TERAKHIR</td>
			<td style="width:auto;padding:5px;font-weight:bold;background:#eee">AKSI</td>
		</tr>';

		#all admin qc fg user
		if($otorisasi == 'all'){
			$lvl = "";
		}else if($otorisasi == 'admin'){
			$lvl = "WHERE level='Admin'";
		}else if($otorisasi == 'qc'){ // qc + rewind 1 + 2
			$lvl = "WHERE (level='QC' OR level='Rewind1' OR level='Rewind2')";
		}else if($otorisasi == 'fg'){
			$lvl = "WHERE level='FG'";
		}else if($otorisasi == 'office'){
			$lvl = "WHERE level='Office'";
		}else if($otorisasi == 'finance'){
			$lvl = "WHERE level='Finance'";
		}else if($otorisasi == 'cor'){
			$lvl = "WHERE level='Corrugated'";
		}else{
			$lvl = "WHERE level='User'";
		}
		$getData = $this->db->query("SELECT*FROM user $lvl ORDER BY level");
		$i = 0;
		foreach($getData->result() as $r){
			$i++;
			$html .='<tr class="list-table">
				<td style="padding:5px;text-align:center">'.$i.'</td>
				<td style="padding:5px">'.$r->username.'</td>
				<td style="padding:5px">'.$r->nm_user.'</td>
				<td style="padding:5px">'.$r->level.'</td>
				<td style="padding:5px">'.$r->last_login.'</td>';

			// $username = $this->session->userdata('username');
			if($r->username == 'developer'){
				$html .='<td style="padding:5px">-</td>';
			}else if($r->logout == '0000-00-00 00:00:00'){
				$html .='<td style="padding:5px">-</td>';
			}else{
				if($this->session->userdata('level') == 'SuperAdmin'){
					$btnHps = ' - <button onclick="hapusUser('."'".$r->id."'".','."'".$r->username."'".','."'".$r->nm_user."'".')" class="btn bg-red btn-sm waves-effect" style="font-weight:bold">HAPUS</button>';
				}else{
					$btnHps = '';
				}

				$usr = $this->session->userdata('username');
				$cek = $this->db->query("SELECT*FROM user WHERE username='$usr' AND (id='5' OR id='4' OR id='6' OR id='18')");
				if($cek->num_rows() > 0) {
					$html .='<td style="padding:5px">
					<button onclick="editUser('."'".$r->id."'".')" class="btn bg-orange btn-sm waves-effect" style="font-weight:bold">EDIT</button>'.$btnHps.'
					</td>';
				}else{
					$html .='<td style="padding:5px">-</td>';
				}
			}
			$html .='</tr>';
		}

		$html .='</table>';

		echo $html;
	}

	function simpanAdministrator(){
		$username = trim($_POST['username']);
		$lusername = trim($_POST['lusername']);
		$nama_user = $_POST['nama_user'];
		$password = trim($_POST['password']);
		$status = $_POST['status'];
		$cekUsername = $this->db->query("SELECT username FROM user WHERE username='$username'");

		if(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
			echo json_encode(array('data' => false, 'msg' => 'USERNAME HANYA BOLEH ANGKA DAN HURUF!'));
		}else if(!preg_match("/^[a-zA-Z ]*$/",$nama_user)){
			echo json_encode(array('data' => false, 'msg' => 'USERNAME HANYA BOLEH HURUF!'));
		}else if($cekUsername->num_rows() > 0 && $status == 'insert'){
			echo json_encode(array('data' => false, 'msg' => 'USERNAME SUDAH ADA!'));
		}
		// else if($username != $lusername && $cekUsername->num_rows() > 0 && $status == 'update'){
		// 	echo json_encode(array('data' => false, 'msg' => 'USERNAME SUDAH ADA!'));
		// }
		else if(!preg_match("/^[a-zA-Z0-9]*$/",$password)){
			echo json_encode(array('data' => false, 'msg' => 'PASSWORD HANYA BOLEH ANGKA DAN HURUF!'));
		}else{
			$this->m_master->simpanAdministrator();
			$fixuser = $this->db->query("SELECT * FROM user WHERE username='$username'");
			if($status == 'insert'){
				echo json_encode(array('data' => true, 'msg' => 'BERHASIL TAMBAH USER!', 'user' => $fixuser->row()));
			}else{ // update
				echo json_encode(array('data' => true, 'msg' => 'BERHASIL UPDATE USER!', 'user' => $fixuser->row()));
			}
		}
	}

	function loadSelectLevelAdministrator(){
		$otorisasi = $_POST['otorisasi'];
		$html = '';
		#all admin qc fg user
		if($otorisasi == 'all'){
			$lvl = "";
		}else if($otorisasi == 'admin'){
			$lvl = "WHERE level='Admin'";
		}else if($otorisasi == 'qc'){ // qc + rewind 1 + 2
			$lvl = "WHERE (level='QC' OR level='Rewind1' OR level='Rewind2')";
		}else if($otorisasi == 'fg'){
			$lvl = "WHERE level='FG'";
		}else if($otorisasi == 'cor'){ 
			$lvl = "WHERE level='Corrugated'";
		}else{
			$lvl = "WHERE level='User'";
		}

		$html .='<option value="">PILIH</option>';
		if($lvl == ''){
			$html .='
				<option value="SuperAdmin">SuperAdmin</option>
				<option value="Admin">Admin</option>
				<option value="Finance">Finance</option>
				<option value="Office">Office</option>
				<option value="QC">QC</option>
				<option value="FG">FG</option>
				<option value="Rewind1">Rewind1</option>
				<option value="Rewind2">Rewind2</option>
				<option value="Corrugated">Corrugated</option>
			';
		}else{
			$getLevel = $this->db->query("SELECT level FROM user $lvl GROUP BY level");
			foreach($getLevel->result() as $lvl){
				$html .='<option value="'.$lvl->level.'">'.$lvl->level.'</option>';
			}
		}
		echo $html;
	}

	function editAdministrator(){
		$id = $_POST['id'];
		$getIdUser = $this->db->query("SELECT*FROM user WHERE id='$id'")->row();
		echo json_encode(
			array(
				'id' => $getIdUser->id,
				'username' => $getIdUser->username,
				'nm_user' => $getIdUser->nm_user,
				// 'password' => $getIdUser->password,
				'level' => $getIdUser->level,
			)
		);
	}

	function hapusAdminstrator(){
		$id = $_POST['id'];
		$this->m_master->delete("user", "id", $id);
		echo "1";
	}

	function loadDataPO(){
		$opsi = $_POST['opsi'];
		$caripo = $_POST['caripo'];
		$otorisasi = $_POST['otorisasi'];
		$html = '';
		
		// KHUSUS COR
		if($otorisasi == 'cor'){
			$getData = $this->db->query("SELECT pt.pimpinan,pt.nm_perusahaan,pt.alamat,m.* FROM po_master m
			INNER JOIN m_perusahaan pt ON m.id_perusahaan=pt.id
			WHERE status='$opsi' AND m.id_perusahaan='210'
			GROUP BY id_perusahaan
			ORDER BY pt.pimpinan,pt.nm_perusahaan");
		}else{
			$getData = $this->db->query("SELECT pt.pimpinan,pt.nm_perusahaan,pt.alamat,m.* FROM po_master m
			INNER JOIN m_perusahaan pt ON m.id_perusahaan=pt.id
			WHERE status='$opsi' AND (pt.pimpinan LIKE '%$caripo%' OR pt.nm_perusahaan LIKE '%$caripo%')
			GROUP BY id_perusahaan
			ORDER BY pt.pimpinan,pt.nm_perusahaan");
		}

		if($getData->num_rows() == 0){
			$html .='<div style="padding:5px">DATA TIDAK ADA!</div>';
		}else{
			$i = 0;
			foreach($getData->result() as $r){
				if($r->pimpinan == '-' || $r->pimpinan == ''){
					$nama = '';
				}else{
					$nama = $r->pimpinan.' - ';
				}
				if($r->nm_perusahaan == '-' && $r->nm_perusahaan == ''){
					$kop = '';
				}else{
					$kop = $r->nm_perusahaan;
				}
				$i++;
				$html .='<table style="font-size:12px;color:#000">';
				$html .='<tr class="ll-tr">
					<td style="padding:5px">
						<button class="btn-c-po" onclick="btnCek('."'".$r->id_perusahaan."'".','."'".$opsi."'".','."'".$i."'".')">DETAIL</button>
					</td>
					<td style="padding:5px">'.$i.'.</td>
					<td style="padding:5px">'.$nama.$kop.'</td>
				</tr>';
				$html .='</table>';

				$html.='<div class="btn-cek btn-cek-list-'.$i.'"></div>';
				$html.='<div class="btn-cek btn-cek-list-rekap-'.$i.'"></div>';
			}
		}
		echo $html;
	}

	function btnCekRekap(){
		$id = $_POST['id'];
		$opsi = $_POST['opsi'];
		$html ='';

		$html .='<div style="overflow:auto;white-space:nowrap"><table style="margin:10px 5px;font-size:12px;color:#000" border="1">';
		$html .='<tr style="background:#e9e9e9">
			<td style="padding:5px;font-weight:bold;text-align:center">NO</td>
			<td style="padding:5px;font-weight:bold;text-align:center">NO. PO</td>
			<td style="padding:5px;font-weight:bold;text-align:center">T(ROLL)</td>
			<td style="padding:5px;font-weight:bold;text-align:center">T(BERAT)</td>
			<td style="padding:5px;font-weight:bold;text-align:center">P(ROLL)</td>
			<td style="padding:5px;font-weight:bold;text-align:center">P(BERAT)</td>
			<td style="padding:5px;font-weight:bold;text-align:center">-/+(ROLL)</td>
			<td style="padding:5px;font-weight:bold;text-align:center">-/+(BERAT)</td>
		</tr>';
		$getDatar = $this->db->query("SELECT id_po,no_po,status,SUM(jml_roll) AS jml_roll,SUM(tonase) AS tonase FROM po_master
		WHERE id_perusahaan='$id' AND status='$opsi'
		GROUP BY id_po,no_po,status");
		$i = 0;
		$totRoll = 0;
		$totBerat = 0;
		$totKirRoll = 0;
		$totKirBerat = 0;
		$totPminRoll = 0;
		$totPminBerat = 0;
		foreach($getDatar->result() as $r){
			$i++;
			$html .='<tr>
				<td style="padding:5px;text-align:center">'.$i.'</td>
				<td style="padding:5px">'.$r->no_po.'</td>
				<td style="padding:5px;text-align:right">'.number_format($r->jml_roll).'</td>
				<td style="padding:5px;text-align:right">'.number_format($r->tonase).'</td>';
			$getKiriman = $this->db->query("SELECT po.id_po,po.no_po,po.id_perusahaan,po.nm_ker,po.g_label,po.width,po.tonase,po.jml_roll,COUNT(t.roll) AS pjmlroll,SUM(t.weight - t.seset) AS totkirpseset FROM po_master po
			LEFT JOIN pl p ON po.no_po=p.no_po AND po.id_perusahaan=p.id_perusahaan
			LEFT JOIN m_timbangan t ON p.id=t.id_pl AND po.nm_ker=t.nm_ker AND po.g_label=t.g_label AND po.width=t.width
			WHERE po.id_perusahaan='$id' AND po.no_po='$r->no_po' AND po.status='$opsi'
			GROUP BY po.id_po,po.no_po,po.id_perusahaan,po.nm_ker,po.g_label,po.width");
			$kirRoll = 0;
			$kirBerat = 0;
			$pminRoll = 0;
			$pminBerat = 0;
			foreach($getKiriman->result() as $kir){
				if($kir->totkirpseset == null){
					$totkirpseset = 0;
				}else{
					$totkirpseset = $kir->totkirpseset;
				}
				$kurangRoll = $kir->pjmlroll - $kir->jml_roll;
				$kurangBerat = $totkirpseset - $kir->tonase;

				// JIKA LEBIH DARI PO HILANGKAN
				if($kir->pjmlroll >= $kir->jml_roll){
					$fxRoll = 0;
				}else{
					$fxRoll = $kurangRoll;
				}
				if($totkirpseset >= $kir->tonase){
					$fxBerat = 0;
				}else{
					$fxBerat = $kurangBerat;
				}

				$kirRoll += $kir->pjmlroll;
				$kirBerat += $totkirpseset;
				$pminRoll += $fxRoll;
				$pminBerat += $fxBerat;
			}
			// JIKA BELUM ADA KIRIMAN
			if($getKiriman->num_rows() == 0){
				$kRoll = $r->jml_roll;
				$kTonn = $r->tonase;
			}else{	
				$kRoll = 0;
				$kTonn = 0;
			}
			$html .='<td style="padding:5px;text-align:right">'.number_format($kirRoll).'</td>
				<td style="padding:5px;text-align:right">'.number_format($kirBerat).'</td>
				<td style="padding:5px;text-align:right">'.number_format($pminRoll - $kRoll).'</td>
				<td style="padding:5px;text-align:right">'.number_format($pminBerat - $kTonn).'</td>
			</tr>';

			$totRoll += $r->jml_roll;
			$totBerat += $r->tonase;
			$totKirRoll += $kirRoll;
			$totKirBerat += $kirBerat;
			$totPminRoll += $pminRoll - $kRoll;
			$totPminBerat += $pminBerat - $kTonn;
		}
		// TOTAL
		$html .='<tr style="background:#e9e9e9;text-align:center;font-weight:bold">
			<td style="padding:5px" colspan="2">TOTAL</td>
			<td style="padding:5px">'.number_format($totRoll).'</td>
			<td style="padding:5px">'.number_format($totBerat).'</td>
			<td style="padding:5px">'.number_format($totKirRoll).'</td>
			<td style="padding:5px">'.number_format($totKirBerat).'</td>
			<td style="padding:5px">'.number_format($totPminRoll).'</td>
			<td style="padding:5px">'.number_format($totPminBerat).'</td>
		</tr>';

		$html .='</table></div>';
		echo $html;
	}

	function btnCekShow(){ // btn-cek-list-
		$id = $_POST['id'];
		$opsi = $_POST['opsi'];
		$li = $_POST['i'];
		$html = '';

		$getData = $this->db->query("SELECT id_po,no_po,status,pajak FROM po_master
		WHERE id_perusahaan='$id' AND status='$opsi'
		-- GROUP BY id_po,no_po,status,pajak
		GROUP BY pajak,tgl,no_po,STATUS,id_po");
		$i =0;
		$html .='<div style="overflow:auto;white-space:nowrap">';
		foreach($getData->result() as $r){
			$i++;
			// CEK JIKA ADA PACKINGLIST OK
			$cek = $this->db->query("SELECT*FROM pl a
			INNER JOIN m_timbangan m ON a.id=m.id_pl
			WHERE a.id_perusahaan='$id' AND a.no_po='$r->no_po' AND qc='ok'
			GROUP BY a.id_perusahaan,a.no_po");
			if($opsi == 'open'){
				$edit = '<button class="btn-c-po" onclick="editPO('."'".$id."'".','."'".$r->id_po."'".','."'".$r->no_po."'".','."'".$i."'".')">edit</button>';
				if($cek->num_rows() == 0){
					// CEK LAGI KALAU ADA PACKING LIST ATAU RENCANA KIRIM TIDAK BISA HAPUS
					$cek2 = $this->db->query("SELECT*FROM pl WHERE id_perusahaan='$id' AND no_po='$r->no_po' GROUP BY no_po;");
					if($cek2->num_rows() == 0){
						$aksi = $edit.' <button class="btn-c-po" onclick="hapusPO('."'".$id."'".','."'".$r->id_po."'".','."'".$r->no_po."'".','."'".$i."'".')">hapus</button>';
					}else{
						$aksi = '';
					}
				}else{
					$aksi = $edit.' <button class="btn-c-po" onclick="closePO('."'".$id."'".','."'".$r->id_po."'".','."'".$r->no_po."'".','."'".$i."'".')">close</button>';
				}
			}else{ //CLOSE TIDAK ADA AKSI
				$aksi = '';
			}
			$html .='<table style="font-size:12px;color:#000">
				<tr class="ll-tr">
					<td style="padding:5px">-</td>
					<td style="padding:5px"><button disabled>'.$r->pajak.'</button></td>
					<td style="padding:5px">'.$r->no_po.'</td>
					<td style="padding:5px">
						<button class="btn-c-po" onclick="btnOpen('."'".$id."'".','."'".$r->id_po."'".','."'".$r->no_po."'".','."'".$opsi."'".','."'".$i."'".')">open</button>
						'.$aksi.'
					</td>
				</tr>
			</table>';

			$html .='<div class="ll-open btn-open-list-'.$i.'"></div>';
		}
		$html .='<div style="padding:5px;font-size:12px;color:#000"><button class="btn-c-po" onclick="btnCekRekap('."'".$id."'".','."'".$opsi."'".','."'".$li."'".')">REKAP</button></div>';
		$html .='</div>';

		echo $html;
	}

	function hapusPO(){
		// 3 - 40 - TESTPO/NON/PPN - 1
		$id = $_POST['id'];
		$no_po = $_POST['no_po'];
		// CEK LAGI PO NYA
		$cek = $this->db->query("SELECT*FROM pl a
		INNER JOIN m_timbangan m ON a.id=m.id_pl
		WHERE a.id_perusahaan='$id' AND a.no_po='$no_po' AND qc='ok'
		GROUP BY a.id_perusahaan,a.no_po");
		if($cek->num_rows() == 0){
			$this->m_master->hapusPO();
			echo json_encode(array('res' => true, 'msg' => 'BERHASIL HAPUS PO!'));
		}else{
			echo json_encode(array('res' => false, 'msg' => 'GAGAL HAPUS PO!'));
		}
	}

	function closePO() {
		$return = $this->m_master->closePO();
		echo json_encode(array('res' => $return, 'msg' => $_POST['no_po'].' BERHASIL DI CLOSE!'));
	}

	function loadDataExpedisi(){
		$cari = $_POST['cari'];
		$html = '';
		$getData = $this->db->query("SELECT*FROM m_expedisi
		WHERE (plat LIKE '%$cari%' OR merk_type LIKE '%$cari%' OR pt LIKE '%$cari%' OR supir LIKE '%$cari%')
		ORDER BY plat,merk_type,pt,supir");

		$html .='<div style="margin-top:15px;color:#000;font-size:12px;overflow:auto;white-space:nowrap;">';
		if($getData->num_rows() == 0){
			$html .='<div style="font-weight:bold">DATA TIDAK DITEMUKAN!</div>';
		}else{
			$html .='<table style="width:100%" border="1">';
			$html .='<tr style="background:#e9e9e9;font-weight:bold;text-align:center">
				<td style="padding:5px">NO.</td>
				<td style="padding:5px">NO. POLISI</td>
				<td style="padding:5px">MERK / TYPE</td>
				<td style="padding:5px">PT</td>
				<td style="padding:5px">SUPIR</td>
				<td style="padding:5px">NO. HP</td>
				<td style="padding:5px">AKSI</td>
			</tr>';
			$i = 0;
			foreach($getData->result() as $r){
				$i++;
				$bO = '<button class="tmbl-cek-roll" onclick="cekEkspedisiKirim('."'".$r->id."'".')">';
				$bC = '</button>';
				$html .='<tr class="list-table">
					<td style="padding:5px;text-align:center">'.$bO.$i.$bC.'</td>
					<td style="padding:5px">'.$bO.$r->plat.$bC.'</td>
					<td style="padding:5px">'.$bO.$r->merk_type.$bC.'</td>
					<td style="padding:5px">'.$bO.$r->pt.$bC.'</td>
					<td style="padding:5px">'.$bO.$r->supir.$bC.'</td>
					<td style="padding:5px">'.$bO.$r->no_telp.$bC.'</td>';
				// CEK KALO SUDAH MASUK KE PACKING LIST TIDAK BISA HAPUS
				$cekNoPol = $this->db->query("SELECT*FROM m_expedisi ex INNER JOIN pl p ON ex.id=p.id_expedisi
				WHERE ex.id='$r->id'");
				if($cekNoPol->num_rows() == 0){
					$aksi = '<button onclick="editExpedisi('."'".$r->id."'".')">Edit</button>
					<button onclick="hapusExpedisi('."'".$r->id."'".','."'".$r->plat."'".')">Hapus</button>';
				}else{
					$aksi = '-';
				}
				$html .='<td style="padding:5px;text-align:center">'.$aksi.'</td></tr>';
			}
			$html .='</table>';
		}
		$html .='</div>';
		echo $html;
	}

	function cekEkspedisiKirim(){
		$idex = $_POST['idex'];
		$html = '';
		$html .='<table style="color:#000;font-size:12px">';
		$html .='<tr style="font-weight:bold">
			<td style="padding:5px">NO</td>
			<td style="padding:5px">TANGGAL</td>
			<td style="padding:5px">CUSTOMER</td>
			<td style="padding:5px">JML. ROLL</td>
			<td style="padding:5px">TONASE</td>
		</tr>';
		
		$getData = $this->db->query("SELECT p.id_rk,id_expedisi,p.tgl,nm_perusahaan,nama,COUNT(t.roll) AS roll,SUM(weight - seset) AS kiriman FROM pl p
		INNER JOIN m_timbangan t ON p.id=t.id_pl
		WHERE id_expedisi='$idex'
		GROUP BY id_expedisi,p.id_perusahaan,p.tgl
		ORDER BY p.tgl");
		$i = 0;
		foreach($getData->result() as $r){
			$i++;

			if($r->nama != '-' && $r->nm_perusahaan == '-'){
				$nmpt = $r->nama;
			}else if($r->nama == '-' && $r->nm_perusahaan != '-'){
				$nmpt = $r->nm_perusahaan;
			}else{
				$nmpt = $r->nama.' - '.$r->nm_perusahaan;
			}
			$html .='<tr>
				<td style="padding:5px;text-align:center">'.$i.'</td>
				<td style="padding:5px">'.strtoupper($this->m_fungsi->tglInd_skt($r->tgl)).'</td>
				<td style="padding:5px">'.$nmpt.'</td>
				<td style="padding:5px;text-align:right">'.number_format($r->roll).'</td>
				<td style="padding:5px;text-align:right">'.number_format($r->kiriman).'</td>
			</tr>';
		}

		$html .='</table>';
		echo $html;
	}

	function simpanExpedisi(){
		$no_polisi1 = $_POST['no_polisi1'];
		$no_polisi2 = $_POST['no_polisi2'];
		$no_polisi3 = $_POST['no_polisi3'];
		$pt = $_POST['pt'];
		$nm_supir = $_POST['nm_supir'];
		$no_hp = $_POST['no_hp'];
		$status = $_POST['status'];

		// DATA LAMA
		$lsupir = $_POST['lsupir'];
		$lnopol = $_POST['lnopol'];

		$nopol = $no_polisi1.' '.$no_polisi2.' '.$no_polisi3;
		$cek = $this->db->query("SELECT*FROM m_expedisi WHERE supir='$nm_supir' AND plat='$nopol'");

		if(!preg_match("/^[A-Z]*$/",$no_polisi1)){
			echo json_encode(array('res' => false, 'msg' => 'KODE WILAYAH HANYA BOLEH HURUF!', 'info' => 'error'));
		}else if(!preg_match("/^[0-9]*$/",$no_polisi2)){
			echo json_encode(array('res' => false, 'msg' => 'NOMER POLISI HARUS ANGKA!', 'info' => 'error'));
		}else if(!preg_match("/^[A-Z]*$/",$no_polisi3)){
			echo json_encode(array('res' => false, 'msg' => 'KODE WILAYAH HANYA BOLEH HURUF!', 'info' => 'error'));
		}else if(!preg_match("/^[A-Z ]*$/",$pt)){
			echo json_encode(array('res' => false, 'msg' => 'NAMA PT HANYA BOLEH HURUF!', 'info' => 'error'));
		}else if(!preg_match("/^[A-Z ]*$/",$nm_supir)){
			echo json_encode(array('res' => false, 'msg' => 'NAMA SUPIR HANYA BOLEH HURUF!', 'info' => 'error'));
		}else if(!preg_match("/^[0-9 +-]*$/",$no_hp)){
			echo json_encode(array('res' => false, 'msg' => 'TIDAK SESUAI FORMAT NO. HP!', 'info' => 'error'));
		}else if($status == 'insert' && $cek->num_rows() > 0){
			// SIMPAN JIKA UBAH GANIT NOPOL SAMA SUPIR
			echo json_encode(array('res' => false, 'msg' => 'NAMA SUPIR DAN NO. POLISI SUDAH ADA!', 'info' => 'error'));
		}else if($status == 'update' && ($nm_supir != $lsupir || $nopol != $lnopol) && $cek->num_rows() > 0){
			// UPDATE JIKA UBAH GANIT NOPOL SAMA SUPIR
			echo json_encode(array('res' => false, 'msg' => 'NAMA SUPIR DAN NO. POLISI SUDAH TERPAKAI!', 'info' => 'error'));
		}else{ // SIMPAN
			$return = $this->m_master->simpanExpedisi();
			echo json_encode(array(
				'res' => $return,
				'msg' => 'BERHASIL '.strtoupper($status).' DATA!',
				'info' => 'success',
			));
		}
	}

	function editExpedisi(){
		$id = $_POST['id'];
		$getData = $this->db->query("SELECT*FROM m_expedisi WHERE id='$id'");
		echo json_encode(array(
			'res' => true,
			'data' => $getData->row(),
		));
	}

	function hapusExpedisi(){
		$id = $_POST['id'];
		$result = $this->m_master->delete("m_expedisi", "id", $id);
		echo json_encode(array(
			'res' => $result,
			'msg' => 'BERHASIL HAPUS',
		));
	}

	function packingListCek(){
		$idrk = $_GET['idrk'];
		$html = '';
		$html .='<table style="width:100%;font-size:11px;border-collapse:collapse;color:#000">
		<tr>
			<td style="width:15%"></td>
			<td style="width:1%"></td>
			<td style="width:84%"></td>
		</tr>
		<tr>
			<td style="font-weight:bold;text-align:center;text-decoration:underline" colspan="3">PACKING LIST CEK</td>
		</tr>';

		// HEADER
		$header = $this->db->query("SELECT a.*,b.nm_ker,COUNT(b.roll) AS roll FROM pl a
		INNER JOIN m_timbangan b ON a.id_rk=b.id_rk
		WHERE a.id_rk='$idrk'
		GROUP BY a.id_rk");

		$html .='<tr>
			<td style="padding:2px">ID RK</td>
			<td style="padding:2px">:</td>
			<td style="padding:2px">'.$header->row()->id_rk.'</td>
		</tr>
		<tr>
			<td style="padding:2px">RENCANA KIRIM</td>
			<td style="padding:2px">:</td>
			<td style="padding:2px">'.$header->row()->tgl_pl.'</td>
		</tr>
		<tr>
			<td style="padding:2px">CUSTOMER</td>
			<td style="padding:2px">:</td>
			<td style="padding:2px">'.$header->row()->nm_perusahaan.'</td>
		</tr>
		<tr>
			<td style="padding:2px">NAMA</td>
			<td style="padding:2px">:</td>
			<td style="padding:2px">'.$header->row()->nama.'</td>
		</tr>
		<tr>
			<td style="padding:2px">ALAMAT</td>
			<td style="padding:2px">:</td>
			<td style="padding:2px">'.$header->row()->alamat_perusahaan.'</td>
		</tr>';
		$html .='</table>';
		
		// ISI
		$html .='<table style="width:100%;font-size:11px;text-align:center;border-collapse:collapse;color:#000" cellpadding="5" border="1">';

		$kop_detail = $this->db->query("SELECT id_rk,nm_ker,COUNT(*) AS jml_roll,SUM(weight) AS berat,SUM(seset) AS seset FROM m_timbangan
		WHERE id_rk='$idrk' GROUP BY nm_ker ORDER BY nm_ker DESC");

		if($kop_detail->row()->nm_ker == 'WP'){
			$html .= '<tr>
				<th style="border:0;padding:2px 0;width:5%"></th>
				<th style="border:0;padding:2px 0;width:9%"></th>
				<th style="border:0;padding:2px 0;width:9%"></th>
				<th style="border:0;padding:2px 0;width:10%"></th>
				<th style="border:0;padding:2px 0;width:10%"></th>
				<th style="border:0;padding:2px 0;width:10%"></th>
				<th style="border:0;padding:2px 0;width:10%"></th>
				<th style="border:0;padding:2px 0;width:10%"></th>
				<th style="border:0;padding:2px 0;width:27%"></th>
			</tr>';
			$cs = '4';
		}else{
			$html .= '<tr>
				<th style="border:0;padding:2px 0;width:5%"></th>
				<th style="border:0;padding:2px 0;width:8%"></th>
				<th style="border:0;padding:2px 0;width:8%"></th>
				<th style="border:0;padding:2px 0;width:9%"></th>
				<th style="border:0;padding:2px 0;width:9%"></th>
				<th style="border:0;padding:2px 0;width:9%"></th>
				<th style="border:0;padding:2px 0;width:9%"></th>
				<th style="border:0;padding:2px 0;width:9%"></th>
				<th style="border:0;padding:2px 0;width:6%"></th>
				<th style="border:0;padding:2px 0;width:28%"></th>
			</tr>';
			$cs = '5';
		}

		$totalRoll = 0;
		$totalBerat = 0;
		foreach($kop_detail->result() as $kd){
			if($kd->nm_ker == 'MH' || $kd->nm_ker == 'MI' || $kd->nm_ker == 'MN'){
				$dkop = '<td style="border:1px solid #000;font-weight:bold">RCT</td>';
				$joint = 'JNT';
			}else if($kd->nm_ker == 'BK' || $kd->nm_ker == 'BL'){
				$dkop = '<td style="border:1px solid #000;font-weight:bold">BI</td>';
				$joint = 'JNT';
			}else if($kd->nm_ker == 'WP'){
				$dkop = '';
				$joint = 'JOINT';
			}else{
				$dkop = '<td style="border:1px solid #000;font-weight:bold">-</td>';
				$joint = 'JNT';
			}

			if($kd->nm_ker == 'MH COLOR'){
				$tnmKer = 'MH C';
			}else{
				$tnmKer = $kd->nm_ker;
			}

			$html .= '<tr>
				<td style="border:1px solid #000;font-weight:bold">NO</td>
				<td style="border:1px solid #000;font-weight:bold" colspan="2">ROLL - '.$tnmKer.'</td>
				<td style="border:1px solid #000;font-weight:bold">BW</td>
				'.$dkop.'
				<td style="border:1px solid #000;font-weight:bold">GSM</td>
				<td style="border:1px solid #000;font-weight:bold">WIDTH</td>
				<td style="border:1px solid #000;font-weight:bold">BERAT</td>
				<td style="border:1px solid #000;font-weight:bold">'.$joint.'</td>
				<td style="border:1px solid #000;font-weight:bold">KETERANGAN</td>
			</tr>';

			// ISI
			$isiDetail = $this->db->query("SELECT*FROM m_timbangan WHERE id_rk='$kd->id_rk' AND (nm_ker='$kd->nm_ker') ORDER BY nm_ker DESC,g_label ASC,width ASC,roll ASC");

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

				if($r->nm_ker == 'MH' || $r->nm_ker == 'MI' || $r->nm_ker == 'MN'){
					$cek = '<td style="border:1px solid #000">'.$c_rct.'</td>';
				}else if($r->nm_ker == 'BK' || $r->nm_ker == 'BL'){
					$cek = '<td style="border:1px solid #000">'.$c_bi.'</td>';
				}else if($r->nm_ker == 'WP'){
					$cek = '';
				}else{
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

		$qrTotPL = $this->db->query("SELECT nm_ker,g_label,width,COUNT(roll) AS roll FROM m_timbangan WHERE id_rk='$idrk'
		GROUP BY nm_ker,g_label,nm_ker,width ORDER BY nm_ker DESC,g_label ASC,width ASC");
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
		$html .='</table>';

		// $count_p_pl = $this->db->query("SELECT*FROM m_timbangan WHERE id_rk='$idrk'")->num_rows();
		// if($count_p_pl >= 38){
			$this->m_fungsi->_mpdf2('',$html,10,10,10,'P','PL',3);
		// }else if($count_p_pl >= 35){
		// 	$this->m_fungsi->_mpdf2('',$html,10,10,10,'P','PL',2);
		// }else if($count_p_pl >= 34){
		// 	$this->m_fungsi->_mpdf2('',$html,10,10,10,'P','PL',1);
		// }else if($count_p_pl <tr 34){
		// 	$this->m_fungsi->_mpdf2('',$html,10,10,10,'P','PL',0);
		// }

		// echo $html;
	}

	function loadDataOFG(){
		$jenis = $_POST['jenis'];
		$otfg = $_POST['otfg'];
		$otorisasi = $_POST['otorisasi'];
		$html = '';

		// mh bk mhbk nonspek wp all
		if($jenis == 'mh'){
			$nmKer = "AND nm_ker='MH'";
		}else if($jenis == 'bk'){
			$nmKer = "AND nm_ker='BK'";
		}else if($jenis == 'mhbk'){
			$nmKer = "AND (nm_ker='MH' OR nm_ker='BK')";
		}else if($jenis == 'nonspek'){
			$nmKer = "AND nm_ker='MN'";
		}else if($jenis == 'wp'){
			$nmKer = "AND nm_ker='WP'";
		}else{
			$nmKer = "";
		}

		$html .='<table style="font-size:12px;color:#000;text-align:center" border="1">';
		// INTI DATA
		$getNmKer = $this->db->query("SELECT nm_ker FROM po_master
		WHERE status='open' $nmKer AND status_roll='0'
		GROUP BY nm_ker");
		if($getNmKer->num_rows() == 0){
			$html .='<td style="padding:5px">TIDAK ADA DATA</td>';
		}else{
			$html .='<tr style="background:#e9e9e9;font-weight:bold">
			<td style="padding:5px" rowspan="2">NO</td>
			<td style="padding:5px" rowspan="2">Ukuran</td>';

			// TAMPIL JENIS KERTAS
			foreach($getNmKer->result() as $ker){
				$getgLabel = $this->db->query("SELECT nm_ker,g_label FROM po_master
				WHERE status='open' AND nm_ker='$ker->nm_ker' AND status_roll='0'
				GROUP BY nm_ker,g_label");
				$html .='<td style="padding:5px" colspan="'.$getgLabel->num_rows().'">'.$ker->nm_ker.'</td>';
			}
			$html .='</tr>';
			
			// TAMPIL GSM
			$html .='<tr>';
			foreach($getNmKer->result() as $ker){
				$getgLabel = $this->db->query("SELECT nm_ker,g_label FROM po_master
				WHERE status='open' AND nm_ker='$ker->nm_ker' AND status_roll='0'
				GROUP BY nm_ker,g_label");
				foreach($getgLabel->result() as $glabel){
					$html .='<td style="padding:5px">'.$glabel->g_label.'</td>';
				}
			}
			$html .='</tr>';
			
			// TAMPIL UKURANNYA
			$html .='<tr>';
			$getUkuran = $this->db->query("SELECT width FROM po_master
			WHERE status='open' $nmKer AND status_roll='0'
			-- AND width between '95' AND '105'
			GROUP BY width;");
			$i = 0;
			foreach($getUkuran->result() as $uk){
				$i++;
				$html .='<td style="padding:5px">'.$i.'</td><td style="padding:5px">'.round($uk->width,2).'</td>';

				$getgLabel = $this->db->query("SELECT nm_ker,g_label FROM po_master
				WHERE status='open' $nmKer AND status_roll='0'
				GROUP BY nm_ker,g_label");
				foreach($getgLabel->result() as $lbl){
					// GET PO
					$getPO = $this->db->query("SELECT*FROM po_master
					WHERE status='open' AND nm_ker='$lbl->nm_ker' AND g_label='$lbl->g_label' AND width='$uk->width' AND status_roll='0'
					GROUP BY no_po");
					$jmlRoll = 0;
					// PILIHAN SISA OS / BERTUAN / TIDAK BERTUAN
					// GET PO
					foreach($getPO->result() as $nopo){
						// GET KIRIMAN
						$getKiriman = $this->db->query("SELECT COUNT(t.roll) AS kroll FROM m_timbangan t
						INNER JOIN pl p ON t.id_pl=p.id
						WHERE no_po='$nopo->no_po' AND t.nm_ker='$nopo->nm_ker' AND t.g_label='$nopo->g_label' AND width='$nopo->width'
						GROUP BY no_po,t.nm_ker,t.g_label,width");
						if($getKiriman->num_rows() == 0){
							$jmlroll = $nopo->jml_roll;
						}else{
							foreach($getKiriman->result() as $qk){
								if($qk->kroll >= $nopo->jml_roll){
									$jmlroll = 0;
								}else{
									$jmlroll = $nopo->jml_roll - $qk->kroll;
								}
							}
						}
						$jmlRoll += $jmlroll;
					}

					// GET UKURAN STOK
					$vWidth = 0;
					if($otfg == 'ofgtuan' || $otfg == 'ofgtdktuan'){
						$getWidth = $this->db->query("SELECT nm_ker,g_label,width,COUNT(width) as jml FROM m_timbangan
						WHERE nm_ker='$lbl->nm_ker' AND g_label='$lbl->g_label' AND width='$uk->width'
						AND status='0' AND id_pl='0'
						GROUP BY nm_ker,g_label,width");
						if($getWidth->num_rows() == 0){
							$vW = 0;
						}else{
							$vW = $getWidth->row()->jml;
						}
						$vWidth = $vW;
					}

					// SISA OS - BERTUAN - TIDAK BERTUAN
					if($otfg == 'ofg'){
						$tuanOrTidak = $jmlRoll;
					}else if($otfg == 'ofgtuan'){
						if($vWidth >= $jmlRoll){
							$tuanOrTidak = $jmlRoll;
						}else{
							$tuanOrTidak = 0;
						}
					}else{ // ofgtdktuan
						// if($vWidth >= $jmlRoll){
							$tuanOrTidak = $vWidth - $jmlRoll;
						// }else{
						// 	$tuanOrTidak = 0;
						// }
					}

					if(($lbl->nm_ker == 'MH' || $lbl->nm_ker == 'MI' || $lbl->nm_ker == 'ML') && ($tuanOrTidak == 0 || $tuanOrTidak <= 0) ){
						$gbLbl = '#ffc';
					}else if($lbl->nm_ker == 'MN' && ($tuanOrTidak == 0 || $tuanOrTidak <= 0)){
						$gbLbl = '#fcc';
					}else if(($lbl->nm_ker == 'BK' || $lbl->nm_ker == 'BL') && ($tuanOrTidak == 0 || $tuanOrTidak <= 0)){
						$gbLbl = '#ccc';
					}else if($lbl->nm_ker == 'WP' && ($tuanOrTidak == 0 || $tuanOrTidak <= 0)){
						$gbLbl = '#cfc';
					}else if($lbl->nm_ker == 'MH COLOR' && ($tuanOrTidak == 0 || $tuanOrTidak <= 0)){
						$gbLbl = '#ccf';
					}else{
						$gbLbl = '#fff';
					}

					$html .= '<td style="padding:5px;background:'.$gbLbl.'">
						<button style="background:transparent;font-weight:bold;margin:0;padding:0;border:0" onclick="cek('."'".$lbl->nm_ker."'".','."'".$lbl->g_label."'".','."'".$uk->width."'".','."'".$otorisasi."'".',0)">'.$tuanOrTidak.'</button>
					</td>';
				}
				$html .='</tr>';
			}

			$html .='</table>';
		}

		echo $html;
	}

	function LoadLaporanPengiriman(){
		$tgl1 = $_POST['tgl1'];
		$tgl2 = $_POST['tgl2'];
		$html = '';

		$html .='<table style="text-align:center" border="1">';
		$html .='<tr style="background:#e9e9e9;font-weight:bold">
			<td style="padding:5px">NO</td>
			<td style="padding:5px">HARI / TANGGAL</td>
			<td style="padding:5px">CUSTOMER</td>
			<td style="padding:5px">TONASE</td>
			<td style="padding:5px">GSM</td>
			<td style="padding:5px">UKURAN ROLL</td>
			<td style="padding:5px">JML ROLL</td>
			<td style="padding:5px">EKSPEDISI</td>
			<td style="padding:5px">NOPOL</td>
			<td style="padding:5px">DRIVER</td>
		</tr>';
		$getTgl = $this->db->query("SELECT tgl FROM pl
		WHERE qc='ok' AND tgl BETWEEN '$tgl1' AND '$tgl2'
		GROUP BY tgl;");
		$sumI = 0;
		foreach($getTgl->result() as $tgl){
			$getData = $this->db->query("SELECT p.tgl,p.id_expedisi,plat,pt,supir,p.id_perusahaan,p.nama,p.nm_perusahaan,COUNT(t.roll) AS roll,SUM(t.weight - t.seset) AS kiriman FROM m_timbangan t
			INNER JOIN pl p ON t.id_pl=p.id
			INNER JOIN m_expedisi ex ON p.id_expedisi=ex.id
			WHERE p.tgl='$tgl->tgl' AND p.nm_perusahaan!='LAMINASI PPI' AND p.nm_perusahaan!='CORRUGATED PPI' AND p.qc='ok'
			GROUP BY p.tgl,p.nama,p.nm_perusahaan,p.id_expedisi,p.id_perusahaan");
			$i = 0;
			$sumKiriman = 0;
			$sumRoll = 0;
			foreach($getData->result() as $r){
				$i++;
				$expTgl = explode("-", $r->tgl); //getHariIni

				if($r->id_perusahaan == 31){
					$dtl = '(TGR)';
				}else if($r->id_perusahaan == 32){
					$dtl = '(KRW)';
				}else if($r->id_perusahaan == 33){
					$dtl = '(CBT)';
				}else{
					$dtl = '';
				}
				if($r->nama != '-' && $r->nm_perusahaan == '-'){
					$nmpt = $r->nama;
				}else if($r->nama == '-' && $r->nm_perusahaan != '-'){
					$nmpt = $r->nm_perusahaan.$dtl;
				}else{
					$nmpt = $r->nm_perusahaan.$dtl.'<br>'.$r->nama;
				}

				$bo = '<button class="tmbl-cek-roll" onclick="cekLapKiriman('."'".$r->tgl."'".','."'".$r->id_perusahaan."'".','."'".$r->id_expedisi."'".')">'; // 
				$bc = '</button>';
				$html .='<tr class="list-p-putih" style="vertical-align:top">
					<td style="padding:5px">'.$bo.$i.$bc.'</td>
					<td style="padding:5px">'.$bo.strtoupper($this->m_fungsi->getHariIni($r->tgl)).', '.$expTgl[2].'/'.$expTgl[1].'/'.$expTgl[0].$bc.'</td>
					<td style="padding:5px">'.$bo.$nmpt.$bc.'</td>
					<td style="padding:5px">'.$bo.number_format($r->kiriman).$bc.'</td>';
					
				$getGsm = $this->db->query("SELECT t.nm_ker,t.g_label FROM m_timbangan t
				INNER JOIN pl p ON t.id_pl=p.id
				WHERE p.tgl='$r->tgl' AND p.id_perusahaan='$r->id_perusahaan' AND p.id_expedisi='$r->id_expedisi'
				GROUP BY t.nm_ker,t.g_label");
				$html .='<td style="padding:5px">'.$bo;
				foreach($getGsm->result() as $gsmL){
					$html .= $gsmL->nm_ker.$gsmL->g_label.'/';
				}
				$html .= $bc.'</td>';

				$getUk = $this->db->query("SELECT t.width FROM m_timbangan t
				INNER JOIN pl p ON t.id_pl=p.id
				WHERE p.tgl='$r->tgl' AND p.id_perusahaan='$r->id_perusahaan' AND p.id_expedisi='$r->id_expedisi'
				GROUP BY t.width");
				$html .='<td style="padding:5px">'.$bo;
				foreach($getUk->result() as $uk){
					$html .= round($uk->width,2).'/';
				}
				$html .= $bc.'</td>';
				$html .='<td style="padding:5px">'.$bo.number_format($r->roll).$bc.'</td>
					<td style="padding:5px">'.$bo.$r->pt.$bc.'</td>
					<td style="padding:5px">'.$bo.$r->plat.$bc.'</td>
					<td style="padding:5px">'.$bo.$r->supir.$bc.'</td>
				</tr>';
			
				$sumKiriman += $r->kiriman;
				$sumRoll += $r->roll;
			}
			// $sumI += $i;
			// TOTAL
			$html .='<tr style="background:#e9e9e9;font-weight:bold">
				<td style="padding:5px" colspan="3">TOTAL</td>
				<td style="padding:5px">'.number_format($sumKiriman).'</td>
				<td style="padding:5px" colspan="2"></td>
				<td style="padding:5px">'.number_format($sumRoll).'</td>
				<td style="padding:5px" colspan="3"></td>
			</tr>';
		}

		$html .='</table>';
		echo $html;
	}

	function cekLapKiriman(){
		$tgl = $_POST['tgl'];
		$idpt = $_POST['idpt'];
		$idex = $_POST['idex'];
		$html = '';

		$getData = $this->db->query("SELECT p.tgl,p.nama,p.nm_perusahaan,p.id_perusahaan,p.id_expedisi,p.no_po,t.nm_ker,COUNT(t.roll) AS roll,SUM(t.weight - t.seset) AS kiriman FROM m_timbangan t
		INNER JOIN pl p ON t.id_pl=p.id
		WHERE p.tgl='$tgl' AND p.id_perusahaan='$idpt' AND p.id_expedisi='$idex'
		GROUP BY p.tgl,p.id_perusahaan,p.id_expedisi,p.no_po,t.nm_ker");
		if($getData->row()->nama != '-' && $getData->row()->nm_perusahaan == '-'){
			$nmpt = $getData->row()->nama;
		}else if($getData->row()->nama == '-' && $getData->row()->nm_perusahaan != '-'){
			$nmpt = $getData->row()->nm_perusahaan;
		}else{
			$nmpt = $getData->row()->nama.' - '.$getData->row()->nm_perusahaan;
		}
		$expTgl = explode("-", $tgl); //getHariIni
		$html .='<div style="color:#000;font-weight:bold">'.strtoupper($this->m_fungsi->getHariIni($tgl)).', '.$expTgl[2].'/'.$expTgl[1].'/'.$expTgl[0].' - '.$nmpt.'</div>';

		$html .='<table style="margin-top:15px;font-size:12px;color:#000">';
		$html .='<tr style="text-align:center;font-weight:bold">
			<td style="padding:5px">JENIS</td>
			<td style="padding:5px">NO. PO</td>
			<td style="padding:5px">JML. ROLL</td>
			<td style="padding:5px">KIRIMAN</td>
		</tr>';

		$sumRoll = 0;
		$sumKiriman = 0;
		foreach($getData->result() as $r){
			$html .='<tr>
				<td style="padding:5px">'.$r->nm_ker.'</td>
				<td style="padding:5px">'.$r->no_po.'</td>
				<td style="padding:5px;text-align:right">'.number_format($r->roll).'</td>
				<td style="padding:5px;text-align:right">'.number_format($r->kiriman).'</td>
			</tr>';
			$sumRoll += $r->roll;
			$sumKiriman += $r->kiriman;
		}
		// TOTAL
		$html .='<tr style="font-weight:bold">
			<td style="padding:5px" colspan="2"></td>
			<td style="padding:5px;text-align:right">'.number_format($sumRoll).'</td>
			<td style="padding:5px;text-align:right">'.number_format($sumKiriman).'</td>
		</tr>';
		$html .='</table>';

		echo $html;
	}
}
