@extends('parts.header')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Absensi</li>
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
                                    <h3 class="card-label mb-0 font-weight-bold text-body">Data Absensi</h3>
                                </div>
                                <!-- <div class="icons d-flex">
                                    <a href="{{ url('guru/form/-') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Tambah Data</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>

                <!--begin::Table-->
                <div class="row">
                    <div class="col-12 px-4">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-body">
                                <!-- <button id="uploadButton" class="btn btn-success text-white font-weight-bold mb-3">Upload Ke Mesin</button> -->
                                                               
                                <div class="table-responsive" id="printableTable">
                                    <table id="orderTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="checkAll">
                                                </th>
                                                <th>NISN</th>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                                <th>Pin Absensi</th>
                                                <th>Absen Masuk</th>
                                                <th>Absen Keluar</th>
                                                <th class="no-sort text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($absensi) > 0)
                                                @foreach($absensi as $data)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="absensiCheckbox" value="{{ $data->NISN }}">
                                                    </td>
                                                    <td>{{ $data->NISN }}</td>
                                                    <td>{{ $data->NIK }}</td>
                                                    <td>{{ $data->NamaSiswa }}</td>
                                                    <td>{{ $data->PINAbsensi }}</td>
                                                    <td>{{ $data->Scan_IN }}</td>
                                                    <td>{{ $data->Scan_OUT }}</td>
                                                    
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
        jQuery('#orderTable').DataTable({
            "pagingType": "simple_numbers",
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            }]
        });

        // Check/uncheck all checkboxes
        jQuery('#checkAll').on('change', function() {
            jQuery('.absensiCheckbox').prop('checked', this.checked);
        });

        // // Handle Upload Ke Mesin button click
        // jQuery('#uploadButton').on('click', function() {
        //     let selectedNIKs = [];
        //     jQuery('.absensiCheckbox:checked').each(function() {
        //         selectedNIKs.push(jQuery(this).val());
        //     });
            
        //     if (selectedNIKs.length > 0) {
        //         // Here, you can perform your upload logic with selectedNISNs
        //         console.log('Selected NIKs:', selectedNIKs);
        //         // Make an AJAX request or perform any action you need
        //     } else {
        //         alert('Please select at least one Absensi to upload.');
        //     }
        // });

       


    });
</script>
@endpush
