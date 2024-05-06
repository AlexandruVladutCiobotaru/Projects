<?php

namespace App\Livewire;

use App\Jobs\GoogleVisionLabelImage;
use App\Jobs\GoogleVisionSafeSearch;
use App\Jobs\RemoveFaces;
use App\Jobs\ResizeImage;
use App\Models\Announcement;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Contracts\Service\Attribute\Required;

class CreateAnnouncement extends Component
{
    use WithFileUploads;
    
    public $title;
    public $description;
    public $price;
    public $category;
    public $category_id;
    public $announcement;
    public $images = [];
    public $image = [];
    public $temporary_images;
    
    public function rules()
    {
        return [
            'title' => 'required|min:4',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'category_id' =>'required',
            'images.*'=>'image|max:1024',
            'temporary_images.*'=>'image|max:1024',
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
        'temporary_images.required' => 'L\'immagine è obbligatoria',
        'temporary_images.*.image' => 'I file caricati devono essere immagini',
        'temporary_images.*.max' => 'L\'immagine deve essere massimo di 1 mb',
        'images.image' => 'Il file deve essere un\'immagine',
        'images.max' => 'L\'immagine deve essere massimo di 1 mb',
    ];
    
    public function updatedTemporaryImages()
    {
        if($this->validate([
            'temporary_images.*'=>'image|max:1024',
            ])) {
                foreach ($this->temporary_images as $image) {
                    $this->images[] = $image;
                }
            }
        }
        
        public function removeImage($key)
        {
            if(in_array($key, array_keys($this->images))) {
                unset($this->images[$key]);
            }
        }
        
        public function store()
        {
            
            $this->validate();
            
            $this->announcement = Category::find($this->category_id)->announcements()->create([
                
                'title' => $this->title,
                'description' => $this->description,
                'price' => $this->price,
                'user_id' => Auth::user()->id,
                'category' => $this->category_id,
                'temporary_images' =>$this->temporary_images,
                'images.*' =>$this->images,
                
                
            ]);
            
            
            if(count($this->images)){
                foreach ($this->images as $image) {
                    // $this->announcement->images()->create(['path' => $image->store('images', 'public')]);
                    $newFileName = "announcements/{$this->announcement->id}";
                    $newImage = $this->announcement->images()->create(['path'=>$image->store($newFileName, 'public')]);

                    RemoveFaces::withChain([
                    (new ResizeImage($newImage->path, 100 , 100)),
                    (new ResizeImage($newImage->path, 200 , 200)),
                    (new ResizeImage($newImage->path, 300 , 300)),
                    (new ResizeImage($newImage->path, 400 , 400)),
                    (new ResizeImage($newImage->path, 500 , 500)),
                    (new ResizeImage($newImage->path, 600 , 600)),
                    
                    ])->dispatch($newImage->id);

                    
                }

                File::deleteDirectory(storage_path('/app/livewire-tmp'));
                
            }
            
            
            session()->flash('status', 'Annuncio inserito correttamente, sarà pubblicato dopo la revisione');
            
            $this->cleanForm();
        }
        
        public function updated($propertyName)
        {
            $this->validateOnly($propertyName);
        }
        
        public function cleanForm()
        {
            $this->title = '';
            $this->description = '';
            $this->price = '';
            $this->images = '';
            $this->images = [];
            $this->temporary_images = [];
        }
        
        public function render()
        {
            return view('livewire.create-announcement');
        }
    }
    