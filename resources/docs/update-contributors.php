<?php
/**
 * Update contributors list
 */

declare(strict_types=1);

function getContributors(string $url): array
{
    $response = file_get_contents(
        $url,
        false,
        stream_context_create(
            [
                'http' => [
                    'method' => "GET",
                    'header' => "User-Agent: ContributorsListUpdater",
                ],
            ]
        )
    );
    return json_decode($response, true);
}

function getMarkdown(array $contributors): string
{
    $tableLines = [
        '| Contributor | Contributions |',
        '| --- | --- |',
    ];

    foreach ($contributors as $contributor) {
        $tableLines[] = sprintf(
            '| %s | %s |',
            sprintf(
                '[<img src="%s" style="%s"/> %s](%s)',
                $contributor['avatar_url'],
                'border-radius: 50%;vertical-align: middle;width: 32px;padding-bottom: 3px;',
                $contributor['login'],
                $contributor['html_url'],
            ),
            $contributor['contributions'],
        );
    }

    $table = implode("\n", $tableLines);

    return <<<markdown
        # Contributors
        
        $table
        markdown;
}

function updateFile(string $file, string $content): void
{
    file_put_contents($file, $content);
}

updateFile(
    __DIR__ . '/../../docs/contributing/contributors.md',
    getMarkdown(
        getContributors('https://api.github.com/repos/idealo/php-rdkafka-ffi/contributors')
    ),
);