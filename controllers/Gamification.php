<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gamification extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        if (!is_admin()) {
            access_denied('Gamification');
        }
        $this->load->model('gamification_model');
    }

    public function settings()
    {
        $data['title'] = 'Configurações de Gamification';
        $data['competitions'] = $this->gamification_model->get_competitions();
        $data['goals'] = $this->gamification_model->get_goals();
        
        $this->load->view('admin/settings/index', $data);
    }
    
    // Funções para CRUD de Competições (exemplo)
    public function competition()
    {
        if ($this->input->post()) {
            // Lógica para salvar competição
        }
    }
    
    // Funções para CRUD de Metas (exemplo)
    public function goal()
    {
        if ($this->input->post()) {
           // Lógica para salvar meta
        }
    }
    
    // Endpoint para o gráfico do painel de leads
    public function get_leaderboard_data($competition_id)
    {
        // Lógica para buscar os dados da competição e formatar para o ApexCharts
        $data = $this->gamification_model->get_leaderboard($competition_id);
        echo json_encode($data);
    }
}