<?php

namespace ahmetcelikezer\laravelFlagSystem;

// Classes
use Illuminate\Support\ServiceProvider;

class FlagSystemServiceProvider extends ServiceProvider{

    // Required Provider Functions
    
    public function boot(){
        
        // Define migrations package needs
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        
    }

    public function register(){
        //
    }

}