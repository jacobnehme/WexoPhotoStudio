<?php

namespace Tests\Unit;

use App\Photo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    //TODO tests needs refactoring
    public function testApprove()
    {
        $photo = Photo::Create([
            'product_id' => 1
        ]);
        $photo->approve();
        $this->assertTrue($photo->status);
        $photo->delete();
    }

    public function testReject()
    {
        $photo = Photo::Create([
            'product_id' => 1
        ]);
        $photo->reject();
        $this->assertFalse($photo->status);
        $photo->delete();
    }
}
