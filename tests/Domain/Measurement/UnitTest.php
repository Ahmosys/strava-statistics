<?php

namespace App\Tests\Domain\Measurement;

use App\Domain\Measurement\Length\Foot;
use App\Domain\Measurement\Length\Kilometer;
use App\Domain\Measurement\Length\Meter;
use App\Domain\Measurement\Length\Mile;
use App\Domain\Measurement\Mass\Gram;
use App\Domain\Measurement\Mass\Kilogram;
use App\Domain\Measurement\Mass\Pound;
use App\Domain\Measurement\Unit;
use App\Domain\Measurement\Velocity\KmPerHour;
use App\Domain\Measurement\Velocity\MilesPerHour;
use App\Infrastructure\Serialization\Json;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class UnitTest extends TestCase
{
    use MatchesSnapshots;

    private string $snapshotName;

    #[DataProvider(methodName: 'provideConversions')]
    public function testConversions(Unit $a, Unit $b): void
    {
        $this->assertEquals(
            $a,
            $b
        );
    }

    public static function provideConversions(): array
    {
        return [
            [Meter::from(0.6096), Foot::from(2)->toMeter()],
            [Mile::from(1.242742), Kilometer::from(2)->toMiles()],
            [Foot::from(6.561), Meter::from(2)->toFoot()],
            [Kilometer::from(3.21868), Mile::from(2)->toKilometer()],
            [Kilogram::from(0.1), Gram::from(100)->toKilogram()],
            [Gram::from(10000), Kilogram::from(10)->toGram()],
            [Pound::from(22.0462), Kilogram::from(10)->toPound()],
            [Gram::from(4535.9237), Pound::from(10)->toGram()],
            [MilesPerHour::from(6.21371), KmPerHour::from(10)->toMph()],
            [KmPerHour::from(16.0934), MilesPerHour::from(10)->toKmH()],
        ];
    }

    #[DataProvider(methodName: 'provideMeasurements')]
    public function testElSnapshots(Unit $measurement): void
    {
        $this->snapshotName = new \ReflectionClass($measurement)->getShortName();
        $this->assertMatchesJsonSnapshot([
            'symbol' => $measurement->getSymbol(),
            'float' => $measurement->toFloat(),
            'string' => (string) $measurement,
            'serialize' => Json::encode($measurement),
        ]);
    }

    protected function getSnapshotId(): string
    {
        return new \ReflectionClass($this)->getShortName().'--'.
            $this->name().'--'.
            $this->snapshotName;
    }

    public static function provideMeasurements(): array
    {
        return [
            [Foot::from(10)],
            [Kilometer::from(100)],
            [Meter::from(1000)],
            [Mile::from(10000)],
            [Gram::from(20)],
            [Kilogram::from(200)],
            [Pound::from(2000)],
            [KmPerHour::from(30)],
            [MilesPerHour::from(300)],
        ];
    }
}
