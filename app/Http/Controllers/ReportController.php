<?php

namespace App\Http\Controllers;

use App\Jobs\SendDebtorEmail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Report\StatsReport;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Display the stats report
     */
    public function stats()
    {
        $report = new StatsReport();

        return view('reports.report.stats', compact('report'));
    }

    /**
     * Display all the debtors
     */
    public function debtors()
    {
        $users = User::hasDebt()->sortable()->get();

        return view('reports.report.debtors', compact('users'));
    }

    /**
     * Send email to debtors
     */
    public function sendDebtorEmail()
    {
        $users = User::hasDebt()->sortable()->get();

        foreach($users as $user)
        {
            $this->dispatch(new SendDebtorEmail($user));
        }

        return redirect()->route('report.debtors')->with('success', 'Emails sent');
    }
}
