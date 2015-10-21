CREATE TABLE IF NOT EXISTS `[table_prefix]shares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `share_name` varchar(255) NOT NULL,
  `buying_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `commision` int(11) NOT NULL,
  `status` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;