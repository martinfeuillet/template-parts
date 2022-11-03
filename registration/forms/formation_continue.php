<?php
/**
 * Registration form for Formations continues
 *
 * @package WordPress
 * @subpackage Crea
 */

$formation_id            = get_query_var( 'formation' );
$formation_type          = get_post_type( $formation_id );
$formation_type_name     = get_post_type_object( $formation_type )->labels->singular_name;
$diploma_list            = crea_get_previous_diplomas();
$data                    = get_query_var( 'data' );
$section_number          = 0;
$formation_theme         = get_post_meta( $formation_id, 'page_theme', true );
$form_thank_you_language = 'formation_continue' === $formation_type ? 'en' : null;

// Get data array.
if ( ! empty( $data ) ) {
	$data = unserialize( base64_decode( $data ) );
}
?>

<form action="<?php echo esc_url( get_permalink( get_page_id_by_template_name( 'template-parts/flow-registration.php', $form_thank_you_language ) ) ); ?>" method="post" enctype="multipart/form-data" autocomplete="on" id="registrationForm">
	<input type="hidden" name="formation" value="<?php echo absint( $formation_id ); ?>" autocomplete="off">
	<input type="hidden" name="countryISO" value="" autocomplete="off">
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
				<input type="text" name="studentBirthday" id="birthday" data-max-age="99" data-min-age="18" placeholder="<?php _e( 'jj-mm-aaaa', 'crea' ); ?>" required
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
					<option value=""><?php esc_html_e( 'À sélectionner', 'crea' ); ?></option>
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
				<label for="studentNationality"><?php esc_html_e( 'Nationalité', 'crea' ); ?></label>
				<select name="studentNationality" id="studentNationality" class="select-title">
					<option value="" <?php echo empty( $data['studentNationality'] ) ? 'selected' : ''; ?>><?php esc_html_e( 'À sélectionner', 'crea' ); ?></option>
					<?php foreach ( $nationalities as $nationalite ) : ?>
						<option value="<?php echo esc_attr( $nationalite ); ?>" <?php  ! empty( $data['studentNationality'] ) ? selected( $data['studentNationality'], $nationalite ) : ''; ?>><?php echo esc_html( $nationalite ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-control required">
				<label for="origin"><?php esc_html_e( 'Lieu d\'origine (lieu de naissance)', 'crea' ); ?></label>
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
				<label for="studentCity"><?php esc_html_e( 'NPA et ville', 'crea' ); ?></label>
				<input type="text" name="studentCity" id="studentCity" required
				<?php
				if ( isset( $data['studentCity'] ) ) {
																										echo 'value="' . esc_attr( $data['studentCity'] ) . '"';
				}
				?>
																									>
			</div>
			<div class="form-control required" visible-in="CH">
				<label for="studentCanton"><?php esc_html_e( 'Canton', 'crea' ); ?></label>
				<input type="text" name="studentCanton" id="studentCanton" required
				<?php
				if ( isset( $data['studentCanton'] ) ) {
																											echo 'value="' . esc_attr( $data['studentCanton'] ) . '"';
				}
				?>
																										>
			</div>
			<div class="form-control required" visible-in="FR">
				<label for="studentDepartment"><?php esc_html_e( 'Département', 'crea' ); ?></label>
				<input type="text" name="studentDepartment" id="studentDepartment" required
				<?php
				if ( isset( $data['studentDepartment'] ) ) {
																													echo 'value="' . esc_attr( $data['studentDepartment'] ) . '"';
				}
				?>
																												>
			</div>
			<div class="form-control required country">
				<label for="studentCountry"><?php esc_html_e( 'Pays', 'crea' ); ?></label>
				<?php
				$countries_obj = new WC_Countries();
				$countries     = $countries_obj->__get( 'countries' );
				?>
				<select name="studentCountry" id="studentCountry" required class="select-country">
					<option value="0"><?php esc_html_e( 'À sélectionner', 'crea' ); ?></option>
					<?php foreach ( $countries as $key => $value ) { ?>
						<option value="<?php echo esc_attr( $value ); ?>" iso="<?php echo $key; ?>"
												  <?php
													if ( isset( $data['studentMobileCode'] ) && $data['studentCountry'] == $value ) {
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
				<label for="studentMail"><?php esc_html_e( 'Mail', 'crea' ); ?></label>
				<input type="email" name="studentMail" id="studentMail" required
				<?php
				if ( isset( $data['studentMail'] ) ) {
																						echo 'value="' . esc_attr( $data['studentMail'] ) . '"';
				}
				?>
																					>
			</div>
			<div class="form-control required">
				<label><?php esc_html_e( 'Mobile', 'crea' ); ?></label>
				<select name="studentMobileCode" class="country_code_phone">
					<option value="41" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_switzerland.svg"
																<?php
																if ( isset( $data['studentMobileCode'] ) && $data['studentMobileCode'] == '41' ) {
																																		echo 'selected="true"';
																}
																?>
																																	>+41</option>
					<option value="33" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_france.svg"
																<?php
																if ( isset( $data['studentMobileCode'] ) && $data['studentMobileCode'] == '33' ) {
																																	echo 'selected="true"';
																}
																?>
																																>+33</option>
					<option value="32" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_belgium.svg"
																<?php
																if ( isset( $data['studentMobileCode'] ) && $data['studentMobileCode'] == '32' ) {
																																	echo 'selected="true"';
																}
																?>
																																>+32</option>
					<option value="39" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_italy.svg"
																<?php
																if ( isset( $data['studentMobileCode'] ) && $data['studentMobileCode'] == '39' ) {
																																echo 'selected="true"';
																}
																?>
																															>+39</option>
					<option value="44" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_uk.svg"
																<?php
																if ( isset( $data['studentMobileCode'] ) && $data['studentMobileCode'] == '44' ) {
																																echo 'selected="true"';
																}
																?>
																															>+44</option>
					<option value=""
					<?php
					if ( isset( $data['studentMobileCode'] ) && $data['studentMobileCode'] == '' ) {
											echo 'selected="true"';
					}
					?>
										><?php esc_html_e( 'Autre', 'crea' ); ?></option>
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
				<label for="studentAVS"><?php esc_html_e( 'Numéro AVS (si domicilié.e en Suisse seulement)', 'crea' ); ?></label>
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
				<label for="accountHolder"><?php esc_html_e( 'Titulaire du compte', 'crea' ); ?></label>
				<input type="text" name="accountHolder" id="accountHolder" required
				<?php
				if ( isset( $data['accountHolder'] ) ) {
																						echo 'value="' . esc_attr( $data['accountHolder'] ) . '"';
				}
				?>
																					>
			</div>
			<div class="form-control required">
				<label for="accountCity"><?php esc_html_e( 'NPA et ville', 'crea' ); ?></label>
				<input type="text" name="accountCity" id="accountCity" required
				<?php
				if ( isset( $data['accountCity'] ) ) {
																					echo 'value="' . esc_attr( $data['accountCity'] ) . '"';
				}
				?>
																				>
			</div>
			<div class="form-control required">
				<label for="accountName"><?php esc_html_e( 'Nom de l\'établissement', 'crea' ); ?></label>
				<input type="text" name="accountName" id="accountName" required
				<?php
				if ( isset( $data['accountName'] ) ) {
																					echo 'value="' . esc_attr( $data['accountName'] ) . '"';
				}
				?>
																				>
			</div>
			<div class="form-control required">
				<label for="accountIBAN"><?php esc_html_e( 'IBAN', 'crea' ); ?></label>
				<input type="text" name="accountIBAN" id="accountIBAN" required
				<?php
				if ( isset( $data['accountIBAN'] ) ) {
																					echo 'value="' . esc_attr( $data['accountIBAN'] ) . '"';
				}
				?>
																				>
			</div>
			<div class="form-control">
				<label for="accountClearing"><?php esc_html_e( 'Clearing', 'crea' ); ?></label>
				<input type="text" name="accountClearing" id="accountClearing"
				<?php
				if ( isset( $data['accountClearing'] ) ) {
																					echo 'value="' . esc_attr( $data['accountClearing'] ) . '"';
				}
				?>
																				>
			</div>
			<div class="form-control required">
				<label for="accountSWIFT"><?php esc_html_e( 'SWIFT', 'crea' ); ?></label>
				<input type="text" name="accountSWIFT" id="accountSWIFT" required
				<?php
				if ( isset( $data['accountSWIFT'] ) ) {
																						echo 'value="' . esc_attr( $data['accountSWIFT'] ) . '"';
				}
				?>
																					>
			</div>
		</div>

		<button class="accordion" onclick="return false;">III. <?php esc_html_e( 'Formations antérieures', 'crea' ); ?></button>
		<div class="panel" start="close">
			<div class="school-1 section">
				<h4><?php _e( 'Formation 1', 'crea' ); ?></h4>
				<div class="form-control <?php echo ( $formation_type === 'brevet_federal' ) ? 'required' : ''; ?>">
					<label><?php _e( 'Nom de l\'école', 'crea' ); ?></label>
					<input type="text" name="school1Name" <?php echo $formation_type === 'brevet_federal' ? 'required' : ''; ?> <?php
					if ( isset( $data['school1Name'] ) ) {
																		echo 'value="' . esc_attr( $data['school1Name'] ) . '"';
					}
					?>
																	>
				</div>
				<div class="form-control <?php echo ( $formation_type === 'brevet_federal' ) ? 'required' : ''; ?>">
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
				<div class="form-control <?php echo ( $formation_type === 'brevet_federal' ) ? 'required' : ''; ?>">
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
				<div class="form-control <?php echo ( $formation_type === 'brevet_federal' ) ? 'required' : ''; ?>">
					<label><?php _e( 'Intitulé du diplôme', 'crea' ); ?></label>
					<input type="text" name="school1DiplomaName" <?php echo ( $formation_type === 'brevet_federal' ) ? 'required' : ''; ?> <?php
					if ( isset( $data['school1DiplomaName'] ) ) {
																				echo 'value="' . esc_attr( $data['school1DiplomaName'] ) . '"';
					}
					?>
																			>
				</div>
				<div class="form-control <?php echo ( $formation_type === 'brevet_federal' ) ? 'required' : ''; ?>">
					<label><?php _e( 'Diplôme obtenu', 'crea' ); ?></label>
					<div class="radio-group">
						<input type="radio" name="school1HasDiploma" value="yes" <?php echo ( $formation_type === 'brevet_federal' ) ? 'required' : ''; ?> id="school1DiplomaYes"
																							<?php
																							if ( isset( $data['school1HasDiploma'] ) and $data['school1HasDiploma'] == 'yes' ) {
																														echo 'checked="true"';
																							}
																							?>
																													>
						<label for="school1DiplomaYes"><?php _e( 'Oui', 'crea' ); ?></label>
					</div>
					<div class="radio-group">
						<input type="radio" name="school1HasDiploma" value="no" <?php echo ( $formation_type === 'brevet_federal' ) ? 'required' : ''; ?> id="school1DiplomaNo"
																						   <?php
																							if ( isset( $data['school1HasDiploma'] ) and $data['school1HasDiploma'] == 'no' ) {
																													echo 'checked="true"';
																							}
																							?>
																												>
						<label for="school1DiplomaNo"><?php _e( 'Non', 'crea' ); ?></label>
					</div>
					<div class="radio-group">
						<input type="radio" name="school1HasDiploma" value="progress" <?php echo ( $formation_type === 'brevet_federal' ) ? 'required' : ''; ?> id="school1DiplomaProgress"
																								 <?php
																									if ( isset( $data['school1HasDiploma'] ) and $data['school1HasDiploma'] == 'progress' ) {
																													echo 'checked="true"';
																									}
																									?>
																												>
						<label for="school1DiplomaProgress"><?php _e( 'En cours', 'crea' ); ?></label>
					</div>
				</div>
				<div class="form-control <?php echo ( $formation_type === 'brevet_federal' ) ? 'required' : ''; ?>">
					<label><?php _e( 'Année du diplôme', 'crea' ); ?></label>
					<input type="text" name="school1DiplomaYear" <?php echo ( $formation_type === 'brevet_federal' ) ? 'required' : ''; ?> <?php
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

		<button class="accordion" onclick="return false;">IV. <?php _e( 'Coordonnées de l\'entreprise', 'crea' ); ?></button>
		<div class="panel panel--company" start="close">
			<p class="panel__intro"><?php _e( 'Ces informations sont à compléter seulement si votre employeur participe au financement de la formation.', 'crea' ); ?></p>

			<?php
			if ( $formation_type === 'brevet_federal' || $formation_type === 'certificat' ) {

				$asterisk_private = get_post_meta( $formation_id, 'payment_private_asterisk', true );
				$asterisk_company = get_post_meta( $formation_id, 'payment_company_asterisk', true );
				?>

				<?php
				if ( ! empty( $asterisk_private ) || ! empty( $asterisk_company ) ) {
					?>

					<div class="form__asterisk">

						<?php if ( ! empty( $asterisk_private ) ) { ?>
							<p><?php echo wp_kses_post( $asterisk_private ); ?></p>
						<?php } ?>

						<?php if ( ! empty( $asterisk_company ) ) { ?>
							<p><?php echo wp_kses_post( $asterisk_company ); ?></p>
						<?php } ?>

					</div>

					<?php
				}
			}
			?>

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
																									echo 'value="' . $data['companyAccountClearing'] . '"';
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

		<?php
		$session_start         = strtotime( (string) get_field( 'session_start', $formation_id ) );
		$session_end           = strtotime( (string) get_field( 'session_end', $formation_id ) );
		$registration_price    = get_field( 'registration_price', $formation_id );
		$formation_prices      = get_prices_data( $formation_id );
		$total_price           = isset( $formation_prices['price'] ) ? $formation_prices['price'] : '';
		$total_price_formatted = isset( $formation_prices['price_formatted'] ) ? $formation_prices['price_formatted'] : '';
		?>

		<button class="accordion" onclick="return false;">V. <?php _e( 'Inscription', 'crea' ); ?> <?php echo ! empty( $formation_prices['early_title'] ) ? ' - ' . wp_kses( $formation_prices['early_title'], array( 'del' => array() ) ) : ''; ?></button>
		<div class="panel text-blue inscription" start="close">
			<p class="text-bold">
				<?php
				if (
					'brevet_federal' === $formation_type ||
					'formation_continue' === $formation_type
				) {

					echo sprintf(
						esc_html__( 'Par ma signature, je confirme mon inscription ferme à la session %1$s - %2$s de l’école CREA pour un montant d’écolage total de %3$s.', 'crea' ),
						ucfirst( wp_date( 'F Y', $session_start ) ),
						ucfirst( wp_date( 'F Y', $session_end ) ),
						wp_kses(
							$total_price_formatted,
							array(
								'del' => array(),
							)
						)
					);

				} else {

					echo sprintf(
						esc_html__( 'Je confirme mon inscription ferme (sous réserve d\'acceptation par CREA) au %1$s - session %2$s-%3$s de l’école CREA pour un montant d’écolage total de %4$s.', 'crea' ),
						esc_html( ucfirst( $formation_type_name ) ),
						date( 'Y', $session_start ),
						date( 'Y', $session_end ),
						wp_kses(
							$total_price_formatted,
							array(
								'del' => array(),
							)
						)
					);
				}
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
			$free_options_intro = get_post_meta( $formation_id, 'supplementary_free_options_before_choice', true );
			$free_options_yes   = get_post_meta( $formation_id, 'supplementary_free_options_choice_yes', true );
			$free_options_no    = get_post_meta( $formation_id, 'supplementary_free_options_choice_no', true );
			if ( ! empty( $free_options_yes ) || ! empty( $free_options_no ) ) :
				?>

				<fieldset class="options--highlighted">
					<?php
					echo ! empty( $free_options_intro ) ? wp_kses(
						wpautop( $free_options_intro ),
						array(
							'p'      => array(),
							'br'     => array(),
							'strong' => array(),
							'span'   => array( 'class' => array() ),
						)
					) : '';
					?>

					<?php
					if ( ! empty( $free_options_yes ) ) {
						?>

						<label for="freeOptionsYes">
							<input type="radio" id="freeOptionsYes" name="free_option" value="1" <?php empty( $data['free_option'] ) || (int) $data['free_option'] === 1 ? 'checked' : ''; ?> required>
							<span class="control">
								<span class="text-bold"><?php echo esc_html( $free_options_yes ); ?></span>
							</span>
						</label>

						<?php
					}
					?>

					<?php
					if ( ! empty( $free_options_no ) ) {
						?>

						<label for="freeOptionsNo">
							<input type="radio" id="freeOptionsNo" name="free_option" value="2" <?php isset( $data['free_option'] ) ? checked( (int) $data['free_option'], 2 ) : ''; ?> required>
							<span class="control">
								<span class="text-bold"><?php echo esc_html( $free_options_no ); ?></span>
							</span>
						</label>

						<?php
					}
					?>
				</fieldset>

				<?php
			endif;
			?>

			<?php
			$registration_date_text = get_post_meta( $formation_id, 'inscription_info', true );
			?>
			<table style="margin-top:24px;">
				<tr>
					<td>
						<span class="table-title"><?php esc_html_e( 'Inscription', 'crea' ); ?></span>
					</td>
					<td>
						<?php echo esc_html( crea_get_date( 'contract_back', true, $formation_id ) ); ?>
						<?php echo ! empty( $registration_date_text ) ? '<br>' . esc_html( $registration_date_text ) : ''; ?>
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

				<?php
				if ( $formation_type === 'brevet_federal' || $formation_type === 'certificat' ) {

					$date_exam_written = get_post_meta( $formation_id, 'exam_written', true );
					$date_exam_oral    = get_post_meta( $formation_id, 'exam_oral', true );

					if ( ! empty( $date_exam_written ) || ! empty( $date_exam_oral ) ) {
						?>

						<tr>

							<td>
								<?php
								if ( $formation_type === 'brevet_federal' ) {
									?>

									<span class="table-title"><?php _e( 'Examens du brevet Fédéral écrit & oral', 'crea' ); ?></span>

									<?php
								} else {
									?>

									<span class="table-title"><?php _e( 'Examens du Certificat écrit & oral', 'crea' ); ?></span>

									<?php
								}
								?>
							</td>
							<td>
								<?php
								if ( date( 'M', strtotime( $date_exam_written ) ) === date( 'M', strtotime( $date_exam_oral ) ) ) {

									echo esc_html( wp_date( 'F Y', strtotime( $date_exam_written ) ) );

								} else {

									if ( date( 'c', strtotime( $date_exam_written ) ) < date( 'c', strtotime( $date_exam_oral ) ) ) {

										echo wp_date( 'F', strtotime( $date_exam_written ) ) . ' & ' . esc_html( wp_date( 'F Y', strtotime( $date_exam_oral ) ) );

									} else {

										echo wp_date( 'F', strtotime( $date_exam_oral ) ) . ' & ' . esc_html( wp_date( 'F Y', strtotime( $date_exam_written ) ) );

									}
								}
								?>
							</td>

						</tr>

						<?php
					}
				} else {

					if ( ! empty( $final_work = crea_get_date( 'final_work', false, $formation_id ) ) ) {
						?>

						<tr>

							<td>
								<span class="table-title"><?php _e( 'Travail personnel de certificat', 'crea' ); ?></span>
							</td>
							<td>
								<?php echo esc_html( $final_work ); ?>
							</td>

						</tr>

						<?php
					}
					?>

					<?php
				}
				?>
			</table>
		</div>

		<button class="accordion open" onclick="return false;">VI. <?php _e( 'Finance d\'inscription', 'crea' ); ?></button>
		<div class="panel text-blue finance" start="open">
			<p class="text-emphasize"><?php echo sprintf( __( 'Un montant de CHF %s.- sera perçu pour la constitution du dossier.', 'crea' ), esc_html( $registration_price ) ); ?></p>
			<p><?php _e( 'Ce montant ne sera pas remboursé en cas de désistement. En revanche, si le candidat n\'est pas retenu, cette finance d\'inscription lui sera restituée.', 'crea' ); ?></p>

			<p><?php _e( 'Le règlement est à effectuer sur le compte suivant', 'crea' ); ?> :</p>
			<p class="text-bold">Crédit Suisse, Genève / IBAN : CH30 0483 5175 2978 1100 1 / Clearing : 4835 / Swift CRESCHZZ80A</p>
		</div>

		<button class="accordion" onclick="return false;">VII. <?php _e( 'Modalités de paiement', 'crea' ); ?></button>
		<div class="panel text-blue modalite" start="close">
			<?php
			$full_payment_date = get_field( 'diploma_contract_split_payment_date', $formation_id );
			?>

			<p><?php echo sprintf( __( 'Je m\'engage à verser le montant de %s à CREA selon ce qui suit', 'crea' ), wp_kses( $total_price_formatted, array( 'del' => array() ) ) ); ?></p>
			<?php
			if ( $formation_type === 'brevet_federal' || $formation_type === 'certificat' ) {
				?>
				<p><?php esc_html_e( 'Les échéances sont à respecter même pendant les périodes de stage ou de vacances.', 'crea' ); ?></p>
				<?php
			}
			?>
			<p><?php _e( 'Veuillez cocher la variante choisie', 'crea' ); ?> : </p>
			<fieldset>

				<?php
				// Make one time payment the default value
				$modalite_saved_value = ! empty( $data['modalite'] ) ? (int) $data['modalite'] : 0;
				?>

				<!-- Paiement en ligne -->
				<?php if ( $formation_type === 'formation_continue' ) { ?>

					<label for="modaliteOption3">
						<input type="radio" id="modaliteOption3" name="modalite" value="3" <?php  ! empty( $data['modalite'] ) ? checked( (int) $data['modalite'], 3 ) : ''; ?>>
						<span class="control">
							<span class="text-bold"><?php echo esc_html__( 'Je souhaite payer directement en ligne (vous serez redirigé après avoir complété le dossier digital)', 'crea' ); ?></span>
						</span>
					</label>

				<?php } ?>

				<!-- En 1 tranche -->
				<label for="modaliteOption1">
					<input type="radio" id="modaliteOption1" name="modalite" value="1" <?php checked( in_array( $modalite_saved_value, array( 0, 1 ) ) ); ?>>
					<span class="control">
						<span class="text-bold"><?php echo sprintf( esc_html__( 'En 1 tranche pour un montant total de %1$s au %2$s', 'crea' ), wp_kses( $total_price_formatted, array( 'del' => array() ) ), $full_payment_date ); ?></span>
					</span>
				</label>

				<!-- En mensualités / trimestres -->
				<?php
				if ( have_rows( 'tab_head', $formation_id ) and have_rows( 'tab_body', $formation_id ) ) {

					// Monthly or quarterly label
					if ( $formation_type === 'formation_continue' ) {

						$table_payment_label = sprintf( __( 'En mensualités selon le plan de paiement suivant pour un montant total de %s', 'crea' ), wp_kses( $total_price_formatted, array( 'del' => array() ) ) );

					} else {

						$table_payment_label = sprintf( __( 'En trimestres selon le plan de paiement suivant pour un montant total de %s', 'crea' ), wp_kses( $total_price_formatted, array( 'del' => array() ) ) );

					}
					?>

					<label for="modaliteOption2">
						<input type="radio" id="modaliteOption2" name="modalite" value="2" <?php  ! empty( $data['modalite'] ) ? checked( (int) $data['modalite'], 2 ) : ''; ?>>
						<span class="control">
							<span class="text-bold"><?php echo $table_payment_label; ?></span>
							<table>
								<tr>
									<td>
										<?php _e( 'Versements', 'crea' ); ?>
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
												CHF
												<?php
												if ( ! empty( get_sub_field( 'col_1' ) ) ) {
														echo number_format( get_sub_field( 'col_1' ), 0, ',', '\'' );
														$rowPrice += get_sub_field( 'col_1' );
												} else {
													echo '-';
												}
												?>
													.-
											</td>
											<td>
												CHF
												<?php
												if ( ! empty( get_sub_field( 'col_2' ) ) ) {
														echo number_format( get_sub_field( 'col_2' ), 0, ',', '\'' );
														$rowPrice += get_sub_field( 'col_2' );
												} else {
													echo '-';
												}
												?>
													.-
											</td>
											<td>
												CHF
												<?php
												if ( ! empty( get_sub_field( 'col_3' ) ) ) {
														echo number_format( get_sub_field( 'col_3' ), 0, ',', '\'' );
														$rowPrice += get_sub_field( 'col_3' );
												} else {
													echo '-';
												}
												?>
													.-
											</td>

											<?php if ( $formation_type === 'brevet_federal' || $formation_type === 'certificat' ) { ?>

												<td>
													CHF
													<?php
													if ( ! empty( get_sub_field( 'col_4' ) ) ) {
															echo number_format( get_sub_field( 'col_4' ), 0, ',', '\'' );
															$rowPrice += get_sub_field( 'col_4' );
													} else {
														echo '-';
													}
													?>
														.-
												</td>

											<?php } ?>

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

				<?php
				if (
					'brevet_federal' === $formation_type ||
					'certificat' === $formation_type
				) {
					?>

					<?php
					$mensualite_nb         = get_post_meta( $formation_id, 'diploma_contract_monthly_payement_number', true );
					$mensualite_amount     = (int) $total_price / (int) $mensualite_nb;
					$mensualite_start_date = get_post_meta( $formation_id, 'diploma_contract_monthly_payement_date_start', true );
					$mensualite_end_date   = get_post_meta( $formation_id, 'diploma_contract_monthly_payement_date_end', true );

					if ( ! empty( $mensualite_nb ) ) {
						?>

						<label for="modaliteOption4">
							<input type="radio" id="modaliteOption4" name="modalite" value="4" <?php checked( (int) $modalite_saved_value, 4 ); ?>>
							<span class="control">
								<span class="text-bold"><?php echo sprintf( esc_html__( 'En %1$d mensualités de CHF %2$s.- du %3$s au %4$s pour un montant total de %5$s', 'crea' ), absint( $mensualite_nb ), number_format( (float) $mensualite_amount, 0, ',', '\'' ), wp_date( 'd.m.Y', strtotime( $mensualite_start_date ) ), wp_date( 'd.m.Y', strtotime( $mensualite_end_date ) ), wp_kses( $total_price_formatted, array( 'del' => array() ) ) ); ?></span>
							</span>
						</label>

					<?php } ?>

					<?php
				}
				?>

				<?php
				if (
					'brevet_federal' === $formation_type
				) {
					?>
					<!-- Convention spécifique -->
					<?php
					$custom_payment = get_field( 'custom_payment', $formation_id );

					if ( ! empty( $custom_payment['title'] ) ) {
						?>

						<label for="modaliteOption5">
							<input type="radio" id="modaliteOption5" name="modalite" value="5" <?php checked( (int) $modalite_saved_value, 5 ); ?>>
							<span class="control">
								<span class="text-bold"><?php echo esc_html( $custom_payment['title'] ); ?></span>
								<?php
								if ( ! empty( $custom_payment['body'] ) ) {
									?>
									<span>
										<?php
										echo wp_kses(
											nl2br( $custom_payment['body'] ),
											array(
												'strong' => array(),
												'em'     => array(),
												'br'     => array(),
											)
										);
										?>
									</span>
									<?php
								}
								?>
							</span>
						</label>

					<?php } ?>

				<?php } ?>

			</fieldset>
		</div>

		<button class="accordion" onclick="return false;">VIII. <?php _e( 'Clauses', 'crea' ); ?></button>
		<div class="panel text-blue clauses" start="close">
			<div class="clause__wrapper">
				<p class="text-title"><?php _e( 'Clauses de désistement', 'crea' ); ?></p>
				<?php
				if ( have_rows( 'disistment_clauses', $formation_id ) ) :
					while ( have_rows( 'disistment_clauses', $formation_id ) ) :
						the_row()
						?>

						<?php
						if ( ! empty( $disistment_title = get_sub_field( 'title' ) ) ) {
							?>
							<p class="text-subtitle"><strong><?php echo esc_html( $disistment_title ); ?></strong></p>
							<?php
						}
						?>
						<p><?php echo wp_kses_post( wpautop( get_sub_field( 'clause' ) ) ); ?></p>
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

			<?php
			if (
				'brevet_federal' !== $formation_type &&
				'formation_continue' !== $formation_type
			) {
				?>

				<div class="clause__wrapper">
					<p class="text-title"><?php esc_html_e( 'Clause de résiliation', 'crea' ); ?></p>
					<?php
					echo wp_kses_post(
						wpautop(
							get_field( 'termination_clause', $formation_id )
						)
					);
					?>
				</div>

			<?php } ?>

			<?php if ( 'brevet_federal' === $formation_type ) { ?>

				<div class="clause__wrapper">
					<p class="text-title"><?php esc_html_e( 'Situation en cas d\'échec', 'crea' ); ?></p>
					<div class="report__content"><?php echo wp_kses_post( wpautop( get_post_meta( $formation_id, 'contract_clause_echec', true ) ) ); ?></div>
				</div>

				<div class="clause__wrapper">
					<p class="text-title"><?php esc_html_e( 'Clause de situation extraordinaire', 'crea' ); ?></p>
					<div class="report__content"><?php echo wp_kses_post( wpautop( get_post_meta( $formation_id, 'contract_clause_situation', true ) ) ); ?></div>
				</div>

			<?php } ?>

			<div class="clause__wrapper">
				<p class="text-title"><?php _e( 'Report du contrat d\'admission', 'crea' ); ?></p>
				<div class="report__content"><?php echo wp_kses_post( wpautop( get_field( 'contract_deferral', $formation_id ) ) ); ?></div>
			</div>

		</div>

		<button class="accordion" onclick="return false;">IX. <?php _e( 'Validation d\'admission', 'crea' ); ?></button>
		<div class="panel text-blue delais" start="close">
			<?php if ( ! empty( $extra_infos = get_field( 'diploma_final_dispositions', $formation_id ) ) ) { ?>
				<div class="clause__wrapper">
					<?php
					echo wp_kses(
						wpautop( $extra_infos ),
						array(
							'p'      => array(),
							'strong' => array(),
							'br'     => array(),
						)
					);
					?>
				</div>
			<?php } ?>
			<table>
				<tr>
					<th>
						<span class="table-title"><?php _e( 'Retour contrat d\'admission', 'crea' ); ?></span>
					</th>
				</tr>
				<tr>
					<td>
						<span class="text-bold"><?php echo esc_html( crea_get_date( 'contract_back', true, $formation_id ) ); ?>.</span>
					</td>
				</tr>
			</table>
		</div>


		<button class="accordion" onclick="return false;">X. <?php _e( 'Documents à fournir', 'crea' ); ?></button>
		<div class="panel" start="close">
			<p class="notice"><?php _e( 'Nous acceptons uniquement les fichiers dans les formats suivants : PDF, PNG, JPEG.', 'crea' ); ?></p>
			<div class="form-control required">
				<label><?php _e( 'Curriculum vitae', 'crea' ); ?></label>
				<div class="uploads">
					<button><?php _e( '(maximum 4Mo)', 'crea' ); ?></button>
					<input type="file" name="uploadCV" accept=".pdf,.png,.jpg,.jpeg" id="uploadCV" required>
				</div>
			</div>

			<div class="form-control diploma1 <?php echo ( $formation_type === 'brevet_federal' ) ? 'required' : ''; ?>">
				<label><?php _e( '[Formation 1] Diplôme', 'crea' ); ?></label>
				<div class="uploads">
					<button><?php _e( '(maximum 4Mo)', 'crea' ); ?></button>
					<input type="file" name="uploadDiploma[]" accept=".pdf,.png,.jpg,.jpeg" id="uploadDiploma" <?php echo ( $formation_type === 'brevet_federal' ) ? 'required' : ''; ?> multiple>
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

			<div class="form-control <?php echo ( $formation_type === 'brevet_federal' || $formation_type === 'certificat' ) ? 'required' : ''; ?>">
				<label><?php echo sprintf( __( 'Justificatif de paiement de l\'inscription (CHF %s.-)', 'crea' ), esc_html( $registration_price ) ); ?></label>
				<div class="uploads">
					<button><?php _e( '(maximum 4Mo)', 'crea' ); ?></button>
					<input type="file" name="uploadPayement" accept=".pdf,.png,.jpg,.jpeg" id="uploadPayement">
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

			<?php
			if ( $formation_type === 'brevet_federal' || $formation_type === 'certificat' ) {
				?>
				<div class="form-control <?php echo $formation_type === 'brevet_federal' ? 'required' : ''; ?>">
					<label><?php _e( 'Attestation(s) de travail', 'crea' ); ?></label>
					<div class="uploads">
						<button><?php _e( '(maximum 4Mo)', 'crea' ); ?></button>
						<input type="file" name="uploadWork[]" accept=".pdf,.png,.jpg,.jpeg" id="uploadWork" <?php echo $formation_type === 'brevet_federal' ? 'required' : ''; ?> multiple>
					</div>
				</div>
				<?php
			}
			?>

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
		} elseif ( $formation_type == 'brevet_federal' ) {
			$formation_type = 'Brevet fédéral';
			$rules          = 'brevets_rules';
			$where          = 'options';
		} elseif ( $formation_type == 'certificat' ) {
			$formation_type = 'Certificat';
			$rules          = 'certificats_rules';
			$where          = 'options';
		} else {
			$formation_type = 'Cycle Certifiant';
			$rules          = 'cc_rules';
			$where          = 'options';
		}
		?>

		<button class="accordion" onclick="return false;">XI. <?php echo sprintf( esc_html__( 'Règlement d\'admission %s', 'crea' ), $formation_type ); ?></button>
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
			<button type="submit"><span><?php _e( 'Valider mon dossier', 'crea' ); ?></span><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/pics/oval.svg' ); ?>" alt="" /></button>
		</div>

	</div>
</form>
