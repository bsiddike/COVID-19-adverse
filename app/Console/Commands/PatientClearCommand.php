<?php

namespace App\Console\Commands;

use App\Models\Patient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PatientClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patient:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @throws \Exception
     */
    public function handle()
    {
        try {
            $dates = array_unique(Patient::select('todays_date')->pluck('todays_date')->toArray());
            foreach ($dates as $date) {
                if (is_string($date)) {
                    if (DB::connection()
                        ->getPdo()
                        ->prepare("delete from `patients` where `todays_date` = '{$date}' limit 500, 100000")
                        ->execute()) {
                        $this->info("Date {$date} extra data deleted");
                    } else {
                        $this->error("Date {$date} extra data failed");
                    }
                }
            }
            return Command::SUCCESS;

        } catch (\Exception $exception) {
            throw  new \Exception($exception->getMessage());
            return Command::FAILURE;

        }
    }
}
