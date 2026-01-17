<?php

namespace App\Livewire\Dashboardumc\users\sizes;

use Livewire\Component;
use App\Models\Sizes;

class Testcrud extends Component
{
    public $sizes, $name, $description, $size_id;

    public function resetFormbtn()
    {
        $this->reset(['name','description','size_id']);
         $this->dispatch('open-modal', id: 'add_sizes');
    }

    public function resetForm()
    {
        $this->reset(['name','description','size_id']);
        //  $this->dispatch('open-modal', id: 'add_sizes');
    }

    public function render()
    {
        $this->sizes = Sizes::latest()->get();
         return view('livewire.Dashboardumc.users.sizes.testcrud');
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

        $this->resetForm();
        //  $this->dispatch('$refresh');     // 🔄 يعاود يجيب list
        session()->flash('success','Saved successfully');

        $this->dispatch('close-modal', id: 'add_sizes');

    }

    public function edit($id)
    {
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
