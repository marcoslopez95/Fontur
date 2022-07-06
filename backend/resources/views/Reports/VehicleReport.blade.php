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
    </style>
@endsection

@section('body')
    <table>
        <thead>
            <tr>
                <td colspan="{{ count($headers) }}" align='center'>
                    @include('Reports.Header')
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
        <tbody>
            @php
                $i = 1;
                $count_type_fuel = [];
                $acum_days_worked = 0;
                $acum_not_days_worked = 0;
                $acum_percent_worked = 0;
                $acum_not_percent_worked = 0;
            @endphp
            @foreach ($vehicles as $vehicle)
            @php
                if(!(array_key_exists($vehicle->type_fuel,$count_type_fuel))){
                    $count_type_fuel[$vehicle->type_fuel] = 0;
                }
                $count_type_fuel[$vehicle->type_fuel] +=1;
                $acum_days_worked += $vehicle->days_worked;
                $acum_not_days_worked += $vehicle->days_no_worked;
                $acum_percent_worked += $vehicle->percent_worked;
                $acum_not_percent_worked += $vehicle->percent_no_worked;
            @endphp
                <tr>
                    <td align="center">
                        {{ $i++ }}
                    </td>
                    <td align="center">
                        {{ $vehicle->placa }}
                    </td>
                    <td align="center">
                        {{ $vehicle->num_controller }}
                    </td>
                    <td align="center">
                        {{ $vehicle->type_fuel }}
                    </td>
                    <td align="center">
                        {{ $vehicle->days_worked }}
                    </td>
                    <td align="center">
                        {{ $vehicle->percent_worked }}
                    </td>
                    <td align="center">
                        {{ $vehicle->days_no_worked }}
                    </td>
                    <td align="center">
                        {{ $vehicle->percent_no_worked }}
                    </td>
                </tr>
            @endforeach
            <tr> <td style="height: 50px"></td></tr>
            @if (count($vehicles) > 0)
            <tr>
                <td colspan="{{count($headers)}}">
                    @include('Reports.Footer')
                </td>
            </tr>
            @endif

        </tbody>
    </table>
@endsection
