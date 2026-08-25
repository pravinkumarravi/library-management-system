<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CLI migration runner.
 *
 * Usage:
 *   php index.php migrate           # migrate to the version in config (5)
 *   php index.php migrate version 3 # migrate up/down to a specific version
 */
class Migrate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('migration');

        if ( ! is_cli()) {
            show_error('This controller is only available from the command line.');
        }
    }

    public function index(): void
    {
        $result = $this->migration->current();

        if ($result === FALSE) {
            show_error($this->migration->error_string());
        }

        $version = $this->db->select('version')->get('migrations')->row()->version;
        $this->output->set_output("Migrations complete - schema is at version {$version}.\n");
    }

    public function version(string $target): void
    {
        if ($this->migration->version($target) === FALSE) {
            show_error($this->migration->error_string());
        }

        $this->output->set_output("Schema migrated to version {$target}.\n");
    }
}
