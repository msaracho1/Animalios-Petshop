-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_animalios
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `db_animalios` ;

-- -----------------------------------------------------
-- Schema db_animalios
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_animalios` DEFAULT CHARACTER SET utf8 ;
USE `db_animalios` ;

-- -----------------------------------------------------
-- Table `rol`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rol` ;

CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` INT NOT NULL AUTO_INCREMENT,
  `nombre_rol` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_rol`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuario` ;

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `fecha_alta` DATETIME NULL,
  `estado` TINYINT NULL,
  `email` VARCHAR(150) NOT NULL,
  `contraseña` VARCHAR(255) NOT NULL,
  `id_rol` INT NOT NULL,
  PRIMARY KEY (`id_usuario`),
  CONSTRAINT `fk_usuario_rol`
    FOREIGN KEY (`id_rol`)
    REFERENCES `rol` (`id_rol`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `email_UNIQUE` ON `usuario` (`email` ASC);


-- -----------------------------------------------------
-- Table `categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `categoria` ;

CREATE TABLE IF NOT EXISTS `categoria` (
  `id_categoria` INT NOT NULL AUTO_INCREMENT,
  `nombre_categoria` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_categoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `subcategoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `subcategoria` ;

CREATE TABLE IF NOT EXISTS `subcategoria` (
  `id_subcategoria` INT NOT NULL AUTO_INCREMENT,
  `nombre_subcategoria` VARCHAR(100) NOT NULL,
  `id_categoria` INT NOT NULL,
  PRIMARY KEY (`id_subcategoria`),
  CONSTRAINT `fk_subcategoria_categoria1`
    FOREIGN KEY (`id_categoria`)
    REFERENCES `categoria` (`id_categoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `marca`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `marca` ;

CREATE TABLE IF NOT EXISTS `marca` (
  `id_marca` INT NOT NULL AUTO_INCREMENT,
  `nombre_marca` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_marca`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producto` ;

CREATE TABLE IF NOT EXISTS `producto` (
  `id_producto` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `precio` DECIMAL(10,2) NOT NULL,
  `stock` INT NOT NULL,
  `activo` TINYINT NOT NULL,
  `imagen_url` VARCHAR(255) NOT NULL,
  `id_subcategoria` INT NOT NULL,
  `id_marca` INT NOT NULL,
  PRIMARY KEY (`id_producto`),
  CONSTRAINT `fk_producto_subcategoria1`
    FOREIGN KEY (`id_subcategoria`)
    REFERENCES `subcategoria` (`id_subcategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_marca1`
    FOREIGN KEY (`id_marca`)
    REFERENCES `marca` (`id_marca`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pedido` ;

CREATE TABLE IF NOT EXISTS `pedido` (
  `id_pedido` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `fecha_creacion` DATETIME NOT NULL,
  `total` DECIMAL(10,2) NOT NULL,
  `id_estado_pedido` INT NOT NULL,
  `direccion_envio` VARCHAR(255) NOT NULL,
  `metodo_pago` VARCHAR(45) NOT NULL,
  `observaciones` TEXT NOT NULL,
  PRIMARY KEY (`id_pedido`),
  CONSTRAINT `fk_pedido_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `detalle_pedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `detalle_pedido` ;

CREATE TABLE IF NOT EXISTS `detalle_pedido` (
  `id_detalle_pedido` INT NOT NULL AUTO_INCREMENT,
  `cantidad` INT NOT NULL,
  `precio_unitario` DECIMAL(10,2) NOT NULL,
  `subtotal` DECIMAL(10,2) NOT NULL,
  `id_pedido` INT NOT NULL,
  `id_producto` INT NOT NULL,
  PRIMARY KEY (`id_detalle_pedido`),
  CONSTRAINT `fk_detalle_pedido_pedido1`
    FOREIGN KEY (`id_pedido`)
    REFERENCES `pedido` (`id_pedido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_pedido_producto1`
    FOREIGN KEY (`id_producto`)
    REFERENCES `producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `historial_pedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `historial_pedido` ;

CREATE TABLE IF NOT EXISTS `historial_pedido` (
  `id_historial_pedido` INT NOT NULL AUTO_INCREMENT,
  `id_pedido` INT NOT NULL,
  `id_usuario` INT NOT NULL,
  `fecha_hora` DATETIME NOT NULL,
  `id_estado_pedido` INT NOT NULL,
  PRIMARY KEY (`id_historial_pedido`),
  CONSTRAINT `fk_historial_pedido_pedido1`
    FOREIGN KEY (`id_pedido`)
    REFERENCES `pedido` (`id_pedido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_historial_pedido_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `contacto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `contacto` ;

CREATE TABLE IF NOT EXISTS `contacto` (
  `id_contacto` INT NOT NULL AUTO_INCREMENT,
  `numero_ticket` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `asunto` VARCHAR(150) NOT NULL,
  `mensaje` TEXT NOT NULL,
  `fecha_creacion` DATETIME NOT NULL,
  `prioridad` ENUM('baja', 'media', 'alta') NOT NULL,
  `id_usuario` INT NULL,
  `id_estado_contacto` INT NOT NULL,
  PRIMARY KEY (`id_contacto`),
  CONSTRAINT `fk_contacto_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `rol`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_animalios`;
INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES (1, 'vendedor');
INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES (2, 'administrador');
INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES (3, 'cliente');

COMMIT;


-- -----------------------------------------------------
-- Data for table `usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_animalios`;
INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `fecha_alta`, `estado`, `email`, `contraseña`, `id_rol`) VALUES (1, 'Bart', 'Simpson', '', 1, 'bsimpson@animalios.com', '123456', 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `categoria`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_animalios`;
INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`) VALUES (1, 'alimentos secos');
INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`) VALUES (2, 'alimendos humedos');
INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`) VALUES (3, 'alimentos naturales');
INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`) VALUES (4, 'gato');
INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`) VALUES (5, 'perro');
INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`) VALUES (6, 'piedras sanitarias');

COMMIT;


-- -----------------------------------------------------
-- Data for table `subcategoria`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_animalios`;
INSERT INTO `subcategoria` (`id_subcategoria`, `nombre_subcategoria`, `id_categoria`) VALUES (1, 'comederos-gato', 4);
INSERT INTO `subcategoria` (`id_subcategoria`, `nombre_subcategoria`, `id_categoria`) VALUES (2, 'comederos-perro', 5);
INSERT INTO `subcategoria` (`id_subcategoria`, `nombre_subcategoria`, `id_categoria`) VALUES (3, 'collares-gato', 4);
INSERT INTO `subcategoria` (`id_subcategoria`, `nombre_subcategoria`, `id_categoria`) VALUES (4, 'collares-perro', 5);
INSERT INTO `subcategoria` (`id_subcategoria`, `nombre_subcategoria`, `id_categoria`) VALUES (5, 'juguetes', 4);
INSERT INTO `subcategoria` (`id_subcategoria`, `nombre_subcategoria`, `id_categoria`) VALUES (6, 'juguetes-perro', 5);
INSERT INTO `subcategoria` (`id_subcategoria`, `nombre_subcategoria`, `id_categoria`) VALUES (7, 'rascadores', 4);
INSERT INTO `subcategoria` (`id_subcategoria`, `nombre_subcategoria`, `id_categoria`) VALUES (8, 'piedras', 6);

COMMIT;


-- -----------------------------------------------------
-- Data for table `marca`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_animalios`;
INSERT INTO `marca` (`id_marca`, `nombre_marca`) VALUES (1, 'nutrique');
INSERT INTO `marca` (`id_marca`, `nombre_marca`) VALUES (2, 'royal canin');
INSERT INTO `marca` (`id_marca`, `nombre_marca`) VALUES (3, 'eukanuba');
INSERT INTO `marca` (`id_marca`, `nombre_marca`) VALUES (4, 'agility');
INSERT INTO `marca` (`id_marca`, `nombre_marca`) VALUES (5, 'sanicat');

COMMIT;


-- -----------------------------------------------------
-- Data for table `producto`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_animalios`;
INSERT INTO `producto` (`id_producto`, `nombre`, `descripcion`, `precio`, `stock`, `activo`, `imagen_url`, `id_subcategoria`, `id_marca`) VALUES (1, 'Piedras Sanitarias Sanicat - 7 Kg', 'Piedras sanitarias', 9000, 10, 1, DEFAULT, 8, 5);

COMMIT;

