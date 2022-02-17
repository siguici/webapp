<?php
$form = form('GET', '/settings');
if ($form->getInput('action') === 'setLang') {
    if (in_array($from->getInput('lang'), app()->getLangs())) {
        client()->storage()->set('lang', $lang);
        server()->storage()->set('lang', $lang);
    }
}
server()->redirectTo('/');