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
$monthly_payments = get_field( 'diploma_contract_monthly_payement', $formation_id );

if ( ! empty( $monthly_payments ) ) {

	$monthly_payments_number     = ! empty( $monthly_payments['number'] ) ? $monthly_payments['number'] : '';
	$monthly_payments_amount     = ! empty( $monthly_payments['amount'] ) ? $monthly_payments['amount'] : '';
	$monthly_payments_start_date = ! empty( $monthly_payments['date_start'] ) ? $monthly_payments['date_start'] : '';
	$monthly_payments_end_date   = ! empty( $monthly_payments['date_end'] ) ? $monthly_payments['date_end'] : '';
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
						// translators: number of monthly payments, total price.
						esc_html__( 'En %1$d mensualités de CHF %2$s.- du %3$s au %4$s pour un montant total de CHF %5$s.-', 'crea' ),
						(int) $monthly_payments_number,
						number_format( $monthly_payments_amount, 0, ',', '\'' ),
						esc_html( $monthly_payments_start_date ),
						esc_html( $monthly_payments_end_date ),
						esc_html( $total_price_formatted ),
					);
					?>
				</p>
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
