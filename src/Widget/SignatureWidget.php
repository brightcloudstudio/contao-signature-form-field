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
    protected $strTemplate = 'form_signature';

    protected $blnForAttribute = false;

    public static $arrAttributes = array();

    public function generate(): string
    {
        $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/contaosignatureformfield/js/signature_pad.umd.min.js';

        return $this->inherit();
    }

    protected function validator($varInput): mixed
    {
        return $varInput;
    }
}
