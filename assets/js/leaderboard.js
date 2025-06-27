$(function() {
    // --- LÓGICA DO PAINEL DE CAMPEONATO (CARREGAMENTO AUTOMÁTICO) ---
    var competitionPanel = $('#competition_panel');
    if (competitionPanel.length > 0) {
        var competitionId = competitionPanel.data('competition-id');
        if (competitionId) {
            renderLeaderboard(competitionId);
        }
    }

    function renderLeaderboard(competitionId) {
        var leaderboardList = $('#leaderboard-list');
        leaderboardList.html('<p>A carregar ranking...</p>');

        $.ajax({
            url: admin_url + 'gamification/get_leaderboard_data/' + competitionId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                leaderboardList.html('');
                if (data.length === 0) {
                    leaderboardList.html('<p>Ainda não há pontuações para esta competição.</p>');
                    return;
                }
                var html = '<ul class="list-unstyled leaderboard-list-container">';
                var medals = ['🥇', '🥈', '🥉'];
                $.each(data, function(index, player) {
                    var position = index + 1;
                    var medal = medals[index] || '🏅';
                    html += '<li>';
                    html += '<span class="leaderboard-position">' + medal + ' ' + position + 'º</span>';
                    html += '<span class="leaderboard-name">' + player.firstname + ' ' + player.lastname + '</span>';
                    html += '<span class="leaderboard-score">' + player.score + ' Pts</span>';
                    html += '</li>';
                });
                html += '</ul>';
                leaderboardList.html(html);
            }
        });
    }

    // --- LÓGICA DO PAINEL DE METAS (CARREGAMENTO AUTOMÁTICO) ---
    var goalPanel = $('#goal_panel');
    if (goalPanel.length > 0) {
        var goalId = goalPanel.data('goal-id');
        if (goalId) {
            renderGoalSpeedometer(goalId);
        }
    }

    function renderGoalSpeedometer(goalId) {
        var chartContainer = $('#goal-speedometer-chart');
        chartContainer.html('<p>A carregar meta...</p>');

        $.ajax({
            url: admin_url + 'gamification/get_goal_progress_data/' + goalId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                chartContainer.html('');
                var options = {
                    series: [data.progress],
                    chart: {
                        type: 'radialBar',
                        height: 350,
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                margin: 0,
                                size: '70%',
                            },
                            dataLabels: {
                                name: {
                                    offsetY: -10,
                                    show: true,
                                    color: '#888',
                                    fontSize: '17px'
                                },
                                value: {
                                    formatter: function(val) {
                                        return parseInt(val) + '%';
                                    },
                                    color: '#111',
                                    fontSize: '36px',
                                    show: true,
                                }
                            }
                        }
                    },
                    labels: ['Progresso'],
                    stroke: {
                        lineCap: 'round'
                    },
                    title: {
                        text: 'Progresso: ' + data.current + ' de ' + data.goal + ' (' + data.label + ')',
                        align: 'center'
                    }
                };
                var chart = new ApexCharts(document.querySelector("#goal-speedometer-chart"), options);
                chart.render();
            }
        });
    }
});