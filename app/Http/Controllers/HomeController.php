<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $monthlyBalanceByMethod = $this->getMethodBalance()->get('monthlyBalanceByMethod');
        $monthlyBalance = $this->getMethodBalance()->get('monthlyBalance');

        $anualsales = $this->getAnnualSales();
        $anualclients = $this->getAnnualClients();
        $anualproducts = $this->getAnnualProducts();

        return view('dashboard', [
            'monthlybalance'            => $monthlyBalance,
            'monthlybalancebymethod'    => $monthlyBalanceByMethod,
            'lasttransactions'          => [],
            'unfinishedsales'           => [],
            'anualsales'                => $anualsales,
            'anualclients'              => $anualclients,
            'anualproducts'             => $anualproducts,
            'lastmonths'                => array_reverse($this->getMonthlyTransactions()->get('lastmonths')),
            'lastincomes'               => $this->getMonthlyTransactions()->get('lastincomes'),
            'lastexpenses'              => $this->getMonthlyTransactions()->get('lastexpenses'),
            'semesterexpenses'          => $this->getMonthlyTransactions()->get('semesterexpenses'),
            'semesterincomes'           => $this->getMonthlyTransactions()->get('semesterincomes')
        ]);
    }

    public function getMethodBalance()
    {
        $methods = [];
        $monthlyBalanceByMethod = [];
        $monthlyBalance = 0;

        foreach ($methods as $method) {
            $balance = 2000;
            $monthlyBalance += (float) $balance;
            $monthlyBalanceByMethod[$method->name] = $balance;
        }
        return collect(compact('monthlyBalanceByMethod', 'monthlyBalance'));
    }

    public function getAnnualSales()
    {
        $sales = [];
        foreach(range(1, 12) as $i) {
            $monthlySalesCount = 23;

            array_push($sales, $monthlySalesCount);
        }
        return "[" . implode(',', $sales) . "]";
    }

    public function getAnnualClients()
    {
        $clients = [];
        foreach(range(1, 12) as $i) {
            $monthclients = (object)[
                'total' => 23
            ];

            array_push($clients, $monthclients->total);
        }
        return "[" . implode(',', $clients) . "]";
    }

    public function getAnnualProducts()
    {
        $products = [];
        foreach(range(1, 12) as $i) {
            $monthproducts = 45;

            array_push($products, $monthproducts);
        }
        return "[" . implode(',', $products) . "]";
    }

    public function getMonthlyTransactions()
    {
        $actualmonth = Carbon::now();

        $lastmonths = [];
        $lastincomes = '';
        $lastexpenses = '';
        $semesterincomes = 10000;
        $semesterexpenses = 0;

        foreach (range(1, 6) as $i) {
            array_push($lastmonths, $actualmonth->shortMonthName);

            $incomes = 56;

            $semesterincomes += $incomes;
            $lastincomes = round($incomes).','.$lastincomes;

            $expenses = abs(780);

            $semesterexpenses += $expenses;
            $lastexpenses = round($expenses).','.$lastexpenses;

            $actualmonth->subMonth(1);
        }

        $lastincomes = '['.$lastincomes.']';
        $lastexpenses = '['.$lastexpenses.']';

        return collect(compact('lastmonths', 'lastincomes', 'lastexpenses', 'semesterincomes', 'semesterexpenses'));
    }
}
