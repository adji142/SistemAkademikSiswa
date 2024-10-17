@extends('parts.header')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{ route('kelas-paralel') }}">Kelas Paralel</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Kelas Paralel</li>
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
										@if (count($kelasparalel) > 0)
											Edit Kelas Paralel
										@else
											Tambah Kelas Paralel
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
								@if (count($kelasparalel) > 0)
									<form action="{{ route('kelas-paralel-edit') }}" method="post">
										<input type="hidden" class="form-control" id="id" name="id" value="{{ count($kelasparalel) > 0 ? $kelasparalel[0]['id'] : '' }}" required="">
								@else
									<form action="{{ route('kelas-paralel-store') }}" method="post">
								@endif
									@csrf

									<div class="form-group row">
										<!-- Kelas (ComboBox) -->
										<div class="col-md-12">
											<label class="text-body">Kelas</label>
											<fieldset class="form-group mb-3">
												<select class="form-control select2" id="kelas_id" name="kelas_id" required="">
													<option value="">Pilih Kelas</option>
													@foreach ($kelas as $k)
														<option value="{{ $k->id }}" {{ (count($kelasparalel) > 0 && $kelasparalel[0]['kelas_id'] == $k->id) ? 'selected' : '' }}>
															{{ $k->NamaKelas }}
														</option>
													@endforeach
												</select>
											</fieldset>
										</div>

										<!-- Nama Kelas Paralel -->
										<div class="col-md-12">
											<label class="text-body">Nama Kelas Paralel</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" id="NamaKelasParalel" name="NamaKelasParalel" placeholder="Nama Kelas Paralel" value="{{ count($kelasparalel) > 0 ? $kelasparalel[0]['NamaKelasParalel'] : '' }}" required="">
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
	$(document).ready(function() {
		$('.select2').select2({
			placeholder: 'Pilih Kelas',
			allowClear: true
		});
	});
</script>
@endpush
