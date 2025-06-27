<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Gamification
Description: Módulo de Metas, Comissões e Campeonatos para a equipe de vendas.
Version: 1.0.0
Author: Alex
*/


define('GAMIFICATION_MODULE_NAME', 'gamification');

hooks()->add_action('admin_init', function(){
    $CI = &get_instance();
    $CI->load->helper(GAMIFICATION_MODULE_NAME . '/gamification');
});

function gamification_init_menu_items()
{
    if (is_admin()) {
        $CI = &get_instance();
        $CI->app_menu->add_sidebar_menu_item('gamification-menu', [
            'name'     => 'Gamification',
            'href'     => admin_url('gamification/settings'),
            'icon'     => 'fa fa-trophy',
            'position' => 25,
        ]);
    }
}
hooks()->add_action('admin_init', 'gamification_init_menu_items');

function gamification_render_leads_header_panels()
{
    $CI = &get_instance();
    $CI->load->model('gamification/gamification_model');

    $staff_id = get_staff_user_id();
    
    $data['competition_nearing_end'] = $CI->gamification_model->get_staff_competition_nearing_end($staff_id);
    $data['goal_nearing_end'] = $CI->gamification_model->get_staff_goal_nearing_end($staff_id);

    echo $CI->load->view('gamification/admin/leads/leads_header', $data, true);
}
hooks()->add_action('custom_leads_header', 'gamification_render_leads_header_panels');

function gamification_log_conversion_on_status_change($data)
{
    $CI = &get_instance();
    $won_status_id = 1;

    if ((int)$data['status'] === $won_status_id) {
        $CI->load->model('gamification/gamification_model');
        $CI->gamification_model->log_conversion($data['lead_id']);
    }
}
hooks()->add_action('after_lead_status_change', 'gamification_log_conversion_on_status_change');

hooks()->add_action('app_admin_head', 'gamification_add_head_components');
function gamification_add_head_components()
{
    echo '<link href="' . module_dir_url(GAMIFICATION_MODULE_NAME, 'assets/css/style.css') . '"  rel="stylesheet" type="text/css" />';
    echo '<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>';
}

hooks()->add_action('app_admin_footer', 'gamification_load_js');
function gamification_load_js(){

     if (strpos($_SERVER['REQUEST_URI'], 'admin/gamification') !== false || strpos($_SERVER['REQUEST_URI'], 'admin/leads') !== false) {
        echo '<script src="' . module_dir_url(GAMIFICATION_MODULE_NAME, 'assets/js/settings.js') . '"></script>';
        echo '<script src="' . module_dir_url(GAMIFICATION_MODULE_NAME, 'assets/js/leaderboard.js') . '"></script>';
     }
}


register_activation_hook(GAMIFICATION_MODULE_NAME, 'gamification_activation_hook');
function gamification_activation_hook()
{
    require_once(__DIR__ . '/install.php');
}

register_uninstall_hook(GAMIFICATION_MODULE_NAME, 'gamification_uninstall_hook');
function gamification_uninstall_hook()
{
    require_once(__DIR__ . '/uninstall.php');
}