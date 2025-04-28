-- Database schema for reclamation system

-- Create the reclamation table
CREATE TABLE IF NOT EXISTS `reclamation` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `sujet` VARCHAR(255) NOT NULL,
  `descrip` TEXT NOT NULL,
  `daterec` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(50) DEFAULT 'En attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create the reponse table to store answers for reclamations
CREATE TABLE IF NOT EXISTS `reponse` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `reclamation_id` INT NOT NULL,
  `contenu` TEXT NOT NULL,
  `date_reponse` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `staff_id` INT,
  `staff_name` VARCHAR(255),
  FOREIGN KEY (`reclamation_id`) REFERENCES `reclamation`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add indexes for better performance
ALTER TABLE `reclamation` ADD INDEX `idx_email` (`email`);
ALTER TABLE `reclamation` ADD INDEX `idx_status` (`status`);
ALTER TABLE `reponse` ADD INDEX `idx_reclamation` (`reclamation_id`);