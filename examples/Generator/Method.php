<?php

declare(strict_types=1);

namespace FFI\Generator;


class Method
{
    /**
     * @var string
     */
    private string $name;
    /**
     * @var string
     */
    private string $description;

    private array $docBlockTags;
    /**
     * @var Param[]
     */
    private array $params;
    /**
     * @var Param|null
     */
    private ?Param $return;

    public function __construct(string $name, array $params, ?Param $return, string $description)
    {
        $this->name = $name;
        $this->params = $params;
        $this->return = $return;
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
        public static function %s(%s)%s 
        {
            %sstatic::getFFI()->%s(%s);
        }
        PHPCODE;

        $code = sprintf(
            $template,
            $this->getDocBlock(),
            $this->name,
            implode(
                ', ',
                array_map(fn(Param $param) => $param->getPhpCode(), $this->params),
            ),
            $this->return->getPhpCode(),
            $this->return->isVoid() ? '' : 'return ',
            $this->name,
            implode(
                ', ',
                array_map(fn(Param $param) => $param->getPhpVar(), $this->params),
            )
        );

        if ($ident != '') {
            $parts = explode("\n", $code);
            $code = '';
            foreach ($parts as $part) {
                $code .= $ident . $part . "\n";
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
        foreach ($this->params as $param) {
            $lines[] = $param->getDocBlock();
        }
        if ($this->return->isVoid() === false) {
            $lines[] = $this->return->getDocBlock();
        }

        return sprintf($template, empty($lines) ? '' : "\n" . implode("\n", $lines));
    }
}