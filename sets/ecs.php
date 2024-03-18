<?php
declare(strict_types=1);

use Developion\CodingStandards\Fixer\{
	BlankLineAfterStrictTypesFixer,
	NoEmptyLineBeforeDeclareStrictTypesFixer,
};
use PhpCsFixer\Fixer\{
	Import\NoUnusedImportsFixer,
	Import\SingleImportPerStatementFixer,
	PhpTag\BlankLineAfterOpeningTagFixer,
	PhpTag\LinebreakAfterOpeningTagFixer,
	Strict\DeclareStrictTypesFixer,
	Whitespace\MethodChainingIndentationFixer,
};
use Symplify\EasyCodingStandard\{
	Config\ECSConfig,
	ValueObject\Option,
	ValueObject\Set\SetList,
};

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
		LinebreakAfterOpeningTagFixer::class,
		NoEmptyLineBeforeDeclareStrictTypesFixer::class,
		DeclareStrictTypesFixer::class,
		BlankLineAfterStrictTypesFixer::class,
		MethodChainingIndentationFixer::class,
		NoUnusedImportsFixer::class,
	])
;
