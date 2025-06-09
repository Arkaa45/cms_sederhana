-- Add email column to users table
ALTER TABLE `users` ADD `email` VARCHAR(255) NOT NULL AFTER `password`;

-- Update existing users with dummy email
UPDATE `users` SET `email` = 'admin1@example.com' WHERE `username` = 'admin1';
UPDATE `users` SET `email` = 'raka@example.com' WHERE `username` = 'Raka Atmaja'; 