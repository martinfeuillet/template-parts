<?php

/**
 * Clause - Withdrawal - registration PDF
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

<!-- Clause de désistement -->
<?php
$disistment_clauses = get_field('disistment_clauses', $formation_id);

if (!empty($disistment_clauses)) {
?>

	<!-- Level 1 title -->
	<?php
	get_template_part(
		'template-parts/registration/pdf/components/section/title',
		null,
		array(
			'number' => $section_number++,
			'title'  => __('Clauses de désistement', 'crea'),
		),
	);
	?>

	<?php
	foreach ($disistment_clauses as $index => $disistment_clause) {
	?>

		<?php if (!empty($disistment_clause['title'])) { ?>
			<p class="<?php echo 0 === $index ? 'mt-0' : 'mt-small'; ?>">
				<strong>
					<?php echo esc_html($disistment_clause['title']); ?>
				</strong>
			</p>
		<?php } ?>
		<?php
		echo wp_kses_post(
			str_replace(
				'<p>',
				'<p class="mt-0">',
				wpautop($disistment_clause['clause']),
			)
		);
		?>
	<?php
	}
	?>

	<p class="mb-0">
		<strong>
			<?php
			if ('brevet_federal' === $formation_type) {

				esc_html_e("Important : La résiliation du présent contrat d'admission, par l'une des parties, doit être formellement portée à la connaissance de l'autre, par lettre recommandée. L'information par courriel n'est pas admise ni valable.", 'crea');
			} else {

				esc_html_e("Important : Tout désistement, selon ce qui précède, doit être formellement portée à la connaissance de CREA par lettre recommandée. La date de réception fait foi. L’information par courriel n’est pas admise ni valable.", 'crea');
			}
			?>
		</strong>
	</p>

<?php
}
?>