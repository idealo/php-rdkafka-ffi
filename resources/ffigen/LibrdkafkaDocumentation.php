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

    public function __construct(string $url = 'https://docs.confluent.io/platform/current/clients/librdkafka/html/rdkafka_8h.html')
    {
        $this->url = $url;
    }

    public function extract(): void
    {
        echo 'Download and prepare librdkafka documentation ...';

        $html = file_get_contents($this->url);
        $page = new Crawler($html);
        $elements = $page->filter('div[class=contents] a[id]')->each(
            function (Crawler $node, $i) {
                // rewrite code examples - use pre & code tag
                $node->nextAll()->eq(1)->filter('div[class=fragment]')->each(
                    function (Crawler $node, $i) {
                        // remove ttc nodes
                        $node->filter('div[class=ttc]')->each(function (Crawler $node, $i) {
                            $node->getNode(0)->parentNode->removeChild($node->getNode(0));
                        });

                        $oldNode = $node->first()->getNode(0);
                        $doc = $oldNode->ownerDocument;

                        $content = $oldNode->ownerDocument->createTextNode(trim($node->first()->text('', false)));
                        $code = $doc->createElement('code');
                        $code->append($content);
                        $pre = $doc->createElement('pre');
                        $pre->append($code);
                        $newNode = $doc->createElement('div');
                        $newNode->append($pre);

                        $oldNode->parentNode->replaceChild($newNode, $oldNode);
                    }
                );

                // extract defines & methods
                if ($node->nextAll()->count()
                    && $node->nextAll()->eq(1)->filter('td[class=memname]')->count()
                    && $node->nextAll()->eq(1)->filter('div[class=memdoc]')->count()
                ) {
                    // extract enumerators
                    if ($node->nextAll()->eq(1)->filter('td[class=fieldname]')->count()
                        && $node->nextAll()->eq(1)->filter('td[class=fielddoc]')->count()
                    ) {
                        $enums = $node->nextAll()->eq(1)->filter('td[class=fieldname]')->each(
                            function (Crawler $node, $i) {
                                return [
                                    'name' => $this->filterHtml($node->text()),
                                    'description' => $this->filterHtml($node->nextAll()->first()->html('')),
                                ];
                            }
                        );
                    }

                    // extract params - and remove them (from description)
                    if ($node->nextAll()->eq(1)->filter('td[class=paramname]')->count()) {
                        $params = $node->nextAll()->eq(1)->filter('td[class=paramname]')->each(
                            function (Crawler $node, $i) {
                                return [
                                    'name' => $this->filterHtml($node->text()),
                                    'description' => $this->filterHtml($node->nextAll()->first()->html('')),
                                ];
                            }
                        );
                        $node->nextAll()->eq(1)->filter('dl[class=params]')->each(
                            function (Crawler $node, $i): void {
                                $node->getNode(0)->parentNode->removeChild($node->getNode(0));
                            }
                        );
                    }

                    // extract return - and remove them (from description)
                    if ($node->nextAll()->eq(1)->filter('dl[class*=return] dd')->count()) {
                        $return = $this->filterHtml($node->nextAll()->eq(1)->filter('dl[class*=return] dd')->first()->html(''));
                        $node->nextAll()->eq(1)->filter('dl[class*=return]')->each(
                            function (Crawler $node, $i): void {
                                $node->getNode(0)->parentNode->removeChild($node->getNode(0));
                            }
                        );
                    }

                    return [
                        'id' => $node->attr('id'),
                        'name' => $node->nextAll()->eq(1)->filter('td[class=memname]')->count()
                            ? $this->filterHtml($node->nextAll()->eq(1)->filter('td[class=memname]')->first()->html(''))
                            : '',
                        'description' => $node->nextAll()->eq(1)->filter('div[class=memdoc]')->count()
                            ? $this->filterHtml($node->nextAll()->eq(1)->filter('div[class=memdoc]')->first()->html(''))
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
