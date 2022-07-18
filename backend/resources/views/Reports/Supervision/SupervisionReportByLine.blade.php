@extends('BaseView')

@section('stiles')
    <style>
        .text-titulo {
            font-size: 18px
        }

        html {
            font-size: 12px
        }

        td {
            border: 0 0 0 1px solid black
        }

        .separador-20{
            height: 20px;
        }
        .separador-30{
            height: 30px;
        }
        .separador-40{
            height: 40px;
        }
    </style>
@endsection

@section('body')
    <table align='center' style="border-collapse: collapse;">
        <thead>
            <tr>
                @foreach ($headers as $head)
                <th style="
                font-size: 12px;
                height: 120px;
                vertical-align:bottom
                "
            >
                        {{ $head }}
                    </th>
                @endforeach
            </tr>

        </thead>
        <tbody>
            @php
                $i = 1;
                $count_type_fuel = [];
                $acum_days_worked = 0;
                $acum_not_days_worked = 0;
                $acum_percent_worked = 0;
                $acum_not_percent_worked = 0;
            @endphp
            @foreach ($supervisions as $municipio => $linea)

                <tr style="
                background-color: rgb(65, 24, 177);
                ">
                    <td style=" color:white;">
                        Municipio:
                    </td>
                    <td style=" color:white;"
                        colspan="{{ count($headers) - 2}}"
                    align="center"
                    >
                        <b> {{ $municipio }}</b>
                    </td>
                    <td></td>
                </tr>
                @foreach ($linea as $line => $supervisiones)
                    <tr style="background-color: rgb(77, 88, 243);">
                        <td colspan="{{count($headers)}}" align="center" >
                            <table width="100%" style="border-collapse: collapse;">
                                <tr>
                                    <td style=" color:white;">
                                        Línea:
                                    </td>
                                    <td
                                        style="

                                            color:white
                                        "
                                    >
                                        <b> {{ $line }}<b>
                                    </td>
                                    <td style=" color:white;" align="right">
                                        Total vehiculos: {{count($supervisiones)}}
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>
                    @foreach ($supervisiones as $supervision)
                    @php
                if(!(array_key_exists($supervision->vehicle->type_fuel,$count_type_fuel))){
                    $count_type_fuel[$supervision->vehicle->type_fuel] = 0;
                }
                $count_type_fuel[$supervision->vehicle->type_fuel] +=1;
                $acum_days_worked += $supervision->days_worked;
                $acum_not_days_worked += $supervision->days_no_worked;
                $acum_percent_worked += $supervision->percent_worked;
                $acum_not_percent_worked += $supervision->percent_no_worked;
            @endphp
                        <tr>
                            <td align="center">
                                {{ $i++ }}
                            </td>
                            <td align="center">
                                {{ $supervision->fecha }}
                            </td>
                            <td align="center">
                                {{ $supervision->vehicle->placa }}
                            </td>
                            <td align="center">
                                {{ $supervision->vehicle->num_controller }}
                            </td>
                            <td align="center">
                                {{ $supervision->vehicle->type_fuel }}
                            </td>
                            <td align="center">
                                {{ $supervision->days_worked }}
                            </td>
                            <td align="center">
                                {{ $supervision->percent_worked }}
                            </td>
                            <td align="center">
                                {{ $supervision->days_no_worked }}
                            </td>
                            <td align="center">
                                {{ $supervision->percent_no_worked }}
                            </td>
                        </tr>
                    @endforeach
                @endforeach
                <tr>
                    <td style="height: 20px"></td>
                </tr>
            @endforeach
            @if (count($supervisions) > 0)
            <tr>
                <td style="height: 50px"></td>
            </tr>
        <tr>
            <td colspan="{{count($headers)}}">
                @include('Reports.Footer')
            </td>
        </tr>
        @endif


        </tbody>
    </table>
@endsection
