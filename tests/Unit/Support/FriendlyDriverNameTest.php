<?php

declare(strict_types=1);

namespace Tests\Unit\Support;

use Illuminate\Support\Collection;
use Support\Actions\FriendlyDriverNameAction;
use XbNz\Resolver\Support\Drivers\Driver;

class FriendlyDriverNameTest extends \Tests\TestCase
{
    public function testItTakesADriverFqnStringAndReturnsTheWebsiteName(): void
    {
        // Arrange
        $driverFqn = SomeRandomDriverNamingConventionDotCom::class;
        $action = app(FriendlyDriverNameAction::class);

        // Act
        $friendlyName = $action($driverFqn);

        // Assert
        $this->assertEquals('somerandomnamingconvention.com', $friendlyName);
    }
}

class SomeRandomDriverNamingConventionDotCom
{
}
