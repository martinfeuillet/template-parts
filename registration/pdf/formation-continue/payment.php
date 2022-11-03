<?php
/**
 * Payment - registration PDF
 * Used for Certificats and Brevets Federaux
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

<!-- En ligne -->
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
				<?php esc_html_e( 'Je souhaite payer directement en ligne', 'crea' ); ?>
			</p>
		</td>
	</tr>
</table>

<!-- En 1 tranche -->
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
			<?php
			$split_pay_date = get_field( 'diploma_contract_split_payment_date', $formation_id );
			?>
			<p>
				<?php
				echo sprintf(
					// translators: numbers of payments, total price.
					esc_html__( 'En 1 tranche pour un montant total de CHF %1$s.- au %2$s', 'crea' ),
					esc_html( $total_price_formatted ),
					esc_html( $split_pay_date )
				);
				?>
			</p>
		</td>
	</tr>
</table>

<!-- En mensualités -->
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
						esc_html__( 'En mensualités selon le plan de paiement suivant pour un montant total de CHF %s.-', 'crea' ),
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

							$cell_width = ! empty( $term_row['col_4'] ) ? '16%' : '20%';
							?>
							<tr>
								<td style="width: <?php echo $cell_width; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>;">
									<div style="text-align: left;"><?php echo esc_html( $term_row['row_title'] ); ?></div>
								</td>
								<td style="width: <?php echo $cell_width; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>;">
									<div>
										<?php echo 'CHF ' . ( ! empty( $term_row['col_1'] ) ? number_format( esc_html( $term_row['col_1'] ), 0, ',', '\'' ) : '-' ) . '.-'; ?>
									</div>
								</td>
								<td style="width: <?php echo $cell_width; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>;">
									<div>
										<?php echo 'CHF ' . ( ! empty( $term_row['col_2'] ) ? number_format( esc_html( $term_row['col_2'] ), 0, ',', '\'' ) : '-' ) . '.-'; ?>
									</div>
								</td>
								<td style="width: <?php echo $cell_width; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>;">
									<div>
										<?php echo 'CHF ' . ( ! empty( $term_row['col_3'] ) ? number_format( esc_html( $term_row['col_3'] ), 0, ',', '\'' ) : '-' ) . '.-'; ?>
									</div>
								</td>

								<?php if ( ! empty( $term_row['col_4'] ) ) { ?>
									<td style="width: <?php echo $cell_width; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>;">
										<div>
											<?php echo 'CHF ' . ( ! empty( $term_row['col_4'] ) ? number_format( esc_html( $term_row['col_4'] ), 0, ',', '\'' ) : '-' ) . '.-'; ?>
										</div>
									</td>
								<?php } ?>

								<td style="width: <?php echo $cell_width; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>;">
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

<p>
	<?php esc_html_e( 'Si la formation est co-financée par l\'entreprise, les quotes-parts sont mentionnées ci-dessous.', 'crea' ); ?>
</p>

<?php
$company_part = $company->get_quote_part();
?>
<table valign="top">
	<tr>
		<td style="width: 10%; ">
			<?php esc_html_e( 'Privé', 'crea' ); ?>
		</td>
		<td style="width: 37%; border-bottom: 1px dotted #000000;">
			<span style="color: #1155cc;"><?php echo esc_html( 100 - (float) $company_part ) . ' %'; ?></span>
		</td>
		<td style="width: 6%;"></td>
		<td style="width: 15%;">
			<?php esc_html_e( 'Entreprise', 'crea' ); ?>
		</td>
		<td style="width: 32%; border-bottom: 1px dotted #000000;">
			<span style="color: #1155cc;"><?php echo esc_html( $company_part ) . ' %'; ?></span>
		</td>
	</tr>
</table>

<p>
	<?php esc_html_e( 'Si la facture est à envoyer à l’entreprise : indiquer l’adresse précise de facturation à la section V du contrat d’admission sous « Coordonnées et adresse de l\'entreprise », puis ajouter le cachet de l’entreprise et la signature de votre direction à la fin du présent document.', 'crea' ); ?>
</p>
