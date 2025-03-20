-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema facil_chamado
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema facil_chamado
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `facil_chamado` DEFAULT CHARACTER SET utf8 ;
USE `facil_chamado` ;

-- -----------------------------------------------------
-- Table `facil_chamado`.`tipo_incidente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `facil_chamado`.`tipo_incidente` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(155) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `facil_chamado`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `facil_chamado`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(155) NOT NULL,
  `dt_nascimento` DATE NOT NULL,
  `email` VARCHAR(155) NOT NULL,
  `telefone` BIGINT(14) NOT NULL,
  `whatsapp` BIGINT(14) NOT NULL,
  `senha` VARCHAR(100) NOT NULL,
  `email_confirm` INT NOT NULL,
  `cd_email_confirm` VARCHAR(150) NOT NULL,
  `id_estado` INT NOT NULL,
  `id_cidade` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `facil_chamado`.`ordem_servico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `facil_chamado`.`ordem_servico` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `tp_incidente` INT NOT NULL,
  `stt_os` INT NOT NULL,
  `descricao` TEXT NOT NULL,
  `observacao` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ordem_servico_tipo_incidente_idx` (`tp_incidente` ASC) VISIBLE,
  INDEX `fk_ordem_servico_usuario1_idx` (`id_usuario` ASC) VISIBLE,
  CONSTRAINT `fk_ordem_servico_tipo_incidente`
    FOREIGN KEY (`tp_incidente`)
    REFERENCES `facil_chamado`.`tipo_incidente` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ordem_servico_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `facil_chamado`.`usuario` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `facil_chamado`.`os_timeline`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `facil_chamado`.`os_timeline` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `id_ordem_servico` INT NOT NULL,
  `mensagem` VARCHAR(155) NOT NULL,
  `data` DATE NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_os_timeline_ordem_servico1_idx` (`id_ordem_servico` ASC) VISIBLE,
  CONSTRAINT `fk_os_timeline_ordem_servico1`
    FOREIGN KEY (`id_ordem_servico`)
    REFERENCES `facil_chamado`.`ordem_servico` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `facil_chamado`.`os_contatos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `facil_chamado`.`os_contatos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_ordem_servico` INT NOT NULL,
  `nome` VARCHAR(155) NOT NULL,
  `numero` BIGINT(14) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_os_contatos_ordem_servico1_idx` (`id_ordem_servico` ASC) VISIBLE,
  CONSTRAINT `fk_os_contatos_ordem_servico1`
    FOREIGN KEY (`id_ordem_servico`)
    REFERENCES `facil_chamado`.`ordem_servico` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `facil_chamado`.`os_anexos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `facil_chamado`.`os_anexos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_ordem_servico` INT NOT NULL,
  `nome` VARCHAR(255) NOT NULL,
  `nm_code` LONGTEXT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_anexos_ordem_servico1_idx` (`id_ordem_servico` ASC) VISIBLE,
  CONSTRAINT `fk_anexos_ordem_servico1`
    FOREIGN KEY (`id_ordem_servico`)
    REFERENCES `facil_chamado`.`ordem_servico` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
