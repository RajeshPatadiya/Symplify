<?php declare(strict_types=1);

namespace Symplify\EasyCodingStandard\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symplify\EasyCodingStandard\DependencyInjection\ContainerFactory;
use Symplify\EasyCodingStandard\FixerRunner\Application\FixerFileProcessor;
use Symplify\EasyCodingStandard\SniffRunner\Application\SniffFileProcessor;

final class MutualExcludedCheckersTest extends TestCase
{
    public function test(): void
    {
        $container = (new ContainerFactory())->createWithConfig(__DIR__ . '/MutualExcludedCheckersSource/config.yml');

        $fixerFileProcessor = $container->get(FixerFileProcessor::class);
        $this->assertCount(1, $fixerFileProcessor->getCheckers());

        $sniffFileProcessor = $container->get(SniffFileProcessor::class);
        $this->assertCount(0, $sniffFileProcessor->getCheckers());
    }
}
