-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2026 a las 01:35:16
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sephora_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha_pedido` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `marca` varchar(80) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `marca`, `categoria`, `precio`, `descripcion`) VALUES
(1, 'Brazilian Bum Bum Cream 240ml', 'Sol de Janeiro', 'Skincare', 1150.00, 'Crema corporal reafirmante e hidratante.'),
(2, 'Water Bank Blue Hyaluronic Cream', 'Laneige', 'Skincare', 890.00, 'Crema hidratante profunda con ácido hialurónico.'),
(3, 'C-Firma Fresh Day Serum', 'Drunk Elephant', 'Skincare', 1850.00, 'Sérum de vitamina C para iluminar la piel.'),
(4, 'The Dewy Skin Cream', 'Tatcha', 'Skincare', 1620.00, 'Crema rica en antioxidantes.'),
(5, 'Soy Face Cleanser', 'Fresh', 'Skincare', 820.00, 'Gel limpiador facial suave.'),
(6, 'BHA Liquid Exfoliant 2%', 'Paulas Choice', 'Skincare', 790.00, 'Exfoliante líquido con ácido salicílico.'),
(7, 'Alpha Arbutin 2% + HA', 'The Ordinary', 'Skincare', 320.00, 'Sérum concentrado para reducir manchas.'),
(8, 'Squalane Cleanser 150ml', 'The Ordinary', 'Skincare', 450.00, 'Limpiador suave e hidratante.'),
(9, 'Niacinamide 10% + Zinc 1%', 'The Ordinary', 'Skincare', 280.00, 'Sérum regulador de sebo.'),
(10, 'Advanced Night Repair Serum', 'Estée Lauder', 'Skincare', 2450.00, 'Sérum nocturno antiedad.'),
(11, 'Soft Pinch Liquid Blush', 'Rare Beauty', 'Maquillaje', 590.00, 'Rubor líquido de alta pigmentación.'),
(12, 'Hollywood Flawless Filter', 'Charlotte Tilbury', 'Maquillaje', 980.00, 'Base iluminadora con efecto filtro.'),
(13, 'Radiant Creamy Concealer', 'NARS', 'Maquillaje', 720.00, 'Corrector de cobertura media a alta.'),
(14, 'Airbrush Flawless Finish Powder', 'Charlotte Tilbury', 'Maquillaje', 990.00, 'Polvo compacto microfino matificante.'),
(15, 'Pro Filt’r Soft Matte Foundation', 'Fenty Beauty', 'Maquillaje', 890.00, 'Base de maquillaje mate suave.'),
(16, 'Luminous Silk Foundation', 'Giorgio Armani', 'Maquillaje', 1450.00, 'Base ligera con acabado satinado.'),
(17, 'Brow Freeze Styling Wax', 'Anastasia Beverly Hills', 'Maquillaje', 560.00, 'Cera fijadora transparente para cejas.'),
(18, 'Better Than Sex Mascara', 'Too Faced', 'Maquillaje', 680.00, 'Mascara de pestañas voluminizadora.'),
(19, 'Ambient Lighting Powder', 'Hourglass', 'Maquillaje', 1150.00, 'Polvo iluminador acabado luz.'),
(20, 'Ethereal Eyes Palette', 'Makeup By Mario', 'Maquillaje', 1680.00, 'Paleta de sombras neutras.'),
(21, 'Gloss Bomb Universal Lip Luminizer', 'Fenty Beauty', 'Labiales', 480.00, 'Brillo labial explosivo no pegajoso.'),
(22, 'Dior Addict Lip Glow Oil', 'Dior Beauty', 'Labiales', 890.00, 'Aceite nutritivo para labios.'),
(23, 'Lip Sleeping Mask Berry', 'Laneige', 'Labiales', 540.00, 'Mascarilla nocturna para labios.'),
(24, 'Matte Revolution - Pillow Talk', 'Charlotte Tilbury', 'Labiales', 780.00, 'Labial mate cremoso tono nude.'),
(25, 'Kind Words Matte Lipstick', 'Rare Beauty', 'Labiales', 490.00, 'Labial mate suave.'),
(26, 'Lip Butter Balm Vanilla', 'Summer Fridays', 'Labiales', 580.00, 'Bálsamo labial sedoso.'),
(27, 'Powder Kiss Liquid Lipcolour', 'MAC Cosmetics', 'Labiales', 520.00, 'Labial líquido mate esfumado.'),
(28, 'Rouge Dior Lipstick Matte', 'Dior Beauty', 'Labiales', 950.00, 'Labial de lujo con extractos florales.'),
(29, 'Lip Injection Maximum Plump', 'Too Faced', 'Labiales', 690.00, 'Brillo voluminizador de labios.'),
(30, 'Almost Lipstick - Black Honey', 'Clinique', 'Labiales', 510.00, 'Bálsamo con pigmento adaptable.'),
(31, 'Baccarat Rouge 540 Eau de Parfum', 'Maison Francis Kurkdjian', 'Fragancias', 6800.00, 'Fragancia de lujo ambarada.'),
(32, 'Sauvage Eau de Parfum 100ml', 'Dior Beauty', 'Fragancias', 3450.00, 'Fragancia masculina fresca.'),
(33, 'Miss Dior Eau de Parfum 50ml', 'Dior Beauty', 'Fragancias', 2850.00, 'Perfume floral con rosa de grasse.'),
(34, 'Black Opium Eau de Parfum', 'Yves Saint Laurent', 'Fragancias', 3100.00, 'Fragancia de café negro y vainilla.'),
(35, 'Good Girl Eau de Parfum', 'Carolina Herrera', 'Fragancias', 2980.00, 'Fragancia oriental floral.'),
(36, 'Tobacco Vanille Eau de Parfum', 'Tom Ford', 'Fragancias', 4200.00, 'Fragancia opulenta de especias y vainilla.'),
(37, 'Cheirosa 68 Perfume Mist 240ml', 'Sol de Janeiro', 'Fragancias', 850.00, 'Bruma corporal con jazmín brasileño.'),
(38, 'Replica By the Fireplace', 'Maison Margiela', 'Fragancias', 3250.00, 'Perfume cálido con castaña asada.'),
(39, 'Flora Gorgeous Gardenia', 'Gucci', 'Fragancias', 2950.00, 'Perfume floral dulce.'),
(40, 'You Eau de Parfum', 'Glossier', 'Fragancias', 1850.00, 'Fragancia suave e íntima.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `detalle_pedidos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_pedidos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
