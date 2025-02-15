@extends('parts.header')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('informasisekolah')}}">Informasi Sekolah</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Informasi Sekolah</li>
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
							<div class="card-header align-items-center border-bottom-dark px-0">
								<div class="card-title mb-0">
									<h3 class="card-label mb-0 font-weight-bold text-body">
										@if (count($informasisekolah) > 0)
											Edit Informasi Sekolah
										@else
											Tambah Informasi Sekolah
										@endif
									</h3>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-12 px-4">
						<div class="card card-custom gutter-b bg-white border-0">
							<div class="card-body">
								@if (count($informasisekolah) > 0)
									<form action="{{route('informasisekolah-edit')}}" method="post">
								@else
									<form action="{{route('informasisekolah-store')}}" method="post">
								@endif
									@csrf

									<div class="form-group row">
										<!-- Nama InformasiSekolah -->
										<div class="col-md-12">
											<label class="text-body">NPSN</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" id="NPSN" name="NPSN" placeholder="NPSN" value="{{ count($informasisekolah) > 0 ? $informasisekolah[0]['NPSN'] : '' }}" readonly required="">
											</fieldset>
										</div>

                                        <div class="col-md-12">
											<label class="text-body">Nama Sekolah</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" id="NamaSekolah" name="NamaSekolah" placeholder="NamaSekolah" value="{{ count($informasisekolah) > 0 ? $informasisekolah[0]['NamaSekolah'] : '' }}" required="">
											</fieldset>
										</div>

                                        <div class="col-md-12">
											<label class="text-body">Alamat Sekolah</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" id="AlamatSekolah" name="AlamatSekolah" placeholder="AlamatSekolah" value="{{ count($informasisekolah) > 0 ? $informasisekolah[0]['AlamatSekolah'] : '' }}" required="">
											</fieldset>
										</div>

                                        <div class="col-md-6">
											<label class="text-body">SK Pendirian Sekolah</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" id="SKPendirianSekolah" name="SKPendirianSekolah" placeholder="SKPendirianSekolah" value="{{ count($informasisekolah) > 0 ? $informasisekolah[0]['SKPendirianSekolah'] : '' }}" required="">
											</fieldset>
										</div>

                                        <div class="col-md-6">
											<label class="text-body">Tanggal SK Pendirian Sekolah</label>
											<fieldset class="form-group mb-3">
												<input type="date" class="form-control" id="TanggalSKPendirian" name="TanggalSKPendirian" placeholder="TanggalSKPendirian" value="{{ count($informasisekolah) > 0 ? $informasisekolah[0]['TanggalSKPendirian'] : '' }}" required="">
											</fieldset>
										</div>

                                        <div class="col-md-6">
											<label class="text-body">SK Izin Operasional</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" id="SKIzinOperasional" name="SKIzinOperasional" placeholder="SKIzinOperasional" value="{{ count($informasisekolah) > 0 ? $informasisekolah[0]['SKIzinOperasional'] : '' }}" required="">
											</fieldset>
										</div>

                                        <div class="col-md-6">
											<label class="text-body">Tanggal SK Izin Operasional</label>
											<fieldset class="form-group mb-3">
												<input type="date" class="form-control" id="TanggalSKOperasional" name="TanggalSKOperasional" placeholder="TanggalSKOperasional" value="{{ count($informasisekolah) > 0 ? $informasisekolah[0]['TanggalSKOperasional'] : '' }}" required="">
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
