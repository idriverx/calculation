<?php

namespace App;

class BinProvider
{
    public function lookupBin(string $bin)
    {
        return file_get_contents('https://lookup.binlist.net/' . $bin);
    }
}