/*
SQLyog Professional v12.4.3 (64 bit)
MySQL - 10.1.38-MariaDB : Database - si_timbangan
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `m_timbangan` */

DROP TABLE IF EXISTS `m_timbangan`;

CREATE TABLE `m_timbangan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roll` varchar(50) NOT NULL,
  `tgl` date DEFAULT NULL,
  `nm_ker` varchar(50) DEFAULT NULL,
  `g_ac` int(11) DEFAULT NULL,
  `g_label` varchar(50) DEFAULT NULL,
  `width` decimal(8,2) DEFAULT NULL,
  `diameter` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `joint` int(11) DEFAULT NULL,
  `ket` text,
  `status` int(1) DEFAULT '0',
  `id_pl` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(50) DEFAULT NULL,
  `packing_at` timestamp NULL DEFAULT NULL,
  `packing_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`,`roll`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `m_timbangan` */

insert  into `m_timbangan`(`id`,`roll`,`tgl`,`nm_ker`,`g_ac`,`g_label`,`width`,`diameter`,`weight`,`joint`,`ket`,`status`,`id_pl`,`created_at`,`created_by`,`packing_at`,`packing_by`) values 
(1,'12345/12/1/M','2019-10-02','test',12,'test',12.00,12,12,0,NULL,1,1,'2019-10-02 09:06:36','admin','2019-10-04 08:54:31','admin'),
(2,'11111/11/1/1','2019-10-02','as',1,'aa',2.00,2,10,1,NULL,1,1,'2019-10-02 10:06:43',NULL,NULL,NULL),
(3,'12345/11/1/M','2019-10-04','as',1,'aa',11.00,11,11,1,NULL,0,0,'2019-10-04 08:40:24',NULL,NULL,NULL),
(4,'11113/11/1/m','2019-10-04','',1,'',3.00,1,2,1,'as',0,0,'2019-10-04 08:42:13',NULL,'2019-10-04 08:54:37','admin'),
(5,'66666/66/6/v','2019-10-11','WP',1,'67',1.00,5,5,0,NULL,1,10,'2019-10-11 11:10:12',NULL,NULL,NULL),
(6,'12312/11/1/M','2019-10-25','WP',12,'67',120.00,2,10,0,NULL,0,0,'2019-10-25 07:56:09',NULL,NULL,NULL);

/*Table structure for table `pl` */

DROP TABLE IF EXISTS `pl`;

CREATE TABLE `pl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` date DEFAULT NULL,
  `no_surat` varchar(99) NOT NULL,
  `no_so` varchar(99) NOT NULL,
  `no_pkb` varchar(99) NOT NULL,
  `no_kendaraan` varchar(99) DEFAULT NULL,
  `nm_perusahaan` varchar(99) DEFAULT NULL,
  `alamat_perusahaan` text,
  `nama` varchar(99) DEFAULT NULL,
  `no_telp` varchar(99) DEFAULT NULL,
  `no_po` varchar(99) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(99) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` varchar(99) DEFAULT NULL,
  PRIMARY KEY (`no_surat`,`no_so`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `pl` */

insert  into `pl`(`id`,`tgl`,`no_surat`,`no_so`,`no_pkb`,`no_kendaraan`,`nm_perusahaan`,`alamat_perusahaan`,`nama`,`no_telp`,`no_po`,`created_at`,`created_by`,`updated_at`,`updated_by`) values 
(1,'2019-10-11','11','111','111','111','test','jl. test','test1','111','111','2019-10-11 09:05:24','rian','2019-10-11 10:30:50','admin'),
(10,'2019-10-11','66','66','66','66','66','66','66','66','66','2019-10-11 12:57:18',NULL,'2019-10-11 13:07:19','admin');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nm_user` varchar(50) DEFAULT NULL,
  `level` enum('Admin','User') DEFAULT NULL,
  PRIMARY KEY (`id`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`password`,`nm_user`,`level`) values 
(1,'admin','202cb962ac59075b964b07152d234b70','Admin Aplikasi','Admin'),
(2,'user','ee11cbb19052e40b07aac0ca060c23ee','Admin user','User');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
