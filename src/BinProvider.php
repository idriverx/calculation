<?php

namespace App;

class BinProvider
{
    public function lookupBin($bin)
    {
        return file_get_contents('https://lookup.binlist.net/' . $bin);
    }
}