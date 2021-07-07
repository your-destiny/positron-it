<?php

namespace App\Console\Commands;

use App\Containers\Books\Actions\UpdateBooksWithRelationsAction;
use Illuminate\Console\Command;

class UpdateBooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновить книги с url';

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
        app(UpdateBooksWithRelationsAction::class);
        $this->info('книги успешно обновлены с url');
    }
}
