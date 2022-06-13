@extends('BaseView')

@section('stiles')
    <style>
        .text-titulo {
            font-size: 18px
        }
        html{
            font-size: 12px
        }
        td{
            border:0 0 0 1px solid black
        }
    </style>
@endsection

@section('body')
    <table>
        <thead>

            <tr>
                <td colspan="{{ count($headers) }}" style="font-size: 20px; text-align: center;">
                    Reporte de Vehículos
                </td>
            </tr>
            <tr>
                <tr>
                    <td colspan="{{ count($headers) }}" style="font-size: 12px; text-align: center;">
                        desde: {{$fecha_ini}} . hasta: {{$fecha_fin}}
                    </td>
                </tr>
            <tr>
                @foreach ($headers as $head)
                    <th style="font-size: 12px">
                        {{ $head }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody >
            @php
                $i=1;
            @endphp
            @foreach ($vehicles as $vehicle)
            <tr>
                <td align="center">
                    {{$i++}}
                </td>
                <td align="center">
                    {{$vehicle->placa}}
                </td>
                <td align="center">
                    {{$vehicle->num_controller}}
                </td>
                <td align="center">
                    {{$vehicle->type_fuel}}
                </td>
                <td align="center">
                    {{$vehicle->days_worked}}
                </td>
                <td align="center">
                    {{$vehicle->percent_worked}}
                </td>
                <td align="center">
                    {{$vehicle->days_no_worked}}
                </td>
                <td align="center">
                    {{$vehicle->percent_no_worked}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
