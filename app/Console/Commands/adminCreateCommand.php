<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class adminCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the admin in the admins table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admin['name'] = $this->ask('name of this admin');
        $admin['email'] = $this->ask('email of this admin');
        $admin['password'] = $this->secret('enter password');

        $validator = Validator::make($admin, [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', Password::default()]
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return -1;
        }

        DB::transaction(function () use ($admin) {
            $admin['password'] = Hash::make($admin['password']);
            Admin::create($admin);
        });

        $this->info($admin['email'] . '' . 'created successfully');

        return 0;
    }
}
