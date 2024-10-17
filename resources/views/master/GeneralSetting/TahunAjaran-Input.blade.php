@extends('parts.header')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('tahunajaran')}}">Tahun Ajaran</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Tahun Ajaran</li>
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
					<div class="col-lg-12 col-xl-12 px-4">
						<div class="card card-custom gutter-b bg-transparent shadow-none border-0">
							<div class="card-header align-items-center  border-bottom-dark px-0">
								<div class="card-title mb-0">
									<h3 class="card-label mb-0 font-weight-bold text-body">
										@if (count($tahunajaran) > 0)
											Edit Tahun Ajaran
										@else
											Tambah Tahun Ajaran
										@endif
									</h3>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0">
							<div class="card-body">
								@if (count($tahunajaran) > 0)
									<form action="{{route('tahunajaran-edit')}}" method="post">
									<input type="hidden" class="form-control" id="id" name="id" value="{{ count($tahunajaran) > 0 ? $tahunajaran[0]['id'] : '' }}" required="">
								@else
									<form action="{{route('tahunajaran-store')}}" method="post">
								@endif
									@csrf

									<div class="form-group row">
										<!-- Nama Tahun Ajaran -->
										<div class="col-md-12">
											<label class="text-body">Nama Tahun Ajaran</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" id="NamaTahunAjaran" name="NamaTahunAjaran" placeholder="Nama Tahun Ajaran" value="{{ count($tahunajaran) > 0 ? $tahunajaran[0]['NamaTahunAjaran'] : '' }}" required="">
											</fieldset>
										</div>
										
										<!-- Tgl Awal -->
										<div class="col-md-6">
											<label class="text-body">Tanggal Awal</label>
											<fieldset class="form-group mb-3">
												<input type="date" class="form-control" id="TglAwal" name="TglAwal" value="{{ count($tahunajaran) > 0 ? $tahunajaran[0]['TglAwal'] : '' }}" required="">
											</fieldset>
										</div>

										<!-- Tgl Akhir -->
										<div class="col-md-6">
											<label class="text-body">Tanggal Akhir</label>
											<fieldset class="form-group mb-3">
												<input type="date" class="form-control" id="TglSelesai" name="TglSelesai" value="{{ count($tahunajaran) > 0 ? $tahunajaran[0]['TglSelesai'] : '' }}" required="">
											</fieldset>
										</div>

										<!-- Submit Button -->
										<div class="col-md-12">
											<button type="submit" class="btn btn-success text-white font-weight-bold me-1 mb-1">Simpan</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
// Custom JavaScript (if needed)
</script>
@endpush
