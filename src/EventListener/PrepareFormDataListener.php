<?php

 /**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    brightcloudstudio/contao-signature-form-field
 * @license    GPL-3.0-or-later
 * @link       https://github.com/brightcloudstudio/contao-signature-form-field
 */
    
namespace BCS\ContaoSignatureFormField\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Form;

use Dompdf\Dompdf;
use Dompdf\Options;

#[AsHook('prepareFormData')]
class PrepareFormDataListener
{
    /**
     * The Contao project root directory, injected via the constructor.
     * In services.yaml bind "%kernel.project_dir%" to $projectDir.
     */
    public function __construct(private readonly string $projectDir)
    {
    }

    public function __invoke(array &$submittedData, array $labels, array $fields, Form $form): void
    {
        // Initialize DomPDF
        $options = new Options();
        $options->set("defaultFont", "Times-Roman");
        $options->set("isRemoteEnabled", "true");
        $options->setChroot('/');
        $dompdf = new Dompdf($options);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer'       => FALSE,
                'verify_peer_name'  => FALSE,
                'allow_self_signed' => TRUE,
            ]
        ]);
        $dompdf->setHttpContext($context);


        // Get our template HTML
        $html = file_get_contents('bundles/contaosignatureformfield/templates/volunteer_coi_form.html', true);


        // Swap out template tags
        preg_match_all('/\{{2}(.*?)\}{2}/is', $html, $tags);
        foreach ($tags[0] as $tag) {

            // Remove brackets from our tag
            $cleanTag = str_replace("{{", "", $tag);
            $cleanTag = str_replace("}}", "", $cleanTag);

            $explodedTag = explode("::", $cleanTag);

            // Do different things based on the first part of our tag
            switch ($explodedTag[0]) {
                case 'server':
    		        switch($explodedTag[1]) {
    		            case 'root':
    		                $html = str_replace($tag, $_SERVER["DOCUMENT_ROOT"], $html);
    		                break;
    		        }
    		    break;
            }
        }


        // Load our HTML into dompdf
        $dompdf->loadHtml($html);

        // Set our paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render our PDF using the loaded HTML
        $dompdf->render();


        // ------------------------------------------------------------------
        // Save the PDF to public_html/files/content/volunteer_coi
        // ------------------------------------------------------------------

        // Build the absolute path to the save directory.
        // $this->projectDir is the Contao project root (one level above public/).
        // Adjust the path below if your web root folder is named differently
        // (e.g. "web" instead of "public_html").
        $saveDir = $this->projectDir . '/files/content/volunteer_coi';

        // Create the directory if it does not already exist
        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0755, true);
        }

        // Build a unique filename using a timestamp + random suffix
        $filename  = 'volunteer_coi_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.pdf';
        $filePath  = $saveDir . '/' . $filename;

        // Write the PDF bytes to disk instead of streaming to the browser
        $pdfContent = $dompdf->output();
        file_put_contents($filePath, $pdfContent);

        // Relative path from the web root – handy for storing as a URL or in Leads
        $relativeUrl = 'files/content/volunteer_coi/' . $filename;
        // ------------------------------------------------------------------


        $submittedData['first_name'] = 'Test';

        // Store the server-relative path to the saved PDF
        $submittedData['generated_pdf'] = $relativeUrl;

        // Add PDF URL to hidden field on form so it gets stored in Leads
    }
}
