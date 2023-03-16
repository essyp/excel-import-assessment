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

class DataImport implements ToCollection, WithHeadingRow, WithValidation,WithColumnFormatting
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
        $batch_id = $this->unique_code(10);
        
        foreach ($rows as $row) {
            Log::debug($row);            
            $customer = User::create([
                'batch_id' => $batch_id,
                'ref_id' => 'RF-'.$this->unique_code(6),
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'phone_number' => $row['phone_number'],
                'email' => $row['email'],
                'address' => $row['address'],
                'city' => $row['city'],
                'state' => $row['state'],
                'country' => $row['country'],
                'gender' => $row['gender'],
                'marital_status' => $row['marital_status'],
                'confirmed' => 1,
            ]);
        }
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