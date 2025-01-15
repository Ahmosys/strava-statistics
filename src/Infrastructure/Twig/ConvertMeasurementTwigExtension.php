<?php

declare(strict_types=1);

namespace App\Infrastructure\Twig;

use App\Infrastructure\ValueObject\Measurement\Imperial;
use App\Infrastructure\ValueObject\Measurement\Metric;
use App\Infrastructure\ValueObject\Measurement\Unit;
use App\Infrastructure\ValueObject\Measurement\UnitSystem;

final readonly class ConvertMeasurementTwigExtension
{
    public function __construct(
        private UnitSystem $unitSystem,
    ) {
    }

    public function doConversion(Unit $measurement): Unit
    {
        if (UnitSystem::IMPERIAL === $this->unitSystem && $measurement instanceof Metric) {
            return $measurement->toImperial();
        }
        if (UnitSystem::METRIC === $this->unitSystem && $measurement instanceof Imperial) {
            return $measurement->toMetric();
        }

        return $measurement;
    }
}
