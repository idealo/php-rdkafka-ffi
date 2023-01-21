<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $config): void {
    $config->sets([
        SetList::PSR_12,
        SetList::COMMON,
        SetList::CLEAN_CODE,
    ]);

    $config->skip(
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

    $config->ruleWithConfiguration(OrderedImportsFixer::class, [
        'imports_order' => [
            'class',
            'const',
            'function',
        ],
    ]);
};
