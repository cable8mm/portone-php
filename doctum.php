<?php

use Doctum\Doctum;
use Doctum\RemoteRepository\GitHubRemoteRepository;
use Symfony\Component\Finder\Finder;

$dir = getcwd().'/src';
$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('tests')
    ->in($dir);

return new Doctum($iterator, [
    'title' => 'The cable8mm/portone-php API',
    'source_dir' => dirname($dir).'/',
    'remote_repository' => new GitHubRemoteRepository('cable8mm/portone-php', dirname($dir)),
    'footer_link' => [
        'href' => 'https://github.com/cable8mm/portone-php',
        'target' => '_blank',
        'before_text' => 'You can refer',
        'link_text' => 'cable8mm/portone-php', // Required if the href key is set
        'after_text' => 'repository',
    ],
]);
