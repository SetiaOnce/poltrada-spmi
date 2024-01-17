<!--  Modal Add -->
<div class="modal fade bs-example-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h6 class="modal-title">AUDITOR
            </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="_closemodal()"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                    <div class="col-md-12">
                        <dl class="row mb-0">
                            <dt class="col-sm-3"><strong>Tahun</strong></dt>
                            <dd class="col-sm-9" id="tahun">: </dd>

                            <dt class="col-sm-3"><strong>Nama Lembaga</strong></dt>
                            <dd class="col-sm-9" id="nama_lembaga">: </dd>

                            <dt class="col-sm-3"><strong>Jenis Standar Mutu</strong></dt>
                            <dd class="col-sm-9" id="jenis_standar_mutu">: </dd>
                        </dl>
                        <!-- <input type="text" id="periode_evaluasi" class="form-control mb-2" readonly> -->
                        <div class="table-responsive">
                            <table  class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="table-info">
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th class="text-center">AUDITOR</th>
                                    </tr>
                                </thead>
                                <tbody id="data_modal_view">
 
                                </tbody>
                            </table>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </div>
</div>