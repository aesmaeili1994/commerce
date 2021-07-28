<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $month = 12;

        $successTransactions = Transaction::getData($month,1);
        $successTransactionsChart = $this->getChart($successTransactions,$month);

        $unsuccessTransactions = Transaction::getData($month,0);
        $unsuccessTransactionsChart = $this->getChart($unsuccessTransactions,$month);

        return view('admin.dashboard',[
            'successTransactions' => array_values($successTransactionsChart),
            'unsuccessTransactions' => array_values($unsuccessTransactionsChart),
            'labels' => array_keys($successTransactionsChart),
            'transactionsCount' => [$successTransactions->count() , $unsuccessTransactions->count()]
        ]);

    }

    public function getChart($transactions,$month)
    {
//        create array from Transaction->created_at
        $monthName = $transactions->map(function ($item){
            return verta($item->created_at)->format('%B %y');
        });

//        create array from Transaction->amount
        $amount = $transactions->map(function ($item){
            return $item->amount;
        });

//        create array from sum($monthName,$amount)
        foreach ($monthName as $i => $v){
            if (! isset($result[$v])) {
                $result[$v] = 0;
            }
            $result[$v] += $amount[$i];
        }

        if ($month != count($result)) {
            for ($i = 0 ; $i < $month ; $i++){
                $Name = verta()->subMonth($i)->format('%B %y');
                $shamsiMonths[$Name] = 0;
            }
            return array_reverse(array_merge($shamsiMonths,$result));
        }
        return $result;
    }
}
