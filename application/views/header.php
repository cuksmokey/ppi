<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>P P I</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo base_url(); ?>assets/logo_ppi.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="<?php echo base_url(); ?>assets/css/font.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/font-icon.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Light Gallery Plugin Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/light-gallery/css/lightgallery.css" rel="stylesheet">

    <!-- Animation Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Multi Select Css -->
    <!-- <link href="<?php echo base_url(); ?>assets/plugins/multi-select/css/multi-select.css" rel="stylesheet"> -->

    <!-- Bootstrap Select Css -->
    <!-- <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" /> -->

    <!-- JQuery DataTable Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Sweetalert Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url(); ?>assets/css/themes/all-themes.css" rel="stylesheet" />
</head>

<style>
    .list li:hover {
        background: rgba(222, 222, 222, 0.5);
    }
</style>

<body class="theme-red">
	
    <!-- Page Loader -->
    <!-- <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div> -->


    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo base_url(); ?>">PT. PRIMA PAPER INDONESIA</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Notifications -->
                    <!-- <li class="dropdown"> -->
                    <!-- <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li> -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?php echo base_url(); ?>assets/images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata('username'); ?></div>
                    <div class="email"><?php echo $this->session->userdata('nm_user'); ?></div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <?php if ($this->session->userdata('level') == "SuperAdmin") { ?>
                    <!-- <li>
                        <a href="<?php echo base_url() ?>">
                            <span>Dashboard</span>
                        </a>
                    </li> -->
					<li>
						<a href="<?php echo base_url('Master/RPK') ?>">
							<!-- <i class="material-icons">list</i> -->
							<span>R P K</span>
						</a>
					</li>
                    <?php } ?>
                    <li>
                        <?php if ($this->session->userdata('level') == "SuperAdmin" || $this->session->userdata('level') == "Rewind1" || $this->session->userdata('level') == "Rewind2") { ?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <!-- <i class="material-icons">book</i> -->
                            <span>Master</span>
                        </a>
                        <?php } ?>
                        <ul class="ml-menu">
                        <?php if ($this->session->userdata('level') == "SuperAdmin" || $this->session->userdata('level') == "Rewind1" || $this->session->userdata('level') == "Rewind2") { ?>
                            <li>
                                <a href="<?php echo base_url('Master/Timbangan') ?>">Timbangan</a>
                            </li>
                        <?php } ?>
                            <?php if ($this->session->userdata('level') == "SuperAdmin") { ?>
                                <li>
                                    <a href="<?php echo base_url('Master/Perusahaan') ?>">Perusahaan</a>
                                </li>
                                <!-- <li>
                                    <a href="<?php echo base_url('Master/PO') ?>">PO</a>
                                </li> -->
                            <?php } ?>
                        </ul>
                    </li>
                    <?php if ($this->session->userdata('level') == "SuperAdmin") { ?>
                        <!-- <li>
                            <a href="<?php echo base_url('Master/Packing_list') ?>">
                                <span>Packing List</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Master/Invoice') ?>">
                                <span>Invoice</span>
                            </a>
                        </li> -->
                    <?php } ?>
                    <?php if ($this->session->userdata('level') == "SuperAdmin" || $this->session->userdata('level') == "Admin" || $this->session->userdata('level') == "Office") { ?>
                        <li>
                            <a href="<?php echo base_url('Laporan/Penjualan_PO') ?>">
                                <!-- <i class="material-icons">list</i> -->
                                <span>Outstanding PO</span>
                            </a>
                        </li>
                    <?php } ?>
					<?php if($this->session->userdata('level') == "SuperAdmin" || $this->session->userdata('level') == "Admin" || $this->session->userdata('level') == "Office" || $this->session->userdata('level') == "FG" || $this->session->userdata('level') == "QC") {?>
					<li>
						<a href="<?php echo base_url('Laporan/Stok_Gudang') ?>">
							<!-- <i class="material-icons">list</i> -->
							<span>Stok Gudang + Produksi</span>
						</a>
					</li>
					<?php } ?>
                    <?php if ($this->session->userdata('level') == "SuperAdmin" || $this->session->userdata('level') == "Admin" || $this->session->userdata('level') == "FG") { ?>
                        <li>
                            <a href="<?php echo base_url('Master/Expedisi') ?>">
                                <!-- <i class="material-icons">list</i> -->
                                <span>Ekspedisi</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($this->session->userdata('level') == "SuperAdmin" || $this->session->userdata('level') == "Admin" || $this->session->userdata('level') == "FG" || $this->session->userdata('level') == "QC") { ?>
                        <li>
                            <a href="<?php echo base_url('Laporan/Pengiriman_Roll') ?>">
                                <!-- <i class="material-icons">list</i> -->
                                <span>Pengiriman</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Laporan/List_Roll') ?>">
                                <!-- <i class="material-icons">list</i> -->
                                <span>List Roll</span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
						<?php if ($this->session->userdata('level') == "SuperAdmin" || $this->session->userdata('level') == "Admin" || $this->session->userdata('level') == "QC") {?>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <!-- <i class="material-icons">equalizer</i> -->
                            <span>Laporan</span>
                        </a>
						<?php } ?>
                        <ul class="ml-menu">
                            <?php if ($this->session->userdata('level') == "SuperAdmin" || $this->session->userdata('level') == "Admin" || $this->session->userdata('level') == "QC") { ?>
                                <li>
                                    <a href="<?php echo base_url('Laporan/Timbangan') ?>">TIMBANGAN</a>
                                </li>
                            <?php } ?>
                            <?php if ($this->session->userdata('level') == "SuperAdmin" || $this->session->userdata('level') == "Admin") { ?>
                                <li>
                                    <a href="<?php echo base_url('Laporan/PenjualanHarian') ?>">PENJUALAN HARIAN</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('Laporan/PenjualanRekap') ?>">PENJUALAN REKAP</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('Laporan/PenjualanTahunan') ?>">PENJUALAN TAHUNAN</a>
                                </li>
                                <!-- <li>
                                    <a href="<?php echo base_url('Laporan/LaporanInvoice') ?>">INVOICE</a>
                                </li> -->
                                <!-- <li>
                                    <a href="<?php echo base_url('Laporan/POCorrugated') ?>">PO CORRUGATED</a>
                                </li> -->
                                <!-- <li>
                                    <a href="<?php echo base_url('Laporan/csv') ?>">CSV</a>
                                </li> -->
                                <!-- <li>
                                    <a href="<?php echo base_url('Laporan/print_label_pl') ?>">LABEL PACKING LIST</a>
                                </li> -->
                                <!-- <li>
                                    <a href="<?php echo base_url('Laporan/print_sj') ?>">SURAT JALAN + PACKING LIST</a>
                                </li> -->
                                <!-- <li>
                                    <a href="<?php echo base_url('Laporan/update_stok_gudang') ?>">UPDATE STOK GUDANG</a>
                                </li> -->
                                <!-- <li>
                                    <a href="<?php echo base_url('Laporan/update_po') ?>">UPDATE PO</a>
                                </li> -->
                            <?php } ?>
                        </ul>
                    </li>
                    <?php if ($this->session->userdata('level') == "SuperAdmin" || $this->session->userdata('level') == "Admin" || $this->session->userdata('level') == "FG" || $this->session->userdata('level') == "QC") { ?>
                        <li>
                            <a href="<?php echo base_url('Master/Administrator') ?>">
                                <!-- <i class="material-icons">list</i> -->
                                <span>Administrator</span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo base_url('Login/logout') ?>">
                            <!-- <i class="material-icons">logout</i> -->
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- if($this->session->userdata('username') == "develop") -->
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    P P I
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <<!-- aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" class="active">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
            </div>
            </aside> -->
            <!-- #END# Right Sidebar -->
    </section>

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/js/jquery.priceformat.js"></script> -->
