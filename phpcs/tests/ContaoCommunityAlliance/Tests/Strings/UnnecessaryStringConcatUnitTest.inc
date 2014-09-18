<?php
$x = 'My '.'string';
$x = 'My '.1234;
$x = 'My '.$y.' test';

echo $data['my'.'index'];
echo $data['my'.4];
echo $data['my'.$x];
echo $data[$x.$y.'My'.'String'];

$code = '$actions = array();'."\n";
$code = "$actions = array();"."\n";

// No errors for these because they are needed in some cases.
$code = ' ?'.'>';
$code = '<'.'?php ';

$code = 'lllllllllllllooooooong' .
    'with continuation on the next line.';

$code = 'short' . ' which' . 'is' . 'not' . 'needed';

$code = 'short' .
        ' which is not needed ' . 'here';
?>
