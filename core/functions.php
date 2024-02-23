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

function template(string $path, array $vars = []): string
{
    $systemTemplateRendererIntoFullPath = "views/$path.php";
    extract($vars);
    ob_start();
    include($systemTemplateRendererIntoFullPath);
    return ob_get_clean();
}

function make404Error($authInfo)
{
    header('HTTP/1.1 404 Not Found');
    $pageTitle = '404 Not Found';
    $pageContent = template('error/e404');
    $html = template('main', [
        'title' => $pageTitle,
        'content' => $pageContent,
        'authInfo' => $authInfo
    ]);
    echo $html;
}

function make400Error($authInfo)
{
    $pageTitle = '400 Bad Request';
    $pageContent = template('error/e400');
    $html = template('main', [
        'title' => $pageTitle,
        'content' => $pageContent,
        'authInfo' => $authInfo
    ]);
    echo $html;
}
