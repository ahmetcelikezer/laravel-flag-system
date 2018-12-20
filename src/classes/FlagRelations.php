<?php

namespace ahmetcelikezer\laravelFlagSystem\classes;

use ahmetcelikezer\laravelFlagSystem\Models\Relations;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\json_encode;

class FlagRelations{

    protected $id;
    protected $flags;
    protected $table;
    protected $targetID;


    public function isRecordExists(){

        $result = Relations::where([['targetID', '=', $this->targetID], ['targetTable', '=', $this->table]])->select('id')->first();
        //die($result);
        return $result ? $result->id : false;
    }

    protected function add(){

        $this->greatFilter(true);
        $record = $this->isRecordExists();
        
        if($record !== false){
            // Table already exists for target id, update

            $relation = Relations::find($record);
            $relation->flags        = json_encode($this->flags);
            return $relation->save();
        }
        else{
            // Table doesn't exists for target id, create

            $relation = new Relations;
            $relation->flags        = json_encode($this->flags);
            $relation->targetTable  = $this->table;
            $relation->targetID     = $this->targetID;
            return $relation->save();
        }
    }

    public function ownedFlags(){

        $flags = DB::table('flag_relations')->select('flags')->where([['targetID', $this->targetID], ['targetTable', $this->table]])->first();

        return $flags ? json_decode($flags->flags, true) : false;
    }

    protected function greatFilter($uniqueOnDb = false){

        // Delete duplicates first
        $this->flags = array_unique($this->flags);
        
        // Check is unique on db
        if($uniqueOnDb === true){

            $ownedFlags = $this->ownedFlags();
            if($ownedFlags === false){return;}

            foreach($this->flags as $key=>$flag){

                if(in_array($flag, $ownedFlags)){

                    unset($this->flags[$key]);
                }
            }

            $this->flags = array_merge($this->flags, $ownedFlags);
        }
       
        return;
    }

}