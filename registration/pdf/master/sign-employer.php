<?php
/**
 * Employer payer - registration PDF
 * Used on Masters
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

<p class="mb-0">
	<strong>
		<?php
		if (
			'formation_continue' === $formation_type ||
			'brevet_federal' === $formation_type
		) {

			esc_html_e( 'EMPLOYEUR', 'crea' );

		} else {

			esc_html_e( 'EMPLOYEUR/RESPONSABLE DE STAGE', 'crea' );

		}
		?>
	</strong>
</p>

<p class="mb-0">
	<?php
	if (
		'formation_continue' === $formation_type ||
		'brevet_federal' === $formation_type
	) {

		esc_html_e( 'Dans le cas où le candidat/étudiant accepte que les factures soient à adresser par CREA à son employeur au titre de la quote-part correspondante des coûts d\'écolage assumés par l\'employeur selon la Section VI ci-dessus, l\'employeur complète (i) la Section VI pour la détermination de la quote-part et (ii) la section ci-dessous, de manière à s\'engager à s\'acquitter personnellement des coûts de l\'écolage et des coûts liés (Sections V et VI ci-dessus, en particulier), le cas échéant de toutes sommes dues au titre de désistement (Section IX ci-dessus).', 'crea' );

	} else {

		esc_html_e( 'Dans le cas où le candidat/étudiant accepte que les factures soient à adresser par CREA à son employeur/responsable de stage au titre de la quote-part correspondante des coûts d\'écolage assumés par l\'employeur/responsable de stage selon la Section VI ci-dessus, l\'employeur/responsable de stage complète (i) la Section VI pour la détermination de la quote-part et (ii) la section ci-dessous, de manière à s\'engager à s\'acquitter personnellement des coûts de l\'écolage et des coûts liés (Sections V et VI ci-dessus, en particulier), le cas échéant de toutes sommes dues au titre de désistement (Section IX ci-dessus).', 'crea' );

	}
	?>
</p>

<p>
	<?php
	if (
		'formation_continue' === $formation_type ||
		'brevet_federal' === $formation_type
	) {

		esc_html_e( 'Par sa signature, l\'employeur s\'engage ainsi, de manière indépendante et pour son propre compte, à acquitter en temps utile les factures que CREA lui fera parvenir en application du présent contrat d\'admission.', 'crea' );

	} else {

		esc_html_e( 'Par sa signature, l\'employeur/responsable de stage s\'engage ainsi, de manière indépendante et pour son propre compte, à acquitter en temps utile les factures que CREA lui fera parvenir en application du présent contrat d\'admission.', 'crea' );

	}
	?>
</p>

<table class="mt-small" valign="top">
	<tr>
		<td style="width: 40%;">
			<?php esc_html_e( 'Nom et prénom de la personne signataire :' ); ?>
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
			<?php
			if (
				'formation_continue' === $formation_type ||
				'brevet_federal' === $formation_type
			) {

				esc_html_e( 'Direction de l\'employeur :', 'crea' );

			} else {

				esc_html_e( 'Direction de l\'employeur/responsable de stage :', 'crea' );

			}
			?>
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

<table class="mt valign-top" valign="top">
	<tr>
		<td style="width: 47%;">
			<?php
			if (
				'formation_continue' === $formation_type ||
				'brevet_federal' === $formation_type
			) {

				esc_html_e( 'Cachet et éventuelle deuxième signature de l\'employeur', 'crea' );

			} else {

				esc_html_e( 'Cachet et éventuelle deuxième signature de l\'employeur/responsable de stage', 'crea' );

			}
			?>
		</td>
		<td style="width: 6%;"></td>
		<td style="width: 47%; height: 85px; border: 1px solid #000000;"></td>
	</tr>
</table>

<p class="mt">
	<?php
	if (
		'formation_continue' === $formation_type ||
		'brevet_federal' === $formation_type
	) {

		esc_html_e( 'Dans l\'éventualité où l\'employeur ne s\'acquitterait pas des sommes dues à CREA en temps utile, CREA conserve l\'intégralité de ses droits à l\'encontre du candidat/étudiant pour exiger que ce dernier s\'acquitte de ses engagements stipulés notamment dans les Section V, VI et IX ci-dessus (et rappelés sur cette page de signatures).', 'crea' );

	} else {

		esc_html_e( 'Dans l\'éventualité où l\'employeur/responsable de stage ne s\'acquitterait pas des sommes dues à CREA en temps utile, CREA conserve l\'intégralité de ses droits à l\'encontre du candidat/étudiant pour exiger que ce dernier s\'acquitte de ses engagements stipulés notamment dans les Section V, VI et IX ci-dessus (et rappelés sur cette page de signatures).', 'crea' );

	}
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

<p>
	<?php esc_html_e( 'La signature par CREA suit.', 'crea' ); ?>
</p>

<p>
	<strong>
		<?php esc_html_e( 'CREA ÉCOLE DE CRÉATION EN COMMUNICATION SA', 'crea' ); ?>
	</strong>
</p>

<table valign="top">
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

<pagebreak />
