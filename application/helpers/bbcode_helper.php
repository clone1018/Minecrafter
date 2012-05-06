<?php

function BBCode ($string) {
    $search = array(
        '\[b\](.*?)\[\/b\]\',
        '\[i\](.*?)\[\/i\]\',
        '\[u\](.*?)\[\/u\]\',
        '\[img\](.*?)\[\/img\]\',
        '\[url\=(.*?)\](.*?)\[\/url\]\',
        '\[code\](.*?)\[\/code\]\'
    );
    $replace = array(
        '<b>\\1</b>',
        '<i>\\1</i>',
        '<u>\\1</u>',
        '<img src="\\1">',
        '<a href="\\1">\\2</a>',
        '<code>\\1</code>'
    );
    return preg_replace($search, $replace, $string);
}
