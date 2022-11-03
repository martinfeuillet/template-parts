<?php
/**
 * Clause - Adjournment - registration PDF
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

<!-- Report du contrat d'admission -->
<?php
$contract_deferral = get_field( 'contract_deferral', $formation_id );

if ( ! empty( $contract_deferral ) ) {
	?>

	<!-- Level 1 title -->
	<?php
	get_template_part(
		'template-parts/registration/pdf/components/section/title',
		null,
		array(
			'number' => $section_number++,
			'title'  => __( 'Report du contrat d\'admission', 'crea' ),
		),
	);
	?>

	<?php
	echo wp_kses_post(
		str_replace(
			'<p>',
			'<p class="mt-0">',
			wpautop( $contract_deferral )
		)
	);
	?>

	<?php
}
?>
