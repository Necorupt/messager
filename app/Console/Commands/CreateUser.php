<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if(User::where('email',$this->argument('email'))->count() != 0){
            $this->error('Email already exists');
            return;
        };
        $user = User::create(
            ['name' => $this->argument('name'),
            'email' => $this->argument('email'), 
            'password' => $this->argument('password')
        ]);

        $this->info('Created user name:\t' . $user->name . '\temail' . $user->email);
    }
}
