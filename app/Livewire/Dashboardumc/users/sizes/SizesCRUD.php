<?php

namespace App\Livewire\Dashboardumc\users\sizes;

use Livewire\Component;
use App\Models\Sizes;

class SizesCRUD extends Component
{
    public $sizes, $name, $description, $size_id;

    public function resetFormbtn()
    {
        $this->reset(['name','description','size_id']);
         $this->dispatch('open-modal', id: 'add_sizes');
    }

    public function resetForm()
    {
        $this->reset(['name'=>'','description'=>'','size_id']);
    }

    public function render()
    {
        $this->sizes = Sizes::latest()->get();
         return view('livewire.Dashboardumc.users.sizes.SizesCRUD');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Sizes::updateOrCreate(
            ['id' => $this->size_id],
            [
                'name' => $this->name,
                'description' => $this->description,
            ]
        );
        $this->name = '';
        $this->description = '';
        $this->size_id = '';
        session()->flash('success','Saved successfully');

        $this->dispatch('close-modal', id: 'add_sizes');

    }

    public function edit($id)
    {
        $this->name = '';
        $this->description = '';
        $size = Sizes::findOrFail($id);
        $this->size_id = $size->id;

        $this->dispatch('open-modal', id: 'add_sizes');
    }

    public function delete($id)
    {
        Sizes::findOrFail($id)->delete();
        session()->flash('success','Deleted successfully');
    }
}
