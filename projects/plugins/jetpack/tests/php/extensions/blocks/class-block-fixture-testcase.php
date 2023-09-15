<?php
/**
 * Jetpack Block Fixture Test Case.
 *
 * @package automattic/jetpack
 */

/**
 * Jetpack Block Fixture Test Case with method for testing against the block's
 * serialized HTML test fixtures, generated by the block's `save` method in JavaScript.
 */
abstract class Jetpack_Block_Fixture_TestCase extends WP_UnitTestCase {
	/**
	 * This test iterates over the block's serialized fixtures, and tests that the generated
	 * markup matches a fixture for the server rendered markup for the block.
	 *
	 * If no server rendered fixture can be found, then one is created.
	 *
	 * @param string $block_name The name used to register the block (e.g. `jetpack/repeat-visitor`).
	 * @param string $block_slug The slug of the directory containing the code for the block (e.g. `repeat-visitor`).
	 * @param string $target_extension The extension for the target markup of the rendered block.
	 */
	public function generate_server_side_rendering_based_on_serialized_fixtures(
		$block_name,
		$block_slug,
		$target_extension = '.server-rendered.html'
	) {
		$fixtures_path = "extensions/blocks/{$block_slug}/test/fixtures/";
		$file_pattern  = '*.serialized.html';
		$files         = glob( JETPACK__PLUGIN_DIR . $fixtures_path . $file_pattern );

		$fail_messages = array();

		foreach ( $files as $file ) {
			$block_markup = trim( file_get_contents( $file ) );

			$parsed_blocks   = parse_blocks( $block_markup );
			$rendered_output = trim( render_block( $parsed_blocks[0] ) );

			$target_markup_filename = str_replace( '.serialized.html', $target_extension, $file );

			// Create a server rendered fixture if one does not exist.
			if ( ! file_exists( $target_markup_filename ) ) {
				file_put_contents( $target_markup_filename, $rendered_output );
				$fail_messages[] =
					sprintf(
						"No server rendered fixture could be found for the %s block's %s fixture\n" .
						"A fixture file has been created in: %s\n",
						$block_name,
						basename( $file ),
						$fixtures_path . basename( $target_markup_filename )
					);
			}

			$server_rendered_fixture = file_get_contents( $target_markup_filename );
			$this->assertEquals(
				$rendered_output,
				trim( $server_rendered_fixture ),
				sprintf(
					'The results of render_block for %s called with serialized markup from %s do not match ' .
					"the server-rendered fixture: %s\n",
					$block_name,
					basename( $file ),
					basename( $target_markup_filename )
				)
			);
		}

		// Fail the test if any fixtures were missing, and report that fixtures have been generated.
		if ( ! empty( $fail_messages ) ) {
			$this->fail(
				implode( "\n", $fail_messages ) .
				"\nTry running this test again. Be sure to commit generated fixture files with any code changes."
			);
		}
	}
}