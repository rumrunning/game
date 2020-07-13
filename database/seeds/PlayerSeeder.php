<?php

use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder {

    public function run()
    {
        $user = \App\User::updateOrCreate([
            'email' => 'jon@jrd.io',
        ], [
            'name' => 'Cuddles',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        foreach (config('game.actions.skilled') as $skilledAction) {
            \App\SkillSet::updateOrCreate([
                'user_id' => $user->getKey(),
                'class' => $skilledAction
            ]);
        }

        foreach (config('game.timers') as $type) {
            \App\Timer::updateOrCreate([
                'user_id' => $user->getKey(),
                'type' => $type
            ]);
        }
    }
}