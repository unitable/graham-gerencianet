<?php

namespace Unitable\GrahamGerencianet\Tests;

use Orchestra\Testbench\TestCase;
use Unitable\GrahamGerencianet\GrahamGerencianetServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [GrahamGerencianetServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
