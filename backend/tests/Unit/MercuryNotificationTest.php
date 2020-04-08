<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Libraries\MercuryNotification;
use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MercuryNotificationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A test for setting recipients.
     *
     * @return void
     */
    public function testSettingRecipients()
    {
        $user    = User::first();
        $mercury = new MercuryNotification(null, null);

        $this->assertEmpty($mercury->getRecipients());
        $mercury->setRecipients([$user]);

        $this->assertContains($user, $mercury->getRecipients());
    }

    /**
     * A test for adding a recipient.
     *
     * @return void
     */
    public function testAddingRecipient()
    {
        $user    = User::first();
        $mercury = new MercuryNotification(null, null);

        $this->assertEmpty($mercury->getRecipients());
        $mercury->setRecipients(['foo']);
        $mercury->addRecipient($user);

        $this->assertContains($user, $mercury->getRecipients());
    }

    /**
     * A test for adding recipients.
     *
     * @return void
     */
    public function testAddingRecipients()
    {
        $mercury = new MercuryNotification(null, null);

        $this->assertEmpty($mercury->getRecipients());

        $mercury->setRecipients(['foo']);
        $mercury->addRecipients(['bar']);

        $this->assertContains('foo', $mercury->getRecipients());
        $this->assertContains('bar', $mercury->getRecipients());
    }
}
