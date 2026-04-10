<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    brightcloudstudio/contao-signature-form-field
 * @license    GPL-3.0-or-later
 * @link       https://github.com/brightcloudstudio/contao-signature-form-field
 */

declare(strict_types=1);

namespace BCS\ContaoSignatureFormField\Widget;

use Contao\Widget;

class SignatureWidget extends Widget
{
    protected $blnSubmitInput = true;
    protected $blnForAttribute = true;
    protected $strTemplate = 'form_signature';
    protected $strPrefix = 'widget widget-signature';

    public function generate(): string
    {
        return '';
    }

    protected function validator($varInput): mixed
    {
        return $varInput;
    }
}
