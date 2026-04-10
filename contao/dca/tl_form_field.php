<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    brightcloudstudio/contao-signature-form-field
 * @license    GPL-3.0-or-later
 * @link       https://github.com/brightcloudstudio/contao-signature-form-field
 */

use BCS\ContaoSignatureFormField\Widget\SignatureWidget;

//$GLOBALS['TL_FFL']['signature'] = SignatureWidget::class;

$GLOBALS['TL_DCA']['tl_form_field']['palettes']['signature'] = '{type_legend},type;{name_legend},name,label;{fconfig_legend},mandatory;{expert_legend:hide},class,accesskey,tabindex';
