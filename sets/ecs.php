<?php
declare(strict_types=1);

use Developion\CodingStandards\Fixer\{
	BlankLineAfterStrictTypesFixer,
	NoEmptyLineBeforeDeclareStrictTypesFixer,
};
use PhpCsFixer\Fixer\Basic\NumericLiteralSeparatorFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\Import\{
	GroupImportFixer,
	NoUnusedImportsFixer,
	OrderedImportsFixer,
	SingleImportPerStatementFixer,
	SingleLineAfterImportsFixer,
};
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\PhpTag\{
	BlankLineAfterOpeningTagFixer,
	LinebreakAfterOpeningTagFixer,
};
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Whitespace\{
	BlankLineBetweenImportGroupsFixer,
	IndentationTypeFixer,
	MethodChainingIndentationFixer,
	StatementIndentationFixer,
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
		NumericLiteralSeparatorFixer::class,
		TrailingCommaInMultilineFixer::class,
		IndentationTypeFixer::class,
		StatementIndentationFixer::class,
		TernaryOperatorSpacesFixer::class,
		LinebreakAfterOpeningTagFixer::class,
		BlankLineAfterNamespaceFixer::class,
		VisibilityRequiredFixer::class,
		ReturnTypeDeclarationFixer::class,
		DeclareStrictTypesFixer::class,
		GroupImportFixer::class,
		SingleLineAfterImportsFixer::class,
		BlankLineBetweenImportGroupsFixer::class,
	])
	->withConfiguredRule(OrderedImportsFixer::class, ['sort_algorithm' => 'alpha', 'imports_order' => ['const', 'class', 'function']])
;
