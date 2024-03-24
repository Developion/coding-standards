<?php
declare(strict_types=1);

use Developion\CodingStandards\SetList;
use PhpCsFixer\Finder;

$finder = (new Finder())
	->in([
		__DIR__ . '/src',
		__DIR__ . '/sets',
	])
	->files(__DIR__ . '/bootstrap.php')
	->ignoreDotFiles(false)
	->ignoreVCSIgnored(true)
	->exclude([
		__DIR__ . '/vendor',
	])
;

$config = require SetList::PHP_CS_FIXER;

return $config($finder);
