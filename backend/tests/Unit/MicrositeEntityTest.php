<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\Microsite;

class MicrositeEntityTest extends TestCase
{
    public function testAddingMicrositeImageUrls()
    {
        $microsite = factory(Microsite::class)->create();
        $this->assertIsInt($microsite->pic_1);
        $this->assertIsInt($microsite->pic_2);
        $this->assertIsInt($microsite->pic_3);

        $this->assertIsObject($microsite->fundsRaisedImageUrls());
    }
}
