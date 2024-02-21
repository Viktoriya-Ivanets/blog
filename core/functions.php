<?php
function extractFields(array $target, array $fields): array
{
    $res = [];

    foreach ($fields as $field) {
        if (isset($target[$field])) {
            $res[$field] = trim(htmlspecialchars($target[$field]));
        } else {
            $res[$field] = '';
        }
    }

    return $res;
}

$fields = extractFields($_POST, ['login', 'password', 'remember']);

function checkImageName(string $name): bool
{
	return !!preg_match('/.*\.jpg$/', $name);
}

function template(string $path, array $vars = []) : string{
    $systemTemplateRendererIntoFullPath = "views/$path.php"; 
    extract($vars);
    ob_start();
    include($systemTemplateRendererIntoFullPath);
    return ob_get_clean();
}