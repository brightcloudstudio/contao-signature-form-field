<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    brightcloudstudio/contao-signature-form-field
 * @license    GPL-3.0-or-later
 * @link       https://github.com/brightcloudstudio/contao-signature-form-field
 */

declare(strict_types=1);

namespace BCS\ContaoSignatureFormField\Backend;

use Contao\DataContainer;
use Contao\StringUtil;

class LeadDataRenderer
{
    public static function generateLabel(array $row, string $label, DataContainer $dc, array $args): string
    {
        $name = (string) ($row['name'] ?? '');
        $value = (string) ($row['value'] ?? '');

        $args[0] = StringUtil::specialchars($name);
        $args[1] = self::renderValue($name, $value);
        $args[2] = '';

        return $args[0] . $args[1] . $args[2];
    }

    private static function renderValue(string $name, string $value): string
    {
        if ($value === '') {
            return '';
        }

        if (self::isSignatureField($name) && self::isBase64ImageDataUri($value)) {
            return self::renderImage($value);
        }

        return StringUtil::specialchars($value);
    }

    private static function isSignatureField(string $name): bool
    {
        return $name === 'signature';
    }

    private static function isBase64ImageDataUri(string $value): bool
    {
        return 1 === preg_match('#^data:image/[-a-zA-Z0-9.+]+;base64,#', $value);
    }

    private static function renderImage(string $dataUri): string
    {
        return sprintf(
            '<img src="%s" alt="Signature" style="max-width:320px; max-height:120px; height:auto; width:auto; border:1px solid #d0d0d0; background:#fff; padding:4px;">',
            StringUtil::specialchars($dataUri)
        );
    }
}
