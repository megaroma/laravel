/*
SQLyog Community v10.2 
MySQL - 5.5.38-MariaDB-log : Database - beltonetest
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`beltonetest` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `beltonetest`;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loginname` char(20) NOT NULL,
  `loginpasswd` char(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `customer_id` int(11) NOT NULL COMMENT 'CONSTRAINT FOREIGN KEY (customer_id) REFERENCES customers(id)',
  `device_id` int(11) DEFAULT NULL COMMENT 'CONSTRAINT FOREIGN KEY (device_id) REFERENCES devices(id)',
  `access_level_number` int(11) NOT NULL,
  `inbound_track_manager` tinyint(1) NOT NULL DEFAULT '0',
  `pstn_telephone` char(10) DEFAULT NULL,
  `email_address` varchar(200) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `loginname` (`loginname`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=299 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`loginname`,`loginpasswd`,`name`,`customer_id`,`device_id`,`access_level_number`,`inbound_track_manager`,`pstn_telephone`,`email_address`,`timestamp`,`created_at`,`updated_at`) values (1,'khalliburton','tele2','Keri Halliburton',1,11,10,0,'6063292644',NULL,'2013-06-21 19:36:52',NULL,NULL),(3,'eholley','belblue','Elisha Holley',1,7,5,0,'3045257221','eholley@beltonetristate.com','2014-06-07 18:50:53',NULL,NULL),(5,'aschaffer','stephanie','Andy Schaffer',1,0,10,0,'3045257221','','2014-02-17 12:06:45',NULL,NULL),(7,'franktest1','franktest','Frank Test',1,3,5,0,NULL,NULL,'2013-06-10 11:38:37',NULL,NULL),(267,'jdearfield','portsmouth','Joni Dearfield',1,23,10,0,NULL,NULL,'2014-05-07 10:24:24',NULL,NULL),(11,'billm','billmatt1249','Bill Mattingly',7,5,5,0,NULL,NULL,NULL,NULL,NULL),(13,'frank','frank','Frank ',3,1,5,1,NULL,NULL,'2013-01-24 11:56:29',NULL,NULL),(15,'vbrumfield','hearing','Vicki Brumfield',1,13,10,0,'7404461744','',NULL,NULL,NULL),(51,'test','test','testttttt',3,0,5,0,'','',NULL,NULL,NULL),(271,'dtuminski','winchester','Deana Tuminski',1,57,10,0,NULL,NULL,'2014-04-30 14:46:35',NULL,NULL),(31,'jcomfort','hearing10','Jacquelyn Comfort',1,31,10,0,'7407796023','',NULL,NULL,NULL),(254,'mpalmer','smile','Margaret Palmer',1,15,10,0,NULL,NULL,'2014-03-07 07:06:50',NULL,NULL),(37,'shall','winner','Sharon Hall',1,37,10,0,'6064328060','',NULL,NULL,NULL),(43,'jgumm','jkg7559','Janice Gumm',1,21,10,0,'3043423300','',NULL,NULL,NULL),(45,'mmattingly','blondie','Marsha Mattingly',1,0,5,0,'3045257221',NULL,'2013-07-11 10:20:12',NULL,NULL),(55,'sadkins','juice1','Stephanie Adkins',1,0,5,0,'3045257221','','2014-02-17 12:11:22',NULL,NULL),(96,'mschwartz','swimming','Mary Ann Schwartz',1,0,5,0,'5133778959','mschwartz@beltonetristate.com','2014-02-17 12:08:33',NULL,NULL),(61,'carlt','billmatt1249','Carl Trube',7,43,10,0,NULL,NULL,'2011-12-10 08:39:17',NULL,NULL),(202,'bferguson','hcp1','Ben Ferguson',1,0,10,0,NULL,NULL,'2014-02-17 12:07:10',NULL,NULL),(65,'jwhitt','bffmc','Janet Whitt',1,72,10,0,'','jwhitt@beltonetristate.com','2014-06-19 16:05:31',NULL,NULL),(194,'namrhein','amrhein','Nick Amrhein',1,NULL,5,0,NULL,'namrhein@beltonetristate.com','2014-02-17 12:11:16',NULL,NULL),(153,'janderson','David1804','Jennifer Anderson',1,49,10,0,NULL,'princeton@beltonetristate.com','2013-06-17 15:15:36',NULL,NULL),(176,'nvoss','notnow1234XXX','Nathan Voss',16,0,5,0,NULL,NULL,'2014-06-11 16:09:50',NULL,NULL),(226,'kcrozier','coshocton','Karen Crozier',1,52,10,0,NULL,NULL,'2013-11-20 22:42:42',NULL,NULL),(105,'stuminski','success','Sharon Tuminski',1,81,10,0,'8597459907','winchester@beltonetristate.com','2014-04-30 14:49:10',NULL,NULL),(224,'ttaylor','smiles','Tina Taylor',1,59,10,0,NULL,NULL,'2013-07-16 14:53:15',NULL,NULL),(247,'cchinn','huntington','Carrie Chinn',1,79,10,0,NULL,NULL,'2014-07-03 12:17:09',NULL,NULL),(160,'scott','brutus1','Scott Brock',3,0,5,0,NULL,NULL,'2013-04-26 09:52:24',NULL,NULL),(115,'jjackson','jefferson','Judy Jackson',1,27,10,0,'3045257221','jjackson@beltonetristate.com','2012-09-18 12:56:37',NULL,NULL),(298,'adeaton','richmond','Amanda Deaton',1,67,10,0,NULL,NULL,'2014-07-16 15:34:08',NULL,NULL),(125,'agilbert','smiley','Alice Gilbert',1,53,10,0,NULL,'Danville@Beltonetristate.com','2013-12-16 16:11:24',NULL,NULL),(196,'ecole','Cheerful','Gina Cole',1,78,10,0,NULL,NULL,'2014-06-11 16:29:03',NULL,NULL),(158,'bbyrd','organize','Bryttani Byrd',3,74,10,0,'5138423722','bryttani@impactfax.com','2013-01-24 12:19:52',NULL,NULL),(142,'nchamra','billy','Nasha Hamra',1,0,10,0,'3045257221','ncharma@beltonetristate.com','2014-02-17 12:07:37',NULL,NULL),(144,'mwalton','smiles','Malcolm Walton',1,0,5,0,'3045257221',NULL,'2014-05-06 20:54:07',NULL,NULL),(269,'astamper','lexington','Ashley Stamper',1,25,10,0,NULL,NULL,'2014-04-30 12:40:55',NULL,NULL),(262,'bgoudy','parkersburg','Bridgette Goudy',1,35,10,0,NULL,NULL,'2014-06-27 10:47:01',NULL,NULL),(166,'dmiller','cheerful','Denise Miller',1,39,10,0,NULL,NULL,'2013-02-06 12:47:22',NULL,NULL),(180,'jstucker','holly','Judy Stucker',1,61,10,0,NULL,'Frankfort@beltonetristate.com','2013-04-30 21:21:29',NULL,NULL),(275,'cstewart','callgirls','Chelsey Stewart',17,83,10,0,NULL,NULL,'2014-06-06 13:32:05',NULL,NULL),(200,'adonchatz','hcp1','Andrew Donchatz',1,NULL,10,0,NULL,NULL,'2014-02-17 12:07:46',NULL,NULL),(238,'spatrick','casey','Sonya Patrick',1,91,5,0,NULL,'spatrick@beltonetristate.com','2014-05-30 10:55:04',NULL,NULL),(274,'mleightenheimer','grandma','Mary Leightenheimer',1,82,10,0,NULL,NULL,'2014-05-17 18:05:49',NULL,NULL),(188,'lcook','manycalls','Lawona Cook',1,45,10,0,NULL,NULL,'2013-05-16 13:52:45',NULL,NULL),(204,'brferguson','hcp1','Brad Ferguson',1,NULL,10,0,NULL,NULL,'2014-02-17 12:07:49',NULL,NULL),(296,'dwren','marietta','Deborah Wren',1,33,10,0,NULL,NULL,'2014-07-16 15:32:45',NULL,NULL),(208,'gblevins','hcp1','Greg Blevins',1,NULL,10,0,NULL,NULL,'2014-02-17 12:07:52',NULL,NULL),(210,'kharris','hcp1','Katie Harris',1,NULL,10,0,NULL,NULL,'2014-02-17 12:07:54',NULL,NULL),(212,'apeery','hcp1','Andy Perry',1,NULL,10,0,NULL,NULL,'2014-02-17 12:07:59',NULL,NULL),(214,'mhunt','hcp1','Michael Hunt',1,NULL,10,0,NULL,NULL,'2014-02-17 12:08:00',NULL,NULL),(264,'cbrown','success','Cowana Brown',1,0,10,0,NULL,NULL,'2014-07-03 12:17:07',NULL,NULL),(218,'sswann','hcp1','Sara Swann',1,NULL,10,0,NULL,NULL,'2014-02-17 12:08:01',NULL,NULL),(220,'tjenkins','hcp1','Tiffany Jenkins',1,NULL,10,0,NULL,NULL,'2014-02-17 12:08:02',NULL,NULL),(222,'wamrhein','hcp1','William Amrhein',1,NULL,10,0,NULL,NULL,'2014-02-17 12:08:06',NULL,NULL),(235,'dlilly','TeamNick','Donna Lilly',1,47,10,0,NULL,NULL,'2013-11-07 21:20:21',NULL,NULL),(244,'jwallis','smiles','James Wallis',1,NULL,5,0,NULL,NULL,'2014-02-17 12:11:08',NULL,NULL),(268,'jjohnson','callcenter','Jennifer Johnson',1,69,10,0,NULL,NULL,'2014-04-22 07:07:52',NULL,NULL),(258,'zsetliff','huntington','Zach Setliff',1,41,5,0,NULL,NULL,'2014-07-30 15:31:58',NULL,NULL),(277,'tvanetten','callgirls','Tonya VanEtten',17,87,10,0,NULL,NULL,'2014-06-07 07:55:16',NULL,NULL),(279,'cblack','callgirls','Christian Black',17,85,10,0,NULL,NULL,'2014-06-06 13:32:08',NULL,NULL),(281,'esawyer','jalen100','Erica Sawyer',17,89,5,0,NULL,'esawyer@beltonetn.com','2014-07-22 07:38:07',NULL,NULL),(283,'pebel','BTN50861','Perry Ebel',17,NULL,5,0,NULL,NULL,'2014-06-06 13:32:10',NULL,NULL),(285,'bsnowden','hunterBNE','Brian Snowden',17,NULL,5,0,NULL,NULL,'2014-06-06 13:32:11',NULL,NULL),(287,'eryan','BNYbetsy','Edwin Ryan',17,NULL,5,0,NULL,NULL,'2014-06-06 13:32:14',NULL,NULL),(289,'smills','callgirls','Stacey Mills',17,93,10,0,NULL,NULL,'2014-06-11 11:29:22',NULL,NULL),(291,'tmyers','coshocton','Tiffany Myers',1,50,10,0,NULL,NULL,'2014-06-11 20:47:15',NULL,NULL),(293,'mbanks','ironton','Missy Banks',1,19,10,0,NULL,NULL,'2014-06-19 13:03:10',NULL,NULL),(295,'bturner','Manycalls','Bridgette Turner',1,29,10,0,NULL,NULL,'2014-06-13 14:43:20',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
