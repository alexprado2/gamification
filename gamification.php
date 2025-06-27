<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Gamification
Description: Módulo de Metas, Comissões e Campeonatos para a equipe de vendas.
Version: 1.0.0
Author: Alex
Author URI: 
*/

define('GAMIFICATION_MODULE_NAME', 'gamification');

hooks()->add_action('admin_init', 'gamification_init_menu_items');
hooks()->add_action('lead_profile_tab_name', 'gamification_add_lead_profile_tab_name');
hooks()->add_action('lead_profile_tab_content', 'gamification_add_lead_profile_tab_content');
hooks()->add_action('after_lead_status_change', 'gamification_log_conversion_on_status_change');

/**
 * Registra o item de menu para a área de administração.
 */
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

/**
 * Adiciona o nome da nova aba no perfil do lead.
 */
function gamification_add_lead_profile_tab_name($tabs)
{
    $tabs['gamification'] = [
        'name' => 'Competição',
        'icon' => 'fa fa-trophy',
        'visible' => true,
        'order' => 99,
    ];
    return $tabs;
}

/**
 * Injeta o conteúdo na nova aba do perfil do lead.
 */
function gamification_add_lead_profile_tab_content($tab)
{
    if ($tab['name'] == 'Competição') {
        $CI = &get_instance();
        echo $CI->load->view('gamification/admin/leads/competition_panel', [], true);
    }
}

/**
 * Hook para registrar uma conversão quando o status do lead muda.
 */
function gamification_log_conversion_on_status_change($data)
{
    $CI = &get_instance();
    // Você precisa definir quais status são considerados "ganhos"
    $won_status_id = 1; // Exemplo: ID do status 'Ganho'

    if ((int)$data['status'] === $won_status_id) {
        $CI->load->model('gamification/gamification_model');
        // A função log_conversion precisa ser criada no seu modelo.
        // Ela deve verificar se o lead já foi convertido e se o vendedor participa de alguma competição/meta.
        $CI->gamification_model->log_conversion($data['lead_id']);
    }
}


// Registra os scripts JS e CSS
hooks()->add_action('app_admin_head', 'gamification_add_head_components');
function gamification_add_head_components()
{
    echo '<link href="' . module_dir_url(GAMIFICATION_MODULE_NAME, 'assets/css/style.css') . '"  rel="stylesheet" type="text/css" />';
    // Inclui a biblioteca ApexCharts
    echo '<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>';
}

hooks()->add_action('app_admin_footer', 'gamification_load_js');
function gamification_load_js(){
     echo '<script src="' . module_dir_url(GAMIFICATION_MODULE_NAME, 'assets/js/settings.js') . '"></script>';
     echo '<script src="' . module_dir_url(GAMIFICATION_MODULE_NAME, 'assets/js/leaderboard.js') . '"></script>';
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