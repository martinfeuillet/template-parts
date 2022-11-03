<?php
/**
 * Student identity - Registration form
 *
 * @param array $data
 * @param int $section_number
 * @param int $min_age
 *
 * @package CREA
 */

$data           = ! empty( $args['data'] ) ? $args['data'] : array();
$section_number = ! empty( $args['section_number'] ) ? $args['section_number'] : 0;
$min_age        = ! empty( $args['min_age'] ) ? $args['min_age'] : 18;
?>

<button class="accordion open" onclick="return false;">
	<?php echo esc_html( number_to_roman( $section_number ) ) . ' ' . esc_html__( 'Identité et adresse privée du candidat/de l’étudiant', 'crea' ); ?>
</button>

<div class="panel panel--identity">

	<?php
	$title_select = isset( $data['titleSelect'] ) ? esc_html( $data['titleSelect'] ) : '';
	?>
	<div class="form-control required">
		<label for="titleSelect">
			<?php esc_html_e( 'Titre', 'crea' ); ?>
		</label>
		<select name="titleSelect" id="titleSelect" class="select-title-student" required>
			<option value="0"><?php esc_html_e( 'À sélectionner', 'crea' ); ?></option>
			<option
				value="woman"
				<?php selected( $title_select, 'woman' ); ?>
			>
				<?php esc_html_e( 'Madame', 'crea' ); ?>
			</option>
			<option
				value="man"
				<?php selected( $title_select, 'man' ); ?>
			>
				<?php esc_html_e( 'Monsieur', 'crea' ); ?>
			</option>
		</select>
	</div>

	<div class="form-control"></div>

	<div class="form-control required">
		<label for="surname"><?php esc_html_e( 'Nom', 'crea' ); ?></label>
		<input
			type="text"
			name="studentSurname"
			id="surname"
			required
			value="<?php echo isset( $data['studentSurname'] ) ? esc_html( $data['studentSurname'] ) : ''; ?>"
		>
	</div>

	<div class="form-control required">
		<label for="name"><?php esc_html_e( 'Prénom', 'crea' ); ?></label>
		<input
			type="text"
			name="studentName"
			id="name"
			required
			value="<?php echo isset( $data['studentName'] ) ? esc_html( $data['studentName'] ) : ''; ?>"
		>
	</div>

	<div class="form-control required">
		<label for="birthday">
			<?php esc_html_e( 'Date de naissance', 'crea' ); ?>
			<span><?php esc_html_e( '(maximum 30 ans)', 'crea' ); ?></span>
		</label>
		<input
			type="text"
			name="studentBirthday"
			id="birthday"
			data-max-age="30"
			data-min-age="<?php echo (int) $min_age; ?>"
			placeholder="<?php esc_html_e( 'jj-mm-aaaa', 'crea' ); ?>"
			required
			value="<?php echo isset( $data['studentBirthday'] ) ? esc_html( $data['studentBirthday'] ) : ''; ?>"
		>
	</div>

	<?php
	$student_civil_state = isset( $data['studentCivilState'] ) ? esc_html( $data['studentCivilState'] ) : '';
	?>
	<div class="form-control required">
		<label for="studentCivilState"><?php esc_html_e( 'État civil', 'crea' ); ?></label>
		<select name="studentCivilState" id="studentCivilState" class="select-title">
			<option value=""><?php esc_html_e( 'À sélectionner', 'crea' ); ?></option>
			<option
				value="<?php esc_attr_e( 'Célibataire', 'crea' ); ?>"
				<?php selected( $student_civil_state, esc_attr__( 'Célibataire', 'crea' ) ); ?>
			>
				<?php esc_html_e( 'Célibataire', 'crea' ); ?>
			</option>
			<option
				value="<?php esc_attr_e( 'Marié(e)', 'crea' ); ?>"
				<?php selected( $student_civil_state, esc_attr__( 'Marié(e)', 'crea' ) ); ?>
			>
				<?php esc_html_e( 'Marié(e)', 'crea' ); ?>
			</option>
			<option
				value="<?php esc_attr_e( 'Divorcé(e)', 'crea' ); ?>"
				<?php selected( $student_civil_state, esc_attr__( 'Divorcé(e)', 'crea' ) ); ?>
			>
				<?php esc_html_e( 'Divorcé(e)', 'crea' ); ?>
			</option>
			<option
				value="<?php esc_attr_e( 'Veuf(ve)', 'crea' ); ?>"
				<?php selected( $student_civil_state, esc_attr__( 'Veuf(ve)', 'crea' ) ); ?>
			>
				<?php esc_html_e( 'Veuf(ve)', 'crea' ); ?>
			</option>
			<option
				value="<?php esc_attr_e( 'Partenariat enregistré / Pacse', 'crea' ); ?>"
				<?php selected( $student_civil_state, esc_attr__( 'Partenariat enregistré / Pacse', 'crea' ) ); ?>
			>
				<?php esc_html_e( 'Partenariat enregistré / Pacse', 'crea' ); ?>
			</option>
		</select>
	</div>

	<?php
	$nationalities = get_nationalities();
	?>
	<div class="form-control required">
		<label for="studentNationality"><?php esc_html_e( 'Nationalité', 'crea' ); ?></label>
		<select name="studentNationality" id="studentNationality" class="select-title">
			<option value=""><?php esc_html_e( 'À sélectionner', 'crea' ); ?></option>
			<?php
			foreach ( $nationalities as $nationalite ) {
				?>
				<option
					value="<?php echo esc_attr( $nationalite ); ?>"
					<?php isset( $data['studentNationality'] ) ? selected( esc_html( $data['studentNationality'] ), $nationalite ) : ''; ?>
				>
					<?php echo esc_html( $nationalite ); ?>
				</option>
				<?php
			}
			?>
		</select>
	</div>

	<div class="form-control required">
		<label for="origin"><?php esc_html_e( 'Lieu d\'origine (lieu de naissance)', 'crea' ); ?></label>
		<input
			type="text"
			name="studentOrigin"
			id="origin"
			required
			value="<?php echo isset( $data['studentOrigin'] ) ? esc_attr( $data['studentOrigin'] ) : ''; ?>"
		>
	</div>

	<div class="form-control required form--address">
		<label for="studentAddress"><?php esc_html_e( 'Adresse', 'crea' ); ?></label>
		<input
			type="text"
			name="studentAddress"
			id="studentAddress"
			placeholder="<?php esc_html_e( 'Indiquez un lieu', 'crea' ); ?>"
			onkeypress="return enterDisabled(event)"
			required
			value="<?php echo isset( $data['studentAddress'] ) ? esc_attr( $data['studentAddress'] ) : ''; ?>"
		>
	</div>

	<div class="form-control required form--nb">
		<label for="studentAddressNb"><?php esc_html_e( 'Numéro', 'crea' ); ?></label>
		<input
			type="text"
			name="studentAddressNb"
			id="studentAddressNb"
			required
			value="<?php echo isset( $data['studentAddressNb'] ) ? esc_attr( $data['studentAddressNb'] ) : ''; ?>"
		>
	</div>

	<div class="form-control required">
		<label for="studentCity"><?php esc_html_e( 'NPA et ville', 'crea' ); ?></label>
		<input
			type="text"
			name="studentCity"
			id="studentCity"
			required
			value="<?php echo isset( $data['studentCity'] ) ? esc_attr( $data['studentCity'] ) : ''; ?>"
		>
	</div>

	<div class="form-control required" visible-in="CH">
		<label for="studentCanton"><?php esc_html_e( 'Canton', 'crea' ); ?></label>
		<input
			type="text"
			name="studentCanton"
			id="studentCanton"
			required
			value="<?php echo isset( $data['studentCanton'] ) ? esc_attr( $data['studentCanton'] ) : ''; ?>"
		>
	</div>

	<div class="form-control required" visible-in="FR">
		<label for="studentDepartment"><?php esc_html_e( 'Département', 'crea' ); ?></label>
		<input
			type="text"
			name="studentDepartment"
			id="studentDepartment"
			required
			value="<?php echo isset( $data['studentDepartment'] ) ? esc_attr( $data['studentDepartment'] ) : ''; ?>"
		>
	</div>

	<?php
	$countries_obj = new WC_Countries();
	$countries     = $countries_obj->__get( 'countries' );
	?>
	<div class="form-control required country">
		<label for="studentCountry"><?php esc_html_e( 'Pays', 'crea' ); ?></label>
		<select name="studentCountry" id="studentCountry" required class="select-country">
			<option value="0"><?php esc_html_e( 'À sélectionner', 'crea' ); ?></option>
			<?php
			foreach ( $countries as $key => $value ) {

				// Set default value if in data array or if key is CH.
				$is_selected = false;
				if (
					( isset( $data['studentCountry'] ) && esc_html( $data['studentCountry'] ) === $value ) ||
					( ! isset( $data['studentCountry'] ) && 'CH' === $key )
				) {
					$is_selected = true;
				}
				?>
				<option
					value="<?php echo esc_attr( $value ); ?>"
					iso="<?php echo esc_attr( $key ); ?>"
					<?php selected( $is_selected, true ); ?>
				>
					<?php echo esc_html( $value ); ?>
				</option>
				<?php
			}
			?>
		</select>
	</div>

	<div class="form-control required">
		<label for="studentMail"><?php esc_html_e( 'Mail', 'crea' ); ?></label>
		<input
			type="email"
			name="studentMail"
			id="studentMail"
			required
			value="<?php echo isset( $data['studentMail'] ) ? esc_attr( $data['studentMail'] ) : ''; ?>"
		>
	</div>

	<?php
	$student_mobile_code = isset( $data['studentMobileCode'] ) ? esc_html( $data['studentMobileCode'] ) : '41';
	?>
	<div class="form-control required">
		<label><?php esc_html_e( 'Mobile', 'crea' ); ?></label>
		<select name="studentMobileCode" class="country_code_phone">
			<option
				value="41"
				data-iconurl="<?php echo esc_url( get_template_directory_uri() . '/assets/pics/flag_switzerland.svg' ); ?>"
				<?php selected( $student_mobile_code, '41' ); ?>
			>
				+41
			</option>
			<option
				value="33"
				data-iconurl="<?php echo esc_url( get_template_directory_uri() . '/assets/pics/flag_france.svg' ); ?>"
				<?php selected( $student_mobile_code, '33' ); ?>
			>
				+33
			</option>
			<option
				value="32"
				data-iconurl="<?php echo esc_url( get_template_directory_uri() . '/assets/pics/flag_belgium.svg' ); ?>"
				<?php selected( $student_mobile_code, '32' ); ?>
			>
				+32
			</option>
			<option
				value="39"
				data-iconurl="<?php echo esc_url( get_template_directory_uri() . '/assets/pics/flag_italy.svg' ); ?>"
				<?php selected( $student_mobile_code, '39' ); ?>
			>
				+39
			</option>
			<option
				value="44"
				data-iconurl="<?php echo esc_url( get_template_directory_uri() . '/assets/pics/flag_uk.svg' ); ?>"
				<?php selected( $student_mobile_code, '44' ); ?>
			>
				+44
			</option>
			<option
				value=""
				<?php selected( $student_mobile_code, '' ); ?>
			>
				<?php esc_html_e( 'Autre', 'crea' ); ?>
			</option>
		</select>
		<input
			type="tel"
			name="studentMobile"
			required
			value="<?php echo isset( $data['studentMobile'] ) ? esc_attr( $data['studentMobile'] ) : ''; ?>"
		>
	</div>

	<div class="form-control" required-in="CH">
		<label for="studentAVS"><?php esc_html_e( 'Numéro AVS (si domicilié.e en Suisse seulement)', 'crea' ); ?></label>
		<input
			type="text"
			name="studentAVS"
			id="studentAVS"
			value="<?php echo isset( $data['studentAVS'] ) ? esc_attr( $data['studentAVS'] ) : ''; ?>"
		>
	</div>
</div>
