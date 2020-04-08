<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Libraries\Facebook;
use Illuminate\Support\Facades\Log;

class FacebookLibraryTest extends TestCase
{
    /**
     * A test for erroring when scraping the opengraph data.
     *
     * @return void
     */
    public function testScrapingOpenGraphDataException()
    {
        Log::shouldReceive('error')
            ->twice();

        Facebook::executeOpenGraphScrape('');
    }
}
