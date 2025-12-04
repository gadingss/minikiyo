<?php

namespace App\Livewire;

use Livewire\Component;

class MenuList extends Component
{
    public $search = '';
    public $category = 'all';
    public $menuData;
    

    public function mount($menuData)
    {
        $this->menuData = collect($menuData)->toArray();
    }

    public function addToCart($id)
    {
        $this->dispatch('addToCartFromMenu', id: $id);
    }


    public function setCategory($category)
    {
        $this->category = $category;
    }


    public function render()
    {
        $menus = collect($this->menuData);

        // 1️⃣ Filter search DULU
        if (!empty($this->search)) {
            $search = strtolower($this->search);

            $menus = $menus
                ->map(function ($items) use ($search) {
                    return collect($items)->filter(function ($item) use ($search) {
                        return str_contains(
                            strtolower($item['name']),
                            $search
                        );
                    });
                })
                ->filter(fn($items) => $items->isNotEmpty());
        }

        // 2️⃣ Filter kategori SETELAH search
        if ($this->category !== 'all') {
            $menus = collect([
                $this->category => $menus[$this->category] ?? []
            ]);
        }

        return view('livewire.menu-list', [
            'menus' => $menus,
        ]);
    }







}

