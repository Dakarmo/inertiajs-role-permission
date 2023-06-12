<?php

namespace App\Imports;

use App\Models\Usercsv;
use App\Safety\CryptageData;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class UsersImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // return new Usercsv([
        //     'superviseur'   => $row['superviseur'],
        //     'login'         => $row['login'],
        //     'prenom'        => $row['prenom'],
        //     'nom'           => $row['nom'],
        //     'matricule'     => $row['matricule'],
        //     'genre'         => $row['genre'],
        //     'campagne'      => $row['campagne'],
        //     'chef_plateau'   => $row['chef_plateau'],
        //     'email'         => $row['email'],
        //     'password'      => hash::make($row['password']),
        //     'pays'          => $row['pays'],
        // ]);

             // Crypter chaque champ avant l'injection dans la base de données
        $encryptedData = $this->encryptData($row);

        return new Usercsv($encryptedData);

    }

    private function encryptData($row)
    {
        // Implémentez votre logique de cryptage pour chaque champ du fichier CSV
        // par exemple, vous pouvez utiliser la fonction `encrypt` de Laravel

        $encryptedData = [];
        
        $encryptedData ['superviseur']   = CryptageData::datacrypt($row['superviseur']);
        $encryptedData ['login']   = CryptageData::datacrypt($row['login']);
        $encryptedData ['prenom']   = CryptageData::datacrypt($row['prenom']);
        $encryptedData ['nom']   = CryptageData::datacrypt($row['nom']);
        $encryptedData ['matricule']   = $row['matricule'];
        $encryptedData ['genre']   = CryptageData::datacrypt($row['genre']);
        $encryptedData ['campagne']   = CryptageData::datacrypt($row['campagne']);
        $encryptedData ['chef_plateau']   = CryptageData::datacrypt($row['chef_plateau']);
        $encryptedData ['chef_plateau']   = CryptageData::datacrypt($row['chef_plateau']);
        $encryptedData ['email']   = CryptageData::datacrypt($row['email']);
        $encryptedData ['password']   = CryptageData::datacrypt($row['password']);
        $encryptedData ['pays']   = CryptageData::datacrypt($row['pays']);
        

        return $encryptedData;
    }

    // public function onError(\Throwable $error)
    // {

    // }

    public function rules(): array
    {
        return [
            '*.matricule' =>['required', 'string', 'unique:usercsvs,matricule'],
            // '*.login' => ['login', 'unique:users,login']
        ];
    }

    //   public function onFailure(Failure ...$failure)
    // {

    // }
}
