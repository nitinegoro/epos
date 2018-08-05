

CREATE TABLE `cash_balance` (
  `ID` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mutation` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `description` text,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



INSERT INTO `cash_balance` (`ID`, `date`, `mutation`, `amount`, `description`, `user_id`) VALUES
(2, '2018-08-05 18:59:32', 'masuk', 53000, 'Saldo buka toko  pertama kali ', 1),
(3, '2018-08-05 19:18:49', 'masuk', 45000, 'Hutang orang', 1),
(5, '2018-08-05 19:20:58', 'keluar', 12000, 'Beli bensin pas ngmbaik barang', 1);

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');


CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `tb_category_product` (
  `category_product` int(11) NOT NULL,
  `category` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tb_category_product` (`category_product`, `category`) VALUES
(1, 'Lain-lain'),
(2, 'Rokok'),
(25, 'Minuman Kaleng'),
(26, 'Pecah Belah');



CREATE TABLE `tb_detail_transaction` (
  `id` int(11) NOT NULL,
  `ID_transaction` varchar(50) DEFAULT NULL,
  `product` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `tb_detail_transaction` (`id`, `ID_transaction`, `product`, `quantity`, `price`) VALUES
(32, '000001082018', 9, 7, 11000),
(39, '000001082018', 10, 12, 13500),
(40, '1000011082018', 8, 3, 18000),
(41, '1000011082018', 9, 10, 10500),
(42, '1000012082018', 10, 1, 14000),
(43, '1000012082018', 8, 1, 18000),
(44, '1000013082018', 8, 1, 18000),
(45, '1000013082018', 10, 1, 14000),
(46, '1000011082018', 10, 1, 13500),
(47, '1000014082018', 8, 1, 18000),
(48, '1000015082018', 9, 12, 10500),
(49, '1000015082018', 10, 3, 14000),
(50, '1000016082018', 10, 1, 14000),
(51, '1000016082018', 9, 1, 10500),
(52, '1000016082018', 8, 1, 18000),
(53, '1000017082018', 8, 1, 18000);

CREATE TABLE `tb_product` (
  `ID` int(11) NOT NULL,
  `product_code` varchar(100) NOT NULL DEFAULT '',
  `product_name` varchar(500) DEFAULT NULL,
  `product_unit` char(20) NOT NULL,
  `category_product` int(11) DEFAULT NULL,
  `purchase` int(225) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT '0',
  `default_price` int(11) NOT NULL,
  `reseller_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `tb_product` (`ID`, `product_code`, `product_name`, `product_unit`, `category_product`, `purchase`, `stock`, `default_price`, `reseller_price`) VALUES
(8, '8999909096004', 'Sampoerna Mild 16', 'pcs', 2, 17000, 95, 18000, 17500),
(9, '8999909982000', 'Sampoerna Mild 12', 'pcs', 2, 10000, 93, 10500, 11000),
(10, '8999909000711', 'Roko Magnum Mild 16', 'pcs', 1, 13000, 118, 14000, 13500);


CREATE TABLE `tb_transaction` (
  `ID_transaction` varchar(50) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `paid` int(255) DEFAULT NULL,
  `selling_type` varchar(50) NOT NULL DEFAULT 'default',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tb_transaction` (`ID_transaction`, `date`, `total`, `paid`, `selling_type`, `user_id`) VALUES
('000001082018', '2018-08-05 01:54:56', 42500, 50000, 'default', 1),
('1000011082018', '2018-08-04 04:58:29', 172500, 200000, 'default', 1),
('1000012082018', '2018-08-05 21:49:04', 32000, 50000, 'default', 1),
('1000013082018', '2018-08-05 21:52:54', 32000, 50000, 'default', 1),
('1000014082018', '2018-08-06 02:07:22', 18000, 20000, 'default', 3),
('1000015082018', '2018-08-06 02:08:11', 168000, 170000, 'default', 3),
('1000016082018', '2018-08-06 02:09:17', 42500, 50000, 'default', 3),
('1000017082018', '2018-08-06 02:11:08', 18000, 20000, 'default', 3);


CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `name`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$10$2ZpjYBxwI0HDW.kTlGo2BOpgkOivefv6Z/sSK8qtsEQnhhoe6qG0a', '', 'admin@admin.com', '', NULL, NULL, 'D6qDOOHaCszFx8NMMO45b.', 1268889823, 1533500932, 1, 'Andini Sari', '0822373004116'),
(3, '127.0.0.1', 'kebabelyuk@gmail.com', '$2y$10$2ZpjYBxwI0HDW.kTlGo2BOpgkOivefv6Z/sSK8qtsEQnhhoe6qG0a', NULL, 'kebabelyuk@gmail.com', NULL, NULL, NULL, '4ur2HY5/.OfWFHcakkOYa.', 1533494464, 1533495467, 1, 'Ansori Firdaus Abu Bakar', '081360088999');


CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 3, 2);


ALTER TABLE `cash_balance`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `date` (`date`);

ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tb_category_product`
  ADD PRIMARY KEY (`category_product`);


ALTER TABLE `tb_detail_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_transaction` (`ID_transaction`),
  ADD KEY `product` (`product`);

ALTER TABLE `tb_product`
  ADD PRIMARY KEY (`ID`) USING BTREE;

ALTER TABLE `tb_transaction`
  ADD PRIMARY KEY (`ID_transaction`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

ALTER TABLE `cash_balance`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;


ALTER TABLE `tb_category_product`
  MODIFY `category_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;


ALTER TABLE `tb_detail_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;


ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

