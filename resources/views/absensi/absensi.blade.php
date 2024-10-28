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

                <div class="row">
                    <div class="col-12 px-4">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-header" >
								Filter Data
							</div>
                            <div class="card-body">
                                <form action="{{ route('absensi') }}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label  class="text-body">Tanggal Awal</label>
                                            <input type="date" name="TglAwal" id="TglAwal" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label  class="text-body">Tanggal Akhir</label>
                                            <input type="date" name="TglAkhir" id="TglAkhir" class="form-control">
                                        </div>
                                        
                                        <div class="col-md-3">
											<label  class="text-body">Kelas</label>
											<select name="KelasID" id="KelasID" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="">Pilih Kelas</option>
												@foreach($kelas as $ko)
													<option value="{{ $ko->id }}" {{ $ko->id == $oldKelasID ? 'selected' : '' }}>
			                                            {{ $ko->NamaKelas }}
			                                        </option>
												@endforeach
												
											</select>
										</div>

                                        <div class="col-md-3">
											<label  class="text-body">Kelas Paralel</label>
											<select name="KelasParalelID" id="KelasParalelID" class="js-example-basic-single js-states form-control bg-transparent" >
												<option value="">Pilih Kelas Paralel</option>
												
											</select>
										</div>

                                        <div class="col-md-3">
                                            <br>
                                            <button type="submit" class="btn btn-outline-primary rounded-pill font-weight-bold me-1 mb-1">Cari Data</button>
                                        </div>

                                    </div>
                                </form>
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
                                                <th width="70px">Tanggal</th>
                                                <th>NISN</th>
                                                <th>Nama</th>
                                                <th>Pin Absensi</th>
                                                <th>Kelas</th>
                                                <th>Absen Masuk</th>
                                                <th>Absen Keluar</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($absensi) > 0)
                                                @foreach($absensi as $data)
                                                <tr>
                                                    <td>{{ $data->TanggalAbsen }}</td>
                                                    <td>{{ $data->NISNSiswa }}</td>
                                                    <td>{{ $data->NamaSiswa }}</td>
                                                    <td>{{ $data->PINAbsensi }}</td>
                                                    <td>{{ $data->NamaKelas." / ".$data->NamaKelasParalel }}</td>
                                                    <td>{{ $data->DataAbsenMasuk }}</td>
                                                    @if ($data->DataAbsenMasuk == $data->DataAbsenKeluar)
                                                        <td></td>
                                                    @else
                                                        <td>{{ $data->DataAbsenKeluar }}</td>
                                                    @endif
                                                    <td>{{ $data->StatusKehadiran }}</td>
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
        var now = new Date();
    	var day = ("0" + now.getDate()).slice(-2);
    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
    	var firstDay = now.getFullYear()+"-"+month+"-01";
    	var NowDay = now.getFullYear()+"-"+month+"-"+day;

        var oldTglAwal = "{{ $oldTglAwal }}";
        var oldTglAkhir = "{{ $oldTglAkhir }}";

        // console.log(oldTglAkhir);

        if (typeof oldTglAwal === 'undefined') {
            jQuery('#TglAwal').val(firstDay);
        } else {
            jQuery('#TglAwal').val(oldTglAwal);
        }

    	
    	jQuery('#TglAkhir').val(typeof oldTglAkhir == 'undefined' ? NowDay : oldTglAkhir);

        jQuery('#orderTable').DataTable({
            dom:"Bfrtip",
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    title: 'Data Absensi Periode : ' +jQuery('#TglAwal').val() + " s/d " + jQuery('#TglAkhir').val() ,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
            ],
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

    });
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
</script>
@endpush
