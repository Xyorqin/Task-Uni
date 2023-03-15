<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'first:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info(">>>> You are reloading database tables. All tables is deleted !!! --------");


        if ($this->confirm('Do you wish to continue? (yes|no)[no]', true)) {

            /**
             * Database refresh
             */
            Artisan::call("migrate:fresh");

            /**
             * Run Permission seeder
             */
            Artisan::call("db:seed --class=RoleSeeder");

            /**
             * Run Role seeder
             */
            $role = $this->getAdminRole();

            /**
             * Run user seeder
             */
            $this->createUser($role->id);

            /**
             * Passport install
             */
            Artisan::call("passport:install");

            $this->info('Successfully installed');
            return Command::SUCCESS;
        }
    }

    public function getAdminRole()
    {
        return Role::where('slug', 'admin')->first();
    }

    public function createUser($role_id)
    {
        if (Schema::hasTable('users')) {
            if (User::count() == 0) {
                User::create([
                    'name'          => 'admin',
                    'phone_number'  => "+998914448867",
                    'role_id'       => $role_id,
                    'password'      => bcrypt('adminadmin'),
                ]);
            }
        }
        return true;
    }
}
