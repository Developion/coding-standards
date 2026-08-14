<?php
declare(strict_types=1);

namespace Developion\CodingStandards\Fixer;

use Developion\CodingStandards\Traits\FixerName;
use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\WhitespacesAwareFixerInterface;
use PhpCsFixer\FixerDefinition\{
	CodeSample,
	FixerDefinition,
	FixerDefinitionInterface,
};
use PhpCsFixer\Tokenizer\{
	CT,
	Token,
	Tokens,
};

final class MultilineGroupImportFixer extends AbstractFixer implements WhitespacesAwareFixerInterface
{
	use FixerName;

	public function getDefinition(): FixerDefinitionInterface
	{
		return new FixerDefinition(
			'Multiline group `use` imports must have the closing brace on its own line, and the last import must be followed by a trailing comma.',
			[
				new CodeSample(
					"<?php\n\nuse Foo\\{\n    Bar,\n    Baz};\n",
				),
				new CodeSample(
					"<?php\n\nuse Foo\\{\n    Bar,\n    Baz\n};\n",
				),
			],
		);
	}

	public function isCandidate(Tokens $tokens): bool
	{
		return $tokens->isTokenKindFound(CT::T_GROUP_IMPORT_BRACE_OPEN);
	}

	/**
	 * Run after the rules that shape group imports in the first place,
	 * so we act on their output rather than fighting with them.
	 */
	public function getPriority(): int
	{
		return -1;
	}

	protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
	{
		for ($index = $tokens->count() - 1; $index >= 0; --$index) {
			if (!$tokens[$index]->isGivenKind(CT::T_GROUP_IMPORT_BRACE_OPEN)) {
				continue;
			}

			$this->fixGroupImport($tokens, $index);
		}
	}

	private function fixGroupImport(Tokens $tokens, int $openIndex): void
	{
		$closeIndex = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_GROUP_IMPORT_BRACE, $openIndex);

		if (!$this->isMultiline($tokens, $openIndex, $closeIndex)) {
			// Single-line group imports are left alone; `no_trailing_comma_in_singleline`
			// already takes care of stripping any trailing comma from those.
			return;
		}

		$indent = $this->detectIndent($tokens, $openIndex);
		$lineEnding = $this->whitespacesConfig->getLineEnding();

		// Find the last "real" (non-whitespace, non-comment) token before the closing brace.
		$lastContentIndex = $closeIndex - 1;
		while ($tokens[$lastContentIndex]->isWhitespace() || $tokens[$lastContentIndex]->isComment()) {
			--$lastContentIndex;
		}

		// 1. Enforce the trailing comma after the last import.
		if (!$tokens[$lastContentIndex]->equals(',')) {
			$tokens->insertAt($lastContentIndex + 1, new Token(','));
			$closeIndex++;
			$lastContentIndex++;
		}

		// 2. Enforce that the closing brace sits alone on its own line, indented like `use`.
		$whitespaceIndex = $lastContentIndex + 1;
		$expected = $lineEnding . $indent;

		if ($tokens[$whitespaceIndex]->isWhitespace()) {
			if ($tokens[$whitespaceIndex]->getContent() !== $expected) {
				$tokens[$whitespaceIndex] = new Token([\T_WHITESPACE, $expected]);
			}
		} else {
			$tokens->insertAt($whitespaceIndex, new Token([\T_WHITESPACE, $expected]));
		}
	}

	private function isMultiline(Tokens $tokens, int $openIndex, int $closeIndex): bool
	{
		for ($i = $openIndex + 1; $i < $closeIndex; ++$i) {
			if (str_contains($tokens[$i]->getContent(), "\n")) {
				return true;
			}
		}

		return false;
	}

	private function detectIndent(Tokens $tokens, int $openIndex): string
	{
		$useIndex = $tokens->getPrevTokenOfKind($openIndex, [[\T_USE]]);

		if (null === $useIndex) {
			return '';
		}

		$prev = $tokens[$useIndex - 1] ?? null;

		if (null !== $prev && $prev->isWhitespace()) {
			$content = $prev->getContent();
			$lastNewLine = strrpos($content, "\n");

			if (false !== $lastNewLine) {
				return substr($content, $lastNewLine + 1);
			}
		}

		return '';
	}
}