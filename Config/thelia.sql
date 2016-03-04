
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- delivery_round
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `delivery_round`;

CREATE TABLE `delivery_round`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `zip_code` VARCHAR(20) NOT NULL,
    `city` VARCHAR(255) NOT NULL,
    `address` TEXT,
    `day` TINYINT NOT NULL,
    `delivery_period` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
