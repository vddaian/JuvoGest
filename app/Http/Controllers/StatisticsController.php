<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\PartnerUser;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    /* Funcion que redirige al apartado de estadisticas */
    public function index()
    {
        $incs = Incident::selectRaw('MONTH(fechaInc) mes, COUNT(*) numero')
            ->where('idUsuario', Auth::user()->id)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $months = $incs->pluck('mes')->map(function ($month) {
            return $this->translateMonth($month);
        })->toArray();
        $count = $incs->pluck('numero')->toArray();

        $chartInc = LarapexChart::areaChart()
            ->setTitle('Incidencias acumuladas')
            ->setSubtitle('Número de incidencias acumuladas por mes')
            ->addData('Incidencias', $count)
            ->setXAxis($months)
            ->setColors(['#D4DA1E']);


        $newPrts = PartnerUser::selectRaw('MONTH(fechaAlta) mes, COUNT(*) numero')
            ->where('idUsuario', Auth::user()->id)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $months = $newPrts->pluck('mes')->map(function ($month) {
            return $this->translateMonth($month);
        })->toArray();

        $count = $newPrts->pluck('numero')->toArray();
        
        $chartNew = LarapexChart::barChart()
            ->setTitle('Nuevos socios')
            ->setSubtitle('Número de nuevos socios por mes')
            ->addData('Socios', $count)
            ->setXAxis($months)
            ->setColors(['#D4DA1E']);

        return view('other.statistics')->with(
            'charts',
            [
                'chartInc' => $chartInc,
                'chartNew' => $chartNew
            ]
        );
    }

    /* Función que mediante el numero del mes recoge el nombre del mes al Español */
    public function translateMonth($num)
    {
        $months = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        return $months[$num] ?? '';
    }
}
