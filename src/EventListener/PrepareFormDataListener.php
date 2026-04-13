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
    public function __invoke(array &$submittedData, array $labels, array $fields, Form $form): void
    {


        // Initialize DomPDF stuffs
        $options = new Options();
        $options->set("defaultFont", "Times-Roman");
        $options->set("isRemoteEnabled", "true");
        $options->setChroot('/');
    	$dompdf = new Dompdf($options);
    	$context = stream_context_create([ 
        	'ssl' => [ 
        		'verify_peer' => FALSE, 
        		'verify_peer_name' => FALSE,
        		'allow_self_signed'=> TRUE 
        	] 
        ]);
        $dompdf->setHttpContext($context);



        // Get our template HTML
        //$html = file_get_contents('../templates/volunteer_coi_form.html', true);
        $html = file_get_contents('bundles/contaosignatureformfield/templates/volunteer_coi_form.html', true);


        // Swap out template tags
        preg_match_all('/\{{2}(.*?)\}{2}/is', $html, $tags);
        foreach($tags[0] as $tag) {
            
            // Remove brackets from our tag
            $cleanTag = str_replace("{{","",$tag);
            $cleanTag = str_replace("}}","",$cleanTag);
            
    	    $explodedTag = explode("::", $cleanTag);
    	    
    	    // Do different things based on the first part of our tag
    	    switch($explodedTag[0]) {
    		    
    		    case 'member':
    		        switch($explodedTag[1]) {
    		            case 'name':
    		                $html = str_replace($tag, $member['name'], $html);
    		                break;
    		        }
    		    break;
    	    }
        }


        // Load our HTML into dompdf
    	$dompdf->loadHtml($html);
    	
    	// Set our paper size and orientation
    	$dompdf->setPaper('A4', 'landscape');
    	
    	// Render our PDF using the loaded HTML
    	$dompdf->render();
    	
    	// Output the generated PDF to Browser
    	$dompdf->stream("certificate.pdf");


        
        $submittedData['first_name'] = 'Test';

        // Generate PDF

        // Store PDF
        $submittedData['generated_pdf'] = 'https://www.youtube.com/watch?v=1O2d5yoLsok';

        // Add PDF URL to hidden field on form so it gets stored in Leads
     
    }
}
