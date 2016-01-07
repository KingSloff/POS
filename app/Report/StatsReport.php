<?php

namespace App\Report;

use Illuminate\Database\Eloquent\Model;

use App\Sale;
use App\Stock;

class StatsReport extends Report
{
	/**
	 * Constructor to initialize attributes
	 */
	public function __construct()
	{
        $this->income = $this->income();
        $this->expenses = $this->expenses();
        $this->profit = $this->profit();
		$this->profit_percentage = $this->profit_percentage();
	}

    /**
     * Get the total income
     *
     */
    public function income()
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
     * Get the total expenses
     *
     */
    public function expenses()
    {
        return Stock::sum('cost');
    }

    /**
     * Get the total profit
     *
     */
    public function profit()
    {
        return $this->income - $this->expenses;
    }

    /**
     * Get the total profit percentage
     *
     */
    public function profit_percentage()
    {
        return $this->profit / $this->expenses * 100;
    }
}
