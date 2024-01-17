<!-- form  Add -->
<div id="card-form" class="row" style="position: static; zoom: 1;display: none;">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title header-title"></h4>
                </div>
                <hr>

                <form id="form-data" class="form" onsubmit="return false">
                    @csrf
                    <input type="hidden" name="id" readonly> 
				    <input type="hidden" name="methodform_data" readonly>
                    <div class="row mb-3">
                        <label class="form-label">Jenis Survey :</label>
                        <div class="input-group">
                            <select name="jenis_survey_id" id="jenis_survey_id" class="form-control select2">
                                <option value="">--Pilih Jenis Survey--</option>
                                @foreach($data_jenis_survey as $jenis_survey)
                                <option value="{{ $jenis_survey->id }}">{{ $jenis_survey->nama_jenis_survey }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Nama Survey : </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="nama_survey" id="nama_survey" placeholder="Masukkan nama survey...">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>

                    <div class="row mb-3">
                        <label class="form-label">Tahun Survey : </label>
                        <div class="input-group" id="datepicker5">
                           <input type="text" name="tahun_survey" id="tahun_survey" class="form-control" data-provide="datepicker" data-date-container='#datepicker5'data-date-format="yyyy" data-date-min-view-mode="2" data-date-autoclose="true" placeholder="Pilih Tahun Survey..." autocomplete="off">
                           <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Logo : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" name="logo" class="form-control" id="logo">
                        </div>
                        <span class="text-danger">*)</span><span class="text-mute" style="font-size:12px;"> Harus diisi! </span>|
                        <span class="text-mute" style="font-size:12px;">File berekstensi <strong style="color:#D23369;">.JPG, .JPEG, .PNG</strong> | maksimal <strong style="color:#D23369;">2 MB</strong> | Ukuran Ideal: 226pixel x 221pixel</span>
                    </div>
                    <div class="mb-3">
                        <img id="showImage" class="img-thumbnail" alt="200x200" width="150" src="{{ asset('img/no-image.png') }}" data-holder-rendered="true">
                    </div>

                    <div class="mt-3" style="float: right;">
                        <button onclick="_closeForm()" class="btn btn-danger btn-sm waves-effect" type="button"><i class="ri-delete-back-2-fill align-middle"></i> Kembali</button>
                        <button id="btn-save" class="btn btn-primary btn-sm waves-effect" type="submit"><i class="ri-save-fill align-middle"></i> Simpan</button>
                    </div>
                    
                </form>
            
            </div>
        </div>
    </div>
</div>
<!-- end form -->