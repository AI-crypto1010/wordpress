<?php

namespace OCDI;

class PixfortOptionsImporter {
	/**
	 * Import Theme Options data from a JSON file.
	 *
	 * @param array $import_data Array of arrays. Child array contains 'option_name' and 'file_path'.
	 */
	public static function import( $import_data ) {
		$ocdi          = OneClickDemoImport::get_instance();
		$log_file_path = $ocdi->get_log_file_path();

		foreach ( $import_data as $pix_item ) {
			$pix_options_raw_data = Helpers::data_from_file( $pix_item['file_path'] );

			$pix_options_data = json_decode( $pix_options_raw_data, true );

			update_option('pix_options', $pix_options_data);
			$log_added = Helpers::append_to_file(
				sprintf( esc_html__( 'Theme Options import for: %s finished successfully!', 'pixfort-core' ), $pix_item['option_name'] ),
				$log_file_path,
				esc_html__( 'Importing Theme Options' , 'pixfort-core' )
			);
			
		}
	}
}
