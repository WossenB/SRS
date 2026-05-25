<?php
namespace App\Livewire\Benefit;
use Livewire\Component;
use App\Models\BenefitCatalog;
class BenefitCatalogForm extends Component {
    public $name, $type = 'allowance', $description, $is_taxable = true;
    public function save() {
        $this->validate(['name' => 'required', 'type' => 'required']);
        BenefitCatalog::create([
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'is_taxable' => $this->is_taxable,
        ]);
        return redirect()->route('employees.index');
    }
    public function render() { return view('livewire.benefit.benefit-catalog-form')->layout('layouts.app'); }
}
