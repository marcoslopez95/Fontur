<table>
    <tr>
        <td colspan="2">
            <b>Total de vehículos: </b>{{ count($vehicles) }}
        </td>
        <td colspan="2">
            <b>Total por Tipo de Combustible:</b>
            <br>
            @foreach ($count_type_fuel as $item => $key)
                {{ $item }} : {{ $key }} <br>
            @endforeach
        </td>
    </tr>
    <tr>
        <td style="height: 25px"></td>
    </tr>
    <tr>
        <td align='center'>
            <b>Promedio de días trabajados: </b> <br>{{ number_format($acum_days_worked / count($vehicles), 2) }}
        </td>
        <td align='center'>
            <b>Promedio de días NO trabajados: </b><br>
            {{ number_format($acum_not_days_worked / count($vehicles), 2) }}
        </td>
        <td align='center'>
            <b>Promedio % de días trabajados: </b> <br>{{ number_format($acum_percent_worked / count($vehicles), 2) }}
        </td>
        <td align='center'>
            <b>Promedio % de días NO trabajados: </b><br>
            {{ number_format($acum_not_percent_worked / count($vehicles), 2) }}
        </td>

    </tr>
</table>
