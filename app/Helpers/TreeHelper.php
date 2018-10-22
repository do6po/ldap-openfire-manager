<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 05.10.18
 * Time: 15:23
 */

namespace App\Helpers;

use PBergman\Console\Helper\TreeHelper as Tree;
use Symfony\Component\Console\Output\StreamOutput;

class TreeHelper
{
    public static function getTree(array $array)
    {
        $tree = new Tree();
        $tree->addArray($array);

        $output = new StreamOutput(fopen('php://memory', 'r+'));
        $tree->printTree($output);

        rewind($output->getStream());

        return stream_get_contents($output->getStream());
    }
}