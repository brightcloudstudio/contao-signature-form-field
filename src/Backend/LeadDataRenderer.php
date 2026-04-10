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

use Contao\StringUtil;

class LeadDataRenderer
{
    public static function generateChildRecord(array $row): string
    {
        $name = (string) ($row['name'] ?? '');
        $value = (string) ($row['value'] ?? '');

        $labelHtml = sprintf(
            '<td class="tl_file_list col_0">%s</td>',
            StringUtil::specialchars($name)
        );

        $valueHtml = sprintf(
            '<td class="tl_file_list col_1">%s</td>',
            self::renderValue($name, $value)
        );

        return $labelHtml . $valueHtml;
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
