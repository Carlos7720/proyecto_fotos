-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-02-2022 a las 00:53:38
-- Versión del servidor: 5.7.37-0ubuntu0.18.04.1
-- Versión de PHP: 7.2.24-0ubuntu0.18.04.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `foto_express`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Repuestos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `monto_total` decimal(10,2) NOT NULL,
  `fk_id_cliente` int(11) NOT NULL,
  `tipo_pago` enum('paypal','tigomoney') NOT NULL DEFAULT 'paypal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='registro de la compra';

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `fecha`, `monto_total`, `fk_id_cliente`, `tipo_pago`) VALUES
(1, '2021-12-16', '36.00', 6, 'paypal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_fotos`
--

CREATE TABLE `compra_fotos` (
  `id` int(11) NOT NULL,
  `fk_id_compra` int(11) NOT NULL,
  `fk_id_fotos_clientes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='detalle fotos compradas';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(512) NOT NULL,
  `direccion` varchar(1024) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='almacena datos de los eventos del fotografo';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos_clientes`
--

CREATE TABLE `fotos_clientes` (
  `id` int(11) NOT NULL,
  `fk_id_fotos` int(11) NOT NULL,
  `fk_id_cliente` int(11) NOT NULL,
  `fk_id_evento` int(11) NOT NULL,
  `compro` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos_eventos`
--

CREATE TABLE `fotos_eventos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT '5.00' COMMENT 'precio de la foto',
  `fk_id_evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mainlogin`
--

CREATE TABLE `mainlogin` (
  `id` int(11) NOT NULL,
  `username` varchar(15) CHARACTER SET latin1 NOT NULL,
  `email` varchar(40) CHARACTER SET latin1 NOT NULL,
  `password` varchar(20) CHARACTER SET latin1 NOT NULL,
  `role` varchar(10) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `mainlogin`
--

INSERT INTO `mainlogin` (`id`, `username`, `email`, `password`, `role`) VALUES
(11, 'admin', 'admin1@admin1.com', '123456', 'admin'),
(12, 'test', 'test@baulphp.com', '123456', 'personal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media`
--

CREATE TABLE `media` (
  `id` int(11) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `media`
--

INSERT INTO `media` (`id`, `file_name`, `file_type`) VALUES
(1, 'filter.jpg', 'image/jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `buy_price` decimal(25,2) DEFAULT NULL,
  `sale_price` decimal(25,2) NOT NULL,
  `categorie_id` int(11) UNSIGNED NOT NULL,
  `media_id` int(11) DEFAULT '0',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `buy_price`, `sale_price`, `categorie_id`, `media_id`, `date`) VALUES
(1, 'Filtro de gasolina', '100', '5.00', '10.00', 1, 1, '2017-06-16 07:03:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carrito`
--

CREATE TABLE `tbl_carrito` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_carrito`
--

INSERT INTO `tbl_carrito` (`id`, `product_id`, `quantity`, `member_id`) VALUES
(20, 3, 1, 2),
(21, 1, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_orden`
--

CREATE TABLE `tbl_orden` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `order_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_orden`
--

INSERT INTO `tbl_orden` (`id`, `customer_id`, `amount`, `name`, `address`, `city`, `state`, `zip`, `country`, `payment_type`, `order_status`, `order_at`) VALUES
(5, 2, 600, 'ada', 'dad', 'ada', 'dad', '34636', 'peru', 'PAYPAL', 'PENDING', '2018-08-03 16:15:20'),
(6, 2, 600, 'we', 'rwer', 'wr', 'wrwrw', 'rwr', 'rw', 'PAYPAL', 'PENDING', '2018-08-03 16:15:29'),
(7, 2, 600, 'we', 'rwer', 'wr', 'wrwrw', 'rwr', 'rw', 'PAYPAL', 'PENDING', '2018-08-03 16:19:37'),
(8, 2, 4450, 'marcos flores', 'b/ san luis', 'santa cruz', 'andres ibañez', '1111', 'Bolivia', 'PAYPAL', 'PENDING', '2021-12-08 05:44:34'),
(9, 2, 600, 'marcos flores', 'b/ san luis', 'santa cruz', 'andres ibañez', '1111', 'Bolivia', 'PAYPAL', 'PENDING', '2021-12-08 05:52:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_orden_item`
--

CREATE TABLE `tbl_orden_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `item_price` double NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_orden_item`
--

INSERT INTO `tbl_orden_item` (`id`, `order_id`, `product_id`, `item_price`, `quantity`) VALUES
(9, 5, 1, 200, 1),
(10, 5, 2, 200, 2),
(11, 6, 1, 200, 1),
(12, 6, 2, 200, 2),
(13, 7, 1, 200, 1),
(14, 7, 2, 200, 2),
(15, 8, 3, 400, 10),
(16, 8, 4, 450, 1),
(17, 9, 3, 400, 1),
(18, 9, 1, 200, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_pago`
--

CREATE TABLE `tbl_pago` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_response` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_producto`
--

CREATE TABLE `tbl_producto` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_producto`
--

INSERT INTO `tbl_producto` (`id`, `name`, `code`, `image`, `price`) VALUES
(1, 'Audifonos Digitales', 'Udr3535', 'productos/audifonos.jpg', 200.00),
(2, 'Cargador Solar', 'Carga075', 'productos/cargador.jpg', 200.00),
(3, 'Drones Durex', 'Drones0056', 'productos/dron.jpg', 400.00),
(4, 'Xbox Cand', 'Xoerp98', 'productos/xbox.jpg', 450.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `tipo` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`, `tipo`) VALUES
(1, 'Admin Users', 'Admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, '43eg6k31.jpg', 1, '2022-02-23 00:49:17', 1),
(2, 'Special User', 'special', 'ba36b97a41e7faf742ab09bf88405ac04f99599a', 2, 'no_image.jpg', 1, '2017-06-16 07:11:26', 1),
(3, 'Default User', 'user', '12dea96fec20593566ab75692c9949596833adc9', 3, 'no_image.jpg', 1, '2017-06-16 07:11:03', 1),
(10, 'Estudiante 1', 'est1', 'ecd0e6be3cc160800f4ab82c098fb68a5ea82d68', 3, 'no_image.jpg', 1, '2021-11-04 20:44:24', 1),
(11, 'Cliente Uno1', 'Cliente1', '06b8abdc1bed263dcce2f8b6cde6c5189e61e582', 2, '78ya8tec11.jpg', 1, '2021-12-21 20:09:41', 2),
(16, 'cliente Dos', 'cliente2', '4ca688df015ff0ed013fb42e35e07278335c8ebd', 2, '8e3vz4er16.jpg', 1, '2022-02-23 00:37:45', 2),
(22, 'test3', 'examen1', '3b66b23c1f4ac368af1b3ab7b259385f792b7f02', 2, '29v04eem22.jpg', 1, '2021-12-21 21:22:00', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'Special', 2, 0),
(3, 'Estudiantes', 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compra_fotos`
--
ALTER TABLE `compra_fotos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fotos_clientes`
--
ALTER TABLE `fotos_clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fotos_eventos`
--
ALTER TABLE `fotos_eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mainlogin`
--
ALTER TABLE `mainlogin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `categorie_id` (`categorie_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `tbl_carrito`
--
ALTER TABLE `tbl_carrito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_orden`
--
ALTER TABLE `tbl_orden`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_orden_item`
--
ALTER TABLE `tbl_orden_item`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_pago`
--
ALTER TABLE `tbl_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_producto`
--
ALTER TABLE `tbl_producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`code`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `user_level` (`user_level`);

--
-- Indices de la tabla `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `compra_fotos`
--
ALTER TABLE `compra_fotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `fotos_clientes`
--
ALTER TABLE `fotos_clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `fotos_eventos`
--
ALTER TABLE `fotos_eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `mainlogin`
--
ALTER TABLE `mainlogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tbl_carrito`
--
ALTER TABLE `tbl_carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `tbl_orden`
--
ALTER TABLE `tbl_orden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `tbl_orden_item`
--
ALTER TABLE `tbl_orden_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `tbl_pago`
--
ALTER TABLE `tbl_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tbl_producto`
--
ALTER TABLE `tbl_producto`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_products` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `SK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
