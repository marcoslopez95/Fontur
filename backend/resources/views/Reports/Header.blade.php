<table>
    <tr>
        <td align="left">
            <img
                src="{{ env('APP_URL') . '/fontur_logo.png' }}" width="100px" height="100px">
        </td>
        <td colspan="" style="font-size: 20px; text-align: center;">
            Reporte {{$type_report}} de {{$name_report}}
            <br>
            desde: {{ $fecha_ini }} . hasta: {{ $fecha_fin }}
        </td>
        <td align="right">
            <img
                src="{{ env('APP_URL') . '/logo_mision_gris.png' }}" width="150px" height="100px">
        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 10px">
            <pre>D/T = Dias Trabajados;      % T =  % Trabajado;     DN/T = Dias NO Trabajados;      % N/T = % NO Trabajado</pre>
        </td>
    </tr>
</table>
