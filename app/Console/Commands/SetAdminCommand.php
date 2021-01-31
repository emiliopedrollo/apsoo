<?php

namespace App\Console\Commands;

use App\Events\UserSetAsAdmin;
use App\Events\UserUnsetAsAdmin;
use App\Models\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SetAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:admin';

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
        $this->addArgument('user',InputArgument::REQUIRED,"The use e-mail");
        $this->addOption('remove','r',InputOption::VALUE_NONE,"If set, remove user status as admin");
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (($user = User::find($id = $this->argument('user'))) === null) {
            $this->error(sprintf("Could not find a user with id %d",$id));
            return 1;
        }

        $desire = !$this->option('remove');

        if ($user->admin == $desire) {
            $this->warn(sprintf("User %s (%s) is already%san admin",
                $user->name,$user->email, $desire ? ' ' : ' not '
            ));
            return 0;
        }

        $this->info(sprintf("%s user %s (%s) as admin",
            $desire ? "Setting" : "Unsetting", $user->name, $user->email));

        $user->unguard();
        $user->update([
            'admin' => $desire
        ]);
        $user->reguard();
        if ($desire) {
            event(new UserSetAsAdmin($user));
        } else {
            event(new UserUnsetAsAdmin($user));
        }
        return 0;
    }
}
