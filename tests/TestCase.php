<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function crimes()
    {
        return require base_path('tests/Unit/config/crimes.php');
    }
}
