@extends('parts.header')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('mapel')}}">Mata Pelajaran</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Mata Pelajaran</li>
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
										@if (count($mapel) > 0)
											Edit Mata Pelajaran
										@else
											Tambah Mata Pelajaran
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
								@if (count($mapel) > 0)
									<form action="{{route('mapel-edit')}}" method="post">
										<input type="hidden" class="form-control" id="id" name="id" value="{{ count($mapel) > 0 ? $mapel[0]['id'] : '' }}" required="">
								@else
									<form action="{{route('mapel-store')}}" method="post">
								@endif
									@csrf

									<div class="form-group row">
										<!-- Nama mapel -->
										<div class="col-md-12">
											<label class="text-body">Nama Mata Pelajaran</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" id="NamaMataPelajaran" name="NamaMataPelajaran" placeholder="Nama Mata Pelajaran" value="{{ count($mapel) > 0 ? $mapel[0]['NamaMataPelajaran'] : '' }}" required="">
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
