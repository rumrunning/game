<?php

namespace App\RumRunning\Crimes;

class CrimeFactory {

    public static function createFromArray(array $crimes) : CrimeCollection
    {
        return (new CrimeCollection($crimes))
            ->map(function ($crime) {
                return new Crime(
                    $crime['code'],
                    $crime['description'],
                    $crime['difficulty'],
                    $crime['outcomes']
                );
            })
        ;
    }
}