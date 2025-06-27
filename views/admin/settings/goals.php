<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="goal_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('gamification/goal')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title">Editar Meta</span>
                    <span class="add-title">Nova Meta</span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('goal_name', 'Nome da Meta'); ?>
                        <?php echo render_select('target_type', [['id'=>'team', 'name'=>'Equipe'], ['id'=>'user', 'name'=>'Usuário Individual']], ['id', 'name'], 'Para quem?'); ?>
                        <?php echo render_select('value_type', [['id'=>'fixed_brl', 'name'=>'Valor Fixo (R$)'], ['id'=>'conversion_count', 'name'=>'Número de Conversões']], ['id', 'name'], 'Tipo de Valor da Meta'); ?>
                        <?php echo render_input('goal_value', 'Valor da Meta', '', 'number'); ?>
                         <hr />
                        <?php echo render_select('commission_type', [['id'=>'percentage', 'name'=>'Porcentagem (%) sobre valor total'], ['id'=>'fixed_brl', 'name'=>'Valor Fixo (R$) por venda']], ['id', 'name'], 'Tipo de Comissão'); ?>
                        <?php echo render_input('commission_value', 'Valor da Comissão', '', 'number'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>