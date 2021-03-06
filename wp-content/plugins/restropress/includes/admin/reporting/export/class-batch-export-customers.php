<?php
/**
 * Batch Customers Export Class
 *
 * This class handles customer export
 *
 * @package     RPRESS
 * @subpackage  Admin/Reports
 * @copyright   Copyright (c) 2018, Magnigenie
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * RPRESS_Batch_Customers_Export Class
 *
 * @since 2.4
 */
class RPRESS_Batch_Customers_Export extends RPRESS_Batch_Export {

	/**
	 * Our export type. Used for export-type specific filters/actions
	 *
	 * @var string
	 * @since 2.4
	 */
	public $export_type = 'customers';

	/**
	 * Set the CSV columns
	 *
	 * @since 2.4
	 * @return array $cols All the columns
	 */
	public function csv_cols() {

		$cols = array(
			'id'        => __( 'ID',   'restropress' ),
			'name'      => __( 'Name',   'restropress' ),
			'email'     => __( 'Email', 'restropress' ),
			'purchases' => __( 'Number of Purchases', 'restropress' ),
			'amount'    => __( 'Customer Value', 'restropress' )
		);

		return $cols;
	}

	/**
	 * Get the Export Data
	 *
	 * @since 2.4
	 *   Database API
	 * @global object $rpress_logs RPRESS Logs Object
	 * @return array $data The data for the CSV file
	 */
	public function get_data() {

		$data = array();

		if ( ! empty( $this->fooditem ) ) {

			// Export customers of a specific product
			global $rpress_logs;

			$args = array(
				'post_parent'    => absint( $this->fooditem ),
				'log_type'       => 'sale',
				'posts_per_page' => 30,
				'paged'          => $this->step
			);

			if( null !== $this->price_id ) {
				$args['meta_query'] = array(
					array(
						'key'   => '_rpress_log_price_id',
						'value' => (int) $this->price_id
					)
				);
			}

			$logs = $rpress_logs->get_connected_logs( $args );

			if ( $logs ) {
				foreach ( $logs as $log ) {

					$payment_id  = get_post_meta( $log->ID, '_rpress_log_payment_id', true );
					$customer_id = rpress_get_payment_customer_id( $payment_id );
					$customer    = new RPRESS_Customer( $customer_id );

					$data[] = array(
						'id'        => $customer->id,
						'name'      => $customer->name,
						'email'     => $customer->email,
						'purchases' => $customer->purchase_count,
						'amount'    => rpress_format_amount( $customer->purchase_value ),
					);
				}
			}

		} else {

			// Export all customers
			$offset    = 30 * ( $this->step - 1 );
			$customers = RPRESS()->customers->get_customers( array( 'number' => 30, 'offset' => $offset ) );

			$i = 0;

			foreach ( $customers as $customer ) {

				$data[$i]['id']        = $customer->id;
				$data[$i]['name']      = $customer->name;
				$data[$i]['email']     = $customer->email;
				$data[$i]['purchases'] = $customer->purchase_count;
				$data[$i]['amount']    = rpress_format_amount( $customer->purchase_value );

				$i++;
			}
		}

		$data = apply_filters( 'rpress_export_get_data', $data );
		$data = apply_filters( 'rpress_export_get_data_' . $this->export_type, $data );

		return $data;
	}

	/**
	 * Return the calculated completion percentage
	 *
	 * @since 2.4
	 * @return int
	 */
	public function get_percentage_complete() {

		$percentage = 0;

		// We can't count the number when getting them for a specific fooditem
		if( empty( $this->fooditem ) ) {

			$total = RPRESS()->customers->count();

			if( $total > 0 ) {

				$percentage = ( ( 30 * $this->step ) / $total ) * 100;

			}

		}

		if( $percentage > 100 ) {
			$percentage = 100;
		}

		return $percentage;
	}

	/**
	 * Set the properties specific to the Customers export
	 *
	 * @since 2.4.2
	 * @param array $request The Form Data passed into the batch processing
	 */
	public function set_properties( $request ) {
		$this->start    = isset( $request['start'] )            ? sanitize_text_field( $request['start'] ) : '';
		$this->end      = isset( $request['end']  )             ? sanitize_text_field( $request['end']  )  : '';
		$this->fooditem = isset( $request['fooditem']         ) ? absint( $request['fooditem']         )   : null;
		$this->price_id = ! empty( $request['rpress_price_option'] ) && 0 !== $request['rpress_price_option'] ? absint( $request['rpress_price_option'] )   : null;
	}
}
