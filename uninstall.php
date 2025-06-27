<?php
defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();
$db_prefix = db_prefix();

$CI->db->query("DROP TABLE IF EXISTS `{$db_prefix}gamify_goals`;");
$CI->db->query("DROP TABLE IF EXISTS `{$db_prefix}gamify_competitions`;");
$CI->db->query("DROP TABLE IF EXISTS `{$db_prefix}gamify_participants`;");
$CI->db->query("DROP TABLE IF EXISTS `{$db_prefix}gamify_conversions`;");