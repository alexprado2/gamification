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
        $example_data = [
            'series' => [
                [
                    'name' => 'Conversões',
                    'data' => [12, 9, 8, 5, 4]
                ]
            ],
            'categories' => ['Vendedor 1', 'Vendedor 2', 'Vendedor 3', 'Vendedor 4', 'Vendedor 5']
        ];

        return $example_data;
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