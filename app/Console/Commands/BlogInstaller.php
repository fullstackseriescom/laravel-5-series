<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class BlogInstaller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the blog';

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
     * @return mixed
     */
    public function handle()
    {
        $this->line('Let\'s install the blog!');
        $this->line(' ');

        $this->call('config:cache');

        $this->info("Database configuration...");
        $dbName = $this->ask('Enter the database name');
        $dbUser = $this->ask('Enter the database user', 'root');
        $dbPassword = $this->ask('Enter the database password', false);
        if($dbPassword == false) {
            $dbPassword = '';
        }

        // http://laravel-tricks.com/tricks/change-the-env-dynamically
        $env_update = $this->changeEnv([
            'DB_DATABASE'   => $dbName,
            'DB_USERNAME'   => $dbUser,
            'DB_PASSWORD'   => $dbPassword
        ]);

        if ( $env_update ) {
            $this->call('migrate');
            $this->call('db:seed');
            $this->line('Tables and fake data were created!');
            $this->line('You can see the user in the database. Every test user has the same password that it is 123456.');
            $this->line(' ');

            $this->info('Publishing vendor packages...');
            $this->call('vendor:publish');
            $this->line(' ');

            $this->info('Installing npm packages and compiling assets...');
            system('npm install');
            $this->line('npm packages installed!');
            system('npm run dev');
            $this->line('Assests compiled as development environment! If you have in production you will have to run npm run prod!');
            $this->line(' ');
        
            $this->line('Blog installed!');
        } else {
            $this->line('Error!');
        }

    }

    // http://laravel-tricks.com/tricks/change-the-env-dynamically
    protected function changeEnv($data = array()){
        if(count($data) > 0){

            $filenameEnv = (file_exists(base_path(".env"))) ? '.env' : '.env.example';

            // Read .env-file
            $env = file_get_contents(base_path() . '/'.$filenameEnv);

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);;

            // Loop through given data
            foreach((array)$data as $key => $value){

                // Loop through .env-data
                foreach($env as $env_key => $env_value){

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if($entry[0] == $key){
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/'.$filenameEnv, $env);
            
            return true;
        } else {
            return false;
        }
    }
}
