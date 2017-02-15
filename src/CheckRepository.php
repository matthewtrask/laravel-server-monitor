<?php

namespace Spatie\ServerMonitor;

use Spatie\ServerMonitor\Models\Check;

class CheckRepository
{
    public static function allThatShouldRun(): MonitorCollection
    {
        $checks = self::query()->get()->filter->shouldCheckUptime();

        return CheckCollection::make($checks);
    }

    protected static function query()
    {
        $modelClass = static::determineCheckModel();

        return $modelClass::enabled();
    }

    protected static function determineCheckModel(): string
    {
        $monitorModel = config('laravel-server-monitor.check_model') ?? Check::class;

        if (! is_a($monitorModel, Monitor::class, true)) {
            throw InvalidConfiguration::modelIsNotValid($monitorModel);
        }

        return $monitorModel;
    }
}
