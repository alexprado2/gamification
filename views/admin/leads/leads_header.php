<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <?php if ($competition_nearing_end): ?>
                    <div id="competition_panel" data-competition-id="<?php echo $competition_nearing_end->id; ?>">
                        <h4 class="no-margin"><?php echo $competition_nearing_end->competition_name; ?></h4>
                        <hr class="hr-panel-heading">
                        <div id="leaderboard-list" class="mtop15"></div>
                    </div>
                <?php else: ?>
                    <h4 class="no-margin">Painel do Campeonato</h4>
                    <hr class="hr-panel-heading">
                    <p>Nenhuma competição ativa no momento.</p>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <?php if ($goal_nearing_end): ?>
                     <div id="goal_panel" data-goal-id="<?php echo $goal_nearing_end->id; ?>">
                        <h4 class="no-margin"><?php echo $goal_nearing_end->goal_name; ?></h4>
                        <hr class="hr-panel-heading">
                        <div id="goal-speedometer-chart" class="mtop15"></div>
                    </div>
                <?php else: ?>
                    <h4 class="no-margin">Painel de Meta Individual</h4>
                    <hr class="hr-panel-heading">
                    <p>Nenhuma meta individual ativa no momento.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>