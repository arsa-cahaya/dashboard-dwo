<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow" style="background-color: #fac0b9">
            <div class="card-header d-sm-flex flex-row align-items-center flex-0">
                <div class="d-block mb-3 mb-sm-0">
                    <div class="fs-5 fw-normal mb-2">Cost vs Sales</div>
                    <h2 class="fs-3 fw-extrabold">$10,567</h2>
                    <div class="small mt-2">
                        <span class="fw-normal me-2">Yesterday</span>
                        <span class="fas fa-angle-up text-success"></span>
                        <span class="text-success fw-bold">10.57%</span>
                    </div>
                </div>
                <div class="d-flex ms-auto">
                    <a href="#" class="btn btn-secondary btn-sm me-2">Month</a>
                    <a href="#" class="btn btn-sm me-3">Week</a>
                </div>
            </div>
            <div class="card-body p-2">
                <div id="scatterChart"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            var data = @json($scatterData); // <-- data dari Livewire

            var options = {
                chart: {
                    type: 'scatter',
                    height: 350,
                    zoom: {
                        enabled: true
                    }
                },
                series: [{
                    name: "Products",
                    data: data
                }],
                xaxis: {
                    title: {
                        text: 'Cost ($)'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Sales ($)'
                    }
                },
                title: {
                    text: 'Cost vs Sales',
                    align: 'center'
                }
            };

            var chart = new ApexCharts(document.querySelector("#scatterChart"), options);
            chart.render();
        });
    </script>
</div>
