<?php
/*
 *  Author  : Ahmet Celikezer
 *  GitHub  : https://github.com/ahmetcelikezer/laravel-flag-system
 *  License : MIT
 *  This package allows you to easily assign flags for any data on your any table on your database. Of course, you can manage or check them.
 *  Version : 0.0.1 Alpha
 */

 namespace ahmetcelikezer\laravelFlagSystem\classes;

 # Required Classes
 use Illuminate\Support\Facades\DB;
 use Illuminate\Support\Facades\Schema;


 class FlagSystem{

    private static $flagsTable = 'flags';   // Default flags table

    public $title;                          // Title for/of target flag
    public $id;                             // Id of target flag
    public $target;                         // Target table for the data
    public $flag;                           // Flag id or title to set target data

    public $errors = array();               // If any exception is occurs, this array fill with those
    private static $exceptions = array(     // Exception's with their keys and messages
        'none'          => 'Unknown error occured, please report this exception on Github: ahmetcelikezer/laravel-flag-system',
        'exists'        => 'Flag is already exists!',
        'maxlength'     => 'Max flag title length is 50!',
        'onlynumbers'   => 'Flag must contain 1 letter at least!',
        'dbsaveunknown' => 'Unknown error occured while flag saving to database !?',
        'dbTableMissing'=> 'laravel-flag-system\'s table missing! Please run "php artisan migrate" first!',
        'flagnotfound'  => 'Flag not found!',
    );

    # Temporary Properties
    private $_tmpSearchFlag = [];




    # Constructor & Destructor

    public function __construct(){
        
        // Check if package has its own data table
       return Schema::hasTable(self::$flagsTable) ?  : $this->throwException('dbTableMissing');
    }

    public function __destruct(){
        
        // Clear Cache
        unset(
            $this->_tmpSearchFlag
        );
        
    }

    ###

    # Flag Controllers

    /** 
     * Check is flag registered to the database or not.
     * @param integer $flagID
     * @return boolean
     */
    private function isFlagExists($flagID){

       return DB::table(self::$flagsTable)->where('id', $flagID)->count() > 0 ? true : false;
    }


    ////


    /**
     * Returns all flags on the system.
     * @return array
     */
    public function listFlags(){

        return json_decode(DB::table(self::$flagsTable)->get(), true);
    }


    ////


    /**
     * Creates new flag
     * @param string $this->title [Max Length 50]
     * @return boolean
     */
    public function createFlag(){

        // Check is flag is already exists first
        if($this->searchFlag()){

            return $this->throwException('exists');
        }

        // Check is flag out of char length limit
        if(strlen($this->trimFlagName()) > 50){

            return $this->throwException('maxlength');
        }

        // Create Flag
        return DB::table(self::$flagsTable)->insert(['title' => $this->trimFlagName($this->title)]) ? true : $this->throwException('dbsaveunknown');

    }


    ////


    /**
     * Upadates the flag title
     * @param integer,string $this->id
     * @param string $this->flag
     */
    public function updateFlag(){

        // Update if is exists
        if($this->searchFlag($this->id) || $this->searchFlag($this->flag)){

            return DB::table(self::$flagsTable)->where('id', $this->_tmpSearchFlag['data'])->update(['title'=>$this->trimFlagName($this->title)]) ? true : false;
        }

        // Not Found
        $this->throwException('flagnotfound', false);
        return false;
        
    }


    ////


    /**
     * Check is flag exists on the system but with every exception is possible.
     * !! Use isFlagExists() function if you already have a id of flag, cause this function is bit heavier than isFlagExists()
     * @param integer $searchFlag 
     * OR
     * @param string $searchFlag
     * @return boolean
     */
    private function searchFlag($searchFlag = null){

        // If flag is not defined, set flag to default
        if($searchFlag == null){

            $searchFlag = $this->title;
        }
        
        $flagQuery = DB::table(self::$flagsTable)->select('id')->where('title', $this->trimFlagName($searchFlag))->first();
        if($flagQuery){

            // Founded by Title & stored at temp
            $this->_tmpSearchFlag = [
                'type'  => 'id',
                'data'  =>  $flagQuery->id
            ];

            return true;
        }
        else if(DB::table(self::$flagsTable)->where('id', $searchFlag)->count() > 0){

            // Founded by Id & stored at temp
            $this->_tmpSearchFlag = [
                'type'  => 'id',
                'data'  =>  $searchFlag
            ];

            return true;
        }
        else{

            // Flag not found
            return false;
        }
    }


    ////


    /**
     * Trim flag name
     * @param string $flagName : default $flagname=$this->title
     * @return string
     */
    public function trimFlagName($flagName = null){

        // Set default if $flagName is null
        if($flagName == null){

            $flagName = $this->title;
        }
        // Remove spaces and make lowercase all chars str_replace(' ', '', $sentence);
        preg_match_all("/[0-9]/", $flagName) == strlen($flagName) ? $this->throwException('onlynumbers') : $flagName = (String)str_replace(' ', '', mb_strtolower($flagName));
        
        return $flagName;
    }


    ////


    /**
     * Exception creator
     * @param string $errCode
     * @param boolean $isFatal, if it's true. function will return false otherwise just adds the exception to error array
     * @return array
     */
    private function throwException($errCode, $isFatal = true){

        if($isFatal === true){
            trigger_error(self::$exceptions[$errCode], E_USER_ERROR);
        }

        array_search(self::$exceptions[$errCode], $this->errors) ?: array_push($this->errors, self::$exceptions[$errCode]);

        return;
    }

 }