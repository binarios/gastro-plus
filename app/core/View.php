<?php

namespace App\Core;

class View
{
    public function render($view, $data = [])
    {
        $layout = $this->getFileContent(APP . '/views/layout/default.php');
        $viewContent = $this->getFileContent(APP . '/views/' . $view . '.php');
        $viewContent = $this->evaluatePhp($viewContent, $data);
        $content = $this->replaceContentPlaceholder($layout, $viewContent);
        $content = $this->replaceVariables($content, $data);
        echo $content;
    }

    private function getFileContent($filePath)
    {
        return file_get_contents($filePath);
    }

    private function replaceContentPlaceholder($layout, $viewContent)
    {
        return str_replace('{{content}}', $viewContent, $layout);
    }

    private function replaceVariables($content, $data)
    {
        // Replace data variables
        foreach ($data as $key => $value) {
            $content = preg_replace_callback('/{{' . preg_quote($key, '/') . '(\|([^}]+))?}}/', function ($matches) use ($value) {
                return !empty($value) ? $value : (isset($matches[2]) ? $matches[2] : '');
            }, $content);
        }

        // Replace ENV variables
        $content = preg_replace_callback('/{{ENV:([^|}]+)\|?([^}]*)}}/', function ($matches) {
            $envValue = $_ENV[$matches[1]] ?? '';
            return !empty($envValue) ? $envValue : $matches[2];
        }, $content);

        // Replace any remaining placeholders with their default values
        $content = preg_replace_callback('/{{([^|}]+)\|([^}]+)}}/', function ($matches) {
            return $matches[2];
        }, $content);

        return $content;
    }

    private function evaluatePhp($content, $data)
    {
        extract($data);
        ob_start();
        eval('?>' . $content);
        return ob_get_clean();
    }
}


