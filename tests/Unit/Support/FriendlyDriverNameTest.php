<?php

namespace Tests\Unit\Support;

use Support\Actions\FriendlyDriverNameAction;


class FriendlyDriverNameTest extends \Tests\TestCase
{
    /** @test **/
    public function it_takes_a_driver_fqn_string_and_returns_the_website_name(): void
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
