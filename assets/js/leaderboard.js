$(function() {
    $('#competition_selector').on('change', function() {
        var competitionId = $(this).val();
        if (competitionId) {
            renderLeaderboardChart(competitionId);
        }
    });

    function renderLeaderboardChart(competitionId) {
        // Limpa o gráfico anterior
        $('#leaderboard-chart').html('');

        $.ajax({
            url: admin_url + 'gamification/get_leaderboard_data/' + competitionId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var options = {
                    series: data.series,
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: data.categories,
                    },
                    title: {
                        text: 'Ranking da Competição'
                    }
                };

                var chart = new ApexCharts(document.querySelector("#leaderboard-chart"), options);
                chart.render();
            }
        });
    }
});