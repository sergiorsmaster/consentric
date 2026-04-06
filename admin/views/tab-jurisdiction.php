<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current = get_option( 'scc_jurisdiction', 'gdpr' );

$jurisdictions = array(
	'gdpr' => array(
		'label'   => __( 'GDPR — European Union', 'simple-cookie-consent' ),
		'model'   => __( 'Opt-in', 'simple-cookie-consent' ),
		'summary' => __( 'Non-essential cookies are blocked until the visitor explicitly accepts them. Required for websites targeting users in the EU/EEA.', 'simple-cookie-consent' ),
		'details' => array(
			__( 'Banner shown on first visit', 'simple-cookie-consent' ),
			__( 'Cookies blocked until consent is granted', 'simple-cookie-consent' ),
			__( 'Accept All / Deny All / Preferences buttons shown', 'simple-cookie-consent' ),
			__( 'Consent stored for 1 year', 'simple-cookie-consent' ),
		),
	),
	'lgpd' => array(
		'label'   => __( 'LGPD — Brazil', 'simple-cookie-consent' ),
		'model'   => __( 'Opt-in', 'simple-cookie-consent' ),
		'summary' => __( 'Same opt-in model as GDPR. Required for websites targeting users in Brazil.', 'simple-cookie-consent' ),
		'details' => array(
			__( 'Banner shown on first visit', 'simple-cookie-consent' ),
			__( 'Cookies blocked until consent is granted', 'simple-cookie-consent' ),
			__( 'Accept All / Deny All / Preferences buttons shown', 'simple-cookie-consent' ),
			__( 'Consent stored for 1 year', 'simple-cookie-consent' ),
		),
	),
	'ccpa' => array(
		'label'   => __( 'CCPA — United States (California)', 'simple-cookie-consent' ),
		'model'   => __( 'Opt-out', 'simple-cookie-consent' ),
		'summary' => __( 'Cookies are allowed by default. Visitors can opt out of the sale of their personal data. Required for businesses targeting California residents above certain thresholds.', 'simple-cookie-consent' ),
		'details' => array(
			__( 'Banner shown as an informational notice', 'simple-cookie-consent' ),
			__( 'Cookies are NOT blocked before interaction', 'simple-cookie-consent' ),
			__( '"Do Not Sell My Personal Information" opt-out shown', 'simple-cookie-consent' ),
			__( 'Preferences button hidden', 'simple-cookie-consent' ),
		),
	),
);
?>
<div class="scc-tab-content">

	<div class="scc-field scc-field--top">
		<label class="scc-field__label">
			<?php esc_html_e( 'Applicable Law', 'simple-cookie-consent' ); ?>
		</label>
		<div class="scc-field__control">
			<p class="description" style="margin-bottom: 16px;">
				<?php esc_html_e( 'Select the privacy law that applies to your website. This controls whether the banner uses an opt-in or opt-out model.', 'simple-cookie-consent' ); ?>
			</p>

			<div class="scc-jurisdiction-options">
				<?php foreach ( $jurisdictions as $key => $data ) : ?>
					<label class="scc-jurisdiction-card <?php echo $current === $key ? 'is-selected' : ''; ?>">
						<div class="scc-jurisdiction-card__header">
							<input
								type="radio"
								name="scc_jurisdiction"
								value="<?php echo esc_attr( $key ); ?>"
								<?php checked( $current, $key ); ?>
								class="scc-jurisdiction-radio">
							<span class="scc-jurisdiction-card__title">
								<?php echo esc_html( $data['label'] ); ?>
							</span>
							<span class="scc-jurisdiction-card__model scc-model--<?php echo esc_attr( $key ); ?>">
								<?php echo esc_html( $data['model'] ); ?>
							</span>
						</div>
						<p class="scc-jurisdiction-card__summary">
							<?php echo esc_html( $data['summary'] ); ?>
						</p>
						<ul class="scc-jurisdiction-card__details">
							<?php foreach ( $data['details'] as $detail ) : ?>
								<li><?php echo esc_html( $detail ); ?></li>
							<?php endforeach; ?>
						</ul>
					</label>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<hr>

	<!-- CCPA opt-out text — shown for all jurisdictions but most relevant to CCPA -->
	<div class="scc-field scc-ccpa-field" style="<?php echo $current !== 'ccpa' ? 'display:none' : ''; ?>">
		<label class="scc-field__label" for="scc_ccpa_opt_out_text">
			<?php esc_html_e( '"Do Not Sell" Button Label', 'simple-cookie-consent' ); ?>
		</label>
		<div class="scc-field__control">
			<input type="text" id="scc_ccpa_opt_out_text" name="scc_ccpa_opt_out_text" class="regular-text"
				value="<?php echo esc_attr( get_option( 'scc_ccpa_opt_out_text', __( 'Do Not Sell My Personal Information', 'simple-cookie-consent' ) ) ); ?>">
			<p class="description">
				<?php esc_html_e( 'Label for the opt-out button shown in the banner when CCPA mode is active.', 'simple-cookie-consent' ); ?>
			</p>
		</div>
	</div>

</div>
