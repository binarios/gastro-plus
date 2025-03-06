<?php

namespace App\Core;

class View
{
    public function render($view, $data = [])
    {
        $layout = $this->getFileContent(APP . '/views/layout/default.php');
        $viewContent = $this->getFileContent(APP . '/views/' . $view . '.php');
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
        foreach ($data as $key => $value) {
            $content = preg_replace_callback('/{{' . preg_quote($key, '/') . '(\|([^}]+))?}}/', function ($matches) use ($value) {
            return !empty($value) ? $value : (isset($matches[2]) ? $matches[2] : '');
            }, $content);
        }
        // Replace any remaining placeholders with their default values
        $content = preg_replace_callback('/{{([^|}]+)\|([^}]+)}}/', function ($matches) {
            return $matches[2];
        }, $content);
        return $content;
    }
}
