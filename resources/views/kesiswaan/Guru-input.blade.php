@extends('parts.header')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('guru') }}">Guru</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Input Guru</li>
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
                                        @if (count($guru) > 0)
                                            Edit Guru
                                        @else
                                            Tambah Guru
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
                                <form action="{{ count($guru) > 0 ? route('guru-edit') : route('guru-store') }}" method="post" enctype="multipart/form-data" onsubmit="return konfirmasiSubmit()">
                                    @csrf

                                    <div class="form-group row">
                                       
                                       
                                        <!-- NIK -->
                                        <div class="col-md-4">
                                            <label class="text-body">NIK</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="NIK" name="NIK" placeholder="NIK" value="{{ count($guru) > 0 ? $guru[0]['NIK'] : '' }}" required>
                                            </fieldset>
                                        </div>
                                       
                                        <!-- Nama Guru -->
                                        <div class="col-md-6">
                                            <label class="text-body">Nama Guru</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="NamaGuru" name="NamaGuru" placeholder="Nama Guru" value="{{ count($guru) > 0 ? $guru[0]['NamaGuru'] : '' }}" required>
                                            </fieldset>
                                        </div>

                                                                               
                                        <!-- Email -->
                                        <div class="col-md-6">
                                            <label class="text-body">Email</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="mail" class="form-control" id="Email" name="Email" placeholder="test@gmail.com" value="{{ count($guru) > 0 ? $guru[0]['Email'] : '' }}" required>
                                            </fieldset>
                                        </div>

                                        <!-- NoHP -->
                                        <div class="col-md-6">
                                            <label class="text-body">Nomor Ponsel Guru</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="number" class="form-control" id="NoHP" name="NoHP" placeholder="6281325058258" value="{{ count($guru) > 0 ? $guru[0]['NoHP'] : '' }}" required>
                                            </fieldset>
                                        </div>

                                         <!-- Kelas  -->
                                       
                                        <div class="col-md-4">
                                            <label class="text-body">Kelas</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="KelasID" name="KelasID">
                                                    <option value="">Pilih Kelas</option>
                                                      @foreach ($kelas as $th)
                <option value="{{ $th->id }}" {{ (isset($guru[0]) && $guru[0]['KelasID'] == $th->id) ? 'selected' : '' }}>
                    {{ $th->NamaKelas }}
                </option>
            @endforeach
                                                </select>
                                            </fieldset>
                                        </div>

                                       <!-- mata Pelajaran -->
                                        <div class="col-md-4">
                                            <label class="text-body">Mata Pelajaran</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="MapelID" name="MapelID">
                                                    <option value="">Pilih Mata pelajaran</option>
                                                    @foreach ($mapel as $th)
                <option value="{{ $th->id }}" {{ (isset($guru[0]) && $guru[0]['MapelID'] == $th->id) ? 'selected' : '' }}>
                    {{ $th->NamaMataPelajaran }}
                </option>
            @endforeach
                                                </select>
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

jQuery(function () {
    var oKelas;
    var oMapel;
    jQuery(document).ready(function() {
        jQuery('.select2').select2();
        oKelas = <?php echo $kelas ?>;
        oMapel = <?php echo $mapel ?>;

        // Preview uploaded image
        function previewImage(event) {
            var output = document.getElementById('imagePreview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = 'block';
        }
    });

   



</script>

<script>
                    function konfirmasiSubmit(){
                        var r = confirm('Lanjutkan penyimpanan data ?');

                        if(r){
                            return true;
                        }else{
                            return false;
                        }
                    }
                </script>

@endpush
