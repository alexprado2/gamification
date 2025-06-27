<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gamification_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_competitions()
    {
        // Lógica para buscar competições do BD
        return [];
    }
    
    public function get_goals()
    {
        // Lógica para buscar metas do BD
        return [];
    }
    
    public function get_leaderboard($competition_id)
    {
        // TODO: Lógica principal aqui.
        // 1. Buscar todos os participantes da competição.
        // 2. Para cada participante, contar o número de conversões ou somar o valor das vendas na tabela 'gamify_conversions'.
        // 3. Ordenar os resultados.
        // 4. Formatar os dados para o ApexCharts.
        
        // Exemplo de dados de retorno para o gráfico:
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
        // TODO: Lógica para registrar a conversão.
        // 1. Obter o ID do vendedor (staff_id) e o valor do lead.
        // 2. Verificar se o vendedor participa de alguma competição ou meta ativa.
        // 3. Inserir um registro na tabela 'gamify_conversions'.
        return true;
    }
}