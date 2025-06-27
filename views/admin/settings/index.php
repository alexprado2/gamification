<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#competitions" aria-controls="competitions" role="tab" data-toggle="tab">Competições</a>
                            </li>
                            <li role="presentation">
                                <a href="#goals" aria-controls="goals" role="tab" data-toggle="tab">Metas e Comissões</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="competitions">
                                <div class="_buttons mtop15">
                                    <a href="#" id="new_competition_btn" class="btn btn-primary">Nova Competição</a>
                                </div>
                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading" />
                                <div class="table-responsive">
                                    <table class="table dt-table">
                                        <thead>
                                            <th>Nome da Competição</th>
                                            <th>Bônus (R$)</th>
                                            <th>Data de Início</th>
                                            <th>Data de Fim</th>
                                            <th>Opções</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($competitions as $competition) { ?>
                                                <tr>
                                                    <td><?php echo $competition['competition_name']; ?></td>
                                                    <td><?php echo number_format($competition['bonus_value'], 2, ',', '.'); ?></td>
                                                    <td><?php echo _d($competition['start_date']); ?></td>
                                                    <td><?php echo _d($competition['end_date']); ?></td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="#" data-id="<?php echo $competition['id']; ?>" class="btn btn-default btn-icon btn-edit-competition"><i class="fa fa-pencil"></i></a>
                                                            <a href="<?php echo admin_url('gamification/delete_competition/' . $competition['id']); ?>" class="btn btn-default btn-icon _delete"><i class="fa-regular fa-trash-can"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="goals">
                                <div class="_buttons mtop15">
                                    <a href="#" id="new_goal_btn" class="btn btn-primary">Nova Meta</a>
                                </div>
                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading" />
                                <div class="table-responsive">
                                     <table class="table dt-table">
                                        <thead>
                                            <th>Nome da Meta</th>
                                            <th>Tipo de Comissão</th>
                                            <th>Valor da Comissão</th>
                                            <th>Opções</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($goals as $goal) { ?>
                                                <tr>
                                                    <td><?php echo $goal['goal_name']; ?></td>
                                                    <td><?php echo $goal['commission_type'] == 'percentage' ? 'Porcentagem (%)' : 'Valor Fixo (R$)'; ?></td>
                                                    <td><?php echo number_format($goal['commission_value'], 2, ',', '.'); ?></td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="#" data-id="<?php echo $goal['id']; ?>" class="btn btn-default btn-icon btn-edit-goal"><i class="fa fa-pencil"></i></a>
                                                            <a href="<?php echo admin_url('gamification/delete_goal/' . $goal['id']); ?>" class="btn btn-default btn-icon _delete"><i class="fa-regular fa-trash-can"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/settings/competitions'); ?>
<?php $this->load->view('admin/settings/goals'); ?>

<?php init_tail(); ?>
<script src="<?php echo module_dir_url('gamification', 'assets/js/settings.js'); ?>"></script>
<script>
    $(function(){
        initDataTable('.dt-table', window.location.href);
    });
</script>