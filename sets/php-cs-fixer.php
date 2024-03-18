<?php
declare(strict_types=1);

use Developion\CodingStandards\Fixer\BlankLineAfterStrictTypesFixer;
use Developion\CodingStandards\Fixer\NoEmptyLineBeforeDeclareStrictTypesFixer;
use Developion\CodingStandards\Fixer\RemoveDebugLinesFixer;
use Developion\CodingStandards\Util;
use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Finder;
use PhpCsFixer\Fixer\Alias\ModernizeStrposFixer;
use PhpCsFixer\Fixer\Basic\NumericLiteralSeparatorFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\PhpTag\LinebreakAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Whitespace\IndentationTypeFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;

return function (Finder $finder): ConfigInterface {
	return (new Config())
	->setRiskyAllowed(true)
	->registerCustomFixers([
		new BlankLineAfterStrictTypesFixer(),
		new NoEmptyLineBeforeDeclareStrictTypesFixer(),
		new RemoveDebugLinesFixer(),
	])
	->setRules([
		'@PSR12:risky' => true,
		Util::getName(ModernizeStrposFixer::class) => true,
		Util::getName(OrderedImportsFixer::class) => true,
		Util::getName(NoUnusedImportsFixer::class) => true,
		Util::getName(NoExtraBlankLinesFixer::class) => [
			'tokens' => [
				'extra',
				'use',
			],
		],
		Util::getName(NumericLiteralSeparatorFixer::class) => true,
		Util::getName(IndentationTypeFixer::class) => true,
		Util::getName(TernaryOperatorSpacesFixer::class) => true,
		Util::getName(LinebreakAfterOpeningTagFixer::class) => true,
		Util::getName(DeclareStrictTypesFixer::class) => true,
		BlankLineAfterStrictTypesFixer::name() => true,
		NoEmptyLineBeforeDeclareStrictTypesFixer::name() => true,
	])
	->setIndent("\t")
	->setFinder($finder);
};
