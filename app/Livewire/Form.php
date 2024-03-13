<?php

namespace App\Livewire;

use Livewire\Component;

class Form extends Component
{

    public $title;
    public $description;
    public $price;
    public $category;
    public $category_id;
    public $announcement;



    
    public function rules()
    {
        return [
            'title' => 'required|min:4',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'category_id' =>'required' 
        ];
    }

    protected $messages = [
        'title.required' => 'Il campo Titolo è obbligatorio',
        'title.min' => 'Il campo Titolo deve contenere almeno :min caratteri',
        'description.required' => 'Il campo Descrizione è obbligatorio',
        'description.min' => 'Il campo Descrizione deve contenere almeno :min caratteri',
        'price.required' => 'Il campo Prezzo è obbligatorio',
        'price.numeric' => 'Il campo Prezzo deve essere un numero',
        'category_id.required' => 'La categoria è obbligatoria',
    ];

    public function store()
    {

        $this->validate();

        $category = Category::find($this->category_id)->announcements()->create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'user_id' => Auth::user()->id,
            'category' =>$this->category_id
        ]);

        session()->flash('status', 'Annuncio inserito correttamente');

        $this->cleanForm();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function render()
    {
        return view('livewire.form');
    }
}