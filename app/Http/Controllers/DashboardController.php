<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\FinancialTransaction;
use App\Models\Event;
use App\Models\ChurchEvent; // Keeping for now if needed, but intended to remove
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:dashboard.view');
    }

    public function index()
    {
        $metrics = $this->getMetrics();

        return view('admin.dashboard', compact('metrics'));
    }

    private function getMetrics()
    {
        return [
            'active_members' => $this->getActiveMembers(),
            'total_donations' => $this->getTotalDonations(),
            'total_events' => $this->getTotalEvents(),
            'total_baptisms' => $this->getTotalBaptisms(),
            'donations_chart' => $this->getDonationsChartData(),
            'events_chart' => $this->getEventsChartData(),
            'baptisms_chart' => $this->getBaptismsChartData(),
        ];
    }

    private function getActiveMembers()
    {
        return Cache::remember('dashboard.active_members', 3600, function () {
            return Member::whereNull('deleted_at')->count();
        });
    }

    private function getTotalDonations()
    {
        return Cache::remember('dashboard.total_donations', 3600, function () {
            return FinancialTransaction::income()->sum('amount');
        });
    }

    private function getTotalEvents()
    {
        return Cache::remember('dashboard.total_events', 3600, function () {
            return Event::count();
        });
    }

    private function getTotalBaptisms()
    {
        return Cache::remember('dashboard.total_baptisms', 3600, function () {
            return Member::whereNotNull('baptism_date')->count();
        });
    }

    private function getDonationsChartData()
    {
        return Cache::remember('dashboard.donations_chart', 3600, function () {
            // Dados para gráfico de barras/linhas: doações por mês
            $driver = \Illuminate\Support\Facades\DB::getDriverName();
            $dateSelect = $driver === 'sqlite' 
                ? "strftime('%Y', transaction_date) as year, strftime('%m', transaction_date) as month"
                : "YEAR(transaction_date) as year, MONTH(transaction_date) as month";

            $data = FinancialTransaction::selectRaw($dateSelect . ', SUM(amount) as total')
                ->income()
                ->where('transaction_date', '>=', now()->subMonths(12))
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();

            $labels = [];
            $values = [];
            foreach ($data as $item) {
                $labels[] = $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                $values[] = $item->total;
            }

            return ['labels' => $labels, 'data' => $values];
        });
    }

    private function getEventsChartData()
    {
        return Cache::remember('dashboard.events_chart', 3600, function () {
            // Gráfico de pizza: eventos por categoria
            $data = Event::selectRaw('COUNT(*) as count, title')
                ->groupBy('title')
                ->get();

            $labels = $data->pluck('title')->toArray();
            $values = $data->pluck('count')->toArray();

            return ['labels' => $labels, 'data' => $values];
        });
    }

    private function getBaptismsChartData()
    {
        return Cache::remember('dashboard.baptisms_chart', 3600, function () {
            // Gráfico de linhas: batismos por ano
            $driver = \Illuminate\Support\Facades\DB::getDriverName();
            $yearSelect = $driver === 'sqlite' 
                ? "strftime('%Y', baptism_date) as year"
                : "YEAR(baptism_date) as year";

            $data = Member::selectRaw($yearSelect . ', COUNT(*) as count')
                ->whereNotNull('baptism_date')
                ->groupBy('year')
                ->orderBy('year')
                ->get();

            $labels = $data->pluck('year')->toArray();
            $values = $data->pluck('count')->toArray();

            return ['labels' => $labels, 'data' => $values];
        });
    }
}