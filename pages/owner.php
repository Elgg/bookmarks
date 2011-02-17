<?php
/**
 * Elgg bookmarks plugin everyone page
 *
 * @package Bookmarks
 */

$guid = get_input('guid');

elgg_set_page_owner_guid($guid);
$page_owner = elgg_get_page_owner_entity();

elgg_push_breadcrumb($page_owner->name);

$offset = (int)get_input('offset', 0);
$content .= elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'bookmarks',
	'container_guid' => $page_owner->guid,
	'limit' => 10,
	'offset' => $offset,
	'full_view' => false,
	'view_toggle_type' => false
));

if (!$content) {
	$content = elgg_echo('bookmarks:none');
}

$title = elgg_echo('bookmarks:owner', array($page_owner->name));

$filter_context = '';
if ($page_owner->getGUID() == elgg_get_logged_in_user_guid()) {
	$filter_context = 'mine';
}

$body = elgg_view_layout('content', array(
	'filter_context' => $filter_context,
	'content' => $content,
	'title' => $title
));

echo elgg_view_page($title, $body);