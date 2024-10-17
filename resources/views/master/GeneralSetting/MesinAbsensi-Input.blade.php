@extends('parts.header')
	
@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('mesinabsensi')}}">Mesin Absensi</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Mesin Absensi</li>
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
						<div class="card card-custom gutter-b bg-transparent shadow-none border-0" >
							<div class="card-header align-items-center  border-bottom-dark px-0">
								<div class="card-title mb-0">
									<h3 class="card-label mb-0 font-weight-bold text-body">
										@if (count($mesinabsensi) > 0)
                                    		Edit Mesin Absensi
	                                	@else
	                                    	Tambah Mesin Absensi
	                                	@endif
									</h3>
								</div>
							</div>
						
						</div>


					</div>
				</div>

				<div class="row">
					<div class="col-12  px-4">
						<div class="card card-custom gutter-b bg-white border-0" >
							<div class="card-body" >
								@if (count($mesinabsensi) > 0)
                            		<form action="{{route('mesinabsensi-edit')}}" method="post">
                                    <input type="hidden" class="form-control" id="id" name="id" placeholder="Nama Mesin" value="{{ count($mesinabsensi) > 0 ? $mesinabsensi[0]['id'] : '' }}" required="" >
                            	@else
                                	<form action="{{route('mesinabsensi-store')}}" method="post">
                            	@endif
                            		@csrf
	                            	<div class="form-group row">
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Nama Mesin</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="NamaMesin" name="NamaMesin" placeholder="Nama Mesin" value="{{ count($mesinabsensi) > 0 ? $mesinabsensi[0]['NamaMesin'] : '' }}" required="" >
	                            			</fieldset>
	                            			
	                            		</div>
	                            		
	                            		<div class="col-md-12">
	                            			<label  class="text-body">Serial Number</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="SerialNumber" name="SerialNumber" placeholder="Masukan Serial Number" value="{{ count($mesinabsensi) > 0 ? $mesinabsensi[0]['SerialNumber'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-4">
	                            			<label  class="text-body">Activation Code</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="ActivationCode" name="ActivationCode" placeholder="Masukan Activation Code" value="{{ count($mesinabsensi) > 0 ? $mesinabsensi[0]['ActivationCode'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-4">
	                            			<label  class="text-body">API Token</label>
	                            			<fieldset class="form-group mb-4">
	                            				<input type="text" class="form-control" id="APIToken" name="APIToken" placeholder="Masukan API Token" value="{{ count($mesinabsensi) > 0 ? $mesinabsensi[0]['APIToken'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

	                            		<div class="col-md-4">
	                            			<label  class="text-body">Cloud Key</label>
	                            			<fieldset class="form-group mb-3">
	                            				<input type="text" class="form-control" id="CloudKey" name="CloudKey" placeholder="Masukan Cloud Key" value="{{ count($mesinabsensi) > 0 ? $mesinabsensi[0]['CloudKey'] : '' }}" required="">
	                            			</fieldset>
	                            			
	                            		</div>

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
	
</script>
@endpush