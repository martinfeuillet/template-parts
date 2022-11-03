<?php
/**
 * Documents - registration PDF
 *
 * @param int         $formation_id
 * @param string      $formation_type
 * @param string      $sesion_start_date Session start date formatted in date.
 * @param string      $session_start_year Session start date year.
 * @param string      $session_start_month_year Session start date month and year.
 * @param string      $sesion_end_date Session end date formatted in date.
 * @param string      $session_end_year Session end date year.
 * @param string      $session_end_month_year Session end date month and year.
 * @param string      $base_pdf_path Path of registration pdf files.
 * @param string      $padding_bottom Padding at the bottom of the page.
 * @param Student     $student
 * @param Parents     $contact1
 * @param Parents     $contact2
 * @param Company     $company
 * @param BankAccount $bank
 * @param array       $formations List of past formations.
 * @param string      $modalite_nb
 * @param string      $free_option_nb
 * @param string      $section_number
 * @param string      $formation_name
 *
 * @package WordPress
 * @subpackage Crea
 */

$documents = get_field( 'diploma_contract_document_mandatory', $formation_id );

if ( ! empty( $documents ) ) {
	?>

	<!-- Level 1 title -->
	<?php
	get_template_part(
		'template-parts/registration/pdf/components/section/title',
		null,
		array(
			'number' => $section_number++,
			'title'  => __( 'Documents à fournir pour le dossier de candidature', 'crea' ),
		),
	);
	?>

	<!-- Documents à fournir -->
	<ul>
		<?php foreach ( $documents as $document ) { ?>
			<li><?php echo esc_html( $document['document_mandatory_element'] ); ?></li>
		<?php } ?>
	</ul>
	<p class="mt-small"><?php esc_html_e( 'Le dossier complet doit être envoyé à l\'adresse suivante ou à', 'crea' ); ?> inscriptions@creageneve.com :</p>
	<p class="mt-0 mb-0">
		<?php esc_html_e( 'CREA - ÉCOLE DE CRÉATION EN COMMUNICATION SA', 'crea' ); ?><br>
		<?php esc_html_e( 'Rte des Acacias 43', 'crea' ); ?><br>
		<?php esc_html_e( '1227 Genève - Acacias', 'crea' ); ?>
	</p>

	<?php
}
?>
