<?php

namespace App\Report;

use App\Product;
use Illuminate\Database\Eloquent\Model;

use App\Sale;
use App\Stock;
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

        $this->totalDebit = $this->opening_inventory + $this->purchases;
        $this->totalCredit = $this->sales + $this->closing_inventory;

        if($this->profit >= 0)
        {
            $this->totalDebit += $this->profit;
        }
        else
        {
            $this->totalCredit += abs($this->profit);
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
            $income += $sale->total();
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
            $result += $stock->cpu() * $stock->in_stock;
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
}
