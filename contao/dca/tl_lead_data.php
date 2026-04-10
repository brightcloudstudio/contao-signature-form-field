<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    brightcloudstudio/contao-signature-form-field
 * @license    GPL-3.0-or-later
 * @link       https://github.com/brightcloudstudio/contao-signature-form-field
 */

declare(strict_types=1);

use BCS\ContaoSignatureFormField\Backend\LeadDataRenderer;

if (isset($GLOBALS['TL_DCA']['tl_lead_data']))
{
    $GLOBALS['TL_DCA']['tl_lead_data']['list']['label']['label_callback'] = [LeadDataRenderer::class, 'generateLabel'];

    unset($GLOBALS['TL_DCA']['tl_lead_data']['list']['label']['format']);
}
