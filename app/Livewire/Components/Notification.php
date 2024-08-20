<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Notification extends Component
{
    public $toasts = [];

    public $listeners = [
        'alertSuccess',
        'alertError',
        'alertWarning',
        'alertInfo',
    ];

    public function alertSuccess($args = [])
    {
        $this->addToast('success', $args);
    }

    public function alertError($args = [])
    {
        $this->addToast('error', $args);
    }

    public function alertInfo($args = [])
    {
        $this->addToast('info', $args);
    }

    public function alertWarning($args = [])
    {
        $this->addToast('warning', $args);
    }

    private function addToast($type, $args)
    {
        $id = uniqid();
        array_unshift($this->toasts, [
            'id'      => $id,
            'type'    => $type,
            'title'   => $args['title'] ?? 'Notification',
            'message' => $args['message'] ?? 'Message',
            'show'    => true,
        ]);

        // Automatically remove the toast after 3 seconds
        $this->dispatch('removeToast', ['id' => $id]);
    }

    public function removeToast($id)
    {
        $this->toasts = array_filter($this->toasts, function ($toast) use ($id) {
            return $toast['id'] !== $id;
        });
    }

    public function render()
    {
        return view('livewire.components.notification');
    }
}
