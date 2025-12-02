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


    public function setCategory($cat)
    {
        $this->category = $cat;
    }

    public function render()
    {
        $menus = collect($this->menuData);

        if ($this->category !== 'all') {
            $menus = collect([$this->category => $menus[$this->category]]);
        }

        $menus = $menus
            ->map(function ($items) {
                return collect($items)->filter(function ($item) {
                    return str_contains(
                        strtolower($item['name']),
                        strtolower($this->search)
                    );
                });
            })
            ->filter(function ($items) {
                return $items->isNotEmpty(); // HAPUS KATEGORI YANG KOSONG
            });

        return view('livewire.menu-list', [
            'menus' => $menus,
        ]);
    }

}

