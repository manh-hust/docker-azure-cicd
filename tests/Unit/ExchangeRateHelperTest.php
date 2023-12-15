<?php

namespace Tests\Unit;

use App\Helpers\ExchangeRateHelper;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ExchangeRateHelperTest extends TestCase
{
    /**
     * @dataProvider supportedExchangeRates
     */
    public function test_that_supported_rates_are_returned($currency)
    {
        $returnedRates = ExchangeRateHelper::getRatesForCurrency($currency);
        $expectedLength = count(ExchangeRateHelper::getSupportedCurrencies()) - 1;
        $actualLength = count($returnedRates);

        $this->assertEquals($expectedLength, $actualLength, "$expectedLength rates should be returned but $actualLength rates were returned.");
    }

    public function supportedExchangeRates(): array
    {
        return [["EUR"], ["GBP"], ["NGN"], ["USD"]];
    }

    public function test_that_unsupported_currency_throws_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ExchangeRateHelper::getRatesForCurrency('YEN');
    }

    public function test_that_all_rates_are_returned_correctly(): void
    {
        $returnedRates = ExchangeRateHelper::getAllRates();
        $expectedLength = count(ExchangeRateHelper::getSupportedCurrencies());
        $actualLength = count($returnedRates);
        $this->assertEquals($expectedLength, $actualLength, "$expectedLength rates should be returned but $actualLength rates were returned.");
    }
}
