<form id="jenis_data_tampil">
    @csrf
    <input type="hidden" name="email" readonly>
    <input type="hidden" name="data_nim" readonly>
    <input type="hidden" name="id_nama_survey" value="{{ $nama_survey->id }}" readonly>
</form>

<!--  Modal Add -->
<div class="modal fade bs-example-modal-lg" id="modalView" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h6 class="modal-title">JAWABAN SURVEY
            </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="_closemodal()"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="table-secondary" style="font-size: 13px;">NAMA</th>
                                <th id="dataNama" style="font-size: 13px;"></th>
                            </tr>
                            <tr>
                                <th class="table-secondary" style="font-size: 13px;">NIK</th>
                                <th id="dataNik" style="font-size: 13px;"></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="table-secondary" style="font-size: 13px;">JENIS KELAMIN</th>
                                <th id="dataJenisKelamin" style="font-size: 13px;"></th>
                            </tr>
                            <tr>
                                <th class="table-secondary" style="font-size: 13px;">EMAIL</th>
                                <th id="dataEmail" style="font-size: 13px;"></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <form id="import-data-excel" method="post" action="{{ route('hasil.survey.export.excel') }}">
                    @csrf
                        <input type="hidden" name="data_nim_excel" readonly>
                        <input type="hidden" name="email_excel" readonly>
                        <input type="hidden" name="id_nama_survey_excel" readonly>
                        <div class="col-md-3 mb-2">
                            <button type="submit"  class="btn btn-success btn-sm" data-bs-original-title="Download Excel" data-bs-placement="top" data-bs-toggle="tooltip"><i class="mdi mdi-microsoft-excel align-middle me-1"></i> Download Excel</button>
                        </div>
                    </form>
                </div>
               <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table  class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="table-info">
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th class="text-center">PERTANYAAN</th>
                                        <th class="text-center">JAWABAN</th>
                                    </tr>
                                </thead>
                                <tbody id="data_modal_view">
                                    <!-- <tr>
                                        <td></td>
                                        <td></td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Add -->