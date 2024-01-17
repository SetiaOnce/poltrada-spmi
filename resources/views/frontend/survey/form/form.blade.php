<div id="status-data" class="col-md-12">
    
</div>
<div class="col-md-12">
    @if($detail_survey->jenis_survey_id == 4)
    <form id="form-notar">
        @csrf
        <div class="form-group">
            <input type="hidden" name="jenis_survey_id" value="{{ $detail_survey->jenis_survey_id }}">
            <label class="control-label" for="notar">No.Taruna:</label>
            <div class="input-group">
                <input type="text" onkeypress="return hanyaAngka(event)" name="notar" id="notar" class="form-control" placeholder="Masukkan no taruna" autocomplete="off" required />
                <span class="input-group-addon"><a href="javascript:void(0);" id="btn-cek" type="submit"><b><i class="fa fa-search fa-fw" aria-hidden="true"></i>Cek</b></a></span>
            </div>
            <span class="help-block">*) No Taruna Terdiri Dari 7 Angka</span>
        </div>
    </form>
    @else
    <form id="form-email">
        @csrf
        <div class="form-group">
            <input type="hidden" name="jenis_survey_id" value="{{ $detail_survey->jenis_survey_id }}">
            <label class="control-label" for="cek_email">Email:</label>
            <div class="input-group">
                <input type="email" name="cek_email" id="cek_email" class="form-control" placeholder="Masukkan email" autocomplete="off" required />
                <span class="input-group-addon"><a href="javascript:void(0);" id="btn-cek-email" type="submit"><b><i class="fa fa-search fa-fw" aria-hidden="true"></i>Cek</b></a></span>
            </div>
            <span class="help-block">*) Masukkan email untuk melakukan pengecekan</span>
        </div>
    </form>
    @endif

    <div class="hide" id="form_survey_taruna">
        <h3 class="box-title">--Biodata Diri Anda</h3>
            <input type="hidden" name="nim" id="nim" class="form-control" readonly />
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="nik">NIK:</label>
                        <input type="text" name="nik" id="nik" class="form-control" readonly />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="nama">Nama:</label>
                        <input type="text" name="nama" id="nama" class="form-control" readonly />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="jenis_kelamin">Jenis Kelamin:</label>
                        <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" readonly />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email">Email:</label>
                        <input type="text" name="email" id="email" class="form-control" readonly />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="tahun_masuk">Tahun Masuk:</label>
                        <input type="text" name="tahun_masuk" id="tahun_masuk" class="form-control" readonly />
                    </div>
                </div>
            </div>
            
            <strong>-ISI SURVEY DIBAWAH</strong> <br> <strong>-Informasi : </strong> <input type="checkbox" checked onclick="return false;"/> Sudah Selesai , <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="return false;"> Belum Selesai
            
            <div class="panel-group" id="accordion">
                @foreach($data_event_survey as $survey_no => $event_survey)
                @php
                    $tanggalSekarang = new DateTime();
                    $tanggalSekarang->format('Y/m/d');
                    $event_dimulai = new DateTime($event_survey->priode_evaluasi_diri_awal);
                    $event_berakhir  = new DateTime($event_survey->priode_evaluasi_diri_akhir);
                @endphp
                @if( $tanggalSekarang->getTimestamp() > $event_dimulai->getTimestamp() &&  $tanggalSekarang->getTimestamp() < $event_berakhir->getTimestamp())
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5 class="panel-title">
                            <span data-toggle="collapse" data-parent="#accordion" style="cursor: pointer;" href="#collapse{{ $event_survey->id }}" data-placement="top" title="Klik Untuk Lihat Detail">
                                <strong style="font-size:13px;align-items:center;">
                                    <input type="checkbox" class="form-check-input status-check-survey{{ $event_survey->id }}" id="exampleCheck1" style="margin-right: 10px;" onclick="return false;"> {{ $event_survey->nama_survey }}
                                </strong>
                            </span>
                        </h5>
                    </div>
                    <div id="collapse{{ $event_survey->id }}" class="panel-collapse collapse collspan-message{{ $event_survey->id }}">
                        <div class="panel-body">
                            <h3 class="box-title">--PERTANYAAN SURVEY</h3>
                            <form id="form-survey{{ $event_survey->id }}">
                                @csrf
                                <input type="hidden" value="{{ $event_survey->jenis_survey_id }}" name="jenis_survey" id="jenis_survey" class="form-control" readonly />
                                <input type="hidden" value="{{ $event_survey->nama_survey_id }}" name="id_nama_survey" id="id_nama_survey" class="form-control" readonly />
                                <input type="hidden" value="{{ $event_survey->id }}" name="id_event_survey" id="id_event_survey" class="form-control" readonly />
                                
                                <input type="hidden" name="nim" id="nim" class="form-control" readonly />
                                <input type="hidden" name="nik" id="nik" class="form-control" readonly />
                                <input type="hidden" name="nama" id="nama" class="form-control" readonly />
                                <input type="hidden" name="jenis_kelamin" id="jenis_kelamin" class="form-control" readonly />
                                <input type="hidden" name="email" id="email" class="form-control" readonly />
                                <input type="hidden" name="tahun_masuk" id="tahun_masuk" class="form-control" readonly />
                                <input type="hidden" name="jenjang" id="jenjang" class="form-control" readonly />
                                <input type="hidden" name="prodi" id="prodi" class="form-control" readonly />
                            @php
                                $data_pertanyaan_survey = App\Models\PertanyaanSurvey::where('nama_survey_id', $event_survey->nama_survey_id)->get();

                                $count = count($data_pertanyaan_survey);
                            @endphp
                            @foreach($data_pertanyaan_survey as $no => $pertanyaan_survey)

                                <input type="hidden" name="id[]" value="{{ $pertanyaan_survey['id'] }}" readonly>
                                <input type="hidden" value="{{ $count }}" name="jumlah" readonly>

                                @if($pertanyaan_survey->jenis == 0)
                                <div class="form-group">
                                    <span class="help-block">{{ $no+1 }} ) {{ $pertanyaan_survey->pertanyaan }}</span>
                                    <textarea name="jawaban{{ $pertanyaan_survey['id'] }}" id="jawaban{{ $pertanyaan_survey['id'] }}" class="form-control" placeholder="Masukkan jawaban anda disini..." rows="2" ></textarea>
                                    <span class="help-block" style="font-size: 12px; color:red;">* Jawaban tidak lebih dari 255 karakter</span>
                                </div>
                                <hr>
                                @else
                                <div class="form-group">
                                    <span class="help-block">{{ $no+1 }} ) {{ $pertanyaan_survey->pertanyaan }}</span>
                                    @if($pertanyaan_survey->pilihan1 != null)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{$pertanyaan_survey->pilihan1}}" name="jawaban{{ $pertanyaan_survey['id'] }}" id="jawaban{{ $pertanyaan_survey['id'] }}">
                                        <label class="form-check-label" for="jawaban{{ $pertanyaan_survey['id'] }}">
                                        {{ $pertanyaan_survey->pilihan1 }}
                                        </label>
                                    </div>
                                    @endif
                                    @if($pertanyaan_survey->pilihan2 != null)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{$pertanyaan_survey->pilihan2}}" name="jawaban{{ $pertanyaan_survey['id'] }}" id="jawaban{{ $pertanyaan_survey['id'] }}" >
                                        <label class="form-check-label" for="jawaban{{ $pertanyaan_survey['id'] }}">
                                        {{ $pertanyaan_survey->pilihan2 }}
                                        </label>
                                    </div>
                                    @endif
                                    @if($pertanyaan_survey->pilihan3 != null)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{$pertanyaan_survey->pilihan3}}" name="jawaban{{ $pertanyaan_survey['id'] }}" id="jawaban{{ $pertanyaan_survey['id'] }}">
                                        <label class="form-check-label" for="jawaban{{ $pertanyaan_survey['id'] }}">
                                        {{ $pertanyaan_survey->pilihan3 }}
                                        </label>
                                    </div>
                                    @endif
                                    @if($pertanyaan_survey->pilihan4 != null)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{$pertanyaan_survey->pilihan4}}" name="jawaban{{ $pertanyaan_survey['id'] }}" id="jawaban{{ $pertanyaan_survey['id'] }}" >
                                        <label class="form-check-label" for="jawaban{{ $pertanyaan_survey['id'] }}">
                                        {{ $pertanyaan_survey->pilihan4 }}
                                        </label>
                                    </div>
                                    @endif
                                    @if($pertanyaan_survey->pilihan5 != null)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{$pertanyaan_survey->pilihan5}}" name="jawaban{{ $pertanyaan_survey['id'] }}" id="jawaban{{ $pertanyaan_survey['id'] }}" >
                                        <label class="form-check-label" for="jawaban{{ $pertanyaan_survey['id'] }}">
                                        {{ $pertanyaan_survey->pilihan5 }}
                                        </label>
                                    </div>
                                    @endif
                                </div>
                                <hr>
                                @endif
                                @endforeach
                            </form>
                            <div class="col-md-12 text-right">
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success" onclick="submit_survey('{{ $event_survey->id }}')" name="submit-survey{{ $event_survey->id }}" id="submit-survey{{ $event_survey->id }}">
                                        <i class="fa fa-sign-in fa-fw"></i> Kirim Survey
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
    </div>