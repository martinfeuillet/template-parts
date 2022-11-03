<?php
/**
 * Registration form for Masters
 *
 * @package WordPress
 * @subpackage Crea
 */

$formation_id        = get_query_var( 'formation' );
$formation_type      = get_post_type( $formation_id );
$formation_type_name = get_post_type_object( $formation_type )->labels->singular_name;
$diploma_list        = crea_get_previous_diplomas();
$data                = get_query_var( 'data' );
$section_number      = 0;
$formation_theme     = get_post_meta( $formation_id, 'page_theme', true );
$is_ebs              = ( 'ebs' === $formation_theme ? true : false );

// Get data array.
if ( ! empty( $data ) ) {
	$data = unserialize( base64_decode( $data ) );
}
?>

<form action="<?php echo esc_url( get_permalink( get_page_id_by_template_name( 'template-parts/flow-registration.php' ) ) ); ?>" method="post" enctype="multipart/form-data" autocomplete="on" id="registrationForm">
	<input type="hidden" name="formation" value="<?php echo absint( $formation_id ); ?>" autocomplete="off">
	<input type="hidden" name="countryISO" value="" autocomplete="off">
	<input type="hidden" name="isebs" value="<?php echo (bool) $is_ebs; ?>" autocomplete="off">

	<div class="line forms">
		<button class="accordion open" onclick="return false;">I. <?php _e( 'Identité et adresse privée du candidat/de l’étudiant', 'crea' ); ?></button>
		<div class="panel panel--identity">
			<div class="form-control required">
				<label for="titleSelect"><?php _e( 'Titre', 'crea' ); ?></label>
				<select name="titleSelect" id="titleSelect" class="select-title-student" required>
					<option value="0"><?php _e( 'À sélectionner', 'crea' ); ?></option>
					<option value="woman"
					<?php
					if ( isset( $data['titleSelect'] ) and $data['titleSelect'] == 'woman' ) {
												echo 'selected="true"';
					}
					?>
											><?php _e( 'Madame', 'crea' ); ?></option>
					<option value="man"
					<?php
					if ( isset( $data['titleSelect'] ) and $data['titleSelect'] == 'man' ) {
											echo 'selected="true"';
					}
					?>
										><?php _e( 'Monsieur', 'crea' ); ?></option>
				</select>
			</div>
			<div class="form-control">

			</div>
			<div class="form-control required">
				<label for="surname"><?php _e( 'Nom', 'crea' ); ?></label>
				<input type="text" name="studentSurname" id="surname" required
				<?php
				if ( isset( $data['studentSurname'] ) ) {
																					echo 'value="' . esc_attr( $data['studentSurname'] ) . '"';
				}
				?>
																				>
			</div>
			<div class="form-control required">
				<label for="name"><?php _e( 'Prénom', 'crea' ); ?></label>
				<input type="text" name="studentName" id="name" required
				<?php
				if ( isset( $data['studentName'] ) ) {
																				echo 'value="' . esc_attr( $data['studentName'] ) . '"';
				}
				?>
																			>
			</div>
			<div class="form-control required">
				<label for="birthday"><?php _e( 'Date de naissance', 'crea' ); ?></label>
				<input type="text" name="studentBirthday" id="birthday" data-max-age="99" data-min-age="1" placeholder="jj-mm-aaaa" required
				<?php
				if ( isset( $data['studentBirthday'] ) ) {
																												echo 'value="' . esc_attr( $data['studentBirthday'] ) . '"';
				}
				?>
																											>
			</div>
			<div class="form-control required">
				<label for="studentCivilState"><?php _e( 'État civil', 'crea' ); ?></label>
				<select name="studentCivilState" id="studentCivilState" class="select-title">
					<option value="0"><?php _e( 'À sélectionner', 'crea' ); ?></option>
					<option value="<?php esc_attr_e( 'Célibataire', 'crea' ); ?>"
											 <?php
												if ( isset( $data['studentCivilState'] ) and $data['studentCivilState'] == __( 'Célibataire', 'crea' ) ) {
																			echo 'selected="true"';
												}
												?>
																		><?php _e( 'Célibataire', 'crea' ); ?></option>
					<option value="<?php esc_attr_e( 'Marié(e)', 'crea' ); ?>"
											 <?php
												if ( isset( $data['studentCivilState'] ) and $data['studentCivilState'] == __( 'Marié(e)', 'crea' ) ) {
																		echo 'selected="true"';
												}
												?>
																	><?php _e( 'Marié(e)', 'crea' ); ?></option>
					<option value="<?php esc_attr_e( 'Divorcé(e)', 'crea' ); ?>"
											 <?php
												if ( isset( $data['studentCivilState'] ) and $data['studentCivilState'] == __( 'Divorcé(e)', 'crea' ) ) {
																			echo 'selected="true"';
												}
												?>
																		><?php _e( 'Divorcé(e)', 'crea' ); ?></option>
					<option value="<?php esc_attr_e( 'Veuf(ve)', 'crea' ); ?>"
											 <?php
												if ( isset( $data['studentCivilState'] ) and $data['studentCivilState'] == __( 'Veuf(ve)', 'crea' ) ) {
																		echo 'selected="true"';
												}
												?>
																	><?php _e( 'Veuf(ve)', 'crea' ); ?></option>
					<option value="<?php esc_attr_e( 'Partenariat enregistré / Pacse', 'crea' ); ?>"
											 <?php
												if ( isset( $data['studentCivilState'] ) and $data['studentCivilState'] == __( 'Partenariat enregistré / Pacse', 'crea' ) ) {
																								echo 'selected="true"';
												}
												?>
																							><?php _e( 'Partenariat enregistré / Pacse', 'crea' ); ?></option>
				</select>
			</div>
			<?php
			$nationalities = get_nationalities();
			?>
			<div class="form-control required">
				<label for="studentNationality"><?php _e( 'Nationalité', 'crea' ); ?></label>
				<select name="studentNationality" id="studentNationality" class="select-title">
					<option value="" <?php echo empty( $data['studentNationality'] ) ? 'selected' : ''; ?>><?php _e( 'À sélectionner', 'crea' ); ?></option>
					<?php foreach ( $nationalities as $nationalite ) : ?>
						<option value="<?php echo esc_attr( $nationalite ); ?>" <?php  ! empty( $data['studentNationality'] ) ? selected( $data['studentNationality'], $nationalite ) : ''; ?>><?php echo esc_html( $nationalite ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-control required">
				<label for="origin"><?php _e( 'Lieu d\'origine (lieu de naissance)', 'crea' ); ?></label>
				<input type="text" name="studentOrigin" id="origin" required
				<?php
				if ( isset( $data['studentOrigin'] ) ) {
																					echo 'value="' . esc_attr( $data['studentOrigin'] ) . '"';
				}
				?>
																				>
			</div>
			<div class="form-control required form--address">
				<label for="studentAddress"><?php _e( 'Adresse', 'crea' ); ?></label>
				<input type="text" name="studentAddress" id="studentAddress" placeholder="<?php _e( 'Indiquez un lieu', 'crea' ); ?>" onkeypress="return enterDisabled(event)" required
																									<?php
																									if ( isset( $data['studentAddress'] ) ) {
																																						echo 'value="' . esc_attr( $data['studentAddress'] ) . '"';
																									}
																									?>
																																					>
			</div>
			<div class="form-control required form--nb">
				<label for="studentAddressNb"><?php _e( 'Numéro', 'crea' ); ?></label>
				<input type="text" name="studentAddressNb" id="studentAddressNb" required
				<?php
				if ( isset( $data['studentAddressNb'] ) ) {
					echo 'value="' . esc_attr( $data['studentAddressNb'] ) . '"'; }
				?>
				>
			</div>
			<div class="form-control required">
				<label for="studentCity"><?php _e( 'NPA et ville', 'crea' ); ?></label>
				<input type="text" name="studentCity" id="studentCity" required
				<?php
				if ( isset( $data['studentCity'] ) ) {
																										echo 'value="' . esc_attr( $data['studentCity'] ) . '"';
				}
				?>
																									>
			</div>
			<div class="form-control required" visible-in="CH">
				<label for="studentCanton"><?php _e( 'Canton', 'crea' ); ?></label>
				<input type="text" name="studentCanton" id="studentCanton" required
				<?php
				if ( isset( $data['studentCanton'] ) ) {
																											echo 'value="' . esc_attr( $data['studentCanton'] ) . '"';
				}
				?>
																										>
			</div>
			<div class="form-control required" visible-in="FR">
				<label for="studentDepartment"><?php _e( 'Département', 'crea' ); ?></label>
				<input type="text" name="studentDepartment" id="studentDepartment" required
				<?php
				if ( isset( $data['studentDepartment'] ) ) {
																													echo 'value="' . esc_attr( $data['studentDepartment'] ) . '"';
				}
				?>
																												>
			</div>
			<div class="form-control required country">
				<label for="studentCountry"><?php _e( 'Pays', 'crea' ); ?></label>
				<?php
				$countries_obj = new WC_Countries();
				$countries     = $countries_obj->__get( 'countries' );
				?>
				<select name="studentCountry" id="studentCountry" required class="select-country">
					<option value="0"><?php _e( 'À sélectionner', 'crea' ); ?></option>
					<?php foreach ( $countries as $key => $value ) { ?>
						<option value="<?php echo esc_attr( $value ); ?>" iso="<?php echo $key; ?>"
												  <?php
													if ( isset( $data['studentMobileCode'] ) and $data['studentCountry'] == $value ) {
																							echo 'selected="true"';
													} elseif ( ! isset( $data['studentMobileCode'] ) && $key == 'CH' ) {
														echo 'selected="true"';
													}
													?>
																						><?php echo esc_html( $value ); ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-control required">
				<label for="studentMail"><?php _e( 'Mail', 'crea' ); ?></label>
				<input type="email" name="studentMail" id="studentMail" required
				<?php
				if ( isset( $data['studentMail'] ) ) {
																						echo 'value="' . esc_attr( $data['studentMail'] ) . '"';
				}
				?>
																					>
			</div>
			<div class="form-control required">
				<label><?php _e( 'Mobile', 'crea' ); ?></label>
				<select name="studentMobileCode" class="country_code_phone">
					<option value="41" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_switzerland.svg"
																<?php
																if ( isset( $data['studentMobileCode'] ) and $data['studentMobileCode'] == '41' ) {
																																		echo 'selected="true"';
																}
																?>
																																	>+41</option>
					<option value="33" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_france.svg"
																<?php
																if ( isset( $data['studentMobileCode'] ) and $data['studentMobileCode'] == '33' ) {
																																	echo 'selected="true"';
																}
																?>
																																>+33</option>
					<option value="32" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_belgium.svg"
																<?php
																if ( isset( $data['studentMobileCode'] ) and $data['studentMobileCode'] == '32' ) {
																																	echo 'selected="true"';
																}
																?>
																																>+32</option>
					<option value="39" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_italy.svg"
																<?php
																if ( isset( $data['studentMobileCode'] ) and $data['studentMobileCode'] == '39' ) {
																																echo 'selected="true"';
																}
																?>
																															>+39</option>
					<option value="44" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_uk.svg"
																<?php
																if ( isset( $data['studentMobileCode'] ) and $data['studentMobileCode'] == '44' ) {
																																echo 'selected="true"';
																}
																?>
																															>+44</option>
					<option value=""
					<?php
					if ( isset( $data['studentMobileCode'] ) and $data['studentMobileCode'] == '' ) {
											echo 'selected="true"';
					}
					?>
										><?php _e( 'Autre', 'crea' ); ?></option>
				</select>
				<input type="tel" name="studentMobile" required
				<?php
				if ( isset( $data['studentMobile'] ) ) {
																	echo 'value="' . esc_attr( $data['studentMobile'] ) . '"';
				}
				?>
																>
			</div>

			<div class="form-control" required-in="CH">
				<label for="studentAVS"><?php _e( 'Numéro AVS (si domicilié en Suisse seulement)', 'crea' ); ?></label>
				<input type="text" name="studentAVS" id="studentAVS"
				<?php
				if ( isset( $data['studentAVS'] ) ) {
																			echo 'value="' . esc_attr( $data['studentAVS'] ) . '"';
				}
				?>
																		>
			</div>
		</div>

		<button class="accordion" onclick="return false;">II. <?php esc_html_e( 'Coordonnées bancaires complètes', 'crea' ); ?></button>
		<div class="panel" start="close">
			<div class="form-control required">
				<label for="accountHolder"><?php _e( 'Titulaire du compte', 'crea' ); ?></label>
				<input type="text" name="accountHolder" id="accountHolder" required
				<?php
				if ( isset( $data['accountHolder'] ) ) {
																						echo 'value="' . esc_attr( $data['accountHolder'] ) . '"';
				}
				?>
																					>
			</div>
			<div class="form-control required">
				<label for="accountCity"><?php _e( 'NPA et ville', 'crea' ); ?></label>
				<input type="text" name="accountCity" id="accountCity" required
				<?php
				if ( isset( $data['accountCity'] ) ) {
																					echo 'value="' . esc_attr( $data['accountCity'] ) . '"';
				}
				?>
																				>
			</div>
			<div class="form-control required">
				<label for="accountName"><?php _e( 'Nom de l\'établissement', 'crea' ); ?></label>
				<input type="text" name="accountName" id="accountName" required
				<?php
				if ( isset( $data['accountName'] ) ) {
																					echo 'value="' . esc_attr( $data['accountName'] ) . '"';
				}
				?>
																				>
			</div>
			<div class="form-control required">
				<label for="accountIBAN"><?php _e( 'IBAN', 'crea' ); ?></label>
				<input type="text" name="accountIBAN" id="accountIBAN" required
				<?php
				if ( isset( $data['accountIBAN'] ) ) {
																					echo 'value="' . esc_attr( $data['accountIBAN'] ) . '"';
				}
				?>
																				>
			</div>
			<div class="form-control">
				<label for="accountClearing"><?php _e( 'Clearing', 'crea' ); ?></label>
				<input type="text" name="accountClearing" id="accountClearing"
				<?php
				if ( isset( $data['accountClearing'] ) ) {
																					echo 'value="' . esc_attr( $data['accountClearing'] ) . '"';
				}
				?>
																				>
			</div>
			<div class="form-control required">
				<label for="accountSWIFT"><?php _e( 'SWIFT', 'crea' ); ?></label>
				<input type="text" name="accountSWIFT" id="accountSWIFT" required
				<?php
				if ( isset( $data['accountSWIFT'] ) ) {
																						echo 'value="' . esc_attr( $data['accountSWIFT'] ) . '"';
				}
				?>
																					>
			</div>
		</div>

		<button class="accordion" onclick="return false;">III. <?php _e( 'Formations antérieures', 'crea' ); ?></button>
		<div class="panel" start="close">
			<div class="school-1 section">
				<h4><?php _e( 'Formation 1', 'crea' ); ?></h4>
				<div class="form-control required">
					<label><?php _e( 'Nom de l\'école', 'crea' ); ?></label>
					<input type="text" name="school1Name" required
					<?php
					if ( isset( $data['school1Name'] ) ) {
																		echo 'value="' . esc_attr( $data['school1Name'] ) . '"';
					}
					?>
																	>
				</div>
				<div class="form-control required">
					<label><?php _e( 'Niveau d\'études', 'crea' ); ?></label>
					<select name="school1Level" id="school1Level" class="select-title">
						<?php foreach ( $diploma_list as $parent => $childs ) { ?>
							<option value="<?php echo esc_attr( $parent ); ?>"
													  <?php
														if ( isset( $data['school1Level'] ) and $data['school1Level'] == esc_attr( $parent ) ) {
															echo 'selected="true"'; }
														?>
							><?php echo esc_html( $parent ); ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-control required">
					<label><?php _e( 'Domaine d\'étude', 'crea' ); ?></label>
					<select name="school1Level2" id="school1Level2" class="select-title">
						<?php
						foreach ( $diploma_list as $parent => $childs ) {
							if ( $parent === array_key_first( $diploma_list ) ) {
								if ( ! empty( $childs ) ) :
									foreach ( $childs as $child ) :
										?>
									<option value="<?php echo esc_attr( $child ); ?>" <?php  ! empty( $data['school2Level2'] ) ? selected( $data['school2Level2'], esc_attr( $child ) ) : ''; ?>><?php echo esc_html( $child ); ?></option>
										<?php
								endforeach;
endif;
								?>
							<?php } ?>
						<?php } ?>
					</select>
				</div>
				<div class="form-control required">
					<label><?php _e( 'Intitulé du diplôme', 'crea' ); ?></label>
					<input type="text" name="school1DiplomaName" required
					<?php
					if ( isset( $data['school1DiplomaName'] ) ) {
																				echo 'value="' . esc_attr( $data['school1DiplomaName'] ) . '"';
					}
					?>
																			>
				</div>
				<div class="form-control required">
					<label><?php _e( 'Diplôme obtenu', 'crea' ); ?></label>
					<div class="radio-group">
						<input type="radio" name="school1HasDiploma" value="yes" id="school1DiplomaYes" required
						<?php
						if ( isset( $data['school1HasDiploma'] ) and $data['school1HasDiploma'] == 'yes' ) {
																														echo 'checked="true"';
						}
						?>
																													>
						<label for="school1DiplomaYes"><?php _e( 'Oui', 'crea' ); ?></label>
					</div>
					<div class="radio-group">
						<input type="radio" name="school1HasDiploma" value="no" id="school1DiplomaNo" required
						<?php
						if ( isset( $data['school1HasDiploma'] ) and $data['school1HasDiploma'] == 'no' ) {
																													echo 'checked="true"';
						}
						?>
																												>
						<label for="school1DiplomaNo"><?php _e( 'Non', 'crea' ); ?></label>
					</div>
					<div class="radio-group">
						<input type="radio" name="school1HasDiploma" value="progress" id="school1DiplomaProgress" required
						<?php
						if ( isset( $data['school1HasDiploma'] ) and $data['school1HasDiploma'] == 'progress' ) {
																													echo 'checked="true"';
						}
						?>
																												>
						<label for="school1DiplomaProgress"><?php _e( 'En cours', 'crea' ); ?></label>
					</div>
				</div>
				<div class="form-control required">
					<label><?php _e( 'Année du diplôme', 'crea' ); ?></label>
					<input type="text" name="school1DiplomaYear" required
					<?php
					if ( isset( $data['school1DiplomaYear'] ) ) {
																				echo 'value="' . esc_attr( $data['school1DiplomaYear'] ) . '"';
					}
					?>
																			>
				</div>
			</div>

			<div class="school-2 section">
				<h4><?php _e( 'Formation 2', 'crea' ); ?></h4>
				<div class="form-control">
					<label><?php _e( 'Nom de l\'école', 'crea' ); ?></label>
					<input type="text" name="school2Name"
					<?php
					if ( isset( $data['school2Name'] ) ) {
																echo 'value="' . esc_attr( $data['school2Name'] ) . '"';
					}
					?>
															>
				</div>
				<div class="form-control">
					<label><?php _e( 'Niveau d\'études', 'crea' ); ?></label>
					<select name="school2Level" id="school2Level" class="select-title">
						<?php foreach ( $diploma_list as $parent => $childs ) { ?>
							<option value="<?php echo esc_attr( $parent ); ?>"
													  <?php
														if ( isset( $data['school2Level'] ) and $data['school2Level'] == esc_attr( $parent ) ) {
															echo 'selected="true"'; }
														?>
							><?php echo esc_html( $parent ); ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-control">
					<label><?php _e( 'Domaine d\'étude', 'crea' ); ?></label>
					<select name="school2Level2" id="school2Level2" class="select-title">
						<?php
						foreach ( $diploma_list as $parent => $childs ) {
							if ( $parent === array_key_first( $diploma_list ) ) {
								if ( ! empty( $childs ) ) :
									foreach ( $childs as $child ) :
										?>
									<option value="<?php echo esc_attr( $child ); ?>" <?php  ! empty( $data['school2Level2'] ) ? selected( $data['school2Level2'], esc_attr( $child ) ) : ''; ?>><?php echo esc_html( $child ); ?></option>
										<?php
								endforeach;
endif;
								?>
							<?php } ?>
						<?php } ?>
					</select>
				</div>
				<div class="form-control">
					<label><?php _e( 'Intitulé du diplôme', 'crea' ); ?></label>
					<input type="text" name="school2DiplomaName"
					<?php
					if ( isset( $data['school2DiplomaName'] ) ) {
																		echo 'value="' . esc_attr( $data['school2DiplomaName'] ) . '"';
					}
					?>
																	>
				</div>
				<div class="form-control">
					<label><?php _e( 'Diplôme obtenu', 'crea' ); ?></label>
					<div class="radio-group">
						<input type="radio" name="school2HasDiploma" value="yes" id="school2DiplomaYes"
						<?php
						if ( isset( $data['school2HasDiploma'] ) and $data['school2HasDiploma'] == 'yes' ) {
																											echo 'checked="true"';
						}
						?>
																										>
						<label for="school2DiplomaYes"><?php _e( 'Oui', 'crea' ); ?></label>
					</div>
					<div class="radio-group">
						<input type="radio" name="school2HasDiploma" value="progress" id="school2DiplomaProgress"
						<?php
						if ( isset( $data['school2HasDiploma'] ) and $data['school2HasDiploma'] == 'progress' ) {
																													echo 'checked="true"';
						}
						?>
																												>
						<label for="school2DiplomaProgress"><?php _e( 'En cours', 'crea' ); ?></label>
					</div>
					<div class="radio-group">
						<input type="radio" name="school2HasDiploma" value="no" id="school2DiplomaNo"
						<?php
						if ( isset( $data['school2HasDiploma'] ) and $data['school2HasDiploma'] == 'no' ) {
																											echo 'checked="true"';
						}
						?>
																										>
						<label for="school2DiplomaNo"><?php _e( 'Non', 'crea' ); ?></label>
					</div>
				</div>
				<div class="form-control">
					<label><?php _e( 'Année du diplôme', 'crea' ); ?></label>
					<input type="text" name="school2DiplomaYear"
					<?php
					if ( isset( $data['school2DiplomaYear'] ) ) {
																				echo 'value="' . esc_attr( $data['school2DiplomaYear'] ) . '"';
					}
					?>
																			>
				</div>
			</div>

		</div>

		<?php if ( ! $is_ebs ) : ?>
			<button class="accordion" onclick="return false;">IV. <?php _e( 'Coordonnées de l\'entreprise', 'crea' ); ?></button>
			<div class="panel" start="close">
				<p class="panel__intro"><?php _e( 'Ces informations sont à compléter seulement si votre employeur participe au financement de la formation.', 'crea' ); ?></p>
				<p><?php _e( 'Coordonnées de l\'entreprise', 'crea' ); ?></p>
				<div class="form-control">
					<label for="companyName"><?php _e( 'Nom de l\'entreprise', 'crea' ); ?></label>
					<input type="text" name="companyName" id="companyName"
					<?php
					if ( isset( $data['companyName'] ) ) {
																				echo 'value="' . esc_attr( $data['companyName'] ) . '"';
					}
					?>
																			>
				</div>
				<div class="form-control">
					<label for="companyStreet"><?php _e( 'Rue', 'crea' ); ?></label>
					<input type="text" name="companyStreet" id="companyStreet"
					<?php
					if ( isset( $data['companyStreet'] ) ) {
																					echo 'value="' . esc_attr( $data['companyStreet'] ) . '"';
					}
					?>
																				>
				</div>
				<div class="form-control">
					<label for="companyCity"><?php _e( 'NPA et Ville', 'crea' ); ?></label>
					<input type="text" name="companyCity" id="companyCity"
					<?php
					if ( isset( $data['companyCity'] ) ) {
																				echo 'value="' . esc_attr( $data['companyCity'] ) . '"';
					}
					?>
																			>
				</div>
				<div class="form-control">
					<label for="companyMail"><?php _e( 'Mail', 'crea' ); ?></label>
					<input type="text" name="companyMail" id="companyMail"
					<?php
					if ( isset( $data['companyMail'] ) ) {
																				echo 'value="' . esc_attr( $data['companyMail'] ) . '"';
					}
					?>
																			>
				</div>
				<div class="form-control">
					<label for="companyPhone"><?php _e( 'Tél', 'crea' ); ?></label>
					<input type="text" name="companyPhone" id="companyPhone"
					<?php
					if ( isset( $data['companyPhone'] ) ) {
																					echo 'value="' . esc_attr( $data['companyPhone'] ) . '"';
					}
					?>
																				>
				</div>
				<div class="form-control">
					<label for="companyMobile"><?php _e( 'Mobile', 'crea' ); ?></label>
					<input type="text" name="companyMobile" id="companyMobile"
					<?php
					if ( isset( $data['companyMobile'] ) ) {
																					echo 'value="' . esc_attr( $data['companyMobile'] ) . '"';
					}
					?>
																				>
				</div>

				<p><?php _e( 'Coordonnées bancaires de l\'entreprise', 'crea' ); ?></p>
				<div class="form-control">
					<label for="companyAccountHolder"><?php _e( 'Titulaire du compte', 'crea' ); ?></label>
					<input type="text" name="companyAccountHolder" id="companyAccountHolder"
					<?php
					if ( isset( $data['companyAccountHolder'] ) ) {
																									echo 'value="' . esc_attr( $data['companyAccountHolder'] ) . '"';
					}
					?>
																								>
				</div>
				<div class="form-control">
					<label for="companyAccountCity"><?php _e( 'NPA et Ville', 'crea' ); ?></label>
					<input type="text" name="companyAccountCity" id="companyAccountCity"
					<?php
					if ( isset( $data['companyAccountCity'] ) ) {
																								echo 'value="' . esc_attr( $data['companyAccountCity'] ) . '"';
					}
					?>
																							>
				</div>
				<div class="form-control">
					<label for="companyAccountBank"><?php _e( 'Nom de l\'établissement', 'crea' ); ?></label>
					<input type="text" name="companyAccountBank" id="companyAccountBank"
					<?php
					if ( isset( $data['companyAccountBank'] ) ) {
																								echo 'value="' . esc_attr( $data['companyAccountBank'] ) . '"';
					}
					?>
																							>
				</div>
				<div class="form-control">
					<label for="companyAccountIBAN"><?php _e( 'IBAN', 'crea' ); ?></label>
					<input type="text" name="companyAccountIBAN" id="companyAccountIBAN"
					<?php
					if ( isset( $data['companyAccountIBAN'] ) ) {
																								echo 'value="' . esc_attr( $data['companyAccountIBAN'] ) . '"';
					}
					?>
																							>
				</div>
				<div class="form-control">
					<label for="companyAccountClearing"><?php _e( 'Clearing', 'crea' ); ?></label>
					<input type="text" name="companyAccountClearing" id="companyAccountClearing"
					<?php
					if ( isset( $data['companyAccountClearing'] ) ) {
																										echo 'value="' . esc_attr( $data['companyAccountClearing'] ) . '"';
					}
					?>
																									>
				</div>
				<div class="form-control">
					<label for="companyAccountSwift"><?php _e( 'Swift', 'crea' ); ?></label>
					<input type="text" name="companyAccountSwift" id="companyAccountSwift"
					<?php
					if ( isset( $data['companyAccountSwift'] ) ) {
																								echo 'value="' . esc_attr( $data['companyAccountSwift'] ) . '"';
					}
					?>
																							>
				</div>
				<p><?php _e( 'Participation de l\'entreprise', 'crea' ); ?></p>
				<div class="form-control">
					<label for="companyQuotepart"><?php _e( 'Indiquez le taux de participation de l\'entreprise (en %)', 'crea' ); ?></label>
					<input type="number" name="companyQuotepart" id="companyQuotepart"
					<?php
					if ( isset( $data['companyQuotepart'] ) ) {
																							echo 'value="' . esc_attr( $data['companyQuotepart'] ) . '"';
					}
					?>
																						>
				</div>
			</div>
		<?php endif; ?>

		<?php
		// Variables
		$formation_id          = get_query_var( 'formation' );
		$session_start         = strtotime( (string) get_field( 'session_start', $formation_id ) );
		$session_end           = strtotime( (string) get_field( 'session_end', $formation_id ) );
		$registration_price    = get_field( 'registration_price', $formation_id );
		$total_price           = (float) get_field( 'total_price', $formation_id );
		$total_price_formatted = number_format( $total_price, 0, ',', '\'' );
		?>

		<button class="accordion" onclick="return false;"><?php echo ( $is_ebs ? 'IV.' : 'V.' ); ?> <?php _e( 'Inscription', 'crea' ); ?></button>
		<div class="panel text-blue inscription" start="close">
			<p class="text-bold">
				<?php
				echo sprintf(
					esc_html__( 'Je confirme mon inscription ferme (sous réserve d\'acceptation par CREA) au %1$s - session %2$s-%3$s de l’école CREA pour un montant d’écolage total de CHF %4$s.-.', 'crea' ),
					esc_html( ucfirst( $formation_type_name ) ),
					date( 'Y', $session_start ),
					date( 'Y', $session_end ),
					number_format( (float) get_field( 'total_price', $formation_id ), 0, ',', '\'')
				);
				?>
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
			$not_included_title = get_post_meta( $formation_id, 'diploma_contract_not_include_title', true );
			if ( ! empty( $not_included_title ) ) {
				?>
				<p class="title--black"><?php echo esc_html( $not_included_title ); ?></p>
				<?php
			}
			?>

			<?php
			$not_included = get_post_meta( $formation_id, 'diploma_contract_not_include', true );
			if ( ! empty( $not_included ) ) {

				echo wp_kses_post(
					wpautop(
						$not_included
					)
				);

			}
			?>

			<?php
			$travel_title = get_post_meta( $formation_id, 'diploma_travels_title', true );
			$travel_body  = get_post_meta( $formation_id, 'diploma_travels_body', true );
			?>
			<?php if ( ! empty( $travel_title ) ) { ?>
				<p class="title--black"><?php echo esc_html( $travel_title ); ?></p>
			<?php } ?>
			<?php if ( ! empty( $travel_body ) ) { ?>
				<div class="travel__content"><?php echo wp_kses_post( wpautop( $travel_body ) ); ?></div>
			<?php } ?>

			<?php
			$campus_title = get_post_meta( $formation_id, 'diploma_campus_title', true );
			$campus_body  = get_post_meta( $formation_id, 'diploma_campus_body', true );
			?>
			<?php if ( ! empty( $campus_title ) ) { ?>
				<p class="title--black"><?php echo esc_html( $campus_title ); ?></p>
			<?php } ?>
			<?php if ( ! empty( $campus_body ) ) { ?>
				<div class="travel__content"><?php echo wp_kses_post( wpautop( $campus_body ) ); ?></div>
			<?php } ?>

			<table style="margin-top:24px;">
				<tr>
					<td>
						<span class="table-title"><?php _e( 'Inscription', 'crea' ); ?></span>
					</td>
					<td>
						<?php echo crea_get_date( 'contract_back', true, $formation_id ); ?>
					</td>
				</tr>
				<tr>
					<td>
						<span class="table-title"><?php _e( 'Début des cours', 'crea' ); ?></span>
					</td>
					<td>
						<?php echo crea_get_date( 'session_start', true, $formation_id ); ?>
					</td>
				</tr>
				<tr>
					<td>
						<span class="table-title"><?php _e( 'Fin des cours', 'crea' ); ?></span>
					</td>
					<td>
						<?php echo crea_get_date( 'session_end', false, $formation_id ); ?>
					</td>
				</tr>
				<tr>
					<td>
						<span class="table-title"><?php _e( 'Travail de Master', 'crea' ); ?></span>
					</td>
					<td>
						<?php echo crea_get_date( 'final_work', false, $formation_id ); ?>
					</td>
				</tr>
			</table>
		</div>

		<button class="accordion open" onclick="return false;"><?php echo ( $is_ebs ? 'V.' : 'VI.' ); ?> <?php _e( 'Finance d\'inscription', 'crea' ); ?></button>
		<div class="panel text-blue finance" start="open">
			<p class="text-emphasize"><?php echo sprintf( __( 'Un montant de CHF %s.- est à verser lors de l’inscription.', 'crea' ), esc_html( $registration_price ) ); ?></p>
			<p><?php _e( 'Ce montant ne sera pas remboursé en cas de désistement ou de non-présentation du candidat à l\'examen d\'entrée. En revanche, si le candidat ou la candidate n\'est pas retenu.e, la finance d\'inscription lui sera restituée.', 'crea' ); ?></p>

			<p><?php _e( 'Le règlement est à effectuer sur le compte suivant', 'crea' ); ?> :</p>
			<p class="text-bold">Crédit Suisse, Genève / IBAN : CH30 0483 5175 2978 1100 1 / Clearing : 4835 / Swift CRESCHZZ80A</p>
		</div>

		<button class="accordion" onclick="return false;">
			<?php echo ( $is_ebs ? 'VI.' : 'VII.' ) . ' ' . esc_html__( 'Modalités de paiement', 'crea' ); ?>
		</button>
		<div class="panel text-blue modalite" start="close">
			<p>
				<?php
				echo sprintf(
					esc_html__( 'Je m\'engage à verser le montant de CHF %s.- à CREA selon ce qui suit.', 'crea' ),
					number_format(
						(float) get_field( 'total_price', $formation_id ),
						0,
						',',
						'\''
					)
				)
				?>
			</p>
			<p>
				<?php esc_html_e( 'Les échéances sont à respecter, même pendant les périodes de stages ou de vacances.', 'crea' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'Veuillez cocher la variante choisie', 'crea' ); ?> :
			</p>
			<fieldset>

				<?php
				$data_modalite = isset( $data['modalite'] ) ? absint( $data['modalite'] ) : 0;
				?>

				<!-- En 1 tranche -->
				<?php
				$split_pay_date = get_field( 'diploma_contract_split_payment_date', $formation_id );
				?>
				<label for="modaliteOption1">
					<input type="radio" id="modaliteOption1" name="modalite" value="1" <?php checked( $data_modalite, 1 ); ?>>
					<span class="control">
						<span class="text-bold">
							<?php
							echo sprintf(
								// translators: numbers of payments, total price.
								esc_html__( 'En 1 tranche pour un montant total de CHF %1$s.- au %2$s', 'crea' ),
								esc_html( $total_price_formatted ),
								esc_html( $split_pay_date )
							);
							?>
						</span>
					</span>
				</label>

				<!-- En trimestres -->
				<?php
				if ( have_rows( 'tab_head', $formation_id ) && have_rows( 'tab_body', $formation_id ) ) {
					?>
					<label for="modaliteOption2">
						<input type="radio" id="modaliteOption2" name="modalite" value="2" <?php checked( $data_modalite, 2 ); ?>>
						<span class="control">
							<span class="text-bold">
								<?php
								echo sprintf(
									esc_html__( 'En trimestre selon le calendrier suivant pour un montant total de CHF %s.-', 'crea' ),
									esc_html( $total_price_formatted )
								);
								?>
							</span>
							<table>
								<tr>
									<td>
										<?php esc_html_e( 'Versements', 'crea' ); ?>
									</td>
									<?php
									if ( have_rows( 'tab_head', $formation_id ) ) {
										while ( have_rows( 'tab_head', $formation_id ) ) {
											the_row();
											echo '<td>' . get_sub_field( 'label' ) . '</td>';
										}
									}
									?>
									<td>
										<?php _e( 'Total CHF', 'crea' ); ?>
									</td>
								</tr>
								<?php
								if ( have_rows( 'tab_body', $formation_id ) ) {
									$row_count = 0;
									while ( have_rows( 'tab_body', $formation_id ) ) {
										the_row();
										$row_count += 1;
										$rowPrice   = 0;
										?>
										<tr>
											<td>
												<?php the_sub_field( 'row_title' ); ?><br>
												<?php if ( get_field( 'show_year_tab', $formation_id ) == 'true' ) { ?>
													(<?php echo absint( date( 'Y', $session_start ) ) + ( $row_count - 1 ); ?>/<?php echo absint( date( 'Y', $session_start ) ) + $row_count; ?>)
												<?php } ?>
											</td>
											<td>

												<?php
												if ( ! empty( get_sub_field( 'col_1' ) ) ) {
													echo 'CHF ' . number_format( get_sub_field( 'col_1' ), 0, ',', '\'' ) . '.-';
													$rowPrice += get_sub_field( 'col_1' );
												} else {
													echo '-';
												}
												?>
											</td>
											<td>
												<?php
												if ( ! empty( get_sub_field( 'col_2' ) ) ) {
													echo 'CHF ' . number_format( get_sub_field( 'col_2' ), 0, ',', '\'' ) . '.-';
													$rowPrice += get_sub_field( 'col_2' );
												} else {
													echo '-';
												}
												?>
											</td>
											<td>
												<?php
												if ( ! empty( get_sub_field( 'col_3' ) ) ) {
													echo 'CHF ' . number_format( get_sub_field( 'col_3' ), 0, ',', '\'' ) . '.-';
													$rowPrice += get_sub_field( 'col_3' );
												} else {
													echo '-';
												}
												?>
											</td>
											<td>
												<?php
												if ( ! empty( get_sub_field( 'col_4' ) ) ) {
													echo 'CHF ' . number_format( get_sub_field( 'col_4' ), 0, ',', '\'' ) . '.-';
													$rowPrice += get_sub_field( 'col_4' );
												} else {
													echo '-';
												}
												?>
											</td>
											<td>
												CHF <?php echo number_format( $rowPrice, 0, ',', '\'' ); ?>.-
											</td>
										</tr>
										<?php
									}
								}
								?>
							</table>
						</span>
					</label>
				<?php } ?>

				<!-- En mensualités -->
				<?php
				$monthly_payments = get_field( 'diploma_contract_monthly_payement', $formation_id );

				if ( ! empty( $monthly_payments ) ) {

					$monthly_payments_number     = $monthly_payments['number'];
					$monthly_payments_amount     = $monthly_payments['amount'];
					$monthly_payments_start_date = $monthly_payments['date_start'];
					$monthly_payments_end_date   = $monthly_payments['date_end'];
					?>

					<label for="modaliteOption3">
						<input type="radio" id="modaliteOption3" name="modalite" value="3" <?php checked( $data_modalite, 3 ); ?>>
						<span class="control">
							<span class="text-bold">
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
							</span>
						</span>
					</label>

					<?php
				}
				?>

				<!-- Convention spécifique -->
				<?php
				$custom_payment = get_field( 'custom_payment', $formation_id );

				if ( ! empty( $custom_payment['title'] ) ) {
					?>
					<label for="modaliteOption4">
						<input type="radio" id="modaliteOption4" name="modalite" value="4" <?php checked( $data_modalite, 4 ); ?>>
						<span class="control">
							<span class="text-bold">
								<?php echo esc_html( $custom_payment['title'] ); ?>
							</span>
							<?php if ( ! empty( $custom_payment['body'] ) ) { ?>
								<span>
									<?php
									echo wp_kses(
										nl2br( $custom_payment['body'] ),
										array(
											'br'     => array(),
											'strong' => array(),
										)
									);
									?>
								</span>
							<?php } ?>
						</span>
					</label>
					<?php
				}
				?>
			</fieldset>
		</div>

		<button class="accordion" onclick="return false;"><?php echo ( $is_ebs ? 'VII.' : 'VIII.' ); ?> <?php _e( 'Clauses', 'crea' ); ?></button>
		<div class="panel text-blue clauses" start="close">
			<div class="clause__wrapper">
				<p class="text-title"><?php _e( 'Clauses de désistement', 'crea' ); ?></p>
				<?php
				if ( have_rows( 'disistment_clauses', $formation_id ) ) :
					while ( have_rows( 'disistment_clauses', $formation_id ) ) :
						the_row()
						?>
						<?php if( !empty( $disistment_title = get_sub_field( 'title' ) ) ) {
							?>
							<p class="text-subtitle"><strong><?php echo esc_html( $disistment_title ) ?></strong></p>
							<?php
						} ?>
						<p><?php echo wp_kses_post( wpautop( get_sub_field('clause') ) ); ?></p>
						<?php
					endwhile;
				endif;
				?>
				<p class="text-bold"><?php _e( 'Important : La résiliation du présent contrat d\'admission, par l\'une des parties, doit être formellement portée à la connaissance de l\'autre, par lettre recommandée. L\'information par courriel n\'est pas admise ni valable.', 'crea' ); ?></p>
			</div>
			<div class="clause__wrapper">
				<p class="text-title"><?php _e( 'Retard de paiement', 'crea' ); ?></p>
				<p><?php the_field( 'late_payment', $formation_id ); ?></p>
			</div>

			<div class="clause__wrapper">
				<p class="text-title"><?php esc_html_e('Situation en cas d\'échec', 'crea') ?></p>
				<div class="report__content"><?php echo wp_kses_post( wpautop( get_post_meta( $formation_id, 'contract_clause_echec', true ) ) ); ?></div>
			</div>

			<div class="clause__wrapper">
				<p class="text-title"><?php esc_html_e( 'Clause de situation extraordinaire', 'crea' ); ?></p>
				<div class="report__content"><?php echo wp_kses_post( wpautop( get_post_meta( $formation_id, 'contract_clause_situation', true ) ) ); ?></div>
			</div>

			<?php
			$diploma_failed_text      = get_post_meta( $formation_id, 'diploma_failed_texte', true );
			$diploma_failed_solutions = get_post_meta( $formation_id, 'diploma_failed_solutions', true );

			if (
				! empty( $diploma_failed_text ) ||
				! empty( $diploma_failed_solutions )
			) {
				?>
				<div class="clause__wrapper">
					<p class="text-title">
						<?php esc_html_e( 'En cas d\'échec à l’obtention du bachelor, du brevet fédéral ou d\'une équivalence', 'crea' ); ?>
					</p>
					<div class="report__content">
						<p>
							<?php
							echo wp_kses(
								nl2br(
									$diploma_failed_text
								),
								array(
									'br' => array(),
									'strong' => array(),
								)
							);
							?>
							<?php
							echo wp_kses_post(
								wpautop(
									$diploma_failed_solutions
								)
							);
							?>
						</p>
					</div>
				</div>
			<?php } ?>

			<div class="clause__wrapper">
				<p class="text-title"><?php _e( 'Report du contrat d\'admission', 'crea' ); ?></p>
				<div class="report__content"><?php echo wp_kses_post( wpautop( get_field( 'contract_deferral', $formation_id ) ) ); ?></div>
			</div>

		</div>

		<button class="accordion" onclick="return false;"><?php echo ( $is_ebs ? 'VIII.' : 'IX.' ); ?> <?php _e( 'Expérience professionnelle : Stage/Emploi', 'crea' ); ?></button>
		<div class="panel text-blue stage" start="close">
			<p><?php the_field( 'internship', $formation_id ); ?></p>
		</div>

		<button class="accordion" onclick="return false;"><?php echo ( $is_ebs ? 'IX.' : 'X.' ); ?> <?php _e( 'Entretien d\'évaluation', 'crea' ); ?></button>
		<div class="panel text-blue entretien" start="close">
			<?php
			$exam_data = get_field( 'entry_exam', $formation_id );

			if ( ! empty( $exam_data ) ) {

				echo wp_kses_post(
					str_replace(
						array(
							'<strong>',
							'</strong>',
						),
						array(
							'<span class="text-bold">',
							'</span>',
						),
						wpautop( $exam_data )
					)
				);
			}
			?>

			<?php
			if ( ! empty( $exam_data['exam_points'][0]['title'] ) || ! empty( $exam_data['exam_points'][0]['details'] ) ) :
				?>
				<ol>
					<?php
					foreach ( $exam_data['exam_points'] as $point ) :
						?>
						<li>
							<p class="text-bold"><?php echo esc_html( $point['title'] ); ?></p>
							<p><?php echo wp_kses( $point['details'], array( 'br' => array() ) ); ?></p>
						</li>
						<?php
					endforeach;
					?>
				</ol>
				<?php
			endif;
			?>
		</div>

		<?php
		$period                   = get_field( 'diploma_period', $formation_id );
		$contract_back_extra_text = get_post_meta( $formation_id, 'contract_back_text', true );
		?>

		<button class="accordion" onclick="return false;"><?php echo ( $is_ebs ? 'X.' : 'XI.' ); ?> <?php _e( 'Délais', 'crea' ); ?></button>
		<div class="panel text-blue delais" start="close">
			<table>
				<tr>
					<th>
						<span class="table-title"><?php _e( 'Retour contrat d\'admission', 'crea' ); ?></span>
					</th>
					<th>
						<span class="table-title"><?php _e( 'Examen d\'entrée', 'crea' ); ?></span>
					</th>
				</tr>
				<tr>
					<td>
						<span class="text-bold"><?php echo esc_html( crea_get_date( 'contract_back', true, $formation_id ) ) . ( ! empty( $contract_back_extra_text ) ? ' <em>' . esc_html( $contract_back_extra_text ) . '</em>' : '' ); ?></span>
						<?php echo isset( $period['sendback_contract'] ) ? esc_html( $period['sendback_contract'] ) : ''; ?>
					</td>
					<td>
						<span class="text-bold"><?php the_field( 'entry_exam_date', $formation_id ); ?></span>
						<?php echo isset( $period['exam_place'] ) ? esc_html( $period['exam_place'] ) : ''; ?>
					</td>
				</tr>
			</table>
			<p><?php echo isset( $period['disclaimer'] ) ? wp_kses_post( $period['disclaimer'] ) : ''; ?></p>
		</div>

		<?php
		$final_dispositions = get_field( 'diploma_final_dispositions_form', $formation_id );
		?>
		<button class="accordion" onclick="return false;"><?php echo ( $is_ebs ? 'XI.' : 'XII.' ); ?> <?php _e( 'Dispositions finales', 'crea' ); ?></button>
		<div class="panel text-blue finance" start="close">
			<?php
			echo wp_kses_post(
				wpautop( $final_dispositions )
			);
			?>
		</div>

		<button class="accordion" onclick="return false;"><?php echo ( $is_ebs ? 'XII.' : 'XIII.' ); ?> <?php _e( 'Documents à fournir', 'crea' ); ?></button>
		<div class="panel" start="close">
			<p class="notice"><?php _e( 'Nous acceptons uniquement les fichiers dans les formats suivants : PDF, PNG, JPEG.', 'crea' ); ?></p>
			<div class="form-control required">
				<label><?php _e( 'Lettre de motivation', 'crea' ); ?></label>
				<div class="uploads">
					<button><?php _e( '(maximum 4Mo)', 'crea' ); ?></button>
					<input type="file" name="uploadLetter" accept=".pdf,.png,.jpg,.jpeg" id="uploadLetter" required>
				</div>
			</div>

			<div class="form-control required">
				<label><?php _e( 'Curriculum vitae', 'crea' ); ?></label>
				<div class="uploads">
					<button><?php _e( '(maximum 4Mo)', 'crea' ); ?></button>
					<input type="file" name="uploadCV" accept=".pdf,.png,.jpg,.jpeg" id="uploadCV" required>
				</div>
			</div>

			<div class="form-control diploma1 required">
				<label><?php _e( '[Formation 1] Diplôme', 'crea' ); ?></label>
				<div class="uploads">
					<button><?php _e( '(maximum 4Mo)', 'crea' ); ?></button>
					<input type="file" name="uploadDiploma[]" accept=".pdf,.png,.jpg,.jpeg" id="uploadDiploma" multiple>
				</div>
			</div>

			<div class="form-control diploma2">
				<label><?php _e( '[Formation 2] Diplôme', 'crea' ); ?></label>
				<div class="uploads">
					<button><?php _e( '(maximum 4Mo)', 'crea' ); ?></button>
					<input type="file" name="uploadDiploma2[]" accept=".pdf,.png,.jpg,.jpeg" id="uploadDiploma2" multiple>
				</div>
			</div>

			<div class="form-control required">
				<label><?php _e( 'Pièce d\'identité ou passeport', 'crea' ); ?></label>
				<div class="uploads">
					<button><?php _e( '(maximum 4Mo)', 'crea' ); ?></button>
					<input type="file" name="uploadIDCard[]" accept=".pdf,.png,.jpg,.jpeg" id="uploadIDCard" required multiple>
				</div>
			</div>

			<div class="form-control required">
				<label><?php echo sprintf( __( 'Justificatif de paiement de l\'inscription (CHF %s.-)', 'crea' ), esc_html( $registration_price ) ); ?></label>
				<div class="uploads">
					<button><?php _e( '(maximum 4Mo)', 'crea' ); ?></button>
					<input type="file" name="uploadPayement" accept=".pdf,.png,.jpg,.jpeg" id="uploadPayement" required>
				</div>
			</div>

			<div class="form-control" required-in="CH">
				<label><?php _e( 'Carte AVS (seulement si domicilié.e en Suisse)', 'crea' ); ?></label>
				<div class="uploads">
					<button><?php _e( '(maximum 4Mo)', 'crea' ); ?></button>
					<input type="file" name="uploadAVS[]" accept=".pdf,.png,.jpg,.jpeg" id="uploadAVS" multiple>
				</div>
			</div>

			<div class="form-control">
				<label><?php _e( 'Photo d\'identité', 'crea' ); ?></label>
				<div class="uploads">
					<button><?php _e( '(maximum 4Mo)', 'crea' ); ?></button>
					<input type="file" name="uploadIdPhoto" accept=".jpg,.jpeg" id="uploadIdPhoto">
				</div>
			</div>

		</div>

		<?php
		if ( $formation_type == 'bachelor' ) {
			$formation_type = 'Bachelor';
			$rules          = 'bachelor_rules';
			$where          = $formation_id;
		} elseif ( $formation_type == 'master' ) {
			$formation_type = 'Master';
			$rules          = 'masters_rules';
			$where          = 'options';
		} else {
			$formation_type = 'Cycle Certifiant';
			$rules          = 'cc_rules';
			$where          = 'options';
		}
		?>

		<button class="accordion" onclick="return false;"><?php echo ( $is_ebs ? 'XIII.' : 'XIV.' ); ?> <?php echo sprintf( esc_html__( 'Règlement d\'admission %s', 'crea' ), $formation_type ); ?></button>
		<div class="panel regles" start="close">
		<?php
		if ( have_rows( $rules, $where ) ) {
			$countArticle = 0;
			while ( have_rows( $rules, $where ) ) {
				the_row();
				$countArticle += 1;
				?>
					<p><span class="text-uppercase"><?php _e( 'Article', 'crea' ); ?> <?php echo $countArticle; ?></span> : <?php the_sub_field( 'article' ); ?></p>
				<?php
			}
		}
		?>
		</div>

		<div class="line submit">
			<button type="submit"><span><?php _e('Valider mon dossier', 'crea') ?></span><img src="<?php echo esc_url( get_stylesheet_directory_uri() .'/assets/pics/oval.svg' ); ?>" alt="" /></button>
		</div>

	</div>
</form>
