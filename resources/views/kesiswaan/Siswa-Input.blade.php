@extends('parts.header')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('siswa') }}">Siswa</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Input Siswa</li>
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
                                        @if (count($siswa) > 0)
                                            Edit Siswa
                                        @else
                                            Tambah Siswa
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
                                <form action="{{ count($siswa) > 0 ? route('siswa-edit') : route('siswa-store') }}" method="post" enctype="multipart/form-data" onsubmit="return konfirmasiSubmit()">
                                    @csrf

                                    <div class="form-group row">
                                        <!-- Foto -->
                                        <center>
                                            <div class="col-md-4">
                                                <label class="text-body">Foto</label>
                                                <small>Click or Drop Images in the Box for Upload.</small>
                                                <fieldset class="form-group mb-3">
    <div class="avatar-upload mb-3">
        <div class="avatar-edit">
            <input type="file" id="imageUpload" name="Foto" accept=".png, .jpg, .jpeg" onchange="loadFile(event)" />
            <label for="imageUpload">image upload</label>
        </div>
        <div class="avatar-preview">
            <div id="imagePreview" class="rounded" style="background-image: url({{ count($siswa) > 0 ? asset('storage/uploads/siswa/' . $siswa[0]['Foto']) : './assets/images/carousel/slide3.jpg' }});"></div>
        </div>
    </div>
    <!-- <img id="imagePreviewImg" src="{{ count($siswa) > 0 ? asset('storage/app/public/uploads/siswa/' . $siswa[0]['Foto']) : '' }}" class="mt-3" style="max-width: 200px; display: {{ count($siswa) > 0 ? 'block' : 'none' }};"> -->
</fieldset>
                                            </div>
                                        </center>

                                        <!-- NISN -->
                                        <div class="col-md-4">
                                            <label class="text-body">NISN</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="NISN" name="NISN" placeholder="NISN" value="{{ count($siswa) > 0 ? $siswa[0]['NISN'] : '' }}" {{ count($siswa) > 0 ? 'readonly' : '' }} required>
                                            </fieldset>
                                        </div>

                                        <!-- NIK -->
                                        <div class="col-md-4">
                                            <label class="text-body">NIK</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="NIK" name="NIK" placeholder="NIK" value="{{ count($siswa) > 0 ? $siswa[0]['NIK'] : '' }}" required>
                                            </fieldset>
                                        </div>

                                        <!-- PINAbsensi -->
                                        <div class="col-md-4">
                                            <label class="text-body">PIN Absensi</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="number" class="form-control" id="PINAbsensi" name="PINAbsensi" placeholder="PIN Absensi" value="{{ count($siswa) > 0 ? $siswa[0]['PINAbsensi'] : '' }}" {{ count($siswa) > 0 ? 'readonly' : '' }} required>
                                            </fieldset>
                                        </div>

                                        <!-- NamaSiswa -->
                                        <div class="col-md-6">
                                            <label class="text-body">Nama Siswa</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="NamaSiswa" name="NamaSiswa" placeholder="Nama Siswa" value="{{ count($siswa) > 0 ? $siswa[0]['NamaSiswa'] : '' }}" required>
                                            </fieldset>
                                        </div>

                                        <!-- JenisKelamin -->
                                        <div class="col-md-6">
                                            <label class="text-body">Jenis Kelamin</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="JenisKelamin" name="JenisKelamin" required>
                                                    <option value="L" {{ count($siswa) > 0 && $siswa[0]['JenisKelamin'] == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                                    <option value="P" {{ count($siswa) > 0 && $siswa[0]['JenisKelamin'] == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <!-- TempatLahir -->
                                        <div class="col-md-6">
                                            <label class="text-body">Tempat Lahir</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="TempatLahir" name="TempatLahir" placeholder="Tempat Lahir" value="{{ count($siswa) > 0 ? $siswa[0]['TempatLahir'] : '' }}" required>
                                            </fieldset>
                                        </div>

                                        <!-- TanggalLahir -->
                                        <div class="col-md-6">
                                            <label class="text-body">Tanggal Lahir</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="date" class="form-control" id="TanggalLahir" name="TanggalLahir" value="{{ count($siswa) > 0 ? $siswa[0]['TanggalLahir'] : '' }}" required>
                                            </fieldset>
                                        </div>
                                        
                                        <!-- Email -->
                                        <div class="col-md-6">
                                            <label class="text-body">Email</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="mail" class="form-control" id="Email" name="Email" placeholder="test@gmail.com" value="{{ count($siswa) > 0 ? $siswa[0]['Email'] : '' }}" required>
                                            </fieldset>
                                        </div>

                                        <!-- NoHP -->
                                        <div class="col-md-6">
                                            <label class="text-body">Nomor Ponsel Siswa</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="number" class="form-control" id="NoHP" name="NoHP" placeholder="6281325058258" value="{{ count($siswa) > 0 ? $siswa[0]['NoHP'] : '' }}" required>
                                            </fieldset>
                                        </div>
                                        <!-- ProvID, KotaID, KecID, KelID, KelasID, KelasParalelID, TahunAjaran -->
                                        <!-- Replace these with select elements using select2.js similar to JenisKelamin -->
                                        <!-- Provinsi -->
                                        <div class="col-md-3">
                                        <label class="text-body">Provinsi</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="ProvID" name="ProvID">
                                                @foreach ($provinsi as $prov)
                <option value="{{ $prov->prov_id }}" {{ (isset($siswa[0]) && $siswa[0]['ProvID'] == $prov->prov_id) ? 'selected' : '' }}>
                    {{ $prov->prov_name }}
                </option>
            @endforeach
                                                </select>
                                            </fieldset>
                                            </div>




                                        <!-- Kota -->
                                        <div class="col-md-3">
                                            <label class="text-body">Kota</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="KotaID" name="KotaID">
                                                    <option value="">Select Kota</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <!-- Kecamatan -->
                                        <div class="col-md-3">
                                            <label class="text-body">Kecamatan</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="KecID" name="KecID">
                                                    <option value="">Select Kecamatan</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <!-- Kelurahan -->
                                        <div class="col-md-3">
                                            <label class="text-body">Kelurahan</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="KelID" name="KelID">
                                                    <option value="">Select Kelurahan</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <!-- AlamatSiswa -->
                                        <div class="col-md-12">
                                            <label class="text-body">Alamat Siswa</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="AlamatSiswa" name="AlamatSiswa" placeholder="Alamat Siswa" value="{{ count($siswa) > 0 ? $siswa[0]['AlamatSiswa'] : '' }}" required>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="text-body">Tahun Ajaran</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="tahunajaran" name="tahunajaran">
                                                    <option value="">Select Tahun Ajaran</option>
                                                    @foreach ($tahunajaran as $th)
                <option value="{{ $th->id }}" {{ (isset($siswa[0]) && $siswa[0]['tahunajaran'] == $th->id) ? 'selected' : '' }}>
                    {{ $th->NamaTahunAjaran }}
                </option>
            @endforeach
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="text-body">Kelas</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="KelasID" name="KelasID">
                                                    <option value="">Select Kelas</option>
                                                      @foreach ($kelas as $th)
                <option value="{{ $th->id }}" {{ (isset($siswa[0]) && $siswa[0]['KelasID'] == $th->id) ? 'selected' : '' }}>
                    {{ $th->NamaKelas }}
                </option>
            @endforeach
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="text-body">Kelas Paralel</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="KelasParalelID" name="KelasParalelID">
                                                    <option value="">Select Kelas Paralel</option>
                                                    <!-- @foreach ($kelasParalel as $th)
                <option value="{{ $th->id }}" {{ (isset($siswa[0]) && $siswa[0]['KelasParalelID'] == $th->id) ? 'selected' : '' }}>
                    {{ $th->NamaKelasParalel }}
                </option>
            @endforeach -->
                                                </select>
                                            </fieldset>
                                        </div>

                                        <hr>
                                        <h3 class="card-label mb-0 font-weight-bold text-body"> Wali Siswa </h3>
                                        <hr>

                                        <!-- Nama Wali -->
                                        <div class="col-md-12">
                                            <label class="text-body">Nama Wali</label>
                                            <fieldset class="form-group mb-3">
                                                <input type="text" class="form-control" id="NamaWali" name="NamaWali" placeholder="Nama Wali" value="{{ count($siswa) > 0 ? $siswa[0]['NamaWali'] : '' }}" required>
                                            </fieldset>
                                        </div>
                                        

                                        <div class="col-md-6">
                                            <label class="text-body">Hubungan Wali</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="HubunganWali" name="HubunganWali" required>
                                                    <!-- <option value="Orang Tua">Orang Tua</option>
                                                    <option value="Saudara">Saudara</option>
                                                    <option value="Lain Lain">Lain Lain</option> -->
                    <option value="Orang Tua" {{  (isset($siswa[0]) && $siswa[0]['HubunganWali'] === 'Orang Tua' )  ? 'selected' : '' }}>Orang Tua</option>
                    <option value="Saudara" {{ (isset($siswa[0]) && $siswa[0]['HubunganWali'] === 'Saudara' )  ? 'selected' : '' }}>Saudara</option>
                    <option value="Lain Lain" {{ (isset($siswa[0]) && $siswa[0]['HubunganWali'] === 'Lain Lain' ) }}>Lain Lain</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="text-body">Nomor Ponsel Wali</label>
                                            <fieldset class="form-group mb-3">
                                            <input type="number" class="form-control" id="NoTlpWali" name="NoTlpWali" placeholder="6281325058258" value="{{ count($siswa) > 0 ? $siswa[0]['NoTlpWali'] : '' }}" required>
                                            </fieldset>
                                        </div>

                                        <!-- Wali Provinsi -->
                                        <div class="col-md-3">
                                            <label class="text-body">Provinsi</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="WaliProvID" name="WaliProvID" required>
                                                    <option value="">Pilih Provinsi</option>
                                                    @foreach ($provinsi as $prov)
                <option value="{{ $prov->prov_id }}" {{ (isset($siswa[0]) && $siswa[0]['WaliProvID'] == $prov->prov_id) ? 'selected' : '' }}>
                    {{ $prov->prov_name }}
                </option>
            @endforeach
                                                </select>
                                            </fieldset>
                                        </div>

                                        <!-- Wali Kota -->
                                        <div class="col-md-3">
                                            <label class="text-body">Kota</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="WaliKotaID" name="WaliKotaID" required>
                                                    <option value="">Pilih Kota</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <!-- Wali Kecamatan -->
                                        <div class="col-md-3">
                                            <label class="text-body">Kecamatan</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="WaliKecID" name="WaliKecID" required>
                                                    <option value="">Pilih Kecamatan</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <!-- Wali Kelurahan -->
                                        <div class="col-md-3">
                                            <label class="text-body">Kelurahan</label>
                                            <fieldset class="form-group mb-3">
                                                <select class="form-control select2" id="WaliKelID" name="WaliKelID" required>
                                                    <option value="">Pilih Kelurahan</option>
                                                </select>
                                            </fieldset>
                                        </div>

                                        <!-- Alamat Wali -->
                                        <div class="col-md-12">
                                            <label class="text-body">Alamat Wali</label>
                                            <fieldset class="form-group mb-3">
                                            <input type="text" class="form-control" id="AlamatWali" name="AlamatWali" placeholder="Alamat Wali" value="{{ count($siswa) > 0 ? $siswa[0]['AlamatWali'] : '' }}" required>
                                            </fieldset>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-6">
                                            <label class="text-body">Status</label>
                                            <fieldset class="form-group mb-3">
                                            <input type="hidden" name="Status" value="0">
                                            <input type="checkbox" id="Status" name="Status" value="1" {{ count($siswa) > 0 && $siswa[0]['Status'] == '1' ? 'checked' : '' }}>
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
    var oKelasParalel;
    jQuery(document).ready(function() {
        jQuery('.select2').select2();
        oKelas = <?php echo $kelas ?>;
        oKelasParalel = <?php echo $kelasParalel ?>;

        // Preview uploaded image
        function previewImage(event) {
            var output = document.getElementById('imagePreview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = 'block';
        }
    });

    //Read edit Condition For Lokasi
//------------------------------------------------------------------------------------------------------------------------

    jQuery(document).ready(function() {
    // Ambil data dari database untuk kondisi edit
    var selectedProvID = "{{ isset($siswa[0]) ? $siswa[0]['ProvID'] : '' }}";
    var selectedKotaID = "{{ isset($siswa[0]) ? $siswa[0]['KotaID'] : '' }}";
    var selectedKecID = "{{ isset($siswa[0]) ? $siswa[0]['KecID'] : '' }}";
    var selectedKelID = "{{ isset($siswa[0]) ? $siswa[0]['KelID'] : '' }}";

    
           // Jika ada Provinsi yang dipilih, ambil daftar Kota
    if (selectedProvID) {
        jQuery.ajax({
            url: '{{ url("get-kota") }}/' + selectedProvID,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                jQuery('#KotaID').empty().append('<option value="">Select Kota</option>');
                jQuery.each(data, function(key, value) {
                    var selected = (value.city_id == selectedKotaID) ? 'selected' : '';
                    jQuery('#KotaID').append('<option value="'+ value.city_id +'" '+ selected +'>'+ value.city_name +'</option>');
                });
            }
        });
      
    }
   
    // Mengambil kota berdasarkan provinsi yang dipilih saat ini
    jQuery('#ProvID').change(function() {
        var provID = jQuery(this).val();
        if (provID) {
            jQuery.ajax({
                url: '{{ url("get-kota") }}/' + provID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    jQuery('#KotaID').empty().append('<option value="">Select Kota</option>');
                    jQuery.each(data, function(key, value) {
                        jQuery('#KotaID').append('<option value="'+ value.city_id +'">'+ value.city_name +'</option>');
                    });
                }
            });
        }
    });

    if (selectedKotaID) {
        jQuery.ajax({
            url: '{{ url("get-kecamatan") }}/' + selectedKotaID,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                jQuery('#KecID').empty().append('<option value="">Select Kecamatan</option>');
                jQuery.each(data, function(key, value) {
                    var selected = (value.dis_id == selectedKecID) ? 'selected' : '';
                    jQuery('#KecID').append('<option value="'+ value.dis_id +'" '+ selected +'>'+ value.dis_name +'</option>');
                });
            }
        });

       
    }

    // jQuery('#KotaID').change(function() {
    //     var kotaID = jQuery(this).val();
    //     if (kotaID) {
    //         jQuery.ajax({
    //             url: '{{ url("get-kota") }}/' + kotaID,
    //             type: 'GET',
    //             dataType: 'json',
    //             success: function(data) {
    //                 jQuery('#KecID').empty().append('<option value="">Select Kecamatan</option>');
    //                 jQuery.each(data, function(key, value) {
    //                     jQuery('#KecID').append('<option value="'+ value.dis_id +'">'+ value.dis_name +'</option>');
    //                 });
    //             }
    //         });
    //     }
    // });

    if (selectedKecID) {
        jQuery.ajax({
            url: '{{ url("get-kelurahan") }}/' + selectedKecID,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                jQuery('#KelID').empty().append('<option value="">Select Kelurahan</option>');
                jQuery.each(data, function(key, value) {
                    var selected = (value.subdis_id == selectedKelID) ? 'selected' : '';
                    jQuery('#KelID').append('<option value="'+ value.subdis_id +'" '+ selected +'>'+ value.subdis_name +'</option>');
                });
            }
        });

       
    }

    jQuery('#KecID').change(function() {
        var kecID = jQuery(this).val();
        if (kecID) {
            jQuery.ajax({
                url: '{{ url("get-kelurahan") }}/' + kecID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    jQuery('#KelID').empty().append('<option value="">Select Kelurahan</option>');
                    jQuery.each(data, function(key, value) {
                        jQuery('#KelID').append('<option value="'+ value.subdis_id +'">'+ value.subdis_name +'</option>');
                    });
                }
            });
        }
    });


});

//------------------------------------------------------------------------------------------------------------------------

    // Load Kecamatan based on Kota selection
    jQuery('#KotaID').change(function() {
        var kotaID = jQuery(this).val();
        if (kotaID) {
            jQuery.ajax({
                url: '{{ url("get-kecamatan") }}/' + kotaID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    jQuery('#KecID').empty().append('<option value="">Select Kecamatan</option>');
                    jQuery.each(data, function(key, value) {
                        jQuery('#KecID').append('<option value="'+ value.dis_id +'">'+ value.dis_name +'</option>');
                    });
                }
            });
        }
    });

    // // Load Kelurahan based on Kecamatan selection
    // jQuery('#KecID').change(function() {
    //     var kecID = jQuery(this).val();
    //     if (kecID) {
    //         jQuery.ajax({
    //             url: '{{ url("get-kelurahan") }}/' + kecID,
    //             type: 'GET',
    //             dataType: 'json',
    //             success: function(data) {
    //                 jQuery('#KelID').empty().append('<option value="">Select Kelurahan</option>');
    //                 jQuery.each(data, function(key, value) {
    //                     jQuery('#KelID').append('<option value="'+ value.subdis_id +'">'+ value.subdis_name +'</option>');
    //                 });
    //             }
    //         });
    //     }
    // });

    // Filter Kota based on Provinsi
    // jQuery('#WaliProvID').on('change', function() {
    //     let prov_id = $(this).val();
    //     $.ajax({
    //         url: '{{ url("get-kota") }}/' + prov_id,
    //         method: 'GET',
    //         data: { prov_id: prov_id },
    //         success: function(data) {
    //             jQuery('#WaliKotaID').empty().append('<option value="">Pilih Kota</option>');
    //             jQuery.each(data, function(key, value) {
    //                 jQuery('#WaliKotaID').append('<option value="'+ value.city_id +'">'+ value.city_name +'</option>');
    //             });
    //         }
    //     });
    // });

   

     //Read edit Condition For Lokasi Wali
//------------------------------------------------------------------------------------------------------------------------

jQuery(document).ready(function() {
    // Ambil data dari database untuk kondisi edit
    var selectedWaliProvID = "{{ isset($siswa[0]) ? $siswa[0]['WaliProvID'] : '' }}";
    var selectedWaliKotaID = "{{ isset($siswa[0]) ? $siswa[0]['WaliKotaID'] : '' }}";
    var selectedWaliKecID = "{{ isset($siswa[0]) ? $siswa[0]['WaliKecID'] : '' }}";
    var selectedWaliKelID = "{{ isset($siswa[0]) ? $siswa[0]['WaliKelID'] : '' }}";


   

        // Jika ada Provinsi yang dipilih, ambil daftar Kota
    if (selectedWaliProvID) {
        jQuery.ajax({
            url: '{{ url("get-kota") }}/' + selectedWaliProvID,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                jQuery('#WaliKotaID').empty().append('<option value="">Select Kota</option>');
                jQuery.each(data, function(key, value) {
                    var selected = (value.city_id == selectedWaliKotaID) ? 'selected' : '';
                    jQuery('#WaliKotaID').append('<option value="'+ value.city_id +'" '+ selected +'>'+ value.city_name +'</option>');
                });
            }
        });

       
    }
   
    // Mengambil kota berdasarkan provinsi yang dipilih saat ini
    jQuery('#WaliProvID').change(function() {
        var waliProvID = jQuery(this).val();
        if (waliProvID) {
            jQuery.ajax({
                url: '{{ url("get-kota") }}/' + waliProvID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    jQuery('#WaliKotaID').empty().append('<option value="">Select Kota</option>');
                    jQuery.each(data, function(key, value) {
                        jQuery('#WaliKotaID').append('<option value="'+ value.city_id +'">'+ value.city_name +'</option>');
                    });
                }
            });
        }
    });

    if (selectedWaliKotaID) {
        jQuery.ajax({
            url: '{{ url("get-kecamatan") }}/' + selectedWaliKotaID,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                jQuery('#WaliKecID').empty().append('<option value="">Select Kecamatan</option>');
                jQuery.each(data, function(key, value) {
                    var selected = (value.dis_id == selectedWaliKecID) ? 'selected' : '';
                    jQuery('#WaliKecID').append('<option value="'+ value.dis_id +'" '+ selected +'>'+ value.dis_name +'</option>');
                });
            }
        });

       
    }

    jQuery('#WaliKotaID').change(function() {
        var waliKotaID = jQuery(this).val();
        if (waliKotaID) {
            jQuery.ajax({
                url: '{{ url("get-kecamatan") }}/' + waliKotaID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    jQuery('#WaliKecID').empty().append('<option value="">Select Kecamatan</option>');
                    jQuery.each(data, function(key, value) {
                        jQuery('#WaliKecID').append('<option value="'+ value.dis_id +'">'+ value.dis_name +'</option>');
                    });
                }
            });
        }
    });

    if (selectedWaliKecID) {
        jQuery.ajax({
            url: '{{ url("get-kelurahan") }}/' + selectedWaliKecID,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                jQuery('#WaliKelID').empty().append('<option value="">Select Kelurahan</option>');
                jQuery.each(data, function(key, value) {
                    var selected = (value.subdis_id == selectedWaliKelID) ? 'selected' : '';
                    jQuery('#WaliKelID').append('<option value="'+ value.subdis_id +'" '+ selected +'>'+ value.subdis_name +'</option>');
                });
            }
        });

       
    }

    jQuery('#WaliKecID').change(function() {
        var waliKecID = jQuery(this).val();
        if (waliKecID) {
            jQuery.ajax({
                url: '{{ url("get-kelurahan") }}/' + waliKecID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    jQuery('#WaliKelID').empty().append('<option value="">Select Kelurahan</option>');
                    jQuery.each(data, function(key, value) {
                        jQuery('#WaliKelID').append('<option value="'+ value.subdis_id +'">'+ value.subdis_name +'</option>');
                    });
                }
            });
        }
    });


});

//------------------------------------------------------------------------------------------------------------------------

 // Filter Kecamatan based on Kota
 jQuery('#WaliKotaID').on('change', function() {
        let kota_id = $(this).val();
        $.ajax({
            url: '{{ url("get-kecamatan") }}/' + kota_id,
            method: 'GET',
            data: { kota_id: kota_id },
            success: function(data) {
                jQuery('#WaliKecID').empty().append('<option value="">Pilih Kecamatan</option>');
                jQuery.each(data, function(key, value) {
                    jQuery('#WaliKecID').append('<option value="'+ value.dis_id +'">'+ value.dis_name +'</option>');
                });
            }
        });
    });

     //Read edit Condition For kelas - kelas Paralel
//------------------------------------------------------------------------------------------------------------------------

jQuery(document).ready(function() {
    // Ambil data dari database untuk kondisi edit
    var selectedKelasID = "{{ isset($siswa[0]) ? $siswa[0]['KelasID'] : '' }}";
    var selectedKelasParalelID = "{{ isset($siswa[0]) ? $siswa[0]['KelasParalelID'] : '' }}";
   

        
    if (selectedKelasID) {
        jQuery.ajax({
            url: '{{ url("get-kelas-paralel") }}/' + selectedKelasID,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                jQuery('#KelasParalelID').empty().append('<option value="">Select Kelas Paralel</option>');
                jQuery.each(data, function(key, value) {
                    var selected = (value.id == selectedKelasParalelID) ? 'selected' : '';
                    jQuery('#KelasParalelID').append('<option value="'+ value.id +'" '+ selected +'>'+ value.NamaKelasParalel +'</option>');
                });
            }
        });

       
    }
   
   
    jQuery('#KelasID').change(function() {
        var kelasID = jQuery(this).val();
        if (kelasID) {
            jQuery.ajax({
                url: '{{ url("get-kelas-paralel") }}/' + kelasID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    jQuery('#KelasParalelID').empty().append('<option value="">Select Kelas Paralel</option>');
                    jQuery.each(data, function(key, value) {
                        jQuery('#KelasParalelID').append('<option value="'+ value.id +'">'+ value.NamaKelasParalel +'</option>');
                    });
                }
            });
        }
    });

});

//------------------------------------------------------------------------------------------------------------------------
   
});

var loadFile = function(event) {
    var output = document.getElementById('imagePreview');
    var previewImg = document.getElementById('imagePreviewImg');
    
    if (event.target.files && event.target.files[0]) {
        // Preview di div background image
        output.style.backgroundImage = "url(" + URL.createObjectURL(event.target.files[0]) + ")";
        
        // Jika menggunakan img tag, atur source-nya
        previewImg.src = URL.createObjectURL(event.target.files[0]);
        previewImg.style.display = "block";
        
        // Revoke object URL setelah digunakan
        previewImg.onload = function() {
            URL.revokeObjectURL(previewImg.src); // Free up memory
        }
    } else {
        // Jika tidak ada file yang dipilih, reset preview
        output.style.backgroundImage = "";
        previewImg.style.display = "none";
    }
};


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
