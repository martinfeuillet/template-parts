<?php
/**
 * Registration - registration PDF
 * Used for Brevets federaux
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

$formation_prices      = get_prices_data( $formation_id );
$total_price           = isset( $formation_prices['price'] ) ? $formation_prices['price'] : '';
$total_price_formatted = isset( $formation_prices['price_formatted'] ) ? $formation_prices['price_formatted'] : '';
?>

<!-- Level 1 title -->
<?php
$incription_after_title = ! empty( $formation_prices['early_title'] ) ? wp_kses( $formation_prices['early_title'], array( 'del' => array() ) ) : '';

get_template_part(
	'template-parts/registration/pdf/components/section/title',
	null,
	array(
		'number' => $section_number++,
		'title'  => __( 'Inscription', 'crea' ) . ' ' . ( ! empty( $incription_after_title ) ? '(' . esc_html( $incription_after_title ) . ')' : '' ),
	),
);
?>

<p class="mt-0">
	<strong>
		<?php
		echo sprintf(
			// translators: Year of the start, year of the end, price formatted.
			esc_html__( 'Par ma signature, je confirme mon inscription ferme ?? la session %1$s-%2$s de l?????cole CREA pour un montant d?????colage total de %3$s.', 'crea' ),
			esc_html( $session_start_month_year ),
			esc_html( $session_end_month_year ),
			wp_kses(
				$total_price_formatted,
				array(
					'del' => array(),
				)
			),
		);
		?>
	</strong>
</p>

<?php
$supplementary_option = get_field( 'supplementary_options', $formation_id );

if ( ! empty( $supplementary_option ) ) {
	echo wp_kses_post(
		wpautop( $supplementary_option )
	);
}
?>

<?php
$not_included = get_post_meta( $formation_id, 'diploma_contract_not_include', true );

if ( ! empty( $not_included ) ) {

	echo wp_kses_post(
		str_replace(
			array(
				'<p>',
				'<ul>',
			),
			array(
				'<p class="mt-0">',
				'<ul class="mb-0">',
			),
			wpautop( $not_included )
		)
	);
}
?>

<?php
$free_options_intro = get_post_meta( $formation_id, 'supplementary_free_options_before_choice', true );
$free_options_yes   = get_post_meta( $formation_id, 'supplementary_free_options_choice_yes', true );
$free_options_no    = get_post_meta( $formation_id, 'supplementary_free_options_choice_no', true );

if ( ! empty( $free_options_yes ) && ! empty( $free_options_no ) ) {
	?>

	<?php if ( ! empty( $free_options_intro ) ) { ?>

		<p class="mb-0">
			<?php
			echo wp_kses(
				nl2br( $free_options_intro ),
				array(
					'br'     => array(),
					'strong' => array(),
				)
			);
			?>
		</p>

	<?php } ?>

	<table class="checkbox mt-small" valign="top">
		<tr>
			<td class="checkbox__box" valign="top">
				<?php if ( ! empty( $free_option_nb ) && 1 === (int) $modalite_nb ) { ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="19"><path fill="#1155cc" d="M400 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zm0 400H48V80h352v352zm-35.864-241.724L191.547 361.48c-4.705 4.667-12.303 4.637-16.97-.068l-90.781-91.516c-4.667-4.705-4.637-12.303.069-16.971l22.719-22.536c4.705-4.667 12.303-4.637 16.97.069l59.792 60.277 141.352-140.216c4.705-4.667 12.303-4.637 16.97.068l22.536 22.718c4.667 4.706 4.637 12.304-.068 16.971z"/></svg>
				<?php } else { ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="19"><path fill="#000000" d="M400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zm-6 400H54c-3.3 0-6-2.7-6-6V86c0-3.3 2.7-6 6-6h340c3.3 0 6 2.7 6 6v340c0 3.3-2.7 6-6 6z"/></svg>
				<?php } ?>
			</td>
			<td>
				<p>
					<?php echo esc_html( $free_options_yes ); ?>
				</p>
			</td>
		</tr>
	</table>

	<table class="checkbox" valign="top">
		<tr>
			<td class="checkbox__box" valign="top">
				<?php if ( ! empty( $free_option_nb ) && 2 === (int) $modalite_nb ) { ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="19"><path fill="#1155cc" d="M400 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zm0 400H48V80h352v352zm-35.864-241.724L191.547 361.48c-4.705 4.667-12.303 4.637-16.97-.068l-90.781-91.516c-4.667-4.705-4.637-12.303.069-16.971l22.719-22.536c4.705-4.667 12.303-4.637 16.97.069l59.792 60.277 141.352-140.216c4.705-4.667 12.303-4.637 16.97.068l22.536 22.718c4.667 4.706 4.637 12.304-.068 16.971z"/></svg>
				<?php } else { ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="19"><path fill="#000000" d="M400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zm-6 400H54c-3.3 0-6-2.7-6-6V86c0-3.3 2.7-6 6-6h340c3.3 0 6 2.7 6 6v340c0 3.3-2.7 6-6 6z"/></svg>
				<?php } ?>
			</td>
			<td>
				<p>
					<?php echo esc_html( $free_options_no ); ?>
				</p>
			</td>
		</tr>
	</table>

	<?php
}
?>

<?php
$travel_title = get_post_meta( $formation_id, 'diploma_travels_title', true );
$travel_body  = get_post_meta( $formation_id, 'diploma_travels_body', true );

if ( ! empty( $travel_body ) ) {
	?>
	<p class="mb-0"><strong><?php echo esc_html( $travel_title ); ?></strong></p>
	<?php
	echo wp_kses_post(
		wpautop( $travel_body )
	);
	?>
	<?php
}
?>

<p class="mt-small">
	<?php esc_html_e( 'Les r??glements sont ?? effectuer sur le compte suivant', 'crea' ); ?> :
	<br>
	CREA - ??COLE DE CR??ATION EN COMMUNICATION SA<br>
	Cr??dit Suisse, Gen??ve / IBAN : CH30 0483 5175 2978 1100 1 / Clearing : 4835 / Swift CRESCHZZ80A
</p>

<?php
$registration_date_text = get_post_meta( $formation_id, 'inscription_info', true );
?>
<table class="col mt-small" valign="top">
	<tr>
		<td style="width: 25%;">
			<strong><?php esc_html_e( 'Inscription', 'crea' ); ?> :</strong>
		</td>
		<td style="width: 75%;">
			<strong>
				<?php echo esc_html( crea_get_date( 'contract_back', true, $formation_id ) ); ?>
			</strong>
			<br>
			<em>
				<?php echo esc_html( $registration_date_text ); ?>
			</em>
		</td>
	</tr>
	<tr>
		<td style="width: 25%;">
			<strong><?php esc_html_e( 'D??but des cours', 'crea' ); ?> :</strong>
		</td>
		<td style="width: 75%;">
			<strong><?php echo esc_html( crea_get_date( 'session_start', true, $formation_id ) ); ?></strong>
		</td>
	</tr>
	<tr>
		<td style="width: 25%;">
			<strong><?php esc_html_e( 'Fin des cours', 'crea' ); ?> :</strong>
		</td>
		<td style="width: 75%;">
			<strong><?php echo esc_html( mb_convert_case( crea_get_date( 'session_end', false, $formation_id ), MB_CASE_TITLE, 'UTF-8' ) ); ?></strong>
		</td>
	</tr>

	<?php
	if ( 'brevet_federal' === $formation_type ) {

		$exam_dates = crea_get_formation_exams_date( 'exam_written', 'exam_oral', $formation_id );
		?>
		<tr>
			<td style="width: 25%;">
				<strong>
					<?php
					echo esc_html__( 'Examens du', 'crea' )
					. ' ' .
					esc_html(
						get_post_type_object( $formation_type )->labels->singular_name
					)
					. ' ' .
					esc_html__( '??crit et oral', 'crea' );
					?>
					:
				</strong>
			</td>
			<td style="width: 75%;">
				<strong><?php echo esc_html( mb_convert_case( $exam_dates, MB_CASE_TITLE, 'UTF-8' ) ); ?></strong>
			</td>
		</tr>
		<?php
	}
	?>
</table>
