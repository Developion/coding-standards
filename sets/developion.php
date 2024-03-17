<?php
declare(strict_types=1);

use Developion\CodingStandards\Fixer\BlankLineAfterStrictTypesFixer;
use Developion\CodingStandards\Fixer\NoEmptyLineBeforeDeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return ECSConfig::configure()
	->withParallel()
	->withSets([
		SetList::PSR_12,
	])
	->withSpacing(
		indentation: Option::INDENTATION_TAB,
	)
	->withSkip([
		SingleImportPerStatementFixer::class => true,
		BlankLineAfterOpeningTagFixer::class => true,
	])
	->withRules([
		NoEmptyLineBeforeDeclareStrictTypesFixer::class,
		DeclareStrictTypesFixer::class,
		BlankLineAfterStrictTypesFixer::class,
		MethodChainingIndentationFixer::class,
		NoUnusedImportsFixer::class,
	])
;
