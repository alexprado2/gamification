<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="competition_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('gamification/competition')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title">Editar Competição</span>
                    <span class="add-title">Nova Competição</span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('competition_name', 'Nome da Competição'); ?>
                        <?php echo render_input('bonus_value', 'Bonificação (R$) para o Vencedor', '', 'number'); ?>
                        <?php echo render_date_input('start_date', 'Data de Início'); ?>
                        <?php echo render_date_input('end_date', 'Data de Fim'); ?>

                        <?php
                        // Prepara os dados dos funcionários para o render_select
                        $staff_members = [];
                        foreach ($staff as $staff_member) {
                            $staff_members[] = [
                                'id' => $staff_member['staffid'],
                                'name' => $staff_member['firstname'] . ' ' . $staff_member['lastname']
                            ];
                        }
                        // O 'staffid' é o ID e o 'name' é o que será exibido
                        echo render_select('participants[]', $staff_members, ['id', ['name']], 'Participantes (Usuários)', '', ['multiple' => true]);
                        ?>
                        <div class="checkbox checkbox-primary">
                            <input type="checkbox" name="show_to_all" id="show_to_all" value="1" checked>
                            <label for="show_to_all">Painel visível para todos os participantes</label>
                        </div>
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