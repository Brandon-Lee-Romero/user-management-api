<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        
        /* allows you to disable exception handling during the execution of a test case */
        $this->withoutExceptionHandling();
    }
}
