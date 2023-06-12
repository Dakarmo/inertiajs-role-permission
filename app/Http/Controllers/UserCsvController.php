<?php
 
namespace App\Http\Controllers;
use App\Models\Usercsv;
use App\Safety\DecryptageData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Inertia\Inertia;
use Inertia\Response;
 
use App\Models\User;
 
class UserCsvController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function index(): Response
    {
        $users=Usercsv::paginate(10);
       
          
         foreach ($users as $user) {
            $user->superviseur = DecryptageData::datadecrypt($user->superviseur);
            $user->login = DecryptageData::datadecrypt($user->login);
            $user->prenom = DecryptageData::datadecrypt($user->prenom);
            $user->nom = DecryptageData::datadecrypt($user->nom);
            $user->matricule;
            $user->genre = DecryptageData::datadecrypt($user->genre);
            $user->campagne = DecryptageData::datadecrypt($user->campagne);
            $user->chef_plateau = DecryptageData::datadecrypt($user->chef_plateau);
            $user->email = DecryptageData::datadecrypt($user->email);
            $user->pays = DecryptageData::datadecrypt($user->pays);
        };
        return inertia::render('Csvfile/UserIndex', [
            'users' => $users
        ]);
    }
    
   
    public function create(): Response
    {
        
        return inertia::render('Csvfile/Create', [
            
        ]);
    }



    public function fileImport(Request $request)
    {

        $file = $request->file('file')->store('import');
        $import = new UsersImport;
        $import->import($file);

        if($import->failures()->isNotEmpty()) {
            $failures = $import->failures();
            $failureArray=[];
            foreach($failures as $failure)
            {
                $attribute = $failure->attribute();
                $row = $failure->row();
                $error = $failure->errors()[0];
                $value = $failure->values()['matricule'];

                $failureArray[] = [
                    'attribute' => $attribute,
                    'row' => $row,
                    'error' => $error,
                    'value' => $value,
                ];

                $numErrors=count($failureArray);
            }
            return Inertia::render('Csvfile/Create', [
                // dd($failures),
                'failures' => $failureArray,
                'numErrors' => $numErrors,

            ]);
        }
        return redirect(route('usercsv.index'))->with('message', 'Utilisateurs importés avec succès.' );
    }
 
    
    public function fileExport(Request $request) 
    {

       return Excel::download(new UsersExport, 'users.xlsx');
    
    }
 
    
    public function search(Request $request)
    {
        
     try { $users = Usercsv::paginate(10);
        $correspondances = [];
          
        foreach ($users as $user) {
            foreach ($user as $cle => $valeur) {
                $valeurDecryptee = DecryptageData::datadecrypt($valeur);
                // dd($valeurDecryptee);
                if ($valeurDecryptee == $request->input('valeur')) {
                    $user[$cle] = $valeurDecryptee; // Remplacer la valeur cryptée par la valeur décryptée dans le tableau utilisateur
                    $correspondances[] = $user;
                }
            }
        }
        // dd($correspondances);
    
        if (!empty($correspondances)) {
            $data = [
                'users' => $correspondances,
            ];
            dd($data);
            return response()->json($data, 200);
        } else {
            return response()->json(['message' => 'Aucune correspondance trouvée.'], 200);
        }
    } catch (\Exception $e) {
        dd($e->getMessage()); // Affichez le message d'erreur
    }
    }
    


}