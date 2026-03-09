<?php

namespace ImageOptimization\Classes\Async_Operation\Queries;

use ImageOptimization\Classes\Async_Operation\Async_Operation_Hook;
use ImageOptimization\Classes\Async_Operation\Async_Operation_Queue;
use ImageOptimization\Classes\Async_Operation\Interfaces\Operation_Query_Interface;
use TypeError;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Operation_Query implements Operation_Query_Interface {
	private array $query;

	public function set_hook( string $hook ): self {
		if ( ! in_array( $hook, Async_Operation_Hook::get_values(), true ) ) {
			throw new TypeError( esc_html( "Hook $hook is not a part of Async_Operation_Hook values" ) );
		}

		$this->query['hook'] = $hook;

		return $this;
	}

	public function set_queue( string $queue ): self {
		if ( ! in_array( $queue, Async_Operation_Queue::get_values(), true ) ) {
			throw new TypeError( esc_html( "Queue $queue is not a part of Async_Operation_Queue values" ) );
		}

		$this->query['group'] = $queue;

		return $this;
	}

	/**
	 * @param string|array $status
	 * @return $this
	 */
	public function set_status( $status ): self {
		$this->query['status'] = $status;

		return $this;
	}

	public function set_image_id( int $image_id ): self {
		$this->query['args']['attachment_id'] = $image_id;

		return $this;
	}

	public function set_limit( int $limit ): self {
		$this->query['per_page'] = $limit;

		return $this;
	}

	public function get_return_type(): string {
		return $this->query['_return_type'];
	}

	public function return_ids(): self {
		$this->query['_return_type'] = 'ids';

		return $this;
	}

	public function get_query(): array {
		$clone = $this->query;

		if ( empty( $clone['args'] ) ) {
			unset( $clone['args'] );
		}

		return $clone;
	}

	public function __construct() {
		$this->query = [
			'args' => [],
			'per_page' => 10,
			'orderby' => 'date',
			'order' => 'DESC',
			'_return_type' => 'object',
		];
	}
}
