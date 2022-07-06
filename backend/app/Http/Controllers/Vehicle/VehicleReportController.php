<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Vehicle\VehicleController;
use App\Models\Supervision;
use App\Models\Vehicle;
use App\Repositories\Vehicle\VehicleRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class VehicleReportController extends Controller
{

    protected $model;
    protected $headers = [
        'N°',
        'Placa',
        'N° Control',
        'Tipo Combustible',
        'Dias Trabajados',
        '% trabajado',
        'Dias No Trabajados',
        '% NO trabajado'
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
        $this->model = $model;
        $this->supervisions = $supervision;
    }

    public function report(Request $request)
    {
        $this->dif_days = self::totalDays($request);
        self::getVehicles($request);
        $option = $request['type_report'] ?? 'General';
        switch($option){
            case 'General':
                self::reportGeneral($request);
                break;
            case 'Municipio':
                self::reportByMunicipality();
                breal;
        }

        return self::generarPdf();
    }

    private function reportByMunicipality(){

    }

    private function reportGeneral(){
        $this->type_report = 'General';

        $this->html = view('Reports.VehicleReport', [
            'headers' => $this->headers,
            'fecha_ini' => $this->fecha_ini->format('Y-m-d'),
            'fecha_fin' => $this->fecha_fin->format('Y-m-d'),
            'vehicles' => $this->vehicles,
            'type_report' => $this->type_report,
            'dif_days' => $this->dif_days
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

    private function getVehicles(Request $request)
    {
        $this->vehicles = $this->model::addSelect([
            'line_name' => DB::table('lines')->select('name')->whereColumn('line_id','lines.id')->limit(1),
            'days_worked' => DB::table('supervisions')->select(DB::raw('count(*)'))->whereColumn('vehicle_id', 'vehicles.id'),
            'days_no_worked' => DB::table('supervisions')->select(DB::raw($this->dif_days."-count(*)"))->whereColumn('vehicle_id', 'vehicles.id'),
            "percent_worked" => DB::table('supervisions')->select(DB::raw("round(count(*)*100/".$this->dif_days."::numeric,2)"))->whereColumn('vehicle_id', 'vehicles.id'),
            "percent_no_worked" => DB::table('supervisions')->select(DB::raw("round((".$this->dif_days."-count(*))*100/".$this->dif_days."::numeric,2)"))->whereColumn('vehicle_id', 'vehicles.id'),
        ])
            ->Filtro($request)
            ->get();
    }

    private function generarPdf()
    {
        $pdf = new Mpdf();
        $pdf->WriteHTML($this->html);
        $nombre_archivo = 'Reporte de Supervisiones - ' . Carbon::now()->format('Y_m_d_h_i');
        header('Content-Type: application/pdf');
        header("Content-Disposition: inline; filename='$nombre_archivo.pdf'");
        return $pdf->Output("$nombre_archivo.pdf", 'I');
    }
}
