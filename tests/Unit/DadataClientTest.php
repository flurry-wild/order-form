<?php

namespace Tests\Unit;

use App\Clients\DadataClient;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class DadataClientTest extends TestCase
{
    /** @var DadataClient */
    private $client;

    protected function setUp(): void
    {
        $this->client = $this->getMockBuilder(DadataClient::class)
            ->setMethodsExcept(['getDadataAddressVariants'])
            ->setConstructorArgs([Config::get('dadata.token'), Config::get('dadata.secret')])
            ->getMock();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testOneDadataAddressVariant()
    {
        $this->client->expects($this->once())
            ->method('suggest')
            ->with("address", 'Москва, Красная Пресня 5', 4)
            ->willReturn(['unrestricted_value' => 'г Москва, ул Красная Пресня, д 13/5']);

        $variants = $this->client->getDadataAddressVariants('Москва, Красная Пресня 5');
        $this->assertIsArray($variants);
        $this->assertEquals(count($variants), 1);
    }

    public function testManyDadataAddressVariants()
    {
        $this->client->expects($this->once())
            ->method('suggest')
            ->with("address", 'Москва, Красная Пресня 5', 4)
            ->willReturn([
                ['unrestricted_value' => 'г Москва, ул Красная Пресня, д 13/5'],
                ['unrestricted_value' => 'г Москва, ул Красная Пресня, д 1 стр 5']
            ]);

        $variants = $this->client->getDadataAddressVariants('Москва, Красная Пресня 5');
        $this->assertIsArray($variants);
        $this->assertEquals(count($variants), 2);
    }
}
