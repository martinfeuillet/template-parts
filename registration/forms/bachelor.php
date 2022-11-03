<?php
/**
 * Registration form for Bachelors
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

		<?php
		get_template_part(
			'template-parts/registration/forms/components/student-identity',
			null,
			array(
				'data'           => $data,
				'section_number' => ++$section_number,
				'min_age'        => 16,
			)
		);
		?>

		<button class="accordion" onclick="return false;">II. <?php esc_html_e( 'Coordonnées des parents', 'crea' ); ?></button>
		<div class="panel panel--parent" start="close">

			<div class="parent-1 section">

				<p class="parent__title"><?php esc_html_e( 'Personne de contact', 'crea' ); ?> 1</p>
				<div class="form-control required">
					<label for="contact1Type"><?php esc_html_e( 'Lien avec la personne', 'crea' ); ?></label>
					<select name="contact1Type" id="contact1Type" class="contact1-type">
						<option value="0" ><?php esc_html_e( 'À sélectionner', 'crea' ); ?></option>
						<option value="<?php esc_html_e( 'Mère', 'crea' ); ?>"
														 <?php
															if ( isset( $data['contact1Type'] ) && $data['contact1Type'] == esc_html__( 'Mère', 'crea' ) ) {
																		echo 'selected="true"';
															}
															?>
																	><?php esc_html_e( 'Mère', 'crea' ); ?></option>
						<option value="<?php esc_html_e( 'Père', 'crea' ); ?>"
														 <?php
															if ( isset( $data['contact1Type'] ) && $data['contact1Type'] == esc_html__( 'Père', 'crea' ) ) {
																		echo 'selected="true"';
															}
															?>
																	><?php esc_html_e( 'Père', 'crea' ); ?></option>
						<option value="<?php esc_html_e( 'Tuteur légal', 'crea' ); ?>"
														 <?php
															if ( isset( $data['contact1Type'] ) && $data['contact1Type'] == esc_html__( 'Tuteur légal', 'crea' ) ) {
																				echo 'selected="true"';
															}
															?>
																			><?php esc_html_e( 'Tuteur légal', 'crea' ); ?></option>
						<option value="<?php esc_html_e( 'Autre', 'crea' ); ?>"
														 <?php
															if ( isset( $data['contact1Type'] ) && $data['contact1Type'] == __( 'Autre', 'crea' ) ) {
																			echo 'selected="true"';
															}
															?>
																		><?php esc_html_e( 'Autre', 'crea' ); ?></option>
					</select>
				</div>

				<div class="form-control required">
					<label for="contact1Surname"><?php esc_html_e( 'Nom', 'crea' ); ?></label>
					<input type="text" name="contact1Surname" id="contact1Surname" required
					<?php
					if ( isset( $data['contact1Surname'] ) ) {
																								echo 'value="' . esc_attr( $data['contact1Surname'] ) . '"';
					}
					?>
																							>
				</div>
				<div class="form-control required">
					<label for="contact1Name"><?php esc_html_e( 'Prénom', 'crea' ); ?></label>
					<input type="text" name="contact1Name" id="contact1Name" required
					<?php
					if ( isset( $data['contact1Name'] ) ) {
																							echo 'value="' . esc_attr( $data['contact1Name'] ) . '"';
					}
					?>
																						>
				</div>
				<div class="form-control required">
					<label for="contact1Profession"><?php esc_html_e( 'Profession', 'crea' ); ?></label>
					<input type="text" name="contact1Profession" id="contact1Profession"
					<?php
					if ( isset( $data['contact1Profession'] ) ) {
																								echo 'value="' . esc_attr( $data['contact1Profession'] ) . '"';
					}
					?>
																							>
				</div>
				<div class="form-control required form--address">
					<label for="contact1Address"><?php esc_html_e( 'Adresse', 'crea' ); ?></label>
					<input type="text" name="contact1Address" id="contact1Address" placeholder="<?php esc_html_e( 'Indiquez un lieu', 'crea' ); ?>" onkeypress="return enterDisabled(event)" required
																										  <?php
																											if ( isset( $data['contact1Address'] ) ) {
																																							echo 'value="' . esc_attr( $data['contact1Address'] ) . '"';
																											}
																											?>
																																						>
				</div>
				<div class="form-control required form--nb">
					<label for="contact1AddressNb"><?php esc_html_e( 'Numéro', 'crea' ); ?></label>
					<input type="text" name="contact1AddressNb" id="contact1AddressNb" required
					<?php
					if ( isset( $data['contact1AddressNb'] ) ) {
						echo 'value="' . esc_attr( $data['contact1AddressNb'] ) . '"'; }
					?>
					>
				</div>
				<div class="form-control required">
					<label for="contact1City"><?php esc_html_e( 'NPA et ville', 'crea' ); ?></label>
					<input type="text" name="contact1City" id="contact1City" required
					<?php
					if ( isset( $data['contact1City'] ) ) {
																												echo 'value="' . esc_attr( $data['contact1City'] ) . '"';
					}
					?>
																											>
				</div>
				<div class="form-control required">
					<label for="contact1Mail"><?php esc_html_e( 'Mail', 'crea' ); ?></label>
					<input type="email" name="contact1Mail" id="contact1Mail" required
					<?php
					if ( isset( $data['contact1Mail'] ) ) {
																							echo 'value="' . esc_attr( $data['contact1Mail'] ) . '"';
					}
					?>
																						>
				</div>
				<div class="form-control">
					<label><?php esc_html_e( 'Mobile', 'crea' ); ?></label>
					<select name="contact1MobileCode" class="country_code_phone">
						<option value="41" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_switzerland.svg"
																	<?php
																	if ( isset( $data['contact1MobileCode'] ) and $data['contact1MobileCode'] == '41' ) {
																																			echo 'selected="true"';
																	}
																	?>
																																		>+41</option>
						<option value="33" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_france.svg"
																	<?php
																	if ( isset( $data['contact1MobileCode'] ) and $data['contact1MobileCode'] == '33' ) {
																																		echo 'selected="true"';
																	}
																	?>
																																	>+33</option>
						<option value="32" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_belgium.svg"
																	<?php
																	if ( isset( $data['contact1MobileCode'] ) and $data['contact1MobileCode'] == '32' ) {
																																		echo 'selected="true"';
																	}
																	?>
																																	>+32</option>
						<option value="39" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_italy.svg"
																	<?php
																	if ( isset( $data['contact1MobileCode'] ) and $data['contact1MobileCode'] == '39' ) {
																																	echo 'selected="true"';
																	}
																	?>
																																>+39</option>
						<option value="44" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_uk.svg"
																	<?php
																	if ( isset( $data['contact1MobileCode'] ) and $data['contact1MobileCode'] == '44' ) {
																																	echo 'selected="true"';
																	}
																	?>
																																>+44</option>
						<option value=""
						<?php
						if ( isset( $data['contact1MobileCode'] ) && $data['contact1MobileCode'] == '' ) {
												echo 'selected="true"';
						}
						?>
											><?php esc_html_e( 'Autre', 'crea' ); ?></option>
					</select>
					<input type="tel" name="contact1Mobile"
					<?php
					if ( isset( $data['contact1Mobile'] ) ) {
																echo 'value="' . esc_attr( $data['contact1Mobile'] ) . '"';
					}
					?>
															>
				</div>

			</div>

			<div class="parent-2 section">

				<p class="parent__title"><?php _e( 'Personne de contact', 'crea' ); ?> 2</p>

				<div class="form-control">
					<label for="contact2Type"><?php _e( 'Lien avec la personne', 'crea' ); ?></label>
					<select name="contact2Type" id="contact2Type" class="contact2-type">
						<option value="<?php _e( 'Aucun', 'crea' ); ?>"
												 <?php
													if ( isset( $_REQUEST['contact2Type'] ) && $_REQUEST['contact2Type'] == __( 'Aucun', 'crea' ) ) {
																			echo 'selected="true"';
													}
													?>
																		><?php _e( 'Aucun', 'crea' ); ?></option>
						<option value="<?php _e( 'Mère', 'crea' ); ?>"
												 <?php
													if ( isset( $_REQUEST['contact2Type'] ) && $_REQUEST['contact2Type'] == __( 'Mère', 'crea' ) ) {
																		echo 'selected="true"';
													}
													?>
																	><?php _e( 'Mère', 'crea' ); ?></option>
						<option value="<?php _e( 'Père', 'crea' ); ?>"
												 <?php
													if ( isset( $_REQUEST['contact2Type'] ) && $_REQUEST['contact2Type'] == __( 'Père', 'crea' ) ) {
																		echo 'selected="true"';
													}
													?>
																	><?php _e( 'Père', 'crea' ); ?></option>
						<option value="<?php _e( 'Tuteur légal', 'crea' ); ?>"
												 <?php
													if ( isset( $_REQUEST['contact2Type'] ) && $_REQUEST['contact2Type'] == __( 'Tuteur légal', 'crea' ) ) {
																				echo 'selected="true"';
													}
													?>
																			><?php _e( 'Tuteur légal', 'crea' ); ?></option>
						<option value="<?php _e( 'Autre', 'crea' ); ?>"
												 <?php
													if ( isset( $_REQUEST['contact2Type'] ) && $_REQUEST['contact2Type'] == __( 'Autre', 'crea' ) ) {
																			echo 'selected="true"';
													}
													?>
																		><?php _e( 'Autre', 'crea' ); ?></option>
					</select>
				</div>
				<div class="form-control">
					<label for="contact2Surname"><?php _e( 'Nom', 'crea' ); ?></label>
					<input type="text" name="contact2Surname" id="contact2Surname"
					<?php
					if ( isset( $data['contact2Surname'] ) ) {
																						echo 'value="' . esc_attr( $data['contact2Surname'] ) . '"';
					}
					?>
																					>
				</div>
				<div class="form-control">
					<label for="contact2Name"><?php _e( 'Prénom', 'crea' ); ?></label>
					<input type="text" name="contact2Name" id="contact2Name"
					<?php
					if ( isset( $data['contact2Name'] ) ) {
																					echo 'value="' . esc_attr( $data['contact2Name'] ) . '"';
					}
					?>
																				>
				</div>
				<div class="form-control">
					<label for="contact2Profession"><?php _e( 'Profession', 'crea' ); ?></label>
					<input type="text" name="contact2Profession" id="contact2Profession"
					<?php
					if ( isset( $data['contact2Profession'] ) ) {
																								echo 'value="' . esc_attr( $data['contact2Profession'] ) . '"';
					}
					?>
																							>
				</div>
				<div class="form-control form--address">
					<label for="contact2Address"><?php _e( 'Adresse', 'crea' ); ?></label>
					<input type="text" name="contact2Address" id="contact2Address" placeholder="<?php _e( 'Indiquez un lieu', 'crea' ); ?>" onkeypress="return enterDisabled(event)"
																										  <?php
																											if ( isset( $data['contact2Address'] ) ) {
																																					echo 'value="' . esc_attr( $data['contact2Address'] ) . '"';
																											}
																											?>
																																				>
				</div>
				<div class="form-control form--nb">
					<label for="contact2AddressNb"><?php _e( 'Numéro', 'crea' ); ?></label>
					<input type="text" name="contact2AddressNb" id="contact2AddressNb"
					<?php
					if ( isset( $data['contact2AddressNb'] ) ) {
						echo 'value="' . esc_attr( $data['contact2AddressNb'] ) . '"'; }
					?>
					>
				</div>
				<div class="form-control">
					<label for="contact2City"><?php _e( 'NPA et ville', 'crea' ); ?></label>
					<input type="text" name="contact2City" id="contact2City"
					<?php
					if ( isset( $data['contact2City'] ) ) {
																									echo 'value="' . esc_attr( $data['contact2City'] ) . '"';
					}
					?>
																								>
				</div>
				<div class="form-control">
					<label for="contact2Mail"><?php _e( 'Mail', 'crea' ); ?></label>
					<input type="email" name="contact2Mail" id="contact2Mail"
					<?php
					if ( isset( $data['contact2Mail'] ) ) {
																					echo 'value="' . esc_attr( $data['contact2Mail'] ) . '"';
					}
					?>
																				>
				</div>
				<div class="form-control">
					<label><?php _e( 'Mobile', 'crea' ); ?></label>
					<select name="contact2MobileCode" class="country_code_phone">
						<option value="41" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_switzerland.svg"
																	<?php
																	if ( isset( $data['contact2MobileCode'] ) and $data['contact2MobileCode'] == '41' ) {
																																			echo 'selected="true"';
																	}
																	?>
																																		>+41</option>
						<option value="33" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_france.svg"
																	<?php
																	if ( isset( $data['contact2MobileCode'] ) and $data['contact2MobileCode'] == '33' ) {
																																		echo 'selected="true"';
																	}
																	?>
																																	>+33</option>
						<option value="32" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_belgium.svg"
																	<?php
																	if ( isset( $data['contact2MobileCode'] ) and $data['contact2MobileCode'] == '32' ) {
																																		echo 'selected="true"';
																	}
																	?>
																																	>+32</option>
						<option value="39" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_italy.svg"
																	<?php
																	if ( isset( $data['contact2MobileCode'] ) and $data['contact2MobileCode'] == '39' ) {
																																	echo 'selected="true"';
																	}
																	?>
																																>+39</option>
						<option value="44" data-iconurl="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/pics/flag_uk.svg"
																	<?php
																	if ( isset( $data['contact2MobileCode'] ) and $data['contact2MobileCode'] == '44' ) {
																																	echo 'selected="true"';
																	}
																	?>
																																>+44</option>
						<option value=""
						<?php
						if ( isset( $data['contact2MobileCode'] ) && $data['contact2MobileCode'] == '' ) {
												echo 'selected="true"';
						}
						?>
											><?php _e( 'Autre', 'crea' ); ?></option>
					</select>
					<input type="tel" name="contact2Mobile"
					<?php
					if ( isset( $data['contact2Mobile'] ) ) {
																echo 'value="' . esc_attr( $data['contact2Mobile'] ) . '"';
					}
					?>
															>
				</div>

			</div>

		</div>

		<button class="accordion" onclick="return false;">III. <?php _e( 'Coordonnées bancaires complètes', 'crea' ); ?></button>
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

		<button class="accordion" onclick="return false;">IV. <?php _e( 'Formations antérieures', 'crea' ); ?></button>
		<div class="panel" start="close">
			<div class="school-1 section">
				<h4><?php esc_html_e( 'Formation 1', 'crea' ); ?></h4>

				<div class="form-control required">
					<label><?php esc_html_e( 'Nom de l\'école', 'crea' ); ?></label>
					<input
						type="text"
						name="school1Name"
						required
						value="<?php echo isset( $data['school1Name'] ) ? esc_attr( $data['school1Name'] ) : ''; ?>"
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
					<label><?php esc_html_e( 'Intitulé du diplôme', 'crea' ); ?></label>
					<input
						type="text"
						name="school1DiplomaName"
						required
						value="<?php echo isset( $data['school1DiplomaName'] ) ? esc_attr( $data['school1DiplomaName'] ) : ''; ?>"
					>
				</div>

				<div class="form-control required">
					<label><?php _e( 'Diplôme obtenu', 'crea' ); ?></label>
					<div class="radio-group">
						<input type="radio" name="school1HasDiploma" value="yes" id="school1DiplomaYes" required <?php echo isset( $data['school1HasDiploma'] ) && $data['school1HasDiploma'] === 'yes' ? 'checked' : ''; ?>>
						<label for="school1DiplomaYes"><?php _e( 'Oui', 'crea' ); ?></label>
					</div>
					<div class="radio-group">
						<input type="radio" name="school1HasDiploma" value="no" id="school1DiplomaNo" required <?php echo empty( $data['school1HasDiploma'] ) || ( isset( $data['school1HasDiploma'] ) && $data['school1HasDiploma'] === 'no' ) ? 'checked' : ''; ?>>
						<label for="school1DiplomaNo"><?php _e( 'Non', 'crea' ); ?></label>
					</div>
					<div class="radio-group">
						<input type="radio" name="school1HasDiploma" value="progress" id="school1DiplomaProgress" required <?php echo isset( $data['school1HasDiploma'] ) && $data['school1HasDiploma'] === 'progress' ? 'checked' : ''; ?>>
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

		<?php
		// Variables
		$formation_id       = get_query_var( 'formation' );
		$session_start      = strtotime( (string) get_field( 'session_start', $formation_id ) );
		$session_end        = strtotime( (string) get_field( 'session_end', $formation_id ) );
		$registration_price = get_field( 'registration_price', $formation_id );
		?>

		<button class="accordion" onclick="return false;">V. <?php _e( 'Inscription', 'crea' ); ?></button>
		<div class="panel text-blue inscription" start="close">
			<p class="text-bold">
				<?php
				echo sprintf(
					esc_html__( 'Je confirme mon inscription ferme (sous réserve d\'acceptation par CREA) au %1$s - session %2$s-%3$s de l’école CREA pour un montant d’écolage total de CHF %4$s.-.', 'crea' ),
					esc_html( ucfirst( $formation_type_name ) ),
					esc_html( date( 'Y', $session_start ) ),
					esc_html( date( 'Y', $session_end ) ),
					number_format( (float) get_field( 'total_price', $formation_id ), 0, ',', '\'' )
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
						<?php echo esc_html( crea_get_date( 'contract_back', true, $formation_id ) ); ?>
					</td>
				</tr>
				<tr>
					<td>
						<span class="table-title"><?php _e( 'Début des cours', 'crea' ); ?></span>
					</td>
					<td>
						<?php echo esc_html( crea_get_date( 'session_start', true, $formation_id ) ); ?>
					</td>
				</tr>
				<tr>
					<td>
						<span class="table-title"><?php _e( 'Fin des cours', 'crea' ); ?></span>
					</td>
					<td>
						<?php echo esc_html( crea_get_date( 'session_end', false, $formation_id ) ); ?>
					</td>
				</tr>
				<tr>
					<td>
						<span class="table-title"><?php _e( 'Travail de Bachelor', 'crea' ); ?></span>
					</td>
					<td>
						<?php echo esc_html( crea_get_date( 'final_work', false, $formation_id ) ); ?>
					</td>
				</tr>
			</table>
		</div>

		<button class="accordion open" onclick="return false;">VI. <?php _e( 'Finance d\'inscription', 'crea' ); ?></button>
		<div class="panel text-blue finance" start="open">
			<p class="text-emphasize"><?php echo sprintf( esc_html__( 'Un montant de CHF %s.- est à verser lors de l’inscription.', 'crea' ), esc_html( $registration_price ) ); ?></p>
			<p><?php _e( 'Ce montant ne sera pas remboursé en cas de désistement ou de non-présentation du candidat à l\'examen d\'entrée. En revanche, si le candidat ou la candidate n\'est pas retenu.e, la finance d\'inscription lui sera restituée.', 'crea' ); ?></p>

			<p><?php _e( 'Le règlement est à effectuer sur le compte suivant', 'crea' ); ?> :</p>
			<p class="text-bold">Crédit Suisse, Genève / IBAN : CH30 0483 5175 2978 1100 1 / Clearing : 4835 / Swift CRESCHZZ80A</p>
		</div>

		<button class="accordion" onclick="return false;">VII. <?php _e( 'Modalités de paiement', 'crea' ); ?></button>
		<div class="panel text-blue modalite" start="close">
			<p><?php echo sprintf( __( 'Je m\'engage à verser le montant de CHF %s.- à CREA selon ce qui suit.', 'crea' ), number_format( (float) get_field( 'total_price', $formation_id ), 0, ',', '\'' ) ); ?></p>
			<p><?php _e( 'Les échéances sont à respecter, même pendant les périodes de stages ou de vacances.', 'crea' ); ?></p>
			<p><?php _e( 'Veuillez cocher la variante choisie', 'crea' ); ?> : </p>
			<fieldset>

				<?php
				if ( have_rows( 'diploma_contract_split_payment', $formation_id ) ) {
					?>
					<?php $splitPayCount = ACF_rows_count( 'diploma_contract_split_payment', $formation_id ); ?>
					<label for="modaliteOption1">
						<input type="radio" id="modaliteOption1" name="modalite" value="1" <?php  ! empty( $data['modalite'] ) ? checked( (int) $data['modalite'], 1 ) : ''; ?>>
						<span class="control">
							<span class="text-bold"><?php echo sprintf( __( 'En %1$s tranches pour un montant total de CHF %2$s.-', 'crea' ), (int) $splitPayCount, number_format( (float) get_field( 'total_price', $formation_id ), 0, ',', '\'' ) ); ?></span>
							<?php
							while ( have_rows( 'diploma_contract_split_payment', $formation_id ) ) {
								the_row();
								?>
								<span class="option__desc"><?php echo sprintf( __( '%1$s : CHF %2$s.- au %3$s', 'crea' ), the_sub_field( 'split_payment_label' ), number_format( get_sub_field( 'split_payment_price' ), 0, ',', '\'' ), get_sub_field( 'split_payment_due_date' ) ); ?></span>
							<?php } ?>
						</span>
					</label>
				<?php } ?>

				<?php
				if ( have_rows( 'tab_head', $formation_id ) and have_rows( 'tab_body', $formation_id ) ) {
					?>
					<label for="modaliteOption2">
						<input type="radio" id="modaliteOption2" name="modalite" value="2" <?php  ! empty( $data['modalite'] ) ? checked( (int) $data['modalite'], 2 ) : ''; ?>>
						<span class="control">
							<span class="text-bold"><?php echo sprintf( __( 'En trimestre selon le calendrier suivant pour un montant total de CHF %s.-', 'crea' ), number_format( (float) get_field( 'total_price', $formation_id ), 0, ',', '\'' ) ); ?></span>
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

				<?php
				if ( have_rows( 'diploma_contract_monthly_payement', $formation_id ) ) {
					$totalPrice = 0;
					$totalMonth = 0;
					while ( have_rows( 'diploma_contract_monthly_payement', $formation_id ) ) {
						the_row();
						$totalPrice += get_sub_field( 'monthly_payement_1st_month' ) + ( get_sub_field( 'monthly_payement_number_months' ) * get_sub_field( 'monthly_payement_month_price' ) );
						if ( get_sub_field( 'monthly_payement_1st_month' ) ) {
							$totalMonth += 1 + get_sub_field( 'monthly_payement_number_months' );
						} else {
							$totalMonth += get_sub_field( 'monthly_payement_number_months' );
						}
					}
					?>
					<label for="modaliteOption3">
						<input type="radio" id="modaliteOption3" name="modalite" value="3" <?php  ! empty( $data['modalite'] ) ? checked( (int) $data['modalite'], 3 ) : ''; ?>>
						<span class="control">
							<span class="text-bold"><?php echo sprintf( __( 'En %1$s mensualités pour un montant total de CHF %2$s.-', 'crea' ), $totalMonth, number_format( $totalPrice, 0, ',', '\'' ) ); ?></span>
							<?php
							while ( have_rows( 'diploma_contract_monthly_payement', $formation_id ) ) {
								the_row();
								?>
								<span>
									<?php the_sub_field( 'monthly_payement_label' ); ?><br>
									<?php if ( get_sub_field( 'monthly_payement_1st_month' ) ) : ?>
										<?php echo sprintf( __( '1ère mensualité de CHF %1$s.- au %2$s', 'crea' ), number_format( get_sub_field( 'monthly_payement_1st_month' ), 0, ',', '\'' ), get_sub_field( 'monthly_payement_1st_due_date' ) ); ?><br>
									<?php endif; ?>
									<?php echo sprintf( __( '%1$s mensualités de CHF %2$s.- du %3$s au %4$s', 'crea' ), get_sub_field( 'monthly_payement_number_months' ), number_format( get_sub_field( 'monthly_payement_month_price' ), 0, ',', '\'' ), get_sub_field( 'monthly_payement_start_date' ), get_sub_field( 'monthly_payement_end_date' ) ); ?><br>
									<?php $totalYearMonth = get_sub_field( 'monthly_payement_1st_month' ) + ( get_sub_field( 'monthly_payement_number_months' ) * get_sub_field( 'monthly_payement_month_price' ) ); ?>
									<?php echo sprintf( __( 'Total : CHF %s.-', 'crea' ), number_format( $totalYearMonth, 0, ',', '\'' ) ); ?>
								</span>
							<?php } ?>
						</span>
					</label>
				<?php } ?>

				<?php
				$custom_payment = get_field( 'custom_payment', $formation_id );

				if ( ! empty( $custom_payment['title'] ) ) {
					?>
					<label for="modaliteOption4">
						<input type="radio" id="modaliteOption4" name="modalite" value="4" <?php  ! empty( $data['modalite'] ) ? checked( (int) $data['modalite'], 4 ) : ''; ?>>
						<span class="control">
							<span class="text-bold"><?php echo esc_html( $custom_payment['title'] ); ?></span>
							<?php if ( ! empty( $custom_payment['body'] ) ) { ?>
								<span>
								<?php
								echo wp_kses(
									wpautop( $custom_payment['body'] ),
									array(
										'strong' => array(),
										'br'     => array(),
										'p'      => array(),
									)
								)
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
				<p class="text-bold"><?php esc_html_e( 'Important : Tout désistement, selon ce qui précède, doit être formellement portée à la connaissance de CREA par lettre recommandée. L’information par courriel n’est pas admise ni valable.', 'crea' ); ?></p>
			</div>
			<div class="clause__wrapper">
				<p class="text-title"><?php _e( 'Retard de paiement', 'crea' ); ?></p>
				<p><?php the_field( 'late_payment', $formation_id ); ?></p>
			</div>

			<div class="clause__wrapper">
				<p class="text-title"><?php _e( 'Situation en cas d\'échec', 'crea' ); ?></p>
				<div class="report__content"><?php echo wp_kses_post( wpautop( get_post_meta( $formation_id, 'contract_clause_echec', true ) ) ); ?></div>
			</div>

			<div class="clause__wrapper">
				<p class="text-title"><?php _e( 'Clause de situation extraordinaire', 'crea' ); ?></p>
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
						<?php esc_html_e( 'En cas d\'échec à l’obtention de la maturité, du baccalauréat ou d\'une équivalence', 'crea' ); ?>
					</p>
					<div class="report__content">
						<p>
							<?php
							echo wp_kses(
								nl2br(
									$diploma_failed_text
								),
								array(
									'br'     => array(),
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

		<button class="accordion" onclick="return false;">IX. <?php echo (int) get_field( 'diploma_markol', 'options' ) === (int) $formation_id ? esc_html__( 'Expérience professionnelle : Stage/Emploi', 'crea' ) : esc_html__( 'Stages', 'crea' ); ?></button>
		<div class="panel text-blue stage" start="close">
			<p><?php the_field( 'internship', $formation_id ); ?></p>
		</div>

		<button class="accordion" onclick="return false;">X. <?php _e( 'Examen d\'entrée', 'crea' ); ?></button>
		<div class="panel text-blue entretien" start="close">
			<?php
			$exam_data = get_field( 'entry_exam', $formation_id );

			if ( ! empty( $exam_data['intro'] ) ) {

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
						wpautop( $exam_data['intro'] )
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

		<button class="accordion" onclick="return false;">XI. <?php _e( 'Délais', 'crea' ); ?></button>

		<?php
		$period = get_field( 'diploma_period', $formation_id );
		?>
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
						<span class="text-bold"><?php echo esc_html( crea_get_date( 'contract_back', true, $formation_id ) ); ?></span>
						<?php echo isset( $period['sendback_contract'] ) ? esc_html( $period['sendback_contract'] ) : ''; ?>
					</td>
					<td>
						<span class="text-bold"><?php the_field( 'entry_exam_date', $formation_id ); ?></span>
						<?php echo isset( $period['exam_place'] ) ? esc_html( $period['exam_place'] ) : ''; ?>
					</td>
				</tr>
			</table>
			<p><?php echo wp_kses_post( $period['disclaimer'] ); ?></p>
		</div>

		<?php
		$final_dispositions = get_field( 'diploma_final_dispositions_form', $formation_id );
		?>
		<button class="accordion" onclick="return false;">XII. <?php _e( 'Dispositions finales', 'crea' ); ?></button>
		<div class="panel text-blue finance" start="close">
			<?php
			echo wp_kses_post(
				wpautop( $final_dispositions )
			);
			?>
		</div>


		<button class="accordion" onclick="return false;">XIII. <?php _e( 'Documents à fournir', 'crea' ); ?></button>
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
		switch ( $formation_type ) {
			case 'bachelor':
				$formation_type_name = __( 'Bachelor', 'crea' );
				$rules               = 'bachelor_rules';
				$where               = $formation_id;
				break;

			case 'certificat':
				$formation_type_name = __( 'Certificat', 'crea' );
				$rules               = 'certificat_rules';
				$where               = $formation_id;
				break;

			case 'master':
				$formation_type_name = __( 'Master', 'crea' );
				$rules               = 'masters_rules';
				$where               = 'options';
				break;

			case 'formation_continue':
				$formation_type_name = __( 'Cycle Certifiant', 'crea' );
				$rules               = 'cc_rules';
				$where               = 'options';
				break;

			case 'brevet_federal':
				$formation_type_name = __( 'Brevet fédéral', 'crea' );
				$rules               = 'brevets_rules';
				$where               = 'options';
				break;
		}
		?>

		<button class="accordion" onclick="return false;">XIV. <?php echo sprintf( esc_html__( 'Règlement d\'admission %s', 'crea' ), $formation_type_name ); ?></button>
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
