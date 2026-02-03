<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inscription;

class UpdateQualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inscriptions = Inscription::whereNotNull('qualification')->get();
        
        foreach ($inscriptions as $inscription) {
            $newQualification = $inscription->qualification / 10;
            
            $inscription->qualification = $newQualification;
            $inscription->save();
        }
        
        $this->command->info('Qualifications updated to 0-10 scale successfully!');
    }
}