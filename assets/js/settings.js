$(function() {
    
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
            $('#competition_modal select[name="participants[]"]').val(response.participants).trigger('change');   
            $('#competition_modal').modal('show');
        }, 'json');
    });

    function prepare_competition_modal(id) {
        var modal = $('#competition_modal');
        var form = modal.find('form');
        form.trigger('reset');

        if (typeof(id) !== 'undefined' && id !== '') {
            form.attr('action', admin_url + 'gamification/competition/' + id);
            modal.find('.add-title').hide();
            modal.find('.edit-title').show();
        } else {
            form.attr('action', admin_url + 'gamification/competition');
            modal.find('.add-title').show();
            modal.find('.edit-title').hide();
        }
        modal.find('select[name="participants[]"]').val('').trigger('change');
    }

    $('#new_goal_btn').on('click', function(e) {
        e.preventDefault();
        $('#goal_modal').modal('show');
    });

    $('body').on('click', '.btn-edit-goal', function(e) {
        e.preventDefault();
        alert('A funcionalidade de editar metas ainda precisa ser implementada no JavaScript e Controller.');
    });
});