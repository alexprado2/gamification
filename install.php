<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Obtém a instância do CodeIgniter
$CI = &get_instance();
$db_prefix = db_prefix();

if (!$CI->db->table_exists("{$db_prefix}gamify_goals")) {
    $CI->db->query("
        CREATE TABLE `{$db_prefix}gamify_goals` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `goal_name` VARCHAR(255) NOT NULL,
            `target_type` ENUM('team', 'user') NOT NULL,
            `value_type` ENUM('fixed_brl', 'conversion_count') NOT NULL,
            `goal_value` DECIMAL(15, 2) NOT NULL,
            `commission_type` ENUM('percentage', 'fixed_brl') NOT NULL,
            `commission_value` DECIMAL(15, 2) NOT NULL,
            `start_date` DATE NOT NULL,
            `end_date` DATE NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
}

if (!$CI->db->table_exists("{$db_prefix}gamify_competitions")) {
    $CI->db->query("
        CREATE TABLE `{$db_prefix}gamify_competitions` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `competition_name` VARCHAR(255) NOT NULL,
            `bonus_value` DECIMAL(15, 2) NOT NULL,
            `show_to_all` BOOLEAN NOT NULL DEFAULT TRUE,
            `start_date` DATE NOT NULL,
            `end_date` DATE NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
}

if (!$CI->db->table_exists("{$db_prefix}gamify_participants")) {
    $CI->db->query("
        CREATE TABLE `{$db_prefix}gamify_participants` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `competition_id` INT NOT NULL,
            `participant_id` INT NOT NULL,
            `participant_type` ENUM('staff', 'department') NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
}

if (!$CI->db->table_exists("{$db_prefix}gamify_conversions")) {
    $CI->db->query("
        CREATE TABLE `{$db_prefix}gamify_conversions` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `lead_id` INT NOT NULL,
            `staff_id` INT NOT NULL,
            `competition_id` INT DEFAULT NULL,
            `goal_id` INT DEFAULT NULL,
            `conversion_value` DECIMAL(15, 2) NOT NULL,
            `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
}