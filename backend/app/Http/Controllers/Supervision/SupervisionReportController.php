<?php

namespace App\Http\Controllers\Supervision;

use App\Models\Municipality;
use App\Models\Supervision;
use App\Models\Supervisor;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class SupervisionReportController{
    protected $model;
    protected $headers = [
        'N°',
        'Fecha',
        'Placa',
        'N° Control',
        'Combustible',
        'D/T',
        '% T',
        'DN/T',
        '% N/T'
    ];
    protected $fech_fin;
    protected $fech_ini;
    protected $html;
    protected $vehicles;
    protected $supervisions;
    protected $type_report;
    protected $dif_days;

    public function __construct(Vehicle $model, Supervision $supervision)
    {
        $this->model = $supervision;
        $this->supervisions = $supervision;
    }

    /**
     * Función principal para hacer el reporte
     *
     * @param Request $request
     * @return void response download file
     */
    public function report(Request $request)
    {
        // arreglar rangode fechas cuando no se envian

        $this->dif_days = self::totalDays($request); // diferencia de días entre fechas

        self::getSupervisiones($request); // genera la consulta

       // return $this->supervisions;

        $option = $request['type_report'] ?? 'General';

        switch($option){
            case 'General':
                $this->type_report = 'General';
                self::reportGeneral($request);
                break;
            case 'Linea':
                $this->type_report = 'por Líneas';
                self::reportByLine();
                break;
            case 'Supervisor':
                $this->type_report = 'por Supervisor';
                self::reportBySupervisor();
        }

        return self::generarPdf();
    }

    private function reportBySupervisor(){
        $this->supervisions = $this->supervisions->groupBy(['municipality_name','line_name']);

        $this->html = view('Reports.Supervision.SupervisionReportBySupervisor', [
            'headers' => $this->headers,
            'fecha_ini' => $this->fecha_ini->format('Y-m-d'),
            'fecha_fin' => $this->fecha_fin->format('Y-m-d'),
            'supervisions' => $this->supervisions,
            'type_report' => $this->type_report,
            'dif_days' => $this->dif_days,
            'name_report' => 'Supervisiones'
        ]);
    }

    private function reportByLine(){
        $this->supervisions = $this->supervisions->groupBy(['municipality_name','line_name']);

        $this->html = view('Reports.Supervision.SupervisionReportByLine', [
            'headers' => $this->headers,
            'fecha_ini' => $this->fecha_ini->format('Y-m-d'),
            'fecha_fin' => $this->fecha_fin->format('Y-m-d'),
            'supervisions' => $this->supervisions,
            'type_report' => $this->type_report,
            'dif_days' => $this->dif_days,
            'name_report' => 'Supervisiones'
        ]);
    }

    private function reportGeneral(){

        $this->html = view('Reports.SupervisionReport', [
            'headers' => $this->headers,
            'fecha_ini' => $this->fecha_ini->format('Y-m-d'),
            'fecha_fin' => $this->fecha_fin->format('Y-m-d'),
            'supervisions' => $this->supervisions,
            'type_report' => $this->type_report,
            'dif_days' => $this->dif_days,
            'name_report' => 'Supervisiones'
        ]);

    }

    private function totalDays(Request $request)
    {
        if ($request->has('fecha_ini')) {
            $this->fecha_ini = Carbon::parse($request->fecha_ini);
        } else {
            $min = $this->supervisions::all()->min('fecha');

            $this->fecha_ini = Carbon::parse($min);
        }

        if ($request->has('fecha_fin')) {
            $this->fecha_fin = Carbon::parse($request->fecha_fin);
        } else {
            $max = $this->supervisions::all()->max('fecha');;
            $this->fecha_fin = Carbon::parse($max);
        }
        $dif_days = $this->fecha_fin->diffInDays($this->fecha_ini);

        $dif_weekend_days = $this->fecha_fin->diffInWeekendDays($this->fecha_ini);
        //dd($dif_days-$dif_weekend_days);
        return $dif_days - $dif_weekend_days;
    }

    private function getSupervisiones(Request $request)
    {
        $this->supervisions = $this->model::with([
            'vehicle.line.municipality',
            'supervisor.municipality'
        ])
        ->Filtro($request)
        ->addSelect([
            'days_worked'       => DB::table('vehicles')->select(DB::raw('count(*)'))->whereColumn('vehicle_id', 'vehicles.id'),
            'days_no_worked'    => DB::table('vehicles')->select(DB::raw($this->dif_days."-count(*)"))->whereColumn('vehicle_id', 'vehicles.id'),
            "percent_worked"    => DB::table('vehicles')->select(DB::raw("round(count(*)*100/".$this->dif_days."::numeric,2)"))->whereColumn('vehicle_id', 'vehicles.id'),
            "percent_no_worked" => DB::table('vehicles')->select(DB::raw("round((".$this->dif_days."-count(*))*100/".$this->dif_days."::numeric,2)"))->whereColumn('vehicle_id', 'vehicles.id'),
            "municipality_name" => Municipality::select('nombre')->whereColumn('municipality_id','municipalities.id')->limit(1),
            "line_name"         =>DB::table('lines')
                                    ->select('name')
                                    ->join('vehicles','line_id','lines.id')
                                    ->whereColumn('vehicle_id','vehicles.id')
                                    ->limit(1)
        ])
        ->orderBy('fecha','desc')
        ->get()
        ;
    }

    private function generarPdf()
    {
        $pdf = new Mpdf();
        $pdf->WriteHTML($this->html);
        $nombre_archivo = 'Reporte '.$this->type_report.' de Supervisiones - '
                            . Carbon::now()->format('Y_m_d_h_i');
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename='$nombre_archivo.pdf'");
        return $pdf->Output("$nombre_archivo.pdf", 'I');
    }
}
