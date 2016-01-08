<?php

namespace App\Report;

use App\Payment;
use App\Product;
use Illuminate\Database\Eloquent\Model;

use App\Sale;
use App\Stock;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;

class TrialBalanceReport extends Report
{
	/**
	 * Constructor to initialize attributes
	 */
	public function __construct()
	{
        $this->sales = $this->sales();
        $this->opening_inventory = $this->openingInventory();
        $this->closing_inventory = $this->closingInventory();
        $this->purchases = $this->purchases();
        $this->profit = $this->profit();

        $this->total_debit1 = $this->opening_inventory + $this->purchases;
        $this->total_credit1 = $this->sales + $this->closing_inventory;

        if($this->profit >= 0)
        {
            $this->total_debit1 += $this->profit;
        }
        else
        {
            $this->total_credit1 += abs($this->profit);
        }

        $this->total_debtors = $this->totalDebtors();
        $this->total_creditors = $this->totalCreditors();
        $this->cumulative_profit = $this->cumulativeProfit();

        $this->cash = $this->cash();

        $this->total_debit2 = $this->cash + abs($this->total_debtors) + $this->closing_inventory;
        $this->total_credit2 = $this->total_creditors;

        if($this->cumulative_profit < 0)
        {
            $this->total_debit2 += abs($this->cumulative_profit);
        }
        else
        {
            $this->total_credit2 += $this->cumulative_profit;
        }

	}

    /**
     * Get the total income from sales
     *
     */
    public function sales()
    {
        $income = 0;

        $sales = Sale::get();

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
        $openingInventory = DB::table('reports')->where('description', 'OpeningInventory')->first();

        return $openingInventory->value;
    }

    /**
     * Get the total purchases
     *
     */
    public function purchases()
    {
        return Stock::sum('cost');
    }

    /**
     * Get the closing inventory
     *
     */
    public function closingInventory()
    {
        $stocks = Stock::hasStock()->get();

        $result = 0;

        foreach($stocks as $stock)
        {
            $result += $stock->cpu * $stock->in_stock;
        }

        return $result;
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
     * Total owed by debtors
     */
    public function totalDebtors()
    {
        return User::where('balance', '<', 0)->sum('balance');
    }

    /**
     * Total owed by debtors
     */
    public function totalCreditors()
    {
        return User::where('balance', '>', 0)->sum('balance');
    }

    /**
     * Cumulative profit
     */
    public function cumulativeProfit()
    {
        return config('default.starting_cash') + $this->profit;
    }

    /**
     * Get cash
     */
    public function cash()
    {
        $startingCash = config('default.starting_cash');

        $stockCost = Stock::sum('cost');

        $amountLoaned = abs(Payment::where('amount', '<', 0)->sum('amount'));
        $amountPaid = Payment::where('amount', '>', 0)->sum('amount');

        $cashSales = Sale::where('user_id', null)->get();
        $totalCashSales = 0;

        foreach($cashSales as $cashSale)
        {
            $totalCashSales += $cashSale->total;
        }

        return $startingCash + $amountPaid + $totalCashSales - $stockCost - $amountLoaned;
    }
}
