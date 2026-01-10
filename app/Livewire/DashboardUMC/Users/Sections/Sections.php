<?php

namespace App\Livewire\DashboardUMC\Users\Sections;

use App\Models\Sections as ModelsSections;
use Livewire\Component;

class Sections extends Component
{
    public function render()
    {
        return view('livewire.dashboard-u-m-c.users.sections.sections', [
            'sections' => ModelsSections::latest()->selectsections()->withsections()->parent()->get(),
        ]);
    }
}
