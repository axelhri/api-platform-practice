<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src')
    ->exclude('var')
    ->exclude('vendor')
;

return (new PhpCsFixer\Config())
    ->setRules([
		'@PSR12' => true,
    ])
	->setIndent("\t")
    ->setFinder($finder)
    ;
