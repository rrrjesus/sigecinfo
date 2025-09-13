<?php $this->layout("_beta"); ?>

  <!-- Breacrumb-->
  <?= $this->insert("views/theme/breadcrumb"); ?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="container-fluid">

            <!-- https://www.highcharts.com/demo/highcharts/donut-chart -->

            <div class="row">

                <div class="col-6 mb-2 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="containerPrinters"></div>
                                <p class="highcharts-description text-center">
                                    Gráfico em tempo real com percentuais de estoque, retirado, reservado, devolvido, assistência, boletim e baixa de impressoras.
                                </p>
                            </figure>
                        </div>
                    </div>
                </div>

                <div class="col-6 mb-2 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="containerTablets"></div>
                                <p class="highcharts-description text-center">
                                    Gráfico em tempo real com percentuais de estoque, retirado, reservado, devolvido, assistência, boletim e baixa de tablets do contrato de 2024.
                                </p>
                            </figure>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-6 mb-2 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="containerChips"></div>
                                <p class="highcharts-description text-center">
                                    Gráfico em tempo real com percentuais de estoque, retirado, reservado, devolvido, assistência, boletim e baixa de chips da Vivo para uso nos tablets.
                                </p>
                            </figure>
                        </div>
                    </div>
                </div>
                
                <div class="col-6 mb-2 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="containerTablets2021"></div>
                                <p class="highcharts-description text-center">
                                    Gráfico em tempo real com percentuais de estoque, retirado, reservado, devolvido, assistência, boletim e baixa de tablets do contrato de 2021.
                                </p>
                            </figure>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<?php $this->start("scripts"); ?>
    <script type="text/javascript">
        $(function () {
            Highcharts.setOptions({
                colors: [
                    '#266b2f', '#28a745', '#ffBf00' , "#fe6a35", "#6b8abc", "#d568fb", "#2ee0ca", "#fa4b42", "#feb56a", "#91e8e1" ]
            });
            Highcharts.chart('containerPrinters', {
                chart: {
                    type: 'pie',
                    custom: {},
                    events: {
                        render() {
                            const chart = this,
                                series = chart.series[0];
                            let customLabel = chart.options.chart.custom.label;

                            if (!customLabel) {
                                customLabel = chart.options.chart.custom.label =
                                    chart.renderer.label(
                                        '<h5>Estoque : <strong><?=$chartPrinters->totals - ($chartPrinters->retirado + $chartPrinters->reservado)?></strong></h5><br/>' +
                                        '<h5>Reservados : <strong><?=$chartPrinters->reservado?></strong></h5><br/>' +
                                        '<h5>Retirados : <strong><?=$chartPrinters->retirado?></strong></h5><br/>' +
                                        '<h5>Total : <strong><?=$chartPrinters->totals?></strong></h5>'
                                    )
                                        .css({
                                            color: '#000',
                                            textAnchor: 'middle'
                                        })
                                        .add();
                            }

                            const x = series.center[0] + chart.plotLeft,
                                y = series.center[1] + chart.plotTop -
                                (customLabel.attr('height') / 2);

                            customLabel.attr({
                                x,
                                y
                            });
                            // Set font size based on chart diameter
                            customLabel.css({
                                fontSize: `${series.center[2] / 14}px`
                            });
                        }
                    }
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                title: {
                    text: 'Entrega de Impressoras Honeywell RP4'
                },
                subtitle: {
                    text:
                    'Entrega das Impressoras Térmicas Portáteis aos Fiscais de Posturas'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        borderRadius: 8,
                        dataLabels: [{
                            enabled: true,
                            distance: 20,
                            format: '{point.name}'
                        }, {
                            enabled: true,
                            distance: -15,
                            format: '{point.percentage:.0f}%',
                            style: {
                                fontSize: '0.9em'
                            }
                        }],
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Honeywell RP4',
                    colorByPoint: true,
                    innerSize: '65%',
                    data: [
                        {
                            name: 'Em estoque',
                            y: <?=$chartPrinters->estoque / $chartPrinters->totals * 100?>
                        },
                        {
                            name: 'Retirados',
                            sliced: true,
                            selected: true,
                            y: <?=$chartPrinters->retirado / $chartPrinters->totals * 100?>
                        },
                        {
                            name: 'Reservados',
                            y: <?=$chartPrinters->reservado / $chartPrinters->totals * 100?>
                        },
                        {
                            name: 'Devolvidos',
                            y: <?=$chartPrinters->devolvido / $chartPrinters->totals * 100?>
                        },
                        {
                            name: 'Assistencia',
                            y: <?=$chartPrinters->assistencia / $chartPrinters->totals * 100?>
                        },
                        {
                            name: 'Boletim',
                            y: <?=$chartPrinters->boletim / $chartPrinters->totals * 100?>
                        },
                        {
                            name: 'Baixa',
                            y: <?=$chartPrinters->baixa / $chartPrinters->totals * 100?>
                        }
                    ]
                }]
            });

            Highcharts.chart('containerTablets', {
                chart: {
                    type: 'pie',
                    custom: {},
                    events: {
                        render() {
                            const chart = this,
                                series = chart.series[0];
                            let customLabel = chart.options.chart.custom.label;

                            if (!customLabel) {
                                customLabel = chart.options.chart.custom.label =
                                    chart.renderer.label(
                                        '<h5>Estoque : <strong><?=$chartTablets->totals - ($chartTablets->retirado + $chartTablets->reservado)?></strong></h5><br/>' +
                                        '<h5>Reservados : <strong><?=$chartTablets->reservado?></strong></h5><br/>' +
                                        '<h5>Retirados : <strong><?=$chartTablets->retirado?></strong></h5><br/>' +
                                        '<h5>Total : <strong><?=$chartTablets->totals?></strong></h5>'
                                    )
                                        .css({
                                            color: '#000',
                                            textAnchor: 'middle'
                                        })
                                        .add();
                            }

                            const x = series.center[0] + chart.plotLeft,
                                y = series.center[1] + chart.plotTop -
                                (customLabel.attr('height') / 2);

                            customLabel.attr({
                                x,
                                y
                            });
                            // Set font size based on chart diameter
                            customLabel.css({
                                fontSize: `${series.center[2] / 14}px`
                            });
                        }
                    }
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                title: {
                    text: 'Entrega de Tablets Samsung A9 + 5G'
                },
                subtitle: {
                    text:
                    'Entrega dos Tablets aos Fiscais de Posturas - Contrato Simpress'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        borderRadius: 8,
                        dataLabels: [{
                            enabled: true,
                            distance: 20,
                            format: '{point.name}'
                        }, {
                            enabled: true,
                            distance: -15,
                            format: '{point.percentage:.0f}%',
                            style: {
                                fontSize: '0.9em'
                            }
                        }],
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Tablets A9 + 5G',
                    colorByPoint: true,
                    innerSize: '65%',
                    data: [
                        {
                            name: 'Em estoque',
                            y: <?=$chartTablets->estoque / $chartTablets->totals * 100?>
                        },
                        {
                            name: 'Retirados',
                            sliced: true,
                            selected: true,
                            y: <?=$chartTablets->retirado / $chartTablets->totals * 100?>
                        },
                        {
                            name: 'Reservados',
                            y: <?=$chartTablets->reservado / $chartTablets->totals * 100?>
                        },
                        {
                            name: 'Devolvidos',
                            y: <?=$chartTablets->devolvido / $chartTablets->totals * 100?>
                        },
                        {
                            name: 'Assistencia',
                            y: <?=$chartTablets->assistencia / $chartTablets->totals * 100?>
                        },
                        {
                            name: 'Boletim',
                            y: <?=$chartTablets->boletim / $chartTablets->totals * 100?>
                        },
                        {
                            name: 'Baixa',
                            y: <?=$chartTablets->baixa / $chartTablets->totals * 100?>
                        }
                    ]
                }]
            });


            Highcharts.chart('containerChips', {
                chart: {
                    type: 'pie',
                    custom: {},
                    events: {
                        render() {
                            const chart = this,
                                series = chart.series[0];
                            let customLabel = chart.options.chart.custom.label;

                            if (!customLabel) {
                                customLabel = chart.options.chart.custom.label =
                                    chart.renderer.label(
                                        '<h5>Estoque : <strong><?=$chartChips->totals - ($chartChips->retirado + $chartChips->reservado)?></strong></h5><br/>' +
                                        '<h5>Reservados : <strong><?=$chartChips->reservado?></strong></h5><br/>' +
                                        '<h5>Retirados : <strong><?=$chartChips->retirado?></strong></h5><br/>' +
                                        '<h5>Total : <strong><?=$chartChips->totals?></strong></h5>'
                                    )
                                        .css({
                                            color: '#000',
                                            textAnchor: 'middle'
                                        })
                                        .add();
                            }

                            const x = series.center[0] + chart.plotLeft,
                                y = series.center[1] + chart.plotTop -
                                (customLabel.attr('height') / 2);

                            customLabel.attr({
                                x,
                                y
                            });
                            // Set font size based on chart diameter
                            customLabel.css({
                                fontSize: `${series.center[2] / 14}px`
                            });
                        }
                    }
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                title: {
                    text: 'Entrega de Chips Vivo 5G'
                },
                subtitle: {
                    text:
                    'Entrega dos Chips Vivo 5G aos Fiscais de Posturas'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        borderRadius: 8,
                        dataLabels: [{
                            enabled: true,
                            distance: 20,
                            format: '{point.name}'
                        }, {
                            enabled: true,
                            distance: -15,
                            format: '{point.percentage:.0f}%',
                            style: {
                                fontSize: '0.9em'
                            }
                        }],
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Chips Vivo 5G',
                    colorByPoint: true,
                    innerSize: '65%',
                    data: [
                        {
                            name: 'Em estoque',
                            y: <?=$chartChips->estoque / $chartChips->totals * 100?>
                        },
                        {
                            name: 'Retirados',
                            sliced: true,
                            selected: true,
                            y: <?=$chartChips->retirado / $chartChips->totals * 100?>
                        },
                        {
                            name: 'Reservados',
                            y: <?=$chartChips->reservado / $chartChips->totals * 100?>
                        },
                        {
                            name: 'Devolvidos',
                            y: <?=$chartChips->devolvido / $chartChips->totals * 100?>
                        },
                        {
                            name: 'Assistencia',
                            y: <?=$chartChips->assistencia / $chartChips->totals * 100?>
                        },
                        {
                            name: 'Boletim',
                            y: <?=$chartChips->boletim / $chartChips->totals * 100?>
                        },
                        {
                            name: 'Baixa',
                            y: <?=$chartChips->baixa / $chartChips->totals * 100?>
                        }
                    ]
                }]
            });

            Highcharts.chart('containerTablets2021', {
                chart: {
                    type: 'pie',
                    custom: {},
                    events: {
                        render() {
                            const chart = this,
                                series = chart.series[0];
                            let customLabel = chart.options.chart.custom.label;

                            if (!customLabel) {
                                customLabel = chart.options.chart.custom.label =
                                    chart.renderer.label(
                                        '<h5>A Baixar : <strong><?=$chartTablets2021->totals - $chartTablets2021->baixa?></strong></h5><br/>' +
                                        '<h5>Com Baixa : <strong><?=$chartTablets2021->baixa?></strong></h5><br/>' +
                                        '<h5>Total : <strong><?=$chartTablets2021->totals?></strong></h5>'
                                    )
                                        .css({
                                            color: '#000',
                                            textAnchor: 'middle'
                                        })
                                        .add();
                            }

                            const x = series.center[0] + chart.plotLeft,
                                y = series.center[1] + chart.plotTop -
                                (customLabel.attr('height') / 2);

                            customLabel.attr({
                                x,
                                y
                            });
                            // Set font size based on chart diameter
                            customLabel.css({
                                fontSize: `${series.center[2] / 14}px`
                            });
                        }
                    }
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                title: {
                    text: 'Devolução de Tablets Samsung Simpress 2021'
                },
                subtitle: {
                    text:
                    'Devolução de Tablets dos Fiscais de Posturas - Contrato Simpress 2021'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        borderRadius: 8,
                        dataLabels: [{
                            enabled: true,
                            distance: 20,
                            format: '{point.name}'
                        }, {
                            enabled: true,
                            distance: -15,
                            format: '{point.percentage:.0f}%',
                            style: {
                                fontSize: '0.9em'
                            }
                        }],
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Tablets Simpress 2021',
                    colorByPoint: true,
                    innerSize: '65%',
                    data: [
                        {
                            name: 'Em estoque',
                            y: <?=$chartTablets2021->estoque / $chartTablets2021->totals * 100?>
                        },
                        {
                            name: 'Retirados',
                            y: <?=$chartTablets2021->retirado / $chartTablets2021->totals * 100?>
                        },
                        {
                            name: 'Reservados',
                            y: <?=$chartTablets2021->reservado / $chartTablets2021->totals * 100?>
                        },
                        {
                            name: 'Devolvidos',
                            y: <?=$chartTablets2021->devolvido / $chartTablets2021->totals * 100?>
                        },
                        {
                            name: 'Assistencia',
                            y: <?=$chartTablets2021->assistencia / $chartTablets2021->totals * 100?>
                        },
                        {
                            name: 'Boletim',
                            y: <?=$chartTablets2021->boletim / $chartTablets2021->totals * 100?>
                        },
                        {
                            name: 'Baixa',
                            sliced: true,
                            selected: true,
                            y: <?=$chartTablets2021->baixa / $chartTablets2021->totals * 100?>
                        }
                    ]
                }]
            });



        });
    </script>
<?php $this->end(); ?>