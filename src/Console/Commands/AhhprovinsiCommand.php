<?php namespace Satudata\Ahhprovinsi\Console\Commands;

use Illuminate\Console\Command;

/**
 * The AhhprovinsiCommand class.
 *
 * @package Satudata\Ahhprovinsi
 * @author  MKI <info@mkitech.net>
 */
class AhhprovinsiCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'satudata:ahhprovinsi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Controllers, Models, seeds, and Routes command for Modul AHHProvinsi Satudata package';

    /**
     * The console command variable.
     *
     * @var string
     */
    protected $stubsController = [
        'controllers' => [
            'AhhprovinsiController.stub'
        ]
    ];
    protected $stubsModel = [
        'models' => [
            'AhhProvinsi.stub',
            'MasterWilayah.stub'
        ]
    ];
    protected $stubsSeeds = [
        'seeds' => [
            'MasterKotaSeeder.stub',
            'MasterProvinsiSeeder.stub'
        ]
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    protected function controllerViewCreate()
    {
        foreach($this->stubsController['controllers'] as $stub)
        {
            File::put(base_path('app/Http/Controllers/').str_replace('stub','php',$stub),File::get(__DIR__.'/../../stubs/Controllers/'.$stub));
        }
    }
    protected function modelViewCreate()
    {
        foreach($this->stubsModel['models'] as $stub)
        {
            File::put(base_path('app/').str_replace('stub','php',$stub),File::get(__DIR__.'/../../stubs/Models/'.$stub));
        }
    }
    protected function routeViewCreate()
    {
        File::append(base_path('routes/web.php'),File::get(__DIR__.'/../../stubs/routesweb.stub'));
    }
    protected function seedsViewCreate()
    {
        foreach($this->stubsSeeds['seeds'] as $stub)
        {
            File::put(base_path('database/seeds/').str_replace('stub','php',$stub),File::get(__DIR__.'/../../stubs/seeds/'.$stub));
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->controllerViewCreate();
        $this->modelViewCreate();
        $this->routeViewCreate();
        $this->seedsViewCreate();
        $this->info('Create Controllers, Models, seeds, and Routes command for Modul AHHProvinsi Satudata package success');
    }
}
