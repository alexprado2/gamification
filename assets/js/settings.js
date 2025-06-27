$(function() {
    // Exemplo para abrir o modal de nova competição
    $('#new_competition_btn').on('click', function(e) {
        e.preventDefault();
        $('#competition_modal').modal('show');
    });

    // Exemplo para abrir o modal de nova meta
    $('#new_goal_btn').on('click', function(e) {
        e.preventDefault();
        $('#goal_modal').modal('show');
    });

    // Você precisará adicionar mais lógica aqui para popular os modais ao editar
});