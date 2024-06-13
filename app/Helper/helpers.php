<?php

function hari_ini($hari)
{

    switch ($hari) {
        case 'Sunday':
            $hari_ini = 'Minggu';
            break;

        case 'Monday':
            $hari_ini = 'Senin';
            break;

        case 'Tuesday':
            $hari_ini = 'Selasa';
            break;

        case 'Wednesday':
            $hari_ini = 'Rabu';
            break;

        case 'Thursday':
            $hari_ini = 'Kamis';
            break;

        case 'Friday':
            $hari_ini = 'Jumat';
            break;

        case 'Saturday':
            $hari_ini = 'Sabtu';
            break;

        default:
            $hari_ini = 'Tidak di ketahui';
            break;
    }

    return $hari_ini;
}

function tanggal_indonesia($tanggal)
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    $pecahkan = explode('-', $tanggal);

    if (count($pecahkan) != 3) {
        return $tanggal; // atau Anda bisa mengembalikan string error atau default value
    }

    return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
}

function bulan_indonesia($tanggal)
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    $pecahkan = explode('-', $tanggal);
    return $bulan[(int) $pecahkan[1]];
}