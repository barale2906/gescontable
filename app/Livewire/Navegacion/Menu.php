<?php

namespace App\Livewire\Navegacion;

use Livewire\Component;
use App\Models\Layout\Menu as MenuModel;

class Menu extends Component
{
    private function menus(){
        return MenuModel::where('status',true)
                    ->get();
    }

    public function render()
    {
        return view('livewire.navegacion.menu',[
            'menus'=>$this->menus(),
        ]);
    }
}
