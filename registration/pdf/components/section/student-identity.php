<?php

/**
 * Student identity - registration PDF
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
		'title'  => __('Identité et adresse privée du/de la candidat.e/de l’étudiant.e', 'crea'),
	),
);
?>

<!-- Identité de l'étudiant -->
<table class="col col-2x" valign="top">
	<tr>
		<td>
			<?php esc_html_e('Titre', 'crea'); ?> : <span style="color: #1155cc;"><?php echo esc_html($student->get_title()); ?></span>
		</td>
		<td>
			<?php esc_html_e('Date de naissance', 'crea'); ?> : <span style="color: #1155cc;"><?php echo esc_html(wp_date('d.m.Y', strtotime($student->get_birthday()))); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e('Nom', 'crea'); ?> : <span style="color: #1155cc;"><?php echo esc_html(mb_strtoupper($student->get_surname(), 'UTF-8')); ?></span>
		</td>
		<td>
			<?php esc_html_e('Nationalité', 'crea'); ?> : <span style="color: #1155cc;"><?php echo esc_html($student->get_nationality()); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e('Prénom', 'crea'); ?> : <span style="color: #1155cc;"><?php echo esc_html($student->get_name()); ?></span>
		</td>
		<td>
			<?php esc_html_e('Lieu de naissance', 'crea'); ?> : <span style="color: #1155cc;"><?php echo esc_html($student->get_origin()); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e('Adresse', 'crea'); ?> : <span style="color: #1155cc;"><?php echo esc_html($student->get_address()); ?></span>
		</td>
		<td>
			<?php esc_html_e('État civil', 'crea'); ?> : <span style="color: #1155cc;"><?php echo esc_html($student->get_civil_state()); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e('NPA et ville', 'crea'); ?> : <span style="color: #1155cc;"><?php echo esc_html($student->get_city()); ?></span>
		</td>
		<td>
			<?php esc_html_e('Mobile', 'crea'); ?> : <span style="color: #1155cc;"><?php echo esc_html($student->get_mobile()); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php esc_html_e('Pays', 'crea'); ?> : <span style="color: #1155cc;"><?php echo esc_html($student->get_country()); ?></span>
		</td>
		<td>
			<?php esc_html_e('E-mail', 'crea'); ?> : <span style="color: #1155cc;"><?php echo esc_html($student->get_mail()); ?></span>
		</td>
	</tr>
	<tr>
		<td>
			<?php if ('CH' === $student->get_countryISO()) { ?>
				<?php esc_html_e('Canton', 'crea'); ?> : <span style="color: #1155cc;"><?php echo esc_html($student->get_state()); ?></span>
			<?php } elseif ('FR' === $student->get_countryISO()) { ?>
				<?php esc_html_e('Département', 'crea'); ?> : <span style="color: #1155cc;"><?php echo esc_html($student->get_state()); ?></span>
			<?php } ?>
		</td>
		<td>
			<?php esc_html_e('Numéro AVS', 'crea'); ?> (<?php esc_html_e('seulement si domicilié.e en Suisse', 'crea'); ?>) : <span style="color: #1155cc;"><?php echo esc_html($student->get_avs()); ?></span>
		</td>
	</tr>
</table>