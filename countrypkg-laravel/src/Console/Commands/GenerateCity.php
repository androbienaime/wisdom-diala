<?php

namespace WisdomDiala\Countrypkg\Console\Commands;

// use App\Customs\GenerateMethod;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use WisdomDiala\Citypkg\Models\City;
use WisdomDiala\Countrypkg\Models\State;

class GenerateStates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'g:ci {state}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate all states around the world and store in the database';

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
    	$response = file_get_contents(__DIR__.'/../../resources/files/cities.json');
		$states = json_decode($response);
       
        $state= $this->argument('state');
        $count_city = 0;
        if ($state == 'all') {
        	
			if ($city != null) {
				$no_of_cities = count($city);
				for($i = 0; $i < $no_of_cities; $i++) {
					$check_city = City::where(['name' => $city[$i]->name, 'state_id' => $city[$i]->state_id])->count();
					if ($check_city <= 0) {
						City::create([
							'state_id' => $city[$i]->state_id,
							'name' => $city[$i]->name
						]);
						++$count_city;
						$city_r = $city[$i]->name;
						$this->info("$city_r");
					}
				}
			}
			

		}else{
			if ($city != null) {
				$no_of_city = count($city);
				$state_db = State::where('name', $state)->first();
				if ($state_db != null) {
					$this->info("Generating City for $state...");
					for($i = 0; $i < $no_of_city; $i++) {
						$check_city = City::where(['name' => $city[$i]->name, 'state_id' => $sate_db->id])->count();
						if ($check_city <= 0) {
							if ($state_db->id == $city[$i]->state_id) {
								State::create([
									'state_id' => $state_db->id,
									'name' => $city[$i]->name
								]);
								++$count_city;
								$city_r = $city[$i]->name;
								$this->info("$city_r");
							}
						}
						
					}
				}else{
					dd("Ooops! No record found for the state you entered.");
				}
			}
		}

		$this->info("$count_city states generated for $state.");
	
    }
}
