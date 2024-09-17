@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Dashboard</h3>
                    <h6 class="op-7 mb-2">Admin Dashboard</h6>
                </div>
                <div class="ms-md-auto py-2 py-md-0">
                    {{-- <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
          <a href="#" class="btn btn-primary btn-round">Add Customer</a> --}}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Customer</p>
                                        <h4 class="card-title">{{$customerCount}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Lawyer</p>
                                        <h4 class="card-title">{{$lawyerCount}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-luggage-cart"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Sales</p>
                                        <h4 class="card-title">$ 1,345</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
            </div>
            {{-- <div class="col-sm-6 col-md-3">
          <div class="card card-stats card-round">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-icon">
                  <div class="icon-big text-center icon-secondary bubble-shadow-small">
                    <i class="far fa-check-circle"></i>
                  </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                  <div class="numbers">
                    <p class="card-category">Order</p>
                    <h4 class="card-title">576</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> --}}
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Weekly Enrolled Customer</div>
                            <div class="card-tools">
                                <a href="#" class="btn btn-label-success btn-round btn-sm me-2">
                                    <span class="btn-label">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                    Export
                                </a>
                                <a href="#" class="btn btn-label-info btn-round btn-sm">
                                    <span class="btn-label">
                                        <i class="fa fa-print"></i>
                                    </span>
                                    Print
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="min-height: 375px">
                            <canvas id="myChart">

                            </canvas>
                        </div>
                        <div id="myChartLegend"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                {{-- <div class="card card-primary card-round">
            <div class="card-header">
              <div class="card-head-row">
                <div class="card-title">Daily Sales</div>
                <div class="card-tools">
                  <div class="dropdown">
                    <button class="btn btn-sm btn-label-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Export
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-category">March 25 - April 02</div>
            </div>
            <div class="card-body pb-0">
              <div class="mb-4 mt-2">
                <h1>$4,578.58</h1>
              </div>
              <div class="pull-in">
                <canvas id="dailySalesChart"></canvas>
              </div>
            </div>
          </div>
          <div class="card card-round">
            <div class="card-body pb-0">
              <div class="h1 fw-bold float-end text-primary">+5%</div>
              <h2 class="mb-2">17</h2>
              <p class="text-muted">Users online</p>
              <div class="pull-in sparkline-fix">
                <div id="lineChart"><canvas width="428" height="70" style="display: inline-block; width: 428.781px; height: 70px; vertical-align: top;"></canvas></div>
              </div>
            </div>
          </div> --}}
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Weekly Enrolled Lawyer</div>
                            <div class="card-tools">
                                <a href="#" class="btn btn-label-success btn-round btn-sm me-2">
                                    <span class="btn-label">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                    Export
                                </a>
                                <a href="#" class="btn btn-label-info btn-round btn-sm">
                                    <span class="btn-label">
                                        <i class="fa fa-print"></i>
                                    </span>
                                    Print
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-lawyer-container" style="min-height: 375px">
                            <canvas id="lawyerChart">

                            </canvas>
                        </div>
                        <div id="lawyerChartLegend"></div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-4">
                    <div class="card card-primary card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Daily Sales</div>
                                <div class="card-tools">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-label-light dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Export
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-category">March 25 - April 02</div>
                        </div>
                        <div class="card-body pb-0">
                            <div class="mb-4 mt-2">
                                <h1>$4,578.58</h1>
                            </div>
                            <div class="pull-in">
                                <canvas id="dailySalesChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card card-round">
                        <div class="card-body pb-0">
                            <div class="h1 fw-bold float-end text-primary">+5%</div>
                            <h2 class="mb-2">17</h2>
                            <p class="text-muted">Users online</p>
                            <div class="pull-in sparkline-fix">
                                <div id="lineChart"><canvas width="428" height="70"
                                        style="display: inline-block; width: 428.781px; height: 70px; vertical-align: top;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
        </div>
        {{-- <div class="row">
        <div class="col-md-12">
          <div class="card card-round">
            <div class="card-header">
              <div class="card-head-row card-tools-still-right">
                <h4 class="card-title">Users Geolocation</h4>
                <div class="card-tools">
                  <button class="btn btn-icon btn-link btn-primary btn-xs">
                    <span class="fa fa-angle-down"></span>
                  </button>
                  <button class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card">
                    <span class="fa fa-sync-alt"></span>
                  </button>
                  <button class="btn btn-icon btn-link btn-primary btn-xs">
                    <span class="fa fa-times"></span>
                  </button>
                </div>
              </div>
              <p class="card-category">
                Map of the distribution of users around the world
              </p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="table-responsive table-hover table-sales">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="assets/img/flags/id.png" alt="indonesia">
                            </div>
                          </td>
                          <td>Indonesia</td>
                          <td class="text-end">2.320</td>
                          <td class="text-end">42.18%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="assets/img/flags/us.png" alt="united states">
                            </div>
                          </td>
                          <td>USA</td>
                          <td class="text-end">240</td>
                          <td class="text-end">4.36%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="assets/img/flags/au.png" alt="australia">
                            </div>
                          </td>
                          <td>Australia</td>
                          <td class="text-end">119</td>
                          <td class="text-end">2.16%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="assets/img/flags/ru.png" alt="russia">
                            </div>
                          </td>
                          <td>Russia</td>
                          <td class="text-end">1.081</td>
                          <td class="text-end">19.65%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="assets/img/flags/cn.png" alt="china">
                            </div>
                          </td>
                          <td>China</td>
                          <td class="text-end">1.100</td>
                          <td class="text-end">20%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="assets/img/flags/br.png" alt="brazil">
                            </div>
                          </td>
                          <td>Brasil</td>
                          <td class="text-end">640</td>
                          <td class="text-end">11.63%</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mapcontainer">
                    <div id="world-map" class="w-100" style="height: 300px"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> --}}

    </div>
    </div>

@endsection

{{-- @section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/tether.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/shepherd.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/pages/dashboard-analytics.js')) }}"></script>
@endsection --}}

@section('page-script')
    <script>
        $(document).ready(function() {
            customerChart();
            lawyerChart();


            function customerChart() {
                const ctx = document.getElementById('myChart').getContext('2d');
                let startX, endX, isDragging = false;

                const data = {
                    labels: [], // Initially empty
                    datasets: [{
                        label: 'Customer/Week',
                        data: [],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                };

                const config = {
                    type: 'bar',
                    data: data,
                    options: {
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Weeks'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Customer Enrolled Weekly'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                };

                const myChart = new Chart(ctx, config);

                function fetchChartData(start, end) {
                    $.ajax({
                        url: "{{ route('admin.weekly.enrolled.customer') }}",
                        method: "GET",
                        data: {
                            start: start,
                            end: end,
                        },
                        success: function(response) {
                            console.log(start, end);
                            const {
                                labels,
                                data
                            } = response;
                            updateChart(labels, data);
                        },
                        error: function(error) {
                            console.error('Error fetching data:', error);
                        }
                    });
                }

                function updateChart(labels, data) {
                    myChart.data.labels = labels;
                    myChart.data.datasets[0].data = data;
                    myChart.update();
                }

                function handleMouseDown(event) {
                    startX = event.clientX;
                    isDragging = true;
                }

                function handleMouseUp() {
                    isDragging = false;
                }

                function handleMouseMove(event) {
                    if (!isDragging) return;

                    endX = event.clientX;
                    const diffX = startX - endX;
                    if (Math.abs(diffX) > 20) {
                        const range = 10;
                        const direction = diffX > 0 ? 1 : -1;
                        const currentStart = parseInt(myChart.data.labels[0].match(/\d+/)[0]) - 1;
                        const newStart = Math.max(0, currentStart + direction * range);
                        const newEnd = newStart + range - 1;
                        fetchChartData(newStart, newEnd);
                        startX = endX;
                    }
                }

                document.querySelector('.chart-container').addEventListener('mousedown', handleMouseDown);
                document.addEventListener('mouseup', handleMouseUp);
                document.addEventListener('mousemove', handleMouseMove);

                // Initial load
                fetchChartData(0, 9);
            }

            function lawyerChart() {
                const ctx = document.getElementById('lawyerChart').getContext('2d');
                let startX, endX, isDragging = false;

                const data = {
                    labels: [], // Initially empty
                    datasets: [{
                        label: 'Lawyer/Week',
                        data: [],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                };

                const config = {
                    type: 'bar',
                    data: data,
                    options: {
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Weeks'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Lawyer Enrolled Weekly'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                };

                const myChart = new Chart(ctx, config);

                function fetchChartData(start, end) {
                    $.ajax({
                        url: "{{ route('admin.weekly.enrolled.lawyer') }}",
                        method: "GET",
                        data: {
                            start: start,
                            end: end,
                        },
                        success: function(response) {
                            console.log(start, end);
                            const {
                                labels,
                                data
                            } = response;
                            updateChart(labels, data);
                        },
                        error: function(error) {
                            console.error('Error fetching data:', error);
                        }
                    });
                }

                function updateChart(labels, data) {
                    myChart.data.labels = labels;
                    myChart.data.datasets[0].data = data;
                    myChart.update();
                }

                function handleMouseDown(event) {
                    startX = event.clientX;
                    isDragging = true;
                }

                function handleMouseUp() {
                    isDragging = false;
                }

                function handleMouseMove(event) {
                    if (!isDragging) return;

                    endX = event.clientX;
                    const diffX = startX - endX;
                    if (Math.abs(diffX) > 20) {
                        const range = 10;
                        const direction = diffX > 0 ? 1 : -1;
                        const currentStart = parseInt(myChart.data.labels[0].match(/\d+/)[0]) - 1;
                        const newStart = Math.max(0, currentStart + direction * range);
                        const newEnd = newStart + range - 1;
                        fetchChartData(newStart, newEnd);
                        startX = endX;
                    }
                }

                document.querySelector('.chart-lawyer-container').addEventListener('mousedown', handleMouseDown);
                document.addEventListener('mouseup', handleMouseUp);
                document.addEventListener('mousemove', handleMouseMove);

                // Initial load
                fetchChartData(0, 9);
            }

        });
    </script>

@endsection
