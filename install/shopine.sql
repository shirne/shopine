SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

DROP TABLE IF EXISTS `si_invited_history`;

CREATE TABLE `si_invited_history` (
  `invited_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `invited_id` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`invited_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `si_customer`;

CREATE TABLE `si_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `username` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `firstname` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `lastname` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `companyname` VARCHAR(150) NULL DEFAULT '',
  `email` varchar(96) COLLATE utf8_bin NOT NULL DEFAULT '',
  `telephone` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `fax` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `password` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `cart` text COLLATE utf8_bin,
  `wishlist` text COLLATE utf8_bin,
  `newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `address_id` int(11) NOT NULL DEFAULT '0',
  `customer_group_id` int(11) NOT NULL,
  `ip` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `active_code` varchar(160) COLLATE utf8_bin DEFAULT NULL,
  `code` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shipping_method` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `payment_method` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_user`;

CREATE TABLE `si_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',
  `password` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `firstname` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `lastname` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `email` varchar(96) COLLATE utf8_bin NOT NULL DEFAULT '',
  `code` varchar(32) COLLATE utf8_bin NOT NULL,
  `ip` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_category_to_store`;

CREATE TABLE `si_category_to_store` (
  `category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_setting`;

CREATE TABLE `si_setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `group` varchar(32) COLLATE utf8_bin NOT NULL,
  `key` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `value` text COLLATE utf8_bin NOT NULL,
  `serialized` tinyint(1) NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('21122', '0', 'shipping', 'shipping_sort_order', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('3453', '0', 'sub_total', 'sub_total_sort_order', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('3452', '0', 'sub_total', 'sub_total_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('272', '0', 'tax', 'tax_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('16013', '0', 'total', 'total_sort_order', '9', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('16012', '0', 'total', 'total_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('273', '0', 'tax', 'tax_sort_order', '5', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25972', '0', 'free_checkout', 'free_checkout_sort_order', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26096', '0', 'cod', 'cod_sort_order', '5', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26094', '0', 'cod', 'cod_geo_zone_id', '5', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26093', '0', 'cod', 'cod_order_status_id', '13', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('21121', '0', 'shipping', 'shipping_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('21120', '0', 'shipping', 'shipping_estimator', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('13801', '0', 'coupon', 'coupon_sort_order', '4', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('13800', '0', 'coupon', 'coupon_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25947', '0', 'flat', 'flat_sort_order', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25946', '0', 'flat', 'flat_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25945', '0', 'flat', 'flat_geo_zone_id', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25944', '0', 'flat', 'flat_tax_class_id', '9', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26364', '0', 'carousel', 'carousel_module', 'a:1:{i:0;a:9:{s:9:"banner_id";s:2:"11";s:5:"limit";s:1:"5";s:6:"scroll";s:1:"3";s:5:"width";s:2:"80";s:6:"height";s:2:"80";s:9:"layout_id";s:1:"1";s:8:"position";s:14:"content_bottom";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"3";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26642', '0', 'config', 'config_image_manufacturer_height', '240', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26650', '0', 'config', 'config_image_wishlist_height', '80', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25943', '0', 'flat', 'flat_cost', '5.00', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('9444', '0', 'credit', 'credit_sort_order', '7', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('9443', '0', 'credit', 'credit_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('18432', '0', 'reward', 'reward_sort_order', '2', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('18431', '0', 'reward', 'reward_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25516', '0', 'affiliate', 'affiliate_module', 'a:1:{i:0;a:4:{s:9:"layout_id";s:2:"10";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25515', '0', 'google_sitemap', 'google_sitemap_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25971', '0', 'free_checkout', 'free_checkout_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25970', '0', 'free_checkout', 'free_checkout_order_status_id', '15', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('24385', '0', 'slideshow', 'slideshow_module', 'a:1:{i:0;a:7:{s:9:"banner_id";s:1:"9";s:5:"width";s:3:"960";s:6:"height";s:3:"280";s:9:"layout_id";s:1:"1";s:8:"position";s:11:"content_top";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"0";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26651', '0', 'config', 'config_image_cart_width', '80', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25466', '0', 'account', 'account_module', 'a:1:{i:0;a:4:{s:9:"layout_id";s:1:"6";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26649', '0', 'config', 'config_image_wishlist_width', '80', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25936', '0', 'free', 'free_total', '200', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25937', '0', 'free', 'free_geo_zone_id', '12', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25938', '0', 'free', 'free_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26648', '0', 'config', 'config_image_compare_height', '120', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25925', '0', 'weight', 'weight_6_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26647', '0', 'config', 'config_image_compare_width', '90', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26646', '0', 'config', 'config_image_related_height', '120', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26645', '0', 'config', 'config_image_related_width', '90', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26644', '0', 'config', 'config_image_additional_height', '120', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26643', '0', 'config', 'config_image_additional_width', '90', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26641', '0', 'config', 'config_image_manufacturer_width', '180', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26640', '0', 'config', 'config_image_category_height', '180', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26639', '0', 'config', 'config_image_category_width', '180', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26638', '0', 'config', 'config_image_product_height', '240', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26637', '0', 'config', 'config_image_product_width', '180', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26636', '0', 'config', 'config_image_popup_height', '1600', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26635', '0', 'config', 'config_image_popup_width', '1200', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26634', '0', 'config', 'config_image_thumb_height', '450', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26633', '0', 'config', 'config_image_thumb_width', '340', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26631', '0', 'config', 'config_logo', 'data/logo/logo.png', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26518', '0', 'config', 'config_cart_weight', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26517', '0', 'config', 'config_upload_allowed', 'jpg, JPG, jpeg, gif, png, txt', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26516', '0', 'config', 'config_download', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26505', '0', 'config', 'config_review_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26515', '0', 'config', 'config_return_status_id', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26514', '0', 'config', 'config_complete_status_id', '5', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26628', '0', 'config', 'config_order_status_id', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26512', '0', 'config', 'config_stock_status_id', '7', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26627', '0', 'config', 'config_stock_checkout', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26513', '0', 'config', 'config_stock_warning', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26626', '0', 'config', 'config_stock_display', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26511', '0', 'config', 'config_commission', '5', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26510', '0', 'config', 'config_affiliate_id', '5', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26625', '0', 'config', 'config_checkout_id', '3', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26624', '0', 'config', 'config_account_id', '5', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26630', '0', 'config', 'config_guest_checkout', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26623', '0', 'config', 'config_customer_approval', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26622', '0', 'config', 'config_customer_price', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26621', '0', 'config', 'config_customer_group_id', '8', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26502', '0', 'config', 'config_invoice_prefix', 'GOOD/001', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26620', '0', 'config', 'config_tax', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26501', '0', 'config', 'config_admin_limit', '40', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26619', '0', 'config', 'config_catalog_limit', '15', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26509', '0', 'config', 'config_weight_class_id', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26508', '0', 'config', 'config_length_class_id', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('24038', '0', 'config', 'config_currency_auto', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26618', '0', 'config', 'config_currency', 'CNY', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26616', '0', 'config', 'config_zone_id', '700', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26617', '0', 'config', 'config_language', 'cn', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26507', '0', 'config', 'config_admin_language', 'cn', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26615', '0', 'config', 'config_country_id', '44', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26614', '0', 'config', 'config_layout_id', '4', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26613', '0', 'config', 'config_template', 'default', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26611', '0', 'config', 'config_meta_description', 'Shopine网店系统,真正开源的PHP中文网店系统,真正开源免费的中文开源网店系统', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26610', '0', 'config', 'config_title', 'Shopine -  中文开源网店系统', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26609', '0', 'config', 'config_fax', '', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26608', '0', 'config', 'config_telephone', '123456789', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26605', '0', 'config', 'config_owner', 'Shirne', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26604', '0', 'config', 'config_name', 'Shopine', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26652', '0', 'config', 'config_image_cart_height', '80', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26491', '0', 'config', 'config_use_ssl', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26492', '0', 'config', 'config_seo_url', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26493', '0', 'config', 'config_maintenance', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26494', '0', 'config', 'config_encryption', '12345', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26495', '0', 'config', 'config_compression', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26497', '0', 'config', 'config_error_display', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26498', '0', 'config', 'config_error_log', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26499', '0', 'config', 'config_error_filename', 'error.txt', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26500', '0', 'config', 'config_google_analytics', '', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26481', '0', 'config', 'config_mail_protocol', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26482', '0', 'config', 'config_mail_parameter', '', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26483', '0', 'config', 'config_smtp_host', '', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26484', '0', 'config', 'config_smtp_username', '', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26485', '0', 'config', 'config_smtp_password', '', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26486', '0', 'config', 'config_smtp_port', '25', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26487', '0', 'config', 'config_smtp_timeout', '5', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26488', '0', 'config', 'config_alert_mail', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26489', '0', 'config', 'config_account_mail', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26490', '0', 'config', 'config_alert_emails', '', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26569', '0', 'config', 'config_url', 'http://localhost/ts/shopine20/', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26387', '0', 'latest', 'latest_module', 'a:1:{i:0;a:7:{s:5:"limit";s:1:"4";s:11:"image_width";s:3:"230";s:12:"image_height";s:3:"300";s:9:"layout_id";s:1:"1";s:8:"position";s:11:"content_top";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26503', '0', 'config', 'config_active', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26629', '0', 'config', 'config_order_nopay_status_id', '16', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26506', '0', 'config', 'config_invite_points', '100', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25033', '0', 'banner', 'banner_module', 'a:3:{i:0;a:7:{s:9:"banner_id";s:2:"10";s:5:"width";s:3:"182";s:6:"height";s:3:"182";s:9:"layout_id";s:1:"3";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"3";}i:1;a:7:{s:9:"banner_id";s:2:"10";s:5:"width";s:3:"960";s:6:"height";s:3:"135";s:9:"layout_id";s:1:"1";s:8:"position";s:11:"content_top";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}i:2;a:7:{s:9:"banner_id";s:2:"12";s:5:"width";s:3:"770";s:6:"height";s:3:"140";s:9:"layout_id";s:1:"3";s:8:"position";s:14:"content_bottom";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"3";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26606', '0', 'config', 'config_address', '信风信息科技有限公司', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26607', '0', 'config', 'config_email', 'shopine@gmail.com', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26612', '0', 'config', 'config_meta_keyword', 'Shopine,网店系统,开源PHP中文网店系统,开源免费网店系统,中文开源网店系统,开源网店系统', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26372', '0', 'citylink', 'citylink_description', '上午发下午到,下午发次日到.', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25926', '0', 'weight', 'weight_7_rate', '5:10.00,7:12.00', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25924', '0', 'weight', 'weight_6_rate', '5:10.00,7:12.00', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25923', '0', 'weight', 'weight_5_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25922', '0', 'weight', 'weight_5_rate', '5:10.00,7:12.00', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25921', '0', 'weight', 'weight_13_status', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25920', '0', 'weight', 'weight_13_rate', '5:10.00,7:12.00', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25919', '0', 'weight', 'weight_12_status', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25918', '0', 'weight', 'weight_12_rate', '5:10.00,7:12.00', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25917', '0', 'weight', 'weight_sort_order', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25916', '0', 'weight', 'weight_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25915', '0', 'weight', 'weight_tax_class_id', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25950', '0', 'pickup', 'pickup_sort_order', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25949', '0', 'pickup', 'pickup_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26095', '0', 'cod', 'cod_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25939', '0', 'free', 'free_sort_order', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25948', '0', 'pickup', 'pickup_geo_zone_id', '5', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25914', '0', 'category', 'category_module', 'a:3:{i:0;a:4:{s:9:"layout_id";s:1:"3";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:1;a:4:{s:9:"layout_id";s:1:"2";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:2;a:4:{s:9:"layout_id";s:2:"13";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25927', '0', 'weight', 'weight_7_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25928', '0', 'weight', 'weight_9_rate', '5:10.00,7:12.00', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25929', '0', 'weight', 'weight_9_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25930', '0', 'weight', 'weight_8_rate', '5:10.00,7:12.00', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25931', '0', 'weight', 'weight_8_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25932', '0', 'weight', 'weight_11_rate', '5:10.00,7:12.00', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25933', '0', 'weight', 'weight_11_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25934', '0', 'weight', 'weight_10_rate', '5:10.00,7:12.00', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25935', '0', 'weight', 'weight_10_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26092', '0', 'cod', 'cod_total', '10', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25973', '0', 'bank_transfer', 'bank_transfer_bank_1', '银行转账', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25974', '0', 'bank_transfer', 'bank_transfer_total', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25975', '0', 'bank_transfer', 'bank_transfer_order_status_id', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25976', '0', 'bank_transfer', 'bank_transfer_geo_zone_id', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25977', '0', 'bank_transfer', 'bank_transfer_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('25978', '0', 'bank_transfer', 'bank_transfer_sort_order', '', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26596', '0', 'config', 'config_default_payment', 'bank_transfer', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26369', '0', 'citylink', 'citylink_tax_class_id', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26370', '0', 'citylink', 'citylink_zone_id', '689', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26371', '0', 'citylink', 'citylink_city_id', '210', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26368', '0', 'citylink', 'citylink_rate', '10:11.6,15:14.1,20:16.60,25:19.1,30:21.6,35:24.1,40:26.6,45:29.1,50:31.6,55:34.1,60:36.6,65:39.1,70:41.6,75:44.1,80:46.6,100:56.6,125:69.1,150:81.6,200:106.6', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26632', '0', 'config', 'config_icon', 'data/demo/ico.png', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26504', '0', 'config', 'config_review', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26268', '0', 'google_talk', 'google_talk_module', 'a:1:{i:0;a:4:{s:9:"layout_id";s:1:"2";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"0";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26480', '0', 'onlineim', 'onlineim_module', 'a:1:{i:0;a:4:{s:9:"layout_id";s:1:"2";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"0";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26324', '0', 'google_base', 'google_base_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26331', '0', 'dealday', 'dealday_module', 'a:1:{i:0;a:7:{s:5:"limit";s:1:"5";s:11:"image_width";s:2:"80";s:12:"image_height";s:2:"80";s:9:"layout_id";s:1:"2";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"3";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26390', '0', 'mostviewed', 'mostviewed_module', 'a:1:{i:0;a:7:{s:5:"limit";s:1:"5";s:11:"image_width";s:3:"120";s:12:"image_height";s:3:"120";s:9:"layout_id";s:1:"2";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26332', '0', 'hotsell', 'hotsell_module', 'a:1:{i:0;a:7:{s:5:"limit";s:1:"5";s:11:"image_width";s:2:"80";s:12:"image_height";s:2:"80";s:9:"layout_id";s:1:"3";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"4";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26496', '0', 'config', 'config_debug', '0', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26362', '0', 'bestseller', 'bestseller_module', 'a:2:{i:0;a:7:{s:5:"limit";s:1:"5";s:11:"image_width";s:2:"80";s:12:"image_height";s:2:"80";s:9:"layout_id";s:1:"2";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"3";}i:1;a:7:{s:5:"limit";s:2:"10";s:11:"image_width";s:2:"80";s:12:"image_height";s:2:"80";s:9:"layout_id";s:2:"14";s:8:"position";s:14:"content_bottom";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26393', '0', 'ims', 'ims', 'a:1:{i:0;a:4:{s:4:"type";s:2:"qq";s:7:"account";s:5:"10000";s:4:"text";s:12:"仅做测试";s:10:"sort_order";s:1:"1";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26388', '0', 'cates', 'cates_module', 'a:1:{i:0;a:8:{s:11:"image_width";s:3:"230";s:12:"image_height";s:3:"300";s:9:"layout_id";s:1:"1";s:8:"position";s:11:"content_top";s:6:"status";s:1:"1";s:4:"cate";s:2:"64";s:5:"count";s:1:"8";s:10:"sort_order";s:1:"2";}}', '1');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26373', '0', 'citylink', 'citylink_status', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES ('26374', '0', 'citylink', 'citylink_sort_order', '1', '0');
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES (26691,0,'config','config_admin_editor','tinymce',0);
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES (26802,0,'config','config_image_article_width','100',0);
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES (26803,0,'config','config_image_article_height','100',0);
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES (26804,0,'config','config_image_article_category_width','100',0);
INSERT INTO `si_setting` (`setting_id`, `store_id`, `group`, `key`, `value`, `serialized`) VALUES (26805,0,'config','config_image_article_category_height','100',0);


DROP TABLE IF EXISTS `si_coupon_history`;

CREATE TABLE `si_coupon_history` (
  `coupon_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL,
  `order_id` varchar(128) COLLATE utf8_bin NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`coupon_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_url_alias`;

CREATE TABLE `si_url_alias` (
  `url_alias_id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(255) COLLATE utf8_bin NOT NULL,
  `keyword` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`url_alias_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_url_alias` VALUES (1361,'common/home','home');
INSERT INTO `si_url_alias` VALUES (1362,'account/account','my-account');
INSERT INTO `si_url_alias` VALUES (1363,'checkout/voucher','voucher');
INSERT INTO `si_url_alias` VALUES (1364,'information/contact','contact-us');
INSERT INTO `si_url_alias` VALUES (1365,'account/return/insert','return-service');
INSERT INTO `si_url_alias` VALUES (1366,'information/sitemap','sitemap');
INSERT INTO `si_url_alias` VALUES (1367,'product/manufacturer','brands');
INSERT INTO `si_url_alias` VALUES (1368,'affiliate/account','affiliate');
INSERT INTO `si_url_alias` VALUES (1369,'affiliate/register','affiliate-register');
INSERT INTO `si_url_alias` VALUES (1370,'affiliate/login','affiliate-login');
INSERT INTO `si_url_alias` VALUES (1371,'affiliate/edit','affiliate-edit');
INSERT INTO `si_url_alias` VALUES (1372,'affiliate/payment','affiliate-payment');
INSERT INTO `si_url_alias` VALUES (1373,'affiliate/password','affiliate-password');
INSERT INTO `si_url_alias` VALUES (1374,'affiliate/tracking','affiliate-tracking');
INSERT INTO `si_url_alias` VALUES (1375,'affiliate/transaction','affiliate-transaction');
INSERT INTO `si_url_alias` VALUES (1376,'affiliate/forgotten','affiliate-forgotten');
INSERT INTO `si_url_alias` VALUES (1377,'affiliate/logout','affiliate-logout');
INSERT INTO `si_url_alias` VALUES (1378,'product/special','special');
INSERT INTO `si_url_alias` VALUES (1379,'account/order','order-history');
INSERT INTO `si_url_alias` VALUES (1380,'account/order/info','order-detail');
INSERT INTO `si_url_alias` VALUES (1381,'account/wishlist','wishlist');
INSERT INTO `si_url_alias` VALUES (1382,'account/login','login');
INSERT INTO `si_url_alias` VALUES (1383,'account/logout','logout');
INSERT INTO `si_url_alias` VALUES (1384,'checkout/checkout','checkout');
INSERT INTO `si_url_alias` VALUES (1385,'product/compare','compare');
INSERT INTO `si_url_alias` VALUES (1386,'account/newsletter','newsletter');
INSERT INTO `si_url_alias` VALUES (1387,'account/forgotten','forgotten');
INSERT INTO `si_url_alias` VALUES (1388,'checkout/cart','cart');
INSERT INTO `si_url_alias` VALUES (1389,'account/register','register');
INSERT INTO `si_url_alias` VALUES (1390,'account/edit','edit-account');
INSERT INTO `si_url_alias` VALUES (1391,'account/address','address');
INSERT INTO `si_url_alias` VALUES (1392,'account/password','password');
INSERT INTO `si_url_alias` VALUES (1393,'account/download','mydownload');
INSERT INTO `si_url_alias` VALUES (1394,'account/reward','reward');
INSERT INTO `si_url_alias` VALUES (1395,'account/transaction','transaction');
INSERT INTO `si_url_alias` VALUES (1396,'account/return','return');
INSERT INTO `si_url_alias` VALUES (1397,'account/address/update','update-address');
INSERT INTO `si_url_alias` VALUES (1398,'account/address/delete','delete-address');
INSERT INTO `si_url_alias` VALUES (1399,'account/return/info','return-info');
INSERT INTO `si_url_alias` VALUES (1400,'account/invite','invite');

DROP TABLE IF EXISTS `si_length_class`;
CREATE TABLE `si_length_class` (
  `length_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `value` decimal(15,8) NOT NULL,
  PRIMARY KEY (`length_class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_length_class` VALUES (1,1.00000000);
INSERT INTO `si_length_class` VALUES (2,10.00000000);
INSERT INTO `si_length_class` VALUES (3,0.39370000);


DROP TABLE IF EXISTS `si_order_product`;

CREATE TABLE `si_order_product` (
  `order_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(128) COLLATE utf8_bin NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `model` varchar(24) COLLATE utf8_bin NOT NULL,
  `quantity` int(4) NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `tax` decimal(15,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`order_product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_article_related`;

CREATE TABLE `si_article_related` (
  `article_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`related_id`),
  KEY `news_id` (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_download_description`;

CREATE TABLE `si_download_description` (
  `download_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`download_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_country`;

CREATE TABLE `si_country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `iso_code_2` varchar(2) COLLATE utf8_bin NOT NULL DEFAULT '',
  `iso_code_3` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '',
  `address_format` text COLLATE utf8_bin NOT NULL,
  `postcode_required` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_country` VALUES (44,'中国','CN','CHN','地址:{zone}{city}{address_1}{address_2} 邮编:{postcode} 手机:{mobile} 电话:{phone}  \r\n收货人: {firstname}\r\n\r\n\r\n\r\n\r\n\r\n\r\n',1,1);

DROP TABLE IF EXISTS `si_customer_ip`;

CREATE TABLE `si_customer_ip` (
  `customer_ip_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `ip` varchar(15) COLLATE utf8_bin NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`customer_ip_id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_attribute_group`;

CREATE TABLE `si_attribute_group` (
  `attribute_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`attribute_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_attribute_description`;

CREATE TABLE `si_attribute_description` (
  `attribute_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`attribute_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_product_attribute`;

CREATE TABLE `si_product_attribute` (
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `text` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`product_id`,`attribute_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_option`;

CREATE TABLE `si_option` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) COLLATE utf8_bin NOT NULL,
  `fixed` TINYINT NULL DEFAULT 0,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_option` VALUES (2,'checkbox',0,3);
INSERT INTO `si_option` VALUES (7,'file',0,6);
INSERT INTO `si_option` VALUES (8,'date',0,7);
INSERT INTO `si_option` VALUES (10,'datetime',0,9);
INSERT INTO `si_option` VALUES (11,'select',0,1);
INSERT INTO `si_option` VALUES (12,'date',0,1);
INSERT INTO `si_option` VALUES (13,'color',0,1);
INSERT INTO `si_option` VALUES (14,'virtual_product',0,11);
INSERT INTO `si_option` VALUES (15,'color',0,1);

DROP TABLE IF EXISTS `si_product_to_category`;

CREATE TABLE `si_product_to_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_return_status`;

CREATE TABLE `si_return_status` (
  `return_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`return_status_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_return_status` VALUES (1,1,'待处理');
INSERT INTO `si_return_status` VALUES (3,1,'完成');
INSERT INTO `si_return_status` VALUES (2,1,'等待发货');


DROP TABLE IF EXISTS `si_order_total`;

CREATE TABLE `si_order_total` (
  `order_total_id` int(10) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(128) COLLATE utf8_bin NOT NULL,
  `code` varchar(32) COLLATE utf8_bin NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `text` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `value` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`order_total_id`),
  KEY `idx_orders_total_orders_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_order_total` VALUES (1178,'201205290753619','shipping','到本商店自取','￥0.00',0.0000,1);
INSERT INTO `si_order_total` VALUES (1179,'201205290753619','sub_total','商品总额','￥22.00',22.0000,1);
INSERT INTO `si_order_total` VALUES (1180,'201205290753619','total','订单总额','￥22.00',22.0000,9);
INSERT INTO `si_order_total` VALUES (3281,'201206101229220','total','订单总额','￥110.60',110.6000,9);
INSERT INTO `si_order_total` VALUES (3280,'201206101229220','sub_total','商品总额','￥99.00',99.0000,1);
INSERT INTO `si_order_total` VALUES (3279,'201206101229220','shipping','同城快递  (重量: 2.00kg)','￥11.60',11.6000,1);
INSERT INTO `si_order_total` VALUES (1263,'201205291108620','total','订单总额','￥200.00',200.0000,9);
INSERT INTO `si_order_total` VALUES (1262,'201205291108620','sub_total','商品总额','￥200.00',200.0000,1);
INSERT INTO `si_order_total` VALUES (1261,'201205291108620','shipping','到本商店自取','￥0.00',0.0000,1);
INSERT INTO `si_order_total` VALUES (3966,'201208080869165','shipping','固定运费','￥5.00',5.0000,1);
INSERT INTO `si_order_total` VALUES (3967,'201208080869165','sub_total','商品总额','￥0.01',0.0100,1);
INSERT INTO `si_order_total` VALUES (3968,'201208080869165','total','订单总额','￥5.01',5.0100,9);
INSERT INTO `si_order_total` VALUES (4038,'201208090748512','total','订单总额','￥10.01',10.0100,9);
INSERT INTO `si_order_total` VALUES (4036,'201208090748512','shipping','快递  (重量: 0.50kg)','￥10.00',10.0000,1);
INSERT INTO `si_order_total` VALUES (4037,'201208090748512','sub_total','商品总额','￥0.01',0.0100,1);

DROP TABLE IF EXISTS `si_option_value`;

CREATE TABLE `si_option_value` (
  `option_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`option_value_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_product_reward`;

CREATE TABLE `si_product_reward` (
  `product_reward_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `customer_group_id` int(11) NOT NULL DEFAULT '0',
  `points` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_reward_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_product_tag`;

CREATE TABLE `si_product_tag` (
  `product_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `tag` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`product_tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_city`;

CREATE TABLE `si_city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `zone_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `center_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`city_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_city` VALUES (3,44,700,'NJ','南京市',1,0);
INSERT INTO `si_city` VALUES (2,44,700,'SZ','苏州市',1,0);
INSERT INTO `si_city` VALUES (4,44,700,'WX','无锡市',1,0);
INSERT INTO `si_city` VALUES (5,44,693,'S','石家庄市',1,0);
INSERT INTO `si_city` VALUES (6,44,693,'T','唐山市',1,0);
INSERT INTO `si_city` VALUES (7,44,693,'Q','秦皇岛市',1,0);
INSERT INTO `si_city` VALUES (8,44,693,'G','邯郸市',1,0);
INSERT INTO `si_city` VALUES (9,44,693,'J','邢台市',1,0);
INSERT INTO `si_city` VALUES (10,44,693,'B','保定市',1,0);
INSERT INTO `si_city` VALUES (11,44,693,'Z','张家口市',1,0);
INSERT INTO `si_city` VALUES (12,44,693,'C','承德市',1,0);
INSERT INTO `si_city` VALUES (13,44,693,'C','沧州市',1,0);
INSERT INTO `si_city` VALUES (14,44,693,'L','廊坊市',1,0);
INSERT INTO `si_city` VALUES (15,44,693,'H','衡水市',1,0);
INSERT INTO `si_city` VALUES (16,44,709,'T','太原市',1,0);
INSERT INTO `si_city` VALUES (17,44,709,'D','大同市',1,0);
INSERT INTO `si_city` VALUES (18,44,709,'Y','阳泉市',1,0);
INSERT INTO `si_city` VALUES (19,44,709,'C','长治市',1,0);
INSERT INTO `si_city` VALUES (20,44,709,'J','晋城市',1,0);
INSERT INTO `si_city` VALUES (21,44,709,'S','朔州市',1,0);
INSERT INTO `si_city` VALUES (22,44,709,'J','晋中市',1,0);
INSERT INTO `si_city` VALUES (23,44,709,'Y','运城市',1,0);
INSERT INTO `si_city` VALUES (24,44,709,'Q','忻州市',1,0);
INSERT INTO `si_city` VALUES (25,44,709,'L','临汾市',1,0);
INSERT INTO `si_city` VALUES (26,44,709,'L','吕梁市',1,0);
INSERT INTO `si_city` VALUES (27,44,715,'T','台北市',1,0);
INSERT INTO `si_city` VALUES (28,44,715,'G','高雄市',1,0);
INSERT INTO `si_city` VALUES (29,44,715,'J','基隆市',1,0);
INSERT INTO `si_city` VALUES (30,44,715,'T','台中市',1,0);
INSERT INTO `si_city` VALUES (31,44,715,'T','台南市',1,0);
INSERT INTO `si_city` VALUES (32,44,715,'X','新竹市',1,0);
INSERT INTO `si_city` VALUES (33,44,715,'J','嘉义市',1,0);
INSERT INTO `si_city` VALUES (34,44,715,'T','台北县',1,0);
INSERT INTO `si_city` VALUES (35,44,715,'Y','宜兰县',1,0);
INSERT INTO `si_city` VALUES (36,44,715,'T','桃园县',1,0);
INSERT INTO `si_city` VALUES (37,44,715,'X','新竹县',1,0);
INSERT INTO `si_city` VALUES (38,44,715,'M','苗栗县',1,0);
INSERT INTO `si_city` VALUES (39,44,715,'T','台中县',1,0);
INSERT INTO `si_city` VALUES (40,44,715,'Z','彰化县',1,0);
INSERT INTO `si_city` VALUES (41,44,715,'N','南投县',1,0);
INSERT INTO `si_city` VALUES (42,44,715,'Y','云林县',1,0);
INSERT INTO `si_city` VALUES (43,44,715,'J','嘉义县',1,0);
INSERT INTO `si_city` VALUES (44,44,715,'T','台南县',1,0);
INSERT INTO `si_city` VALUES (45,44,715,'G','高雄县',1,0);
INSERT INTO `si_city` VALUES (46,44,715,'P','屏东县',1,0);
INSERT INTO `si_city` VALUES (47,44,715,'P','澎湖县',1,0);
INSERT INTO `si_city` VALUES (48,44,715,'T','台东县',1,0);
INSERT INTO `si_city` VALUES (49,44,715,'H','花莲县',1,0);
INSERT INTO `si_city` VALUES (50,44,703,'S','沈阳市',1,0);
INSERT INTO `si_city` VALUES (51,44,703,'D','大连市',1,0);
INSERT INTO `si_city` VALUES (52,44,703,'A','鞍山市',1,0);
INSERT INTO `si_city` VALUES (53,44,703,'F','抚顺市',1,0);
INSERT INTO `si_city` VALUES (54,44,703,'B','本溪市',1,0);
INSERT INTO `si_city` VALUES (55,44,703,'D','丹东市',1,0);
INSERT INTO `si_city` VALUES (56,44,703,'J','锦州市',1,0);
INSERT INTO `si_city` VALUES (57,44,703,'Y','营口市',1,0);
INSERT INTO `si_city` VALUES (58,44,703,'F','阜新市',1,0);
INSERT INTO `si_city` VALUES (59,44,703,'L','辽阳市',1,0);
INSERT INTO `si_city` VALUES (60,44,703,'P','盘锦市',1,0);
INSERT INTO `si_city` VALUES (61,44,703,'T','铁岭市',1,0);
INSERT INTO `si_city` VALUES (62,44,703,'Z','朝阳市',1,0);
INSERT INTO `si_city` VALUES (63,44,703,'H','葫芦岛市',1,0);
INSERT INTO `si_city` VALUES (64,44,702,'C','长春市',1,0);
INSERT INTO `si_city` VALUES (65,44,702,'J','吉林市',1,0);
INSERT INTO `si_city` VALUES (66,44,702,'S','四平市',1,0);
INSERT INTO `si_city` VALUES (67,44,702,'L','辽源市',1,0);
INSERT INTO `si_city` VALUES (68,44,702,'T','通化市',1,0);
INSERT INTO `si_city` VALUES (69,44,702,'B','白山市',1,0);
INSERT INTO `si_city` VALUES (70,44,702,'S','松原市',1,0);
INSERT INTO `si_city` VALUES (71,44,702,'B','白城市',1,0);
INSERT INTO `si_city` VALUES (72,44,702,'Y','延边朝鲜族自治州',1,0);
INSERT INTO `si_city` VALUES (73,44,694,'H','哈尔滨市',1,0);
INSERT INTO `si_city` VALUES (74,44,694,'Q','齐齐哈尔市',1,0);
INSERT INTO `si_city` VALUES (75,44,694,'H','鹤岗市',1,0);
INSERT INTO `si_city` VALUES (76,44,694,'S','双鸭山市',1,0);
INSERT INTO `si_city` VALUES (77,44,694,'J','鸡市',1,0);
INSERT INTO `si_city` VALUES (78,44,694,'D','大庆市',1,0);
INSERT INTO `si_city` VALUES (79,44,694,'Y','伊春市',1,0);
INSERT INTO `si_city` VALUES (80,44,694,'M','牡丹江市',1,0);
INSERT INTO `si_city` VALUES (81,44,694,'J','佳木斯市',1,0);
INSERT INTO `si_city` VALUES (82,44,694,'Q','七台河市',1,0);
INSERT INTO `si_city` VALUES (83,44,694,'H','黑河市',1,0);
INSERT INTO `si_city` VALUES (84,44,694,'S','绥化市',1,0);
INSERT INTO `si_city` VALUES (85,44,694,'D','大兴安岭地区',1,0);
INSERT INTO `si_city` VALUES (86,44,700,'X','徐州市',1,0);
INSERT INTO `si_city` VALUES (87,44,700,'C','常州市',1,0);
INSERT INTO `si_city` VALUES (88,44,700,'N','南通市',1,0);
INSERT INTO `si_city` VALUES (89,44,700,'L','连云港市',1,0);
INSERT INTO `si_city` VALUES (90,44,700,'H','淮安市',1,0);
INSERT INTO `si_city` VALUES (91,44,700,'Y','盐城市',1,0);
INSERT INTO `si_city` VALUES (92,44,700,'Y','扬州市',1,0);
INSERT INTO `si_city` VALUES (93,44,700,'Z','镇江市',1,0);
INSERT INTO `si_city` VALUES (94,44,700,'T','泰州市',1,0);
INSERT INTO `si_city` VALUES (95,44,700,'S','宿迁市',1,0);
INSERT INTO `si_city` VALUES (96,44,714,'H','杭州市',1,0);
INSERT INTO `si_city` VALUES (97,44,714,'N','宁波市',1,0);
INSERT INTO `si_city` VALUES (98,44,714,'W','温州市',1,0);
INSERT INTO `si_city` VALUES (99,44,714,'J','嘉兴市',1,0);
INSERT INTO `si_city` VALUES (100,44,714,'H','湖州市',1,0);
INSERT INTO `si_city` VALUES (101,44,714,'X','绍兴市',1,0);
INSERT INTO `si_city` VALUES (102,44,714,'J','金华市',1,0);
INSERT INTO `si_city` VALUES (103,44,714,'Q','衢州市',1,0);
INSERT INTO `si_city` VALUES (104,44,714,'Z','舟山市',1,0);
INSERT INTO `si_city` VALUES (105,44,714,'T','台州市',1,0);
INSERT INTO `si_city` VALUES (106,44,714,'L','丽水市',1,0);
INSERT INTO `si_city` VALUES (107,44,684,'H','合肥市',1,0);
INSERT INTO `si_city` VALUES (108,44,684,'W','芜湖市',1,0);
INSERT INTO `si_city` VALUES (109,44,684,'F','蚌埠市',1,0);
INSERT INTO `si_city` VALUES (110,44,684,'H','淮南市',1,0);
INSERT INTO `si_city` VALUES (111,44,684,'M','马鞍山市',1,0);
INSERT INTO `si_city` VALUES (112,44,684,'H','淮北市',1,0);
INSERT INTO `si_city` VALUES (113,44,684,'T','铜陵市',1,0);
INSERT INTO `si_city` VALUES (114,44,684,'A','安庆市',1,0);
INSERT INTO `si_city` VALUES (115,44,684,'H','黄山市',1,0);
INSERT INTO `si_city` VALUES (116,44,684,'C','滁州市',1,0);
INSERT INTO `si_city` VALUES (117,44,684,'F','阜阳市',1,0);
INSERT INTO `si_city` VALUES (118,44,684,'S','宿州市',1,0);
INSERT INTO `si_city` VALUES (119,44,684,'C','巢湖市',1,0);
INSERT INTO `si_city` VALUES (120,44,684,'L','六安市',1,0);
INSERT INTO `si_city` VALUES (121,44,684,'H','亳州市',1,0);
INSERT INTO `si_city` VALUES (122,44,684,'C','池州市',1,0);
INSERT INTO `si_city` VALUES (123,44,684,'X','宣城市',1,0);
INSERT INTO `si_city` VALUES (124,44,687,'F','福州市',1,0);
INSERT INTO `si_city` VALUES (125,44,687,'X','厦门市',1,0);
INSERT INTO `si_city` VALUES (126,44,687,'P','莆田市',1,0);
INSERT INTO `si_city` VALUES (127,44,687,'S','三明市',1,0);
INSERT INTO `si_city` VALUES (128,44,687,'Q','泉州市',1,0);
INSERT INTO `si_city` VALUES (129,44,687,'Z','漳州市',1,0);
INSERT INTO `si_city` VALUES (130,44,687,'N','南平市',1,0);
INSERT INTO `si_city` VALUES (131,44,687,'L','龙岩市',1,0);
INSERT INTO `si_city` VALUES (132,44,687,'N','宁德市',1,0);
INSERT INTO `si_city` VALUES (133,44,701,'N','南昌市',1,0);
INSERT INTO `si_city` VALUES (134,44,701,'J','景德镇市',1,0);
INSERT INTO `si_city` VALUES (135,44,701,'P','萍乡市',1,0);
INSERT INTO `si_city` VALUES (136,44,701,'J','九江市',1,0);
INSERT INTO `si_city` VALUES (137,44,701,'X','新余市',1,0);
INSERT INTO `si_city` VALUES (138,44,701,'Y','鹰潭市',1,0);
INSERT INTO `si_city` VALUES (139,44,701,'G','赣州市',1,0);
INSERT INTO `si_city` VALUES (140,44,701,'J','吉安市',1,0);
INSERT INTO `si_city` VALUES (141,44,701,'Y','宜春市',1,0);
INSERT INTO `si_city` VALUES (142,44,701,'F','抚州市',1,0);
INSERT INTO `si_city` VALUES (143,44,701,'S','上饶市',1,0);
INSERT INTO `si_city` VALUES (144,44,707,'J','济南市',1,0);
INSERT INTO `si_city` VALUES (145,44,707,'Q','青岛市',1,0);
INSERT INTO `si_city` VALUES (146,44,707,'Z','淄博市',1,0);
INSERT INTO `si_city` VALUES (147,44,707,'Z','枣庄市',1,0);
INSERT INTO `si_city` VALUES (148,44,707,'D','东营市',1,0);
INSERT INTO `si_city` VALUES (149,44,707,'Y','烟台市',1,0);
INSERT INTO `si_city` VALUES (150,44,707,'W','潍坊市',1,0);
INSERT INTO `si_city` VALUES (151,44,707,'J','济宁市',1,0);
INSERT INTO `si_city` VALUES (152,44,707,'T','泰安市',1,0);
INSERT INTO `si_city` VALUES (153,44,707,'W','威海市',1,0);
INSERT INTO `si_city` VALUES (154,44,707,'R','日照市',1,0);
INSERT INTO `si_city` VALUES (155,44,707,'L','莱芜市',1,0);
INSERT INTO `si_city` VALUES (156,44,707,'L','临沂市',1,0);
INSERT INTO `si_city` VALUES (157,44,707,'D','德州市',1,0);
INSERT INTO `si_city` VALUES (158,44,707,'L','聊城市',1,0);
INSERT INTO `si_city` VALUES (159,44,707,'B','滨州市',1,0);
INSERT INTO `si_city` VALUES (160,44,707,'H','菏泽市',1,0);
INSERT INTO `si_city` VALUES (161,44,695,'Z','郑州市',1,0);
INSERT INTO `si_city` VALUES (162,44,695,'K','开封市',1,0);
INSERT INTO `si_city` VALUES (163,44,695,'L','洛阳市',1,0);
INSERT INTO `si_city` VALUES (164,44,695,'P','平顶山市',1,0);
INSERT INTO `si_city` VALUES (165,44,695,'A','安阳市',1,0);
INSERT INTO `si_city` VALUES (166,44,695,'H','鹤壁市',1,0);
INSERT INTO `si_city` VALUES (167,44,695,'X','新乡市',1,0);
INSERT INTO `si_city` VALUES (168,44,695,'J','焦作市',1,0);
INSERT INTO `si_city` VALUES (169,44,695,'P','濮阳市',1,0);
INSERT INTO `si_city` VALUES (170,44,695,'X','许昌市',1,0);
INSERT INTO `si_city` VALUES (171,44,695,'L','漯河市',1,0);
INSERT INTO `si_city` VALUES (172,44,695,'S','三门峡市',1,0);
INSERT INTO `si_city` VALUES (173,44,695,'N','南阳市',1,0);
INSERT INTO `si_city` VALUES (174,44,695,'S','商丘市',1,0);
INSERT INTO `si_city` VALUES (175,44,695,'X','信阳市',1,0);
INSERT INTO `si_city` VALUES (176,44,695,'Z','周口市',1,0);
INSERT INTO `si_city` VALUES (177,44,695,'Z','驻马店市',1,0);
INSERT INTO `si_city` VALUES (178,44,695,'J','济源市',1,0);
INSERT INTO `si_city` VALUES (179,44,697,'W','武汉市',1,0);
INSERT INTO `si_city` VALUES (180,44,697,'H','黄石市',1,0);
INSERT INTO `si_city` VALUES (181,44,697,'S','十堰市',1,0);
INSERT INTO `si_city` VALUES (182,44,697,'J','荆州市',1,0);
INSERT INTO `si_city` VALUES (183,44,697,'Y','宜昌市',1,0);
INSERT INTO `si_city` VALUES (184,44,697,'X','襄樊市',1,0);
INSERT INTO `si_city` VALUES (185,44,697,'E','鄂州市',1,0);
INSERT INTO `si_city` VALUES (186,44,697,'J','荆门市',1,0);
INSERT INTO `si_city` VALUES (187,44,697,'X','孝感市',1,0);
INSERT INTO `si_city` VALUES (188,44,697,'H','黄冈市',1,0);
INSERT INTO `si_city` VALUES (189,44,697,'X','咸宁市',1,0);
INSERT INTO `si_city` VALUES (190,44,697,'X','随州市',1,0);
INSERT INTO `si_city` VALUES (191,44,697,'X','仙桃市',1,0);
INSERT INTO `si_city` VALUES (192,44,697,'T','天门市',1,0);
INSERT INTO `si_city` VALUES (193,44,697,'Q','潜江市',1,0);
INSERT INTO `si_city` VALUES (194,44,697,'S','神农架林区',1,0);
INSERT INTO `si_city` VALUES (195,44,697,'E','恩施土家族苗族自治州',1,0);
INSERT INTO `si_city` VALUES (196,44,698,'C','长沙市',1,0);
INSERT INTO `si_city` VALUES (197,44,698,'Z','株洲市',1,0);
INSERT INTO `si_city` VALUES (198,44,698,'X','湘潭市',1,0);
INSERT INTO `si_city` VALUES (199,44,698,'H','衡阳市',1,0);
INSERT INTO `si_city` VALUES (200,44,698,'X','邵阳市',1,0);
INSERT INTO `si_city` VALUES (201,44,698,'Y','岳阳市',1,0);
INSERT INTO `si_city` VALUES (202,44,698,'C','常德市',1,0);
INSERT INTO `si_city` VALUES (203,44,698,'Z','张家界市',1,0);
INSERT INTO `si_city` VALUES (204,44,698,'Y','益阳市',1,0);
INSERT INTO `si_city` VALUES (205,44,698,'C','郴州市',1,0);
INSERT INTO `si_city` VALUES (206,44,698,'Y','永州市',1,0);
INSERT INTO `si_city` VALUES (207,44,698,'H','怀化市',1,0);
INSERT INTO `si_city` VALUES (208,44,698,'L','娄底市',1,0);
INSERT INTO `si_city` VALUES (209,44,698,'X','湘西土家族苗族自治州',1,0);
INSERT INTO `si_city` VALUES (210,44,689,'G','广州市',1,0);
INSERT INTO `si_city` VALUES (211,44,689,'S','深圳市',1,0);
INSERT INTO `si_city` VALUES (212,44,689,'Z','珠海市',1,0);
INSERT INTO `si_city` VALUES (213,44,689,'S','汕头市',1,0);
INSERT INTO `si_city` VALUES (214,44,689,'S','韶关市',1,0);
INSERT INTO `si_city` VALUES (215,44,689,'F','佛山市',1,0);
INSERT INTO `si_city` VALUES (216,44,689,'J','江门市',1,0);
INSERT INTO `si_city` VALUES (217,44,689,'Z','湛江市',1,0);
INSERT INTO `si_city` VALUES (218,44,689,'M','茂名市',1,0);
INSERT INTO `si_city` VALUES (219,44,689,'Z','肇庆市',1,0);
INSERT INTO `si_city` VALUES (220,44,689,'H','惠州市',1,0);
INSERT INTO `si_city` VALUES (221,44,689,'M','梅州市',1,0);
INSERT INTO `si_city` VALUES (222,44,689,'S','汕尾市',1,0);
INSERT INTO `si_city` VALUES (223,44,689,'H','河源市',1,0);
INSERT INTO `si_city` VALUES (224,44,689,'Y','阳江市',1,0);
INSERT INTO `si_city` VALUES (225,44,689,'Q','清远市',1,0);
INSERT INTO `si_city` VALUES (226,44,689,'D','东莞市',1,0);
INSERT INTO `si_city` VALUES (227,44,689,'Z','中山市',1,0);
INSERT INTO `si_city` VALUES (228,44,689,'C','潮州市',1,0);
INSERT INTO `si_city` VALUES (229,44,689,'YJ','揭阳市',1,0);
INSERT INTO `si_city` VALUES (230,44,689,'','云浮市',1,0);
INSERT INTO `si_city` VALUES (231,44,688,'L','兰州市',1,0);
INSERT INTO `si_city` VALUES (232,44,688,'J','金昌市',1,0);
INSERT INTO `si_city` VALUES (233,44,688,'B','白银市',1,0);
INSERT INTO `si_city` VALUES (234,44,688,'T','天水市',1,0);
INSERT INTO `si_city` VALUES (235,44,688,'J','嘉峪关市',1,0);
INSERT INTO `si_city` VALUES (236,44,688,'W','武威市',1,0);
INSERT INTO `si_city` VALUES (237,44,688,'Z','张掖市',1,0);
INSERT INTO `si_city` VALUES (238,44,688,'P','平凉市',1,0);
INSERT INTO `si_city` VALUES (239,44,688,'J','酒泉市',1,0);
INSERT INTO `si_city` VALUES (240,44,688,'Q','庆阳市',1,0);
INSERT INTO `si_city` VALUES (241,44,688,'D','定西市',1,0);
INSERT INTO `si_city` VALUES (242,44,688,'L','陇南市',1,0);
INSERT INTO `si_city` VALUES (243,44,688,'L','临夏回族自治州',1,0);
INSERT INTO `si_city` VALUES (244,44,688,'G','甘南藏族自治州',1,0);
INSERT INTO `si_city` VALUES (245,44,710,'C','成都市',1,0);
INSERT INTO `si_city` VALUES (246,44,710,'Z','自贡市',1,0);
INSERT INTO `si_city` VALUES (247,44,710,'P','攀枝花市',1,0);
INSERT INTO `si_city` VALUES (248,44,710,'L','泸州市',1,0);
INSERT INTO `si_city` VALUES (249,44,710,'D','德阳市',1,0);
INSERT INTO `si_city` VALUES (250,44,710,'M','绵阳市',1,0);
INSERT INTO `si_city` VALUES (251,44,710,'G','广元市',1,0);
INSERT INTO `si_city` VALUES (252,44,710,'S','遂宁市',1,0);
INSERT INTO `si_city` VALUES (253,44,710,'N','内江市',1,0);
INSERT INTO `si_city` VALUES (254,44,710,'L','乐山市',1,0);
INSERT INTO `si_city` VALUES (255,44,710,'N','南充市',1,0);
INSERT INTO `si_city` VALUES (256,44,710,'M','眉山市',1,0);
INSERT INTO `si_city` VALUES (257,44,710,'Y','宜宾市',1,0);
INSERT INTO `si_city` VALUES (258,44,710,'G','广安市',1,0);
INSERT INTO `si_city` VALUES (259,44,710,'D','达州市',1,0);
INSERT INTO `si_city` VALUES (260,44,710,'Y','雅安市',1,0);
INSERT INTO `si_city` VALUES (261,44,710,'B','巴中市',1,0);
INSERT INTO `si_city` VALUES (262,44,710,'Z','资阳市',1,0);
INSERT INTO `si_city` VALUES (263,44,710,'A','阿坝藏族羌族自治州',1,0);
INSERT INTO `si_city` VALUES (264,44,710,'G','甘孜藏族自治州',1,0);
INSERT INTO `si_city` VALUES (265,44,710,'L','凉山彝族自治州',1,0);
INSERT INTO `si_city` VALUES (266,44,691,'G','贵阳市',1,0);
INSERT INTO `si_city` VALUES (267,44,691,'L','六盘水市',1,0);
INSERT INTO `si_city` VALUES (268,44,691,'Z','遵义市',1,0);
INSERT INTO `si_city` VALUES (269,44,691,'A','安顺市',1,0);
INSERT INTO `si_city` VALUES (270,44,691,'T','铜仁地区',1,0);
INSERT INTO `si_city` VALUES (271,44,691,'B','毕节地区',1,0);
INSERT INTO `si_city` VALUES (272,44,691,'Q','黔西南布依族苗族自治州',1,0);
INSERT INTO `si_city` VALUES (273,44,691,'Q','黔东南苗族侗族自治州',1,0);
INSERT INTO `si_city` VALUES (274,44,691,'Q','黔南布依族苗族自治州',1,0);
INSERT INTO `si_city` VALUES (275,44,713,'K','昆明市',1,0);
INSERT INTO `si_city` VALUES (276,44,713,'Q','曲靖市',1,0);
INSERT INTO `si_city` VALUES (277,44,713,'Y','玉溪市',1,0);
INSERT INTO `si_city` VALUES (278,44,713,'B','保山市',1,0);
INSERT INTO `si_city` VALUES (279,44,713,'Z','昭通市',1,0);
INSERT INTO `si_city` VALUES (280,44,713,'L','丽江市',1,0);
INSERT INTO `si_city` VALUES (281,44,713,'S','思茅市',1,0);
INSERT INTO `si_city` VALUES (282,44,713,'L','临沧市',1,0);
INSERT INTO `si_city` VALUES (283,44,713,'W','文山壮族苗族自治州',1,0);
INSERT INTO `si_city` VALUES (284,44,713,'H','红河哈尼族彝族自治州',1,0);
INSERT INTO `si_city` VALUES (285,44,713,'X','西双版纳傣族自治州',1,0);
INSERT INTO `si_city` VALUES (286,44,713,'C','楚雄彝族自治州',1,0);
INSERT INTO `si_city` VALUES (287,44,713,'D','大理白族自治州',1,0);
INSERT INTO `si_city` VALUES (288,44,713,'D','德宏傣族景颇族自治州',1,0);
INSERT INTO `si_city` VALUES (289,44,713,'N','怒江傈傈族自治州',1,0);
INSERT INTO `si_city` VALUES (290,44,713,'D','迪庆藏族自治州',1,0);
INSERT INTO `si_city` VALUES (291,44,716,'X','西宁市',1,0);
INSERT INTO `si_city` VALUES (292,44,716,'H','海东地区',1,0);
INSERT INTO `si_city` VALUES (293,44,716,'H','海北藏族自治州',1,0);
INSERT INTO `si_city` VALUES (294,44,716,'H','黄南藏族自治州',1,0);
INSERT INTO `si_city` VALUES (295,44,716,'H','海南藏族自治州',1,0);
INSERT INTO `si_city` VALUES (296,44,716,'G','果洛藏族自治州',1,0);
INSERT INTO `si_city` VALUES (297,44,716,'Y','玉树藏族自治州',1,0);
INSERT INTO `si_city` VALUES (298,44,716,'H','海西蒙古族藏族自治州',1,0);
INSERT INTO `si_city` VALUES (299,44,706,'X','西安市',1,0);
INSERT INTO `si_city` VALUES (300,44,706,'T','铜川市',1,0);
INSERT INTO `si_city` VALUES (301,44,706,'B','宝鸡市',1,0);
INSERT INTO `si_city` VALUES (302,44,706,'X','咸阳市',1,0);
INSERT INTO `si_city` VALUES (303,44,706,'W','渭南市',1,0);
INSERT INTO `si_city` VALUES (304,44,706,'Y','延安市',1,0);
INSERT INTO `si_city` VALUES (305,44,706,'H','汉中市',1,0);
INSERT INTO `si_city` VALUES (306,44,706,'Y','榆林市',1,0);
INSERT INTO `si_city` VALUES (307,44,706,'A','安康市',1,0);
INSERT INTO `si_city` VALUES (308,44,706,'S','商洛市',1,0);
INSERT INTO `si_city` VALUES (309,44,690,'N','南宁市',1,0);
INSERT INTO `si_city` VALUES (310,44,690,'L','柳州市',1,0);
INSERT INTO `si_city` VALUES (311,44,690,'G','桂林市',1,0);
INSERT INTO `si_city` VALUES (312,44,690,'W','梧州市',1,0);
INSERT INTO `si_city` VALUES (313,44,690,'B','北海市',1,0);
INSERT INTO `si_city` VALUES (314,44,690,'F','防城港市',1,0);
INSERT INTO `si_city` VALUES (315,44,690,'Q','钦州市',1,0);
INSERT INTO `si_city` VALUES (316,44,690,'G','贵港市',1,0);
INSERT INTO `si_city` VALUES (317,44,690,'Y','玉林市',1,0);
INSERT INTO `si_city` VALUES (318,44,690,'B','百色市',1,0);
INSERT INTO `si_city` VALUES (319,44,690,'H','贺州市',1,0);
INSERT INTO `si_city` VALUES (320,44,690,'H','河池市',1,0);
INSERT INTO `si_city` VALUES (321,44,690,'L','来宾市',1,0);
INSERT INTO `si_city` VALUES (322,44,690,'C','崇左市',1,0);
INSERT INTO `si_city` VALUES (323,44,717,'L','拉萨市',1,0);
INSERT INTO `si_city` VALUES (324,44,717,'N','那曲地区',1,0);
INSERT INTO `si_city` VALUES (325,44,717,'C','昌都地区',1,0);
INSERT INTO `si_city` VALUES (326,44,717,'S','山南地区',1,0);
INSERT INTO `si_city` VALUES (327,44,717,'R','日喀则地区',1,0);
INSERT INTO `si_city` VALUES (328,44,717,'A','阿里地区',1,0);
INSERT INTO `si_city` VALUES (329,44,717,'L','林芝地区',1,0);
INSERT INTO `si_city` VALUES (330,44,705,'Y','银川市',1,0);
INSERT INTO `si_city` VALUES (331,44,705,'S','石嘴山市',1,0);
INSERT INTO `si_city` VALUES (332,44,705,'W','吴忠市',1,0);
INSERT INTO `si_city` VALUES (333,44,705,'G','固原市',1,0);
INSERT INTO `si_city` VALUES (334,44,705,'Z','中卫市',1,0);
INSERT INTO `si_city` VALUES (335,44,712,'W','乌鲁木齐市',1,0);
INSERT INTO `si_city` VALUES (336,44,712,'K','克拉玛依市',1,0);
INSERT INTO `si_city` VALUES (337,44,712,'S','石河子市　',1,0);
INSERT INTO `si_city` VALUES (338,44,712,'A','阿拉尔市',1,0);
INSERT INTO `si_city` VALUES (339,44,712,'T','图木舒克市',1,0);
INSERT INTO `si_city` VALUES (340,44,712,'W','五家渠市',1,0);
INSERT INTO `si_city` VALUES (341,44,712,'K','吐鲁番市',1,0);
INSERT INTO `si_city` VALUES (342,44,712,'A','阿克苏市',1,0);
INSERT INTO `si_city` VALUES (343,44,712,'K','喀什市',1,0);
INSERT INTO `si_city` VALUES (344,44,712,'H','哈密市',1,0);
INSERT INTO `si_city` VALUES (345,44,712,'H','和田市',1,0);
INSERT INTO `si_city` VALUES (346,44,712,'A','阿图什市',1,0);
INSERT INTO `si_city` VALUES (347,44,712,'K','库尔勒市',1,0);
INSERT INTO `si_city` VALUES (348,44,712,'K','昌吉市　',1,0);
INSERT INTO `si_city` VALUES (349,44,712,'F','阜康市',1,0);
INSERT INTO `si_city` VALUES (350,44,712,'M','米泉市',1,0);
INSERT INTO `si_city` VALUES (351,44,712,'B','博乐市',1,0);
INSERT INTO `si_city` VALUES (352,44,712,'Y','伊宁市',1,0);
INSERT INTO `si_city` VALUES (353,44,712,'K','奎屯市',1,0);
INSERT INTO `si_city` VALUES (354,44,712,'T','塔城市',1,0);
INSERT INTO `si_city` VALUES (355,44,712,'W','乌苏市',1,0);
INSERT INTO `si_city` VALUES (356,44,712,'A','阿勒泰市',1,0);
INSERT INTO `si_city` VALUES (357,44,699,'F','呼和浩特市',1,0);
INSERT INTO `si_city` VALUES (358,44,699,'B','包头市',1,0);
INSERT INTO `si_city` VALUES (359,44,699,'W','乌海市',1,0);
INSERT INTO `si_city` VALUES (360,44,699,'C','赤峰市',1,0);
INSERT INTO `si_city` VALUES (361,44,699,'T','通辽市',1,0);
INSERT INTO `si_city` VALUES (362,44,699,'E','鄂尔多斯市',1,0);
INSERT INTO `si_city` VALUES (363,44,699,'F','呼伦贝尔市',1,0);
INSERT INTO `si_city` VALUES (364,44,699,'B','巴彦淖尔市',1,0);
INSERT INTO `si_city` VALUES (365,44,699,'W','乌兰察布市',1,0);
INSERT INTO `si_city` VALUES (366,44,699,'X','锡林郭勒盟',1,0);
INSERT INTO `si_city` VALUES (367,44,699,'X','兴安盟',1,0);
INSERT INTO `si_city` VALUES (368,44,699,'A','阿拉善盟',1,0);
INSERT INTO `si_city` VALUES (369,44,692,'H','海口市',1,0);
INSERT INTO `si_city` VALUES (370,44,692,'S','三亚市',1,0);
INSERT INTO `si_city` VALUES (371,44,692,'W','五指山市',1,0);
INSERT INTO `si_city` VALUES (372,44,692,'Q','琼海市',1,0);
INSERT INTO `si_city` VALUES (373,44,692,'D','儋州市',1,0);
INSERT INTO `si_city` VALUES (374,44,692,'W','文昌市',1,0);
INSERT INTO `si_city` VALUES (375,44,692,'W','万宁市',1,0);
INSERT INTO `si_city` VALUES (376,44,692,'D','东方市',1,0);
INSERT INTO `si_city` VALUES (377,44,692,'C','澄迈县',1,0);
INSERT INTO `si_city` VALUES (378,44,692,'D','定安县',1,0);
INSERT INTO `si_city` VALUES (379,44,692,'T','屯昌县',1,0);
INSERT INTO `si_city` VALUES (380,44,692,'L','临高县',1,0);
INSERT INTO `si_city` VALUES (381,44,692,'B','白沙黎族自治县',1,0);
INSERT INTO `si_city` VALUES (382,44,692,'C','昌江黎族自治县',1,0);
INSERT INTO `si_city` VALUES (383,44,692,'L','乐东黎族自治县',1,0);
INSERT INTO `si_city` VALUES (384,44,692,'L','陵水黎族自治县',1,0);
INSERT INTO `si_city` VALUES (385,44,692,'B','保亭黎族苗族自治县',1,0);
INSERT INTO `si_city` VALUES (386,44,692,'Q','琼中黎族苗族自治县',1,0);
INSERT INTO `si_city` VALUES (387,44,704,'M','澳门特别行政区',1,0);
INSERT INTO `si_city` VALUES (388,44,696,'HK','香港特别行政区',1,0);
INSERT INTO `si_city` VALUES (389,44,711,'TI','天津市',1,0);
INSERT INTO `si_city` VALUES (390,44,685,'CY','朝阳区',1,0);
INSERT INTO `si_city` VALUES (391,44,685,'H','海淀区',1,0);
INSERT INTO `si_city` VALUES (392,44,685,'XC','西城区',1,0);
INSERT INTO `si_city` VALUES (393,44,685,'DC','东城区',1,0);
INSERT INTO `si_city` VALUES (394,44,685,'CW','崇文区',1,0);
INSERT INTO `si_city` VALUES (395,44,685,'XW','宣武区',1,0);
INSERT INTO `si_city` VALUES (396,44,685,'FT','丰台区',1,0);
INSERT INTO `si_city` VALUES (397,44,685,'SJS','石景山区',1,0);
INSERT INTO `si_city` VALUES (398,44,685,'MTG','门头沟',1,0);
INSERT INTO `si_city` VALUES (399,44,685,'FS','房山区',1,0);
INSERT INTO `si_city` VALUES (400,44,685,'TZ','通州区',1,0);
INSERT INTO `si_city` VALUES (401,44,685,'DX','大兴区',1,0);
INSERT INTO `si_city` VALUES (402,44,685,'SY','顺义区',1,0);
INSERT INTO `si_city` VALUES (403,44,685,'HR','怀柔区',1,0);
INSERT INTO `si_city` VALUES (404,44,685,'MY','密云区',1,0);
INSERT INTO `si_city` VALUES (405,44,685,'CP','昌平区',1,0);
INSERT INTO `si_city` VALUES (406,44,685,'PG','平谷区',1,0);
INSERT INTO `si_city` VALUES (407,44,685,'YQ','延庆县',1,0);
INSERT INTO `si_city` VALUES (408,44,708,'HP','黄浦区',1,0);
INSERT INTO `si_city` VALUES (409,44,708,'LW','卢湾区',1,0);
INSERT INTO `si_city` VALUES (410,44,708,'XH','徐汇区',1,0);
INSERT INTO `si_city` VALUES (411,44,708,'CN','长宁区',1,0);
INSERT INTO `si_city` VALUES (412,44,708,'JA','静安区',1,0);
INSERT INTO `si_city` VALUES (413,44,708,'ZB','闸北区',1,0);
INSERT INTO `si_city` VALUES (414,44,708,'HK','虹口区',1,0);
INSERT INTO `si_city` VALUES (415,44,708,'YP','杨浦区',1,0);
INSERT INTO `si_city` VALUES (416,44,708,'BS','宝山区',1,0);
INSERT INTO `si_city` VALUES (417,44,708,'MX','闵行区',1,0);
INSERT INTO `si_city` VALUES (418,44,708,'JD','嘉定区',1,0);
INSERT INTO `si_city` VALUES (419,44,708,'PDXQ','浦东新区',1,0);
INSERT INTO `si_city` VALUES (420,44,708,'QP','青浦区',1,0);
INSERT INTO `si_city` VALUES (421,44,708,'SJ','松江区',1,0);
INSERT INTO `si_city` VALUES (422,44,708,'JS','金山区',1,0);
INSERT INTO `si_city` VALUES (423,44,708,'NH','南汇区',1,0);
INSERT INTO `si_city` VALUES (424,44,708,'FX','奉贤区',1,0);
INSERT INTO `si_city` VALUES (425,44,708,'PT','普陀区',1,0);
INSERT INTO `si_city` VALUES (426,44,708,'CMX','崇明县',1,0);

DROP TABLE IF EXISTS `si_weight_class_description`;

CREATE TABLE `si_weight_class_description` (
  `weight_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) COLLATE utf8_bin NOT NULL,
  `unit` varchar(4) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`weight_class_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_weight_class_description` VALUES (1,1,'千克','kg');
INSERT INTO `si_weight_class_description` VALUES (2,1,'克','g');
INSERT INTO `si_weight_class_description` VALUES (5,1,'磅','lb');
INSERT INTO `si_weight_class_description` VALUES (6,1,'盎司','oz');


DROP TABLE IF EXISTS `si_user_group`;

CREATE TABLE `si_user_group` (
  `user_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `permission` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`user_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_user_group` VALUES (1,'管理员','a:2:{s:6:"access";a:127:{i:0;s:15:"article/article";i:1;s:16:"article/category";i:2;s:16:"article/download";i:3;s:17:"catalog/attribute";i:4;s:23:"catalog/attribute_group";i:5;s:16:"catalog/category";i:6;s:16:"catalog/download";i:7;s:19:"catalog/information";i:8;s:28:"catalog/information_category";i:9;s:20:"catalog/manufacturer";i:10;s:15:"catalog/message";i:11;s:14:"catalog/option";i:12;s:15:"catalog/product";i:13;s:14:"catalog/review";i:14;s:15:"catalog/sitemap";i:15;s:18:"common/filemanager";i:16;s:19:"common/localisation";i:17;s:13:"common/upload";i:18;s:15:"common/uploader";i:19;s:13:"design/banner";i:20;s:12:"design/flink";i:21;s:13:"design/layout";i:22;s:14:"extension/feed";i:23;s:16:"extension/module";i:24;s:17:"extension/payment";i:25;s:18:"extension/shipping";i:26;s:14:"extension/tool";i:27;s:15:"extension/total";i:28;s:16:"feed/google_base";i:29;s:19:"feed/google_sitemap";i:30;s:14:"layout/default";i:31;s:16:"layout/parameter";i:32;s:13:"layout/report";i:33;s:17:"localisation/city";i:34;s:20:"localisation/country";i:35;s:21:"localisation/currency";i:36;s:19:"localisation/editor";i:37;s:21:"localisation/geo_zone";i:38;s:21:"localisation/language";i:39;s:25:"localisation/length_class";i:40;s:22:"localisation/logistics";i:41;s:25:"localisation/order_status";i:42;s:26:"localisation/return_action";i:43;s:26:"localisation/return_reason";i:44;s:26:"localisation/return_status";i:45;s:25:"localisation/stock_status";i:46;s:22:"localisation/tax_class";i:47;s:25:"localisation/weight_class";i:48;s:17:"localisation/zone";i:49;s:14:"module/account";i:50;s:16:"module/affiliate";i:51;s:13:"module/banner";i:52;s:17:"module/bestseller";i:53;s:15:"module/carousel";i:54;s:15:"module/category";i:55;s:12:"module/cates";i:56;s:14:"module/dealday";i:57;s:15:"module/featured";i:58;s:14:"module/hotsell";i:59;s:18:"module/information";i:60;s:13:"module/latest";i:61;s:17:"module/mostviewed";i:62;s:15:"module/onlineim";i:63;s:16:"module/slideshow";i:64;s:14:"module/special";i:65;s:12:"module/store";i:66;s:13:"module/viewed";i:67;s:14:"module/welcome";i:68;s:14:"payment/alipay";i:69;s:21:"payment/bank_transfer";i:70;s:11:"payment/cod";i:71;s:21:"payment/free_checkout";i:72;s:19:"payment/pp_standard";i:73;s:14:"payment/tenpay";i:74;s:27:"report/affiliate_commission";i:75;s:22:"report/customer_credit";i:76;s:21:"report/customer_order";i:77;s:22:"report/customer_reward";i:78;s:24:"report/product_purchased";i:79;s:21:"report/product_viewed";i:80;s:11:"report/sale";i:81;s:18:"report/sale_coupon";i:82;s:17:"report/sale_order";i:83;s:18:"report/sale_return";i:84;s:20:"report/sale_shipping";i:85;s:15:"report/sale_tax";i:86;s:14:"sale/affiliate";i:87;s:13:"sale/auto_seo";i:88;s:12:"sale/contact";i:89;s:11:"sale/coupon";i:90;s:13:"sale/customer";i:91;s:19:"sale/customer_group";i:92;s:7:"sale/im";i:93;s:10:"sale/order";i:94;s:11:"sale/return";i:95;s:12:"sale/voucher";i:96;s:18:"sale/voucher_theme";i:97;s:13:"seo/url_alias";i:98;s:14:"setting/custom";i:99;s:12:"setting/mail";i:100;s:17:"setting/parameter";i:101;s:14:"setting/server";i:102;s:15:"setting/setting";i:103;s:13:"setting/store";i:104;s:15:"setting/upgrade";i:105;s:17:"shipping/citylink";i:106;s:13:"shipping/flat";i:107;s:13:"shipping/free";i:108;s:13:"shipping/item";i:109;s:15:"shipping/pickup";i:110;s:15:"shipping/weight";i:111;s:11:"tool/backup";i:112;s:14:"tool/error_log";i:113;s:16:"toolset/auto_seo";i:114;s:15:"toolset/sitemap";i:115;s:12:"total/coupon";i:116;s:12:"total/credit";i:117;s:14:"total/handling";i:118;s:19:"total/low_order_fee";i:119;s:12:"total/reward";i:120;s:14:"total/shipping";i:121;s:15:"total/sub_total";i:122;s:9:"total/tax";i:123;s:11:"total/total";i:124;s:13:"total/voucher";i:125;s:9:"user/user";i:126;s:20:"user/user_permission";}s:6:"modify";a:127:{i:0;s:15:"article/article";i:1;s:16:"article/category";i:2;s:16:"article/download";i:3;s:17:"catalog/attribute";i:4;s:23:"catalog/attribute_group";i:5;s:16:"catalog/category";i:6;s:16:"catalog/download";i:7;s:19:"catalog/information";i:8;s:28:"catalog/information_category";i:9;s:20:"catalog/manufacturer";i:10;s:15:"catalog/message";i:11;s:14:"catalog/option";i:12;s:15:"catalog/product";i:13;s:14:"catalog/review";i:14;s:15:"catalog/sitemap";i:15;s:18:"common/filemanager";i:16;s:19:"common/localisation";i:17;s:13:"common/upload";i:18;s:15:"common/uploader";i:19;s:13:"design/banner";i:20;s:12:"design/flink";i:21;s:13:"design/layout";i:22;s:14:"extension/feed";i:23;s:16:"extension/module";i:24;s:17:"extension/payment";i:25;s:18:"extension/shipping";i:26;s:14:"extension/tool";i:27;s:15:"extension/total";i:28;s:16:"feed/google_base";i:29;s:19:"feed/google_sitemap";i:30;s:14:"layout/default";i:31;s:16:"layout/parameter";i:32;s:13:"layout/report";i:33;s:17:"localisation/city";i:34;s:20:"localisation/country";i:35;s:21:"localisation/currency";i:36;s:19:"localisation/editor";i:37;s:21:"localisation/geo_zone";i:38;s:21:"localisation/language";i:39;s:25:"localisation/length_class";i:40;s:22:"localisation/logistics";i:41;s:25:"localisation/order_status";i:42;s:26:"localisation/return_action";i:43;s:26:"localisation/return_reason";i:44;s:26:"localisation/return_status";i:45;s:25:"localisation/stock_status";i:46;s:22:"localisation/tax_class";i:47;s:25:"localisation/weight_class";i:48;s:17:"localisation/zone";i:49;s:14:"module/account";i:50;s:16:"module/affiliate";i:51;s:13:"module/banner";i:52;s:17:"module/bestseller";i:53;s:15:"module/carousel";i:54;s:15:"module/category";i:55;s:12:"module/cates";i:56;s:14:"module/dealday";i:57;s:15:"module/featured";i:58;s:14:"module/hotsell";i:59;s:18:"module/information";i:60;s:13:"module/latest";i:61;s:17:"module/mostviewed";i:62;s:15:"module/onlineim";i:63;s:16:"module/slideshow";i:64;s:14:"module/special";i:65;s:12:"module/store";i:66;s:13:"module/viewed";i:67;s:14:"module/welcome";i:68;s:14:"payment/alipay";i:69;s:21:"payment/bank_transfer";i:70;s:11:"payment/cod";i:71;s:21:"payment/free_checkout";i:72;s:19:"payment/pp_standard";i:73;s:14:"payment/tenpay";i:74;s:27:"report/affiliate_commission";i:75;s:22:"report/customer_credit";i:76;s:21:"report/customer_order";i:77;s:22:"report/customer_reward";i:78;s:24:"report/product_purchased";i:79;s:21:"report/product_viewed";i:80;s:11:"report/sale";i:81;s:18:"report/sale_coupon";i:82;s:17:"report/sale_order";i:83;s:18:"report/sale_return";i:84;s:20:"report/sale_shipping";i:85;s:15:"report/sale_tax";i:86;s:14:"sale/affiliate";i:87;s:13:"sale/auto_seo";i:88;s:12:"sale/contact";i:89;s:11:"sale/coupon";i:90;s:13:"sale/customer";i:91;s:19:"sale/customer_group";i:92;s:7:"sale/im";i:93;s:10:"sale/order";i:94;s:11:"sale/return";i:95;s:12:"sale/voucher";i:96;s:18:"sale/voucher_theme";i:97;s:13:"seo/url_alias";i:98;s:14:"setting/custom";i:99;s:12:"setting/mail";i:100;s:17:"setting/parameter";i:101;s:14:"setting/server";i:102;s:15:"setting/setting";i:103;s:13:"setting/store";i:104;s:15:"setting/upgrade";i:105;s:17:"shipping/citylink";i:106;s:13:"shipping/flat";i:107;s:13:"shipping/free";i:108;s:13:"shipping/item";i:109;s:15:"shipping/pickup";i:110;s:15:"shipping/weight";i:111;s:11:"tool/backup";i:112;s:14:"tool/error_log";i:113;s:16:"toolset/auto_seo";i:114;s:15:"toolset/sitemap";i:115;s:12:"total/coupon";i:116;s:12:"total/credit";i:117;s:14:"total/handling";i:118;s:19:"total/low_order_fee";i:119;s:12:"total/reward";i:120;s:14:"total/shipping";i:121;s:15:"total/sub_total";i:122;s:9:"total/tax";i:123;s:11:"total/total";i:124;s:13:"total/voucher";i:125;s:9:"user/user";i:126;s:20:"user/user_permission";}}');
INSERT INTO `si_user_group` VALUES (10,'演示帐号','');

DROP TABLE IF EXISTS `si_article_category_to_store`;

CREATE TABLE `si_article_category_to_store` (
  `article_category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`article_category_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_article_category_to_layout`;

CREATE TABLE `si_article_category_to_layout` (
  `article_category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`article_category_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_weight_class`;

CREATE TABLE `si_weight_class` (
  `weight_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `value` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  PRIMARY KEY (`weight_class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_weight_class` VALUES (1,1.00000000);
INSERT INTO `si_weight_class` VALUES (2,1000.00000000);
INSERT INTO `si_weight_class` VALUES (5,2.20460000);
INSERT INTO `si_weight_class` VALUES (6,35.27400000);

DROP TABLE IF EXISTS `si_product`;

CREATE TABLE `si_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(64) COLLATE utf8_bin NOT NULL,
  `sku` varchar(64) COLLATE utf8_bin NOT NULL,
  `upc` varchar(12) COLLATE utf8_bin NOT NULL,
  `location` varchar(128) COLLATE utf8_bin NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `stock_status_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `shipping` tinyint(1) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `points` int(8) NOT NULL DEFAULT '0',
  `tax_class_id` int(11) NOT NULL,
  `date_available` date NOT NULL,
  `weight` decimal(5,2) NOT NULL DEFAULT '0.00',
  `weight_class_id` int(11) NOT NULL DEFAULT '0',
  `length` decimal(5,2) NOT NULL DEFAULT '0.00',
  `width` decimal(5,2) NOT NULL DEFAULT '0.00',
  `height` decimal(5,2) NOT NULL DEFAULT '0.00',
  `length_class_id` int(11) NOT NULL DEFAULT '0',
  `subtract` tinyint(1) NOT NULL DEFAULT '1',
  `minimum` int(11) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `viewed` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_customer_group`;

CREATE TABLE `si_customer_group` (
  `customer_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`customer_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_customer_group` VALUES (8,'一般顾客');
INSERT INTO `si_customer_group` VALUES (6,'分销商');

DROP TABLE IF EXISTS `si_return_product`;
CREATE TABLE `si_return_product` (
  `return_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `return_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `model` varchar(64) COLLATE utf8_bin NOT NULL,
  `quantity` int(4) NOT NULL,
  `return_reason_id` int(11) NOT NULL,
  `opened` tinyint(1) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_bin NOT NULL,
  `return_action_id` int(11) NOT NULL,
  PRIMARY KEY (`return_product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_product_description`;

CREATE TABLE `si_product_description` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `meta_title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8_bin NOT NULL,
  `meta_keyword` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`product_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



DROP TABLE IF EXISTS `si_product_related`;

CREATE TABLE `si_product_related` (
  `product_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`related_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_tax_rate`;

CREATE TABLE `si_tax_rate` (
  `tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `geo_zone_id` int(11) NOT NULL DEFAULT '0',
  `tax_class_id` int(11) NOT NULL,
  `priority` int(5) NOT NULL DEFAULT '1',
  `rate` decimal(7,4) NOT NULL DEFAULT '0.0000',
  `description` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`tax_rate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_address`;

CREATE TABLE `si_address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `firstname` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `lastname` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `company` varchar(32) COLLATE utf8_bin NOT NULL,
  `mobile` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `address_1` varchar(128) COLLATE utf8_bin NOT NULL,
  `address_2` varchar(128) COLLATE utf8_bin NOT NULL,
  `city` varchar(128) COLLATE utf8_bin NOT NULL,
  `city_id` int(11) NOT NULL DEFAULT '0',
  `postcode` varchar(10) COLLATE utf8_bin NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `zone_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`address_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_order_status`;

CREATE TABLE `si_order_status` (
  `order_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`order_status_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_order_status` VALUES (2,1,'正在处理');
INSERT INTO `si_order_status` VALUES (3,1,'已发货');
INSERT INTO `si_order_status` VALUES (7,1,'取消订单');
INSERT INTO `si_order_status` VALUES (5,1,'完成');
INSERT INTO `si_order_status` VALUES (8,1,'被拒绝');
INSERT INTO `si_order_status` VALUES (10,1,'失败');
INSERT INTO `si_order_status` VALUES (11,1,'退款');
INSERT INTO `si_order_status` VALUES (13,1,'扣款');
INSERT INTO `si_order_status` VALUES (1,1,'待处理');
INSERT INTO `si_order_status` VALUES (15,1,'已处理');
INSERT INTO `si_order_status` VALUES (14,1,'过期');
INSERT INTO `si_order_status` VALUES (16,1,'待付款');


DROP TABLE IF EXISTS `si_return`;

CREATE TABLE `si_return` (
  `return_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(128) COLLATE utf8_bin NOT NULL,
  `date_ordered` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `firstname` varchar(32) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(32) COLLATE utf8_bin NOT NULL,
  `email` varchar(96) COLLATE utf8_bin NOT NULL,
  `telephone` varchar(32) COLLATE utf8_bin NOT NULL,
  `return_status_id` int(11) NOT NULL,
  `comment` text COLLATE utf8_bin,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`return_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_product_to_store`;

CREATE TABLE `si_product_to_store` (
  `product_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



DROP TABLE IF EXISTS `si_coupon`;

CREATE TABLE `si_coupon` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `code` varchar(10) COLLATE utf8_bin NOT NULL,
  `type` char(1) COLLATE utf8_bin NOT NULL,
  `discount` decimal(15,4) NOT NULL,
  `logged` tinyint(1) NOT NULL DEFAULT '0',
  `shipping` tinyint(1) NOT NULL DEFAULT '0',
  `total` decimal(15,4) NOT NULL,
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  `uses_total` int(11) NOT NULL,
  `uses_customer` varchar(11) COLLATE utf8_bin NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`coupon_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_voucher_theme`;

CREATE TABLE `si_voucher_theme` (
  `voucher_theme_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`voucher_theme_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_banner_image_description`;

CREATE TABLE `si_banner_image_description` (
  `banner_image_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `title` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`banner_image_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;




DROP TABLE IF EXISTS `si_product_discount`;
CREATE TABLE `si_product_discount` (
  `product_discount_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `priority` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`product_discount_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_order_history`;

CREATE TABLE `si_order_history` (
  `order_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(128) COLLATE utf8_bin NOT NULL,
  `order_status_id` int(5) NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_bin NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`order_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_category_description`;

CREATE TABLE `si_category_description` (
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `description` text COLLATE utf8_bin NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_bin NOT NULL,
  `meta_title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `meta_keyword` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`category_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_return_reason`;

CREATE TABLE `si_return_reason` (
  `return_reason_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`return_reason_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_return_reason` VALUES (1,1,'送货太慢');
INSERT INTO `si_return_reason` VALUES (2,1,'收到的货品不对');
INSERT INTO `si_return_reason` VALUES (3,1,'订单下错了');
INSERT INTO `si_return_reason` VALUES (4,1,'货品有瑕疵');
INSERT INTO `si_return_reason` VALUES (5,1,'其他原因');

DROP TABLE IF EXISTS `si_attribute_group_description`;

CREATE TABLE `si_attribute_group_description` (
  `attribute_group_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`attribute_group_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_zone_to_geo_zone`;

CREATE TABLE `si_zone_to_geo_zone` (
  `zone_to_geo_zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL DEFAULT '0',
  `geo_zone_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`zone_to_geo_zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_zone_to_geo_zone` VALUES (97,44,700,5,'2012-06-01 15:23:25','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (96,44,708,5,'2012-06-01 15:23:25','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (95,44,714,5,'2012-06-01 15:23:25','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (72,44,689,6,'2012-05-31 15:46:02','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (70,44,700,12,'2012-05-31 15:45:57','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (71,44,689,12,'2012-05-31 15:45:57','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (76,44,687,7,'2012-05-31 15:46:52','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (77,44,685,7,'2012-05-31 15:46:52','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (78,44,686,7,'2012-05-31 15:46:52','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (79,44,684,7,'2012-05-31 15:46:52','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (80,44,690,7,'2012-05-31 15:46:52','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (81,44,704,9,'2012-05-31 15:47:15','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (82,44,699,9,'2012-05-31 15:47:15','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (83,44,705,9,'2012-05-31 15:47:15','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (84,44,715,9,'2012-05-31 15:47:15','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (85,44,712,9,'2012-05-31 15:47:15','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (86,44,688,8,'2012-05-31 15:47:30','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (87,44,694,8,'2012-05-31 15:47:30','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (88,44,703,8,'2012-05-31 15:47:30','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (89,44,705,11,'2012-05-31 15:47:40','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (90,44,699,11,'2012-05-31 15:47:40','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (91,44,712,10,'2012-05-31 15:47:52','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (92,44,699,10,'2012-05-31 15:47:52','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (93,44,689,13,'2012-05-31 15:48:54','0000-00-00 00:00:00');
INSERT INTO `si_zone_to_geo_zone` VALUES (94,44,700,13,'2012-05-31 15:48:54','0000-00-00 00:00:00');


DROP TABLE IF EXISTS `si_manufacturer_to_store`;

CREATE TABLE `si_manufacturer_to_store` (
  `manufacturer_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`manufacturer_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_banner`;

CREATE TABLE `si_banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_product_special`;

CREATE TABLE `si_product_special` (
  `product_special_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `priority` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`product_special_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_download`;
CREATE TABLE `si_download` (
  `download_id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '',
  `mask` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '',
  `remaining` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_option_value_description`;

CREATE TABLE `si_option_value_description` (
  `option_value_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`option_value_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_coupon_product`;

CREATE TABLE `si_coupon_product` (
  `coupon_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`coupon_product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_product_to_layout`;

CREATE TABLE `si_product_to_layout` (
  `product_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_information_to_layout`;

CREATE TABLE `si_information_to_layout` (
  `information_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`information_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_voucher_theme_description`;

CREATE TABLE `si_voucher_theme_description` (
  `voucher_theme_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`voucher_theme_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_voucher_theme_description` VALUES (6,1,'圣诞节');
INSERT INTO `si_voucher_theme_description` VALUES (7,1,'生日');
INSERT INTO `si_voucher_theme_description` VALUES (8,1,'其他');

DROP TABLE IF EXISTS `si_tax_class`;

CREATE TABLE `si_tax_class` (
  `tax_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`tax_class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_tax_class` VALUES (9,'增值税','增值税','2009-01-06 23:21:53','2011-09-24 19:54:54');


DROP TABLE IF EXISTS `si_category`;
CREATE TABLE `si_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `top` tinyint(1) NOT NULL DEFAULT '0',
  `column` int(3) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



DROP TABLE IF EXISTS `si_currency`;

CREATE TABLE `si_currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `code` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '',
  `symbol_left` varchar(12) COLLATE utf8_bin NOT NULL,
  `symbol_right` varchar(12) COLLATE utf8_bin NOT NULL,
  `decimal_place` char(1) COLLATE utf8_bin NOT NULL,
  `value` float(15,8) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`currency_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_currency` VALUES (1,'人民币','CNY','￥','','2',1.00000000,1,'2012-08-13 06:53:40');


DROP TABLE IF EXISTS `si_length_class_description`;

CREATE TABLE `si_length_class_description` (
  `length_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) COLLATE utf8_bin NOT NULL,
  `unit` varchar(4) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`length_class_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_length_class_description` VALUES (1,1,'厘米','cm');
INSERT INTO `si_length_class_description` VALUES (2,1,'毫米','mm');
INSERT INTO `si_length_class_description` VALUES (3,1,'英尺','in');

DROP TABLE IF EXISTS `si_order_option`;

CREATE TABLE `si_order_option` (
  `order_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(128) COLLATE utf8_bin NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `product_option_id` int(11) NOT NULL,
  `product_option_value_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL,
  `type` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`order_option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_order_option` VALUES (337,'201205290753619',520,264,80,'Size','Small','select');
INSERT INTO `si_order_option` VALUES (966,'201206101229220',1610,268,98,'Size','Medium','select');


DROP TABLE IF EXISTS `si_language`;

CREATE TABLE `si_language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `code` varchar(15) COLLATE utf8_bin NOT NULL,
  `locale` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(64) COLLATE utf8_bin NOT NULL,
  `directory` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `filename` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


INSERT INTO `si_language` VALUES (1,'简体中文','cn','zh,zh-hk,zh-cn,zh-cn.UTF-8,cn-gb,chinese','cn.png','zh-cn','chinese',1,1);

DROP TABLE IF EXISTS `si_article`;

CREATE TABLE `si_article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` INT NULL DEFAULT 0,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `meta_title` varchar(255) COLLATE utf8_bin NOT NULL,
  `meta_keyword` varchar(255) COLLATE utf8_bin NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `status` int(11) DEFAULT '0',
  `download_only` int(1) NOT NULL DEFAULT '0',
  `viewed` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(11) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`article_id`,`language_id`),
  KEY `title` (`title`),
  KEY `group` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_manufacturer`;
CREATE TABLE `si_manufacturer` (
  `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`manufacturer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_manufacturer_description`;
CREATE TABLE `si_manufacturer_description` (
  `manufacturer_id` INT NOT NULL,
  `language_id` INT NOT NULL,
  `title` VARCHAR(100) NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`manufacturer_id`, `language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_extension`;

CREATE TABLE `si_extension` (
  `extension_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) COLLATE utf8_bin NOT NULL,
  `code` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`extension_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_extension` VALUES (23,'payment','cod');
INSERT INTO `si_extension` VALUES (22,'total','shipping');
INSERT INTO `si_extension` VALUES (57,'total','sub_total');
INSERT INTO `si_extension` VALUES (58,'total','tax');
INSERT INTO `si_extension` VALUES (59,'total','total');
INSERT INTO `si_extension` VALUES (410,'module','banner');
INSERT INTO `si_extension` VALUES (426,'module','carousel');
INSERT INTO `si_extension` VALUES (390,'total','credit');
INSERT INTO `si_extension` VALUES (387,'shipping','flat');
INSERT INTO `si_extension` VALUES (349,'total','handling');
INSERT INTO `si_extension` VALUES (452,'shipping','item');
INSERT INTO `si_extension` VALUES (389,'total','coupon');
INSERT INTO `si_extension` VALUES (413,'module','category');
INSERT INTO `si_extension` VALUES (458,'payment','bank_transfer');
INSERT INTO `si_extension` VALUES (408,'module','account');
INSERT INTO `si_extension` VALUES (393,'total','reward');
INSERT INTO `si_extension` VALUES (453,'module','affiliate');
INSERT INTO `si_extension` VALUES (407,'payment','free_checkout');
INSERT INTO `si_extension` VALUES (419,'module','slideshow');
INSERT INTO `si_extension` VALUES (429,'module','cates');
INSERT INTO `si_extension` VALUES (430,'shipping','free');
INSERT INTO `si_extension` VALUES (457,'shipping','pickup');
INSERT INTO `si_extension` VALUES (446,'shipping','weight');
INSERT INTO `si_extension` VALUES (445,'shipping','weight');
INSERT INTO `si_extension` VALUES (438,'module','latest');
INSERT INTO `si_extension` VALUES (466,'module','information');
INSERT INTO `si_extension` VALUES (465,'module','hotsell');
INSERT INTO `si_extension` VALUES (449,'module','bestseller');
INSERT INTO `si_extension` VALUES (447,'payment','pp_standard');
INSERT INTO `si_extension` VALUES (443,'payment','tenpay');
INSERT INTO `si_extension` VALUES (448,'payment','alipay');
INSERT INTO `si_extension` VALUES (454,'module','mostviewed');
INSERT INTO `si_extension` VALUES (464,'module','dealday');
INSERT INTO `si_extension` VALUES (459,'module','viewed');
INSERT INTO `si_extension` VALUES (469,'feed','google_base');
INSERT INTO `si_extension` VALUES (461,'shipping','citylink');
INSERT INTO `si_extension` VALUES (471,'module','onlineim');
INSERT INTO `si_extension` VALUES (467,'module','store');
INSERT INTO `si_extension` VALUES (468,'module','welcome');
INSERT INTO `si_extension` VALUES (470,'feed','google_sitemap');

DROP TABLE IF EXISTS `si_stock_status`;

CREATE TABLE `si_stock_status` (
  `stock_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`stock_status_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_stock_status` VALUES (7,1,'有货');
INSERT INTO `si_stock_status` VALUES (8,1,'预定');
INSERT INTO `si_stock_status` VALUES (5,1,'缺货');
INSERT INTO `si_stock_status` VALUES (6,1,'2 - 3 天到货');




DROP TABLE IF EXISTS `si_product_option_value`;

CREATE TABLE `si_product_option_value` (
  `product_option_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_value_id` int(11) NOT NULL,
  `quantity` int(3) NOT NULL,
  `subtract` tinyint(1) NOT NULL DEFAULT '0',
  `price` decimal(15,4) NOT NULL,
  `price_prefix` varchar(1) COLLATE utf8_bin NOT NULL,
  `points` int(8) NOT NULL,
  `points_prefix` varchar(1) COLLATE utf8_bin NOT NULL,
  `weight` decimal(15,8) NOT NULL,
  `weight_prefix` varchar(1) COLLATE utf8_bin NOT NULL,
  `color_product_id` int(11) DEFAULT '0',
  `product_value` tinytext COLLATE utf8_bin,
  PRIMARY KEY (`product_option_value_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



DROP TABLE IF EXISTS `si_article_to_download`;

CREATE TABLE `si_article_to_download` (
  `article_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_article_to_store`;

CREATE TABLE `si_article_to_store` (
  `article_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_information_description`;

CREATE TABLE `si_information_description` (
  `information_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `description` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`information_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_information_description` VALUES (4,1,'关于我们','&lt;p&gt;\r\n	关于我们&lt;/p&gt;\r\n');
INSERT INTO `si_information_description` VALUES (5,1,'相关条款','&lt;p&gt;\r\n	相关条款&lt;/p&gt;\r\n');
INSERT INTO `si_information_description` VALUES (3,1,'购买条款','&lt;p&gt;\r\n	购买条款&lt;/p&gt;\r\n');
INSERT INTO `si_information_description` VALUES (6,1,'送货说明','&lt;p&gt;\r\n	送货说明&lt;/p&gt;\r\n');

DROP TABLE IF EXISTS `si_category_to_layout`;

CREATE TABLE `si_category_to_layout` (
  `category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_information_to_store`;

CREATE TABLE `si_information_to_store` (
  `information_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`information_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_information_to_store` VALUES (3,0);
INSERT INTO `si_information_to_store` VALUES (4,0);
INSERT INTO `si_information_to_store` VALUES (5,0);
INSERT INTO `si_information_to_store` VALUES (6,0);

DROP TABLE IF EXISTS `si_information_category`;

CREATE TABLE `si_information_category` (
  `information_category_id` INT NOT NULL AUTO_INCREMENT,
  `sort_order` INT NULL DEFAULT 0,
  `parent_id` INT NULL DEFAULT 0,
  PRIMARY KEY (`information_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_information_category_description`;

CREATE TABLE `si_information_category_description` (
  `information_category_id` INT NOT NULL,
  `language_id` INT NOT NULL,
  `name` VARCHAR(64) NOT NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`information_category_id`, `language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_information`;

CREATE TABLE `si_information` (
  `information_id` int(11) NOT NULL AUTO_INCREMENT,
  `information_category_id` INT NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`information_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_information` VALUES (3,0,3,1);
INSERT INTO `si_information` VALUES (4,0,1,1);
INSERT INTO `si_information` VALUES (5,0,4,1);
INSERT INTO `si_information` VALUES (6,0,2,1);


DROP TABLE IF EXISTS `si_article_category`;
CREATE TABLE `si_article_category` (
  `article_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `download_only` int(1) NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(1) NOT NULL DEFAULT '1',
  `type` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`article_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_order`;

CREATE TABLE `si_order` (
  `order_id` varchar(128) COLLATE utf8_bin NOT NULL,
  `invoice_no` int(11) NOT NULL DEFAULT '0',
  `invoice_prefix` varchar(10) COLLATE utf8_bin NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `store_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `store_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `customer_group_id` int(11) NOT NULL DEFAULT '0',
  `firstname` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `lastname` varchar(32) COLLATE utf8_bin NOT NULL,
  `email` varchar(96) COLLATE utf8_bin NOT NULL,
  `telephone` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `fax` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `shipping_firstname` varchar(32) COLLATE utf8_bin NOT NULL,
  `shipping_lastname` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `shipping_company` varchar(32) COLLATE utf8_bin NOT NULL,
  `shipping_address_1` varchar(128) COLLATE utf8_bin NOT NULL,
  `shipping_address_2` varchar(128) COLLATE utf8_bin NOT NULL,
  `shipping_city` varchar(128) COLLATE utf8_bin NOT NULL,
  `shipping_city_id` int(11) NOT NULL,
  `shipping_postcode` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `shipping_mobile` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `shipping_phone` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `shipping_country` varchar(128) COLLATE utf8_bin NOT NULL,
  `shipping_country_id` int(11) NOT NULL,
  `shipping_zone` varchar(128) COLLATE utf8_bin NOT NULL,
  `shipping_zone_id` int(11) NOT NULL,
  `shipping_address_format` text COLLATE utf8_bin NOT NULL,
  `shipping_method` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '',
  `payment_firstname` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `payment_lastname` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `payment_company` varchar(32) COLLATE utf8_bin NOT NULL,
  `payment_address_1` varchar(128) COLLATE utf8_bin NOT NULL,
  `payment_address_2` varchar(128) COLLATE utf8_bin NOT NULL,
  `payment_city` varchar(128) COLLATE utf8_bin NOT NULL,
  `payment_city_id` int(11) NOT NULL,
  `payment_postcode` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `payment_country` varchar(128) COLLATE utf8_bin NOT NULL,
  `payment_country_id` int(11) NOT NULL,
  `payment_zone` varchar(128) COLLATE utf8_bin NOT NULL,
  `payment_zone_id` int(11) NOT NULL,
  `payment_address_format` text COLLATE utf8_bin NOT NULL,
  `payment_method` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` text COLLATE utf8_bin NOT NULL,
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `reward` int(8) NOT NULL,
  `order_status_id` int(11) NOT NULL DEFAULT '0',
  `affiliate_id` int(11) NOT NULL,
  `commission` decimal(15,4) NOT NULL,
  `language_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `currency_code` varchar(3) COLLATE utf8_bin NOT NULL,
  `currency_value` decimal(15,8) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `ip` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT '',
  `express` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `express_website` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `express_no` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `payment_code` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_voucher_history`;

CREATE TABLE `si_voucher_history` (
  `voucher_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_id` int(11) NOT NULL,
  `order_id` varchar(128) COLLATE utf8_bin NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`voucher_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_product_to_download`;

CREATE TABLE `si_product_to_download` (
  `product_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_affiliate_transaction`;

CREATE TABLE `si_affiliate_transaction` (
  `affiliate_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(11) NOT NULL,
  `order_id` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`affiliate_transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_review`;

CREATE TABLE `si_review` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `author` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `text` text COLLATE utf8_bin NOT NULL,
  `rating` int(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`review_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_attribute`;
CREATE TABLE `si_attribute` (
  `attribute_id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_group_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_logistics`;

CREATE TABLE `si_logistics` (
  `logistics_id` int(11) NOT NULL AUTO_INCREMENT,
  `logistics_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logistics_link` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `language_id` int(1) DEFAULT NULL,
  PRIMARY KEY (`logistics_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `si_logistics` VALUES (3,'顺丰','http://www.sf-express.com/cn/sc/',1);
INSERT INTO `si_logistics` VALUES (4,'天天快递','http://www.tttkd.cn/',1);
INSERT INTO `si_logistics` VALUES (5,'申通快递','http://www.express8.cn/',1);
INSERT INTO `si_logistics` VALUES (6,'韵达快运','http://www.tttkd.cn/',1);

DROP TABLE IF EXISTS `si_voucher`;

CREATE TABLE `si_voucher` (
  `voucher_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(128) COLLATE utf8_bin NOT NULL,
  `code` varchar(10) COLLATE utf8_bin NOT NULL,
  `from_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `from_email` varchar(96) COLLATE utf8_bin NOT NULL,
  `to_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `to_email` varchar(96) COLLATE utf8_bin NOT NULL,
  `message` text COLLATE utf8_bin NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `voucher_theme_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`voucher_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_article_category_description`;

CREATE TABLE `si_article_category_description` (
  `article_category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `meta_keyword` varchar(255) COLLATE utf8_bin NOT NULL,
  `meta_title` VARCHAR(255) COLLATE utf8_bin NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`article_category_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_order_download`;

CREATE TABLE `si_order_download` (
  `order_download_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(128) COLLATE utf8_bin NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `filename` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '',
  `mask` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '',
  `remaining` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_article_to_category`;

CREATE TABLE `si_article_to_category` (
  `article_id` int(11) NOT NULL,
  `article_category_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`article_category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_banner_image`;

CREATE TABLE `si_banner_image` (
  `banner_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) NOT NULL,
  `link` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`banner_image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



DROP TABLE IF EXISTS `si_affiliate`;

CREATE TABLE `si_affiliate` (
  `affiliate_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `lastname` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `email` varchar(96) COLLATE utf8_bin NOT NULL DEFAULT '',
  `telephone` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `fax` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `password` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '',
  `company` varchar(32) COLLATE utf8_bin NOT NULL,
  `website` varchar(255) COLLATE utf8_bin NOT NULL,
  `address_1` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '',
  `address_2` varchar(128) COLLATE utf8_bin NOT NULL,
  `city` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '',
  `postcode` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT '',
  `country_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `code` varchar(64) COLLATE utf8_bin NOT NULL,
  `commission` decimal(4,2) NOT NULL DEFAULT '0.00',
  `tax` varchar(64) COLLATE utf8_bin NOT NULL,
  `payment` varchar(6) COLLATE utf8_bin NOT NULL,
  `cheque` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `paypal` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `bank_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `bank_branch_number` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `bank_swift_code` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `bank_account_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `bank_account_number` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `ip` varchar(15) COLLATE utf8_bin NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `city_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`affiliate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_customer_transaction`;

CREATE TABLE `si_customer_transaction` (
  `customer_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `order_id` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`customer_transaction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_layout`;

CREATE TABLE `si_layout` (
  `layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`layout_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_layout` VALUES (1,'Home');
INSERT INTO `si_layout` VALUES (2,'Product');
INSERT INTO `si_layout` VALUES (3,'Category');
INSERT INTO `si_layout` VALUES (4,'Default');
INSERT INTO `si_layout` VALUES (5,'Manufacturer');
INSERT INTO `si_layout` VALUES (6,'Account');
INSERT INTO `si_layout` VALUES (7,'Checkout');
INSERT INTO `si_layout` VALUES (8,'Contact');
INSERT INTO `si_layout` VALUES (9,'Sitemap');
INSERT INTO `si_layout` VALUES (10,'Affiliate');
INSERT INTO `si_layout` VALUES (11,'Information');
INSERT INTO `si_layout` VALUES (12,'Account-No-Login');
INSERT INTO `si_layout` VALUES (13,'Search');
INSERT INTO `si_layout` VALUES (14,'Cart');
INSERT INTO `si_layout` VALUES (15,'Article');
INSERT INTO `si_layout` VALUES (16,'ArticleCategory');
INSERT INTO `si_layout` VALUES (17,'ArticleSearch');

DROP TABLE IF EXISTS `si_product_image`;

CREATE TABLE `si_product_image` (
  `product_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`product_image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_product_option`;

CREATE TABLE `si_product_option` (
  `product_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_value` text COLLATE utf8_bin NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_option_description`;
CREATE TABLE `si_option_description`(
  `option_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`option_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_option_description` VALUES (2,1,'复选项');
INSERT INTO `si_option_description` VALUES (8,1,'日期');
INSERT INTO `si_option_description` VALUES (7,1,'上传文件');
INSERT INTO `si_option_description` VALUES (10,1,'日期和时间');
INSERT INTO `si_option_description` VALUES (12,1,'送达日期');
INSERT INTO `si_option_description` VALUES (11,1,'大小');
INSERT INTO `si_option_description` VALUES (15,1,'颜色');
INSERT INTO `si_option_description` VALUES (14,1,'点卡');


DROP TABLE IF EXISTS `si_layout_route`;

CREATE TABLE `si_layout_route` (
  `layout_route_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `route` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`layout_route_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_layout_route` VALUES (17,10,0,'affiliate/');
INSERT INTO `si_layout_route` VALUES (29,3,0,'product/category');
INSERT INTO `si_layout_route` VALUES (27,1,3,'common/home');
INSERT INTO `si_layout_route` VALUES (26,1,0,'common/home');
INSERT INTO `si_layout_route` VALUES (20,2,0,'product/product');
INSERT INTO `si_layout_route` VALUES (24,11,0,'information/information');
INSERT INTO `si_layout_route` VALUES (22,5,0,'product/manufacturer');
INSERT INTO `si_layout_route` VALUES (61,7,0,'checkout/checkout');
INSERT INTO `si_layout_route` VALUES (31,8,0,'information/contact');
INSERT INTO `si_layout_route` VALUES (32,12,0,'account/logout');
INSERT INTO `si_layout_route` VALUES (33,12,0,'account/login');
INSERT INTO `si_layout_route` VALUES (34,12,0,'account/forgotten');
INSERT INTO `si_layout_route` VALUES (35,12,0,'account/register');
INSERT INTO `si_layout_route` VALUES (58,6,0,'account/address');
INSERT INTO `si_layout_route` VALUES (57,6,0,'account/invite');
INSERT INTO `si_layout_route` VALUES (56,6,0,'account/newsletter');
INSERT INTO `si_layout_route` VALUES (55,6,0,'account/transaction');
INSERT INTO `si_layout_route` VALUES (54,6,0,'account/return');
INSERT INTO `si_layout_route` VALUES (53,6,0,'account/download');
INSERT INTO `si_layout_route` VALUES (52,6,0,'account/order');
INSERT INTO `si_layout_route` VALUES (51,6,0,'account/wishlist');
INSERT INTO `si_layout_route` VALUES (50,6,0,'account/password');
INSERT INTO `si_layout_route` VALUES (49,6,0,'account/account');
INSERT INTO `si_layout_route` VALUES (48,6,0,'account/edit');
INSERT INTO `si_layout_route` VALUES (47,13,0,'product/search');
INSERT INTO `si_layout_route` VALUES (59,6,0,'account/reward');
INSERT INTO `si_layout_route` VALUES (60,14,0,'checkout/cart');
INSERT INTO `si_layout_route` VALUES (62,15,0,'article/article');
INSERT INTO `si_layout_route` VALUES (63,16,0,'article/category');
INSERT INTO `si_layout_route` VALUES (64,17,0,'article/search');

DROP TABLE IF EXISTS `si_customer_reward`;

CREATE TABLE `si_customer_reward` (
  `customer_reward_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `order_id` varchar(128) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `description` text COLLATE utf8_bin NOT NULL,
  `points` int(8) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`customer_reward_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_geo_zone`;

CREATE TABLE `si_geo_zone` (
  `geo_zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`geo_zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_geo_zone` VALUES (5,'江浙沪','江浙沪','2012-06-01 15:23:25','2011-09-24 19:57:38');
INSERT INTO `si_geo_zone` VALUES (6,'珠三角','珠三角','2012-05-31 15:46:02','2011-09-24 19:57:51');
INSERT INTO `si_geo_zone` VALUES (7,'配送一区','配送一区','2012-05-31 15:46:52','2012-05-29 12:07:10');
INSERT INTO `si_geo_zone` VALUES (8,'配送二区','配送二区','2012-05-31 15:47:30','2012-05-29 12:07:17');
INSERT INTO `si_geo_zone` VALUES (9,'配送三区','配送三区','2012-05-31 15:47:15','2012-05-29 12:07:25');
INSERT INTO `si_geo_zone` VALUES (10,'配送四区','配送四区','2012-05-31 15:47:52','2012-05-29 12:07:34');
INSERT INTO `si_geo_zone` VALUES (11,'配送五区','配送五区- 不支持货到付款','2012-05-31 15:47:40','2012-05-29 12:07:51');
INSERT INTO `si_geo_zone` VALUES (12,'免运费地区','支持免运费的区域','0000-00-00 00:00:00','2012-05-31 15:45:57');
INSERT INTO `si_geo_zone` VALUES (13,'可货到付款','支持货到付款的地区','2012-05-31 15:48:54','2012-05-31 15:48:43');


DROP TABLE IF EXISTS `si_article_to_layout`;

CREATE TABLE `si_article_to_layout` (
  `article_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_message`;

CREATE TABLE `si_message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `reply` text COLLATE utf8_unicode_ci,
  `status` int(1) DEFAULT '0',
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `si_return_history`;

CREATE TABLE `si_return_history` (
  `return_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `return_id` int(11) NOT NULL,
  `return_status_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_bin NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`return_history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_return_action`;

CREATE TABLE `si_return_action` (
  `return_action_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`return_action_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_return_action` VALUES (1,1,'已经退款');
INSERT INTO `si_return_action` VALUES (2,1,'积分问题');
INSERT INTO `si_return_action` VALUES (3,1,'已换货');


DROP TABLE IF EXISTS `si_store`;

CREATE TABLE `si_store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `ssl` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `si_article_tag`;

CREATE TABLE `si_article_tag` (
  `article_id` int(11) NOT NULL,
  `tag` varchar(32) COLLATE utf8_bin NOT NULL,
  `language_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`tag`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_zone`;

CREATE TABLE `si_zone` (
  `zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`zone_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_zone` VALUES (684,44,'AN','安徽省',1);
INSERT INTO `si_zone` VALUES (685,44,'BE','北京',1);
INSERT INTO `si_zone` VALUES (686,44,'CH','重庆',1);
INSERT INTO `si_zone` VALUES (687,44,'FU','福建省',1);
INSERT INTO `si_zone` VALUES (688,44,'GA','甘肃省',1);
INSERT INTO `si_zone` VALUES (689,44,'GU','广东省',1);
INSERT INTO `si_zone` VALUES (690,44,'GX','广西省',1);
INSERT INTO `si_zone` VALUES (691,44,'GZ','贵州省',1);
INSERT INTO `si_zone` VALUES (692,44,'HA','海南省',1);
INSERT INTO `si_zone` VALUES (693,44,'HB','河北省',1);
INSERT INTO `si_zone` VALUES (694,44,'HL','黑龙江省',1);
INSERT INTO `si_zone` VALUES (695,44,'HE','河南省',1);
INSERT INTO `si_zone` VALUES (696,44,'HK','香港',1);
INSERT INTO `si_zone` VALUES (697,44,'HU','湖北省',1);
INSERT INTO `si_zone` VALUES (698,44,'HN','湖南省',1);
INSERT INTO `si_zone` VALUES (699,44,'IM','内蒙古自治区',1);
INSERT INTO `si_zone` VALUES (700,44,'JI','江苏省',1);
INSERT INTO `si_zone` VALUES (701,44,'JX','江西省',1);
INSERT INTO `si_zone` VALUES (702,44,'JL','吉林省',1);
INSERT INTO `si_zone` VALUES (703,44,'LI','辽宁省',1);
INSERT INTO `si_zone` VALUES (704,44,'MA','澳门',1);
INSERT INTO `si_zone` VALUES (705,44,'NI','宁夏回族自治区',1);
INSERT INTO `si_zone` VALUES (706,44,'SH','陕西省',1);
INSERT INTO `si_zone` VALUES (707,44,'SA','山东省',1);
INSERT INTO `si_zone` VALUES (708,44,'SG','上海',1);
INSERT INTO `si_zone` VALUES (709,44,'SX','山西省',1);
INSERT INTO `si_zone` VALUES (710,44,'SI','四川省',1);
INSERT INTO `si_zone` VALUES (711,44,'TI','天津',1);
INSERT INTO `si_zone` VALUES (712,44,'XI','新疆维吾尔自治区',1);
INSERT INTO `si_zone` VALUES (713,44,'YU','云南省',1);
INSERT INTO `si_zone` VALUES (714,44,'ZH','浙江省',1);
INSERT INTO `si_zone` VALUES (715,44,'TW','台湾省',1);
INSERT INTO `si_zone` VALUES (716,44,'QH','青海省',1);
INSERT INTO `si_zone` VALUES (717,44,'XZ','西藏自治区',1);

DROP TABLE IF EXISTS `si_editor`;

CREATE TABLE `si_editor` (
  `editor_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `code` varchar(15) COLLATE utf8_bin NOT NULL,
  `locale` text COLLATE utf8_bin NOT NULL,
  `image` varchar(64) COLLATE utf8_bin NOT NULL,
  `directory` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`editor_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `si_editor` VALUES (1,'tinyMCE','tinymce','&lt;script type=&quot;text/javascript&quot; src=&quot;view/javascript/tinymce/tinymce.min.js&quot;&gt;&lt;/script&gt; \r\n&lt;script type=&quot;text/javascript&quot;&gt;\r\ntinymce.init({\r\n    selector: &quot;textarea.editor&quot;,\r\n    language: &quot;{%language_code%}&quot;,\r\n    height:300,\r\n    plugins: [\r\n        &quot;advlist autolink lists link image charmap print preview anchor&quot;,\r\n        &quot;searchreplace visualblocks code fullscreen&quot;,\r\n        &quot;insertdatetime media table contextmenu paste filemanager&quot;\r\n    ],\r\n    toolbar: &quot;insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image&quot;\r\n});\r\n&lt;/script&gt;','','tinymce',0,1);
INSERT INTO `si_editor` VALUES (2,'ckEditor','ckeditor','&lt;script type=&quot;text/javascript&quot; src=&quot;view/javascript/ckeditor/ckeditor.js&quot;&gt;&lt;/script&gt; \r\n&lt;script type=&quot;text/javascript&quot;&gt;\r\nvar ckconfig={\r\n  filebrowserBrowseUrl: \'index.php?route=common/filemanager&amp;token={%token%}\',\r\n  filebrowserImageBrowseUrl: \'index.php?route=common/filemanager&amp;token={%token%}\',\r\n  filebrowserFlashBrowseUrl: \'index.php?route=common/filemanager&amp;token={%token%}\',\r\n  filebrowserUploadUrl: \'index.php?route=common/filemanager&amp;token={%token%}\',\r\n  filebrowserImageUploadUrl: \'index.php?route=common/filemanager&amp;token={%token%}\',\r\n  filebrowserFlashUploadUrl: \'index.php?route=common/filemanager&amp;token={%token%}\'\r\n};\r\n$(\'textarea.editor\').each(function(i,a){\r\ntry{\r\n  CKEDITOR.replace(a, ckconfig);\r\n}catch(e){}\r\n})\r\n&lt;/script&gt;','','ckeditor',1,1);

DROP TABLE IF EXISTS `si_flink`;

CREATE TABLE `si_flink` (
  `flink_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`flink_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_flink_site`;

CREATE TABLE `si_flink_site` (
  `flink_site_id` int(11) NOT NULL AUTO_INCREMENT,
  `flink_id` int(11) NOT NULL,
  `link` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`flink_site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `si_flink_site_description`;

CREATE TABLE `si_flink_site_description` (
  `flink_site_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `flink_id` int(11) NOT NULL,
  `title` varchar(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`flink_site_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;