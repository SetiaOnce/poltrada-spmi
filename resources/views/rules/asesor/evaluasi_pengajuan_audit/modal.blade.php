<!--  Modal Add -->
<div class="modal fade bs-example-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h6 class="modal-title">Dokumen Pendukung
            </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                    <div class="col-lg-12">
                        <table  class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="table-secondary" width="25%">Unit/Prodi :</th>
                                    <th id="nama_unit_prodi"></th>
                                </tr>
                            </thead>
                        </table>

                        <div class="table-responsive">
                            <table id="PendukungTable" class="table table-bordered mb-0">
                                <thead class="table-info">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Dokumen</th>
                                        <th>File Pendukung</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody id="data_pendukung">
                                    <tr>
                                        <td>1</td>
                                        <td>Lorem Ipsum</td>
                                        <td><button class="btn btn-primary btn-sm" onclick="priveryPdf()">Lihat</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Priview Pdf -->
<div class="modal fade bs-example-modal-xl" id="modalPrivewPdf" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myLargeModalLabel">Priview Pdf</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <embed id="PriviewPdf" type="application/pdf" src="" width="100%" height="500"></embed>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Priview Pdf -->