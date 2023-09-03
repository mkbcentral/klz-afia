<?php

namespace App\Console\Commands;

use App\Exports\ProductExport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class DownloadFromExcelData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exporttation data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename='Pruducts.xlsx';
        return Excel::download(new ProductExport,$filename);

    }
}
