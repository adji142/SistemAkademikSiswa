@extends('parts.header')

@section('content')

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-solid">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-white mb-0 px-0 py-2">
				<li class="breadcrumb-item active" aria-current="page">
					<a href="{{route('templatemessage')}}">Kelas</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Input Kelas</li>
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
										@if (count($templatemessage) > 0)
											Edit Kelas
										@else
											Tambah Kelas
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
								@if (count($templatemessage) > 0)
									<form action="{{route('templatemessage-edit')}}" method="post">
										<input type="hidden" class="form-control" id="id" name="id" value="{{ count($templatemessage) > 0 ? $templatemessage[0]['id'] : '' }}" required="">
								@else
									<form action="{{route('templatemessage-store')}}" method="post">
								@endif
									@csrf

									<div class="form-group row">
										<div class="col-md-12">
											<label class="text-body">Nama Template</label>
											<fieldset class="form-group mb-3">
												<input type="text" class="form-control" id="NamaTemplate" name="NamaTemplate" placeholder="Nama Template" value="{{ count($templatemessage) > 0 ? $templatemessage[0]['NamaTemplate'] : '' }}" required="">
											</fieldset>
										</div>
                                        <div class="col-md-12">
                                            <label  class="text-body">Template</label><br>
                                            <button type="button" id="btNamaSekolah" data-action="NamaSekolah" class="btParameter btn btn-outline-secondary rounded-pill font-weight-bold me-1 mb-1">NamaSekolah</button>
                                            <button type="button" id="btAlamatSekolah" data-action="AlamatSekolah" class="btParameter btn btn-outline-secondary rounded-pill font-weight-bold me-1 mb-1">AlamatSekolah</button>
                                            <button type="button" id="btNIS" data-action="NIS" class="btParameter btn btn-outline-secondary rounded-pill font-weight-bold me-1 mb-1">NISNSiswa</button>
                                            <button type="button" id="btNamaSiswa" data-action="NamaSiswa" class="btParameter btn btn-outline-secondary rounded-pill font-weight-bold me-1 mb-1">NamaSiswa</button>
                                            <button type="button" id="btNamaWali" data-action="NamaWali" class="btParameter btn btn-outline-secondary rounded-pill font-weight-bold me-1 mb-1">NamaWali</button>
                                            <button type="button" id="btDataAbsen" data-action="DataAbsen" class="btParameter btn btn-outline-secondary rounded-pill font-weight-bold me-1 mb-1">DataAbsen</button>
                                            <button type="button" id="btDataAbsenMasuk" data-action="DataAbsenMasuk" class="btParameter btn btn-outline-secondary rounded-pill font-weight-bold me-1 mb-1">DataAbsenMasuk</button>
                                            <button type="button" id="btDataAbsenKeluar" data-action="DataAbsenKeluar" class="btParameter btn btn-outline-secondary rounded-pill font-weight-bold me-1 mb-1">DataAbsenKeluar</button>
                                            <button type="button" id="btTanggal" data-action="TanggalHariIni" class="btParameter btn btn-outline-secondary rounded-pill font-weight-bold me-1 mb-1">TanggalHariIni</button>
                                            <button type="button" id="btNamaHari" data-action="Hari" class="btParameter btn btn-outline-secondary rounded-pill font-weight-bold me-1 mb-1">Hari</button>
                                            <button type="button" id="btStatusKehadiran" data-action="StatusKehadiran" class="btParameter btn btn-outline-secondary rounded-pill font-weight-bold me-1 mb-1">StatusKehadiran</button>
                                            <button type="button" id="btPinGuru" data-action="PINGuru" class="btParameter btn btn-outline-secondary rounded-pill font-weight-bold me-1 mb-1">PIN Guru</button>
                                            <button type="button" id="btNamaGuru" data-action="NamaGuru" class="btParameter btn btn-outline-secondary rounded-pill font-weight-bold me-1 mb-1">PIN Guru</button>
                                            <hr>
                                            <fieldset class="form-group mb-12">
                                                <textarea class="form-control" id="TemplateContent" name="TemplateContent" rows="5" placeholder="Masukan Template">{{ count($templatemessage) > 0 ? $templatemessage[0]['TemplateContent'] : '' }}</textarea>
                                            </fieldset>
                                            <br>
                                            <button type="button" id="btBold" data-wrap="*" class="btWrap btn btn-outline-secondary  font-weight-bold me-1 mb-1">B</button>
                                            <button type="button" id="btItalic" data-wrap="_" class="btWrap btn btn-outline-secondary  font-weight-bold me-1 mb-1">I</button>
                                            <hr>
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
    $(function () {
        jQuery(document).ready(function () {

        });
        jQuery('.btParameter').click(function () {
            const action = jQuery(this).data('action');
            const $textarea = $('#TemplateContent');
            const cursorPosition = $textarea.prop('selectionStart');

            console.log(action);

            var TextToInsert = "#"+action+"#";

            insertTextAtCursor($textarea, TextToInsert, cursorPosition);
        });

        jQuery('.btWrap').click(function () {
            const wrapChar = $(this).data('wrap');
            const $textarea = $('#TemplateContent');
            wrapSelectedText($textarea, wrapChar);
        });

        function insertTextAtCursor($textarea, text, position) {
            const currentValue = $textarea.val();
            const newValue = currentValue.slice(0, position) + text + currentValue.slice(position);

            // Update the textarea with new text and move the cursor
            $textarea.val(newValue);
            $textarea[0].setSelectionRange(position + text.length, position + text.length);
            $textarea.focus();
        }
        function wrapSelectedText($textarea, wrapChar) {
            const textarea = $textarea[0];
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const text = $textarea.val();

            // Get selected text and wrap it
            const selectedText = text.substring(start, end);
            const wrappedText = wrapChar + selectedText + wrapChar;

            // Replace selected text with wrapped text
            const newText = text.substring(0, start) + wrappedText + text.substring(end);
            $textarea.val(newText);

            // Re-select the wrapped text (optional)
            textarea.setSelectionRange(start, start + wrappedText.length);
            $textarea.focus();
        }
    })
</script>
@endpush
