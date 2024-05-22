@extends('layout.main')
@section('content')
<div class="class">
    <div class="row">
        <div class="col-4">
            <div class="card h-md-100">
                <div class="card-header">
                    <div class="d-flex flex-stack">
                        <h4 class="fw-bold text-gray-800 m-0">Jumlah Subjek</h4>
                    </div>
                </div>
                <div class="card-body pt-5">
                    <div class="text-center">
                        <h4 class="fw-bold text-gray-800 m-0"></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card h-md-100">
                <div class="card-header">
                    <div class="d-flex flex-stack">
                        <h4 class="fw-bold text-gray-800 m-0">Jumlah Arsip Foto</h4>
                    </div>
                </div>
                <div class="card-body pt-5">
                    <div class="text-center">
                        <h4 class="fw-bold text-gray-800 m-0"></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card h-md-100">
                <div class="card-header">
                    <div class="d-flex flex-stack">
                        <h4 class="fw-bold text-gray-800 m-0">Jumlah Arsip Video</h4>
                    </div>
                </div>
                <div class="card-body pt-5">
                    <div class="text-center">
                        <h4 class="fw-bold text-gray-800 m-0"></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row pt-4 mb-4">
        <div class="col-4">
            <div class="card h-md-100">
                <div class="card-header">
                    <div class="d-flex flex-stack">
                        <h4 class="fw-bold text-gray-800 m-0">Jumlah Pustaka Buku</h4>
                    </div>
                </div>
                <div class="card-body pt-5">
                    <div class="text-center">
                        <h4 class="fw-bold text-gray-800 m-0"></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card h-md-100">
                <div class="card-header">
                    <div class="d-flex flex-stack">
                        <h4 class="fw-bold text-gray-800 m-0">Jumlah Pustaka video</h4>
                    </div>
                </div>
                <div class="card-body pt-5">
                    <div class="text-center">
                        <h4 class="fw-bold text-gray-800 m-0"></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card h-md-100">
                <div class="card-header">
                    <div class="d-flex flex-stack">
                        <h4 class="fw-bold text-gray-800 m-0">Jumlah Pustaka Audio</h4>
                    </div>
                </div>
                <div class="card-body pt-5">
                    <div class="text-center">
                        <h4 class="fw-bold text-gray-800 m-0"></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div id="count-siswa">  </div>
        </div>
    </div>

</div>
@endsection
@section('javascript')
<script>
    Highcharts.chart('count-siswa', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'TOTAL SISWA 5 TAHUN TERAKHIR',
        align: 'center'
    },
    xAxis: {
        categories: ['USA', 'China', 'Brazil', 'EU', 'India', 'Russia'],
        crosshair: true,
        accessibility: {
            description: 'Countries'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Siswa'
        }
    },
    tooltip: {
        valueSuffix: ' Siswa'
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        {
            name: 'Corn',
            data: [406292, 260000, 107000, 68300, 27500, 14500]
        },
        {
            name: 'Wheat',
            data: [51086, 136000, 5500, 141000, 107180, 77000]
        }
    ]
});

</script>
@endsection