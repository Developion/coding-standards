<?php
declare(strict_types=1);

namespace Developion\CodingStandards\Fixer;

use Developion\CodingStandards\Traits\FixerName;
use PhpCsFixer\AbstractFixer;
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

final class UngroupSingleImportFixer extends AbstractFixer
{
	use FixerName;

	public function getDefinition(): FixerDefinitionInterface
	{
		return new FixerDefinition(
			'A group `use` import left with only one member (for example after `no_unused_imports` removed the others) must be converted back into a plain, non-grouped import.',
			[
				new CodeSample(
					"<?php\n\nuse Foo\\{Bar};\n"
				),
				new CodeSample(
					"<?php\n\nuse Foo\\{Bar as B};\n"
				),
				new CodeSample(
					"<?php\n\nuse Foo\\{function bar};\n"
				),
			]
		);
	}

	public function isCandidate(Tokens $tokens): bool
	{
		return $tokens->isTokenKindFound(CT::T_GROUP_IMPORT_BRACE_OPEN);
	}

	/**
	 * Run after `no_unused_imports` (-10) has had a chance to strip members
	 * out of a group, but before `ordered_imports` (-30) re-sorts the
	 * resulting plain imports.
	 */
	public function getPriority(): int
	{
		return -15;
	}

	protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
	{
		for ($index = $tokens->count() - 1; $index >= 0; --$index) {
			if (!$tokens[$index]->isGivenKind(CT::T_GROUP_IMPORT_BRACE_OPEN)) {
				continue;
			}

			$this->ungroupIfSingleMember($tokens, $index);
		}
	}

	private function ungroupIfSingleMember(Tokens $tokens, int $openIndex): void
	{
		$closeIndex = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_GROUP_IMPORT_BRACE, $openIndex);

		$members = $this->findMembers($tokens, $openIndex, $closeIndex);

		if (1 !== \count($members)) {
			return;
		}

		[$memberStart, $memberEnd] = $members[0];

		$useIndex = $tokens->getPrevTokenOfKind($openIndex, [[\T_USE]]);

		if (null === $useIndex) {
			return;
		}

		$afterUse = $tokens->getNextMeaningfulToken($useIndex);
		$groupType = null;
		$prefixStart = $afterUse;

		if ($tokens[$afterUse]->isGivenKind([\T_FUNCTION, \T_CONST])) {
			$groupType = clone $tokens[$afterUse];
			$prefixStart = $tokens->getNextMeaningfulToken($afterUse);
		}

		$nameStart = $memberStart;
		$itemType = null;

		if ($tokens[$memberStart]->isGivenKind([\T_FUNCTION, \T_CONST])) {
			$itemType = clone $tokens[$memberStart];
			$nameStart = $tokens->getNextMeaningfulToken($memberStart);
		}

		$finalType = $groupType ?? $itemType;

		$prefixTokens = $this->cloneRange($tokens, $prefixStart, $openIndex - 1);
		$nameTokens = $this->cloneRange($tokens, $nameStart, $memberEnd);

		$replacement = [new Token([\T_WHITESPACE, ' '])];

		if (null !== $finalType) {
			$replacement[] = $finalType;
			$replacement[] = new Token([\T_WHITESPACE, ' ']);
		}

		array_push($replacement, ...$prefixTokens, ...$nameTokens);

		$tokens->overrideRange($useIndex + 1, $closeIndex, $replacement);
	}

	/**
	 * @return list<array{0: int, 1: int}> list of [startIndex, endIndex] pairs, one per member
	 */
	private function findMembers(Tokens $tokens, int $openIndex, int $closeIndex): array
	{
		$members = [];
		$memberStart = null;
		$lastMeaningful = null;

		for ($i = $openIndex + 1; $i < $closeIndex; ++$i) {
			$token = $tokens[$i];

			if ($token->isWhitespace() || $token->isComment()) {
				continue;
			}

			if ($token->equals(',')) {
				if (null !== $memberStart) {
					$members[] = [$memberStart, $lastMeaningful];
					$memberStart = null;
				}

				continue;
			}

			if (null === $memberStart) {
				$memberStart = $i;
			}

			$lastMeaningful = $i;
		}

		if (null !== $memberStart) {
			$members[] = [$memberStart, $lastMeaningful];
		}

		return $members;
	}

	/**
	 * @return list<Token>
	 */
	private function cloneRange(Tokens $tokens, int $start, int $end): array
	{
		$clones = [];

		for ($i = $start; $i <= $end; ++$i) {
			$clones[] = clone $tokens[$i];
		}

		return $clones;
	}
}
