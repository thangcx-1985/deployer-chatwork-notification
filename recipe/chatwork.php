<?php

namespace Deployer;

use Deployer\Utility\Httpie;

// Chatwork
set('chatwork_base_url', 'https://api.chatwork.com/v2');

// Project title
set('chatwork_title', function () {
    return get('application', 'Project');
});

// Deploy message
set('chatwork_text', '[info][title]Deployer on {{target}}[/title]{{user}} is deploying branch {{branch}} to {{target}} envirement[/info]');
set('chatwork_success_text', '[info][title]Deployer on {{target}}[/title]Deployment is successful[/info]');
set('chatwork_failure_text', '[info][title]Deployer on {{target}}[/title]Deployment is failed[/info]');
set('chatwork_rollback_text', '[info][title]Deployer on {{target}}[/title]Deployment is rolling back[/info]');

// Task
desc('Notifying Chatwork');
task('chatwork:notify', function () {
    if (!get('chatwork_room_id', false) || !get('chatwork_api_token', false)) {

        return;
    }
    Httpie::post(get('chatwork_base_url') . '/rooms/' . get('chatwork_room_id') . '/messages')
        ->header('X-ChatWorkToken: ' . get('chatwork_api_token'))
        ->form(['body' => get('chatwork_text')])->send();
})
    ->once()
    ->shallow()
    ->setPrivate();

desc('Notifying Chatwork about deploy success');
task('chatwork:notify:success', function () {
    if (!get('chatwork_room_id', false) || !get('chatwork_api_token', false)) {
        return;
    }
    Httpie::post(get('chatwork_base_url') . '/rooms/' . get('chatwork_room_id') . '/messages')
        ->header('X-ChatWorkToken: ' . get('chatwork_api_token'))
        ->form(['body' => get('chatwork_success_text')])->send();
})
    ->once()
    ->shallow()
    ->setPrivate();

desc('Notifying Chatwork about deploy failed');
task('chatwork:notify:failed', function () {
    if (!get('chatwork_room_id', false) || !get('chatwork_api_token', false)) {
        return;
    }
    Httpie::post(get('chatwork_base_url') . '/rooms/' . get('chatwork_room_id') . '/messages')
        ->header('X-ChatWorkToken: ' . get('chatwork_api_token'))
        ->form(['body' => get('chatwork_failure_text')])->send();
})
    ->once()
    ->shallow()
    ->setPrivate();

desc('Notifying Chatwork about deploy roll back');
task('chatwork:notify:rollback', function () {
    if (!get('chatwork_room_id', false) || !get('chatwork_api_token', false)) {
        return;
    }
    Httpie::post(get('chatwork_base_url') . '/rooms/' . get('chatwork_room_id') . '/messages')
        ->header('X-ChatWorkToken: ' . get('chatwork_api_token'))
        ->form(['body' => get('chatwork_rollback_text')])->send();
})
    ->once()
    ->shallow()
    ->setPrivate();
