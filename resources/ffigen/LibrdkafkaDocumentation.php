<?php

declare(strict_types=1);

namespace RdKafka\FFIGen;

use Klitsche\FFIGen\Constant;
use Klitsche\FFIGen\DocBlockTag;
use Klitsche\FFIGen\Method;
use Symfony\Component\DomCrawler\Crawler;

class LibrdkafkaDocumentation
{
    protected array $documentedElements;
    private string $url;

    public function __construct(string $url = 'https://docs.confluent.io/3.2.1/clients/librdkafka/rdkafka_8h.html')
    {
        $this->url = $url;
    }

    public function extract(): void
    {
        echo 'Download and prepare librdkafka documentation ...';

        $page = new Crawler(file_get_contents($this->url));
        $elements = $page->filter('a[class=anchor]')->each(
            function (Crawler $node, $i) {
                // extract defines & methods
                if ($node->nextAll()->count()
                    && $node->nextAll()->first()->filter('td[class=memname]')->count()
                    && $node->nextAll()->first()->filter('div[class=memdoc]')->count()
                ) {
                    // extract enumerators
                    if ($node->nextAll()->first()->filter('td[class=fieldname]')->count()
                        && $node->nextAll()->first()->filter('td[class=fielddoc]')->count()
                    ) {
                        $enums = $node->nextAll()->first()->filter('td[class=fieldname]')->each(
                            function (Crawler $node, $i) {
                                return [
                                    'name' => $this->filterHtml($node->text()),
                                    'description' => $this->filterHtml($node->nextAll()->first()->html('')),
                                ];
                            }
                        );
                    }

                    // extract params - and remove them (from description)
                    if ($node->nextAll()->first()->filter('td[class=paramname]')->count()) {
                        $params = $node->nextAll()->first()->filter('td[class=paramname]')->each(
                            function (Crawler $node, $i) {
                                return [
                                    'name' => $this->filterHtml($node->text()),
                                    'description' => $this->filterHtml($node->nextAll()->first()->html('')),
                                ];
                            }
                        );
                        $node->nextAll()->first()->filter('dl[class=params]')->each(
                            function (Crawler $node, $i): void {
                                $node->getNode(0)->parentNode->removeChild($node->getNode(0));
                            }
                        );
                    }

                    // extract return - and remove them (from description)
                    if ($node->nextAll()->first()->filter('dl[class*=return] dd')->count()) {
                        $return = $this->filterHtml($node->nextAll()->first()->filter('dl[class*=return] dd')->first()->html(''));
                        $node->nextAll()->first()->filter('dl[class*=return]')->each(
                            function (Crawler $node, $i): void {
                                $node->getNode(0)->parentNode->removeChild($node->getNode(0));
                            }
                        );
                    }

                    return [
                        'id' => $node->attr('id'),
                        'name' => $node->nextAll()->first()->filter('td[class=memname]')->count()
                            ? $this->filterHtml($node->nextAll()->first()->filter('td[class=memname]')->first()->html(''))
                            : '',
                        'description' => $node->nextAll()->first()->filter('div[class=memdoc]')->count()
                            ? $this->filterHtml($node->nextAll()->first()->filter('div[class=memdoc]')->first()->html(''))
                            : '',
                        'params' => $params ?? [],
                        'return' => $return ?? null,
                        'enums' => $enums ?? [],
                    ];
                }

                return null;
            }
        );

        echo ' done.' . PHP_EOL;

        $this->documentedElements = array_filter($elements, 'is_array');
    }

    private function filterHtml(string $html): string
    {
        return trim(preg_replace('/<\/?a.*?>/', '', $html));
    }

    /**
     * @param Constant|Method $element
     */
    public function enrich($element): void
    {
        foreach ($this->documentedElements as $documentedElement) {
            if (preg_match('/\b' . $element->getName() . '\b/', $documentedElement['name'])) {
                $element->getDocBlock()->addTag(
                    new DocBlockTag(
                        'link',
                        $this->url . '#' . $documentedElement['id']
                    )
                );
                $element->getDocBlock()->setDescription($documentedElement['description']);

                foreach ($documentedElement['params'] as $param) {
                    foreach ($element->getDocBlock()->getTags() as $tag) {
                        if (preg_match('/\b' . preg_quote($param['name'], '/') . '\b/', $tag->getValue())) {
                            $tag->setValue($tag->getValue() . ' - ' . $param['description']);
                            break;
                        }
                    }
                }
                if ($documentedElement['return'] !== null) {
                    foreach ($element->getDocBlock()->getTags() as $tag) {
                        if ($tag->getName() === 'return') {
                            $tag->setValue($tag->getValue() . ' - ' . $documentedElement['return']);
                            break;
                        }
                    }
                }
            } else {
                foreach ($documentedElement['enums'] as $documentedEnum) {
                    if (preg_match('/\b' . $element->getName() . '\b/', $documentedEnum['name'])) {
                        $element->getDocBlock()->addTag(
                            new DocBlockTag(
                                'link',
                                $this->url . '#' . $documentedElement['id']
                            )
                        );
                        $element->getDocBlock()->setDescription($documentedEnum['description']);
                    }
                }
            }
        }
    }
}
