<?php
namespace App\Livewire\Benefit;
use Livewire\Component;
use App\Models\BenefitCatalog;
class BenefitCatalogList extends Component {
    public function render() {
        return view('livewire.benefit.benefit-catalog-list', ['catalogs' => BenefitCatalog::all()])->layout('layouts.app');
    }
}
