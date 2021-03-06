<?php declare(strict_types=1);

namespace Symplify\TokenRunner\DocBlock;

use Nette\Utils\Strings;

final class ParamAndReturnTagAnalyzer
{
    /**
     * @var string[]
     */
    private $uselessTypes = [];

    public function isTagUseful(?string $docType, ?string $docDescription, ?string $codeType): bool
    {
        if ($this->isMatch($docType, $codeType)) {
            return false;
        }

        if ($docDescription) {
            return true;
        }

        // not code type and no type in typehint
        if ($codeType === null && ! $docType) {
            return false;
        }

        if (in_array($docType, $this->uselessTypes, true)) {
            return false;
        }

        if ($this->isLongSimpleType($docType, $codeType)) {
            return false;
        }

        return true;
    }

    /**
     * @param string[] $uselessTypes
     */
    public function setUselessTypes(array $uselessTypes): void
    {
        $this->uselessTypes = $uselessTypes;
    }

    private function isMatch(?string $docType, ?string $codeType): bool
    {
        if ($docType === $codeType) {
            return true;
        }

        if ($docType) {
            if (Strings::endsWith($docType, '\\' . $codeType)) {
                return true;
            }

            if (Strings::endsWith($codeType, '\\' . $docType)) {
                return true;
            }
        }

        return false;
    }

    private function isLongSimpleType(?string $docType, ?string $paramType): bool
    {
        if ($docType === 'boolean' && $paramType === 'bool') {
            return true;
        }

        if ($docType === 'integer' && $paramType === 'int') {
            return true;
        }

        return false;
    }
}
