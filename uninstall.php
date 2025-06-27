<?php
defined('BASEPATH') or exit('No direct script access allowed');

$db_prefix = db_prefix();

$this->db->query("DROP TABLE IF EXISTS `{$db_prefix}gamify_goals`;");
$this->db->query("DROP TABLE IF EXISTS `{$db_prefix}gamify_competitions`;");
$this->db->query("DROP TABLE IF EXISTS `{$db_prefix}gamify_participants`;");
$this->db->query("DROP TABLE IF EXISTS `{$db_prefix}gamify_conversions`;");