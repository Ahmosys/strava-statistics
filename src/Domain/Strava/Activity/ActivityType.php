<?php

namespace App\Domain\Strava\Activity;

use App\Domain\Strava\SportType;

enum ActivityType: string
{
    case RIDE = 'Ride';
    case VIRTUAL_RIDE = 'VirtualRide';
    case RUN = 'Run';

    public function supportsWeather(): bool
    {
        return self::RIDE === $this || self::RUN === $this;
    }

    public function supportsReverseGeocoding(): bool
    {
        return self::RIDE === $this || self::RUN === $this;
    }

    public function isVirtual(): bool
    {
        return self::VIRTUAL_RIDE === $this;
    }

    public function isRide(): bool
    {
        return SportType::RIDE === $this->getSportType();
    }

    public function isRun(): bool
    {
        return SportType::RUN === $this->getSportType();
    }

    public function getSportType(): SportType
    {
        return match ($this) {
            ActivityType::RIDE, ActivityType::VIRTUAL_RIDE => SportType::RIDE,
            ActivityType::RUN => SportType::RUN,
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            ActivityType::RIDE => 'emerald-600',
            ActivityType::VIRTUAL_RIDE => 'orange-500',
            ActivityType::RUN => 'yellow-300',
        };
    }
}
