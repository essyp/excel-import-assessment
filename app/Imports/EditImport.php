<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EditImport implements ToCollection, WithHeadingRow, WithValidation,WithColumnFormatting
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        //return an eloquent object
        // return $rows;
       
    }

    public function unique_code($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }


    public function rules(): array
    {
        return [
            '*.phone_number' => 'nullable|numeric:users',
            '*.email' => 'nullable|email|unique:users',

        ];
    }

    public function customValidationMessages()
    {
        return [
            'email.required' => 'email is required.',
            'email.unique' => 'The email has already been taken.',
            'phone_number.numeric' => 'The phone number must be a number.'


        ];
    }

    

    public function columnFormats(): array
    {
        return [
            'phone_number' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }
}