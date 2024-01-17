<div class="row scroll-row" style="margin-top: 10px;">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="section-title-heading text-center">
                    <h3 class="wow fadeInDown" data-wow-delay=".3s">STATUS AKREDITASI</h3>
                </div>
            </div>
            <div class="panel-body wow fadeIn" data-wow-delay=".3s">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-group" id="accordion">
                                            
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered table-hover color-table inverse-table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>PROGRAM</th>
                                            <th>PROGRAM STUDI</th>
                                            <th class="text-center">STATUS & PERINGKAT</th>
                                            <th class="text-center">TAHUN SK</th>
                                            <th class="text-center">TANGGAL KEDALUARSA</th>
                                            <th class="text-center">FILE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dt_statusAkreditasi as $no => $akreditasi)            
                                            <tr>
                                                <td align="center">{{ $no+1 }}</td>
                                                <td>{{ $akreditasi->program }}</td>
                                                <td>{{ $akreditasi->prodi->nama_prodi }}</td>
                                                <td align="center">{{ $akreditasi->status_peringkat }}</td>
                                                <td align="center">{{ $akreditasi->tahun_sk }}</td>
                                                <td align="center">{{ date('d-m-Y', strtotime($akreditasi->tanggal_kedaluarsa)) }}</td>
                                                <td align="center"><a href="{{ asset('pdf/data-akreditasi/'.$akreditasi->file_sertifikat) }}" title="Lihat File Sertifikat" class="btn btn-danger btn-sm" target="_blank">File Sertifikat</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
