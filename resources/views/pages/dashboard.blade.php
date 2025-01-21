@include('partials.header')
<body>
    <div class="contenair">
        @include('partials.sidebar')
        <div class="tableau_content" id="tableau_content">
            @include('partials.topnav')
            <div class="content ">
                <div class="content_main">
                    <h2>Tableau de bord</h2>
                    <div class="container">
                        <div class="row " style="height: 100vh;">
                            <div class="col-md-6">
                                <figure class="highcharts-figure">
                                    <div id="container"></div>
                                    <p class="highcharts-description">
                                        Voici le diagramme circulaire illustrant la répartition des bons de commande en
                                        fonction de leur statut.
                                    </p>
                                </figure>
                            </div>
                            <div class="col-md-6">
                                <figure class="highcharts-figure">
                                    <div id="containerBarChart"></div>
                                    <p class="highcharts-description">
                                        Voici l'histogramme illustrant la répartition des produits en fonction de leur
                                        fournisseurs.
                                    </p>
                                </figure>
                            </div>
                        </div>
                        <div>
                            <figure class="highcharts-figure">
                                <div id="historiqueCommande"></div>
                                <p class="highcharts-description">
                                    Voici le graphique en ligne illustrant le nombre de produit reçu par jour.
                                </p>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/script.js"></script>
    @include('partials.script')
    <script>
        var graphData = @json($results);
        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Ordre des commandes par statut',
                align: 'left'
            },
            tooltip: {
                pointFormatter: function() {
                    var point = this;
                    return `<b>${point.name}</b>: <b>${point.y}</b>`;
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Status',
                data: graphData
            }]
        });

        var barGraphData = @json($barChartData);
        var barGraphCategories = @json($categories);
        Highcharts.chart('containerBarChart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Nombre de produits attribués aux fournisseurs',
                align: 'left'
            },
            xAxis: {
                categories: barGraphCategories,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Nombre de produits'
                }
            },
            tooltip: {
                pointFormatter: function() {
                    return `<b>${this.category}</b>: ${this.y}`;
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Fournisseurs',
                data: barGraphData
            }]
        });

        var lineCategories = @json($lineCategories);
        var lineData = @json($lineData);
        Highcharts.chart('historiqueCommande', {
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Produits reçus par jour',
                align: 'left'
            },

            yAxis: {
                title: {
                    text: 'Produits reçus'
                }
            },

            xAxis: {
                categories: lineCategories
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    }
                }
            },

            series: [{
                name: 'Produit Reçu',
                data: lineData
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
    </script>

</body>

</html>
