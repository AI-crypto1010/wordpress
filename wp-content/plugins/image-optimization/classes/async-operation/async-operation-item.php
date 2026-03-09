<?php

namespace ImageOptimization\Classes\Async_Operation;

use DateTime;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Async_Operation_Item {
	private int $id;
	private string $hook;
	private string $status;
	private array $args;
	private string $queue;
	private DateTime $date;
	private array $logs;

	public function get_id(): int {
		return $this->id;
	}

	public function set_id( int $id ): Async_Operation_Item {
		$this->id = $id;
		return $this;
	}

	public function get_hook(): string {
		return $this->hook;
	}

	public function set_hook( string $hook ): Async_Operation_Item {
		$this->hook = $hook;
		return $this;
	}

	public function get_status(): string {
		return $this->status;
	}

	public function set_status( string $status ): Async_Operation_Item {
		$this->status = $status;
		return $this;
	}

	public function get_args(): array {
		return $this->args;
	}

	public function set_args( array $args ): Async_Operation_Item {
		$this->args = $args;
		return $this;
	}

	public function get_date(): DateTime {
		return $this->date;
	}

	public function set_date( DateTime $date ): Async_Operation_Item {
		$this->date = $date;
		return $this;
	}

	public function get_queue(): string {
		return $this->queue;
	}

	public function set_queue( string $queue ): Async_Operation_Item {
		$this->queue = $queue;
		return $this;
	}

	public function get_logs(): array {
		return $this->logs;
	}

	public function set_logs( array $logs ): Async_Operation_Item {
		$this->logs = $logs;
		return $this;
	}
}
