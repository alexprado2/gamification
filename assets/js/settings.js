$(function() {
    // ---- Funções do Modal de Competição ----
    function prepare_competition_modal(id) {
        var modal = $('#competition_modal');
        var form = modal.find('form');
        form.trigger('reset');
        modal.find('select.selectpicker').selectpicker('refresh').selectpicker('val', '');

        var actionUrl = admin_url + 'gamification/competition';
        if (typeof(id) !== 'undefined' && id !== '') {
            actionUrl += '/' + id;
            modal.find('.add-title').addClass('hide');
            modal.find('.edit-title').removeClass('hide');
        } else {
            modal.find('.add-title').removeClass('hide');
            modal.find('.edit-title').addClass('hide');
        }
        form.attr('action', actionUrl);
    }

    $('#new_competition_btn').on('click', function(e) {
        e.preventDefault();
        prepare_competition_modal();
        $('#competition_modal').modal('show');
    });

    $('body').on('click', '.btn-edit-competition', function(e) {
        e.preventDefault();
        var competitionId = $(this).data('id');
        $.get(admin_url + 'gamification/get_competition_data/' + competitionId, function(response) {
            prepare_competition_modal(competitionId);
            $('#competition_modal input[name="competition_name"]').val(response.competition_name);
            $('#competition_modal input[name="bonus_value"]').val(response.bonus_value);
            $('#competition_modal input[name="start_date"]').val(response.start_date);
            $('#competition_modal input[name="end_date"]').val(response.end_date);
            $('#competition_modal #show_to_all').prop('checked', response.show_to_all == 1);
            $('#competition_modal select[name="participants[]"]').selectpicker('val', response.participants);
            $('#competition_modal').modal('show');
        }, 'json');
    });

    // ---- Funções do Modal de Metas ----
    function prepare_goal_modal(id) {
        var modal = $('#goal_modal');
        var form = modal.find('form');
        form.trigger('reset');
        
        modal.find('select.selectpicker').selectpicker('refresh').selectpicker('val', '');

        var actionUrl = admin_url + 'gamification/goal';
        if (typeof(id) !== 'undefined' && id !== '') {
            actionUrl += '/' + id;
            modal.find('.add-title').addClass('hide');
            modal.find('.edit-title').removeClass('hide');
        } else {
            modal.find('.add-title').removeClass('hide');
            modal.find('.edit-title').addClass('hide');
        }
        form.attr('action', actionUrl);
    }

    $('#new_goal_btn').on('click', function(e) {
        e.preventDefault();
        prepare_goal_modal();
        $('#goal_modal').modal('show');
    });

    $('body').on('click', '.btn-edit-goal', function(e) {
        e.preventDefault();
        var goalId = $(this).data('id');

        $.get(admin_url + 'gamification/get_goal_data/' + goalId, function(response) {
            prepare_goal_modal(goalId);
            var modal = $('#goal_modal');

            modal.find('input[name="goal_name"]').val(response.goal_name);
            modal.find('input[name="goal_value"]').val(response.goal_value);
            modal.find('input[name="commission_value"]').val(response.commission_value);
            
            modal.find('select[name="target_type"]').selectpicker('val', response.target_type);
            modal.find('select[name="value_type"]').selectpicker('val', response.value_type);
            modal.find('select[name="commission_type"]').selectpicker('val', response.commission_type);

            modal.modal('show');
        }, 'json').fail(function() {
            alert('Ocorreu um erro ao carregar os dados da meta. Verifique a consola do navegador para mais detalhes.');
        });
    });
});