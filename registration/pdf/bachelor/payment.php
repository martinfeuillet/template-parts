<?php
/**
 * Payment - registration PDF
 * Used for Bachelors
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

$total_price_formatted = number_format( get_field( 'total_price', $formation_id ), 0, ',', '\'' );

?>

<!-- Level 1 title -->
<?php
get_template_part(
	'template-parts/registration/pdf/components/section/title',
	null,
	array(
		'number' => $section_number++,
		'title'  => __( 'Modalités de paiement', 'crea' ),
	),
);
?>

<!-- Modalités de paiement -->
<p class="mt-0 mb-0">
	<?php
	echo sprintf(
		// translators: Total price.
		esc_html__( 'Je m\'engage à verser le montant de CHF %s.- à CREA selon ce qui suit.', 'crea' ),
		esc_html( $total_price_formatted )
	);
	?>
	<br>
	<?php esc_html_e( 'Les échéances sont à respecter, même pendant les périodes de stages ou de vacances.', 'crea' ); ?>
</p>

<p class="mb-0">
	<?php esc_html_e( 'Veuillez cochez la variante choisie', 'crea' ); ?> :
</p>

<!-- En 3 tranches -->
<?php
if ( have_rows( 'diploma_contract_split_payment', $formation_id ) ) {
	?>
	<table class="checkbox" valign="top">
		<tr>
			<td class="checkbox__box" valign="top">
				<?php if ( ! empty( $modalite_nb ) && 1 === (int) $modalite_nb ) { ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="19"><path fill="#1155cc" d="M400 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zm0 400H48V80h352v352zm-35.864-241.724L191.547 361.48c-4.705 4.667-12.303 4.637-16.97-.068l-90.781-91.516c-4.667-4.705-4.637-12.303.069-16.971l22.719-22.536c4.705-4.667 12.303-4.637 16.97.069l59.792 60.277 141.352-140.216c4.705-4.667 12.303-4.637 16.97.068l22.536 22.718c4.667 4.706 4.637 12.304-.068 16.971z"/></svg>
				<?php } else { ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="19"><path fill="#000000" d="M400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zm-6 400H54c-3.3 0-6-2.7-6-6V86c0-3.3 2.7-6 6-6h340c3.3 0 6 2.7 6 6v340c0 3.3-2.7 6-6 6z"/></svg>
				<?php } ?>
			</td>
			<td>
				<?php $split_pay_count = ACF_rows_count( 'diploma_contract_split_payment', $formation_id ); ?>
				<p>
					<?php
					echo sprintf(
						// translators: numbers of payments, total price.
						esc_html__( 'En %1$s tranches pour un montant total de CHF %2$s.-', 'crea' ),
						absint( $split_pay_count ),
						esc_html( $total_price_formatted ),
					);
					?>
				</p>
				<p style="margin-top:16px;">
					<?php
					$split_payments    = get_field( 'diploma_contract_split_payment', $formation_id );
					$split_payments_nb = count( $split_payments );

					foreach ( $split_payments as $index => $split_payment ) {

						echo sprintf(
							// translators: year, price, date.
							esc_html__( '%1$s : CHF %2$s.- au %3$s', 'crea' ),
							esc_html( $split_payment['split_payment_label'] ),
							esc_html( number_format( (int) $split_payment['split_payment_price'], 0, ',', '\'' ) ),
							esc_html( $split_payment['split_payment_due_date'] ),
						);

						echo ( $index + 1 === (int) $split_payments_nb ) ? '' : '<br>';
					}
					?>
				</p>
			</td>
		</tr>
	</table>
	<?php
}
?>

<!-- En trimestre -->
<?php
if (
	have_rows( 'tab_head', $formation_id ) &&
	have_rows( 'tab_body', $formation_id )
) {
	?>
	<table class="checkbox" valign="top">
		<tr>
			<td class="checkbox__box" valign="top">
				<?php if ( ! empty( $modalite_nb ) && 2 === (int) $modalite_nb ) { ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="19"><path fill="#1155cc" d="M400 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zm0 400H48V80h352v352zm-35.864-241.724L191.547 361.48c-4.705 4.667-12.303 4.637-16.97-.068l-90.781-91.516c-4.667-4.705-4.637-12.303.069-16.971l22.719-22.536c4.705-4.667 12.303-4.637 16.97.069l59.792 60.277 141.352-140.216c4.705-4.667 12.303-4.637 16.97.068l22.536 22.718c4.667 4.706 4.637 12.304-.068 16.971z"/></svg>
				<?php } else { ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="19"><path fill="#000000" d="M400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zm-6 400H54c-3.3 0-6-2.7-6-6V86c0-3.3 2.7-6 6-6h340c3.3 0 6 2.7 6 6v340c0 3.3-2.7 6-6 6z"/></svg>
				<?php } ?>
			</td>
			<td>
				<p>
					<?php
					echo sprintf(
						// translators: total price.
						esc_html__( 'En trimestres selon le calendrier suivant pour un montant total de CHF %s.-', 'crea' ),
						esc_html( $total_price_formatted ),
					);
					?>
				</p>

				<table class="border p-small mt-small" valign="middle" style="font-size: 95%; padding-left: 0;">
					<tr>
						<th style="width: 20%;">
							<div style="text-align: left;"><?php esc_html_e( 'Versements', 'crea' ); ?></div>
						</th>
						<?php
						if ( have_rows( 'tab_head', $formation_id ) ) {
							while ( have_rows( 'tab_head', $formation_id ) ) {
								the_row();
								?>
								<th style="width: 16%;">
									<div><?php echo esc_html( get_sub_field( 'label' ) ); ?></div>
								</th>
								<?php
							}
						}
						?>
						<th style="width: 16%;">
							<div><strong><?php esc_html_e( 'Total CHF', 'crea' ); ?></strong></div>
						</th>
					</tr>

					<?php
					$terms_rows = get_field( 'tab_body', $formation_id );

					if ( ! empty( $terms_rows ) ) {
						foreach ( $terms_rows as $index => $term_row ) {
							?>
							<tr>
								<td style="width: 16%;">
									<div style="text-align: left;"><?php echo esc_html( $term_row['row_title'] ); ?></div>
								</td>
								<td style="width: 16%;">
									<div>
										<?php echo 'CHF ' . ( ! empty( $term_row['col_1'] ) ? number_format( esc_html( $term_row['col_1'] ), 0, ',', '\'' ) : '-' ) . '.-'; ?>
									</div>
								</td>
								<td style="width: 16%;">
									<div>
										<?php echo 'CHF ' . ( ! empty( $term_row['col_2'] ) ? number_format( esc_html( $term_row['col_2'] ), 0, ',', '\'' ) : '-' ) . '.-'; ?>
									</div>
								</td>
								<td style="width: 16%;">
									<div>
										<?php echo 'CHF ' . ( ! empty( $term_row['col_3'] ) ? number_format( esc_html( $term_row['col_3'] ), 0, ',', '\'' ) : '-' ) . '.-'; ?>
									</div>
								</td>
								<td style="width: 16%;">
									<div>
										<?php echo 'CHF ' . ( ! empty( $term_row['col_4'] ) ? number_format( esc_html( $term_row['col_4'] ), 0, ',', '\'' ) : '-' ) . '.-'; ?>
									</div>
								</td>
								<td style="width: 16%;">
									<div>
										<strong>
											<?php
											echo 'CHF ' .
											number_format(
												esc_html( (int) $term_row['col_1'] + (int) $term_row['col_2'] + (int) $term_row['col_3'] + (int) $term_row['col_4'] ),
												0,
												',',
												'\''
											) .
											'.-';
											?>
										</strong>
									</div>
								</td>
							</tr>
							<?php
						}
					}
					?>
				</table>
			</td>
		</tr>
	</table>
	<?php
}
?>

<!-- En mensualités -->
<?php
$monthly_payments         = get_field( 'diploma_contract_monthly_payement', $formation_id );
$monthly_payments_numbers = 0;

if ( ! empty( $monthly_payments ) ) {

	// Get number of monthly payments.
	foreach ( $monthly_payments as $monthly_payment ) {
		++$monthly_payments_numbers;
		$monthly_payments_numbers += (int) $monthly_payment['monthly_payement_number_months'];
	};
	?>

	<table class="checkbox" valign="top">
		<tr>
			<td class="checkbox__box" valign="top">
				<?php if ( ! empty( $modalite_nb ) && 3 === (int) $modalite_nb ) { ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="19"><path fill="#1155cc" d="M400 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zm0 400H48V80h352v352zm-35.864-241.724L191.547 361.48c-4.705 4.667-12.303 4.637-16.97-.068l-90.781-91.516c-4.667-4.705-4.637-12.303.069-16.971l22.719-22.536c4.705-4.667 12.303-4.637 16.97.069l59.792 60.277 141.352-140.216c4.705-4.667 12.303-4.637 16.97.068l22.536 22.718c4.667 4.706 4.637 12.304-.068 16.971z"/></svg>
				<?php } else { ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="19"><path fill="#000000" d="M400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zm-6 400H54c-3.3 0-6-2.7-6-6V86c0-3.3 2.7-6 6-6h340c3.3 0 6 2.7 6 6v340c0 3.3-2.7 6-6 6z"/></svg>
				<?php } ?>
			</td>
			<td>
				<p>
					<?php
					echo sprintf(
						// translators: number of monthly payments, total price.
						esc_html__( 'En %1$s mensualités pour un montant total de CHF %2$s.-', 'crea' ),
						(int) $monthly_payments_numbers,
						esc_html( $total_price_formatted ),
					);
					?>
				</p>
				<?php
				foreach ( $monthly_payments as $monthly_payment ) {

					$monthly_payment_total = (float) $monthly_payment['monthly_payement_1st_month'] + ( (float) $monthly_payment['monthly_payement_number_months'] * (float) $monthly_payment['monthly_payement_month_price'] );
					?>
					<p>
						<strong><?php echo esc_html( $monthly_payment['monthly_payement_label'] ); ?></strong>
						<br>
						<?php
						echo sprintf(
							// translators: monthly payment amount, monthly payment date.
							esc_html__( '1ère mensualité de CHF %1$s.- au %2$s', 'crea' ),
							number_format( esc_html( $monthly_payment['monthly_payement_1st_month'] ), 0, ',', '\'' ),
							esc_html( $monthly_payment['monthly_payement_1st_due_date'] ),
						);
						?>
						<br>
						<?php
						echo sprintf(
							// translators: mensual payments numbers, amount, start date, end date.
							esc_html__( '%1$s mensualités de CHF %2$s.- du %3$s au %4$s', 'crea' ),
							(int) $monthly_payment['monthly_payement_number_months'],
							number_format( esc_html( $monthly_payment['monthly_payement_month_price'] ), 0, ',', '\'' ),
							esc_html( $monthly_payment['monthly_payement_start_date'] ),
							esc_html( $monthly_payment['monthly_payement_end_date'] ),
						);
						?>
						<br>
						<?php
						echo sprintf(
							// translators: total price.
							esc_html__( 'Total : CHF %s.-', 'crea' ),
							number_format( (int) $monthly_payment_total, 0, ',', '\'' ),
						);
						?>
					</p>
					<?php
				}
				?>
			</td>
		</tr>
	</table>

	<?php
}
?>

<!-- Convention spécifique -->
<?php
$custom_payment = get_field( 'custom_payment', $formation_id );

if ( ! empty( $custom_payment['title'] ) ) {
	?>

	<table class="checkbox" valign="top">
		<tr>
			<td class="checkbox__box" valign="top">
				<?php if ( ! empty( $modalite_nb ) && 4 === (int) $modalite_nb ) { ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="19"><path fill="#1155cc" d="M400 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zm0 400H48V80h352v352zm-35.864-241.724L191.547 361.48c-4.705 4.667-12.303 4.637-16.97-.068l-90.781-91.516c-4.667-4.705-4.637-12.303.069-16.971l22.719-22.536c4.705-4.667 12.303-4.637 16.97.069l59.792 60.277 141.352-140.216c4.705-4.667 12.303-4.637 16.97.068l22.536 22.718c4.667 4.706 4.637 12.304-.068 16.971z"/></svg>
				<?php } else { ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="19"><path fill="#000000" d="M400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zm-6 400H54c-3.3 0-6-2.7-6-6V86c0-3.3 2.7-6 6-6h340c3.3 0 6 2.7 6 6v340c0 3.3-2.7 6-6 6z"/></svg>
				<?php } ?>
			</td>
			<td>
				<p>
					<?php echo esc_html( $custom_payment['title'] ); ?>
					<br>
					<?php
					if ( ! empty( $custom_payment['body'] ) ) {
						echo wp_kses(
							str_replace(
								'<br><br>',
								'<br>',
								nl2br( $custom_payment['body'] )
							),
							array(
								'strong' => array(),
								'em'     => array(),
								'br'     => array(),
							)
						);
					}
					?>
				</p>
			</td>
		</tr>
	</table>
	<?php
}
?>
