<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('format_goal_column')) {

    function format_goal_column($column_name, $goal)
    {
        $value = isset($goal[$column_name]) ? $goal[$column_name] : '';

        switch ($column_name) {
            case 'target_type':
                return $value == 'user' ? 'Individual' : 'Equipe';
            
            case 'value_type':
                $goal_value = ' (' . number_format($goal['goal_value'], $goal['value_type'] == 'fixed_brl' ? 2 : 0, ',', '.') . ')';
                return ($value == 'fixed_brl' ? 'Valor Fixo (R$)' : 'Nº de Conversões') . $goal_value;

            case 'commission':
                if ($goal['commission_type'] == 'percentage') {
                    return number_format($goal['commission_value'], 2, ',', '.') . '%';
                }
                return 'R$ ' . number_format($goal['commission_value'], 2, ',', '.');

            case 'period':
                return _d($goal['start_date']) . ' a ' . _d($goal['end_date']);

            default:
                return $value;
        }
    }
}