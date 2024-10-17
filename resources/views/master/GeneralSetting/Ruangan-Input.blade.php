@extends('parts.header')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{ route('ruangan') }}">Ruangan</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Ruangan</li>
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
										@if (count($ruangan) > 0)
											Edit Ruangan
										@else
											Tambah Ruangan
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
								@if (count($ruangan) > 0)
									<form action="{{ route('ruangan-edit') }}" method="post">
										<input type="hidden" class="form-control" id="id" name="id" value="{{ count($ruangan) > 0 ? $ruangan[0]['id'] : '' }}" required="">
								@else
									<form action="{{ route('ruangan-store') }}" method="post">
								@endif
									@csrf

									<div class="form-group row">
										<!-- Nama Ruangan -->
										<div class="col-md-12">
											<label class="text-body">Nama Ruangan</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" id="NamaRuangan" name="NamaRuangan" placeholder="Nama Ruangan" value="{{ count($ruangan) > 0 ? $ruangan[0]['NamaRuangan'] : '' }}" required="">
											</fieldset>
										</div>

										<!-- Penanggung Jawab -->
										<div class="col-md-12">
											<label class="text-body">Penanggung Jawab</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" id="PenanggungJawab" name="PenanggungJawab" placeholder="Penanggung Jawab" value="{{ count($ruangan) > 0 ? $ruangan[0]['PenanggungJawab'] : '' }}" required="">
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
