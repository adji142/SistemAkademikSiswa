@extends('parts.header')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Siswa</li>
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
                                    <h3 class="card-label mb-0 font-weight-bold text-body">Data Siswa</h3>
                                </div>
                                <div class="icons d-flex">
                                    <a href="{{ url('siswa/form/-') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Tambah Data</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--begin::Table-->
                <div class="row">
                    <div class="col-12 px-4">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-body">

                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                                    <!-- Tombol di kiri -->
                                    <div class="d-flex flex-wrap mb-2 mb-md-0">
                                        <button id="uploadButton" class="btn btn-success text-white font-weight-bold me-2">Upload Ke Mesin</button>
                                        <button id="naikKelasButton" class="btn btn-success text-white font-weight-bold">Naik Kelas</button>
                                    </div>
                                    
                                    <!-- Filter Dropdown di kanan -->
                                    <div class="d-flex flex-wrap">
                                        <select id="filterKelas" class="form-control w-auto me-2 mb-2 mb-md-0">
                                            <option value=""><- Filter Jenis Kelas -></option>
                                            @foreach ($kelas as $th)
                                                <option value="{{ $th->id }}">
                                                    {{ $th->NamaKelas }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <select id="filterKelasParalel" class="form-control w-auto">
                                            <option value=""><- Filter Kelas Paralel -></option>
                                            <!-- @foreach ($kelasParalel as $th)
                                                <option value="{{ $th->id }}">
                                                    {{ $th->NamaKelasParalel }}
                                                </option>
                                            @endforeach -->
                                        </select>
                                    </div>
                                </div>


                                <div class="table-responsive" id="printableTable">
                                    <table id="orderTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="checkAll">
                                                </th>
                                                <th>NISN</th>
                                                <th>NIK</th>
                                                <th>Pin</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>KelasParalel</th>
                                                <th>Tempat</th>
                                                <th>Tgl Lahir</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Email</th>
                                                <th>No Tlp</th>
                                                <th>Uploaded</th>
                                                <th class="no-sort text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($siswa) > 0)
                                                @foreach($siswa as $data)
                                                <tr>
                                                <td>
                                                    <input type="checkbox" class="siswaCheckbox" value="{{ $data->NISN }}">
                                                </td>
                                                <td>{{ $data->NISN }}</td>
                                                <td>{{ $data->NIK }}</td>
                                                <td>{{ $data->PINAbsensi }}</td>
                                                <td>{{ $data->NamaSiswa }}</td>
                                                <td>{{ $data->NamaKelas }}</td>
                                                <td>{{ $data->NamaKelasParalel }}</td>
                                                <td>{{ $data->TempatLahir }}</td>
                                                <td>{{ $data->TanggalLahir }}</td>
                                                <td>{{ $data->JenisKelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                                                <td>{{ $data->Email }}</td>
                                                <td>{{ $data->NoHP }}</td>
                                                <td>{{ $data->isUploaded }}</td>
                                                    <td>
                                                        <div class="card-toolbar text-end">
                                                            <button class="btn p-0 shadow-none" type="button" id="dropdowneditButton{{ $data->NISN }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="svg-icon">
                                                                    <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-three-dots text-body" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path>
                                                                    </svg>
                                                                </span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdowneditButton{{ $data->NISN }}">
                                                                <a class="dropdown-item" href="{{ url('siswa/form/' . $data->NISN) }}">Edit</a>
                                                                <a class="dropdown-item" title="Delete" href="{{ route('siswa-delete', $data->NISN) }}" data-confirm-delete="true">Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Table-->
            </div>
        </div>
    </div>
</div>
<!--end::Entry-->

@endsection

@push('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
        var table = jQuery('#orderTable').DataTable({
            "pagingType": "simple_numbers",
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            }],
            "createdRow": function(row, data, dataIndex) {
                // Disable the checkbox if the NISN is empty or another condition is met
                console.log(data[12]);
                if (data[12] == 1) {
                    jQuery(row).find('.siswaCheckbox').prop('disabled', true);
                }
                // You can add other conditions here if necessary
                // Example: if (data.status === 'inactive') { ... }
            }
        });

        $('#filterKelas').on('change', function() {

            var kelasID = jQuery(this).val();
        if (kelasID) {
            jQuery.ajax({
                url: '{{ url("get-kelas-paralel") }}/' + kelasID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    jQuery('#filterKelasParalel').empty().append('<option value="">Select Kelas Paralel</option>');
                    jQuery.each(data, function(key, value) {
                        jQuery('#filterKelasParalel').append('<option value="'+ value.id +'">'+ value.NamaKelasParalel +'</option>');
                    });
                }
            });
        }

            var selectedValue = $(this).val(); 
        var selectedText = $('#filterKelas option:selected').text().trim();  // Mendapatkan teks dari option yang dipilih
        console.log("5. Selected Kelas: " + selectedText);


       // Cek apakah selectedValue kosong atau tidak ada kelas yang dipilih
    if (selectedValue === "") {
        // Jika tidak ada kelas yang dipilih, tampilkan semua data
        table.column(5).search('').draw();  // Mengosongkan filter pencarian di kolom Kelas
    } else {
        // Jika ada kelas yang dipilih, lakukan pencarian berdasarkan teks kelas
        table.column(5).search(selectedText).draw();  // Sesuaikan dengan index kolom yang benar
    }
    });

    $('#filterKelasParalel').on('change', function() {
        var selectedValue = $(this).val(); 
        var selectedText = $('#filterKelasParalel option:selected').text().trim();  // Mendapatkan teks dari option yang dipilih
        console.log("6. Selected Kelas Paralel: " + selectedText);

        if (selectedValue === "") {
        // Jika tidak ada kelas yang dipilih, tampilkan semua data
        table.column(6).search('').draw();  // Mengosongkan filter pencarian di kolom Kelas
    } else {
        // Jika ada kelas yang dipilih, lakukan pencarian berdasarkan teks kelas
        table.column(6).search(selectedText).draw();  // Sesuaikan dengan index kolom yang benar
    }
    });

        // Check/uncheck all checkboxes
        jQuery('#checkAll').on('change', function() {
            var isChecked = this.checked; 
            jQuery('.siswaCheckbox:enabled').prop('checked', isChecked);
        });

        // Handle Upload Ke Mesin button click
        jQuery('#uploadButton').on('click', function() {
            let selectedNISNs = [];
            jQuery('.siswaCheckbox:checked').each(function() {
                selectedNISNs.push(jQuery(this).val());
            });
            
            if (selectedNISNs.length > 0) {
                // Here, you can perform your upload logic with selectedNISNs
                // console.log('Selected NISNs:', selectedNISNs);
                Swal.fire({
                    title: 'Loading...',
                    text: 'Please wait while the request is being processed',
                    allowOutsideClick: false, // Disable closing by clicking outside
                    didOpen: () => {
                        Swal.showLoading(); // Show loading spinner
                    }
                });

                $.ajax({
                    url: '{{ route("uploadsiswa") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        nisns: selectedNISNs
                    },
                    success: function (response) {
                        Swal.close();

                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'The request has been processed successfully.',
                            }).then((result)=>{
		                        location.reload();
		                    });;
                        }
                        else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Error ' + response.message,
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong. Please try again. ' + error,
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Please select at least one Siswa to upload.',
                });
                
            }
        });

      

     

        //naik Kelas -----------------------------------------------------------------------------------------
        var kelasData = @json($kelas);  // Data dari controller
        var kelasParalelData = @json($kelasParalel);
        $('#naikKelasButton').on('click', function() {
            let selectedNISNs = [];
            jQuery('.siswaCheckbox:checked').each(function() {
                selectedNISNs.push(jQuery(this).val());
            });
            
            if (selectedNISNs.length > 0) {
                
            let kelasOptions = '';
            let kelasParalelOptions = '';

    // Loop untuk membuat option HTML dari data kelas
        kelasData.forEach(function(kelas) {
            kelasOptions += `<option value="${kelas.id}">${kelas.NamaKelas}</option>`;
        });

        kelasParalelData.forEach(function(kelas) {
            kelasParalelOptions += `<option value="${kelas.id}">${kelas.NamaKelasParalel}</option>`;
        });


        Swal.fire({
            title: 'Naik Kelas',
            html: `
                <form id="naikKelasForm">
                    <div class="form-group">
                        <label for="jenisKelas">Kelas</label>
                        <select class="form-control" id="jenisKelas" name="jenisKelas">
                            <option value="">Pilih Jenis Kelas</option>
                            ${kelasOptions}  <!-- Dropdown diisi dari data kelas -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="paralelKelas">Kelas Paralel</label>
                        <select class="form-control" id="paralelKelas" name="paralelKelas">
                            <option value="">Pilih Kelas Paralel</option>
                             ${kelasParalelOptions}
                        </select>
                    </div>
                </form>
            `,
        showCancelButton: true,
        confirmButtonText: 'Proses',
        cancelButtonText: 'Batal',
        preConfirm: () => {
            return {
                jenisKelas: $('#jenisKelas').val(),
                paralelKelas: $('#paralelKelas').val()
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim data via AJAX
            $.ajax({
                    url: '{{ route("update-kelas-siswa") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        nisns: selectedNISNs,
                        jenisKelas: result.value.jenisKelas,
                        paralelKelas: result.value.paralelKelas
                    },
                    success: function(response) {
                        Swal.fire('Sukses', response.message, 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON.message, 'error');
                    }
                });
        }
    });
} else {
                alert('Please select at least one Siswa .');
            }
});


    });
</script>
@endpush
