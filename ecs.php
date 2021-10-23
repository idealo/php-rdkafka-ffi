<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(SetList::PSR_12);
    $containerConfigurator->import(SetList::COMMON);
    $containerConfigurator->import(SetList::CLEAN_CODE);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(
        Option::SKIP,
        [
            'src/constants.php',
            'src/RdKafka/FFI/Methods.php',
            'src/RdKafka/FFI/Versions/*.php',
            ClassAttributesSeparationFixer::class => '~',
            OrderedClassElementsFixer::class => '~',
            StrictComparisonFixer::class => [
                'src/RdKafka.php',
            ],
        ]
    );

    $services = $containerConfigurator->services();
    $services->set(OrderedImportsFixer::class)
        ->call(
            'configure',
            [
                [
                    'imports_order' => [
                        'class',
                        'const',
                        'function',
                    ],
                ],
            ]
        );
};
