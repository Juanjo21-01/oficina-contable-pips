<?php

namespace App\Http\Controllers;

use App\Models\Tramite;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // RUTA PRINCIPAL
    public function index()
    {
        // total de tramites y clientes, siempre y cuando estén activos
        $totalTramites = Tramite::where('estado', 1)->count();
        $totalClientes = Cliente::where('estado', 1)->count();

        // Calcular el gasto total del último mes
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();
        $gastoTotal = Tramite::where('estado', 1)
            ->whereBetween('fecha', [$inicioMes, $finMes])
            ->sum('precio') - Tramite::where('estado', 1)
            ->whereBetween('fecha', [$inicioMes, $finMes])
            ->sum('gastos');

        // Últimos registros de tramites y clientes
        $ultimosTramites = Tramite::with(['cliente:id,nombres,apellidos', 'tipoTramite:id,nombre'])
            ->latest()
            ->take(5)
            ->get(['id', 'cliente_id', 'tipo_tramite_id', 'precio', 'fecha', 'estado']);

        $ultimosClientes = Cliente::latest()
            ->take(5)
            ->get(['id', 'nombres', 'apellidos', 'email', 'telefono', 'estado']);

        // Datos para la gráfica
        $tramitesPorMes = Tramite::where('estado', 1)->selectRaw('DATE_FORMAT(fecha, "%Y-%m") as mes, COUNT(*) as cantidad')
            ->where('fecha', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('mes')
            ->pluck('cantidad', 'mes')
            ->toArray();

        $clientesPorMes = Cliente::where('estado', 1)->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, COUNT(*) as cantidad')
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('mes')
            ->pluck('cantidad', 'mes')
            ->toArray();

        $tramitesData = [];
        $clientesData = [];

        // Obtener los últimos 6 meses
        $mesesDato = collect();
        for ($i = 5; $i >= 0; $i--) {
            $mesesDato->push(Carbon::now()->subMonths($i)->format('Y-m'));
        }
        foreach ($mesesDato as $mes) {
            $mesKey = Carbon::parse($mes)->format('Y-m');
            $tramitesData[] = $tramitesPorMes[$mesKey] ?? 0;
            $clientesData[] = $clientesPorMes[$mesKey] ?? 0;
        }

        $meses = collect();
        for ($i = 5; $i >= 0; $i--) {
            $meses->push(Carbon::now()->subMonths($i)->locale('es')->isoFormat('MMMM YYYY'));
        }

        $chartData = [
            'labels' => $meses,
            'datasets' => [
                [
                    'label' => 'Trámites',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'data' => $tramitesData,
                ],
                [
                    'label' => 'Clientes',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'data' => $clientesData,
                ],
            ],
        ];

        return view('dashboard', compact('totalTramites', 'totalClientes', 'gastoTotal', 'ultimosTramites', 'ultimosClientes', 'chartData'));
    }
}
