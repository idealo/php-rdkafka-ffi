<?php

declare(strict_types=1);

namespace FFI\Generator;


class Constant_
{
    /**
     * @var string
     */
    private string $name;
    /**
     * @var int|string|array
     */
    private $value;
    /**
     * @var string
     */
    private string $description;
    private array $docBlockTags;

    public function __construct(string $name, $value, string $description)
    {
        $this->name = $name;
        $this->value = $value;
        $this->description = $description;
        $this->docBlockTags = [];
    }

    public function addDocBlockTag(string $name, string $text)
    {
        $this->docBlockTags[] = [$name, $text];
    }

    /**
     * @return array [name, text]
     */
    public function getDocBlockTags(): array
    {
        return $this->docBlockTags;
    }

    public function getPhpCode(string $ident = ''): string
    {
        $template = <<<PHPCODE
        %s
        const %s = %s;
        PHPCODE;

        $code = sprintf($template, $this->getDocBlock(), $this->name, $this->getPhpValue());

        if ($ident != '') {
            $parts = explode("\n", $code);
            $code = '';
            foreach ($parts as $part) {
                $code .= trim($ident . $part) . "\n";
            }
        }
        return $code;
    }

    public function getDocBlock(): string
    {
        $template = <<<PHPDOC
         /**%s
          */
         PHPDOC;

        $lines = [];
        if (empty($this->description) === false) {
            $lines[] = sprintf(' * %s', $this->description);
        }
        foreach ($this->docBlockTags as $tag) {
            $lines[] = sprintf(' * @%s %s', $tag[0], $tag[1]);
        }

        return sprintf($template, empty($lines) ? '' : "\n" . implode("\n", $lines));
    }

    private function getPhpValue(): string
    {
        return var_export($this->value, true);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array|int|string
     */
    public function getValue()
    {
        return $this->value;
    }
}