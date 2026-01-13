<?php

namespace App\Livewire;

use Livewire\Component;

class ContactModal extends Component
{
    public $isOpen = false; // يتحكم في إظهار/إخفاء المودال
    public $name = '';
    public $email = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
    ];

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function submit()
    {
        $this->validate();

        // مثال: يمكن الحفظ في قاعدة البيانات
        session()->flash('message', "شكراً يا {$this->name}، سيتم التواصل معك!");

        $this->reset(['name', 'email']);
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.contact-modal');
    }
}
