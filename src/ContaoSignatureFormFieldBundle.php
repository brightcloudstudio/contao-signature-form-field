<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    brightcloudstudio/contao-signature-form-field
 * @license    GPL-3.0-or-later
 * @link       https://github.com/brightcloudstudio/contao-signature-form-field
 */

declare(strict_types=1);

namespace BCS\ContaoSignatureFormField;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContaoSignatureFormFieldBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
