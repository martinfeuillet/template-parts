<?php
/**
 * Employer bank - registration PDF
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

	$section_title = __( 'Coordonnées bancaires complètes de l\'employeur', 'crea' );

} else {

	$section_title = __( 'Coordonnées bancaires complètes de l\'employeur/du responsable de stage', 'crea' );
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

<!-- Coordonnée bancaires de l'employeur -->
<table class="col col-2x" valign="top">
	<tr>
		<td>
			<?php esc_html_e( 'Titulaire du compte', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $company->get_bank()->get_holder() ); ?></span>
		</td>
		<td>
			<?php esc_html_e( 'NPA et ville', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $company->get_bank()->get_city() ); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e( 'Nom de l’établissement', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $company->get_bank()->get_name() ); ?></span>
		</td>
		<td>
			<?php esc_html_e( 'IBAN', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $company->get_bank()->get_iban() ); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e( 'Clearing.', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $company->get_bank()->get_clearing() ); ?></span>
		</td>
		<td>
			<?php esc_html_e( 'Swift', 'crea' ); ?> : <span style="color: #1155cc;"><?php echo esc_html( $company->get_bank()->get_swift() ); ?></span>
		</td>
	</tr>
</table>

<?php
if (
	'brevet_federal' === $formation_type ||
	'formation_continue' === $formation_type
) {
	?>

	<p class="mt-0 mb-0">
		<em>*
			<?php esc_html_e( 'En cas de remboursement, sauf précision contraire, les montants dûs sont versés au titulaire du compte mentionné.', 'crea' ); ?>
		</em>
	</p>

<?php } ?>
