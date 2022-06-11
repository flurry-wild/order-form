<?php

namespace Tests\Unit;

use App\Clients\DadataClient;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class DadataClientTest extends TestCase
{
    /** @var DadataClient */
    private $client;

    /**
     * @return void
     */
    protected function setUp() {
        $this->client = $this->getMockBuilder(DadataClient::class)
            ->setMethodsExcept(['getDadataAddressVariants'])
            ->setConstructorArgs([Config::get('dadata.token'), Config::get('dadata.secret')])
            ->getMock();
    }

    /**
     * @return array[]
     */
    public function dataProvider() {
        return [
            [
                ['unrestricted_value' => 'г Москва, ул Красная Пресня, д 13/5'],
                1
            ],
            [
                [
                    ['unrestricted_value' => 'г Москва, ул Красная Пресня, д 13/5'],
                    ['unrestricted_value' => 'г Москва, ул Красная Пресня, д 1 стр 5'],
                ],
                2
            ]
        ];
    }

    /**
     * Test check getting address variants
     *
     * @dataProvider dataProvider
     *
     * @param array $suggestValue
     * @param int   $countOfVariants
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testOneDadataAddressVariant(array $suggestValue, int $countOfVariants) {
        $this->client->expects($this->once())
            ->method('suggest')
            ->with("address", 'Москва, Красная Пресня 5', 4)
            ->willReturn($suggestValue);

        $variants = $this->client->getDadataAddressVariants('Москва, Красная Пресня 5');
        $this->assertIsArray($variants);
        $this->assertEquals(count($variants), $countOfVariants);
    }
}
