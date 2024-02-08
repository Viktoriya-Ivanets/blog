<?php
function extractFields(array $target, array $fields): array
{
	$res = [];

	foreach ($fields as $field) {
		$res[$field] = trim($target[$field]);
	}

	return $res;
}
function checkImageName(string $name): bool
{
	return !!preg_match('/.*\.jpg$/', $name);
}