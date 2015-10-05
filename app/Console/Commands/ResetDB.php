<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class ResetDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set database tables auto increment back to the next value';

    protected $db;

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tables = ['users', 'products'];

        foreach($tables as $table)
        {
            DB::statement('ALTER TABLE '.$table.' AUTO_INCREMENT = 0');
        }
    }
}
