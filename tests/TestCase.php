<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $uri = 'api/V1/';

    public $headers = [
        'content-type' => 'application/json',
        'accept' => 'application/json',
    ];
}
