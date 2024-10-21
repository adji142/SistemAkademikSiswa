@extends('parts.header')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Guru</li>
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
                                    <h3 class="card-label mb-0 font-weight-bold text-body">Data Guru</h3>
                                </div>
                                <div class="icons d-flex">
                                    <a href="{{ url('guru/form/-') }}" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Tambah Data</a>
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
                                <button id="uploadButton" class="btn btn-success text-white font-weight-bold mb-3">Upload Ke Mesin</button>
                                                               
                                <div class="table-responsive" id="printableTable">
                                    <table id="orderTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="checkAll">
                                                </th>
                                                <th>NIK</th>
                                                <th>Nama Guru</th>
                                                <th>Email</th>
                                                <th>No HP</th>
                                                <th class="no-sort text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($guru) > 0)
                                                @foreach($guru as $data)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="guruCheckbox" value="{{ $data['NIK'] }}">
                                                    </td>
                                                    <td>{{ $data['NIK'] }}</td>
                                                    <td>{{ $data['NamaGuru'] }}</td>
                                                    <td>{{ $data['Email'] }}</td>
                                                    <td>{{ $data['NoHP'] }}</td>
                                                    <td>
                                                        <div class="card-toolbar text-end">
                                                            <button class="btn p-0 shadow-none" type="button" id="dropdowneditButton{{ $data['NIK'] }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="svg-icon">
                                                                    <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-three-dots text-body" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                                        <path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path>
                                                                    </svg>
                                                                </span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdowneditButton{{ $data['NIK'] }}">
                                                                <a class="dropdown-item" href="{{ url('guru/form/' . $data['NIK']) }}">Edit</a>
                                                                <a class="dropdown-item" title="Delete" href="{{ route('guru-delete', $data['NIK']) }}" data-confirm-delete="true">Delete</a>
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
        jQuery('#orderTable').DataTable({
            "pagingType": "simple_numbers",
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            }]
        });

        // Check/uncheck all checkboxes
        jQuery('#checkAll').on('change', function() {
            jQuery('.guruCheckbox').prop('checked', this.checked);
        });

        // Handle Upload Ke Mesin button click
        jQuery('#uploadButton').on('click', function() {
            let selectedNIKs = [];
            jQuery('.guruCheckbox:checked').each(function() {
                selectedNIKs.push(jQuery(this).val());
            });
            
            if (selectedNIKs.length > 0) {
                // Here, you can perform your upload logic with selectedNISNs
                console.log('Selected NIKs:', selectedNIKs);
                // Make an AJAX request or perform any action you need
            } else {
                alert('Please select at least one Guru to upload.');
            }
        });

       


    });
</script>
@endpush
