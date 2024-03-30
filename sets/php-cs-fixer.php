<?php
declare(strict_types=1);

use Developion\CodingStandards\Fixer\Import\SingleImportPerLineInGroupImportFixer;
use Developion\CodingStandards\Fixer\{
	BlankLineAfterStrictTypesFixer,
	NoEmptyLineBeforeDeclareStrictTypesFixer,
	RemoveDebugLinesFixer,
};
use Developion\CodingStandards\Util;
use PhpCsFixer\Fixer\Alias\ModernizeStrposFixer;
use PhpCsFixer\Fixer\Basic\NumericLiteralSeparatorFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\Import\{
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
	NoExtraBlankLinesFixer,
	StatementIndentationFixer,
};
use PhpCsFixer\{
	Config,
	ConfigInterface,
	Finder,
};

return function (Finder $finder): ConfigInterface {
	return (new Config())
		->setRiskyAllowed(true)
		->registerCustomFixers([
			new BlankLineAfterStrictTypesFixer(),
			new NoEmptyLineBeforeDeclareStrictTypesFixer(),
			new RemoveDebugLinesFixer(),
			new SingleImportPerLineInGroupImportFixer(),
		])
		->setRules([
			// base set
			'@PSR12:risky' => true,
			// disables
			Util::getName(BlankLineAfterOpeningTagFixer::class) => false,
			Util::getName(SingleImportPerStatementFixer::class) => false,
			// enables
			Util::getName(BlankLineAfterNamespaceFixer::class) => true,
			Util::getName(BlankLineBetweenImportGroupsFixer::class) => true,
			Util::getName(DeclareStrictTypesFixer::class) => true,
			Util::getName(IndentationTypeFixer::class) => true,
			Util::getName(LinebreakAfterOpeningTagFixer::class) => true,
			Util::getName(MethodChainingIndentationFixer::class) => true,
			Util::getName(ModernizeStrposFixer::class) => true,
			Util::getName(NoExtraBlankLinesFixer::class) => [
				'tokens' => [
					'extra',
					'use',
				],
			],
			Util::getName(NoUnusedImportsFixer::class) => true,
			Util::getName(NumericLiteralSeparatorFixer::class) => true,
			Util::getName(OrderedImportsFixer::class) => true,
			Util::getName(ReturnTypeDeclarationFixer::class) => true,
			Util::getName(SingleLineAfterImportsFixer::class) => true,
			Util::getName(StatementIndentationFixer::class) => true,
			Util::getName(TernaryOperatorSpacesFixer::class) => true,
			Util::getName(TrailingCommaInMultilineFixer::class) => true,
			Util::getName(VisibilityRequiredFixer::class) => true,
			// custom fixers
			BlankLineAfterStrictTypesFixer::name() => true,
			NoEmptyLineBeforeDeclareStrictTypesFixer::name() => true,
			SingleImportPerLineInGroupImportFixer::name() => true,
		])
		->setIndent("\t")
		->setFinder($finder);
};
