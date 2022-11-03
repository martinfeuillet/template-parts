<?php
/**
 * Generate PDF
 */

use Mpdf\HTMLParserMode;
use Mpdf\Utils\UtfString;

require get_template_directory() . '/vendor/autoload.php';

//use Spipu\Html2Pdf\Html2Pdf;

/**
 * Fonction utlisé pour savegarder le PDF sur le serveur ou l'afficher directement
 *
 * @param string      $contract_id L'ID du contrat.
 * @param int         $formation L'ID de la formation.
 * @param Student     $student Informations concernant l'élève.
 * @param Parents     $contact1 Informations concernant la mère de l'élève.
 * @param Parents     $contact2 Informations concernant le père.
 * @param Company     $company Information concerrnant l'entreprise.
 * @param BankAccount $bank Informations concernant le compte en banque.
 * @param array       $formations Liste des anciennes formations.
 * @param string      $modalite_nb Le numéro de la modalité de paiement choisi.
 * @param string      $free_option_nb Le numéro de l'option gratuite choisie (non par défaut).
 * @param Bool        $save Si le formulaire est sauvegardé sur le serveur (par défaut: false).
 *
 * @return String Le chemain du PDF
 */
function get_pdf( string $contract_id, int $formation, Student $student, Parents $contact1, Parents $contact2, Company $company, BankAccount $bank, array $formations, string $modalite_nb = '', string $free_option_nb, bool $save = false ) {

	$upload_path = wp_get_upload_dir();
	$path        = $upload_path['basedir'] . '/registrations/contrat-' . $contract_id . '.pdf';
	$soft_path   = '/wp-content/uploads/registrations/contrat-' . $contract_id . '.pdf';
	$html_pdf    = pdf_generate_html( $formation, $student, $contact1, $contact2, $company, $bank, $formations, $modalite_nb, $free_option_nb );
	$page_footer = return_template_part( 'template-parts/registration/pdf/components/page/footer' );
	$stylesheet_path = file_get_contents( get_template_directory() . '/template-parts/registration/pdf/contract.css' );

	$mpdf = new \Mpdf\Mpdf(
		array(
			'mode'                 => 'c',
			'format'               => 'A4',
			'margin_top'           => 20,
			'margin_right'         => 20,
			'margin_bottom'        => 40,
			'margin_left'          => 20,
			'margin_footer'        => 0,
			'margin_footer'        => 30,
			'useSubstitutions'     => true,
			'shrink_tables_to_fit' => 0,
		)
	);

	$mpdf->setTitle( __( "Contrat d'admission", 'crea' ) );
	$mpdf->WriteHTML( $stylesheet_path, HTMLParserMode::HEADER_CSS );
	$mpdf->SetHTMLFooter( $page_footer );
	$mpdf->SetDisplayMode( 'real' );

	$mpdf->WriteHTML( $html_pdf );

	if ( $save ) {

		$mpdf->Output( $path, 'F' );
		$mpdf->cleanup();

		return $soft_path;
	} else {

		$mpdf->Output( 'contrat-' . $contract_id . '.pdf' );
		$mpdf->cleanup();
	}
}
