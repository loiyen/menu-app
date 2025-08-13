<?php

use Carbon\Carbon;

function tanggal_indo($tanggal, $format = 'd F Y')
{
    if (!$tanggal) return '-';

    \Carbon\Carbon::setLocale('id');
    return \Carbon\Carbon::parse($tanggal)->translatedFormat($format);
}

function format_jam($tanggal, $format = 'H:i')
{
    if (!$tanggal) return '-';

    return \Carbon\Carbon::parse($tanggal)->translatedFormat($format);
}

