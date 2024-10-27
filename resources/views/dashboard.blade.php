@extends('parts.header')
@section('content')

<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
			</ol>
		</nav>
	</div>
</div>
<!--end::Subheader-->
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
	<!--begin::Container-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 px-4">
				<div class="row">
					<div class="col-lg-6 col-xl-4">
						<div class="card card-custom gutter-b bg-white border-0 theme-circle theme-circle-secondary">
							<div class="card-body">
								<h3 class="text-body font-weight-bold">Jumlah Siswa</h3>
								<div class="mt-3">
                                    <div class="d-flex align-items-center">
                                        <span class="text-dark font-weight-bold font-size-h1 me-3">
                                            {{ $siswaCount }}
                                        </span>

                                    </div>
                                </div>
							</div>
						</div>
					</div>

					<div class="col-lg-6 col-xl-4">
						<div class="card card-custom gutter-b bg-white border-0 theme-circle theme-circle-success">
							<div class="card-body">
								<h3 class="text-body font-weight-bold">Siswa Masuk</h3>
								<div class="mt-3">
                                    <div class="d-flex align-items-center">
                                        <span class="text-dark font-weight-bold font-size-h1 me-3">
                                            {{ $siswaMasuk }}
                                        </span>

                                    </div>
                                </div>
							</div>
						</div>
					</div>

					<div class="col-lg-6 col-xl-4">
						<div class="card card-custom gutter-b bg-white border-0 theme-circle theme-circle-primary">
							<div class="card-body">
								<h3 class="text-body font-weight-bold">Siswa Tidak Masuk</h3>
								<div class="mt-3">
                                    <div class="d-flex align-items-center">
                                        <span class="text-dark font-weight-bold font-size-h1 me-3">
                                            {{ $siswaTidakMasuk }}
                                        </span>

                                    </div>
                                </div>
							</div>
						</div>
					</div>

				</div>
			</div>
			
		</div>

		<div class="row">
			<div class="col-lg-6 col-xl-12">
				<div class="card card-custom gutter-b bg-white border-0" >
					<div class="card-header align-items-center  border-0">
						<div class="card-title mb-0">
							<h3 class="card-label mb-0 font-weight-bold text-body">Grafik Kehadiran Per Kelas
							</h3>
						</div>
					</div>
					<div class="card-body pt-3" >
						<div id="chart-1"></div>
					</div>
				</div>
				
			</div>
		</div>

	</div>
</div>
@endsection


@push('scripts')
<script type="text/javascript">

	jQuery(document).ready(function() {
        var AbsensiMasuk = <?php echo json_encode($AbsensiMasuk) ?>;
		var AbsensiTidakMasuk = <?php echo json_encode($dataTidakHadir) ?>;
		console.log(AbsensiMasuk);
		console.log(AbsensiTidakMasuk);
		GenerateKehadiranChart(AbsensiMasuk);
		// GenerateKetidakhadiranChart(AbsensiTidakMasuk);
	});

	function GenerateKehadiranChart(oData) {
		const arrayWithMaxLength = oData['label'].reduce((maxArray, currentArray) => 
			currentArray.length > maxArray.length ? currentArray : maxArray, []
		);
		console.log(oData['series'])
		var options = {
			series: oData['series'],  // Set dynamically based on your data
			chart: {
				height: 350,
				type: 'line',
				dropShadow: {
					enabled: true,
					color: '#000',
					top: 18,
					left: 7,
					blur: 10,
					opacity: 0.2
				},
				zoom: {
					enabled: false
				},
				toolbar: {
					show: false
				}
			},
			colors: ['#77B6EA', '#545454', '#FF5733'], // Add more colors as needed
			dataLabels: {
				enabled: true,
			},
			stroke: {
				curve: 'smooth'
			},
			title: {
				text: 'Data Absensi Siswa Masuk',
				align: 'left'
			},
			grid: {
				borderColor: '#e7e7e7',
				row: {
				colors: ['#f3f3f3', 'transparent'], 
				opacity: 0.5
				},
			},
			markers: {
				size: 1
			},
			xaxis: {
				categories: arrayWithMaxLength,
				title: {
					text: 'Day'
				}
			},
			yaxis: {
				title: {
					text: 'Jumlah Masuk'
				},
				min: 1,
				max: 40
			},
			legend: {
				position: 'top',
				horizontalAlign: 'right',
				floating: true,
				offsetY: -25,
				offsetX: -5
			}
			};

			var chart = new ApexCharts(document.querySelector("#chart-1"), options);
			chart.render();
	}

	function GenerateKetidakhadiranChart(oData) {
		const arrayWithMaxLength = oData['label'].reduce((maxArray, currentArray) => 
			currentArray.length > maxArray.length ? currentArray : maxArray, []
		);
		console.log(oData['series'])
		var options = {
			series: oData['series'],  // Set dynamically based on your data
			chart: {
				height: 350,
				type: 'line',
				dropShadow: {
					enabled: true,
					color: '#000',
					top: 18,
					left: 7,
					blur: 10,
					opacity: 0.2
				},
				zoom: {
					enabled: false
				},
				toolbar: {
					show: false
				}
			},
			colors: ['#77B6EA', '#545454', '#FF5733'], // Add more colors as needed
			dataLabels: {
				enabled: true,
			},
			stroke: {
				curve: 'smooth'
			},
			title: {
				text: 'Data Absensi Siswa Tidak Masuk',
				align: 'left'
			},
			grid: {
				borderColor: '#e7e7e7',
				row: {
				colors: ['#f3f3f3', 'transparent'], 
				opacity: 0.5
				},
			},
			markers: {
				size: 1
			},
			xaxis: {
				categories: arrayWithMaxLength,
				title: {
				text: 'Day'
				}
			},
			yaxis: {
				title: {
					text: 'Jumlah Tidak Masuk'
				},
				min: 1,
				max: 40
			},
			legend: {
				position: 'top',
				horizontalAlign: 'right',
				floating: true,
				offsetY: -25,
				offsetX: -5
			}
		};

		var chart = new ApexCharts(document.querySelector("#chart-2"), options);
		chart.render();
	}


</script>
@endpush