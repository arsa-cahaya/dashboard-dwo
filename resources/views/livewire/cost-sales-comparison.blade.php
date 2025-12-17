<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow" style="background-color: #fac0b9">
            <div class="card-header d-sm-flex flex-row align-items-center flex-0">
                <div class="d-block mb-3 mb-sm-0">
                    <div class="fs-5 fw-normal mb-2">Cost vs Sales</div>
                </div>
            </div>
            <div class="card-body p-2">
                <div id="comboChart"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            var data = @json($chartData);

            var years = data.map(item => item.year);
            var costs = data.map(item => item.cost);
            var sales = data.map(item => item.sales);
            var profitMargin = data.map(item => item.profit_margin);

            var maxValue = Math.max(...costs, ...sales);

            var options = {
                chart: {
                    type: 'line',
                    height: 400,
                    stacked: false
                },
                stroke: {
                    width: [0, 0, 4]
                }, // line untuk profit margin
                series: [{
                        name: 'Purchase Cost',
                        type: 'column',
                        data: costs,
                        yAxisIndex: 0
                    },
                    {
                        name: 'Sales Revenue',
                        type: 'column',
                        data: sales,
                        yAxisIndex: 0
                    },
                    {
                        name: 'Profit Margin (%)',
                        type: 'line',
                        data: profitMargin,
                        yAxisIndex: 1
                    }
                ],
                xaxis: {
                    categories: years
                },
                yaxis: [{
                        title: {
                            text: 'Amount ($)'
                        },
                        min: 0,
                        labels: {
                            formatter: function(val) {
                                return (val / 1000000).toFixed(1) + 'M';
                            }
                        }
                    },
                    {
                        opposite: true,
                        title: {
                            text: 'Profit Margin (%)'
                        },
                        min: 0,
                        max: 100
                    }
                ],
                tooltip: {
                    shared: true,
                    intersect: false
                },
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [0, 1, 2],
                    formatter: function(val) {
                        return val.toLocaleString(undefined, {
                            maximumFractionDigits: 0
                        });
                    }
                },
                title: {
                    text: 'Cost vs Sales by Year',
                    align: 'center'
                }
            };

            var chart = new ApexCharts(document.querySelector("#comboChart"), options);
            chart.render();
        });
    </script>
</div>
