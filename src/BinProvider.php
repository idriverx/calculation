<?php

namespace App;

class BinProvider
{
    private const BASE_BIN_ENDPOINT = 'https://lookup.binlist.net';

    public function lookupBin(string $bin)
    {
        return file_get_contents(self::BASE_BIN_ENDPOINT . '/' . $bin);
    }
}