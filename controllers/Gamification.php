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
        $this->load->model('staff_model');
    }

    public function settings()
    {
        $data['title'] = 'Configurações de Gamification';
        $data['competitions'] = $this->gamification_model->get_competitions();
        $data['goals'] = $this->gamification_model->get_goals();
        $data['staff'] = $this->staff_model->get('', ['active' => 1]);

        $this->load->view('admin/settings/index', $data);
    }

    // Função para Adicionar/Editar Competição
    public function competition($id = '')
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $data['start_date'] = to_sql_date($data['start_date']);
            $data['end_date'] = to_sql_date($data['end_date']);
            $data['show_to_all'] = isset($data['show_to_all']) ? 1 : 0;

            if ($id == '') {
                $success = $this->gamification_model->add_competition($data);
                if ($success) {
                    set_alert('success', 'Competição adicionada com sucesso');
                }
            } else {
                $success = $this->gamification_model->update_competition($data, $id);
                if ($success) {
                    set_alert('success', 'Competição atualizada com sucesso');
                }
            }
            redirect(admin_url('gamification/settings'));
        }
    }

    public function get_competition_data($id)
    {
        if (!$this->input->is_ajax_request()) {
           show_404();
        }
        $data = $this->gamification_model->get_competition($id);
        $data->start_date = _d($data->start_date);
        $data->end_date = _d($data->end_date);

        echo json_encode($data);
    }

    // Função para Adicionar/Editar Meta
    public function goal($id = '')
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            if ($id == '') {
                $success = $this->gamification_model->add_goal($data);
                if ($success) {
                    set_alert('success', 'Meta adicionada com sucesso');
                }
            } else {
                // Lógica para editar (a ser implementada)
            }
            redirect(admin_url('gamification/settings'));
        }
    }

    // Endpoint para o gráfico do painel de leads
    public function get_leaderboard_data($competition_id)
    {
        $data = $this->gamification_model->get_leaderboard($competition_id);
        echo json_encode($data);
    }

    public function delete_competition($id)
    {
        if (!$id) {
            redirect(admin_url('gamification/settings'));
        }
        $response = $this->gamification_model->delete_competition($id);
        if ($response == true) {
            set_alert('success', 'Competição excluída com sucesso');
        } else {
            set_alert('warning', 'Erro ao excluir a competição');
        }
        redirect(admin_url('gamification/settings'));
    }

    public function delete_goal($id)
    {
        if (!$id) {
            redirect(admin_url('gamification/settings'));
        }
        $response = $this->gamification_model->delete_goal($id);
        if ($response == true) {
            set_alert('success', 'Meta excluída com sucesso');
        } else {
            set_alert('warning', 'Erro ao excluir a meta');
        }
        redirect(admin_url('gamification/settings'));
    }
}