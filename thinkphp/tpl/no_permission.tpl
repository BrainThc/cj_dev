<?php
    if(!function_exists('parse_padding')){
        function parse_padding($source)
        {
            $length  = strlen(strval(count($source['source']) + $source['first']));
            return 40 + ($length - 1) * 8;
        }
    }

    if(!function_exists('parse_class')){
        function parse_class($name)
        {
            $names = explode('\\', $name);
            return '<abbr title="'.$name.'">'.end($names).'</abbr>';
}
}

if(!function_exists('parse_file')){
function parse_file($file, $line)
{
return '<a class="toggle" title="'."{$file} line {$line}".'">'.basename($file)." line {$line}".'</a>';
}
}

if(!function_exists('parse_args')){
function parse_args($args)
{
$result = [];

foreach ($args as $key => $item) {
switch (true) {
case is_object($item):
$value = sprintf('<em>object</em>(%s)', parse_class(get_class($item)));
break;
case is_array($item):
if(count($item) > 3){
$value = sprintf('[%s, ...]', parse_args(array_slice($item, 0, 3)));
} else {
$value = sprintf('[%s]', parse_args($item));
}
break;
case is_string($item):
if(strlen($item) > 20){
$value = sprintf(
'\'<a class="toggle" title="%s">%s...</a>\'',
htmlentities($item),
htmlentities(substr($item, 0, 20))
);
} else {
$value = sprintf("'%s'", htmlentities($item));
}
break;
case is_int($item):
case is_float($item):
$value = $item;
break;
case is_null($item):
$value = '<em>null</em>';
break;
case is_bool($item):
$value = '<em>' . ($item ? 'true' : 'false') . '</em>';
break;
case is_resource($item):
$value = '<em>resource</em>';
break;
default:
$value = htmlentities(str_replace("\n", '', var_export(strval($item), true)));
break;
}

$result[] = is_int($key) ? $value : "'{$key}' => {$value}";
}

return implode(', ', $result);
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>没有权限</title>
    <meta name="robots" content="noindex,nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <style>
        /* Base */
        body {
            color: #333;
            font: 14px Verdana, "Helvetica Neue", helvetica, Arial, 'Microsoft YaHei', sans-serif;
            margin: 0;
            padding: 0 20px 20px;
            word-break: break-word;
        }
        h1{
            margin: 10px 0 0;
            font-size: 28px;
            font-weight: 500;
            line-height: 32px;
        }
        h2{
            color: #4288ce;
            font-weight: 400;
            padding: 6px 0;
            margin: 6px 0 0;
            font-size: 18px;
            border-bottom: 1px solid #eee;
        }
        h3.subheading {
            color: #4288ce;
            margin: 6px 0 0;
            font-weight: 400;
        }
        h3{
            margin: 12px;
            font-size: 16px;
            font-weight: bold;
        }
        abbr{
            cursor: help;
            text-decoration: underline;
            text-decoration-style: dotted;
        }
        a{
            color: #868686;
            cursor: pointer;
        }
        a:hover{
            text-decoration: underline;
        }
        .line-error{
            background: #f8cbcb;
        }

        .echo table {
            width: 100%;
        }

        .echo pre {
            padding: 16px;
            overflow: auto;
            font-size: 85%;
            line-height: 1.45;
            background-color: #f7f7f7;
            border: 0;
            border-radius: 3px;
            font-family: Consolas, "Liberation Mono", Menlo, Courier, monospace;
        }

        .echo pre > pre {
            padding: 0;
            margin: 0;
        }
        /* Layout */
        .col-md-3 {
            width: 25%;
        }
        .col-md-9 {
            width: 75%;
        }
        [class^="col-md-"] {
            float: left;
        }
        .clearfix {
            clear:both;
        }
        @media only screen
        and (min-device-width : 375px)
        and (max-device-width : 667px) {
            .col-md-3,
            .col-md-9 {
                width: 100%;
            }
        }
        /* Copyright Info */
        .copyright{
            padding:10px;
            width:auto;
            position: fixed;
            left: 50%;
            top: 50%;
            z-index: 40;
            -webkit-transform: translateX(-50%) translateY(-50%);
            transform: translateX(-50%) translateY(-50%);
            text-align:center;
            overflow:hidden;
        }
    </style>
</head>
<body>
<div class="copyright">
    You do not have permission
</div>
</body>
</html>
