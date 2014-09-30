<?php

CREATE TABLE IF NOT EXISTS `top_stylists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `top_outfits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outfit_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `is_like` tinyint(1) DEFAULT 0 NOT NULL,
  `is_message` tinyint(1) DEFAULT 0 NOT NULL,
  `is_outfit` tinyint(1) DEFAULT 0 NOT NULL,
  `is_order` tinyint(1) DEFAULT 0 NOT NULL,
  `is_request_outfit` tinyint(1) DEFAULT 0 NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


ALTER TABLE	`outfits`
ADD COLUMN `outfit_name` varchar(255) after `stylist_id`;

ALTER TABLE	`outfits_items`
ADD COLUMN `size_id` int(11) after `product_entity_id`;


CREATE TABLE IF NOT EXISTS `stylist_bio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stylist_id` int(11) NOT NULL,
  `hometown` varchar(255) NOT NULL,
  `fashion_tip` varchar(255) NOT NULL,
  `stylist_bio` text NOT NULL,
  `stylist_inspiration` text NOT NULL,
  `funfact` varchar(255) NOT NULL,
  `stylist_social_link` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `stylist_photostream` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stylistbio_id` int(11) NOT NULL,
  `stylist_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `caption` varchar(155) NOT NULL,
  `is_profile` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `stylist_top_outfits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stylist_id` int(11) NOT NULL,
  `outfit_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `users_outfits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `outfit_id` int(11) UNSIGNED NOT NULL,
  `stylist_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `users_size_informations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `custom_shirt_measurement` text NOT NULL,
  `custom_jacket_measurement` text NOT NULL,
  `custom_trouser_measurement` text NOT NULL,
  `custom_vest_measurement` text NOT NULL,
  `custom_measurement_comments` longtext NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `stylist_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `stylist_id` int(11) NOT NULL,
  `notes` text NOT NULL,
  `image` varchar(35) NOT NULL,
  `is_image` int(2) NOT NULL,
  `is_notes` int(2) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `users`
  ADD COLUMN `is_phone` TINYINT(1) NOT NULL DEFAULT '0' AFTER `active`,
  ADD COLUMN `is_skype` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_phone`,
  ADD COLUMN `is_srs_msg` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_skype`,
  ADD COLUMN `comments` TEXT NULL AFTER `is_srs_msg`;


ALTER TABLE `messages`
  ADD COLUMN `is_request_outfit` TINYINT(1) NOT NULL DEFAULT '0' AFTER `outfit_id`
  ADD COLUMN `post_id` INT(11) NOT NULL AFTER `is_request_outfit`;


ALTER TABLE `wishlists`
  ADD COLUMN `post_id` INT(11) NOT NULL AFTER `product_entity_id`;


ALTER TABLE `carts_items`
  ADD COLUMN `outfit_id` INT(11) NOT NULL AFTER `cart_id`;


ALTER TABLE `orders_items`
  ADD COLUMN `post_id` INT(11) NOT NULL AFTER `order_id`,
  ADD COLUMN `outfit_id` INT(11) NOT NULL AFTER `post_id`;


CREATE TABLE IF NOT EXISTS `bookmark_outfits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `outfit_id` int(11) UNSIGNED NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;