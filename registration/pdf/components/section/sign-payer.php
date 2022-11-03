<?php
/**
 * Third party payer - registration PDF
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

// Defining section numbers depending on formation type.
switch ( $formation_type ) {
	default:
		$clause_withdrawal_nb = 'IX';
		break;
}
?>

<p class="mb-0">
	<strong>
		<?php esc_html_e( 'LE TIERS-PAYEUR', 'crea' ); ?>
	</strong>
</p>

<p class="mb-0">
	<?php
	echo sprintf(
		// translators: section's number.
		esc_html__( 'Dans le cas où le candidat/étudiant accepte que les factures soient à adresser par CREA à une tierce personne (autre que le candidat/étudiant), cette tierce personne complète la section ci-dessous et contresigne le présent contrat d’admission, de manière à s\'engager à s\'acquitter personnellement des coûts de l\'écolage et des coûts liés (Sections V et VI ci-dessus, en particulier), le cas échéant de toutes sommes dues au titre de désistement (Section %s ci-dessus).', 'crea' ),
		$clause_withdrawal_nb // phpcs:ignore
	);
	?>
</p>

<p>
	<?php esc_html_e( 'Par sa signature, cette personne s\'engage ainsi, de manière indépendante et pour son propre compte, à acquitter en temps utile les factures que CREA lui fera parvenir en application du présent contrat d\'admission.', 'crea' ); ?>
</p>

<table class="mt" valign="top">
	<tr>
		<td style="width: 9%; padding-right: 16px;">
			<?php esc_html_e( 'Nom :', 'crea' ); ?>
		</td>
		<td style="width: 38%; border-bottom: 1px dotted #000000;"></td>
		<td style="width: 6%;"></td>
		<td style="width: 15%; padding-right: 8px;">
			<?php esc_html_e( 'Prénom :', 'crea' ); ?>
		</td>
		<td style="width: 32%; border-bottom: 1px dotted #000000;"></td>
	</tr>
</table>

<table class="mt" valign="top">
	<tr>
		<td style="width: 9%; padding-right: 16px;">
			<?php esc_html_e( 'Rue :', 'crea' ); ?>
		</td>
		<td style="width: 38%; border-bottom: 1px dotted #000000;"></td>
		<td style="width: 6%;"></td>
		<td style="width: 15%; padding-right: 8px;">
			<?php esc_html_e( 'NPA et Ville :', 'crea' ); ?>
		</td>
		<td style="width: 32%; border-bottom: 1px dotted #000000;"></td>
	</tr>
</table>

<table class="mt" valign="top">
	<tr>
		<td style="width: 9%; padding-right: 16px;">
			<?php esc_html_e( 'Mail :', 'crea' ); ?>
		</td>
		<td style="width: 38%; border-bottom: 1px dotted #000000;"></td>
		<td style="width: 6%;"></td>
		<td style="width: 15%; padding-right: 8px;">
			<?php esc_html_e( 'Mobile :', 'crea' ); ?>
		</td>
		<td style="width: 32%; border-bottom: 1px dotted #000000;"></td>
	</tr>
</table>

<table class="mt" valign="top">
	<tr>
		<td style="width: 47%;">
			<?php esc_html_e( 'Lieu et date :', 'crea' ); ?>
		</td>
		<td style="width: 6%;"></td>
		<td style="width: 47%;">
			<?php esc_html_e( 'Signature du tiers-payeur :', 'crea' ); ?>
		</td>
	</tr>
	<tr>
		<td style="width: 47%; height: 50px; border-bottom: 1px dotted #000000;">
		</td>
		<td style="width: 6%;"></td>
		<td style="width: 47%; height: 50px; border-bottom: 1px dotted #000000;">
		</td>
	</tr>
	<tr>
		<td style="width: 47%; font-size: 10px; padding-top: 8px;"></td>
		<td style="width: 6%;"></td>
		<td style="width: 47%; font-size: 10px; padding-top: 8px;">
			<?php esc_html_e( '(copie de la pièce d\'identité à fournir)', 'crea' ); ?>
		</td>
	</tr>
</table>

<p class="mt">
	<?php
	echo sprintf(
		// translators: section's number.
		esc_html__( 'Dans l\'éventualité où cette tierce personne ne s\'acquitterait pas des sommes dues à CREA en temps utile, CREA conserve l\'intégralité de ses droits à l\'encontre du candidat/étudiant pour exiger que ce dernier s\'acquitte de ses engagements stipulés notamment dans les Section V, VI et %s ci-dessus (et rappelés sur cette page de signatures).', 'crea' ),
		$clause_withdrawal_nb // phpcs:ignore
	);
	?>
</p>

<table class="mt-small" valign="top">
	<tr>
		<td style="width: 40%;">
			<?php esc_html_e( 'Nom et prénom du candidat/étudiant :' ); ?>
		</td>
		<td style="width: 60%; border-bottom: 1px dotted #000000;"></td>
	</tr>
</table>

<table class="mt" valign="top">
	<tr>
		<td style="width: 47%;">
			<?php esc_html_e( 'Lieu et date :', 'crea' ); ?>
		</td>
		<td style="width: 6%;"></td>
		<td style="width: 47%;">
			<?php esc_html_e( 'Signature du candidat/étudiant(e) :', 'crea' ); ?>
		</td>
	</tr>
	<tr>
		<td style="width: 47%; height: 50px; border-bottom: 1px dotted #000000;">
		</td>
		<td style="width: 6%;"></td>
		<td style="width: 47%; height: 50px; border-bottom: 1px dotted #000000;">
		</td>
	</tr>
</table>

<?php if ( 'bachelor' === $formation_type ) { ?>

	<p class="mt">
		<?php esc_html_e( 'La signature par CREA suit.', 'crea' ); ?>
	</p>

	<p>
		<strong>
			<?php esc_html_e( 'CREA ÉCOLE DE CRÉATION EN COMMUNICATION SA', 'crea' ); ?>
		</strong>
	</p>

	<table class="mt" valign="top">
		<tr>
			<td style="width: 47%;">
				<?php esc_html_e( 'Lieu et date :', 'crea' ); ?>
			</td>
			<td style="width: 6%;"></td>
			<td style="width: 47%;">
				<?php echo 'René Engelmann - ' . esc_html__( 'Directeur', 'crea' ); ?>
			</td>
		</tr>
		<tr>
			<td style="width: 47%; height: 50px; border-bottom: 1px dotted #000000;">
			</td>
			<td style="width: 6%;"></td>
			<td style="width: 47%; height: 50px; border-bottom: 1px dotted #000000;">
			</td>
		</tr>
	</table>

<?php } else { ?>

	<p class="mt">
		<?php
		if (
			'formation_continue' === $formation_type ||
			'brevet_federal' === $formation_type
		) {

			esc_html_e( 'Les signatures de l\'employeur et de CREA suivent.', 'crea' );

		} else {

			esc_html_e( 'Les signatures de l\'employeur/responsable de stage et de CREA suivent.', 'crea' );

		}
		?>
	</p>

<?php } ?>

<pagebreak />
