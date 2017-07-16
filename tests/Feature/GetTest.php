<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetTest extends TestCase
{

    public function testLanguages()
    {
        $response = $this->get('/languages');
        $response->assertStatus(200);
    }

}

