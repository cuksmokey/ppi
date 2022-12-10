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
			$this->load->view('home');
		}else if($this->session->userdata('level') == "Admin" || $this->session->userdata('level') == "QC" || $this->session->userdata('level') == "FG"){
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

	public function Administrator()
	{
		$this->load->view('header');
		$this->load->view('Master/v_administrator');
		$this->load->view('footer');
	}

	function Insert()
	{
		$jenis      = $_POST['jenis'];

		if ($jenis == "Timbangan") {
			$id = $this->input->post('id');
                $cek = $this->m_master->get_data_one("m_timbangan","roll",$id)->num_rows();
                if ($cek > 0 ) {
					echo json_encode(array('data' => FALSE, 'msg' => 'ROLL NUMBER SUDAH ADA'));
                }else{
					$this->m_master->insert_timbangan();
					$getId = $this->m_master->get_data_one("m_timbangan","roll",$id)->row();
                    echo json_encode(array('data' => TRUE, 'getid' => $getId->id));
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
						// $row[] = $r->ctk;

						$aksi ="";
						// if ($this->session->userdata('level') == "Admin") {
						
                        // $aksi = '
                        // <button type="button" onclick="tampil_edit('.$id.')" class="btn bg-orange btn-circle waves-effect waves-circle waves-float">
                        //     <i class="material-icons">edit</i>
                        // </button>
						// <button type="button" onclick="deleteData('.$id.','."".')" class="btn btn-danger btn-circle waves-effect waves-circle waves-float">
                        //     <i class="material-icons">delete</i>
                        // </button>
                        // <a type="button" href="'.$print.'" target="blank" class="btn btn-default btn-circle waves-effect waves-circle waves-float">
                        //     <i class="material-icons">print</i>
                        // </a>
                        // <a type="button" href="'.$print2.'" target="blank" class="btn bg-green btn-circle waves-effect waves-circle waves-float">
                        //     <i class="material-icons">print</i>
                        // </a>';

						// #FF9800 - #fff edit
						// #FB483A - #fff hapus
						// #fff - #333333 kcl
						// #4CAF50 - besar
                        if($r->ctk == 1){
                            $aksi .='-';
                        }else if($r->ctk == 0){
							$aksi = '
							<button type="button" onclick="tampil_edit('.$id.')" class="btn bg-orange">
								EDIT
							</button>
							<button type="button" onclick="deleteData('.$id.','."".')" class="btn btn-danger">
								HAPUS
							</button>
							<a type="button" href="'.$print.'" target="_blank" class="btn btn-default">
								L BESAR
							</a>
							<a type="button" href="'.$print2.'" target="_blank" class="btn bg-green">
								L KECIL
							</a>';
                        }
                    // }
                    $row[] = $aksi;
                    $data[] = $row;
                    // $i++;
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
			if($getid->status == 0 || $getid->id_pl == 0){
				$this->m_master->update_timbangan();
				echo json_encode(array('data' => TRUE, 'getid' => $getid->id));
			}else{
				echo json_encode(array('data' => TRUE, 'msg' => 'DATA ROLL SUDAH TERJUAL'));
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
			$getId = $this->db->query("SELECT * FROM m_timbangan WHERE id='$id' AND ctk='1'");
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

	function editQCRoll(){
		$id = $_POST['id'];

		// CEK JIKA SUDAH MASUK RENCANA KIRIM
		$cek_rk = $this->db->query("SELECT*FROM m_timbangan WHERE id='$id' AND (id_rk='' OR id_rk IS NULL)");

		if($cek_rk->num_rows() == 0){
			$idOldRoll = $this->m_master->get_data_one("m_timbangan", "id", $id)->row();
			echo json_encode(
				array(
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
				)
			);
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
				)
			);
		}
	}

	function print_timbangan()
	{
		$id = $_GET['id'];
		$data = $this->db->query("SELECT * FROM m_timbangan WHERE roll = '$id'")->row();
		$data_perusahaan = $this->db->query("SELECT * FROM perusahaan limit 1")->row();
		$html = '';
		
		if($data->ctk == 0){
			$this->db->query("UPDATE m_timbangan SET ctk='1' WHERE roll='$id'");
			$html .= '<h1> ' . $data_perusahaan->nama . ' </h1>  ' . $data_perusahaan->daerah . ' , Email : ' . $data_perusahaan->email . '
			<hr>
			
			<br><br><br>
			<table style="margin:0;font-size:52px;width:100%" cellspacing="0" border="1">
				<tr>
					<td style="width:50%">QUALITY</td>
					<td style="text-align:center">' . $data->nm_ker . '</td>
				</tr>
				<tr>
					<td>GRAMMAGE</td>
					<td style="text-align:center">' . $data->g_label . ' GSM</td>
				</tr>
				<tr>
					<td>WIDTH</td>
					<td style="text-align:center">' . round($data->width, 2) . ' CM</td>
				</tr>
				<tr>
					<td>DIAMETER</td>
					<td style="text-align:center">' . $data->diameter . ' CM</td>
				</tr>
				<tr>
					<td>WEIGHT</td>
					<td style="text-align:center">' . $data->weight . ' KG</td>
				</tr>
				<tr>
					<td>JOINT</td>
					<td style="text-align:center">' . $data->joint . '</td>
				</tr>
				<tr>
					<td>ROLL NUMBER</td>
					<td style="text-align:center">' . $data->roll . '</td>
				</tr>
			</table>';
			$this->m_fungsi->_mpdfCustom('', $html, 10, 10, 10, 'L');
		}else{
			// $html.='<div style="text-align:center;font-weight:bold;font-size:40px">DATA ROLL '.$data->roll.' SUDAH PRINT LABEL. HARAP HUBUNGI QC</div>';
			redirect(base_url("Master"));
		}
	}

	function print_timbangan2()
	{
		$id = $_GET['id'];
		$data = $this->db->query("SELECT * FROM m_timbangan WHERE roll = '$id'")->row();
		$html = '';
		
		if($data->ctk == 0){
			$this->db->query("UPDATE m_timbangan SET ctk='1' WHERE roll='$id'");
			$html .= '<br><br><br><br><br><br>
			<table cellspacing="0" cellpadding="5" style="font-size:37px;width:100%" border="1">
				<tr>
					<td>QUALITY</td>
					<td style="text-align:center">' . $data->nm_ker . '</td>
				</tr>
				<tr>
					<td>GRAMMAGE</td>
					<td style="text-align:center">' . $data->g_label . ' GSM</td>
				</tr>
				<tr>
					<td>WIDTH</td>
					<td style="text-align:center">' . round($data->width,2) . ' CM</td>
				</tr>
				<tr>
					<td>DIAMETER</td>
					<td style="text-align:center">' . $data->diameter . ' CM</td>
				</tr>
				<tr>
					<td>WEIGHT</td>
					<td style="text-align:center">' . $data->weight . ' KG</td>
				</tr>
				<tr>
					<td>JOINT</td>
					<td style="text-align:center">' . $data->joint . '</td>
				</tr>
				<tr>
					<td>ROLL NUMBER</td>
					<td style="text-align:center">' . $data->roll . '</td>
				</tr>
				<tr>
			</table>';
		}else{
			// $html.='<div style="text-align:center;font-weight:bold;font-size:40px">DATA ROLL '.$data->roll.' SUDAH PRINT LABEL. HARAP HUBUNGI QC</div>';
			redirect(base_url("Master"));
		}

		$this->m_fungsi->_mpdf('', $html, 10, 10, 10, 'P');
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
		$html = '';

		// $getData = $this->db->query("");
		$html .='test';

		echo $html;
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
		
		// PACKING LIST OK
		$getData = $this->db->query("SELECT p.tgl,no_surat,nama,nm_perusahaan,qc FROM pl p
		INNER JOIN m_timbangan t ON p.id=t.id_pl
		WHERE p.tgl LIKE '%$fyear%' AND no_surat LIKE '%$syear/$kpjk/$jenis%' AND qc='ok'
		GROUP BY p.tgl DESC,no_pkb DESC,qc LIMIT 10");
		if($_POST['tgl'] == '' || $_POST['id'] == '' || $_POST['pjk'] == '' || $getData->num_rows() == 0){
			$html .= '';
		}else{
			$html .='<table style="color:#000;font-size:12px;text-align:center;margin-top:15px" border="1">';
			$html .='<tr>
				<td style="padding:5px;font-weight:bold" colspan="4">10 KIRIMAN TERAKHIR</td>
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
		WHERE tgl LIKE '%$fyear%' AND no_surat LIKE '%$syear/$kpjk/$jenis%' AND qc='proses'
		GROUP BY tgl DESC,no_pkb DESC,qc");
		if($_POST['tgl'] == '' || $_POST['id'] == '' || $_POST['pjk'] == '' || $getData->num_rows() == 0){
			$html .= '';
		}else{
			$html .='<table style="color:#000;font-size:12px;text-align:center;margin-top:15px" border="1">';
			$html .='<tr>
				<td style="padding:5px;font-weight:bold" colspan="4">PACKING LIST PROSES</td>
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
		$id = explode("_ex_", $_POST['id']);
		echo json_encode(array('nm_ker' => $id[2]));
	}

	function addCartPl(){
		// fkepada fnmpt fnama falamat ftelp ftgl fplhpajak noSJ noSOSJ noPKB fnopkb ftahunpkb fjnspkb fnopo fjenis fplhplgsm
		// tgl no_surat no_so no_pkb no_kendaraan nm_perusahaan id_perusahaan alamat_perusahaan nama no_telp no_po status qc tgl_pl opl no_pl_inv  cek_po      sj  item_desc
		// CEK NOMER SURAT JALAN SUDAH TERPAKAI ATAU BELUM = PACKING LIST OK
		$year = substr($_POST['ftgl'], 0, 4);
		$noSJ = explode("/", trim($_POST['noSJ']));
		$no = $noSJ[0];
		$thn = $noSJ[3];
		$pjk = $noSJ[4];
		$jns = $noSJ[5];
		$getnoSJ = $this->db->query("SELECT p.tgl,no_surat,no_so,no_pkb,qc FROM pl p
		INNER JOIN m_timbangan t ON p.id=t.id_pl
		WHERE p.tgl LIKE '%$year%' AND no_surat LIKE '%$no%' AND no_surat LIKE '%$thn/$pjk/$jns%' AND qc='ok'
		GROUP BY p.tgl,no_surat,no_so,no_pkb");
		if($_POST['pilihan'] == 'cart'){
			if($getnoSJ->num_rows() == 0){
				// CEK NOMER SURAT JALAN SUDAH TERPAKAI ATAU BELUM = PACKING LIST PROSES
				$getnoSJproses = $this->db->query("SELECT tgl,no_surat,no_so,no_pkb,qc FROM pl
				WHERE tgl LIKE '%$year%' AND no_surat LIKE '%$no%' AND no_surat LIKE '%$thn/$pjk/$jns%' AND qc='proses'
				GROUP BY tgl,no_surat,no_so,no_pkb");
				if($getnoSJproses->num_rows() == 0){
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
					$this->cart->insert($data);
					echo json_encode(array('data' => 'cart', 'opsi' => true, 'msg' => 'BERHASIL DITAMBAHKAN!'));
				}else{
					echo json_encode(array('data' => 'cart', 'opsi' => false, 'msg' => 'NOMER SURAT JALAN SUDAH TERPAKAI!'));
				}
			}else{
				echo json_encode(array('data' => 'cart', 'opsi' => false, 'msg' => 'NOMER SURAT JALAN SUDAH TERPAKAI!'));
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

	function showCartPl(){
		$html ='';

		if($this->cart->total_items() != 0){
			$html .='<table style="margin-top:15px;width:100%;color:#000;font-size:12px;text-align:center;border-color:#aaa" border="1">';
			$html .='<tr>
				<td style="padding:5px;font-weight:bold">TANGGAL</td>
				<td style="padding:5px;font-weight:bold">NO. SJ</td>
				<td style="padding:5px;font-weight:bold">NO. SO</td>
				<td style="padding:5px;font-weight:bold">NO. PO</td>
				<td style="padding:5px;font-weight:bold">JENIS</td>
				<td style="padding:5px;font-weight:bold">GRAMATURE</td>
				<td style="padding:5px;font-weight:bold">AKSI</td>
			</tr>';
		}

		foreach($this->cart->contents() as $items){
			$html .='<tr>
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
				<td style="padding:5px" colspan="7"><button onclick="addCartPl('."'simpan'".')">SIMPAN</button></td>
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
		// 5_ex_2022-12-08_ex_TESET/RENCANA/KIRIM_ex_MH_ex_150_ex_190.00
		#tgl nm_ker g_label width jml_roll order_pl
		$exp = explode("_ex_", $_POST['rkukuran']);
		$tgl = $exp[1];
		$nm_ker = $exp[3];
		$g_label = $exp[4];
		$width = $exp[5];
		$jml_roll = $_POST['rkjmlroll'];
		$order_pl = $exp[0];

		$data = array(
			'id' => $nm_ker.$g_label.'_'.$width.$order_pl,
			'name' => $nm_ker.$g_label.'_'.$width.$order_pl,
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
			$html .='<table style="margin-top:15px;width:100%;color:#000;font-size:12px;text-align:center;border-color:#aaa" border="1">';
			$html .='<tr>
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
				<td style="padding:5px">'.$items['options']['width'].'</td>
				<td style="padding:5px">'.$items['options']['jml_roll'].'</td>
				<td style="padding:5px"><button onclick="hapusCartRk('."'".$items['rowid']."'".')">Batal</button></td>
			</tr>';
		}

		if($this->cart->total_items() != 0){
			$html .='<tr>
					<td style="padding:5px"><button onclick="simpanCartRk()">SIMPAN</button></td>
				</tr>
			</table>';
		}

		echo $html;
	}

	function simpanCartRk(){
		$this->m_master->simpanCartRk();
		echo json_encode(array('data' => true));
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
		$html ='';

		$getCust = $this->db->query("SELECT r.id_rk AS idrk,p.* FROM pl p
		INNER JOIN m_rencana_kirim r ON p.tgl_pl=r.tgl AND p.opl=r.order_pl
		WHERE qc='proses' AND tgl_pl='$tgl'
		GROUP BY opl");
		if($getCust->num_rows() == 0){
			$html .='';
		}else{
			$i = 0;
			foreach($getCust->result() as $cust){
				$i++;
				$html .='<table class="list-table">
					<tr>
						<td style="padding:5px 0;text-align:center">
							<button onclick="btnRencana('."'".$cust->idrk."'".','."'".$cust->opl."'".','."'".$cust->tgl_pl."'".','."'".$i."'".')">PROSES</button>
							<button onclick="btnRencanaEdit('."'".$cust->idrk."'".','."'".$cust->opl."'".','."'".$cust->tgl_pl."'".','."'".$i."'".')">EDIT</button>
						</td>
						<td style="padding:5px;text-align:center">'.$i.'</td>
						<td style="padding:5px">'.$cust->nm_perusahaan.'</td>
					</tr>
				</table>';

				// SEMUA TAMPIL DISINII
				$html .='<div class="id-cek t-plist-rencana-'.$i.'"></div>';
				$html .='<div class="id-cek t-plist-edit-'.$i.'"></div>';
				$html .='<div class="id-cek t-plist-input-sementara-'.$i.'"></div>';
				$html .='<div class="id-cek t-plist-hasil-input-'.$i.'"></div>';
				$html .='<div class="id-cek t-plist-input-'.$i.'"></div>';
			}
		}
		echo $html;
	}

	function pListInputSementara(){
		$id_rk = $_POST['id_rk'];
		$l = $_POST['i'];
		$html ='';

		$html .='<div style="overflow:auto;white-space:nowrap;"><table class="list-table" style="width:100%;text-align:center;margin-top:15px" border="1">';
		$html .='<tr>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">NO.</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:10%">NO. ROLL</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">BW</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">RCT</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">BI</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">D(CM)</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">BERAT</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">JNT</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:25%">KET</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">SESET</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:5%">LABEL</td>
			<td style="background:#e9e9e9;padding:5px;font-weight:bold;width:20%">AKSI</td>
		</tr>';

		$getKer = $this->db->query("SELECT id_rk,nm_ker,g_label,width,COUNT(width) AS jml FROM m_timbangan
		WHERE id_rk='$id_rk'
		GROUP BY nm_ker,g_label,width");
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
			$html .='<tr class="'.$bgtrt.'">
				<td style="padding:5px;font-weight:bold;text-align:left" colspan="12">'.$ker->nm_ker.''.$ker->g_label.' - '.round($ker->width,2).'</td>
			</tr>';

			$getWidth = $this->db->query("SELECT * FROM m_timbangan
			WHERE id_rk='$ker->id_rk' AND nm_ker='$ker->nm_ker' AND g_label='$ker->g_label' AND width='$ker->width'
			ORDER BY roll");
			$i = 0;
			foreach($getWidth->result() as $w){
				$i++;
				if($w->status == '3'){
					$bgtr = 'status-buffer';
				}else{
					$bgtr = 'status-stok';
				}

				if($w->nm_ker == 'MH'){
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

				$html .='<tr class="'.$bgtr.'">
					<td style="padding:5px">'.$i.'</td>
					<td style="padding:5px">'.$w->roll.'</td>
					<td style="padding:5px;'.$bgbw.'">'.$w->g_ac.'</td>
					<td style="padding:5px;'.$bgrct.'">'.$w->rct.'</td>
					<td style="padding:5px;'.$bgbi.'">'.$w->bi.'</td>
					<td style="padding:5px">'.$w->diameter.'</td>
					<td style="padding:5px">'.number_format($w->weight - $w->seset).'</td>
					<td style="padding:5px">'.$w->joint.'</td>
					<td style="padding:5px;text-align:left">'.$ketSeset.'</td>
					<td style="padding:5px;position:relative">
						<input type="text" id="his-seset-'.$w->id.'" value="'.number_format($w->seset).'" style="position:absolute;text-align:center;top:0;left:0;right:0;bottom:0;width:100%;border:0;">
					</td>
					<td style="padding:5px"><button onclick="">REQ</button></td>
					<td style="padding:5px"><button onclick="editRollRk('."'".$w->id."'".','."'".$l."'".')">EDIT</button> - <button onclick="batalRollRk('."'".$w->id."'".','."'".$l."'".')">BATAL</button></td>
				</tr>';

				$totBerat += $w->weight - $w->seset;
			}
			$totRoll += $ker->jml;
		}
		$html .='<tr>
			<td style="padding:5px;font-weight:bold">'.number_format($totRoll).'</td>
			<td style="padding:5px;font-weight:bold" colspan="5">TOTAL</td>
			<td style="padding:5px;font-weight:bold">'.number_format($totBerat).'</td>
			<td style="padding:5px;font-weight:bold" colspan="5">-</td>
		</tr>';

		$html .='</table></div>';
		echo $html;
	}

	function editRollRk(){
		$id = $_POST['id'];
		$this->m_master->editRollRk();
		echo json_encode(
			array(
				'data' => 'berhasil',
			)
		);
	}

	function batalRollRk(){
		$id = $_POST['id'];
		$id_rk = $_POST['id_rk'];
		$return = $this->m_master->batalRollRk();

		echo json_encode(
			array(
				'data' => $return,
			)
		);
	}

	function pListRencana(){
		$opl = $_POST['opl'];		
		$tgl_pl = $_POST['tgl_pl'];
		$i = $_POST['i'];
		$html = '';

		$getUkRencKirim = $this->db->query("SELECT p.id,p.tgl_pl,p.opl,p.nm_ker,p.g_label,width,jml_roll FROM pl p
		INNER JOIN m_rencana_kirim r ON p.tgl_pl=r.tgl AND p.opl=r.order_pl
		WHERE p.tgl_pl='$tgl_pl' AND p.opl='$opl'
		GROUP BY p.tgl_pl,p.opl,p.nm_ker,p.g_label");
		if($getUkRencKirim->num_rows() == 0){
			$html .= '';
		}else{
			$html .='<table class="list-table" style="font-weight:bold;text-align:center" border="1">
				<tr>
					<td style="padding:5px">JENIS</td>
					<td style="padding:5px">UKURAN</td>
					<td style="padding:5px">JUMLAH</td>
				</tr>';
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
				WHERE nm_ker='$ukRenc->nm_ker' AND g_label='$ukRenc->g_label' AND order_pl='$ukRenc->opl'
				GROUP BY nm_ker,g_label,width,order_pl");
				$rowsp = $getUk->num_rows() + 1;
				$html .='<tr class="'.$bgtr.'">
					<td style="padding:5px" rowspan="'.$rowsp.'">'.$ukRenc->nm_ker.' '.$ukRenc->g_label.'</td></tr>';

				foreach($getUk->result() as $uk){
					$html .='<tr class="'.$bgtr.'">
						<td style="padding:5px">'.round($uk->width,2).'</td>
						<td style="padding:5px"><button onclick="btnInputRoll('."'".$i."'".','."'".$uk->nm_ker."'".','."'".$uk->g_label."'".','."'".$uk->width."'".')" style="background:0;border:0">'.$uk->jml_roll.'</button></td>
					</tr>';
				}
			}
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
		$html .='<div style="padding:10px 0 0">
			<button style="padding:5px;font-weight:bold" disabled>'.$nm_ker.''.$g_label.' - '.round($width,2).' :</button>
			<input type="text" name="roll" id="roll" maxlength="14" style="border:1px solid #ccc;padding:7px;border-radius:5px" autocomplete="off" placeholder="ROLL">
			<button class="btn-cari-inp-roll" onclick="cariRoll('."'".$i."'".','."'".$nm_ker."'".','."'".$g_label."'".','."'".$width."'".','."'".$roll."'".','."'".$key."'".')">CARI</button>
		</div>';
		
		$getRoll = $this->db->query("SELECT*FROM m_timbangan
		WHERE nm_ker='$nm_ker' AND g_label='$g_label' AND width='$width' AND roll LIKE '%$roll%'
		AND tgl BETWEEN '2020-04-01' AND '9999-01-01'
		AND (STATUS=0 OR STATUS=2 OR STATUS=3) AND id_pl='0' AND (id_rk IS NULL OR id_rk = '')
		ORDER BY pm,roll");
		if($getRoll->num_rows() == 0){
			$html .='<div class="notfon">DATA TIDAK DITEMUKAN</div>';
		}else{
			$ii = 0;
			$html .='<div style="padding-top:10px"><table class="list-table" style="text-align:center;width:100%;border-color:#ccc" border="1">
			<tr>
				<td style="padding:5px;font-weight:bold;width:5%">No.</td>
				<td style="padding:5px;font-weight:bold;width:18%">Roll</td>
				<td style="padding:5px;font-weight:bold;width:5%">BW</td>
				<td style="padding:5px;font-weight:bold;width:5%">RCT</td>
				<td style="padding:5px;font-weight:bold;width:5%">BI</td>
				<td style="padding:5px;font-weight:bold;width:5%">Jenis</td>
				<td style="padding:5px;font-weight:bold;width:5%">GSM</td>
				<td style="padding:5px;font-weight:bold;width:5%">C M</td>
				<td style="padding:5px;font-weight:bold;width:5%">Ukuran</td>
				<td style="padding:5px;font-weight:bold;width:5%">Berat</td>
				<td style="padding:5px;font-weight:bold;width:5%">Jnt</td>
				<td style="padding:5px;font-weight:bold;width:27%">Keterangan</td>
				<td style="padding:5px;font-weight:bold;width:5%">Aksi</td>
			</tr>';
			foreach($getRoll->result() as $r){
				$ii++;
				if($r->status == 3){
					$bgtr = 'status-buffer';
				}else{
					$bgtr = 'status-stok';
				}
				$html .='<tr class="'.$bgtr.'">
					<td style="padding:5px">'.$ii.'</td>
					<td style="padding:5px;text-align:left">'.$r->roll.'</td>
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
		$html .='</table></div>';
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
			$html .='<table class="list-table" style="font-weight:bold;text-align:center;margin:15px 0;border-color:#ccc" border="1">
			<tr>
				<td style="padding:5px">No.</td>
				<td style="padding:5px">Roll</td>
				<td style="padding:5px">Aksi</td>
			</tr>';
		}

		$i = 0;
		foreach($this->cart->contents() as $items){
			$i++;
			$html .='<tr>
				<td style="padding:5px">'.$i.'</td>
				<td style="padding:5px">'.$items['options']['roll'].'</td>
				<td style="padding:5px"><button onclick="hapusCartInputRoll('."'".$items['rowid']."'".','."'".$items['options']['i']."'".')">Batal</button></td>
			</tr>';
		}
		$html .='</table>';

		if($this->cart->total_items() != 0){
			$html .='<button onclick="simpanInputRoll()">SIMPAN</button>';
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
			),
		);
		$this->cart->insert($data);
		echo json_encode(array('data' => true));
	}

	function simpanCartPO(){
		$cekIdPo = $this->db->query("SELECT*FROM po_master GROUP BY id_po")->num_rows();
		if($cekIdPo == 0){
			$idpo = 1;
		}else{
			$idpo = $cekIdPo + 1;
		}
		$this->m_master->simpanCartPO($idpo);
		echo json_encode(array('data' => true));
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

		$html .= '<table style="width:100%;margin-top:15px" border="1">';
		if($this->cart->total_items() != 0){
			$html .='<tr>
				<td style="width:5%;padding:5px;font-weight:bold;text-align:center">NO</td>
				<td style="width:auto;padding:5px;font-weight:bold">JENIS</td>
				<td style="width:auto;padding:5px;font-weight:bold">GSM</td>
				<td style="width:auto;padding:5px;font-weight:bold">UKURAN</td>
				<td style="width:auto;padding:5px;font-weight:bold">TONASE</td>
				<td style="width:auto;padding:5px;font-weight:bold">JUMLAH ROLL</td>
				<td style="width:auto;padding:5px;font-weight:bold">HARGA</td>
				<td style="width:10%;padding:5px;font-weight:bold">AKSI</td>
			</tr>';
		}

		$i = 0;
		foreach($this->cart->contents() as $r){
			$i++;
			$html .='<tr>
				<td style="padding:5px;text-align:center">'.$i.'</td>
				<td style="padding:5px">'.$r['options']['fjenis'].'</td>
				<td style="padding:5px">'.$r['options']['fgsm'].'</td>
				<td style="padding:5px">'.$r['options']['fukuran'].'</td>
				<td style="padding:5px">'.number_format($r['options']['ftonase']).'</td>
				<td style="padding:5px">'.$r['options']['fjmlroll'].'</td>
				<td style="padding:5px">Rp. '.number_format($r['options']['fharga']).'</td>
				<td style="padding:5px"><button onclick="hapusCartPO('."'".$r['rowid']."'".')">Batal</button></td>
			</tr>';
		}
		if($this->cart->total_items() != 0){
			$html .='<tr>
				<td style="padding:5px" colspan="8"><button onclick="simpanCart()">SIMPAN</button></td>
			</tr>';
		}
		$html .= '</table>';

		echo $html;
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
		}else{
			$lvl = "WHERE level='User'";
		}
		$getData = $this->db->query("SELECT*FROM USER $lvl ORDER BY level");
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
				$html .='<td style="padding:5px">
					<button onclick="editUser('."'".$r->id."'".')" class="btn bg-orange btn-sm waves-effect" style="font-weight:bold">EDIT</button>'.$btnHps.'
				</td>';
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
		}else{
			$lvl = "WHERE level='User'";
		}

		$html .='<option value="">PILIH</option>';
		if($lvl == ''){
			$html .='
				<option value="SuperAdmin">SuperAdmin</option>
				<option value="Admin">Admin</option>
				<option value="QC">QC</option>
				<option value="FG">FG</option>
				<option value="Rewind1">Rewind1</option>
				<option value="Rewind2">Rewind2</option>
			';
		}else{
			$getLevel = $this->db->query("SELECT level FROM USER $lvl GROUP BY level");
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
		$caripo = $_POST['caripo'];
		$html = '';
		
		$getData = $this->db->query("SELECT pt.pimpinan,pt.nm_perusahaan,pt.alamat,m.* FROM po_master m
		INNER JOIN m_perusahaan pt ON m.id_perusahaan=pt.id
		WHERE status='open' AND (pt.pimpinan LIKE '%$caripo%' OR pt.nm_perusahaan LIKE '%$caripo%')
		GROUP BY id_perusahaan
		ORDER BY pt.pimpinan,pt.nm_perusahaan");
		if($getData->num_rows() == 0){
			$html .='';
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
						<button class="btn-c-po" onclick="btnCek('."'".$r->id_perusahaan."'".','."'".$i."'".','."'detail'".')">DETAIL</button>
						<button class="btn-c-po" onclick="btnCek('."'".$r->id_perusahaan."'".','."'".$i."'".','."'rekap'".')">REKAP</button>
					</td>
					<td style="padding:5px">'.$i.'.</td>
					<td style="padding:5px">'.$nama.$kop.'</td>
				</tr>';
				$html .='</table>';

				$html.='<div class="btn-cek btn-cek-list-'.$i.'"></div>';
			}
		}
		echo $html;
	}

	function btnCekShow(){ // btn-cek-list-
		$id = $_POST['id'];
		$opsi = $_POST['opsi'];
		// $i = $_POST['i'];
		$html ='';

		if($opsi == 'rekap'){
			$html .='rekap';
		}else{ // detail
			$getData = $this->db->query("SELECT id_po,no_po,status FROM po_master
			WHERE id_perusahaan='$id' AND status='open'
			GROUP BY id_po,no_po,status");
			$i =0;
			foreach($getData->result() as $r){
				$i++;
				$html .='<table  style="font-size:12px;color:#000">
					<tr class="ll-tr">
						<td style="padding:5px">-</td>
						<td style="padding:5px">'.$r->no_po.'</td>
						<td style="padding:5px">
							<button class="btn-c-po" onclick="btnOpen('."'".$id."'".','."'".$r->id_po."'".','."'".$r->no_po."'".','."'".$i."'".')">'.$r->status.'</button>
						</td>
					</tr>
				</table>';

				$html .='<div class="ll-open btn-open-list-'.$i.'"></div>';
			}
		}
		
		echo $html;
	}

	function btnOpenShow(){ // btn-open-list-
		$id = $_POST['id'];
		$id_po = $_POST['id_po'];
		$no_po = $_POST['no_po'];
		// $i = $_POST['i'];
		$html ='';

		$html .='<table style="font-size:12px;color:#000;text-align:center" border="1">';
		$html .='<tr>
			<td style="padding:5px;font-weight:bold">JENIS</td>
			<td style="padding:5px;font-weight:bold">UKURAN</td>
			<td style="padding:5px;font-weight:bold">TONASE</td>
			<td style="padding:5px;font-weight:bold">JML ROLL</td>
			<td style="padding:5px;font-weight:bold"></td>
		</tr>';

		$getData = $this->db->query("SELECT*FROM po_master
		WHERE id_perusahaan='$id' AND id_po='$id_po' AND no_po='$no_po'
		ORDER BY nm_ker,g_label,width");
		$i = 100;
		foreach($getData->result() as $r){
			$i++;
			$html .='<tr class="ll-tr">
					<td style="padding:5px">'.$r->nm_ker.' '.$r->g_label.'</td>
					<td style="padding:5px">'.round($r->width,2).'</td>
					<td style="padding:5px;text-align:right">'.number_format($r->tonase).'</td>
					<td style="padding:5px">'.$r->jml_roll.'</td>
					<td style="padding:5px"><button class="btn-c-po" onclick="viewList('."'".$r->nm_ker."'".','."'".$r->g_label."'".','."'".$r->width."'".','."'".$i."'".')">view</button></td>
				</tr>';
		}

		$html .='</table>';

		echo $html;
	}
}
