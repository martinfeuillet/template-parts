<?php
/**
 * Period - registration PDF
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
get_template_part(
	'template-parts/registration/pdf/components/section/title',
	null,
	array(
		'number' => $section_number++,
		'title'  => __( 'Délais', 'crea' ),
	),
);
?>

<?php
$contract_back_extra_text = get_post_meta( $formation_id, 'contract_back_text', true );
$period = get_field( 'diploma_period', $formation_id );
?>

<table class="border valign-top" valign="top" style="padding-left: 0;">
	<tr>
		<th style="width: 50%; text-align: left;">
			<?php esc_html_e( 'Retour contrat d\'admission et dossier', 'crea' ); ?>
		</th>
		<th style="width: 50%; text-align: left;">
			<?php esc_html_e( 'Examen d\'entrée', 'crea' ); ?>
		</th>
	</tr>
	<tr>
		<td style="width: 50%; text-align: left;">
			<strong>
				<?php echo esc_html( crea_get_date( 'contract_back', true, $formation_id ) ) . ( ! empty( $contract_back_extra_text ) ? ' <em>' . esc_html( $contract_back_extra_text ) . '</em>' : '' ); ?>
			</strong>
			<br>
			<?php echo esc_html( $period['sendback_contract'] ); ?>
		</td>
		<td style="width: 50%; text-align: left;">
			<strong>
				<?php echo esc_html( get_field( 'entry_exam_date', $formation_id ) ); ?>.
			</strong>
			<br>
			<?php echo esc_html( $period['exam_place'] ); ?>
		</td>
	</tr>
</table>

<?php
if ( ! empty( $period['disclaimer'] ) ) {
	?>

	<div class="mt">
		<?php
		echo wp_kses_post(
			str_replace(
				'<p>',
				'<p class="mt-0">',
				wpautop( $period['disclaimer'] )
			)
		);
		?>
	</div>

	<?php
}
?>
