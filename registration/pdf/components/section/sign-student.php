<?php
/**
 * Student signature- registration PDF
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

<p>
	<strong>
		<?php
		echo esc_html__( 'Par ma signature, j\'accepte les termes du présent contrat d\'admission, incluant le', 'crea' ) .
			' <em>' .
			sprintf(
				// translators: Formation type singular label.
				esc_html__( 'Règlement d’admission %s en annexe.', 'crea' ),
				esc_html( get_post_type_object( $formation_type )->labels->singular_name )
			) .
			'</em>';
		?>
	</strong>
</p>

<p class="mb-0">
	<strong>
		<?php esc_html_e( 'LE CANDIDAT/ETUDIANT', 'crea' ); ?>
	</strong>
</p>

<table class="mt" valign="top">
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
		<td style="width: 47%; color: #e51f48;">
			<strong><?php esc_html_e( 'Signature du candidat/étudiant(e) :', 'crea' ); ?></strong>
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

	<table class="mt" valign="top">
		<tr>
			<td style="width: 47%;">
				<?php esc_html_e( "Noms et prénoms du/des détenteurs(s) de l'autorité parentale (si mineur)  :", 'crea' ); ?>
			</td>
			<td style="width: 6%;"></td>
			<td style="width: 47%;">
				<?php esc_html_e( "Noms et prénoms du/des détenteur(s) de l'autorité parentale (si mineur)", 'crea' ); ?>
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

	<table class="mt" valign="top">
		<tr>
			<td style="width: 47%;">
				<?php esc_html_e( "Signature du/des détenteur(s) de l'autorité parentale (si mineur)", 'crea' ); ?>
			</td>
			<td style="width: 6%;"></td>
			<td style="width: 47%;">
				<?php esc_html_e( "Signature du/des détenteur(s) de l'autorité parentale (si mineur)", 'crea' ); ?>
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
			<td style="width: 47%; font-size: 10px; padding-top: 8px;">
				<?php esc_html_e( '(copie de la pièce d\'identité à fournir)', 'crea' ); ?>
			</td>
			<td style="width: 6%;"></td>
			<td style="width: 47%; font-size: 10px; padding-top: 8px;">
				<?php esc_html_e( '(copie de la pièce d\'identité à fournir)', 'crea' ); ?>
			</td>
		</tr>
	</table>

<?php } ?>

<p class="mt-big mb-0"><?php esc_html_e( 'La signature du présent contrat d\'admission vaut reconnaissance de dette au sens de l\'art. 82 LP pour le montant de l\'écolage et les coûts qui y sont détaillés (Sections V et VI ci-dessus, en particulier), le cas échéant pour toutes sommes dues au titre de désistement (Section VII ci-dessus).', 'crea' ); ?></p>

<?php if ( 'bachelor' === $formation_type ) { ?>

	<p class="mb-0"><?php esc_html_e( 'Les signatures par le tiers-payeur et par CREA suivent.', 'crea' ); ?></p>

<?php } else { ?>

	<p>
		<?php
		if (
			'formation_continue' === $formation_type ||
			'brevet_federal' === $formation_type
		) {

			echo sprintf(
				// translators: diploma type.
				esc_html__( 'Le candidat/étudiant qui accepte que tout ou partie des coûts d\'écolage (le cas échéant, des sommes dues au titre de désistement) soient prises en charge par un tiers-payeur et/ou un employeur est ici informé par CREA que, sur demande motivée de la part de l\'une ou l\'autre des personnes précitées, CREA acceptera de leur transmettre des informations sur (i) le déroulement de la formation en ce qui concerne l\'étudiant (à savoir, l\'indication d\'une situation de réussite ou d\'échec) (ii) sa réussite ou échec au Diplôme de %s/diplôme CREA, (iii) le statut de règlement des coûts d\'écolage et/ou (iv) toute information qui serait utile à faire valoir leurs droits légitimes dans le cadre du contrat d\'admission.', 'crea' ),
				esc_html( ucfirst( get_post_type_object( $formation_type )->labels->singular_name ) )
			);

		} else {

			echo sprintf(
				// translators: diploma type.
				esc_html__( 'Le candidat/étudiant qui accepte que tout ou partie des coûts d\'écolage (le cas échéant, des sommes dues au titre de désistement) soient prises en charge par un tiers-payeur et/ou un employeur/responsable de stage est ici informé par CREA que, sur demande motivée de la part de l\'une ou l\'autre des personnes précitées, CREA acceptera de leur transmettre des informations sur (i) le déroulement de la formation en ce qui concerne l\'étudiant (à savoir, l\'indication d\'une situation de réussite ou d\'échec) (ii) sa réussite ou échec au Diplôme de %s/diplôme CREA, (iii) le statut de règlement des coûts d\'écolage et/ou (iv) toute information qui serait utile à faire valoir leurs droits légitimes dans le cadre du contrat d\'admission.', 'crea' ),
				esc_html( ucfirst( get_post_type_object( $formation_type )->labels->singular_name ) )
			);

		}
		?>
	</p>

	<p class="mb-0">
		<?php
		if (
			'formation_continue' === $formation_type ||
			'brevet_federal' === $formation_type
		) {

			esc_html_e( 'Les signatures par le tiers-payeur, l\'employeur et CREA suivent.', 'crea' );

		} else {

			esc_html_e( 'Les signatures par le tiers-payeur, l\'employeur/responsable de stage et CREA suivent.', 'crea' );

		}
		?>
	</p>

<?php } ?>

<pagebreak />
