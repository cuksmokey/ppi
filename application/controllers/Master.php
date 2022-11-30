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


	function Insert()
	{
		$jenis      = $_POST['jenis'];

		if ($jenis == "Timbangan") {
			$id = $this->input->post('id');
                $cek = $this->m_master->get_data_one("m_timbangan","roll",$id)->num_rows();
                if ($cek > 0 ) {
                    echo json_encode(array('data' =>  FALSE));
                }else{
                    $this->m_master->insert_timbangan();
                    echo json_encode(array('data' =>  TRUE));
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
			$query = $this->m_master->get_timbangan()->result();
			$i = 1;
			foreach ($query as $r) {
				$id = "'$r->id'";

                    $print = base_url("Master/print_timbangan?id=").$r->roll;
                    $print2 = base_url("Master/print_timbangan2?id=").$r->roll;

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
                        $aksi = '
                        <button type="button" onclick="tampil_edit('.$id.')" class="btn bg-orange">
                            EDIT
                        </button>
						<button type="button" onclick="deleteData('.$id.','."".')" class="btn btn-danger">
                            HAPUS
                        </button>
                        <a type="button" href="'.$print.'" target="blank" class="btn btn-default">
                            L BESAR
                        </a>
                        <a type="button" href="'.$print2.'" target="blank" class="btn bg-green">
                            L KECIL
                        </a>';

                        // if($r->ctk == 1){
                        //     $aksi .='';
                        // }else if($r->ctk == 0){

                        // $aksi .='
						// <a type="button" href="'.$print.'" target="blank" class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
						// 	<i class="material-icons">print</i>
						// </a>';

                        // }                        
                    // }
                    $row[] = $aksi;
                    $data[] = $row;
                    // $i++;
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
			$result = $this->m_master->update_timbangan();
			echo json_encode(array('data' =>  TRUE));
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
			$return = $this->m_master->delete("m_timbangan", "id", $id);
			echo "1";
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

		$this->m_master->updateQCRoll();
		$idNewRoll =  $this->m_master->get_data_one("m_timbangan", "id", $id)->row();
		echo json_encode(
			array(
				'data' => true,
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

	function print_timbangan()
	{
		$id = $_GET['id'];

		$data = $this->db->query("SELECT * FROM m_timbangan WHERE roll = '$id'")->row();
		$data_perusahaan = $this->db->query("SELECT * FROM perusahaan limit 1")->row();
		// $query = $this->db->query("UPDATE m_timbangan SET ctk='1' WHERE roll='$id'");

		$html = '';

		$html .= '
        <center> 
            <h1> ' . $data_perusahaan->nama . ' </h1>  ' . $data_perusahaan->daerah . ' , Email : ' . $data_perusahaan->email . '
        </center>
        <hr>
        
        <br><br><br>
                <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size:52px">
                    <tr>
                        <td align="left" width="50%">QUALITY</td>
                        <td align="center">' . $data->nm_ker . '</td>
                    </tr>
                    <tr>
                        <td align="left">GRAMMAGE</td>
                        <td align="center">' . $data->g_label . ' GSM</td>
                    </tr>
                    <tr>
                        <td align="left">WIDTH</td>
                        <td align="center">' . round($data->width, 2) . ' CM</td>
                    </tr>
                    <tr>
                        <td align="left">DIAMETER</td>
                        <td align="center">' . $data->diameter . ' CM</td>
                    </tr>
                    <tr>
                        <td align="left">WEIGHT</td>
                        <td align="center">' . $data->weight . ' KG</td>
                    </tr>
                    <tr>
                        <td align="left">JOINT</td>
                        <td align="center">' . $data->joint . '</td>
                    </tr>
                    <tr>
                        <td align="left">ROLL NUMBER</td>
                        <td align="center">' . $data->roll . '</td>
                    </tr>
                    <tr>
                </table>';

		$this->m_fungsi->_mpdfCustom('', $html, 10, 10, 10, 'L');
	}

	function print_timbangan2()
	{
		$id = $_GET['id'];

		$data = $this->db->query("SELECT * FROM m_timbangan WHERE roll = '$id'")->row();
		// $query = $this->db->query("UPDATE m_timbangan SET ctk='1' WHERE roll='$id'");

		$html = '';

		$html .= '<br><br><br><br><br><br>
                <table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size:37px">
                    <tr>
                        <td align="left">QUALITY</td>
                        <td align="center">' . $data->nm_ker . '</td>
                    </tr>
                    <tr>
                        <td align="left">GRAMMAGE</td>
                        <td align="center">' . $data->g_label . ' GSM</td>
                    </tr>
                    <tr>
                        <td align="left">WIDTH</td>
                        <td align="center">' . $data->width . ' CM</td>
                    </tr>
                    <tr>
                        <td align="left">DIAMETER</td>
                        <td align="center">' . $data->diameter . ' CM</td>
                    </tr>
                    <tr>
                        <td align="left">WEIGHT</td>
                        <td align="center">' . $data->weight . ' KG</td>
                    </tr>
                    <tr>
                        <td align="left">JOINT</td>
                        <td align="center">' . $data->joint . '</td>
                    </tr>
                    <tr>
                        <td align="left">ROLL NUMBER</td>
                        <td align="center">' . $data->roll . '</td>
                    </tr>
                    <tr>
                </table>';


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

	function pList(){
		$tgl = $_POST['tgl'];
		$html ='';
		// $html .='<table style="margin:0;padding:0;border-collapse:collapse;color:#000;font-size:12px" border="1">';

		$getCust = $this->db->query("SELECT*FROM pl
		WHERE qc='proses' AND tgl='$tgl'
		GROUP BY opl");
		if($getCust->num_rows() == 0){
			$html .='<div style="font-weight:bold">DATA PROSES INPUT TIDAK DITEMUKAN</div>';
		}else{
			// $html .='<table class="list-table">
			// 	<tr>
			// 		<td style="padding:5px;font-weight:bold">No.</td>
			// 		<td style="padding:5px;font-weight:bold">Customer</td>
			// 		<td style="padding:5px;font-weight:bold">Keterangan</td>
			// 	</tr>
			// </table>';
			$i = 0;
			foreach($getCust->result() as $cust){
				$i++;
				$html .='<table class="list-table">
					<tr>
						<td style="padding:5px;text-align:center">'.$i.'</td>
						<td style="padding:5px">'.$cust->nm_perusahaan.'</td>
						<td style="padding:5px;text-align:center"><button onclick="btnCekQc('."'".$cust->opl."'".','."'".$i."'".')">CEK QC</button></td>
					</tr>
				</table>';

				$html .='<div class="id-cek t-plist-cek-'.$i.'"></div>';
			}
		}
		// $html .='</table>';

		echo $html;
	}

	// function pListCekQc(){
	// 	$tgl = $_POST['tgl'];
	// 	$html = '';
	// 	$getCekQc = $this->db->query("SELECT*FROM pl
	// 	WHERE qc='cek' AND tgl='$tgl'
	// 	GROUP BY opl");
	// 	if($getCekQc->num_rows() == 0){
	// 		$html .='<div stye="font-weight:bold">DATA CEK QC TIDAK DITEMUKAN</div>';
	// 	}else{
	// 		$html .='<table class="list-table">';
	// 		$html .='<tr>
	// 			<td style="padding:5px;font-weight:bold">No.</td>
	// 			<td style="padding:5px;font-weight:bold">Customer</td>
	// 			<td style="padding:5px;font-weight:bold">Keterangan</td>
	// 		</tr></table>';
	// 		$i = 0;
	// 		foreach($getCekQc->result() as $cekqc){
	// 			$i++;
	// 			$html .='<table class="list-table">';
	// 			$html .='<tr>
	// 				<td style="padding:5px;text-align:center">'.$i.'</td>
	// 				<td style="padding:5px">'.$cekqc->nm_perusahaan.'</td>
	// 				<td style="padding:5px;text-align:center"><button onclick="btnCekQc('."'".$cekqc->opl."'".','."'".$i."'".')">CEK QC</button></td>
	// 			</tr>';
				
	// 			$html .='</table>';

	// 			$html .='<div class="id-cek t-plist-cek-'.$i.'"></div>';
	// 		}
	// 	}
		
	// 	echo $html;
	// }
}
