<?php
/**
 * Employer identity - registration PDF
 * Used for Masters
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

?>

<!-- Level 1 title -->
<?php
if (
	'formation_continue' === $formation_type ||
	'brevet_federal' === $formation_type
) {

	$section_title = __( 'Coordonnées et adresse de l\'employeur', 'crea' );

} else {

	$section_title = __( 'Coordonnées et adresse de l\'employeur/du responsable de stage', 'crea' );
}

get_template_part(
	'template-parts/registration/pdf/components/section/title',
	null,
	array(
		'number' => $section_number++,
		'title'  => $section_title,
	),
);
?>

<!-- Coordonnée de l'employeur -->
<table class="col col-2x" valign="top">
	<tr>
		<td>
			<?php esc_html_e( 'Raison sociale', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $company->get_name() ); ?></span>
		</td>
		<td>
			<?php esc_html_e( 'Rue', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $company->get_street() ); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e( 'NPA et ville', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $company->get_city() ); ?></span>
		</td>
		<td>
			<?php esc_html_e( 'Mail', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $company->get_mail() ); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e( 'Tél.', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $company->get_tel() ); ?></span>
		</td>
		<td>
			<?php esc_html_e( 'Mobile', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $company->get_mobile() ); ?></span>
		</td>
	</tr>
</table>
