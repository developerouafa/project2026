<?php

namespace App\Livewire\Dashboardumc\users\sizes;

use Livewire\Component;
use App\Models\Size;
use App\Models\Sizes;

class Testcrud extends Component
{
    public $sizes, $name, $description, $size_id;
    public $isOpen = false;

    public function render()
    {
        $this->sizes = Sizes::latest()->get();
         return view('livewire.Dashboardumc.users.sizes.testcrud');
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->name = '';
        $this->description = '';
        $this->size_id = null;
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

        session()->flash('success','Saved successfully');

        $this->closeModal();
    }

    public function edit($id)
    {
        $size = Sizes::findOrFail($id);

        $this->size_id = $id;
        $this->name = $size->name;
        $this->description = $size->description;

        $this->openModal();
    }

    public function delete($id)
    {
        Sizes::findOrFail($id)->delete();
        session()->flash('success','Deleted successfully');
    }
}
