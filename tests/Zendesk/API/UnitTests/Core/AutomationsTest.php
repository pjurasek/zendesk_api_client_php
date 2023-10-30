<?php

namespace Zendesk\API\UnitTests\Core;

use GuzzleHttp\Psr7\Response;
use Zendesk\API\UnitTests\BasicTest;

/**
 * Automations test class
 */
class AutomationsTest extends BasicTest
{
    protected $testResource0;
    protected $testResource1;
    protected $testResource2;

    public function setUp()
    {
        $this->testResource0 = ['anyField'  => 'Any field 0'];
        $this->testResource1 = ['anyField'  => 'Any field 1'];
        parent::setUp();
    }

    public function testIterator()
    {
        // CBP
        $this->mockApiResponses([
            new Response(200, [], json_encode([
                'automations' => [$this->testResource0, $this->testResource1],
                'meta' => ['has_more' => false],

            ]))
        ]);

        $iterator = $this->client->automations()->iterator();

        $actual = iterator_to_array($iterator);
        $this->assertCount(2, $actual);
        $this->assertEquals($this->testResource0['anyField'], $actual[0]->anyField);
        $this->assertEquals($this->testResource1['anyField'], $actual[1]->anyField);
    }


    /**
     * Test we can use endpoint to get active automations
     */
    public function testActive()
    {
        $this->assertEndpointCalled(function () {
            // TODO: let's test this
            $this->client->automations()->findActive();
        }, 'automations/active.json');
    }
}
