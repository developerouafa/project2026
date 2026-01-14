<?php
namespace App\Livewire\Dashboardumc\users\sizes;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Size;
use App\Models\Sizes;

class ModalSizes extends Component
{
    public $isOpen = false;
    public $sizeId = null;
    public $name;
    public $description;

    #[On('create-size')]
    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    #[On('edit-size')]
    public function edit($payload)
    {
        $id = $payload['id'];

        $size = Sizes::findOrFail($id);

        $this->sizeId = $id;
        $this->name = $size->name;
        $this->description = $size->description;
        $this->isOpen = true;
    }

    public function save()
    {
        Sizes::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->close();
        $this->dispatch('refresh-sizes');
    }

    public function update()
    {
        Sizes::where('id', $this->sizeId)->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->close();
        $this->dispatch('refresh-sizes');
    }

    public function close()
    {
        $this->isOpen = false;
    }

    private function resetForm()
    {
        $this->reset(['sizeId', 'name', 'description']);
    }

    public function render()
    {
        return view('livewire.Dashboardumc.users.sizes.modalsizes');
    }
}
