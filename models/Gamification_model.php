<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gamification_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add_competition($data)
    {
        $participants = $data['participants'];
        unset($data['participants']);
        $this->db->insert(db_prefix() . 'gamify_competitions', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            foreach ($participants as $staff_id) {
                $this->db->insert(db_prefix() . 'gamify_participants', [
                    'competition_id'   => $insert_id,
                    'participant_id'   => $staff_id,
                    'participant_type' => 'staff',
                ]);
            }
            return true;
        }

        return false;
    }

    public function add_goal($data)
    {
        $this->db->insert(db_prefix() . 'gamify_goals', $data);
        $insert_id = $this->db->insert_id();

        return $insert_id ? true : false;
    }

    public function get_competitions()
    {
        return $this->db->get(db_prefix() . 'gamify_competitions')->result_array();
    }

    public function get_goals()
    {
        return $this->db->get(db_prefix() . 'gamify_goals')->result_array();
    }

    public function get_leaderboard($competition_id)
    {
        // Primeiro, obtemos os detalhes da competição para ter as datas
        $competition = $this->db->get_where(db_prefix() . 'gamify_competitions', ['id' => $competition_id])->row();

        if (!$competition) {
            return []; // Retorna um array vazio se a competição não for encontrada
        }

        $start_date = $competition->start_date . ' 00:00:00';
        $end_date   = $competition->end_date . ' 23:59:59';

        $this->db->select('p.participant_id as staff_id, s.firstname, s.lastname');
        $this->db->select('COUNT(c.id) as score');
        $this->db->from(db_prefix() . 'gamify_participants p');
        $this->db->join(db_prefix() . 'staff s', 's.staffid = p.participant_id');

        // Junta as conversões que ocorreram DENTRO do período da competição
        $this->db->join(db_prefix() . 'gamify_conversions c', 
            "c.staff_id = p.participant_id AND c.created_at BETWEEN '{$start_date}' AND '{$end_date}'", 
            'left'
        );

        $this->db->where('p.competition_id', $competition_id);
        $this->db->group_by('p.participant_id, s.firstname, s.lastname');
        $this->db->order_by('score', 'DESC');

        return $this->db->get()->result_array();
    }
    
    public function get_staff_competition_nearing_end($staff_id)
    {
        $today = date('Y-m-d');
        $this->db->select('c.id, c.competition_name');
        $this->db->from(db_prefix() . 'gamify_competitions c');
        $this->db->join(db_prefix() . 'gamify_participants p', 'p.competition_id = c.id');
        $this->db->where('p.participant_id', $staff_id);
        $this->db->where('c.start_date <=', $today);
        $this->db->where('c.end_date >=', $today);
        $this->db->order_by('c.end_date', 'ASC');
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function get_staff_goal_nearing_end($staff_id)
    {
        $today = date('Y-m-d');
        $this->db->where('start_date <=', $today);
        $this->db->where('end_date >=', $today);
        // $this->db->where('assignee_id', $staff_id);
        $this->db->order_by('end_date', 'ASC');
        $this->db->limit(1);
        return $this->db->get(db_prefix() . 'gamify_goals')->row();
    }
    
    public function get_user_goal_progress($goal_id, $staff_id)
    {
        $goal = $this->db->get_where(db_prefix() . 'gamify_goals', ['id' => $goal_id])->row();
        if (!$goal) {
            return [];
        }

        $this->db->where('staff_id', $staff_id);
        $this->db->where('created_at >=', $goal->start_date . ' 00:00:00');
        $this->db->where('created_at <=', $goal->end_date . ' 23:59:59');
        $conversions = $this->db->get(db_prefix() . 'gamify_conversions')->result_array();

        $current_value = 0;
        if ($goal->value_type == 'fixed_brl') {
            $current_value = array_sum(array_column($conversions, 'conversion_value'));
        } else { 
            $current_value = count($conversions);
        }
        
        $progress = ($goal->goal_value > 0) ? ($current_value / $goal->goal_value) * 100 : 0;

        return [
            'goal'     => $goal->goal_value,
            'current'  => $current_value,
            'progress' => round($progress),
            'label'    => $goal->value_type == 'fixed_brl' ? 'R$' : 'Nº',
        ];
    }

    public function log_conversion($lead_id)
    {
        return true;
    }

    public function delete_competition($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'gamify_competitions');
        if ($this->db->affected_rows() > 0) {
            $this->db->where('competition_id', $id);
            $this->db->delete(db_prefix() . 'gamify_participants');
            return true;
        }
        return false;
    }

    public function delete_goal($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'gamify_goals');
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function get_competition($id)
    {
        $this->db->where('id', $id);
        $competition = $this->db->get(db_prefix() . 'gamify_competitions')->row();

        if ($competition) {
            $this->db->select('participant_id');
            $this->db->where('competition_id', $id);
            $participants = $this->db->get(db_prefix() . 'gamify_participants')->result_array();
            $competition->participants = array_column($participants, 'participant_id');
        }

        return $competition;
    }

    public function update_competition($data, $id)
    {
        $participants = $data['participants'];
        unset($data['participants']);

        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'gamify_competitions', $data);
        $this->db->where('competition_id', $id);
        $this->db->delete(db_prefix() . 'gamify_participants');

        foreach ($participants as $staff_id) {
            $this->db->insert(db_prefix() . 'gamify_participants', [
                'competition_id'   => $id,
                'participant_id'   => $staff_id,
                'participant_type' => 'staff',
            ]);
        }
        return true;
    }

    public function get_goal($id)
    {
        $this->db->where('id', $id);
        return $this->db->get(db_prefix() . 'gamify_goals')->row();
    }

    public function update_goal($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'gamify_goals', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }
}