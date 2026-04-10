<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    brightcloudstudio/contao-signature-form-field
 * @license    GPL-3.0-or-later
 * @link       https://github.com/brightcloudstudio/contao-signature-form-field
 */

declare(strict_types=1);

namespace BCS\ContaoSignatureFormField\ContaoManager;

use BCS\ContaoSignatureFormField\ContaoSignatureFormFieldBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return array(
            BundleConfig::create(ContaoSignatureFormFieldBundle::class)
                ->setLoadAfter(array(ContaoCoreBundle::class)),
        );
    }
}
