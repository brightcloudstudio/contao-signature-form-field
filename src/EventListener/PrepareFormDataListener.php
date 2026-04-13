<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    brightcloudstudio/contao-signature-form-field
 * @license    GPL-3.0-or-later
 * @link       https://github.com/brightcloudstudio/contao-signature-form-field
 */

namespace Bcs\ContaoSignatureFormField\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Environment;
use Contao\LayoutModel;
use Contao\PageModel;


#[AsHook('prepareFormData')]
class PrepareFormDataListener
{
    public function __invoke(array &$submittedData, array $labels, array $fields, Form $form): void
    {
        echo "<pre>";
        print_r($submittedData);
        echo "</pre>";
        die();
    }
}
