<?php

declare(strict_types=1);

namespace Kreait\Firebase\Tests\Unit\RemoteConfig;

use Kreait\Firebase\RemoteConfig\Condition;
use Kreait\Firebase\RemoteConfig\TagColor;
use Kreait\Firebase\Tests\UnitTestCase;

/**
 * @internal
 */
final class ConditionTest extends UnitTestCase
{
    public function testItCanBeNamed(): void
    {
        $condition = Condition::named('name');
        $this->assertSame('name', $condition->name());
    }

    public function testItsDefaultExpressionIsFalseAsString(): void
    {
        $condition = Condition::named('name');
        $this->assertSame('false', $condition->expression());
    }

    public function testItsDefaultTagColorIsNotSet(): void
    {
        $condition = Condition::named('name');
        $this->assertNull($condition->tagColor());
    }

    public function testItsTagColorCanBeSetWithAString(): void
    {
        $condition = Condition::named('name')->withTagColor('ORANGE');
        $expectedColor = new TagColor('ORANGE');

        $this->assertNotNull($condition->tagColor());
        $this->assertSame($condition->tagColor()->value(), $expectedColor->value());
    }

    /**
     * @dataProvider valueProvider
     *
     * @param array<mixed> $conditionData
     */
    public function testItCanBeCreatedFromAnArray(string $expectedName, string $expectedExpression, ?TagColor $expectedTagColor, array $conditionData): void
    {
        $condition = Condition::fromArray($conditionData);

        $this->assertSame($expectedName, $condition->name());
        $this->assertSame($expectedExpression, $condition->expression());
        $this->assertSame($expectedTagColor?->value(), $condition->tagColor()?->value());
    }

    /**
     * @return iterable<string, mixed>
     */
    public static function valueProvider(): iterable
    {
        yield 'color string' => [
            'My Name',
            'expression',
            new TagColor('GREEN'),
            [
                'name' => 'My Name',
                'expression' => 'expression',
                'tagColor' => 'GREEN',
            ],
        ];

        yield 'no color' => [
            'My Name',
            'expression',
            null,
            [
                'name' => 'My Name',
                'expression' => 'expression',
                'tagColor' => null,
            ],
        ];
    }
}
