<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'nisn',
        'nama',
        'kelas',
        'jurusan',
    ];

    public function setKelasAttribute($value): void
    {
        $kelas = trim((string) $value);

        if ($kelas === '') {
            $this->attributes['kelas'] = null;
            return;
        }

        $this->attributes['kelas'] = ctype_digit($kelas)
            ? $this->toRoman((int) $kelas)
            : $kelas;
    }

    private function toRoman(int $number): string
    {
        $map = [
            1000 => 'M',
            900 => 'CM',
            500 => 'D',
            400 => 'CD',
            100 => 'C',
            90 => 'XC',
            50 => 'L',
            40 => 'XL',
            10 => 'X',
            9 => 'IX',
            5 => 'V',
            4 => 'IV',
            1 => 'I',
        ];

        $result = '';

        foreach ($map as $value => $roman) {
            while ($number >= $value) {
                $result .= $roman;
                $number -= $value;
            }
        }

        return $result;
    }
}
