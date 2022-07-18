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

class SupervisionReportController
{
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
    protected $name_report;

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
        $this->dif_days = self::totalDays($request); // diferencia de días entre fechas

        self::getSupervisiones($request); // genera la consulta

        // return $this->supervisions;

        $option = $request['type_report'] ?? 'General';

        switch ($option) {
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

    private function reportBySupervisor()
    {
        $this->supervisions = $this->supervisions->groupBy(['supervisor_name','municipality_name', 'line_name']);
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

    private function reportByLine()
    {
        $this->supervisions = $this->supervisions->groupBy(['municipality_name', 'line_name']);

        $this->html = view('Reports.Supervision.SupervisionReportByLine', [
            'headers' => $this->headers,
            'supervisions' => $this->supervisions,
            'dif_days' => $this->dif_days,
        ]);
    }

    private function reportGeneral()
    {

        $this->html = view('Reports.SupervisionReport', [
            'headers' => $this->headers,
            'supervisions' => $this->supervisions,
            'dif_days' => $this->dif_days,
        ]);
    }

    private function totalDays(Request $request)
    {
        if ($request->has('fecha_ini') && $request->fecha_ini) {
            $this->fecha_ini = Carbon::parse($request->fecha_ini);
        } else {
            $min = $this->supervisions::all()->min('fecha');
            $this->fecha_ini = Carbon::parse($min);
        }

        if ($request->has('fecha_fin') && $request->fecha_fin) {
            $this->fecha_fin = Carbon::parse($request->fecha_fin);
        } else {
            $max = $this->supervisions::all()->max('fecha');
            $this->fecha_fin = Carbon::parse($max);
        }
        if($this->fecha_fin == $this->fecha_ini){
            $dif_days = 1;
        }else{
            $dif_days = $this->fecha_fin->diffInDays($this->fecha_ini);
        }

        $dif_weekend_days = $this->fecha_fin->diffInWeekendDays($this->fecha_ini);

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
                'days_no_worked'    => DB::table('vehicles')->select(DB::raw($this->dif_days . "-count(*)"))->whereColumn('vehicle_id', 'vehicles.id'),
                "percent_worked"    => DB::table('vehicles')->select(DB::raw("round(count(*)*100/" . $this->dif_days . "::numeric,2)"))->whereColumn('vehicle_id', 'vehicles.id'),
                "percent_no_worked" => DB::table('vehicles')->select(DB::raw("round((" . $this->dif_days . "-count(*))*100/" . $this->dif_days . "::numeric,2)"))->whereColumn('vehicle_id', 'vehicles.id'),
                "municipality_name" => Municipality::select('nombre')->whereColumn('municipality_id', 'municipalities.id')->limit(1),
                'supervisor_name'   => Supervisor::select(DB::Raw('first_name||\' \'||last_name'))->whereColumn('supervisor_id','supervisors.id')->limit(1),
                "line_name"         => DB::table('lines')
                    ->select('name')
                    ->join('vehicles', 'line_id', 'lines.id')
                    ->whereColumn('vehicle_id', 'vehicles.id')
                    ->limit(1)
            ])
            ->orderBy('fecha', 'desc')
            ->get();
    }

    private function generarPdf()
    {
        $this->name_report = 'Reporte ' . $this->type_report . ' de Supervisiones';
        $name = $this->name_report.' - '. Carbon::now()->format('Y_m_d_h_i');
        $pdf = new Mpdf();
        $pdf->SetHTMLHeader(self::setHeader());
        $pdf->setFooter(self::setFooter(),'O');
        $pdf->setFooter(self::setFooter(),'E');
        $pdf->WriteHTML($this->html);
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename='".$name.".pdf'");
        return $pdf->Output($name.".pdf", 'I');
    }

    private function setHeader()
    {
        return view('Reports.Header', [
            'fecha_ini' => $this->fecha_ini->format('Y-m-d'),
            'fecha_fin' => $this->fecha_fin->format('Y-m-d'),
            'type_report' => $this->type_report,
            'name_report' => 'Supervisiones',
        ]);
    }

    private function setFooter()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        return [
            'L' => [
                'content' => $this->name_report,
                'font-size' => 10,
                'font-family' => 'serif',
                'color' => '#000000'
            ],
            'C' => [
                'content' =>  $now,
                'font-size' => 10,
                'font-family' => 'serif',
                'color' => '#000000'
            ],
            'R' => [
                'content' => '{PAGENO} de {nbpg}',
                'font-size' => 10,
                'font-style' => 'B',
                'font-family' => 'serif',
                'color' => '#000000'
            ],
            'line' => 1,
        ];
    }
}
