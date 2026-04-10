<?php

declare(strict_types=1);

use BCS\ContaoSignatureFormField\Backend\LeadDataRenderer;

if (isset($GLOBALS['TL_DCA']['tl_lead_data']))
{
    $GLOBALS['TL_DCA']['tl_lead_data']['list']['sorting']['child_record_callback'] = [LeadDataRenderer::class, 'generateChildRecord'];
}
