<?php

namespace Classifai;

use Classifai\Providers\Provider;
use Classifai\Services\Service;
use Classifai\Services\ServicesManager;

/**
 * Miscellaneous Helper functions to access different parts of the
 * ClassifAI plugin.
 */

/**
 * Returns the ClassifAI plugin's singleton instance
 *
 * @return Plugin
 */
function get_plugin() {
	return Plugin::get_instance();
}

/**
 * Returns the ClassifAI plugin's stored settings in the WP options.
 *
 * @param string $service The service to get settings from, defaults to the ServiceManager class.
 *
 * @return array The array of ClassifAi settings.
 */
function get_plugin_settings( $service = '' ) {
	$services = Plugin::$instance->services;
	if ( empty( $services ) || empty( $services['service_manager'] ) || ! $services['service_manager'] instanceof ServicesManager ) {
		return [];
	}

	/** @var ServicesManager $service_manager Instance of the services manager class. */
	$service_manager = $services['service_manager'];
	if ( empty( $service ) ) {
		return $service_manager->get_settings();
	}

	if ( ! isset( $service_manager->service_classes[ $service ] ) || ! $service_manager->service_classes[ $service ] instanceof Service ) {
		return [];
	}

	/** @var Provider $provider An instance or extension of the provider abstract class. */
	$provider = $service_manager->service_classes[ $service ]->provider_classes[0];
	return $provider->get_settings();
}

/**
 * Overwrites the ClassifAI plugin's stored settings. Expected format is,
 *
 * [
 *     'post_types' => [ <list of post type names> ]
 *     'features' => [
 *         <feature_name> => <bool>
 *         <feature_threshold> => <int>
 *     ],
 *     'credentials' => [
 *         'watson_username' => <string>
 *         'watson_password' => <string>
 *     ]
 * ]
 *
 * @param array $settings The settings we're saving.
 */
function set_plugin_settings( $settings ) {
	update_option( 'classifai_settings', $settings );
}

/**
 * Resets the plugin to factory defaults, keeping licensing information only.
 */
function reset_plugin_settings() {

	$options = get_option( 'classifai_settings' );
	if ( $options && isset( $options['registration'] ) ) {
		// This is a legacy option set, so let's update it to the new format.
		$new_settings = [
			'valid_license' => $options['valid_license'],
			'email'         => isset( $options['registration']['email'] ) ? $options['registration']['email'] : '',
			'license_key'   => isset( $options['registration']['license_key'] ) ? $options['registration']['license_key'] : '',
		];
		update_option( 'classifai_settings', $new_settings );
	}

	$services = get_plugin()->services;
	if ( ! isset( $services['service_manager'] ) || ! $services['service_manager']->service_classes ) {
		return;
	}

	$service_classes = $services['service_manager']->service_classes;
	foreach ( $service_classes as $service_class ) {
		if ( ! $service_class instanceof Service || empty( $service_class->provider_classes ) ) {
			continue;
		}

		foreach ( $service_class->provider_classes as $provider_class ) {
			if ( ! $provider_class instanceof Provider || ! method_exists( $provider_class, 'reset_settings' ) ) {
				continue;
			}

			$provider_class->reset_settings();
		}
	}
}


/**
 * Returns the currently configured Watson API URL. Lookup order is,
 *
 * - Options
 * - Constant
 *
 * @return string
 */
function get_watson_api_url() {
	$settings = get_plugin_settings( 'language_processing' );
	$creds    = ! empty( $settings['credentials'] ) ? $settings['credentials'] : [];

	if ( ! empty( $creds['watson_url'] ) ) {
		return $creds['watson_url'];
	} elseif ( defined( 'WATSON_URL' ) ) {
		return WATSON_URL;
	} else {
		return '';
	}
}


/**
 * Returns the currently configured Watson username. Lookup order is,
 *
 * - Options
 * - Constant
 *
 * @return string
 */
function get_watson_username() {
	$settings = get_plugin_settings( 'language_processing' );
	$creds    = ! empty( $settings['credentials'] ) ? $settings['credentials'] : [];

	if ( ! empty( $creds['watson_username'] ) ) {
		return $creds['watson_username'];
	} else if ( defined( 'WATSON_USERNAME' ) ) {
		return WATSON_USERNAME;
	} else {
		return '';
	}
}

/**
 * Returns the currently configured Watson username. Lookup order is,
 *
 * - Options
 * - Constant
 *
 * @return string
 */
function get_watson_password() {
	$settings = get_plugin_settings( 'language_processing' );
	$creds    = ! empty( $settings['credentials'] ) ? $settings['credentials'] : [];

	if ( ! empty( $creds['watson_password'] ) ) {
		return $creds['watson_password'];
	} else if ( defined( 'WATSON_PASSWORD' ) ) {
		return WATSON_PASSWORD;
	} else {
		return '';
	}
}

/**
 * The list of post types that get the ClassifAI taxonomies. Defaults
 * to 'post'.
 *
 * return array
 */
function get_supported_post_types() {
	$classifai_settings = get_plugin_settings( 'language_processing' );

	if ( empty( $classifai_settings ) ) {
		$post_types = [];
	} else {
		$post_types = [];
		foreach ( $classifai_settings['post_types'] as $post_type => $enabled ) {
			if ( ! empty( $enabled ) ) {
				$post_types[] = $post_type;
			}
		}
	}

	if ( empty( $post_types ) ) {
		$post_types = [ 'post' ];
	}

	$post_types = apply_filters( 'classifai_post_types', $post_types );

	return $post_types;
}

/**
 * Returns a bool based on whether the specified feature is enabled
 *
 * @param string $feature category,keyword,entity,concept
 * @return bool
 */
function get_feature_enabled( $feature ) {
	$settings = get_plugin_settings( 'language_processing' );

	if ( ! empty( $settings ) && ! empty( $settings['features'] ) ) {
		if ( ! empty( $settings['features'][ $feature ] ) ) {
			return filter_var(
				$settings['features'][ $feature ],
				FILTER_VALIDATE_BOOLEAN
			);
		}
	}

	return false;
}

/**
 * Returns the feature threshold based on current configuration. Lookup
 * order is.
 *
 * - Option
 * - Constant
 *
 * Any results below the threshold will be ignored.
 *
 * @param string $feature The feature whose threshold to lookup
 * @return int
 */
function get_feature_threshold( $feature ) {
	$settings  = get_plugin_settings( 'language_processing' );
	$threshold = 0;

	if ( ! empty( $settings ) && ! empty( $settings['features'] ) ) {
		if ( ! empty( $settings['features'][ $feature . '_threshold' ] ) ) {
			$threshold = filter_var(
				$settings['features'][ $feature . '_threshold' ],
				FILTER_VALIDATE_INT
			);
		}
	}

	if ( empty( $threshold ) ) {
		$constant = 'WATSON_' . strtoupper( $feature ) . '_THRESHOLD';

		if ( defined( $constant ) ) {
			$threshold = intval( constant( $constant ) );
		}
	}

	$threshold = empty( $threshold ) ? 0.7 : $threshold / 100;
	/**
	 * Filter the threshold for a specific feature. Any results below the
	 * threshold will be ignored.
	 *
	 * @param string $threshold The threshold to use.
	 * @param string $feature   The feature whose threshold to lookup.
	 *
	 * @ return string $threshold The filtered threshold.
	 */
	return apply_filters( 'classifai_feature_threshold', $threshold, $feature );
}

/**
 * Returns the Taxonomy for the specified NLU feature. Returns defaults
 * in config.php if options have not been configured.
 *
 * @param string $feature NLU feature name
 * @return string Taxonomy mapped to the feature
 */
function get_feature_taxonomy( $feature ) {
	$settings = get_plugin_settings( 'language_processing' );
	$taxonomy = 0;

	if ( ! empty( $settings ) && ! empty( $settings['features'] ) ) {
		if ( ! empty( $settings['features'][ $feature . '_taxonomy' ] ) ) {
			$taxonomy = $settings['features'][ $feature . '_taxonomy' ];
		}
	}

	if ( empty( $taxonomy ) ) {
		$constant = 'WATSON_' . strtoupper( $feature ) . '_TAXONOMY';

		if ( defined( $constant ) ) {
			$taxonomy = constant( $constant );
		}
	}

	/**
	 * Filter the Taxonomy for the specified NLU feature.
	 *
	 * @param string $taxonomy The taxonomy to use.
	 * @param string $feature  The NLU feature this taxonomy is for.
	 *
	 * @return string $taxonomy The filtered taxonomy.
	 */
	return apply_filters( 'classifai_taxonomy_for_feature', $taxonomy, $feature );
}

/**
 * Provides the max filesize for the ComputerVision service.
 *
 * @return int
 *
 * @since 1.4.0
 */
function computer_vision_max_filesize() {
	/**
	 * Filters the ComputerVision maximum allowed filesize.
	 *
	 * @param int Default 4MB.
	 */
	return apply_filters( 'classifai_computervision_max_filesize', 4 * MB_IN_BYTES ); // 4MB default.
}

/**
 * Retrieves the URL of the largest version of an attachment image lower than a specified max size..
 *
 * @param string $full_image The path to the full-sized image source file.
 * @param string $full_url   The URL of the full-sized image.
 * @param array  $sizes      Intermediate size data from attachment meta.
 * @param int    $max        The maximum acceptable size.
 * @return string|null The image URL, or null if no acceptable image found.
 *
 * @since 1.4.0
 */
function get_largest_acceptable_image_url( $full_image, $full_url, $sizes, $max = MB_IN_BYTES ) {
	$file_size = @filesize( $full_image ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
	if ( $file_size && $max >= $file_size ) {
		return $full_url;
	}

	// Sort the image sizes in order of total width + height, descending.
	$sort_sizes = function( $size_1, $size_2 ) {
		$size_1_total = $size_1['width'] + $size_1['height'];
		$size_2_total = $size_2['width'] + $size_2['height'];

		if ( $size_1_total === $size_2_total ) {
			return 0;
		}

		return $size_1_total > $size_2_total ? -1 : 1;
	};

	usort( $sizes, $sort_sizes );

	foreach ( $sizes as $size ) {
		$sized_file = str_replace( basename( $full_image ), $size['file'], $full_image );
		$file_size  = @filesize( $sized_file ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged

		if ( $file_size && $max >= $file_size ) {
			return str_replace( basename( $full_url ), $size['file'], $full_url );
		}
	}

	return null;
}
