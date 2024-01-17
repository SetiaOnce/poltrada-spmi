<?php

namespace App\Exports;

use App\Models\DataHasilSurvey;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportHasilSurvey implements FromCollection
{
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $request = $this->request;
        
        if($request->data_nim_excel != null){
            $data = DataHasilSurvey::select(
                "spm_data_hasil_survey.nama",
                "spm_data_hasil_survey.email",                                          
                "spm_data_hasil_survey.nim",                                          
                "spm_data_hasil_survey.jenis_kelamin",                                          
                "spm_pertanyaan_survey.pertanyaan",
                "spm_data_hasil_survey.jawaban",
            )
            ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
            ->where('spm_data_hasil_survey.nim', $request->data_nim_excel)
            ->where('spm_data_hasil_survey.id_nama_survey', $request->id_nama_survey_excel)
            ->get();
            return $data;
        }else{
            $data = DataHasilSurvey::select(
                "spm_data_hasil_survey.nama",
                "spm_data_hasil_survey.email",                                          
                "spm_data_hasil_survey.nim",                                          
                "spm_data_hasil_survey.jenis_kelamin",                                          
                "spm_pertanyaan_survey.pertanyaan",
                "spm_data_hasil_survey.jawaban",
            )
            ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
            ->where('spm_data_hasil_survey.email', $request->email_excel)
            ->where('spm_data_hasil_survey.id_nama_survey', $request->id_nama_survey_excel)
            ->get();
            return $data;
        }
    }

    public function headings(): array
    {
        return ['NAMA', 'EMAIL', 'NIM', 'JENIS KELAMIN', 'PERTANYAAN', 'JAWABAN'];
    }
}
