<?php

namespace Example\Helper;

class FileLoader
{
    public static function read(string $filePath) : string
    {
        return file_get_contents($filePath);
    }
}
