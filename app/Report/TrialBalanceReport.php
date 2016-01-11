<?php

namespace App\Report;

use App\Bank;
use App\Payment;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Sale;
use App\Stock;
use Illuminate\Support\Facades\DB;

class TrialBalanceReport extends Report
{
    /**
     * Constructor to initialize attributes
     * @param $from
     * @param $to
     */
	public function __construct($from, $to)
	{
        $this->from = ($from == null) ? Carbon::minValue() : new Carbon($from);
        $this->to = ($to == null) ? Carbon::maxValue() : new Carbon($to);

        $this->from = $this->from->firstOfMonth();
        $this->to = $this->to->lastOfMonth();

        $this->sales = $this->sales();
        $this->opening_inventory = $this->openingInventory();
        $this->closing_inventory = $this->closingInventory();
        $this->purchases = $this->purchases();
        $this->profit = $this->profit();

        $this->total_debtors = $this->totalDebtors();
        $this->total_creditors = $this->totalCreditors();

        $this->cash = $this->cash();
        $this->bank = $this->bank();
	}

    /**
     * Get the total income from sales
     *
     */
    public function sales()
    {
        $income = 0;

        $sales = Sale::dateRange($this->from, $this->to)->get();

        foreach ($sales as $sale)
        {
            $income += $sale->total;
        }

        return $income;
    }

    /**
     * Get the opening inventory
     *
     */
    public function openingInventory()
    {
        $stocksValue = Stock::dateRangeTo($this->from)->sum('cost');
        $salesValue = Sale::dateRangeTo($this->from)->sum(DB::raw('`cpu` * `amount`'));

        return $stocksValue - $salesValue;
    }

    /**
     * Get the total purchases
     *
     */
    public function purchases()
    {
        return Stock::dateRange($this->from, $this->to)->sum('cost');
    }

    /**
     * Get the closing inventory
     *
     */
    public function closingInventory()
    {
        $stocksValue = Stock::dateRangeTo($this->to)->sum('cost');
        $salesValue = Sale::dateRangeTo($this->to)->sum(DB::raw('`cpu` * `amount`'));

        return $stocksValue - $salesValue;
    }

    /**
     * Get the total profit
     *
     */
    public function profit()
    {
        return $this->sales - $this->opening_inventory - $this->purchases + $this->closing_inventory;
    }

    /**
     * Get the first total debits
     */
    public function totalDebits1()
    {
        $result = $this->opening_inventory + $this->purchases;

        if($this->profit >= 0)
        {
            $result += $this->profit;
        }

        return $result;
    }

    /**
     * Get the first total credits
     */
    public function totalCredits1()
    {
        $result = $this->sales + $this->closing_inventory;

        if($this->profit < 0)
        {
            $result += abs($this->profit);
        }

        return $result;
    }

    /**
     * Total owed by debtors
     */
    public function totalDebtors()
    {
        $users = User::dateRangeTo($this->to)->with('sales', 'payments')->get();

        $total = 0;

        foreach($users as $user)
        {
            $initialBalance = $user->initial_balance;

            $payments = $user->payments()->dateRangeTo($this->to)->sum('amount');

            $sales = $user->sales()->dateRangeTo($this->to)
                ->sum(DB::raw('`price` * `amount`'));

            $totalUser = $initialBalance + $payments - $sales;

            if($totalUser < 0)
                $total += $totalUser;
        }

        return $total;
    }

    /**
     * Total owed by debtors
     */
    public function totalCreditors()
    {
        $users = User::with('sales', 'payments')->get();

        $total = 0;

        foreach($users as $user)
        {
            $initialBalance = $user->initial_balance;

            $payments = $user->payments()->dateRangeTo($this->to)->sum('amount');

            $sales = $user->sales()->dateRangeTo($this->to)
                ->sum(DB::raw('`price` * `amount`'));

            $totalUser = $initialBalance + $payments - $sales;

            if($totalUser > 0)
                $total += $totalUser;
        }

        return $total;
    }

    /**
     * Cumulative profit
     */
    public function cumulativeProfit()
    {
        $tmpTrialBalanceReport = new TrialBalanceReport(Carbon::minValue()->toDateString(), $this->to);

        return config('default.starting_cash') + config('default.starting_bank') + $tmpTrialBalanceReport->profit;
    }

    /**
     * Get cash
     */
    public function cash()
    {
        $startingCash = config('default.starting_cash');

        $stockCost = Stock::dateRangeTo($this->to)->sum('cost');

        $amountLoaned = abs(Payment::dateRangeTo($this->to)->where('amount', '<', 0)->sum('amount'));
        $amountPaid = Payment::dateRangeTo($this->to)->where('amount', '>', 0)->sum('amount');

        $cashSales = Sale::dateRangeTo($this->to)->where('user_id', null)->get();
        $totalCashSales = 0;

        foreach($cashSales as $cashSale)
        {
            $totalCashSales += $cashSale->total;
        }

        $initialBalances = User::dateRangeTo($this->to)->sum('initial_balance');

        $paymentsToBank = Bank::dateRangeTo($this->to)->sum('amount');

        return $startingCash + $amountPaid + $totalCashSales + $initialBalances - $stockCost - $amountLoaned -
            $paymentsToBank;
    }

    /**
     * Get amount in bank
     */
    public function bank()
    {
        return config('default.starting_bank') + Bank::dateRangeTo($this->to)->sum('amount');
    }

    /**
     * Get the second total debits
     */
    public function totalDebits2()
    {
        $result = $this->cash + $this->bank + abs($this->total_debtors) + $this->closing_inventory;

        if($this->cumulativeProfit() < 0)
        {
            $result += abs($this->cumulativeProfit());
        }

        return $result;
    }

    /**
     * Get the second total credits
     */
    public function totalCredits2()
    {
        $result = $this->total_creditors;

        if($this->cumulativeProfit() > 0)
        {
            $result += $this->cumulativeProfit();
        }

        return $result;
    }
}
