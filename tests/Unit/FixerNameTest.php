<?php
declare(strict_types=1);

use Developion\CodingStandards\Fixer\BlankLineAfterStrictTypesFixer;
use Developion\CodingStandards\Util;
use PhpCsFixer\Utils;

test('Fixer Names', function () {
	$rc = new ReflectionClass(BlankLineAfterStrictTypesFixer::class);
	expect(Util::getName(BlankLineAfterStrictTypesFixer::class) . '_fixer' === Utils::camelCaseToUnderscore($rc->getShortName()))->toBeTrue();
});
