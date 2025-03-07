<?php

namespace App\Core;

class Dotenv
{

    /**
     * Load environment variables from a .env file
     *
     * @param string $path The path to the .env file
     * @throws \InvalidArgumentException If the file does not exist or is not readable
     */

    private $path;
    public function __construct()
    {
        $this->path = ROOT . "/.env";
    }

    public function load(): void
    {
        // Check if the file exists and is readable
        if (!file_exists($this->path) || !is_readable($this->path)) {
            throw new \InvalidArgumentException("The file at path {$this->path} does not exist or is not readable.");
        }

        // Read the file into an array of lines, ignoring empty lines
        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line); // Trim whitespace from the line

            // Skip empty lines and comments
            if ($line === '' || $line[0] === '#') {
                continue;
            }

            // Split the line into name and value
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name); // Trim whitespace from the name
            $value = trim($value); // Trim whitespace from the value

            // Set the environment variable if it does not already exist
            if (!array_key_exists($name, $_ENV)) {
                $_ENV[$name] = $value;
            }
        }
    }
}
